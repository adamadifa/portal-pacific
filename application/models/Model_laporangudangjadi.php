<?php

class Model_laporangudangjadi extends CI_Model
{


	function listproduk()
	{
		return $this->db->get('master_barang');
	}


	function get_produk($produk = null)
	{
		$this->db->where('kode_produk', $produk);
		return $this->db->get('master_barang');
	}

	function getSaldoAwalMutasi($dari, $sampai, $produk)
	{
		$this->db->where('tgl_mutasi_gudang <', $dari);
		$this->db->where('detail_mutasi_gudang.kode_produk', $produk);
		$this->db->join('mutasi_gudang_jadi', 'detail_mutasi_gudang.no_mutasi_gudang=mutasi_gudang_jadi.no_mutasi_gudang');
		$this->db->select(
			"SUM(IF( `inout` = 'IN', jumlah, 0)) AS jml_in,
			SUM(IF( `inout` = 'OUT', jumlah, 0)) AS jml_out,
			SUM(IF( `inout` = 'IN', jumlah, 0)) -SUM(IF( `inout` = 'OUT', jumlah, 0)) as saldo_awal"
		);
		$this->db->from('detail_mutasi_gudang');
		return $this->db->get();
	}


	function getSaldoAwalMutasiCabang($cabang, $dari, $sampai, $produk)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$this->db->select('saldoawal_bj_detail.kode_produk,jumlah,isipcsdus,isipack,isipcs');
		$this->db->from('saldoawal_bj_detail');
		$this->db->join('saldoawal_bj', 'saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal');
		$this->db->join('master_barang', 'saldoawal_bj_detail.kode_produk = master_barang.kode_produk');
		$this->db->where('MONTH(tanggal)', $bulan);
		$this->db->where('YEAR(tanggal)', $tahun);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('status', 'GS');
		$this->db->where('saldoawal_bj_detail.kode_produk', $produk);
		return $this->db->get();
	}

	function getSaldoAwalMutasiBadCabang($cabang, $dari, $sampai, $produk)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$this->db->select('saldoawal_bj_detail.kode_produk,jumlah,isipcsdus,isipack,isipcs');
		$this->db->from('saldoawal_bj_detail');
		$this->db->join('saldoawal_bj', 'saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal');
		$this->db->join('master_barang', 'saldoawal_bj_detail.kode_produk = master_barang.kode_produk');
		$this->db->where('MONTH(tanggal)', $bulan);
		$this->db->where('YEAR(tanggal)', $tahun);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('status', 'BS');
		$this->db->where('saldoawal_bj_detail.kode_produk', $produk);
		return $this->db->get();
	}

	function getMtsa($cabang, $dari, $produk)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$mulai   = $tahun . "-" . $bulan . "-" . "01";
		$this->db->where('tgl_mutasi_gudang_cabang >=', $mulai);
		$this->db->where('tgl_mutasi_gudang_cabang <', $dari);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('jenis_mutasi !=', 'KIRIM PUSAT');
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->select(
			"SUM(IF( `inout_good` = 'IN', jumlah, 0)) AS jml_in,
			SUM(IF( `inout_good` = 'OUT', jumlah, 0)) AS jml_out,
			SUM(IF( `inout_good` = 'IN', jumlah, 0)) -SUM(IF( `inout_good` = 'OUT', jumlah, 0)) as jumlah,
			isipcsdus"
		);
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function getMtsaBad($cabang, $dari, $produk)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$mulai   = $tahun . "-" . $bulan . "-" . "01";
		$this->db->where('tgl_mutasi_gudang_cabang >=', $mulai);
		$this->db->where('tgl_mutasi_gudang_cabang <', $dari);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('kondisi', 'BAD');
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->select(
			"SUM(IF( `inout_bad` = 'IN', jumlah, 0)) AS jml_in,
			SUM(IF( `inout_bad` = 'OUT', jumlah, 0)) AS jml_out,
			SUM(IF( `inout_bad` = 'IN', jumlah, 0)) -SUM(IF( `inout_bad` = 'OUT', jumlah, 0)) as jumlah,
			isipcsdus"
		);
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function mutasi($dari, $sampai, $produk)
	{

		$this->db->order_by('tgl_mutasi_gudang,mutasi_gudang_jadi.time_stamp', 'ASC');
		$this->db->where('tgl_mutasi_gudang >=', $dari);
		$this->db->where('tgl_mutasi_gudang <=', $sampai);
		$this->db->where('detail_mutasi_gudang.kode_produk', $produk);
		$this->db->join('mutasi_gudang_jadi', 'detail_mutasi_gudang.no_mutasi_gudang=mutasi_gudang_jadi.no_mutasi_gudang');
		$this->db->join('permintaan_pengiriman', 'mutasi_gudang_jadi.no_permintaan_pengiriman = permintaan_pengiriman.no_permintaan_pengiriman', 'LEFT');
		$this->db->join('master_barang', 'detail_mutasi_gudang.kode_produk=master_barang.kode_produk');
		$this->db->select('detail_mutasi_gudang.no_mutasi_gudang,tgl_mutasi_gudang,jenis_mutasi,inout,mutasi_gudang_jadi.keterangan,detail_mutasi_gudang.kode_produk,jumlah,
		kode_cabang');
		$this->db->from('detail_mutasi_gudang');
		return $this->db->get();
	}


	function mutasi_cabang($cabang, $dari, $sampai, $produk)
	{
		$this->db->order_by('tgl_mutasi_gudang_cabang,order,no_dpb', 'ASC');
		$this->db->where('tgl_mutasi_gudang_cabang >=', $dari);
		$this->db->where('tgl_mutasi_gudang_cabang <=', $sampai);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('jenis_mutasi !=', 'KIRIM PUSAT');
		$this->db->where('inout_good !=', '');
		$this->db->or_where('jenis_mutasi', 'PENYESUAIAN BAD');
		$this->db->where('tgl_mutasi_gudang_cabang >=', $dari);
		$this->db->where('tgl_mutasi_gudang_cabang <=', $sampai);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('inout_good !=', '');
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb', 'LEFT');
		$this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan', 'LEFT');
		$this->db->select('detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,nama_karyawan,tujuan,no_suratjalan,tgl_kirim,detail_mutasi_gudang_cabang.jumlah,isipcsdus,inout_good,promo,jenis_mutasi,
		date_format(mutasi_gudang_cabang.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(mutasi_gudang_cabang.date_updated, "%d %M %Y %H:%i:%s") as date_updated
		');
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function mutasibadstok_cabang($cabang, $dari, $sampai, $produk)
	{
		$kondisi = "BAD";
		$this->db->order_by('tgl_mutasi_gudang_cabang,order', 'ASC');
		$this->db->where('tgl_mutasi_gudang_cabang >=', $dari);
		$this->db->where('tgl_mutasi_gudang_cabang <=', $sampai);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('kondisi', $kondisi);
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->select('detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang,no_dpb,tgl_mutasi_gudang_cabang,no_suratjalan,tgl_kirim,detail_mutasi_gudang_cabang.jumlah,isipcsdus,inout_bad,promo,jenis_mutasi,
		date_format(mutasi_gudang_cabang.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(mutasi_gudang_cabang.date_updated, "%d %M %Y %H:%i:%s") as date_updated
		');
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function rekapmutasi($dari, $sampai)
	{

		$query = "SELECT
					m.kode_produk,
					nama_barang,
					(
						SELECT
							IFNULL(SUM( IF ( `inout` = 'IN', jumlah, 0 ) ) -
							SUM( IF ( `inout` = 'OUT', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk AND tgl_mutasi_gudang < '$dari'
					) as saldoawal,
					jmlfsthp,
					jmlrepack,
					jmlreject,
					jmllainlain_in,
					jmllainlain_out,
					jmlsuratjalan
				FROM
					master_barang m
				LEFT JOIN (
					SELECT
							kode_produk,
							SUM(IF(jenis_mutasi = 'FSTHP' ,jumlah,0)) as jmlfsthp,
							SUM(IF(jenis_mutasi = 'REPACK',jumlah,0)) as jmlrepack,
							SUM(IF(jenis_mutasi = 'REJECT',jumlah,0)) as jmlreject,
							SUM(IF(jenis_mutasi = 'LAINLAIN' AND  `inout` ='IN',jumlah,0)) as jmllainlain_in,
							SUM(IF(jenis_mutasi = 'LAINLAIN' AND  `inout` ='OUT',jumlah,0)) as jmllainlain_out,
							SUM(IF(jenis_mutasi = 'SURAT JALAN',jumlah,0)) as jmlsuratjalan
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE
						tgl_mutasi_gudang BETWEEN '$dari' AND '$sampai' GROUP BY kode_produk) mutasi ON (m.kode_produk = mutasi.kode_produk) ";

		return $this->db->query($query);
	}

	function rekaphasilproduksi($bulan, $tahun)
	{

		$minggu1 = "'" . $tahun . "-" . $bulan . "-01'" . " AND '" . $tahun . "-" . $bulan . "-07'";
		$minggu2 = "'" . $tahun . "-" . $bulan . "-08'" . " AND '" . $tahun . "-" . $bulan . "-14'";
		$minggu3 = "'" . $tahun . "-" . $bulan . "-15'" . " AND '" . $tahun . "-" . $bulan . "-21'";
		$minggu4 = "'" . $tahun . "-" . $bulan . "-22'" . " AND '" . $tahun . "-" . $bulan . "-31'";
		$query = "SELECT
					m.kode_produk,
					nama_barang,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'FSTHP', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu1
					) as minggu1,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'FSTHP', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu2
					) as minggu2,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'FSTHP', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu3
					) as minggu3,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'FSTHP', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu4
					) as minggu4

				FROM master_barang m";
		return $this->db->query($query);
	}

	function rekappengeluaran($bulan, $tahun)
	{

		$minggu1 = "'" . $tahun . "-" . $bulan . "-01'" . " AND '" . $tahun . "-" . $bulan . "-07'";
		$minggu2 = "'" . $tahun . "-" . $bulan . "-08'" . " AND '" . $tahun . "-" . $bulan . "-14'";
		$minggu3 = "'" . $tahun . "-" . $bulan . "-15'" . " AND '" . $tahun . "-" . $bulan . "-21'";
		$minggu4 = "'" . $tahun . "-" . $bulan . "-22'" . " AND '" . $tahun . "-" . $bulan . "-31'";
		$query = "SELECT
					m.kode_produk,
					nama_barang,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu1
					) as minggu1,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu2
					) as minggu2,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu3
					) as minggu3,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu4
					) as minggu4

				FROM master_barang m";
		return $this->db->query($query);
	}

	function realisasipengeluaran($bulan, $tahun)
	{

		$minggu1 = "'" . $tahun . "-" . $bulan . "-01'" . " AND '" . $tahun . "-" . $bulan . "-07'";
		$minggu2 = "'" . $tahun . "-" . $bulan . "-08'" . " AND '" . $tahun . "-" . $bulan . "-14'";
		$minggu3 = "'" . $tahun . "-" . $bulan . "-15'" . " AND '" . $tahun . "-" . $bulan . "-21'";
		$minggu4 = "'" . $tahun . "-" . $bulan . "-22'" . " AND '" . $tahun . "-" . $bulan . "-31'";

		$query = "SELECT
					m.kode_produk,
					nama_barang,
					(
						SELECT
							IFNULL(SUM(jumlah),0)
						FROM
							detail_permintaan_pengiriman dp
						INNER JOIN permintaan_pengiriman pp
						ON dp.no_permintaan_pengiriman = pp.no_permintaan_pengiriman
						WHERE dp.kode_produk = m.kode_produk
						AND tgl_permintaan_pengiriman
						BETWEEN $minggu1
					) as pm1,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'FSTHP', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu1
					) as minggu1,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu1
					) as sj1,
					(
						SELECT
							IFNULL(SUM(jumlah),0)
						FROM
							detail_permintaan_pengiriman dp
						INNER JOIN permintaan_pengiriman pp
						ON dp.no_permintaan_pengiriman = pp.no_permintaan_pengiriman
						WHERE dp.kode_produk = m.kode_produk
						AND tgl_permintaan_pengiriman
						BETWEEN $minggu2
					) as pm2,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'FSTHP', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu2
					) as minggu2,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu2
					) as sj2,
					(
						SELECT
							IFNULL(SUM(jumlah),0)
						FROM
							detail_permintaan_pengiriman dp
						INNER JOIN permintaan_pengiriman pp
						ON dp.no_permintaan_pengiriman = pp.no_permintaan_pengiriman
						WHERE dp.kode_produk = m.kode_produk
						AND tgl_permintaan_pengiriman
						BETWEEN $minggu3
					) as pm3,

					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'FSTHP', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu3
					) as minggu3,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu3
					) as sj3,
					(
						SELECT
							IFNULL(SUM(jumlah),0)
						FROM
							detail_permintaan_pengiriman dp
						INNER JOIN permintaan_pengiriman pp
						ON dp.no_permintaan_pengiriman = pp.no_permintaan_pengiriman
						WHERE dp.kode_produk = m.kode_produk
						AND tgl_permintaan_pengiriman
						BETWEEN $minggu4
					) as pm4,

					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'FSTHP', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu4
					) as minggu4,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						WHERE d.kode_produk = m.kode_produk
						AND tgl_mutasi_gudang BETWEEN $minggu4
					) as sj4


				FROM master_barang m";

		return $this->db->query($query);
	}


	function realisasikiriman($cabang, $bulan, $tahun)
	{

		if ($cabang 	!= "") {
			$cabang = "AND kode_cabang = '" . $cabang . "' ";
		}
		$query = "SELECT
					m.kode_produk,
					nama_barang,
					(
						SELECT
							IFNULL(SUM(jumlah),0)
						FROM
							detail_permintaan_pengiriman dp
						INNER JOIN permintaan_pengiriman pp
						ON dp.no_permintaan_pengiriman = pp.no_permintaan_pengiriman
						WHERE dp.kode_produk = m.kode_produk
						AND MONTH(tgl_permintaan_pengiriman) = '$bulan'  AND YEAR(tgl_permintaan_pengiriman) = '$tahun'"
			. $cabang
			. "
					) as permintaan,
					(
						SELECT
							IFNULL(SUM(target_bulan),0)
						FROM
							target_pengiriman tp
						WHERE tp.kode_produk = m.kode_produk
						AND bulan = '$bulan'  AND tahun = '$tahun'"
			. $cabang
			. "
					) as target,
					(
						SELECT
							IFNULL(SUM( IF ( `jenis_mutasi` = 'SURAT JALAN', jumlah, 0 ) ),0)
						FROM
							detail_mutasi_gudang d
						INNER JOIN mutasi_gudang_jadi
						ON d.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
						INNER JOIN permintaan_pengiriman pp
						ON mutasi_gudang_jadi.no_permintaan_pengiriman = pp.no_permintaan_pengiriman

						WHERE d.kode_produk = m.kode_produk
						AND MONTH(tgl_mutasi_gudang) = '$bulan' AND YEAR(tgl_mutasi_gudang) = '$tahun'"
			. $cabang
			. "
					) as realisasi

				FROM master_barang m ";

		return $this->db->query($query);
	}


	function rekapbjcabang($cabang, $dari, $sampai)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$mulai   = $tahun . "-" . $bulan . "-" . "01";
		$query = "SELECT
			m.kode_produk,
			nama_barang,
			isipcsdus,
			isipack,
			isipcs,
			saldoawalgs,saldoawalbs,
			SUM(IF(jenis_mutasi = 'SURAT JALAN' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as pusat,
			SUM(IF(jenis_mutasi = 'TRANSIT IN' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as transit_in,
			SUM(IF(jenis_mutasi = 'RETUR' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as retur,
			SUM(IF(jenis_mutasi = 'HUTANG KIRIM' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_good='IN' OR jenis_mutasi = 'PL TTR' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_good='IN' OR jenis_mutasi = 'PENYESUAIAN BAD' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_good='IN',jumlah,0))
			as lainlain_in,
			SUM(IF(jenis_mutasi = 'PENYESUAIAN' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_good='IN',jumlah,0))
			as penyesuaian_in,
			SUM(IF(jenis_mutasi = 'PENYESUAIAN BAD' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_bad='IN',jumlah,0))
			as penyesuaianbad_in,
			SUM(IF(jenis_mutasi = 'REPACK' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as repack,
			SUM(IF(jenis_mutasi = 'PENJUALAN' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as penjualan,
			SUM(IF(jenis_mutasi = 'PROMOSI'  AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as promosi,
			SUM(IF(jenis_mutasi = 'REJECT PASAR' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as reject_pasar,
			SUM(IF(jenis_mutasi = 'REJECT GUDANG' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as reject_gudang,
			SUM(IF(jenis_mutasi = 'TRANSIT OUT' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as transit_out,
			SUM(IF(jenis_mutasi = 'PL HUTANG KIRIM' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_good='OUT' OR jenis_mutasi = 'TTR' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_good='OUT' OR jenis_mutasi = 'GANTI BARANG' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai' AND inout_good='OUT'
			,jumlah,0))
			as lainlain_out,
			SUM(IF(jenis_mutasi = 'PENYESUAIAN' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_good='OUT',jumlah,0))
			as penyesuaian_out,
			SUM(IF(jenis_mutasi = 'PENYESUAIAN BAD' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai'
			AND inout_bad='OUT',jumlah,0))
			as penyesuaianbad_out,
		  SUM(IF(jenis_mutasi = 'KIRIM PUSAT' AND mc.kode_cabang='$cabang'
			AND mc.tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai',jumlah,0))
			as kirimpusat,

			SUM(IF(mc.tgl_mutasi_gudang_cabang >= '$mulai' AND mc.tgl_mutasi_gudang_cabang < '$dari' AND mc.kode_cabang='$cabang'
				AND jenis_mutasi !='KIRIM PUSAT' AND inout_good='IN'
			,jumlah,0)) - SUM(IF(mc.tgl_mutasi_gudang_cabang >= '$mulai' AND mc.tgl_mutasi_gudang_cabang < '$dari' AND mc.kode_cabang='$cabang'
				AND jenis_mutasi !='KIRIM PUSAT' AND inout_good='OUT'
			,jumlah,0)) as sisamutasi,

			SUM(IF(mc.tgl_mutasi_gudang_cabang >= '$mulai' AND mc.tgl_mutasi_gudang_cabang < '$dari' AND mc.kode_cabang='$cabang'
				AND kondisi !='BAD' AND inout_bad='IN'
			,jumlah,0)) - SUM(IF(mc.tgl_mutasi_gudang_cabang >= '$mulai' AND mc.tgl_mutasi_gudang_cabang < '$dari' AND mc.kode_cabang='$cabang'
				AND kondisi !='BAD' AND inout_bad='OUT'
			,jumlah,0)) as sisamutasibad
		FROM master_barang m
		LEFT JOIN
		(SELECT kode_produk,jumlah as saldoawalgs FROM saldoawal_bj_detail
		 INNER JOIN saldoawal_bj ON saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal
		 WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal)='$tahun' AND kode_cabang='$cabang' AND status='GS'
	  ) sags ON (m.kode_produk = sags.kode_produk)
		LEFT JOIN
		(SELECT kode_produk,jumlah as saldoawalbs FROM saldoawal_bj_detail
		 INNER JOIN saldoawal_bj ON saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal
		 WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal)='$tahun' AND kode_cabang='$cabang' AND status='BS'
	 ) sabs ON (m.kode_produk = sabs.kode_produk)
		LEFT JOIN detail_mutasi_gudang_cabang d
		ON m.kode_produk = d.kode_produk
		LEFT JOIN mutasi_gudang_cabang mc
		ON d.no_mutasi_gudang_cabang = mc.no_mutasi_gudang_cabang
		GROUP BY m.kode_produk,nama_barang,
		isipcsdus,
		isipack,
		isipcs,saldoawalgs,saldoawalbs";
		return $this->db->query($query);
	}


	function mutasisuratjalan($cabang, $bulan, $tahun, $produk)
	{
		$this->db->order_by('tgl_mutasi_gudang_cabang', 'ASC');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('jenis_mutasi', 'SURAT JALAN');
		$this->db->or_where('jenis_mutasi', 'TRANSIT OUT');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->or_where('jenis_mutasi', 'TRANSIT IN');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb', 'LEFT');
		$this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan', 'LEFT');
		$this->db->select('detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,nama_karyawan,tujuan,no_suratjalan,tgl_kirim,detail_mutasi_gudang_cabang.jumlah,isipcsdus,inout_good,promo,jenis_mutasi,
		date_format(mutasi_gudang_cabang.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(mutasi_gudang_cabang.date_updated, "%d %M %Y %H:%i:%s") as date_updated
		');
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function mutasipenyesuaian($cabang, $bulan, $tahun, $produk)
	{
		$this->db->order_by('tgl_mutasi_gudang_cabang', 'ASC');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('jenis_mutasi', 'PENYESUAIAN');
		$this->db->where('inout_good', 'IN');
		$this->db->or_where('jenis_mutasi', 'PENYESUAIAN');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('inout_good', 'OUT');
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb', 'LEFT');
		$this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan', 'LEFT');
		$this->db->select('detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,nama_karyawan,tujuan,no_suratjalan,tgl_kirim,detail_mutasi_gudang_cabang.jumlah,isipcsdus,inout_good,promo,jenis_mutasi,
		date_format(mutasi_gudang_cabang.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(mutasi_gudang_cabang.date_updated, "%d %M %Y %H:%i:%s") as date_updated
		');
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}


	function mutasidpbpengambilan($cabang, $bulan, $tahun, $produk)
	{
		$this->db->order_by('tgl_pengambilan', 'asc');
		$this->db->select('detail_dpb.no_dpb,dpb.kode_cabang,dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan,tgl_pengambilan,jml_pengambilan,tgl_pengembalian,jml_pengembalian');
		$this->db->from('detail_dpb');
		$this->db->join('dpb', 'detail_dpb.no_dpb = dpb.no_dpb');
		$this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
		$this->db->where('dpb.kode_cabang', $cabang);
		$this->db->where('MONTH(tgl_pengambilan)', $bulan);
		$this->db->where('YEAR(tgl_pengambilan)', $tahun);
		$this->db->where('kode_produk', $produk);
		return $this->db->get();
	}

	function mutasidpbpengembalian($cabang, $bulan, $tahun, $produk)
	{
		$this->db->order_by('tgl_pengembalian', 'asc');
		$this->db->select('detail_dpb.no_dpb,dpb.kode_cabang,dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan,tgl_pengambilan,jml_pengambilan,tgl_pengembalian,jml_pengembalian');
		$this->db->from('detail_dpb');
		$this->db->join('dpb', 'detail_dpb.no_dpb = dpb.no_dpb');
		$this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
		$this->db->where('dpb.kode_cabang', $cabang);
		$this->db->where('MONTH(tgl_pengembalian)', $bulan);
		$this->db->where('YEAR(tgl_pengembalian)', $tahun);
		$this->db->where('kode_produk', $produk);
		return $this->db->get();
	}


	function mutasireject($cabang, $bulan, $tahun, $produk)
	{
		$this->db->order_by('tgl_mutasi_gudang_cabang', 'ASC');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('jenis_mutasi', 'REJECT PASAR');
		$this->db->or_where('jenis_mutasi', 'REJECT GUDANG');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb', 'LEFT');
		$this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan', 'LEFT');
		$this->db->select('detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,nama_karyawan,tujuan,no_suratjalan,tgl_kirim,detail_mutasi_gudang_cabang.jumlah,isipcsdus,inout_good,promo,jenis_mutasi,
    date_format(mutasi_gudang_cabang.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(mutasi_gudang_cabang.date_updated, "%d %M %Y %H:%i:%s") as date_updated
    ');
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function mutasirepack($cabang, $bulan, $tahun, $produk)
	{
		$this->db->order_by('tgl_mutasi_gudang_cabang', 'ASC');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('jenis_mutasi', 'REPACK');

		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb', 'LEFT');
		$this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan', 'LEFT');
		$this->db->select('detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,nama_karyawan,tujuan,no_suratjalan,tgl_kirim,detail_mutasi_gudang_cabang.jumlah,isipcsdus,inout_good,promo,jenis_mutasi,
    date_format(mutasi_gudang_cabang.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(mutasi_gudang_cabang.date_updated, "%d %M %Y %H:%i:%s") as date_updated
    ');
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function mutasiretur($cabang, $bulan, $tahun, $produk)
	{
		$this->db->order_by('tgl_mutasi_gudang_cabang', 'ASC');
		$this->db->where('MONTH(tgl_mutasi_gudang_cabang)', $bulan);
		$this->db->where('YEAR(tgl_mutasi_gudang_cabang)', $tahun);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
		$this->db->where('jenis_mutasi', 'RETUR');

		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb', 'LEFT');
		$this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan', 'LEFT');
		$this->db->select('detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,nama_karyawan,tujuan,no_suratjalan,tgl_kirim,detail_mutasi_gudang_cabang.jumlah,isipcsdus,inout_good,promo,jenis_mutasi,
    date_format(mutasi_gudang_cabang.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(mutasi_gudang_cabang.date_updated, "%d %M %Y %H:%i:%s") as date_updated
    ');
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}
}
