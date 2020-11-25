<?php

class Model_komisi extends CI_Model{
  
  function getPenerimakomisi($cabang="")
  {
   
    $this->db->where('kode_cabang',$cabang);
    
    $this->db->join('jabatan','komisi_penerima.kode_jabatan = jabatan.kode_jabatan');
    return $this->db->get('komisi_penerima');
  }

  function getJabatan()
  {
    $this->db->order_by('order','asc');
    return $this->db->get('jabatan');
  }
  
  function getLastNik($cabang)
  {
    $qsb 						    = "SELECT nik FROM komisi_penerima
                           WHERE kode_cabang='$cabang' ORDER BY nik DESC LIMIT 1";
    $sb							    = $this->db->query($qsb)->row_array();
    $nomor_terakhir 		= $sb['nik'];
    $kode_setoranpusat 	= buatkode($nomor_terakhir,$cabang,4);
    return $kode_setoranpusat;
  }
  function inputpenerima()
  {
   $nik = $this->input->post('nik');
   $namalengkap = $this->input->post('namalengkap');
   $cbg = $this->input->post('cbg');
   $jabatan = $this->input->post('jabatan');
   $sales = $this->input->post('salesman');

   $data = [
    'nik' => $nik,
    'nama_lengkap' => $namalengkap,
    'kode_cabang' => $cbg,
    'kode_jabatan' => $jabatan,
    'id_sales' => $sales,
    'status' =>'1'
   ];

   $simpan = $this->db->insert('komisi_penerima',$data);
   if($simpan)
   {
    $this->session->set_flashdata('msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
        </div>');
    redirect('komisi/penerimakomisi');
   }else{
      $this->session->set_flashdata('msg',
      '<div class="alert bg-pink alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Di Simpan !
        </div>');
      redirect('komisi/penerimakomisi');
   }
  }

  function getPenerimaID($nik)
  {
    return $this->db->get_where('komisi_penerima',array('nik'=>$nik));
  }

  function updatepenerima()
  {
   $nik = $this->input->post('nik');
   $namalengkap = $this->input->post('namalengkap');
   $cbg = $this->input->post('cbg');
   $jabatan = $this->input->post('jabatan');
   $sales = $this->input->post('salesman');

   $data = [
    // 'nik' => $nik,
    'nama_lengkap' => $namalengkap,
    'kode_cabang' => $cbg,
    'kode_jabatan' => $jabatan,
    'id_sales' => $sales,
    'status' =>'1'
   ];

   $simpan = $this->db->update('komisi_penerima',$data,array('nik'=>$nik));
   if($simpan)
   {
    $this->session->set_flashdata('msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
        </div>');
    redirect('komisi/penerimakomisi');
   }else{
      $this->session->set_flashdata('msg',
      '<div class="alert bg-pink alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Di Simpan !
        </div>');
      redirect('komisi/penerimakomisi');
   }
  }

  function hapuspenerima($nik)
  {

   $hapus = $this->db->delete('komisi_penerima',array('nik'=>$nik));
   if($hapus)
   {
    $this->session->set_flashdata('msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
        </div>');
    redirect('komisi/penerimakomisi');
   }else{
      $this->session->set_flashdata('msg',
      '<div class="alert bg-pink alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Di Hapus !
        </div>');
      redirect('komisi/penerimakomisi');
   }
  }

  function getTargetPerBulan($cabang,$bulan,$tahun)
  {
    $query = "SELECT komisi_penerima.nik,nama_lengkap,nama_jabatan,kode_cabang,target_kuantitas,target_cashin, 
    target_collection
    FROM komisi_penerima
    INNER JOIN jabatan ON komisi_penerima.kode_jabatan = jabatan.kode_jabatan
    LEFT JOIN (SELECT nik,bulan,tahun,SUM(IF(kode_kriteria='K001',jml_target,0)) as target_kuantitas,
    SUM(IF(kode_kriteria='K002',jml_target,0)) as target_cashin,
    SUM(IF(kode_kriteria='K003',jml_target,0)) as target_collection
    FROM komisi_target WHERE bulan ='$bulan' AND tahun='$tahun' GROUP BY nik,bulan,tahun)
    as target ON (komisi_penerima.nik=target.nik) WHERE kode_cabang='$cabang'";

    return $this->db->query($query);
  }

  function updatetarget()
  {
    $nik = $this->input->post('nik');
    $kodekriteria = $this->input->post('kodekriteria');
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $jmltarget = $this->input->post('jmltarget');
    if(!empty($jmltarget)){
      $cek = $this->db->get_where('komisi_target',array('nik'=>$nik,'bulan'=>$bulan,'tahun'=>$tahun,'kode_kriteria'=>$kodekriteria))->num_rows();
      if($cek > 0)
      {
        $data = [
          'jml_target' => $jmltarget
        ];
        $this->db->update('komisi_target',$data,array('nik'=>$nik,'bulan'=>$bulan,'tahun'=>$tahun,'kode_kriteria'=>$kodekriteria));
      }else{
        $data = [
          'nik'   => $nik,
          'kode_kriteria' => $kodekriteria,
          'bulan' => $bulan,
          'tahun' => $tahun,
          'jml_target' => $jmltarget
        ];

        $this->db->insert('komisi_target',$data);
      }
    }else{
      $this->db->delete('komisi_target',array('nik'=>$nik,'bulan'=>$bulan,'tahun'=>$tahun,'kode_kriteria'=>$kodekriteria));
    }
  }

  function simpanrange()
  {
    $kode_range = $this->input->post('kode_range');
    $cabang = $this->input->post('cabang');
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');

    $data = [
      'kode_range_komisi' => $kode_range,
      'kode_cabang' => $cabang,
      'bulan' => $bulan,
      'tahun'=> $tahun
    ];

    $cek = $this->db->get_where('komisi_range',array('kode_range_komisi'=>$kode_range))->num_rows();
    if(empty($cek))
    {
      $this->db->insert('komisi_range',$data);
    }
  }

  function updaterange()
  {
    $kode_range = $this->input->post('kode_range');
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $kacab = $this->input->post('kacab');
    $spv = $this->input->post('spv');
    $sales = $this->input->post('sales');
    $driverhelper = $this->input->post('driverhelper');
    $kepalagudang = $this->input->post('kepalagudang');
    $gudang = $this->input->post('gudang');
    $cek = $this->db->get_where('komisi_range_detail',array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai))->num_rows();
    if($cek > 0)
    {
      $data = [
        'kacab' => $kacab,
        'spv' => $spv,
        'sales' => $sales,
        'driverhelper' => $driverhelper,
        'kepalagudang' => $kepalagudang,
        'gudang' => $gudang
      ];
      $this->db->update('komisi_range_detail',$data,array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai));
    }else{
      $data = [
        'kode_range_komisi' => $kode_range,
        'dari' => $dari,
        'sampai' => $sampai,
        'kacab' => $kacab,
        'spv' => $spv,
        'sales' => $sales,
        'driverhelper' => $driverhelper,
        'kepalagudang' => $kepalagudang,
        'gudang' => $gudang
      ];

      $this->db->insert('komisi_range_detail',$data);
    }
   
  }

  function updaterasiokacab(){
    $kode_range = $this->input->post('kode_range');
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $kacab = $this->input->post('kacab');
    $cek = $this->db->get_where('komisi_range_detail',array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai))->num_rows();
    if($cek > 0)
    {
      $data = [
        'kacab' => $kacab
      ];
      $this->db->update('komisi_range_detail',$data,array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai));
    }else{
      $data = [
        'kode_range_komisi' => $kode_range,
        'dari' => $dari,
        'sampai' => $sampai,
        'kacab' => $kacab
      ];

      $this->db->insert('komisi_range_detail',$data);
    }
  }

  function updaterasiospv()
  {
    $kode_range = $this->input->post('kode_range');
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $spv = $this->input->post('spv');
    $cek = $this->db->get_where('komisi_range_detail',array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai))->num_rows();
    if($cek > 0)
    {
      $data = [
        'spv' => $spv
      ];
      $this->db->update('komisi_range_detail',$data,array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai));
    }else{
      $data = [
        'kode_range_komisi' => $kode_range,
        'dari' => $dari,
        'sampai' => $sampai,
        'spv' => $spv
      ];

      $this->db->insert('komisi_range_detail',$data);
    }
  }

  function updaterasiosales()
  {
    $kode_range = $this->input->post('kode_range');
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $sales = $this->input->post('sales');
    $cek = $this->db->get_where('komisi_range_detail',array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai))->num_rows();
    if($cek > 0)
    {
      $data = [
        'sales' => $sales
      ];
      $this->db->update('komisi_range_detail',$data,array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai));
    }else{
      $data = [
        'kode_range_komisi' => $kode_range,
        'dari' => $dari,
        'sampai' => $sampai,
        'sales' => $sales
      ];

      $this->db->insert('komisi_range_detail',$data);
    }
  }

  function updaterasiodriverhelper()
  {
    $kode_range = $this->input->post('kode_range');
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $driverhelper = $this->input->post('driverhelper');
    $cek = $this->db->get_where('komisi_range_detail',array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai))->num_rows();
    if($cek > 0)
    {
      $data = [
        'driverhelper' => $driverhelper
      ];
      $this->db->update('komisi_range_detail',$data,array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai));
    }else{
      $data = [
        'kode_range_komisi' => $kode_range,
        'dari' => $dari,
        'sampai' => $sampai,
        'driverhelper' => $driverhelper
      ];

      $this->db->insert('komisi_range_detail',$data);
    }
  }

  function updaterasiokepalagudang()
  {
    $kode_range = $this->input->post('kode_range');
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $kepalagudang = $this->input->post('kepalagudang');
    $cek = $this->db->get_where('komisi_range_detail',array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai))->num_rows();
    if($cek > 0)
    {
      $data = [
        'kepalagudang' => $kepalagudang
      ];
      $this->db->update('komisi_range_detail',$data,array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai));
    }else{
      $data = [
        'kode_range_komisi' => $kode_range,
        'dari' => $dari,
        'sampai' => $sampai,
        'kepalagudang' => $kepalagudang
      ];

      $this->db->insert('komisi_range_detail',$data);
    }
  }

  function updaterasiogudang()
  {
    $kode_range = $this->input->post('kode_range');
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $gudang = $this->input->post('gudang');
    $cek = $this->db->get_where('komisi_range_detail',array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai))->num_rows();
    if($cek > 0)
    {
      $data = [
        'gudang' => $gudang
      ];
      $this->db->update('komisi_range_detail',$data,array('kode_range_komisi'=>$kode_range,'dari'=>$dari,'sampai'=>$sampai));
    }else{
      $data = [
        'kode_range_komisi' => $kode_range,
        'dari' => $dari,
        'sampai' => $sampai,
        'gudang' => $gudang
      ];

      $this->db->insert('komisi_range_detail',$data);
    }
  }

  function resetrasio($kode_range)
  {
    $this->db->delete('komisi_range_detail',array('kode_range_komisi'=>$kode_range));
  }

  function getKriteria($cbg,$bln,$thn)
  {
    $query = "SELECT komisi_kriteria.kode_kriteria,nama_kriteria,poin,persentase_min FROM komisi_kriteria
    LEFT JOIN (SELECT kode_kriteria,poin,persentase_min FROM komisi_setkriteria_detail
    INNER JOIN komisi_setkriteria ON komisi_setkriteria_detail.kode_setkriteria = komisi_setkriteria.kode_setkriteria 
    WHERE bulan ='$bln' AND tahun='$thn' AND kode_cabang='$cbg')
    as setkriteria ON (komisi_kriteria.kode_kriteria=setkriteria.kode_kriteria)";
    return $this->db->query($query);
  }

  function simpankriteriakomisi()
  {
    $kode_setkriteria = $this->input->post('kode_setkriteria');
    $cabang = $this->input->post('cabang');
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');

    $data = [
      'kode_setkriteria' => $kode_setkriteria,
      'kode_cabang' => $cabang,
      'bulan' => $bulan,
      'tahun'=> $tahun
    ];

    $cek = $this->db->get_where('komisi_setkriteria',array('kode_setkriteria'=>$kode_setkriteria))->num_rows();
    if(empty($cek))
    {
      $this->db->insert('komisi_setkriteria',$data);
    }
  }

  function updatepoinkriteria(){
    $kode_setkriteria = $this->input->post('kode_setkriteria');
    $kode_kriteria = $this->input->post('kode_kriteria');
    $poin = $this->input->post('poin');
    $ceksetkriteria = $this->db->get_where('komisi_setkriteria',array('kode_setkriteria'=>$kode_setkriteria))->num_rows();
    if($ceksetkriteria > 0){
      $cek = $this->db->get_where('komisi_setkriteria_detail',array('kode_setkriteria'=>$kode_setkriteria,'kode_kriteria'=>$kode_kriteria))->num_rows();
      if($cek > 0)
      {
        $data = [
          'poin' => $poin
        ];
        $this->db->update('komisi_setkriteria_detail',$data,array('kode_setkriteria'=>$kode_setkriteria,'kode_kriteria'=>$kode_kriteria));
      }else{
        $data = [
          'kode_setkriteria' => $kode_setkriteria,
          'kode_kriteria' => $kode_kriteria,
          'poin' => $poin
        ];

        $this->db->insert('komisi_setkriteria_detail',$data);
      }
      return 1;
    }else{
      return 0;
    }
  }

  function updatepersentasekriteria(){
    $kode_setkriteria = $this->input->post('kode_setkriteria');
    $kode_kriteria = $this->input->post('kode_kriteria');
    $persentase_min = $this->input->post('persentase_min');
    $ceksetkriteria = $this->db->get_where('komisi_setkriteria',array('kode_setkriteria'=>$kode_setkriteria))->num_rows();
    if($ceksetkriteria > 0){
      $cek = $this->db->get_where('komisi_setkriteria_detail',array('kode_setkriteria'=>$kode_setkriteria,'kode_kriteria'=>$kode_kriteria))->num_rows();
      if($cek > 0)
      {
        $data = [
          'persentase_min' => $persentase_min
        ];
        $this->db->update('komisi_setkriteria_detail',$data,array('kode_setkriteria'=>$kode_setkriteria,'kode_kriteria'=>$kode_kriteria));
      }else{
        $data = [
          'kode_setkriteria' => $kode_setkriteria,
          'kode_kriteria' => $kode_kriteria,
          'persentase_min' => $persentase_min
        ];

        $this->db->insert('komisi_setkriteria_detail',$data);
      }
      return 1;
    }else{
      return 0;
    }
  }

  function resetsetkriteria($kode_setkriteria)
  {
    $this->db->delete('komisi_setkriteria_detail',array('kode_setkriteria'=>$kode_setkriteria));
  }

  

}