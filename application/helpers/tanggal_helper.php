<?php
function DateToIndo2($date2) { // fungsi atau method untuk mengubah tanggal ke format indonesia
   // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
		$BulanIndo2 = array("Januari", "Februari", "Maret",
						   "April", "Mei", "Juni",
						   "Juli", "Agustus", "September",
						   "Oktober", "November", "Desember");
	
		$tahun2 = substr($date2, 0, 4); // memisahkan format tahun menggunakan substring
		$bulan2 = substr($date2, 5, 2); // memisahkan format bulan menggunakan substring
		$tgl2   = substr($date2, 8, 2); // memisahkan format tanggal menggunakan substring
		
		$result = $tgl2 . " " . $BulanIndo2[(int)$bulan2-1] . " ". $tahun2;
		return($result);
}
	
	//echo(DateToIndo("2011-08-25")); //Akan menghasilkan 25 Agustus 2011
?>