<?php

class Model_laporanpenjualan extends CI_Model
{

	function get_salesman($cabang)
	{
		$this->db->where('kode_cabang', $cabang);
		//$this->db->where('nama_karyawan !=','-');
		return $this->db->get('karyawan');
	}
	function get_kendaraan($cabang)
	{
		$this->db->where('kode_cabang', $cabang);
		//$this->db->where('nama_karyawan !=','-');
		return $this->db->get('kendaraan');
	}

	function get_pelanggan($salesman)
	{
		$this->db->where('id_sales', $salesman);
		$this->db->select('DISTINCT(pelanggan.kode_pelanggan),nama_pelanggan');
		$this->db->from('pelanggan');
		return $this->db->get();
	}

	function get_pelanggancabang($cabang)
	{
		$this->db->where('kode_cabang', $cabang);
		$this->db->select('DISTINCT(pelanggan.kode_pelanggan),nama_pelanggan');
		$this->db->from('pelanggan');
		return $this->db->get();
	}

	function listdiskon($cabang, $dari, $sampai)
	{
		if ($cabang 	!= "") {
			$cabang = "AND barang.kode_cabang = '" . $cabang . "' ";
		}
		$query =  ("SELECT
	detailpenjualan.no_fak_penj AS no_fak_penj,
	penjualan.tgltransaksi AS tgltransaksi,
	penjualan.kode_pelanggan AS kode_pelanggan,
	pelanggan.nama_pelanggan AS nama_pelanggan,
	penjualan.id_karyawan AS id_karyawan,
	karyawan.nama_karyawan AS nama_karyawan,
	barang.kategori AS kategori,
	barang.kode_cabang AS kode_cabang,
	sum(
		round(( detailpenjualan.jumlah / barang.isipcsdus ), 0 )) AS jmldus,(
	SELECT
		sum( diskon.diskon ) 
	FROM
		diskon 
	WHERE
		((
				diskon.kategori = barang.kategori 
				) 
			AND ( sum( round(( detailpenjualan.jumlah / barang.isipcsdus ), 0 )) >= diskon.dari ) 
		AND ( sum( round(( detailpenjualan.jumlah / barang.isipcsdus ), 0 )) <= diskon.sampai )) 
	GROUP BY
		diskon.kategori 
		) AS diskonkategori,(
		sum(
			round(( detailpenjualan.jumlah / barang.isipcsdus ), 0 )) * (
		SELECT
			sum( diskon.diskon ) 
		FROM
			diskon 
		WHERE
			((
					diskon.kategori = barang.kategori 
					) 
				AND ( sum( round(( detailpenjualan.jumlah / barang.isipcsdus ), 0 )) >= diskon.dari ) 
			AND ( sum( round(( detailpenjualan.jumlah / barang.isipcsdus ), 0 )) <= diskon.sampai )) 
		GROUP BY
			diskon.kategori 
		)) AS totalpotongan 
FROM
	((((
					detailpenjualan
					JOIN penjualan ON ((
							detailpenjualan.no_fak_penj = penjualan.no_fak_penj 
						)))
				JOIN barang ON ((
						detailpenjualan.kode_barang = barang.kode_barang 
					)))
			JOIN pelanggan ON ((
					penjualan.kode_pelanggan = pelanggan.kode_pelanggan 
				)))
		JOIN karyawan ON ((
				penjualan.id_karyawan = karyawan.id_karyawan 
			))) 
			WHERE penjualan.tgltransaksi BETWEEN '$dari' AND '$sampai' "
			. $cabang
			. "
GROUP BY
	detailpenjualan.no_fak_penj,
	barang.kategori,
	penjualan.id_karyawan,
	penjualan.tgltransaksi,
	barang.kode_cabang
	
	");
		return $this->db->query($query);
	}


	function list_penjualanpending($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null, $jt = null, $status)
	{
		if ($cabang 	!= "") {
			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {

			$salesman = "AND penjualan_pending.id_karyawan = '" . $salesman . "' ";
		}

		if ($status == "1") {
			$status = "AND (SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) = '1'";
		} else if ($status == "2") {
			$status = "AND (SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) != '1'";
		}

		if ($pelanggan != "") {

			$pelanggan = "AND penjualan_pending.kode_pelanggan = '" . $pelanggan . "' ";
		}

		if ($jt != "") {

			$jt = "AND penjualan_pending.jenistransaksi = '" . $jt . "'";
		}
		$query = "SELECT
					penjualan_pending.no_fak_penj AS no_fak_penj,
					penjualan_pending.tgltransaksi AS tgltransaksi,
					penjualan_pending.kode_pelanggan AS kode_pelanggan,
					pelanggan.nama_pelanggan AS nama_pelanggan,
					pelanggan.alamat_pelanggan AS alamat_pelanggan,
					pelanggan.no_hp AS no_hp,
					pelanggan.pasar AS pasar,
					pelanggan.hari AS hari,
					pelanggan.kode_cabang AS kode_cabang,
					penjualan_pending.subtotal AS subtotal,
					penjualan_pending.potongan AS potongan,
					penjualan_pending.potistimewa AS potistimewa,
					penjualan_pending.penyharga AS penyharga,
					ifnull( penjualan_pending.total, 0 ) AS total,
					ifnull( r.totalgb, 0 ) AS totalgb,
					ifnull( r.totalpf, 0 ) AS totalpf,
					( ifnull( r.totalpf, 0 ) - ifnull( r.totalgb, 0 ) ) AS totalretur,
					(
					ifnull( penjualan_pending.total, 0 ) - ( ifnull( r.totalpf, 0 ) - ifnull( r.totalgb, 0 ) )
					) AS totalpiutang,
					ifnull( view_historibayar.totalbayar, 0 ) AS totalbayar,
					(
					(
					ifnull( penjualan_pending.total, 0 ) - ( ifnull( r.totalpf, 0 ) - ifnull( r.totalgb, 0 ) )
					) - ifnull( view_historibayar.totalbayar, 0 )
					) AS sisabayar,
					penjualan_pending.jenistransaksi AS jenistransaksi,
					penjualan_pending.jenisbayar AS jenisbayar,
					penjualan_pending.id_karyawan AS id_karyawan,
					karyawan.nama_karyawan AS nama_karyawan,
					penjualan_pending.jatuhtempo AS jatuhtempo
				FROM
					(
					(
					(
					( penjualan_pending JOIN pelanggan ON ( ( penjualan_pending.kode_pelanggan = pelanggan.kode_pelanggan ) ) )
					JOIN karyawan ON ( ( penjualan_pending.id_karyawan = karyawan.id_karyawan ) )
					)
					LEFT JOIN
					(
						select retur.no_fak_penj AS no_fak_penj,sum(retur.subtotal_gb) AS totalgb,sum(retur.subtotal_pf) AS totalpf from retur WHERE tglretur BETWEEN '$dari' AND '$sampai' group by retur.no_fak_penj
					) r ON ( penjualan_pending.no_fak_penj = r.no_fak_penj )
					)
					LEFT JOIN view_historibayar ON ( ( penjualan_pending.no_fak_penj = view_historibayar.no_fak_penj ) )
					)

				WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $cabang
			. $salesman
			. $pelanggan
			. $status
			. $jt
			. "
				GROUP BY
					penjualan_pending.no_fak_penj,
					penjualan_pending.kode_pelanggan,
					pelanggan.nama_pelanggan,
					pelanggan.alamat_pelanggan,
					pelanggan.no_hp,
					pelanggan.pasar,
					pelanggan.hari,
					pelanggan.kode_cabang,
					penjualan_pending.subtotal,
					penjualan_pending.potongan,
					penjualan_pending.potistimewa,
					penjualan_pending.penyharga,
					penjualan_pending.jenistransaksi,
					penjualan_pending.jenisbayar,
					penjualan_pending.id_karyawan,
					karyawan.nama_karyawan,
					penjualan_pending.jatuhtempo
					ORDER BY tgltransaksi,no_fak_penj ASC";

		return $this->db->query($query);
	}

	function list_penjualan($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null, $jt = null)
	{
		if ($cabang  != "") {
			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {
			$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
		}

		if ($pelanggan != "") {
			$pelanggan = "AND penjualan.kode_pelanggan = '" . $pelanggan . "' ";
		}

		if ($jt != "") {
			$jt = "AND penjualan.jenistransaksi = '" . $jt . "'";
		}
		$query = "SELECT
    penjualan.no_fak_penj AS no_fak_penj,
    penjualan.tgltransaksi AS tgltransaksi,
    penjualan.kode_pelanggan AS kode_pelanggan,
    pelanggan.nama_pelanggan AS nama_pelanggan,
    pelanggan.alamat_pelanggan AS alamat_pelanggan,
    pelanggan.no_hp AS no_hp,
    pelanggan.pasar AS pasar,
    pelanggan.hari AS hari,
    pelanggan.kode_cabang AS kode_cabang,
    penjualan.subtotal AS subtotal,
    penjualan.potongan AS potongan,
    penjualan.potistimewa AS potistimewa,
    penjualan.penyharga AS penyharga,
    date_format(penjualan.date_created, '%d %M %Y %H:%i:%s') as date_created,
    date_format(penjualan.date_updated, '%d %M %Y %H:%i:%s') as date_updated,
    ifnull( penjualan.total, 0 ) AS total,
    ifnull( r.totalgb, 0 ) AS totalgb,
    ifnull( r.totalpf, 0 ) AS totalpf,
    (ifnull( r.totalpf, 0 ) - ifnull( r.totalgb, 0 ) ) AS totalretur,
    (ifnull( penjualan.total, 0 ) - ( ifnull( r.totalpf, 0 ) - ifnull( r.totalgb, 0))) AS totalpiutang,
    penjualan.jenistransaksi AS jenistransaksi,
    penjualan.jenisbayar AS jenisbayar,
    penjualan.id_karyawan AS id_karyawan,
    karyawan.nama_karyawan AS nama_karyawan,
    penjualan.jatuhtempo AS jatuhtempo 
  FROM
    penjualan 
        JOIN
          pelanggan 
          ON (penjualan.kode_pelanggan = pelanggan.kode_pelanggan) 
        JOIN
          karyawan 
          ON (penjualan.id_karyawan = karyawan.id_karyawan) 
        LEFT JOIN
          (
              select
                retur.no_fak_penj AS no_fak_penj,
                sum(retur.subtotal_gb) AS totalgb,
                sum(retur.subtotal_pf) AS totalpf 
              from
                retur 
              WHERE
                tglretur BETWEEN '$dari' AND '$sampai' 
              group by
                retur.no_fak_penj 
          ) r ON ( penjualan.no_fak_penj = r.no_fak_penj ) 

        WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $cabang
			. $salesman
			. $pelanggan
			. $jt
			. "
        GROUP BY
          penjualan.no_fak_penj,
          penjualan.kode_pelanggan,
          pelanggan.nama_pelanggan,
          pelanggan.alamat_pelanggan,
          pelanggan.no_hp,
          pelanggan.pasar,
          pelanggan.hari,
          pelanggan.kode_cabang,
          penjualan.subtotal,
          penjualan.potongan,
          penjualan.potistimewa,
          penjualan.penyharga,
          penjualan.jenistransaksi,
          penjualan.jenisbayar,
          penjualan.id_karyawan,
          karyawan.nama_karyawan,
          penjualan.jatuhtempo
          ORDER BY tgltransaksi,no_fak_penj ASC";

		return $this->db->query($query);
	}

	function rekappenjualancabangpending($dari, $sampai, $jt, $status)
	{
		if ($jt != "") {
			$jt = "AND penjualan_pending.jenistransaksi = '" . $jt . "'";
		}
		if ($status == "1") {
			$status = "AND (SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) = '1'";
		} else if ($status == "2") {
			$status = "AND (SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) != '1'";
		}
		$query = "SELECT

					pelanggan.kode_cabang AS kode_cabang,nama_cabang,

					(
					ifnull( SUM(penjualan_pending.subtotal), 0 )
					) AS totalbruto, totalretur,ifnull( SUM(penjualan_pending.penyharga), 0 )  as totalpenyharga,
					ifnull( SUM(penjualan_pending.potongan), 0 )  as totalpotongan,
					ifnull( SUM(penjualan_pending.potistimewa), 0 )  as totalpotistimewa

				FROM
					penjualan_pending
					JOIN pelanggan ON penjualan_pending.kode_pelanggan = pelanggan.kode_pelanggan
					JOIN cabang    ON pelanggan.kode_cabang = cabang.kode_cabang
					LEFT JOIN (
					SELECT pelanggan.kode_cabang, SUM(retur.total )AS totalretur FROM retur
					INNER JOIN penjualan_pending ON retur.no_fak_penj = penjualan_pending.no_fak_penj
					INNER JOIN pelanggan ON penjualan_pending.kode_pelanggan = pelanggan.kode_pelanggan
					WHERE tglretur BETWEEN '$dari' AND '$sampai' GROUP BY pelanggan.kode_cabang) r ON ( pelanggan.kode_cabang = r.kode_cabang )

				WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $jt
			. $status
			. "
				GROUP BY
				pelanggan.kode_cabang,
				nama_cabang

				";

		return $this->db->query($query);
	}


	function rekappenjualancabang($dari, $sampai, $jt)
	{
		if ($jt != "") {
			$jt = "AND penjualan.jenistransaksi = '" . $jt . "'";
		}
		$query = "SELECT

          pelanggan.kode_cabang AS kode_cabang,nama_cabang,

          (
          ifnull( SUM(penjualan.subtotal), 0 )
          ) AS totalbruto, totalretur,ifnull( SUM(penjualan.penyharga), 0 )  as totalpenyharga,
          ifnull( SUM(penjualan.potongan), 0 )  as totalpotongan,
          ifnull( SUM(penjualan.potistimewa), 0 )  as totalpotistimewa

        FROM
          penjualan
          JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
          JOIN cabang    ON pelanggan.kode_cabang = cabang.kode_cabang
          LEFT JOIN (
          SELECT pelanggan.kode_cabang, SUM(retur.total )AS totalretur FROM retur
          INNER JOIN penjualan ON retur.no_fak_penj = penjualan.no_fak_penj
          INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
          WHERE tglretur BETWEEN '$dari' AND '$sampai' GROUP BY pelanggan.kode_cabang) r ON ( pelanggan.kode_cabang = r.kode_cabang )

        WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $jt
			. "
        GROUP BY
        pelanggan.kode_cabang,
        nama_cabang

        ";

		return $this->db->query($query);
	}


	function loadrekappenjualan($bulan, $tahun)
	{

		$query = "SELECT

          pelanggan.kode_cabang AS kode_cabang,nama_cabang,

          (
          ifnull( SUM(penjualan.subtotal), 0 )
          ) AS totalbruto, totalretur,ifnull( SUM(penjualan.penyharga), 0 )  as totalpenyharga,
          ifnull( SUM(penjualan.potongan), 0 )  as totalpotongan,
          ifnull( SUM(penjualan.potistimewa), 0 )  as totalpotistimewa

        FROM
          penjualan
          JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
          JOIN cabang    ON pelanggan.kode_cabang = cabang.kode_cabang
          LEFT JOIN (
          SELECT pelanggan.kode_cabang, SUM(retur.total )AS totalretur FROM retur
          INNER JOIN penjualan ON retur.no_fak_penj = penjualan.no_fak_penj
          INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
          WHERE MONTH(tglretur) ='$bulan' AND YEAR(tglretur)='$tahun' GROUP BY pelanggan.kode_cabang) r ON ( pelanggan.kode_cabang = r.kode_cabang )

        WHERE  MONTH(tgltransaksi) ='$bulan' AND YEAR(tgltransaksi)='$tahun'"

			. "
        GROUP BY
        pelanggan.kode_cabang,
        nama_cabang

        ";

		return $this->db->query($query);
	}


	function rekapkasbesarcabang($dari, $sampai, $jenisbayar)
	{
		if ($jenisbayar != "") {

			$jenisbayar = "AND historibayar.jenisbayar = '" . $jenisbayar . "'";
		}
		$query = "SELECT karyawan.kode_cabang,nama_cabang,SUM(bayar) as totalkasbesar FROM historibayar
				INNER JOIN penjualan ON historibayar.no_fak_penj = penjualan.no_fak_penj
				INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
				INNER JOIN karyawan  ON penjualan.id_karyawan = karyawan.id_karyawan
				INNER JOIN cabang ON karyawan.kode_cabang = cabang.kode_cabang
				WHERE tglbayar BETWEEN '$dari' AND '$sampai'"
			. $jenisbayar
			. "
				GROUP BY
				karyawan.kode_cabang,
				nama_cabang

				";

		return $this->db->query($query);
	}


	function loadrekapkasbesar($bulan, $tahun)
	{
		// if($jenisbayar != ""){

		// 	$jenisbayar = "AND historibayar.jenisbayar = '".$jenisbayar."'";
		// }
		$query = "SELECT karyawan.kode_cabang,nama_cabang,SUM(bayar) as totalkasbesar FROM historibayar
				INNER JOIN penjualan ON historibayar.no_fak_penj = penjualan.no_fak_penj
				INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
				INNER JOIN karyawan  ON penjualan.id_karyawan = karyawan.id_karyawan
				INNER JOIN cabang ON karyawan.kode_cabang = cabang.kode_cabang
				WHERE MONTH(tglbayar) ='$bulan' AND YEAR(tglbayar)='$tahun'"

			. "
				GROUP BY
				karyawan.kode_cabang,
				nama_cabang

				";

		return $this->db->query($query);
	}


	function list_retur($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null)
	{


		$this->db->select('no_retur_penj,retur.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,pasar,hari,karyawan.kode_cabang,tglretur,subtotal_gb,
		  subtotal_pf,retur.total,jenistransaksi,retur.date_created,retur.date_updated');
		$this->db->from('retur');
		$this->db->join('penjualan', 'retur.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan', 'penjualan.id_karyawan = karyawan.id_karyawan');
		//$this->db->order_by('no_retur_penj','desc');
		$this->db->order_by('tglretur', 'ASC');
		$this->db->where('tglretur >=', $dari);
		$this->db->where('tglretur <=', $sampai);

		if ($cabang != "") {

			$this->db->where('karyawan.kode_cabang', $cabang);
		}

		if ($salesman != "") {

			$this->db->where('penjualan.id_karyawan', $salesman);
		}

		if ($pelanggan != "") {

			$this->db->where('penjualan.kode_pelanggan', $pelanggan);
		}
		return $this->db->get();
	}

	function list_retur_khusus($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null)
	{


		$this->db->select('no_retur_penj,retur.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,pasar,hari,karyawan.kode_cabang,tglretur,subtotal_gb,
      subtotal_pf,retur.total,jenistransaksi,retur.date_created,retur.date_updated');
		$this->db->from('retur');
		$this->db->join('penjualan', 'retur.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan', 'penjualan.id_karyawan = karyawan.id_karyawan');
		//$this->db->order_by('no_retur_penj','desc');
		$this->db->order_by('tglretur', 'ASC');
		$this->db->where('tglretur >=', $dari);
		$this->db->where('tglretur <=', $sampai);

		if ($cabang != "") {

			$this->db->where('karyawan.kode_cabang', $cabang);
		}

		if ($salesman != "") {

			$this->db->where('penjualan.id_karyawan', $salesman);
		}

		if ($pelanggan != "") {

			$this->db->where('penjualan.kode_pelanggan', $pelanggan);
		}
		return $this->db->get();
	}


	function kasbesar($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null, $jenisbayar = null)
	{

		$this->db->select('historibayar.no_fak_penj,nama_karyawan,tgltransaksi,tglbayar,bayar,bayar as bayarterakhir,girotocash,status_bayar,date_format(historibayar.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(historibayar.date_updated, "%d %M %Y %H:%i:%s") as date_updated,
			(
				SELECT IFNULL(penjualan.total, 0) - (ifnull(r.totalpf, 0) - ifnull(r.totalgb, 0)) AS totalpiutang
				FROM penjualan
				LEFT JOIN (
					SELECT retur.no_fak_penj AS no_fak_penj,
					sum(retur.subtotal_gb) AS totalgb,
					sum(retur.subtotal_pf) AS totalpf
					FROM
						retur
					GROUP BY
						retur.no_fak_penj
				) r ON (penjualan.no_fak_penj = r.no_fak_penj)
				WHERE penjualan.no_fak_penj = historibayar.no_fak_penj
			) as totalpenjualan,
			(SELECT IFNULL(SUM(bayar),0) FROM historibayar h WHERE h.no_fak_penj = historibayar.no_fak_penj AND h.tglbayar <= historibayar.tglbayar AND h.tglbayar >= penjualan.tgltransaksi) as totalbayar,
			 historibayar.jenisbayar,no_giro,materai,giro.namabank as bankgiro,giro.jumlah as jumlahgiro,transfer.namabank as banktransfer,transfer.jumlah as jumlahtransfer,historibayar.id_karyawan,penjualan.kode_pelanggan,nama_pelanggan');
		$this->db->from('historibayar');
		$this->db->join('giro', 'historibayar.id_giro = giro.id_giro', 'left');
		$this->db->join('transfer', 'historibayar.id_transfer = transfer.id_transfer', 'left');
		$this->db->join('penjualan', 'historibayar.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('v_movefaktur', 'historibayar.no_fak_penj = v_movefaktur.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan', 'penjualan.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tglbayar,historibayar.no_fak_penj', 'ASC');
		$this->db->where('tglbayar >=', $dari);
		$this->db->where('tglbayar <=', $sampai);

		if ($cabang != "") {

			$this->db->where('cabangbarunew', $cabang);
		}

		if ($salesman != "") {

			$this->db->where('historibayar.id_karyawan', $salesman);
		}

		if ($pelanggan != "") {
			$this->db->where('penjualan.kode_pelanggan', $pelanggan);
		}

		if ($jenisbayar != "") {

			$this->db->where('historibayar.jenisbayar', $jenisbayar);
		}
		return $this->db->get();
	}

	function voucher($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null, $statusbayar = null)
	{
		$this->db->select('tglbayar,historibayar.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,status_bayar,bayar');
		$this->db->from('historibayar');
		$this->db->join('penjualan', 'historibayar.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan', 'historibayar.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tglbayar,historibayar.no_fak_penj', 'ASC');
		$this->db->where('tglbayar >=', $dari);
		$this->db->where('tglbayar <=', $sampai);
		if ($cabang != "") {

			$this->db->where('karyawan.kode_cabang', $cabang);
		}

		if ($salesman != "") {

			$this->db->where('historibayar.id_karyawan', $salesman);
		}

		if ($pelanggan != "") {

			$this->db->where('penjualan.kode_pelanggan', $pelanggan);
		}
		if ($statusbayar != "") {

			$this->db->where('historibayar.status_bayar', $statusbayar);
		}
		return $this->db->get();
	}


	function cekkasbesar($tanggallhp = null, $cabang = null, $salesman = null)
	{

		$this->db->select('historibayar.no_fak_penj,tglbayar,bayar,girotocash,status_bayar,
			(SELECT totalpiutang from view_pembayaran WHERE view_pembayaran.no_fak_penj = historibayar.no_fak_penj) as totalpenjualan,
			(SELECT IFNULL(SUM(bayar),0) FROM historibayar h WHERE h.no_fak_penj = historibayar.no_fak_penj AND h.tglbayar <= historibayar.tglbayar) as totalbayar,
			(SELECT bayar FROM historibayar g WHERE g.no_fak_penj = historibayar.no_fak_penj AND g.tglbayar <= historibayar.tglbayar ORDER BY nobukti DESC LIMIT 1 ) as bayarterakhir,
			 historibayar.jenisbayar,no_giro,materai,giro.namabank as bankgiro,giro.jumlah as jumlahgiro,transfer.namabank as banktransfer,transfer.jumlah as jumlahtransfer,historibayar.id_karyawan,penjualan.kode_pelanggan,nama_pelanggan');
		$this->db->from('historibayar');
		$this->db->join('giro', 'historibayar.id_giro = giro.id_giro', 'left');
		$this->db->join('transfer', 'historibayar.id_transfer = transfer.id_transfer', 'left');
		$this->db->join('penjualan', 'historibayar.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->order_by('tglbayar,historibayar.no_fak_penj', 'ASC');
		$this->db->where('tglbayar', $tanggallhp);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('historibayar.id_karyawan', $salesman);
		$this->db->where('historibayar.id_giro IS NULL');
		$this->db->where('historibayar.girotocash IS NULL');
		$this->db->where('historibayar.id_transfer IS NULL');
		$this->db->or_where('tglbayar', $tanggallhp);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('historibayar.id_karyawan', $salesman);
		$this->db->where('historibayar.id_giro IS NULL');
		$this->db->where('historibayar.girotocash', '1');
		$this->db->where('historibayar.id_transfer IS NULL');
		$this->db->or_where('tglbayar', $tanggallhp);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('historibayar.id_karyawan', $salesman);
		$this->db->where('historibayar.id_giro IS NOT NULL');
		$this->db->where('historibayar.girotocash', '1');
		$this->db->where('historibayar.id_transfer IS NULL');

		return $this->db->get();
	}




	function kartupiutang($cabang = null, $salesman = null, $pelanggan = null, $dari, $sampai)
	{



		$b 				= explode("-", $dari);
		$bulan		= $b[1];

		if ($cabang 	!= "") {
			$cabang = "AND cabangbarunew = '" . $cabang . "' ";
		}
		if ($salesman != "") {
			$salesman = "AND salesbarunew = '" . $salesman . "' ";
		}

		if ($pelanggan != "") {
			$pelanggan = "AND penjualan.kode_pelanggan = '" . $pelanggan . "' ";
		}
		$query = "SELECT
			penjualan.no_fak_penj AS no_fak_penj,
			penjualan.tgltransaksi AS tgltransaksi,
			datediff('$sampai', penjualan.tgltransaksi) as usiapiutang,
			penjualan.kode_pelanggan AS kode_pelanggan,
			pelanggan.nama_pelanggan AS nama_pelanggan,
			pelanggan.alamat_pelanggan AS alamat_pelanggan,
			pelanggan.no_hp AS no_hp,
			pelanggan.pasar AS pasar,
			pelanggan.hari AS hari,
			penjualan.jatuhtempo AS jatuhtempo,
			pelanggan.kode_cabang AS kode_cabang,
			penjualan.total AS total,
			penjualan.jenistransaksi AS jenistransaksi,
			penjualan.jenisbayar AS jenisbayar,
			penjualan.id_karyawan AS id_karyawan,
			salesbarunew,
			karyawan.nama_karyawan AS nama_karyawan,
			IFNULL(penjbulanini.subtotal,0) AS subtotal,
			IFNULL(penjbulanini.penyharga,0) AS penyharga,
			IFNULL(penjbulanini.potongan,0) AS potongan,
			IFNULL(penjbulanini.potistimewa,0) AS potistimewa,
			(IFNULL(totalpf,0)-IFNULL(totalgb,0)) AS totalretur,
			IFNULL(penjbulanini.total,0) -(IFNULL(totalpf,0)-IFNULL(totalgb,0))  AS piutangbulanini,
			(ifnull(penjualan.total,0) - (ifnull(totalpf_last,0)-ifnull(totalgb_last,0))) AS totalpiutang,
		ifnull(bayarsebelumbulanini,0) AS bayarsebelumbulanini,
		ifnull(bayarbulanini,0) AS bayarbulanini
	FROM
			penjualan 
			
			JOIN
				pelanggan 
				ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan 
				
		LEFT JOIN (
				SELECT no_fak_penj,subtotal,penyharga,potongan,potistimewa,total
				FROM penjualan
				WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'
		) penjbulanini ON (penjualan.no_fak_penj = penjbulanini.no_fak_penj)
		
		LEFT JOIN (
          SELECT pj.no_fak_penj,
          IF(salesbaru IS NULL,pj.id_karyawan,salesbaru) as salesbarunew, karyawan.nama_karyawan as nama_sales,
          IF(cabangbaru IS NULL,karyawan.kode_cabang,cabangbaru) as cabangbarunew
          FROM penjualan pj
          INNER JOIN karyawan ON pj.id_karyawan = karyawan.id_karyawan
          LEFT JOIN (
            SELECT MAX(id_move) as id_move,no_fak_penj,move_faktur.id_karyawan as salesbaru,karyawan.kode_cabang as cabangbaru
            FROM move_faktur
            INNER JOIN karyawan ON move_faktur.id_karyawan = karyawan.id_karyawan
						WHERE tgl_move <= '$dari'
            GROUP BY no_fak_penj,move_faktur.id_karyawan,karyawan.kode_cabang
          ) move_fak ON (pj.no_fak_penj = move_fak.no_fak_penj)
          
      ) pjmove ON (penjualan.no_fak_penj = pjmove.no_fak_penj)
		JOIN
				karyawan 
				ON pjmove.salesbarunew = karyawan.id_karyawan 
		LEFT JOIN (
			SELECT retur.no_fak_penj AS no_fak_penj,
			sum(retur.subtotal_gb) AS totalgb,
			sum(retur.subtotal_pf) AS totalpf
			FROM
			retur
			WHERE tglretur BETWEEN  '$dari' AND '$sampai'
				
			GROUP BY
				retur.no_fak_penj
		) returbulanini ON (penjualan.no_fak_penj = returbulanini.no_fak_penj)
		
		
		
		LEFT JOIN (
			SELECT no_fak_penj,sum( historibayar.bayar ) AS bayarsebelumbulanini
			FROM historibayar
			WHERE tglbayar < '$dari'
			GROUP BY no_fak_penj
		) hblalu ON (penjualan.no_fak_penj = hblalu.no_fak_penj)
		
		LEFT JOIN (
			SELECT no_fak_penj,sum( historibayar.bayar ) AS bayarbulanini
			FROM historibayar
			WHERE tglbayar BETWEEN  '$dari' AND '$sampai'
			GROUP BY no_fak_penj
		) hbskrg ON (penjualan.no_fak_penj = hbskrg.no_fak_penj)
		
		LEFT JOIN (
			SELECT retur.no_fak_penj AS no_fak_penj,
			sum(retur.subtotal_gb) AS totalgb_last,
			sum(retur.subtotal_pf) AS totalpf_last
			FROM
				retur
			WHERE tglretur < '$dari'
			GROUP BY
				retur.no_fak_penj
		) r ON (penjualan.no_fak_penj = r.no_fak_penj)
	WHERE
			penjualan.jenistransaksi != 'tunai' 
			AND tgltransaksi <= '$sampai'"
			. $cabang
			. $salesman
			. $pelanggan
			. "
			AND (ifnull(penjualan.total,0) - (ifnull(totalpf_last,0)-ifnull(totalgb_last,0))) != IFNULL(bayarsebelumbulanini,0)
			OR penjualan.jenistransaksi != 'tunai' 
			AND tgltransaksi <= '$sampai'"
			. $cabang
			. $salesman
			. $pelanggan
			. "
			AND IFNULL(bayarbulanini,0) != 0
			
	ORDER BY
			tgltransaksi ASC
		";
		return $this->db->query($query);
		//print_r($query);
	}


	function aup($cabang = null, $salesman = null, $pelanggan = null, $tanggal)
	{

		$tgl = '2020-01-01';
		if ($cabang 	!= "") {
			$cabang = "AND cabangbarunew = '" . $cabang . "'";
		} else {
			if ($tanggal < $tgl) {
				$cabang = "AND cabangbarunew !='GRT' ";
			}
		}
		if ($salesman != "") {
			$salesman = "AND salesbarunew = '" . $salesman . "' ";
		}
		if ($pelanggan != "") {
			$pelanggan = "AND penjualan.kode_pelanggan = '" . $pelanggan . "' ";
		}
		$this->db->order_by('nama_pelanggan', 'asc');

		$query = " SELECT
		penjualan.kode_pelanggan,nama_pelanggan,karyawan.nama_karyawan,pasar,hari,pelanggan.jatuhtempo,
		CASE
		WHEN datediff('$tanggal', tgltransaksi) <= 15 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duaminggu,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) <= 31  AND datediff('$tanggal', tgltransaksi) > 15 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS satubulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) <= 46  AND datediff('$tanggal', tgltransaksi) > 31 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS satubulan15,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) <= 60  AND datediff('$tanggal', tgltransaksi) > 46 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duabulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 60 AND datediff('$tanggal', tgltransaksi) <= 90 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS lebihtigabulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 90 AND datediff('$tanggal', tgltransaksi) <= 180 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS enambulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 180 AND datediff('$tanggal', tgltransaksi) <= 360 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duabelasbulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 360 AND datediff('$tanggal', tgltransaksi) <= 720 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duatahun,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 720 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS lebihduatahun
						
		FROM
			penjualan 
			JOIN
					pelanggan 
					ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan 
			JOIN
					karyawan 
					ON pelanggan.id_sales = karyawan.id_karyawan 
			
					
					LEFT JOIN (
          SELECT pj.no_fak_penj,
          IF(salesbaru IS NULL,pj.id_karyawan,salesbaru) as salesbarunew, karyawan.nama_karyawan as nama_sales,
          IF(cabangbaru IS NULL,karyawan.kode_cabang,cabangbaru) as cabangbarunew
          FROM penjualan pj
          INNER JOIN karyawan ON pj.id_karyawan = karyawan.id_karyawan
          LEFT JOIN (
            SELECT MAX(id_move) as id_move,no_fak_penj,move_faktur.id_karyawan as salesbaru,karyawan.kode_cabang as cabangbaru
            FROM move_faktur
            INNER JOIN karyawan ON move_faktur.id_karyawan = karyawan.id_karyawan
						WHERE tgl_move <='$tanggal'
            GROUP BY no_fak_penj,move_faktur.id_karyawan,karyawan.kode_cabang
          ) move_fak ON (pj.no_fak_penj = move_fak.no_fak_penj)
          
      ) pjmove ON (penjualan.no_fak_penj = pjmove.no_fak_penj)


			LEFT JOIN (
				SELECT no_fak_penj,sum( historibayar.bayar ) AS jmlbayar
				FROM historibayar
				WHERE tglbayar <= '$tanggal'
				GROUP BY no_fak_penj
			) hblalu ON (penjualan.no_fak_penj = hblalu.no_fak_penj)
			
			
			LEFT JOIN (
				SELECT retur.no_fak_penj AS no_fak_penj,
				SUM(total) AS total
				FROM
					retur
				WHERE tglretur <= '$tanggal'
				GROUP BY
					retur.no_fak_penj
			) retur ON (penjualan.no_fak_penj = retur.no_fak_penj)
			
		
		WHERE
			penjualan.jenistransaksi != 'tunai' 
			AND tgltransaksi <= '$tanggal'"
			. $cabang
			. $salesman
			. $pelanggan
			. "
			AND (ifnull(penjualan.total,0) - (ifnull(retur.total,0))) != IFNULL(jmlbayar,0)
			
		
		ORDER BY
			nama_pelanggan,penjualan.kode_pelanggan ASC

				";
		return $this->db->query($query);
	}

	function detailaup($cabang = null, $salesman = null, $pelanggan = null, $tanggal, $lama = null)
	{

		if ($cabang 	!= "all") {
			$cabang = "AND pelanggan.kode_cabang = '" . $cabang . "' ";
		} else {
			$cabang = "";
		}



		if ($salesman != "all") {
			$salesman = "AND salesbarunew = '" . $salesman . "' ";
		} else {
			$salesman = "";
		}

		if ($pelanggan != "all") {
			$pelanggan = "AND penjualan.kode_pelanggan = '" . $pelanggan . "' ";
		} else {
			$pelanggan = "";
		}

		if ($lama == "duaminggu") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) <=15";
		} else if ($lama == "satubulan") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) >15 AND datediff( '" . $tanggal . "', tgltransaksi ) <=31";
		} else if ($lama == "satubulan15") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) >31 AND datediff( '" . $tanggal . "', tgltransaksi ) <=46";
		} else if ($lama == "duabulan") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) >46 AND datediff( '" . $tanggal . "', tgltransaksi ) <=60";
		} else if ($lama == "tigabulan") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) >60 AND datediff( '" . $tanggal . "', tgltransaksi ) <=90";
		} else if ($lama == "enambulan") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) >90 AND datediff( '" . $tanggal . "', tgltransaksi ) <=180";
		} else if ($lama == "duabelasbulan") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) >180 AND datediff( '" . $tanggal . "', tgltransaksi ) <=360";
		} else if ($lama == "duatahun") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) >360 AND datediff( '" . $tanggal . "', tgltransaksi ) <=720";
		} else if ($lama == "lebihduatahun") {
			$lama = "AND datediff( '" . $tanggal . "', tgltransaksi ) >=720";
		} else {
			$lama = "";
		}


		$query = "SELECT
		penjualan.no_fak_penj,tgltransaksi,penjualan.kode_pelanggan,nama_pelanggan,pasar,hari,pelanggan.jatuhtempo AS jt,nama_karyawan,
			(ifnull(penjualan.total,0) - IFNULL(retur.total,0)-ifnull(jmlbayar,0)) AS jumlah					
		FROM
			penjualan 
			JOIN
					karyawan 
					ON penjualan.id_karyawan = karyawan.id_karyawan 
			JOIN
					pelanggan 
					ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan 

			LEFT JOIN (
				SELECT pj.no_fak_penj,
				IF(salesbaru IS NULL,pj.id_karyawan,salesbaru) as salesbarunew
				FROM penjualan pj
				LEFT JOIN (SELECT no_fak_penj,id_karyawan as salesbaru FROM move_faktur WHERE tgl_move<= '$tanggal' 
				AND id_move IN (SELECT MAX(id_move)
				FROM move_faktur WHERE tgl_move <='$tanggal'
				GROUP BY no_fak_penj)) move_fak ON (pj.no_fak_penj = move_fak.no_fak_penj)
				WHERE tgltransaksi <= '$tanggal'
			) pjmove ON (penjualan.no_fak_penj = pjmove.no_fak_penj)
					
			LEFT JOIN (
				SELECT no_fak_penj,sum( historibayar.bayar ) AS jmlbayar
				FROM historibayar
				WHERE tglbayar <= '$tanggal'
				GROUP BY no_fak_penj
			) hblalu ON (penjualan.no_fak_penj = hblalu.no_fak_penj)
			
			
			LEFT JOIN (
				SELECT retur.no_fak_penj AS no_fak_penj,
				SUM(total) AS total
				FROM
					retur
				WHERE tglretur <= '$tanggal'
				GROUP BY
					retur.no_fak_penj
			) retur ON (penjualan.no_fak_penj = retur.no_fak_penj)
			
		
		WHERE
			penjualan.jenisbayar != 'tunai' 
			AND tgltransaksi <= '$tanggal'"
			. $cabang
			. $salesman
			. $pelanggan
			. $lama
			. "
			AND (ifnull(penjualan.total,0) - (ifnull(retur.total,0))) != IFNULL(jmlbayar,0)
			
		
		ORDER BY
			nama_pelanggan,penjualan.kode_pelanggan ASC";

		return $this->db->query($query);
	}

	function tunaikredit($cabang = "", $salesman = "", $dari = "", $sampai = "")
	{
		if ($cabang 	!= "") {

			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		} else {

			$cabang = "";
		}

		if ($salesman != "") {

			$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
		} else {
			$salesman = "";
		}

		$query = "SELECT master_barang.kode_produk,nama_barang,isipcsdus,isipack,isipcs,jumlah_tunai,totaljual_tunai,jumlah_kredit,totaljual_kredit,jumlah_tunai + jumlah_kredit as jumlah,totaljual_tunai + totaljual_kredit as totaljual
					FROM master_barang
					LEFT JOIN (
					 SELECT kode_produk,
					 SUM( IF ( jenistransaksi ='tunai', detailpenjualan.jumlah, 0 ) ) AS jumlah_tunai,
					 SUM( IF ( jenistransaksi ='tunai', detailpenjualan.subtotal, 0 ) ) AS totaljual_tunai,
					 SUM( IF ( jenistransaksi ='kredit', detailpenjualan.jumlah, 0 ) ) AS jumlah_kredit,
					 SUM( IF ( jenistransaksi ='kredit', detailpenjualan.subtotal, 0 ) ) AS totaljual_kredit
					 FROM detailpenjualan
					 INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
					 INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
					 INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
					 WHERE tgltransaksi BETWEEN '$dari' AND '$sampai' AND promo !='1'"
			. $cabang
			. $salesman
			. "
					 GROUP BY kode_produk
					 ) dp ON (master_barang.kode_produk = dp.kode_produk)
					 ORDER BY master_barang.kode_produk ASC";
		return $this->db->query($query);
	}



	function lebihsatufaktur($cabang = null, $salesman = null, $tanggal)
	{

		if ($cabang 	!= "") {
			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {
			$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
		}

		$query = "SELECT
		penjualan.no_fak_penj,tgltransaksi,penjualan.kode_pelanggan,nama_pelanggan,pasar,penjualan.total as totalpenjualan,
			( ifnull( penjualan.total, 0 ) - IFNULL( retur.total, 0 ) - ifnull( jmlbayar, 0 ) ) AS sisabayar, 1 AS jmlfaktur
		FROM
			penjualan 
			JOIN
					karyawan 
					ON penjualan.id_karyawan = karyawan.id_karyawan 
			JOIN
					pelanggan 
					ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
		
					
			LEFT JOIN (
				SELECT no_fak_penj,sum( historibayar.bayar ) AS jmlbayar
				FROM historibayar
				WHERE tglbayar <= '$tanggal'
				GROUP BY no_fak_penj
			) hblalu ON (penjualan.no_fak_penj = hblalu.no_fak_penj)
			
			
			LEFT JOIN (
				SELECT retur.no_fak_penj AS no_fak_penj,
				SUM(total) AS total
				FROM
					retur
				WHERE tglretur <= '$tanggal'
				GROUP BY
					retur.no_fak_penj
			) retur ON (penjualan.no_fak_penj = retur.no_fak_penj)
			
		
		WHERE
			penjualan.jenisbayar != 'tunai' 
			AND tgltransaksi <= '$tanggal'"
			. $cabang
			. $salesman
			. "
			AND (ifnull(penjualan.total,0) - (ifnull(retur.total,0))) != IFNULL(jmlbayar,0)
			
		ORDER BY
			penjualan.kode_pelanggan ASC
			
		";
		return $this->db->query($query);
	}



	function lappelanggan($dari = null, $sampai = null, $cabang = null, $salesman = null)
	{

		if ($cabang != "") {

			$this->db->where('pelanggan.kode_cabang', $cabang);
		}

		if ($salesman != "") {

			$this->db->where('penjualan.id_karyawan', $salesman);
		}

		$this->db->select(' penjualan.kode_pelanggan,
							nama_pelanggan,
							detailpenjualan.kode_barang,
							kode_produk,
							nama_barang,
							jumlah,
							isipcsdus,
							isipack,
							isipcs,
							detailpenjualan.subtotal');
		$this->db->from('detailpenjualan');
		$this->db->join('penjualan', 'detailpenjualan.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('barang', 'detailpenjualan.kode_barang=barang.kode_barang');
		$this->db->where('tgltransaksi >=', $dari);
		$this->db->where('tgltransaksi <=', $sampai);
		$this->db->order_by('penjualan.kode_pelanggan');
		return $this->db->get();
	}


	function lapsales($dari = null, $sampai = null, $cabang = null)
	{

		if ($cabang != "") {

			$this->db->where('kode_cabang', $cabang);
		}


		$this->db->select('id_karyawan,nama_karyawan,pasar,hari,kode_cabang, SUM(subtotal) as subtotal,SUM(potongan) as potongan,SUM(potistimewa) as potistimewa,SUM(penyharga) as penyharga,SUM(total) as total,SUM(totalretur) as totalretur,SUM(totalpiutang) as totalpiutang');
		$this->db->from('view_pembayaran');
		$this->db->where('tgltransaksi >=', $dari);
		$this->db->where('tgltransaksi <=', $sampai);
		$this->db->group_by('id_karyawan');
		return $this->db->get();
	}

	function listgiro($tanggallhp = null, $cabang = null, $salesman = null)
	{

		$this->db->select("giro.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,tgl_giro,no_giro,namabank,jumlah,tglcair,giro.status");
		$this->db->from('giro');
		$this->db->join('penjualan', 'giro.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->where('tgl_giro', $tanggallhp);
		$this->db->where('pelanggan.kode_cabang', $cabang);
		$this->db->where('giro.id_karyawan', $salesman);
		return $this->db->get();
	}


	function listtransfer($tanggallhp = null, $cabang = null, $salesman = null)
	{

		$this->db->select("transfer.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,tgl_transfer,namabank,jumlah,tglcair,transfer.status");
		$this->db->from('transfer');
		$this->db->join('penjualan', 'transfer.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->where('tgl_transfer', $tanggallhp);
		$this->db->where('pelanggan.kode_cabang', $cabang);
		$this->db->where('transfer.id_karyawan', $salesman);
		return $this->db->get();
	}

	function setoranpenjualan($cabang = "", $salesman = "", $dari = "", $sampai = "")
	{

		$this->db->select('*');
		$this->db->from('setoran_penjualan');
		$this->db->join('karyawan', 'setoran_penjualan.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tgl_lhp,setoran_penjualan.id_karyawan', 'asc');

		if ($cabang != "-") {

			$this->db->where('setoran_penjualan.kode_cabang', $cabang);
		}
		if ($salesman != '-') {
			$this->db->where('setoran_penjualan.id_karyawan', $salesman);
		}

		if ($dari !=  '-') {
			$this->db->where('tgl_lhp >=', $dari);
		}
		if ($sampai !=  '-') {
			$this->db->where('tgl_lhp <=', $sampai);
		}
		return $this->db->get();
	}


	function setoranpusat($cabang = "", $bank = "", $dari = "", $sampai = "")
	{

		$this->db->select('*');
		$this->db->from('setoran_pusat');
		$this->db->order_by('kode_setoranpusat,tgl_setoranpusat', 'ASC');

		if ($cabang != "-") {
			$this->db->where('setoran_pusat.kode_cabang', $cabang);
		}
		if ($bank != '-') {
			$this->db->where('bank', $bank);
		}
		if ($dari !=  '-') {
			$this->db->where('tgl_setoranpusat >=', $dari);
		}
		if ($sampai !=  '-') {
			$this->db->where('tgl_setoranpusat <=', $sampai);
		}

		return $this->db->get();
	}

	function rekapbanksetoranpusat($cabang = "", $bank = "", $dari = "", $sampai = "")
	{

		$this->db->select('bank,sum(uang_kertas) as uang_kertas, sum(uang_logam) as uang_logam, sum(giro) as giro,SUM(transfer) as transfer');
		$this->db->from('setoran_pusat');
		$this->db->group_by('bank');

		if ($cabang != "-") {
			$this->db->where('setoran_pusat.kode_cabang', $cabang);
		}
		if ($bank != '-') {
			$this->db->where('bank', $bank);
		}
		if ($dari !=  '-') {
			$this->db->where('tgl_setoranpusat >=', $dari);
		}
		if ($sampai !=  '-') {
			$this->db->where('tgl_setoranpusat <=', $sampai);
		}

		return $this->db->get();
	}


	function setoran_penjualan($cabang = "", $salesman = "", $dari = "", $sampai = "")
	{

		$this->db->select('*');
		$this->db->from('setoran_penjualan');
		$this->db->join('karyawan', 'setoran_penjualan.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tgl_lhp', 'asc');

		if ($cabang != "") {

			$this->db->where('setoran_penjualan.kode_cabang', $cabang);
		}
		if ($salesman != '') {
			$this->db->where('setoran_penjualan.id_karyawan', $salesman);
		}

		if ($dari !=  '') {
			$this->db->where('tgl_lhp >=', $dari);
		}
		if ($sampai !=  '') {
			$this->db->where('tgl_lhp <=', $sampai);
		}

		return $this->db->get();
	}

	function rekapbg($cabang, $dari, $sampai)
	{
		$query = "SELECT tgl_giro,penjualan.id_karyawan,nama_karyawan,giro.no_fak_penj,nama_pelanggan,namabank,no_giro,tglcair as jatuhtempo,jumlah,tglbayar as tgl_pencairan
							FROM giro
							INNER JOIN penjualan
							ON giro.no_fak_penj = penjualan.no_fak_penj
							INNER JOIN karyawan
							ON penjualan.id_karyawan = karyawan.id_karyawan
							INNER JOIN pelanggan
							ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
							LEFT JOIN (SELECT id_giro,tglbayar FROM historibayar WHERE tglbayar BETWEEN '$dari' AND '$sampai') as hb
							ON giro.id_giro = hb.id_giro
							WHERE tgl_giro BETWEEN '$dari' AND '$sampai' AND pelanggan.kode_cabang='$cabang'
							OR tglbayar BETWEEN '$dari' AND '$sampai' AND pelanggan.kode_cabang='$cabang'
							ORDER BY tgl_giro,no_giro ASC
							";
		return $this->db->query($query);
	}


	function omset($cabang, $dari, $sampai)
	{
		$query = "SELECT karyawan.id_karyawan,nama_karyawan,total_omset,giro_jt,girolalu_jt,giro_belumjt,belumtransfer
								FROM karyawan
								LEFT JOIN
									(SELECT id_karyawan,SUM((lhp_tunai + lhp_tagihan)) as total_omset
										FROM setoran_penjualan
										WHERE tgl_lhp BETWEEN '$dari' AND '$sampai'
										GROUP BY id_karyawan) setoran
									ON (karyawan.id_karyawan = setoran.id_karyawan)
								LEFT JOIN
								(SELECT
									penjualan.id_karyawan,
									SUM( IF ( tglbayar BETWEEN '$dari' AND '$sampai', jumlah, 0 ) ) AS giro_jt,
									SUM( IF ( tgl_giro < '$dari' AND tglbayar BETWEEN '$dari' AND '$sampai', jumlah, 0 ) ) AS girolalu_jt,
									SUM(
								IF
									(
									tgl_giro BETWEEN '$dari'
									AND '$sampai'
									AND tglbayar NOT BETWEEN '$dari'
									AND '$sampai'
									OR tgl_giro BETWEEN '$dari'
									AND '$sampai'
									AND tglbayar IS NULL,
									jumlah,
									0
									)
									) AS giro_belumjt
								FROM
									giro
									INNER JOIN penjualan ON giro.no_fak_penj = penjualan.no_fak_penj
									LEFT JOIN historibayar ON giro.id_giro = historibayar.id_giro
								WHERE tgl_giro BETWEEN '$dari' AND '$sampai' OR tglbayar  BETWEEN '$dari' AND '$sampai'
								GROUP BY
									id_karyawan
									) g ON (karyawan.id_karyawan=g.id_karyawan)
									LEFT JOIN
									(SELECT
										penjualan.id_karyawan,
										SUM(
									IF
										(
										tgl_transfer BETWEEN '$dari'
										AND '$sampai'
										AND tglbayar NOT BETWEEN '$dari'
										AND '$sampai'
										OR tgl_transfer BETWEEN '$dari'
										AND '$sampai'
										AND tglbayar IS NULL,
										jumlah,
										0
										)
										) AS belumtransfer
									FROM
										transfer
										INNER JOIN penjualan ON transfer.no_fak_penj = penjualan.no_fak_penj
										LEFT JOIN historibayar ON transfer.id_transfer = historibayar.id_transfer
									WHERE tgl_transfer BETWEEN '$dari' AND '$sampai' OR tglbayar  BETWEEN '$dari' AND '$sampai'
									GROUP BY
										id_karyawan
										) t ON (karyawan.id_karyawan=t.id_karyawan)
								WHERE karyawan.kode_cabang = '$cabang' AND nama_karyawan !='-' GROUP BY id_karyawan,nama_karyawan,total_omset,giro_jt,girolalu_jt,giro_belumjt,belumtransfer
								";
		return $this->db->query($query);
	}

	function get_listbank($cbg = "")
	{
		if ($cbg != "") {
			$this->db->where('kode_cabang', $cbg);
		}
		return $this->db->get('master_bank');
	}

	function repo($dari, $sampai, $cabang = null, $salesman = null)
	{
		if ($cabang 	!= "") {

			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {

			$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
		}

		$query = "SELECT master_barang.kode_produk,nama_barang,isipcsdus,outlettergarap,totalpenjualan,efektifoutlet,totalpenjualaneo,newoutlet,totalpenjualanno
		FROM
		master_barang
		LEFT JOIN (SELECT barang.kode_produk,COUNT(penjualan.kode_pelanggan) as outlettergarap,SUM(detailpenjualan.jumlah) as totalpenjualan FROM
		detailpenjualan
		INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj

		INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
		INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
		WHERE tgltransaksi <'$dari'"
			. $cabang
			. $salesman
			. "
		GROUP BY barang.kode_produk) ot ON (master_barang.kode_produk = ot.kode_produk)

		LEFT JOIN(SELECT b1.kode_produk,COUNT(penjualan.kode_pelanggan) as efektifoutlet,SUM(d1.jumlah) as totalpenjualaneo FROM
		detailpenjualan d1
		INNER JOIN penjualan ON d1.no_fak_penj = penjualan.no_fak_penj
		INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
		INNER JOIN barang b1 ON d1.kode_barang = b1.kode_barang
		WHERE tgltransaksi BETWEEN '$dari' AND '$sampai' "
			. $cabang
			. $salesman
			. " AND penjualan.kode_pelanggan
		IN (SELECT penjualan.kode_pelanggan FROM
		detailpenjualan d2
		INNER JOIN penjualan ON d2.no_fak_penj = penjualan.no_fak_penj
		INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
		INNER JOIN barang ON d2.kode_barang = barang.kode_barang
		WHERE tgltransaksi < '$dari' "
			. $cabang
			. $salesman
			. " AND barang.kode_produk = b1.kode_produk
		GROUP BY penjualan.kode_pelanggan,barang.kode_produk
		ORDER BY kode_produk)
		GROUP BY b1.kode_produk) eo ON (master_barang.kode_produk = eo.kode_produk)

		LEFT JOIN(SELECT b1.kode_produk,COUNT(penjualan.kode_pelanggan) as newoutlet,SUM(d1.jumlah) as totalpenjualanno FROM
		detailpenjualan d1
		INNER JOIN penjualan ON d1.no_fak_penj = penjualan.no_fak_penj
		INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
		INNER JOIN barang b1 ON d1.kode_barang = b1.kode_barang
		WHERE tgltransaksi BETWEEN '$dari' AND '$sampai' "
			. $cabang
			. $salesman
			. " AND penjualan.kode_pelanggan
		NOT IN (SELECT penjualan.kode_pelanggan FROM
		detailpenjualan d2
		INNER JOIN penjualan ON d2.no_fak_penj = penjualan.no_fak_penj
		INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
		INNER JOIN barang ON d2.kode_barang = barang.kode_barang
		WHERE tgltransaksi < '$dari' "
			. $cabang
			. $salesman
			. " AND barang.kode_produk = b1.kode_produk
		GROUP BY penjualan.kode_pelanggan,barang.kode_produk
		ORDER BY kode_produk)
		GROUP BY b1.kode_produk) no ON (master_barang.kode_produk = no.kode_produk)";

		return $this->db->query($query);
	}


	function dppp($cabang, $tahun, $bulan)
	{
		$tahunlalu = $tahun - 1;
		if ($cabang 	!= "") {
			$cabang = "AND kode_cabang = '" . $cabang . "' ";
		}

		$query = "SELECT master_barang.kode_produk,nama_barang,isipcsdus,target_tahun,target_bulan,target_sampaibulan,realisasibulanberjalan,realisasibulanberjalanlast,realisasisampaibulanberjalan,realisasisampaibulanberjalanlast,realisasimanual,realisasimanualsampaibulanini
					FROM master_barang

					LEFT JOIN
					(SELECT target_pertahuncabang.kode_produk, SUM(target_tahun) as target_tahun FROM target_pertahuncabang
					INNER JOIN master_barang ON target_pertahuncabang.kode_produk = master_barang.kode_produk
					WHERE  tahun ='$tahun'"
			. $cabang
			. "
					GROUP BY target_pertahuncabang.kode_produk) tt ON (master_barang.kode_produk = tt.kode_produk)


					LEFT JOIN
					(SELECT target_bulancabang.kode_produk,SUM(target_bulan) as target_bulan FROM target_bulancabang
					INNER JOIN master_barang ON target_bulancabang.kode_produk = master_barang.kode_produk
					WHERE bulan ='$bulan' AND tahun='$tahun'"
			. $cabang
			. "
					GROUP BY target_bulancabang.kode_produk) tb ON (master_barang.kode_produk = tb.kode_produk)

					LEFT JOIN
					(SELECT target_bulancabang.kode_produk,SUM(target_bulan) as target_sampaibulan FROM target_bulancabang
					INNER JOIN master_barang ON target_bulancabang.kode_produk = master_barang.kode_produk
					WHERE bulan BETWEEN '1' AND '$bulan' AND tahun='$tahun'"
			. $cabang
			. "
					GROUP BY target_bulancabang.kode_produk) tb2 ON (master_barang.kode_produk = tb2.kode_produk)

					LEFT JOIN (SELECT kode_produk,SUM(jumlah) as realisasibulanberjalan FROM detailpenjualan
					INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
					INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
					WHERE
					MONTH(tgltransaksi) = '$bulan' AND YEAR(tgltransaksi) = '$tahun'"
			. $cabang
			. "
					GROUP BY kode_produk ) dp ON (master_barang.kode_produk = dp.kode_produk)

					LEFT JOIN (SELECT kode_produk,SUM(jumlah) as realisasibulanberjalanlast FROM detailpenjualan
					INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
					INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
					WHERE
					MONTH(tgltransaksi) = '$bulan' AND YEAR(tgltransaksi) = '$tahunlalu'"
			. $cabang
			. "
					GROUP BY kode_produk ) dplast ON (master_barang.kode_produk = dplast.kode_produk)

					LEFT JOIN (
					SELECT
						kode_produk,
						SUM(jumlah_penjualan) AS realisasimanual
					FROM
						rekap_penjualan
					WHERE
						bulan = '$bulan'
						AND tahun = '$tahunlalu'"
			. $cabang
			. "
					GROUP BY
						kode_produk
					) rp2 ON ( master_barang.kode_produk = rp2.kode_produk )
					LEFT JOIN (
					SELECT
						kode_produk,
						SUM(jumlah_penjualan) AS realisasimanualsampaibulanini
					FROM
						rekap_penjualan
					WHERE
						bulan <= '$bulan'
						AND tahun = '$tahunlalu'"
			. $cabang
			. "
					GROUP BY
						kode_produk
					) rp ON ( master_barang.kode_produk = rp.kode_produk )

					LEFT JOIN (SELECT kode_produk,SUM(jumlah) as realisasisampaibulanberjalan FROM detailpenjualan
					INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
					INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
					WHERE
					MONTH(tgltransaksi) BETWEEN '1' AND '$bulan' AND YEAR(tgltransaksi) = '$tahun'"
			. $cabang
			. "
					GROUP BY kode_produk ) dp2 ON (master_barang.kode_produk = dp2.kode_produk)

					LEFT JOIN (SELECT kode_produk,SUM(jumlah) as realisasisampaibulanberjalanlast FROM detailpenjualan
					INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
					INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
					WHERE
					MONTH(tgltransaksi) BETWEEN '1' AND '$bulan' AND YEAR(tgltransaksi) = '$tahunlalu'"
			. $cabang
			. "
					GROUP BY kode_produk ) dp2last ON (master_barang.kode_produk = dp2last.kode_produk)


					ORDER BY kode_produk ASC
					";

		return $this->db->query($query);
	}


	function dpp($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null)
	{

		if ($cabang 	!= "") {

			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {

			$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
		}

		if ($pelanggan != "") {

			$pelanggan = "AND penjualan.kode_pelanggan = '" . $pelanggan . "' ";
		}

		$query = "SELECT tgltransaksi,penjualan.kode_pelanggan,nama_pelanggan,alamat_pelanggan,penjualan.id_karyawan,nama_karyawan,
					SUM( IF ( kode_produk = 'BB', jumlah/isipcsdus, 0 ) ) AS BB,
					SUM( IF ( kode_produk = 'AB', jumlah/isipcsdus, 0 ) ) AS AB,
					SUM( IF ( kode_produk = 'AR', jumlah/isipcsdus, 0 ) ) AS AR,
					SUM( IF ( kode_produk = 'AS', jumlah/isipcsdus, 0 ) ) AS ASE,
					SUM( IF ( kode_produk = 'DEP', jumlah/isipcsdus, 0 ) ) AS DP,
					SUM( IF ( kode_produk = 'DK', jumlah/isipcsdus, 0 ) )  AS DK,
					SUM( IF ( kode_produk = 'DS', jumlah/isipcsdus, 0 ) )  AS DS,
					SUM( IF ( kode_produk = 'DB', jumlah/isipcsdus, 0 ) )  AS DB,
					SUM( IF ( kode_produk = 'CG', jumlah/isipcsdus, 0 ) )  AS CG,
					SUM( IF ( kode_produk = 'CGG', jumlah/isipcsdus, 0 ) ) AS CGG
					FROM detailpenjualan

					INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
					INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
					INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
					INNER JOIN karyawan  ON penjualan.id_karyawan = karyawan.id_karyawan
					WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $cabang
			. $salesman
			. $pelanggan
			. "
					GROUP BY tgltransaksi,penjualan.kode_pelanggan,nama_pelanggan,penjualan.id_karyawan,nama_karyawan
					ORDER BY tgltransaksi";

		return $this->db->query($query);
	}


	function rekappelanggan($dari = null, $sampai = null, $cabang = null, $salesman = null, $pelanggan = null)
	{
		if ($cabang 	!= "") {

			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {

			$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
		}

		if ($pelanggan != "") {

			$pelanggan = "AND penjualan.kode_pelanggan = '" . $pelanggan . "' ";
		}

		$query = "SELECT penjualan.kode_pelanggan,nama_pelanggan,nama_karyawan,
					SUM( IF ( kode_produk = 'AB', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS AB,
					SUM( IF ( kode_produk = 'AR', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS AR,
					SUM( IF ( kode_produk = 'AS', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS ASE,
					SUM( IF ( kode_produk = 'BB', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS BB,
					SUM( IF ( kode_produk = 'CG', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS CG,
					SUM( IF ( kode_produk = 'CGG', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS CGG,
					SUM( IF ( kode_produk = 'DB', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS DB,
					SUM( IF ( kode_produk = 'DEP', detailpenjualan.jumlah/isipcsdus,NULL ) ) AS DEP,
					SUM( IF ( kode_produk = 'DK', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS DK,
					SUM( IF ( kode_produk = 'DS', detailpenjualan.jumlah/isipcsdus, NULL ) ) AS DS
				FROM detailpenjualan
				INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
				INNER JOIN penjualan ON detailpenjualan.no_fak_penj =  penjualan.no_fak_penj
				INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
				INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
				WHERE  tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $cabang
			. $salesman
			. $pelanggan
			. "
				GROUP BY penjualan.kode_pelanggan,nama_pelanggan,nama_karyawan";
		return $this->db->query($query);
	}


	function rekappenjualan($dari = null, $sampai = null, $cabang = null, $salesman = null)
	{
		$tanggal = '2020-01-01';
		if ($cabang 	!= "") {
			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "'";
		} else {
			if ($dari < $tanggal) {
				$cabang = "AND karyawan.kode_cabang !='GRT' ";
			}
		}

		if ($salesman != "") {

			$salesman = "AND karyawan.id_karyawan = '" . $salesman . "' ";
		}



		$query = "SELECT
							karyawan.id_karyawan,
							nama_karyawan,
							karyawan.kode_cabang,
							AB,
							AR,
							ASE,
							BB,
							CG,
							CGG,
							DB,
							DEP,
							DK,
							DS,
							totalbruto,
							totalretur,
							totalpotongan, totalpotistimewa,
							totalpenyharga,
							totalpenjualansampaibulanlalu,
							totalretursampaibulanlalu,
							totalbayar,
							bayarsebelumbulanini,
						(IFNULL(totalpenjualansampaibulanlalu,0)-IFNULL(totalretursampaibulanlalu,0)) - IFNULL(bayarsebelumbulanini,0) as saldoawalpiutang,

						totalpenjualankredit,
						totalreturkredit,
						totalbayarkredit,
						(IFNULL(totalpenjualankredit,0)-IFNULL(totalreturkredit,0)) as totalpiutangbulanini,
						((IFNULL(totalpenjualansampaibulanlalu,0)-IFNULL(totalretursampaibulanlalu,0)) - IFNULL(bayarsebelumbulanini,0)+(IFNULL(totalpenjualankredit,0)-IFNULL(totalreturkredit,0)))-IFNULL(totalbayarkredit,0) as saldoakhirpiutang
						FROM
							karyawan
							
							LEFT JOIN (
						SELECT
							p.id_karyawan,
							SUM( IF ( kode_produk = 'AB', detailpenjualan.subtotal, NULL ) ) AS AB,
							SUM( IF ( kode_produk = 'AR', detailpenjualan.subtotal, NULL ) ) AS AR,
							SUM( IF ( kode_produk = 'AS', detailpenjualan.subtotal, NULL ) ) AS ASE,
							SUM( IF ( kode_produk = 'BB', detailpenjualan.subtotal, NULL ) ) AS BB,
							SUM( IF ( kode_produk = 'CG', detailpenjualan.subtotal, NULL ) ) AS CG,
							SUM( IF ( kode_produk = 'CGG', detailpenjualan.subtotal, NULL ) ) AS CGG,
							SUM( IF ( kode_produk = 'DB', detailpenjualan.subtotal, NULL ) ) AS DB,
							SUM( IF ( kode_produk = 'DEP', detailpenjualan.subtotal, NULL ) ) AS DEP,
							SUM( IF ( kode_produk = 'DK', detailpenjualan.subtotal, NULL ) ) AS DK,
							SUM( IF ( kode_produk = 'DS', detailpenjualan.subtotal, NULL ) ) AS DS
						FROM
							detailpenjualan
							INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
							INNER JOIN penjualan p ON detailpenjualan.no_fak_penj = p.no_fak_penj
						WHERE
							tgltransaksi BETWEEN '$dari'
							AND '$sampai'
						GROUP BY
							p.id_karyawan
							) dp ON ( karyawan.id_karyawan = dp.id_karyawan )



							LEFT JOIN (
						SELECT
							id_karyawan,
							SUM(IF(tglretur BETWEEN '$dari' AND '$sampai',retur.total,0 )) AS totalretur,
							SUM(IF(tglretur BETWEEN '$dari' AND '$sampai' AND jenistransaksi!='tunai',retur.total,0 )) AS totalreturkredit,
							SUM(IF(tglretur < '$dari',retur.total,0 )) AS totalretursampaibulanlalu
						FROM
							retur
							INNER JOIN penjualan ON retur.no_fak_penj = penjualan.no_fak_penj
						WHERE
							tglretur <= '$sampai'
						GROUP BY
							id_karyawan
							) rt ON ( karyawan.id_karyawan = rt.id_karyawan )


								
							LEFT JOIN (
						SELECT
							id_karyawan,
							SUM(IF(tgltransaksi BETWEEN '$dari' AND '$sampai',potongan,0 )) AS totalpotongan,
							SUM(IF(tgltransaksi BETWEEN '$dari' AND '$sampai',potistimewa,0 )) AS totalpotistimewa,
							SUM(IF(tgltransaksi BETWEEN '$dari' AND '$sampai',penyharga,0 )) AS totalpenyharga,
							SUM(IF(tgltransaksi BETWEEN '$dari' AND '$sampai',subtotal,0 )) AS totalbruto,
							SUM(IF(tgltransaksi BETWEEN '$dari' AND '$sampai' AND jenistransaksi !='tunai',total,0 )) AS totalpenjualankredit,
							SUM(IF(tgltransaksi < '$dari',total,0 )) AS totalpenjualansampaibulanlalu
						FROM
							penjualan
						WHERE tgltransaksi <= '$sampai'

						GROUP BY
							id_karyawan
							) penj ON ( karyawan.id_karyawan = penj.id_karyawan )



						LEFT JOIN (
						SELECT
							historibayar.id_karyawan,
							SUM(IF(tglbayar BETWEEN '$dari' AND '$sampai',bayar,0)) as totalbayar,
							SUM(IF(tglbayar BETWEEN '$dari' AND '$sampai' AND penjualan.jenisbayar!='tunai',bayar,0)) as totalbayarkredit,
							SUM(IF(tglbayar < '$dari',bayar,0)) as bayarsebelumbulanini
						FROM
							historibayar
							INNER JOIN penjualan ON historibayar.no_fak_penj = penjualan.no_fak_penj
						WHERE tglbayar <='$sampai'
						GROUP BY
							historibayar.id_karyawan
							) hb ON ( karyawan.id_karyawan = hb.id_karyawan )
							
						WHERE
							karyawan.id_karyawan != ''"
			. $cabang
			. $salesman
			. "
								ORDER BY karyawan.id_karyawan,karyawan.kode_cabang
							";
		return $this->db->query($query);
	}

	function rekappenjualanqty($dari = null, $sampai = null)
	{
		$query = " SELECT kode_produk,nama_barang,isipcsdus,
					SUM(IF(karyawan.kode_cabang = 'BDG',jumlah,0)) as BDG,
					SUM(IF(karyawan.kode_cabang = 'BDG',detailpenjualan.subtotal,0)) as JML_BDG,
					SUM(IF(karyawan.kode_cabang = 'BGR',jumlah,0)) as BGR,
					SUM(IF(karyawan.kode_cabang = 'BGR',detailpenjualan.subtotal,0)) as JML_BGR,
					SUM(IF(karyawan.kode_cabang = 'SKB',jumlah,0)) as SKB,
					SUM(IF(karyawan.kode_cabang = 'SKB',detailpenjualan.subtotal,0)) as JML_SKB,
					SUM(IF(karyawan.kode_cabang = 'PWT',jumlah,0)) as PWT,
					SUM(IF(karyawan.kode_cabang = 'PWT',detailpenjualan.subtotal,0)) as JML_PWT,
					SUM(IF(karyawan.kode_cabang = 'TGL',jumlah,0)) as TGL,
					SUM(IF(karyawan.kode_cabang = 'TGL',detailpenjualan.subtotal,0)) as JML_TGL,
					SUM(IF(karyawan.kode_cabang = 'TSM',jumlah,0)) as TSM,
					SUM(IF(karyawan.kode_cabang = 'TSM',detailpenjualan.subtotal,0)) as JML_TSM,
					SUM(IF(karyawan.kode_cabang = 'SBY',jumlah,0)) as SBY,
					SUM(IF(karyawan.kode_cabang = 'SBY',detailpenjualan.subtotal,0)) as JML_SBY,
					SUM(IF(karyawan.kode_cabang = 'SMR',jumlah,0)) as SMR,
					SUM(IF(karyawan.kode_cabang = 'SMR',detailpenjualan.subtotal,0)) as JML_SMR,
					SUM(IF(karyawan.kode_cabang = 'PST',jumlah,0)) as PST,
					SUM(IF(karyawan.kode_cabang = 'PST',detailpenjualan.subtotal,0)) as JML_PST,
					SUM(jumlah) as totalqty,
					SUM(detailpenjualan.subtotal) as JML
					FROM detailpenjualan
					INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
					INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
					INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
					WHERE tgltransaksi BETWEEN '$dari' AND '$sampai' AND promo != '1'
					GROUP BY kode_produk,nama_barang,isipcsdus";
		return $this->db->query($query);
	}

	function rekapretur($dari = null, $sampai = null, $cabang = null, $salesman = null)
	{
		if ($cabang 	!= "") {
			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}
		if ($salesman != "") {
			$salesman = "AND p.id_karyawan = '" . $salesman . "' ";
		}
		$query = "SELECT
					p.id_karyawan,nama_karyawan,karyawan.kode_cabang,
					SUM( IF ( kode_produk = 'AB', detailretur.jumlah/isipcsdus, NULL ) ) AS JML_AB,
					SUM( IF ( kode_produk = 'AB', detailretur.subtotal, NULL ) ) AS AB,
					SUM( IF ( kode_produk = 'AR', detailretur.jumlah/isipcsdus, NULL ) ) AS JML_AR,
					SUM( IF ( kode_produk = 'AR', detailretur.subtotal, NULL ) ) AS AR,
					SUM( IF ( kode_produk = 'AS', detailretur.jumlah/isipcsdus, NULL ) ) AS JML_ASE,
					SUM( IF ( kode_produk = 'AS', detailretur.subtotal, NULL ) ) AS ASE,
					SUM( IF ( kode_produk = 'BB', detailretur.jumlah/isipcsdus, NULL ) ) AS JML_BB,
					SUM( IF ( kode_produk = 'BB', detailretur.subtotal, NULL ) ) AS BB,
					SUM( IF ( kode_produk = 'CG', detailretur.jumlah/isipcsdus, NULL ) ) AS JML_CG,
					SUM( IF ( kode_produk = 'CG', detailretur.subtotal, NULL ) ) AS CG,
					SUM( IF ( kode_produk = 'CGG',detailretur.jumlah/isipcsdus, NULL ) ) AS JML_CGG,
					SUM( IF ( kode_produk = 'CGG',detailretur.subtotal, NULL ) ) AS CGG,
					SUM( IF ( kode_produk = 'DB',detailretur.jumlah/isipcsdus, NULL ) ) AS JML_DB,
					SUM( IF ( kode_produk = 'DB',detailretur.subtotal, NULL ) ) AS DB,
					SUM( IF ( kode_produk = 'DEP',detailretur.jumlah/isipcsdus,NULL ) ) AS JML_DEP,
					SUM( IF ( kode_produk = 'DEP',detailretur.subtotal,NULL ) ) AS DEP,
					SUM( IF ( kode_produk = 'DK',detailretur.jumlah/isipcsdus, NULL ) ) AS JML_DK,
					SUM( IF ( kode_produk = 'DK',detailretur.subtotal, NULL ) ) AS DK,
					SUM( IF ( kode_produk = 'DS',detailretur.jumlah/isipcsdus, NULL ) ) AS JML_DS,
					SUM( IF ( kode_produk = 'DS',detailretur.subtotal, NULL ) ) AS DS,
					SUM(detailretur.subtotal) as totalretur,
					total_gb
					FROM detailretur

					INNER JOIN barang ON detailretur.kode_barang = barang.kode_barang
					INNER JOIN retur ON detailretur.no_retur_penj = retur.no_retur_penj
					INNER JOIN penjualan p ON retur.no_fak_penj = p.no_fak_penj
					INNER JOIN karyawan ON p.id_karyawan = karyawan.id_karyawan
					LEFT JOIN (
						SELECT id_karyawan,SUM(subtotal_gb) as total_gb FROM retur
						INNER JOIN penjualan ON retur.no_fak_penj = penjualan.no_fak_penj
						WHERE tglretur BETWEEN '$dari' AND '$sampai'
						GROUP BY id_karyawan
					) penj ON  (p.id_karyawan = penj.id_karyawan)
					WHERE tglretur BETWEEN '$dari' AND '$sampai'
					"
			. $cabang
			. $salesman
			. "
					GROUP BY p.id_karyawan
					ORDER BY karyawan.kode_cabang,nama_karyawan ASC";
		return $this->db->query($query);
	}

	// function rekapaup($cabang = null, $salesman = null, $pelanggan = null, $tanggal)
	// {
	// 	$tgl = '2020-01-01';
	// 	if ($cabang 	!= "") {
	// 		$cabang = "AND karyawan.kode_cabang = '" . $cabang . "'";
	// 	} else {
	// 		if ($tanggal < $tgl) {
	// 			$cabang = "AND karyawan.kode_cabang !='GRT' ";
	// 		}
	// 	}
	// 	// if($cabang 	!= ""){
	// 	// 	 $cabang = "AND karyawan.kode_cabang = '".$cabang."' ";
	// 	// }
	// 	if ($salesman != "") {
	// 		$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
	// 	}

	// 	if ($pelanggan != "") {
	// 		$pelanggan = "AND penjualan.kode_pelanggan = '" . $pelanggan . "' ";
	// 	}
	// 	$this->db->order_by('nama_pelanggan', 'asc');
	// 	$query = " SELECT
	// 	penjualan.kode_pelanggan,nama_pelanggan,pasar,hari,pelanggan.jatuhtempo,penjualan.id_karyawan,nama_karyawan,karyawan.kode_cabang,
	// 	CASE
	// 	WHEN datediff('$tanggal', tgltransaksi) <= 15 THEN
	// 			((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duaminggu,
	// 	CASE		
	// 	WHEN datediff('$tanggal', tgltransaksi) <= 30  AND datediff('$tanggal', tgltransaksi) > 15 THEN
	// 			((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS satubulan,
	// 	CASE		
	// 	WHEN datediff('$tanggal', tgltransaksi) <= 60  AND datediff('$tanggal', tgltransaksi) > 30 THEN
	// 			((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duabulan,
	// 	CASE		
	// 	WHEN datediff('$tanggal', tgltransaksi) > 60 AND datediff('$tanggal', tgltransaksi) <= 90 THEN
	// 			((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS lebihtigabulan,
	// 	CASE		
	// 	WHEN datediff('$tanggal', tgltransaksi) > 90 AND datediff('$tanggal', tgltransaksi) <= 180 THEN
	// 			((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS enambulan,
	// 	CASE		
	// 	WHEN datediff('$tanggal', tgltransaksi) > 180 AND datediff('$tanggal', tgltransaksi) <= 360 THEN
	// 			((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duabelasbulan,
	// 	CASE		
	// 	WHEN datediff('$tanggal', tgltransaksi) > 360 AND datediff('$tanggal', tgltransaksi) <= 720 THEN
	// 			((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duatahun,
	// 	CASE		
	// 	WHEN datediff('$tanggal', tgltransaksi) > 720 THEN
	// 			((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS lebihduatahun

	// 	FROM
	// 		penjualan 
	// 		JOIN
	// 				karyawan 
	// 				ON penjualan.id_karyawan = karyawan.id_karyawan 
	// 		JOIN
	// 				pelanggan 
	// 				ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan 


	// 		LEFT JOIN (
	// 			SELECT no_fak_penj,sum( historibayar.bayar ) AS jmlbayar
	// 			FROM historibayar
	// 			WHERE tglbayar <= '$tanggal'
	// 			GROUP BY no_fak_penj
	// 		) hblalu ON (penjualan.no_fak_penj = hblalu.no_fak_penj)


	// 		LEFT JOIN (
	// 			SELECT retur.no_fak_penj AS no_fak_penj,
	// 			SUM(total) AS total
	// 			FROM
	// 				retur
	// 			WHERE tglretur <= '$tanggal'
	// 			GROUP BY
	// 				retur.no_fak_penj
	// 		) retur ON (penjualan.no_fak_penj = retur.no_fak_penj)


	// 	WHERE
	// 		penjualan.jenisbayar != 'tunai' 
	// 		AND tgltransaksi <= '$tanggal'"
	// 		. $cabang
	// 		. $salesman
	// 		. $pelanggan
	// 		. "
	// 		AND (ifnull(penjualan.total,0) - (ifnull(retur.total,0))) != IFNULL(jmlbayar,0)
	// 	ORDER BY
	// 		karyawan.kode_cabang ASC";
	// 	return $this->db->query($query);
	// }

	function rekapaup($cabang = null, $salesman = null, $pelanggan = null, $tanggal)
	{
		$tgl = '2020-01-01';
		if ($cabang 	!= "") {
			$cabang = "AND cabangbarunew = '" . $cabang . "'";
		} else {
			if ($tanggal < $tgl) {
				$cabang = "AND cabangbarunew !='GRT' ";
			}
		}
		// if($cabang 	!= ""){
		// 	 $cabang = "AND karyawan.kode_cabang = '".$cabang."' ";
		// }
		if ($salesman != "") {
			$salesman = "AND salesbarunew = '" . $salesman . "' ";
		}

		if ($pelanggan != "") {
			$pelanggan = "AND salesbarunew = '" . $pelanggan . "' ";
		}
		$this->db->order_by('nama_pelanggan', 'asc');
		$query = " SELECT
		penjualan.kode_pelanggan,nama_pelanggan,pasar,hari,pelanggan.jatuhtempo,penjualan.id_karyawan,nama_karyawan,karyawan.kode_cabang,cabangbarunew,salesbarunew,
		CASE
		WHEN datediff('$tanggal', tgltransaksi) <= 15 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duaminggu,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) <= 31  AND datediff('$tanggal', tgltransaksi) > 15 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS satubulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) <= 46  AND datediff('$tanggal', tgltransaksi) > 31 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS satubulan15,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) <= 60  AND datediff('$tanggal', tgltransaksi) > 46 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duabulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 60 AND datediff('$tanggal', tgltransaksi) <= 90 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS lebihtigabulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 90 AND datediff('$tanggal', tgltransaksi) <= 180 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS enambulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 180 AND datediff('$tanggal', tgltransaksi) <= 360 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duabelasbulan,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 360 AND datediff('$tanggal', tgltransaksi) <= 720 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS duatahun,
		CASE		
		WHEN datediff('$tanggal', tgltransaksi) > 720 THEN
				((IFNULL(penjualan.total,0))-(IFNULL(retur.total,0)))-(ifnull(jmlbayar,0) ) END AS lebihduatahun
						
		FROM
			penjualan 
			JOIN
					karyawan 
					ON penjualan.id_karyawan = karyawan.id_karyawan 
			JOIN
					pelanggan 
					ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan 
					
					
			LEFT JOIN (
				SELECT no_fak_penj,sum( historibayar.bayar ) AS jmlbayar
				FROM historibayar
				WHERE tglbayar <= '$tanggal'
				GROUP BY no_fak_penj
			) hblalu ON (penjualan.no_fak_penj = hblalu.no_fak_penj)
			
			
			LEFT JOIN (
				SELECT retur.no_fak_penj AS no_fak_penj,
				SUM(total) AS total
				FROM
					retur
				WHERE tglretur <= '$tanggal'
				GROUP BY
					retur.no_fak_penj
			) retur ON (penjualan.no_fak_penj = retur.no_fak_penj)
			
			LEFT JOIN (
          SELECT pj.no_fak_penj,
          IF(salesbaru IS NULL,pj.id_karyawan,salesbaru) as salesbarunew, karyawan.nama_karyawan as nama_sales,
          IF(cabangbaru IS NULL,karyawan.kode_cabang,cabangbaru) as cabangbarunew
          FROM penjualan pj
          INNER JOIN karyawan ON pj.id_karyawan = karyawan.id_karyawan
          LEFT JOIN (
            SELECT MAX(id_move) as id_move,no_fak_penj,move_faktur.id_karyawan as salesbaru,karyawan.kode_cabang as cabangbaru
            FROM move_faktur
            INNER JOIN karyawan ON move_faktur.id_karyawan = karyawan.id_karyawan
						WHERE tgl_move <= '$tanggal'
            GROUP BY no_fak_penj,move_faktur.id_karyawan,karyawan.kode_cabang
          ) move_fak ON (pj.no_fak_penj = move_fak.no_fak_penj)
          
      ) pjmove ON (penjualan.no_fak_penj = pjmove.no_fak_penj)
		WHERE
			penjualan.jenistransaksi != 'tunai' 
			AND tgltransaksi <= '$tanggal'"
			. $cabang
			. $salesman
			. $pelanggan
			. "
			AND (ifnull(penjualan.total,0) - (ifnull(retur.total,0))) != IFNULL(jmlbayar,0)
		ORDER BY
			cabangbarunew,salesbarunew ASC";
		return $this->db->query($query);
	}
	function rekapproduk($dari = null, $sampai = null, $cabang = null, $salesman = null)
	{
		if ($cabang 	!= "") {
			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {
			$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
		}
		$query = "SELECT barang.nama_barang,barang.kode_produk,kategori_jenisproduk,SUM(detailpenjualan.subtotal) as jumlah
		FROM detailpenjualan
		INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
		INNER JOIN master_barang ON barang.kode_produk = master_barang.kode_produk
		INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
		INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
		WHERE  tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $cabang
			. $salesman
			. "
		GROUP BY barang.nama_barang,barang.kode_produk,kategori_jenisproduk";
		return $this->db->query($query);
	}

	function list_penjualanpelangganpending($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null, $jt = null, $status = null)
	{
		if ($cabang 	!= "") {
			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {
			$salesman = "AND penjualan_pending.id_karyawan = '" . $salesman . "' ";
		}

		if ($pelanggan != "") {
			$pelanggan = "AND penjualan_pending.kode_pelanggan = '" . $pelanggan . "' ";
		}

		if ($status == "1") {
			$status = "AND (SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) =','1'";
		} else if ($status == "2") {
			$status = "AND (SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) !=','1'";
		}

		$query = $this->db->query("SELECT penjualan_pending.kode_pelanggan,nama_pelanggan,pasar,hari,penjualan_pending.id_karyawan,nama_karyawan,SUM(subtotal) as totalpenjualan_pending,sum(potongan) as totalpotongan,
		 sum(potistimewa) as totalpotonganistimewa,sum(penyharga) as totalpenyharga, sum(total) as totalpenjualan_pendingnetto,SUM(totretur) as totalretur
		 FROM penjualan_pending
		 INNER JOIN pelanggan ON penjualan_pending.kode_pelanggan = pelanggan.kode_pelanggan
		 INNER JOIN karyawan ON penjualan_pending.id_karyawan = karyawan.id_karyawan
		 LEFT JOIN (SELECT no_fak_penj,SUM(total) as totretur FROM retur WHERE tglretur BETWEEN '$dari' AND '$sampai' GROUP BY no_fak_penj ) ret ON (ret.no_fak_penj = penjualan_pending.no_fak_penj)
		 WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $cabang
			. $salesman
			. $pelanggan
			. $status
			. $jt
			. "
		GROUP BY
		penjualan_pending.kode_pelanggan,
		nama_pelanggan,
		pasar,
		Hari,
		penjualan_pending.id_karyawan,
		nama_karyawan
		");
		return $query;
	}

	function list_penjualanpelanggan($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null, $jt = null)
	{
		if ($cabang  != "") {
			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "' ";
		}

		if ($salesman != "") {
			$salesman = "AND penjualan.id_karyawan = '" . $salesman . "' ";
		}

		if ($pelanggan != "") {
			$pelanggan = "AND penjualan.kode_pelanggan = '" . $pelanggan . "' ";
		}

		$query = $this->db->query("SELECT penjualan.kode_pelanggan,nama_pelanggan,pasar,hari,penjualan.id_karyawan,nama_karyawan,SUM(subtotal) as totalpenjualan,sum(potongan) as totalpotongan,
     sum(potistimewa) as totalpotonganistimewa,sum(penyharga) as totalpenyharga, sum(total) as totalpenjualannetto,SUM(totretur) as totalretur
     FROM penjualan
     INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
     INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
     LEFT JOIN (SELECT no_fak_penj,SUM(total) as totretur FROM retur WHERE tglretur BETWEEN '$dari' AND '$sampai' GROUP BY no_fak_penj ) ret ON (ret.no_fak_penj = penjualan.no_fak_penj)
     WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
			. $cabang
			. $salesman
			. $pelanggan
			. $jt
			. "
    GROUP BY
    penjualan.kode_pelanggan,
    nama_pelanggan,
    pasar,
    Hari,
    penjualan.id_karyawan,
    nama_karyawan
    ");
		return $query;
	}

	function getSaldoAwalKasBesar($cabang, $dari)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$this->db->select('uang_kertas,uang_logam,giro,transfer');
		$this->db->from('saldoawal_kasbesar');
		$this->db->where('MONTH(tanggal)', $bulan);
		$this->db->where('YEAR(tanggal)', $tahun);
		$this->db->where('kode_cabang', $cabang);
		return $this->db->get();
	}

	function getSetoranPenjualan($cabang, $dari)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$mulai   = $tahun . "-" . $bulan . "-" . "01";
		$this->db->where('tgl_lhp >=', $mulai);
		$this->db->where('tgl_lhp <', $dari);
		$this->db->where('kode_cabang', $cabang);
		$this->db->select('SUM(setoran_logam) as uanglogam,SUM(setoran_kertas) as uangkertas,SUM(setoran_bg) as giro,SUM(girotocash) as girotocash,SUM(setoran_transfer) as transfer');
		$this->db->from('setoran_penjualan');
		return $this->db->get();
	}

	function getSetoranPusat($cabang, $dari)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$mulai   = $tahun . "-" . $bulan . "-" . "01";
		$this->db->where('tgl_setoranpusat >=', $mulai);
		$this->db->where('tgl_setoranpusat <', $dari);
		$this->db->where('kode_cabang', $cabang);
		$this->db->select('SUM(uang_logam) as uanglogam,SUM(uang_kertas) as uangkertas,SUM(giro) as giro,SUM(transfer) as transfer');
		$this->db->from('setoran_pusat');
		return $this->db->get();
	}

	function getKLSetorpenjualan($cabang, $dari, $pembayaran)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$mulai   = $tahun . "-" . $bulan . "-" . "01";
		$this->db->where('tgl_kl >=', $mulai);
		$this->db->where('tgl_kl <', $dari);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('pembayaran', $pembayaran);
		$this->db->select('SUM(uang_logam) as uanglogam,SUM(uang_kertas) as uangkertas');
		$this->db->from('kuranglebihsetor');
		return $this->db->get();
	}

	function getGantiLogam($cabang, $dari)
	{
		$tanggal = explode("-", $dari);
		$bulan 	 = $tanggal[1];
		$tahun 	 = $tanggal[0];
		$mulai   = $tahun . "-" . $bulan . "-" . "01";
		$this->db->where('tgl_logamtokertas >=', $mulai);
		$this->db->where('tgl_logamtokertas <', $dari);
		$this->db->where('kode_cabang', $cabang);
		$this->db->select('SUM(jumlah_logamtokertas) as gantikertas');
		$this->db->from('logamtokertas');
		return $this->db->get();
	}

	function cekNextBulan($cabang, $bulan, $tahun)
	{
		if ($bulan == 12) {
			$bln = 1;
			$thn = $tahun + 1;
		} else {
			$bln = $bulan + 1;
			$thn = $tahun;
		}
		$this->db->order_by('tgl_diterimapusat', 'desc');
		$this->db->limit(1);
		return $this->db->get_where('setoran_pusat', array(
			'omset_bulan' => $bulan, 'omset_tahun' => $thn, 'MONTH(tgl_diterimapusat)' => $bln,
			'YEAR(tgl_diterimapusat)' => $thn, 'kode_cabang' => $cabang
		));
	}

	function cekBeforeBulan($cabang, $bulan, $tahun)
	{
		$bln = $bulan - 1;
		$thn = $tahun;
		$this->db->order_by('tgl_diterimapusat', 'desc');
		$this->db->limit(1);
		return $this->db->get_where('setoran_pusat', array(
			'omset_bulan' => $bulan, 'omset_tahun' => $thn, 'MONTH(tgl_diterimapusat)' => $bln,
			'YEAR(tgl_diterimapusat)' => $thn, 'kode_cabang' => $cabang
		));
	}


	function kasbesarlhp($dari, $sampai, $cabang = null, $salesman = null, $pelanggan = null)
	{

		$this->db->select('historibayar.no_fak_penj,nama_karyawan,tgltransaksi,tglbayar,bayar,bayar as bayarterakhir,girotocash,status_bayar,date_format(historibayar.date_created, "%d %M %Y %H:%i:%s") as date_created, date_format(historibayar.date_updated, "%d %M %Y %H:%i:%s") as date_updated,
			(
				SELECT IFNULL(penjualan.total, 0) - (ifnull(r.totalpf, 0) - ifnull(r.totalgb, 0)) AS totalpiutang
				FROM penjualan
				LEFT JOIN (
					SELECT retur.no_fak_penj AS no_fak_penj,
					sum(retur.subtotal_gb) AS totalgb,
					sum(retur.subtotal_pf) AS totalpf
					FROM
						retur
					GROUP BY
						retur.no_fak_penj
				) r ON (penjualan.no_fak_penj = r.no_fak_penj)
				WHERE penjualan.no_fak_penj = historibayar.no_fak_penj
			) as totalpenjualan,
			(SELECT IFNULL(SUM(bayar),0) FROM historibayar h WHERE h.no_fak_penj = historibayar.no_fak_penj AND h.tglbayar <= historibayar.tglbayar AND h.tglbayar >= penjualan.tgltransaksi) as totalbayar,
			 historibayar.jenisbayar,no_giro,materai,giro.namabank as bankgiro,giro.jumlah as jumlahgiro,transfer.namabank as banktransfer,transfer.jumlah as jumlahtransfer,historibayar.id_karyawan,penjualan.kode_pelanggan,nama_pelanggan');
		$this->db->from('historibayar');
		$this->db->join('giro', 'historibayar.id_giro = giro.id_giro', 'left');
		$this->db->join('transfer', 'historibayar.id_transfer = transfer.id_transfer', 'left');
		$this->db->join('penjualan', 'historibayar.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan', 'penjualan.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tglbayar,historibayar.no_fak_penj', 'ASC');
		$this->db->where('tglbayar >=', $dari);
		$this->db->where('tglbayar <=', $sampai);
		$this->db->where('historibayar.id_giro IS NULL');
		$this->db->where('historibayar.id_transfer IS NULL');
		if ($cabang != "") {

			$this->db->where('karyawan.kode_cabang', $cabang);
		}

		if ($salesman != "") {

			$this->db->where('historibayar.id_karyawan', $salesman);
		}

		if ($pelanggan != "") {
			$this->db->where('penjualan.kode_pelanggan', $pelanggan);
		}


		return $this->db->get();
	}

	function listgirolhp($dari, $sampai, $cabang = null, $salesman = null)
	{

		$this->db->select("giro.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,tgl_giro,no_giro,namabank,jumlah,tglcair,giro.status,tglbayar");
		$this->db->from('giro');
		$this->db->join('penjualan', 'giro.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('historibayar', 'giro.id_giro = historibayar.id_giro', 'left');
		$this->db->where('tgl_giro >=', $dari);
		$this->db->where('tgl_giro <=', $sampai);
		if ($cabang != "") {
			$this->db->where('pelanggan.kode_cabang', $cabang);
		}

		if ($salesman != "") {
			$this->db->where('giro.id_karyawan', $salesman);
		}


		return $this->db->get();
	}


	function listtransferlhp($dari, $sampai, $cabang = null, $salesman = null)
	{

		$this->db->select("transfer.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,tgl_transfer,namabank,jumlah,tglcair,transfer.status,tglbayar");
		$this->db->from('transfer');
		$this->db->join('penjualan', 'transfer.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('historibayar', 'transfer.id_transfer = historibayar.id_transfer', 'left');
		$this->db->where('tgl_transfer >=', $dari);
		$this->db->where('tgl_transfer <=', $sampai);

		if ($cabang != "") {
			$this->db->where('pelanggan.kode_cabang', $cabang);
		}

		if ($salesman != "") {
			$this->db->where('transfer.id_karyawan', $salesman);
		}

		return $this->db->get();
	}

	function netpenjualan($bulan, $tahun, $jenisproduk)
	{
		$awal = $tahun . "-" . $bulan . "-01";
		$akhir = $tahun . "-" . $bulan . "-31";

		$query = "SELECT master_barang.jenis_produk AS jenis_produk, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'TSM' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'TSM' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS TSM, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'BDG' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'BDG' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS BDG, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'SKB' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'SKB' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END)  AS SKB, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'TGL' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'TGL' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS TGL, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'BGR' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'BGR' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS BGR, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'PWT' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'PWT' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS PWT, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'PST' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'PST' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS PST, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'GRT' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'GRT' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS GRT, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'SBY' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'SBY' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS SBY, 
						Sum(CASE 
									WHEN ( karyawan.kode_cabang = 'SMR' 
													AND master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN ( karyawan.kode_cabang = 'SMR' 
													AND master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS SMR 
			FROM   detailpenjualan 
						JOIN penjualan 
							ON ( detailpenjualan.no_fak_penj = penjualan.no_fak_penj ) 
						JOIN karyawan 
							ON ( penjualan.id_karyawan = karyawan.id_karyawan ) 
						JOIN barang 
							ON ( detailpenjualan.kode_barang = barang.kode_barang ) 
						JOIN master_barang 
							ON ( barang.kode_produk = master_barang.kode_produk ) 
			WHERE  penjualan.tgltransaksi BETWEEN '$awal' AND '$akhir' AND jenis_produk ='$jenisproduk'
			GROUP  BY master_barang.jenis_produk ";

		return $this->db->query($query);
	}


	function netretur($bulan, $tahun, $jenisproduk)
	{
		$awal = $tahun . "-" . $bulan . "-01";
		$akhir = $tahun . "-" . $bulan . "-31";
		$query = "SELECT master_barang.jenis_produk AS jenis_produk, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'TSM' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'TSM' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END)  AS TSM, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'BDG' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'BDG' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END) AS BDG, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'SKB' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'SKB' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END)  AS SKB, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'TGL' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'TGL' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END) AS TGL, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'BGR' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'BGR' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END) AS BGR, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'PWT' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'PWT' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END)                   AS PWT, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'PST' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'PST' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END)  AS PST, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'GRT' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'GRT' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END)  AS GRT, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'SBY' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'SBY' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END) AS SBY, 
		Sum(CASE 
					WHEN ( karyawan.kode_cabang = 'SMR' 
								AND master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN ( karyawan.kode_cabang = 'SMR' 
								AND master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END)  AS SMR 
		FROM   detailretur 
					JOIN retur 
						ON ( detailretur.no_retur_penj = retur.no_retur_penj ) 
					JOIN penjualan 
						ON ( retur.no_fak_penj = penjualan.no_fak_penj ) 
					JOIN karyawan 
						ON ( penjualan.id_karyawan = karyawan.id_karyawan ) 
					JOIN barang 
						ON ( detailretur.kode_barang = barang.kode_barang ) 
					JOIN master_barang 
						ON ( barang.kode_produk = master_barang.kode_produk ) 
		WHERE  retur.tglretur  BETWEEN '$awal' AND '$akhir' AND jenis_produk ='$jenisproduk'
					AND retur.jenis_retur = 'pf' 
		GROUP  BY master_barang.jenis_produk ";
		return $this->db->query($query);
	}


	function piutanglebihsatubulan($bulan, $tahun)
	{
		$tanggal = $tahun . "-" . $bulan . "-31";
		$tanggalawal = $tahun . "-" . $bulan . "-01";

		$query = "SELECT 
			sum(
				CASE WHEN cabangbarunew = 'TSM' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS TSM, 
			sum(
				CASE WHEN cabangbarunew = 'BDG' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS BDG, 
			sum(
				CASE WHEN cabangbarunew = 'TGL' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS TGL, 
			sum(
				CASE WHEN cabangbarunew = 'BGR' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS BGR, 
			sum(
				CASE WHEN cabangbarunew = 'PWT' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS PWT, 
			sum(
				CASE WHEN cabangbarunew = 'PST' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS PST, 
			sum(
				CASE WHEN cabangbarunew = 'GRT' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS GRT, 
			sum(
				CASE WHEN cabangbarunew = 'SKB' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS SKB, 
			sum(
				CASE WHEN cabangbarunew = 'SBY' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS SBY, 
			sum(
				CASE WHEN cabangbarunew = 'SMR' THEN ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0) END
			) AS SMR 
		FROM 
			(
				(
					(
						(
							penjualan 
							JOIN pelanggan ON (
								penjualan.kode_pelanggan = pelanggan.kode_pelanggan
							)
						) 
						
						JOIN karyawan ON (
							pelanggan.id_sales = karyawan.id_karyawan
						)
					) 

					LEFT JOIN (
							SELECT pj.no_fak_penj,
							IF(salesbaru IS NULL,pj.id_karyawan,salesbaru) as salesbarunew, karyawan.nama_karyawan as nama_sales,
							IF(cabangbaru IS NULL,karyawan.kode_cabang,cabangbaru) as cabangbarunew
							FROM penjualan pj
							INNER JOIN karyawan ON pj.id_karyawan = karyawan.id_karyawan
							LEFT JOIN (
								SELECT MAX(id_move) as id_move,no_fak_penj,move_faktur.id_karyawan as salesbaru,karyawan.kode_cabang as cabangbaru
								FROM move_faktur
								INNER JOIN karyawan ON move_faktur.id_karyawan = karyawan.id_karyawan
								WHERE tgl_move <= '$tanggal'
								GROUP BY no_fak_penj,move_faktur.id_karyawan,karyawan.kode_cabang
							) move_fak ON (pj.no_fak_penj = move_fak.no_fak_penj)
							
					) pjmove ON (penjualan.no_fak_penj = pjmove.no_fak_penj)
					LEFT JOIN (
						SELECT 
							historibayar.no_fak_penj AS no_fak_penj, 
							sum(historibayar.bayar) AS jmlbayar 
						FROM 
							historibayar 
						WHERE 
							historibayar.tglbayar <= '$tanggal' 
						GROUP BY 
							historibayar.no_fak_penj
					) hblalu ON (
						penjualan.no_fak_penj = hblalu.no_fak_penj
					)
				) 
				LEFT JOIN (
					SELECT 
						retur.no_fak_penj AS no_fak_penj, 
						sum(retur.total) AS total 
					FROM 
						retur 
					WHERE 
						retur.tglretur <= '$tanggal' 
					GROUP BY 
						retur.no_fak_penj
				) retur ON (
					penjualan.no_fak_penj = retur.no_fak_penj
				)
			) 
		WHERE 
			penjualan.jenisbayar <> 'tunai' 
			AND penjualan.tgltransaksi <= '$tanggal' 
			AND ifnull(penjualan.total, 0) - ifnull(retur.total, 0) <> ifnull(hblalu.jmlbayar, 0) 
			AND to_days('$tanggal') - to_days(penjualan.tgltransaksi) > 30
		";

		return $this->db->query($query);
	}

	function costratiobiaya($bulan, $tahun)
	{
		$awal = $tahun . "-" . $bulan . "-01";
		$akhir = $tahun . "-" . $bulan . "-31";
		$query = "SELECT costratio_biaya.kode_akun,nama_akun,
		SUM(IF(kode_cabang='TSM',jumlah,0)) as TSM,
		SUM(IF(kode_cabang='BDG',jumlah,0)) as BDG,
		SUM(IF(kode_cabang='SKB',jumlah,0)) as SKB,
		SUM(IF(kode_cabang='TGL',jumlah,0)) as TGL,
		SUM(IF(kode_cabang='BGR',jumlah,0)) as BGR,
		SUM(IF(kode_cabang='PWT',jumlah,0)) as PWT,
		SUM(IF(kode_cabang='PST',jumlah,0)) as PST,
		SUM(IF(kode_cabang='GRT',jumlah,0)) as GRT,
		SUM(IF(kode_cabang='SBY',jumlah,0)) as SBY,
		SUM(IF(kode_cabang='SMR',jumlah,0)) as SMR
		FROM costratio_biaya
		LEFT JOIN coa ON costratio_biaya.kode_akun = coa.kode_akun
		WHERE tgl_transaksi BETWEEN '$awal' AND '$akhir' AND LEFT(costratio_biaya.kode_akun,3)='6-1' 
		OR tgl_transaksi BETWEEN '$awal' AND '$akhir' AND LEFT(costratio_biaya.kode_akun,3)='6-2'
		GROUP BY costratio_biaya.kode_akun,nama_akun";
		return $this->db->query($query);
	}

	function costratiobiayaCabang($bulan, $tahun, $cabang)
	{
		$awal = $tahun . "-" . $bulan . "-01";
		$akhir = $tahun . "-" . $bulan . "-31";
		$query = "SELECT costratio_biaya.kode_akun,nama_akun,
		SUM(jumlah) as jumlahbiaya
		FROM costratio_biaya
		LEFT JOIN coa ON costratio_biaya.kode_akun = coa.kode_akun
		WHERE tgl_transaksi BETWEEN '$awal' AND '$akhir' AND kode_cabang ='$cabang' AND LEFT(costratio_biaya.kode_akun,3)='6-1' OR tgl_transaksi BETWEEN '$awal' AND '$akhir' AND kode_cabang ='$cabang' AND LEFT(costratio_biaya.kode_akun,3)='6-2'
		GROUP BY costratio_biaya.kode_akun,nama_akun";
		return $this->db->query($query);
	}

	function netpenjualanCabang($bulan, $tahun, $jenisproduk, $cabang)
	{
		$awal = $tahun . "-" . $bulan . "-01";
		$akhir = $tahun . "-" . $bulan . "-31";

		$query = "SELECT master_barang.jenis_produk AS jenis_produk, 
						Sum(CASE 
									WHEN ( master_barang.jenis_produk = 'AIDA' ) THEN 
									detailpenjualan.subtotal - penjualan.potaida - penjualan.potisaida 
									- 
									penjualan.penyaida 
									WHEN (  master_barang.jenis_produk = 'SWAN' ) THEN 
									detailpenjualan.subtotal - penjualan.potswan - penjualan.potisswan 
									- 
									penjualan.penyswan 
								END) AS netpenjualan
						
			FROM   detailpenjualan 
						JOIN penjualan 
							ON ( detailpenjualan.no_fak_penj = penjualan.no_fak_penj ) 
						JOIN karyawan 
							ON ( penjualan.id_karyawan = karyawan.id_karyawan ) 
						JOIN barang 
							ON ( detailpenjualan.kode_barang = barang.kode_barang ) 
						JOIN master_barang 
							ON ( barang.kode_produk = master_barang.kode_produk ) 
			WHERE  penjualan.tgltransaksi BETWEEN '$awal' AND '$akhir' AND jenis_produk ='$jenisproduk' AND karyawan.kode_cabang ='$cabang'
			GROUP  BY master_barang.jenis_produk ";

		return $this->db->query($query);
	}

	function netreturCabang($bulan, $tahun, $jenisproduk, $cabang)
	{
		$awal = $tahun . "-" . $bulan . "-01";
		$akhir = $tahun . "-" . $bulan . "-31";
		$query = "SELECT master_barang.jenis_produk AS jenis_produk, 
		Sum(CASE 
					WHEN (master_barang.jenis_produk = 'AIDA' ) THEN 
					detailretur.subtotal 
					WHEN (  master_barang.jenis_produk = 'SWAN' ) THEN 
					detailretur.subtotal 
				END)  AS netretur
		FROM   detailretur 
					JOIN retur 
						ON ( detailretur.no_retur_penj = retur.no_retur_penj ) 
					JOIN penjualan 
						ON ( retur.no_fak_penj = penjualan.no_fak_penj ) 
					JOIN karyawan 
						ON ( penjualan.id_karyawan = karyawan.id_karyawan ) 
					JOIN barang 
						ON ( detailretur.kode_barang = barang.kode_barang ) 
					JOIN master_barang 
						ON ( barang.kode_produk = master_barang.kode_produk ) 
		WHERE  retur.tglretur  BETWEEN '$awal' AND '$akhir' AND jenis_produk ='$jenisproduk'
					AND retur.jenis_retur = 'pf'  AND karyawan.kode_cabang = '$cabang'
		GROUP  BY master_barang.jenis_produk ";
		return $this->db->query($query);
	}

	function piutanglebihsatubulanCabang($bulan, $tahun, $cabang)
	{
		$tanggal = $tahun . "-" . $bulan . "-31";
		$query = "SELECT 
			sum(ifnull(penjualan.total, 0) - ifnull(retur.total, 0) - ifnull(hblalu.jmlbayar, 0)) AS jumlah
		FROM 
			(
				(
					(
						(
							penjualan 
							JOIN pelanggan ON (
								penjualan.kode_pelanggan = pelanggan.kode_pelanggan
							)
						) 
						JOIN karyawan ON (
							pelanggan.id_sales = karyawan.id_karyawan
						)
					) 

					LEFT JOIN (
							SELECT pj.no_fak_penj,
							IF(salesbaru IS NULL,pj.id_karyawan,salesbaru) as salesbarunew, karyawan.nama_karyawan as nama_sales,
							IF(cabangbaru IS NULL,karyawan.kode_cabang,cabangbaru) as cabangbarunew
							FROM penjualan pj
							INNER JOIN karyawan ON pj.id_karyawan = karyawan.id_karyawan
							LEFT JOIN (
								SELECT MAX(id_move) as id_move,no_fak_penj,move_faktur.id_karyawan as salesbaru,karyawan.kode_cabang as cabangbaru
								FROM move_faktur
								INNER JOIN karyawan ON move_faktur.id_karyawan = karyawan.id_karyawan
								WHERE tgl_move <= '$tanggal'
								GROUP BY no_fak_penj,move_faktur.id_karyawan,karyawan.kode_cabang
							) move_fak ON (pj.no_fak_penj = move_fak.no_fak_penj)
							
					) pjmove ON (penjualan.no_fak_penj = pjmove.no_fak_penj)
					LEFT JOIN (
						SELECT 
							historibayar.no_fak_penj AS no_fak_penj, 
							sum(historibayar.bayar) AS jmlbayar 
						FROM 
							historibayar 
						WHERE 
							historibayar.tglbayar <= '$tanggal' 
						GROUP BY 
							historibayar.no_fak_penj
					) hblalu ON (
						penjualan.no_fak_penj = hblalu.no_fak_penj
					)
				) 
				LEFT JOIN (
					SELECT 
						retur.no_fak_penj AS no_fak_penj, 
						sum(retur.total) AS total 
					FROM 
						retur 
					WHERE 
						retur.tglretur <= '$tanggal' 
					GROUP BY 
						retur.no_fak_penj
				) retur ON (
					penjualan.no_fak_penj = retur.no_fak_penj
				)
			) 
		WHERE 
			penjualan.jenisbayar <> 'tunai' 
			AND penjualan.tgltransaksi <= '$tanggal' 
			AND ifnull(penjualan.total, 0) - ifnull(retur.total, 0) <> ifnull(hblalu.jmlbayar, 0) 
			AND to_days('$tanggal') - to_days(penjualan.tgltransaksi) > 30 AND cabangbarunew = '$cabang'
		";

		return $this->db->query($query);
	}

	function rekapkendaraan($dari, $sampai, $kendaraan)
	{
		$query = "SELECT detail_dpb.kode_produk,isipcsdus,ROUND(SUM(jml_pengambilan),2) as jml_pengambilan,
		ROUND(SUM(jml_pengembalian),2) as jml_pengembalian, 
		jmlpenjualan,jmlgantibarang,jmlplhk,jmlpromosi,jmlttr,
		dpb.no_kendaraan
		FROM detail_dpb
		
		INNER JOIN dpb ON detail_dpb.no_dpb = dpb.no_dpb
		LEFT JOIN master_barang ON detail_dpb.kode_produk = master_barang.kode_produk
		LEFT JOIN (SELECT kode_produk,
		ROUND(SUM(IF(jenis_mutasi = 'PENJUALAN',jumlah,0)),2) as jmlpenjualan,
		ROUND(SUM(IF(jenis_mutasi = 'PL HUTANG KIRIM',jumlah,0)),2) as jmlplhk,
		ROUND(SUM(IF(jenis_mutasi = 'PROMOSI',jumlah,0)),2) as jmlpromosi,
		ROUND(SUM(IF(jenis_mutasi = 'TTR',jumlah,0)),2) as jmlttr,
		ROUND(SUM(IF(jenis_mutasi = 'GANTI BARANG',jumlah,0)),2) as jmlgantibarang,
		ROUND(SUM(IF(jenis_mutasi = 'RETUR',jumlah,0)),2) as jmlretur,
		ROUND(SUM(IF(jenis_mutasi = 'PL TTR',jumlah,0)),2) as jmlplttr,
		ROUND(SUM(IF(jenis_mutasi = 'HUTANG KIRIM',jumlah,0)),2) as jmlhk,
		no_kendaraan
		FROM detail_mutasi_gudang_cabang
		INNER JOIN mutasi_gudang_cabang ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
		INNER JOIN dpb ON mutasi_gudang_cabang.no_dpb = dpb.no_dpb
		WHERE tgl_mutasi_gudang_cabang BETWEEN '$dari' AND '$sampai' AND no_kendaraan = '$kendaraan' 
		GROUP BY kode_produk,no_kendaraan) penjualan ON (detail_dpb.kode_produk = penjualan.kode_produk)
	
		WHERE tgl_pengambilan BETWEEN '$dari' AND '$sampai' AND dpb.no_kendaraan = '$kendaraan'
		GROUP BY kode_produk,dpb.no_kendaraan";

		return $this->db->query($query);
	}

	function rekapkasbesarsales($dari, $sampai, $jenisbayar, $cabang)
	{
		if ($jenisbayar != "") {

			$jenisbayar = "AND historibayar.jenisbayar = '" . $jenisbayar . "'";
		}

		if ($cabang != "") {

			$cabang = "AND karyawan.kode_cabang = '" . $cabang . "'";
		}

		$query = "SELECT historibayar.id_karyawan,nama_karyawan,SUM(bayar) as totalkasbesar FROM historibayar
				INNER JOIN penjualan ON historibayar.no_fak_penj = penjualan.no_fak_penj
				INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
				INNER JOIN karyawan  ON historibayar.id_karyawan = karyawan.id_karyawan
				INNER JOIN cabang ON karyawan.kode_cabang = cabang.kode_cabang
				WHERE tglbayar BETWEEN '$dari' AND '$sampai'"
			. $jenisbayar
			. $cabang
			. "
				GROUP BY
				historibayar.id_karyawan,
				nama_karyawan

				";

		return $this->db->query($query);
	}

	function historikendaraan($dari, $sampai, $nokendaraan)
	{
		$query = "SELECT dpb.tgl_pengambilan, no_kendaraan,COUNT(no_dpb) as jmlpengambilan
		FROM dpb 
		WHERE no_kendaraan = '$nokendaraan' AND tgl_pengambilan BETWEEN '$dari' AND '$sampai'
		GROUP BY tgl_pengambilan";
		return $this->db->query($query);
	}
}
