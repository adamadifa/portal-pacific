<?php

class Model_setting extends CI_Model
{

  function getDataTutupLaporan($tahun)
  {
    if ($tahun != "") {
      $this->db->where('tahun', $tahun);
    }
    return $this->db->get('tutup_laporan');
  }

  function inserttutuplaporan()
  {
    $tanggal = $this->input->post('tgl_penutupan');
    $bulan = $this->input->post('bulan');
    if ($bulan < 9) {
      $nol = "0";
    } else {
      $nol = "";
    }
    $tahun = $this->input->post('tahun');
    $jenis_laporan = $this->input->post('jenis_laporan');
    $DataTerakhir = $this->db->query("SELECT kode_tutuplaporan FROM tutup_laporan WHERE bulan ='$bulan' AND tahun='$tahun' ORDER BY kode_tutuplaporan DESC LIMIT 1")->row_array();
    $nomorterakhir = $DataTerakhir['kode_tutuplaporan'];
    $kode = $tahun . $nol . $bulan;
    $kodelaporan = buatkode($nomorterakhir, $kode, 2);
    // echo $kodelaporan;
    // die;
    $data = [
      'kode_tutuplaporan' => $kodelaporan,
      'bulan' => $bulan,
      'tahun' => $tahun,
      'jenis_laporan' => $jenis_laporan,
      'tgl_penutupan' => $tanggal,
      'status' => 1
    ];

    $simpan = $this->db->insert('tutup_laporan', $data);
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="fa fa-check"></i> Data Berhasil di Simpan !
			</div>'
      );
      redirect('setting/tutuplaporan');
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="fa fa-check"> Gagal di Simpan !
			</div>'
      );
      redirect('setting/tutuplaporan');
    }
  }


  function bukalaporan($kodelaporan)
  {


    $data = [
      'status' => 0
    ];

    $simpan = $this->db->update('tutup_laporan', $data, array('kode_tutuplaporan' => $kodelaporan));
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="fa fa-check"> Data Berhasil di Simpan !
			</div>'
      );
      redirect('setting/tutuplaporan');
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="fa fa-check"> Gagal di Simpan !
			</div>'
      );
      redirect('setting/tutuplaporan');
    }
  }


  function tutuplaporan($kodelaporan)
  {

    $data = [
      'status' => 1
    ];

    $simpan = $this->db->update('tutup_laporan', $data, array('kode_tutuplaporan' => $kodelaporan));
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="fa fa-check"> Data Berhasil di Simpan !
			</div>'
      );
      redirect('setting/tutuplaporan');
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="fa fa-check"> Gagal di Simpan !
			</div>'
      );
      redirect('setting/tutuplaporan');
    }
  }


  function cektutuplaporan($tanggal, $jenis)
  {
    $tgl = explode("-", $tanggal);
    $tahun = $tgl[0];
    $bulan = $tgl[1];

    return $this->db->get_where('tutup_laporan', array('tahun' => $tahun, 'bulan' => $bulan, 'status' => 1, 'jenis_laporan' => $jenis));
  }
}
