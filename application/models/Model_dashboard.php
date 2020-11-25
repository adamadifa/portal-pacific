<?php

class Model_dashboard extends CI_Model
{

	function grafikPenjualan()
	{
		$thisyear = date("Y");
		$lastyear = $thisyear - 1;
		$query = "SELECT MONTH(tgltransaksi) as bulan, SUM(IF(YEAR(tgltransaksi)='$lastyear',total,0)) as lastyear,SUM(IF(YEAR(tgltransaksi)='$thisyear',total,0)) as thisyear
			FROM penjualan
			GROUP BY bulan ";
		return $this->db->query($query);
	}


	function jumlahPelanggan()
	{
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {

			$this->db->where('kode_cabang', $cabang);
		}

		$this->db->select('COUNT(kode_pelanggan) as totalpelanggan');
		$this->db->from('pelanggan');
		$this->db->where('nama_pelanggan !=', 'BATAL');
		return $this->db->get();
	}


	function jumlahSales()
	{
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {

			$this->db->where('kode_cabang', $cabang);
		}

		$this->db->select('COUNT(id_karyawan) as totalsales');
		$this->db->from('karyawan');
		return $this->db->get();
	}


	function jumlahBarang()
	{
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {

			$this->db->where('kode_cabang', $cabang);
		}

		$this->db->select('COUNT(kode_barang) as totalbrg');
		$this->db->from('barang');
		return $this->db->get();
	}


	function penjualan($tahun)
	{
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {

			$cabang = "AND pelanggan.kode_cabang = '$cabang'";
		} else {

			$cabang = "";
		}
		$query = "SELECT

					(
					ifnull( SUM(penjualan.total), 0 ) - ( ifnull( SUM(r.totalpf), 0 ) - ifnull( SUM(r.totalgb), 0 ) )
					) AS totalpenjualan

				FROM
					penjualan
					JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
					JOIN cabang    ON pelanggan.kode_cabang = cabang.kode_cabang
					LEFT JOIN
					(SELECT retur.no_fak_penj AS no_fak_penj,sum(retur.subtotal_gb) AS totalgb,sum(retur.subtotal_pf) AS totalpf from retur WHERE YEAR(tglretur) ='$tahun' group by retur.no_fak_penj
					) r ON ( penjualan.no_fak_penj = r.no_fak_penj )
					LEFT JOIN view_historibayar ON penjualan.no_fak_penj = view_historibayar.no_fak_penj


				WHERE YEAR(tgltransaksi) ='$tahun'"

			. $cabang
			. "
				GROUP BY
				YEAR(tgltransaksi)

				";


		return $this->db->query($query);
	}



	function piutang()
	{
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {
			$this->db->where('kode_cabang', $cabang);
		}

		$this->db->select('SUM(sisabayar) as totalpiutang');
		$this->db->from('view_pembayaran');
		return $this->db->get();
	}


	function girojatuhtempo($hariini)
	{
		$this->db->select('id_giro,giro.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,kode_cabang,no_giro,materai,namabank,jumlah,tglcair,giro.status,ket');
		$this->db->from('giro');
		$this->db->join('penjualan', 'giro.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->where('tglcair', $hariini);
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {
			$this->db->where('kode_cabang', $cabang);
		}
		$this->db->order_by('nama_pelanggan', 'ASC');
		return $this->db->get();
	}


	function transferjatuhtempo($hariini)
	{

		$this->db->select('id_transfer,transfer.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,kode_cabang,norek,namapemilikrek,namabank,jumlah,tglcair,transfer.status,ket');
		$this->db->from('transfer');
		$this->db->join('penjualan', 'transfer.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->where('tglcair', $hariini);
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {
			$this->db->where('kode_cabang', $cabang);
		}
		return $this->db->get();
	}


	function rekapbjcabang($cabang)
	{
		$sampai = "Y-m-d";
		$query  = "SELECT
							m.kode_produk,
							nama_barang,
							isipcsdus,
							isipack,
							isipcs,
							SUM(IF(inout_good='IN' AND mc.kode_cabang='$cabang' AND d.kode_produk = m.kode_produk
						    AND mc.tgl_mutasi_gudang_cabang <= '$sampai',jumlah,0)) -
							SUM(IF(inout_good='OUT' AND mc.kode_cabang='$cabang' AND d.kode_produk = m.kode_produk
						    AND mc.tgl_mutasi_gudang_cabang <= '$sampai',jumlah,0)) as saldoakhir,
							SUM(IF(inout_bad='IN' AND mc.kode_cabang='$cabang' AND d.kode_produk = m.kode_produk
						    AND mc.tgl_mutasi_gudang_cabang <= '$sampai',jumlah,0)) -
							SUM(IF(inout_bad='OUT' AND mc.kode_cabang='$cabang' AND d.kode_produk = m.kode_produk
						    AND mc.tgl_mutasi_gudang_cabang <= '$sampai',jumlah,0))
						    as saldoakhir_bs

					FROM master_barang m
					LEFT JOIN detail_mutasi_gudang_cabang d
					ON m.kode_produk = d.kode_produk
					LEFT JOIN mutasi_gudang_cabang mc
					ON d.no_mutasi_gudang_cabang = mc.no_mutasi_gudang_cabang
					GROUP BY m.kode_produk";

		return $this->db->query($query);
	}


	function persediaangudang()
	{
		$sampai = date("Y-m-d");
		$query  = "SELECT
							m.kode_produk,
							nama_barang,
							isipcsdus,
							isipack,
							isipcs,
							SUM(IF(`inout`='IN'  AND d.kode_produk = m.kode_produk
						    AND mc.tgl_mutasi_gudang <= '$sampai',jumlah,0)) -
							SUM(IF(`inout`='OUT' AND d.kode_produk = m.kode_produk
						    AND mc.tgl_mutasi_gudang <= '$sampai',jumlah,0)) as saldoakhir
							FROM master_barang m
							LEFT JOIN detail_mutasi_gudang d
							ON m.kode_produk = d.kode_produk
							LEFT JOIN mutasi_gudang_jadi mc
							ON d.no_mutasi_gudang = mc.no_mutasi_gudang
							GROUP BY m.kode_produk";

		return $this->db->query($query);
	}

	function permintaanproduksi($bulan, $tahun)
	{

		$this->db->select('detail_permintaan_produksi.kode_produk,nama_barang,oman_mkt,stok_gudang,buffer_stok');
		$this->db->from('detail_permintaan_produksi');
		$this->db->join('master_barang', 'detail_permintaan_produksi.kode_produk = master_barang.kode_produk');
		$this->db->join('permintaan_produksi', 'detail_permintaan_produksi.no_permintaan = permintaan_produksi.no_permintaan');
		$this->db->join('oman', 'permintaan_produksi.no_order = oman.no_order');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		return $this->db->get();
	}


	function get_permintaanproduksi($bulan, $tahun)
	{

		$status = 1;
		$this->db->select('permintaan_produksi.no_permintaan,tgl_permintaan,permintaan_produksi.no_order,bulan,tahun');
		$this->db->from('permintaan_produksi');
		$this->db->join('oman', 'permintaan_produksi.no_order = oman.no_order');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('permintaan_produksi.status', $status);
		return $this->db->get();
	}

	function rekappersediaan()
	{
		$query = "SELECT * FROM cabang ";

		return $this->db->query($query);
	}

	function getRekapProduksi($tahun)
	{
		$query = "SELECT kode_produk,
		SUM(IF(MONTH(tgl_mutasi_produksi)=1 AND jenis_mutasi='BPBJ',jumlah,0)) as januari,
		SUM(IF(MONTH(tgl_mutasi_produksi)=2 AND jenis_mutasi='BPBJ',jumlah,0)) as februari,
		SUM(IF(MONTH(tgl_mutasi_produksi)=3 AND jenis_mutasi='BPBJ',jumlah,0)) as maret,
		SUM(IF(MONTH(tgl_mutasi_produksi)=4 AND jenis_mutasi='BPBJ',jumlah,0)) as april,
		SUM(IF(MONTH(tgl_mutasi_produksi)=5 AND jenis_mutasi='BPBJ',jumlah,0)) as mei,
		SUM(IF(MONTH(tgl_mutasi_produksi)=6 AND jenis_mutasi='BPBJ',jumlah,0)) as juni,
		SUM(IF(MONTH(tgl_mutasi_produksi)=7 AND jenis_mutasi='BPBJ',jumlah,0)) as juli,
		SUM(IF(MONTH(tgl_mutasi_produksi)=8 AND jenis_mutasi='BPBJ',jumlah,0)) as agustus,
		SUM(IF(MONTH(tgl_mutasi_produksi)=9 AND jenis_mutasi='BPBJ',jumlah,0)) as september,
		SUM(IF(MONTH(tgl_mutasi_produksi)=10 AND jenis_mutasi='BPBJ',jumlah,0)) as oktober,
		SUM(IF(MONTH(tgl_mutasi_produksi)=11 AND jenis_mutasi='BPBJ',jumlah,0)) as november,
		SUM(IF(MONTH(tgl_mutasi_produksi)=12 AND jenis_mutasi='BPBJ',jumlah,0)) as desember
		FROM detail_mutasi_produksi
		INNER JOIN mutasi_produksi ON detail_mutasi_produksi.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi
		WHERE YEAR(tgl_mutasi_produksi)='$tahun'
		GROUP BY kode_produk ORDER BY kode_produk ASC
		";

		return $this->db->query($query);
	}
}
