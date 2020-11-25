<?php

class Model_produksi extends CI_Model{

  function jsonBarang(){
    $this->datatables->select('kode_barang,nama_barang,jenis_barang,satuan,kode_kategori,kode_dept,status');
    $this->datatables->from('master_barang_produksi');
    $this->datatables->add_column('view', '<a href="#" data-kode="$1" class="btn bg-green btn-xs waves-effect edit">Edit</a> <a href="#"  data-toggle="modal" data-href="hapusbarang/$1" class="btn bg-red btn-xs waves-effect hapus">Hapus</a>', 'kode_barang');
    return $this->datatables->generate();
  }

  function getBarang($kodebarang)
  {
    return $this->db->get_where('master_barang_produksi',array('kode_barang'=>$kodebarang));

  } 

  function insert_barang()
  {
    $kodebarang  = $this->input->post('kodebarang');
    $namabarang  = $this->input->post('nama_barang');
    $satuan      = $this->input->post('satuan');
    $jenisbarang = $this->input->post('jenis_barang');
    $kode_kategori = $this->input->post('kode_kategori');
    $departemen  = $this->input->post('departemen');

    $data = array(
      'kode_barang'   => $kodebarang,
      'nama_barang'   => $namabarang,
      'satuan'        => $satuan,
      'jenis_barang'  => 'Produksi',
      'kode_kategori' => $kode_kategori,
      'status'        => 'Aktif',
      'kode_dept'     => 'PRD'
    );

    $cek = $this->db->get_where('master_barang_produksi',array('kode_barang'=>$kodebarang))->num_rows();
    if(empty($cek))
    {
      $simpan = $this->db->insert('master_barang_produksi',$data);
      if($simpan)
      {
        $this->session->set_flashdata('msg',
          '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
          </div>');
        redirect('produksi/barang');
      }
    }else{
      $this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Kode Barang Sudah Ada !
        </div>');
      redirect('produksi/barang');
    }
  }

  function update_barang()
  {
    $kodebarang     = $this->input->post('kodebarang');
    $namabarang     = $this->input->post('nama_barang');
    $satuan         = $this->input->post('satuan');
    $jenisbarang    = $this->input->post('jenis_barang');
    $departemen     = $this->input->post('departemen');
    $kode_kategori  = $this->input->post('kode_kategori');
    $status         = $this->input->post('status');

    $data = array(
      'nama_barang'   => $namabarang,
      'satuan'        => $satuan,
      'kode_kategori' => $kode_kategori,
      'status'        => $status
    );


    $simpan = $this->db->update('master_barang_produksi',$data,array('kode_barang'=>$kodebarang));
    if($simpan)
    {
      $this->session->set_flashdata('msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
        </div>');
      redirect('produksi/barang');
    }

  }

  function hapuspengeluaran(){

    $nobukti    = str_replace(".","/",$this->uri->segment(3));
    $this->db->query("DELETE FROM pengeluaran_gp WHERE nobukti_pengeluaran = '$nobukti' ");
    $this->db->query("DELETE FROM detail_pengeluaran_gp WHERE nobukti_pengeluaran = '$nobukti' ");

  }

  function getdetailsaldo($bulan,$tahun){

    if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
    
    $query = "SELECT 
    master_barang_produksi.kode_barang,
    master_barang_produksi.nama_barang,
    gm.qtypemasukan,
    gk.qtypengeluaran,
    sa.qtysaldoawal

    FROM master_barang_produksi

    LEFT JOIN (SELECT saldoawal_gp_detail.kode_barang,SUM( qty ) AS qtysaldoawal FROM saldoawal_gp_detail 
    INNER JOIN saldoawal_gp ON saldoawal_gp.kode_saldoawal=saldoawal_gp_detail.kode_saldoawal
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY saldoawal_gp_detail.kode_barang ) sa ON (master_barang_produksi.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT detail_pemasukan_gp.kode_barang,SUM( qty ) AS qtypemasukan FROM 
    detail_pemasukan_gp 
    INNER JOIN pemasukan_gp ON detail_pemasukan_gp.nobukti_pemasukan = pemasukan_gp.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan_gp.kode_barang) gm ON (master_barang_produksi.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran_gp.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran_gp 
    INNER JOIN pengeluaran_gp ON detail_pengeluaran_gp.nobukti_pengeluaran = pengeluaran_gp.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran_gp.kode_barang) gk ON (master_barang_produksi.kode_barang = gk.kode_barang)

    WHERE master_barang_produksi.status = 'Aktif' 
    GROUP BY 
    master_barang_produksi.kode_barang,
    master_barang_produksi.nama_barang,
    gm.qtypemasukan,
    gk.qtypengeluaran,
    sa.qtysaldoawal
    ";
    return $this->db->query($query);

  }


  function getDetailopname($bulan,$tahun){

    if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
    
    $query = "SELECT 
    master_barang_produksi.kode_barang,
    master_barang_produksi.nama_barang,    
    sa.saldoawal,
    op.opname,
    gm.gudang,
    gm.seasoning,
    gm.trial,
    gk.pemakaian,
    gk.retur,
    gk.lainnya

    FROM master_barang_produksi

    LEFT JOIN (SELECT saldoawal_gp_detail.kode_barang,SUM( qty ) AS saldoawal FROM saldoawal_gp_detail 
    INNER JOIN saldoawal_gp ON saldoawal_gp.kode_saldoawal=saldoawal_gp_detail.kode_saldoawal
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY saldoawal_gp_detail.kode_barang ) sa ON (master_barang_produksi.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT opname_gp_detail.kode_barang,SUM( qty ) AS opname FROM opname_gp_detail 
    INNER JOIN opname_gp ON opname_gp.kode_opname=opname_gp_detail.kode_opname
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY opname_gp_detail.kode_barang ) op ON (master_barang_produksi.kode_barang = op.kode_barang)

    LEFT JOIN (SELECT 
    detail_pemasukan_gp.kode_barang,
    SUM( IF( kode_dept = 'Gudang' , qty ,0 )) AS gudang,
    SUM( IF( kode_dept = 'Seasoning' , qty ,0 )) AS seasoning,
    SUM( IF( kode_dept = 'Trial' , qty ,0 )) AS trial
    FROM 
    detail_pemasukan_gp 
    INNER JOIN pemasukan_gp ON detail_pemasukan_gp.nobukti_pemasukan = pemasukan_gp.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan_gp.kode_barang) gm ON (master_barang_produksi.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT 
    detail_pengeluaran_gp.kode_barang,
    SUM( IF( kode_dept = 'Pemakaian' , qty ,0 )) AS pemakaian,
    SUM( IF( kode_dept = 'Retur Out' , qty ,0 )) AS retur,
    SUM( IF( kode_dept = 'Lainnya' , qty ,0 )) AS lainnya
    FROM detail_pengeluaran_gp 
    INNER JOIN pengeluaran_gp ON detail_pengeluaran_gp.nobukti_pengeluaran = pengeluaran_gp.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran_gp.kode_barang) gk ON (master_barang_produksi.kode_barang = gk.kode_barang)

    WHERE master_barang_produksi.status = 'Aktif'
    GROUP BY 
    master_barang_produksi.kode_barang,
    master_barang_produksi.nama_barang,    
    sa.saldoawal,
    op.opname,
    gm.gudang,
    gm.seasoning,
    gm.trial,
    gk.pemakaian,
    gk.retur,
    gk.lainnya
    ";
    return $this->db->query($query);

  }

  
  function getKategori(){

    return $this->db->get('kategori_barang_pembelian');
  }


  function listproduk(){

    return $this->db->get('master_barang_produksi');
  }

  function ceksaldo($bulan,$tahun){

    if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('saldoawal_gp',array('bulan'=>$bulan,'tahun'=>$tahun));

  }

  function ceksaldoall(){

    return $this->db->get('saldoawal_gp');
  }

  function ceksaldoSkrg($bulan,$tahun){

    return $this->db->get_where('saldoawal_gp',array('bulan'=>$bulan,'tahun'=>$tahun));
  }

  function cekopname($bulan,$tahun){

    if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('opname_gp',array('bulan'=>$bulan,'tahun'=>$tahun,));

  }

  function cekopnameall(){

    return $this->db->get('opname_gp');
  }
  function cekopnameSkrg($bulan,$tahun){

    return $this->db->get_where('opname_gp',array('bulan'=>$bulan,'tahun'=>$tahun));
  }

  function insert_opname(){

    $kode_opname      = $this->input->post('kode_opname');
    $tanggal          = $this->input->post('tanggal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $jumproduk        = $this->input->post('jumlahproduk');

    $data = array(
      'kode_opname'       => $kode_opname,
      'tanggal'           => $tanggal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
    );

    $cek            = $this->db->get_where('opname_gp',array('kode_opname'=>$kode_opname))->num_rows();
    $cekbulan       = $this->db->get_where('opname_gp',array('bulan'=>$bulan,'tahun'=>$tahun))->num_rows();
    if(empty($cek) && empty($cekbulan)) {

      $simpansaldo   = $this->db->insert('opname_gp',$data);
      if($simpansaldo){
        for($i=1; $i<=$jumproduk; $i++){
          $kode_barang     = $this->input->post('kode_barang'.$i);
          $qty             = $this->input->post('qty'.$i);

          $detail_saldo   = array (
            'kode_opname'       => $kode_opname,
            'kode_barang'       => $kode_barang,
            'qty'               => $qty
          );
          $this->db->insert('opname_gp_detail',$detail_saldo);

        }
        $this->session->set_flashdata('msg',
          '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
          </div>');
        redirect('produksi/opname');

      }

    }else{
      $this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
        </div>');
      redirect('produksi/inputopname');
    }
  }


  function insert_saldoawal(){

    $kode_saldoawal   = $this->input->post('kode_saldoawal');
    $tanggal          = $this->input->post('tanggal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $jumproduk        = $this->input->post('jumproduk');

    $data = array(
      'kode_saldoawal'    => $kode_saldoawal,
      'tanggal'           => $tanggal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
    );

    $cek            = $this->db->get_where('saldoawal_gp',array('kode_saldoawal'=>$kode_saldoawal))->num_rows();
    $cekbulan       = $this->db->get_where('saldoawal_gp',array('bulan'=>$bulan,'tahun'=>$tahun))->num_rows();
    if(empty($cek) && empty($cekbulan)) {

      $simpansaldo   = $this->db->insert('saldoawal_gp',$data);
      if($simpansaldo){
        for($i=1; $i<=$jumproduk; $i++){
          $kode_barang      = $this->input->post('kode_barang'.$i);
          $qty              = $this->input->post('qty'.$i);

          $detail_saldo   = array (
            'kode_saldoawal'    => $kode_saldoawal,
            'kode_barang'       => $kode_barang,
            'qty'               => $qty
          );
          $this->db->insert('saldoawal_gp_detail',$detail_saldo);

        }
        $this->session->set_flashdata('msg',
          '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
          </div>');
        redirect('produksi/saldoawal');

      }

    }else{
      $this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
        </div>');
      redirect('produksi/inputsaldoawal');
    }
  }

  function hapuspemasukan(){

    $nobukti    = str_replace(".","/",$this->uri->segment(3));
    $this->db->query("DELETE FROM pemasukan_gp WHERE nobukti_pemasukan = '$nobukti' ");
    $this->db->query("DELETE FROM detail_pemasukan_gp WHERE nobukti_pemasukan = '$nobukti' ");

  }

  function hapussaldoawal(){

    $nobukti    = str_replace(".","/",$this->uri->segment(3));
    $this->db->query("DELETE FROM saldoawal_gp WHERE kode_saldoawal = '$nobukti' ");
    $this->db->query("DELETE FROM saldoawal_gp_detail WHERE kode_saldoawal = '$nobukti' ");

  }

  function hapusopname(){

    $nobukti    = str_replace(".","/",$this->uri->segment(3));
    $this->db->query("DELETE FROM opname_gp WHERE kode_opname = '$nobukti' ");
    $this->db->query("DELETE FROM opname_gp_detail WHERE kode_opname = '$nobukti' ");

  }

  function editdetailsaldoawal(){

    $kodesaldo    = $this->input->post('kodesaldoawal');
    $kode_barang  = $this->input->post('kodebarang');
    $qty          = str_replace(",", "", $this->input->post('qty'));

    $data = array(

      'kode_barang'     => $kode_barang,
      'qty'             => $qty

    );

    $this->db->where('kode_saldoawal',$kodesaldo);
    $this->db->where('kode_barang',$kode_barang);
    $this->db->update('saldoawal_gp_detail',$data);

  }

  function getDetailPemasukan(){

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('master_barang_produksi','detail_pemasukan_gp.kode_barang = master_barang_produksi.kode_barang');
    return $this->db->get_where('detail_pemasukan_gp',array('detail_pemasukan_gp.nobukti_pemasukan'=>$nobukti));
  }

  function getDetailsaldoawal(){

    $kode_saldoawal            = $this->input->post('kode_saldoawal');
    $this->db->join('master_barang_produksi','saldoawal_gp_detail.kode_barang = master_barang_produksi.kode_barang');
    return $this->db->get_where('saldoawal_gp_detail',array('saldoawal_gp_detail.kode_saldoawal'=>$kode_saldoawal));
  }

  function geteditpemasukan(){

    $nobukti    = str_replace(".","/",$this->uri->segment(3));
    
    // $this->db->join('detail_pemasukan_gp','pemasukan_gp.nobukti_pemasukan = detail_pemasukan_gp.nobukti_pemasukan');
    return $this->db->get_where('pemasukan_gp',array('pemasukan_gp.nobukti_pemasukan'=>$nobukti));
  }


  function geteditpengeluaran(){

    $nobukti    = str_replace(".","/",$this->uri->segment(3));
    
    // $this->db->join('detail_pemasukan_gp','pemasukan_gp.nobukti_pemasukan = detail_pemasukan_gp.nobukti_pemasukan');
    return $this->db->get_where('pengeluaran_gp',array('pengeluaran_gp.nobukti_pengeluaran'=>$nobukti));
  }


  function getDetailopnamestok(){

    $kode_opname            = $this->input->post('kode_opname');
    $this->db->join('master_barang_produksi','opname_gp_detail.kode_barang = master_barang_produksi.kode_barang');
    return $this->db->get_where('opname_gp_detail',array('opname_gp_detail.kode_opname'=>$kode_opname));
  }

  function getDept(){

    return $this->db->get_where('departemen');
  }

  function getSaldoawal(){

    $kode_saldoawal            = $this->input->post('kode_saldoawal');
    return $this->db->get_where('saldoawal_gp',array('kode_saldoawal'=>$kode_saldoawal));
  }

  function getOpname(){

    $kode_opname            = $this->input->post('kode_opname');
    return $this->db->get_where('opname_gp',array('kode_opname'=>$kode_opname));
  }

  function getPemasukan(){

    $nobukti            = $this->input->post('nobukti');
    return $this->db->get_where('pemasukan_gp',array('nobukti_pemasukan'=>$nobukti));
  }

  function getDetailPengeluaran(){

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('master_barang_produksi','detail_pengeluaran_gp.kode_barang = master_barang_produksi.kode_barang');
    return $this->db->get_where('detail_pengeluaran_gp',array('detail_pengeluaran_gp.nobukti_pengeluaran'=>$nobukti));
  }

  function getPengeluaran(){

    $nobukti            = $this->input->post('nobukti');
    return $this->db->get_where('pengeluaran_gp',array('nobukti_pengeluaran'=>$nobukti));
  }

  public function getDataopname($rowno,$rowperpage,$kode_opname="",$tanggal=""){

    $this->db->select('*');
    $this->db->from('opname_gp');
    $this->db->order_by('tanggal','DESC');

    if($kode_opname != ''){
      $this->db->like('kode_opname', $kode_opname);
    }

    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordopnameCount($kode_opname="",$tanggal=""){

    $this->db->select('count(*) as allcount');
    $this->db->from('opname_gp');
    $this->db->order_by('tanggal','DESC');

    if($kode_opname != ''){
      $this->db->like('kode_opname', $kode_opname);
    }

    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataSaldoawal($rowno,$rowperpage,$kode_saldoawal="",$tanggal=""){

    $this->db->select('*');
    $this->db->from('saldoawal_gp');
    $this->db->order_by('tanggal','DESC');

    if($kode_saldoawal != ''){
      $this->db->like('kode_saldoawal', $kode_saldoawal);
    }

    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordSaldoawalnCount($kode_saldoawal="",$tanggal=""){

    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal_gp');
    $this->db->order_by('tanggal','DESC');

    if($kode_saldoawal != ''){
      $this->db->like('kode_saldoawal', $kode_saldoawal);
    }

    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataPemasukan($rowno,$rowperpage,$nobukti="",$tgl_pemasukan=""){

    $this->db->select('*');
    $this->db->from('pemasukan_gp');
    $this->db->order_by('tgl_pemasukan','DESC');

    if($nobukti != ''){
      $this->db->like('nobukti_pemasukan', $nobukti);
    }

    if($tgl_pemasukan != ''){
      $this->db->where('tgl_pemasukan', $tgl_pemasukan);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordPemasukanCount($nobukti="",$tgl_pemasukan=""){

    $this->db->select('count(*) as allcount');
    $this->db->from('pemasukan_gp');
    $this->db->order_by('tgl_pemasukan','DESC');

    if($nobukti != ''){
      $this->db->like('nobukti_pemasukan', $nobukti);
    }

    if($tgl_pemasukan != ''){
      $this->db->where('tgl_pemasukan', $tgl_pemasukan);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataPengeluaran($rowno,$rowperpage,$nobukti="",$tgl_pengeluaran=""){

    $this->db->select('*');
    $this->db->from('pengeluaran_gp');
    $this->db->order_by('tgl_pengeluaran,nobukti_pengeluaran','DESC');

    if($nobukti != ''){
      $this->db->like('nobukti_pengeluaran', $nobukti);
    }

    if($tgl_pengeluaran != ''){
      $this->db->where('tgl_pengeluaran', $tgl_pengeluaran);
    }


    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordPengeluaranCount($nobukti="",$tgl_pengeluaran=""){

    $this->db->select('count(*) as allcount');
    $this->db->from('pengeluaran_gp');
    $this->db->order_by('tgl_pengeluaran','desc');

    if($nobukti != ''){
      $this->db->like('nobukti_pengeluaran', $nobukti);
    }

    if($tgl_pengeluaran != ''){
      $this->db->where('tgl_pengeluaran', $tgl_pengeluaran);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insertpemasukan_temp(){

    $kode_barang  = $this->input->post('kodebarang');
    $kodeedit     = $this->input->post('kode_edit');
    $qty          = str_replace(",", "", $this->input->post('qty'));
    $keterangan   = $this->input->post('keterangan');
    $id_admin     = $this->session->userdata('id_user');

    $data = array(

      'kode_barang'  => $kode_barang,
      'qty'          => $qty,
      'keterangan'   => $keterangan,
      'id_admin'     => $id_admin

    );
    if ($kodeedit == "") {
      $this->db->insert('detailpemasukan_temp_gp',$data);
    }else{
      $this->db->where('kode_barang',$kode_barang);
      $this->db->update('detailpemasukan_temp_gp',$data);
    }

  }

  function inputeditpemasukan(){

    $kode_barang  = $this->input->post('kodebarang');
    $kodeedit     = $this->input->post('kode_edit');
    $nobukti      = $this->input->post('nobukti');
    $tgl_pemasukan= $this->input->post('tgl_pemasukan');
    $departemen   = $this->input->post('departemen');
    $qty        = str_replace(",", "", $this->input->post('qty'));
    $keterangan   = $this->input->post('keterangan');
    $id_admin     = $this->session->userdata('id_user');

    $data2 = array(

      'nobukti_pemasukan'   => $nobukti,
      'kode_barang'         => $kode_barang,
      'qty'                 => $qty,
      'keterangan'          => $keterangan

    );
    if ($kodeedit == "") {
      $this->db->insert('detail_pemasukan_gp',$data2);
    }else{
      $this->db->where('kode_barang',$kode_barang);
      $this->db->where('nobukti_pemasukan',$nobukti);
      $this->db->update('detail_pemasukan_gp',$data2);
    }

  }

  function inputeditpengeluaran(){

    $kode_barang      = $this->input->post('kodebarang');
    $kodeedit         = $this->input->post('kode_edit');
    $nobukti          = $this->input->post('nobukti');
    $tgl_pengeluaran  = $this->input->post('tgl_pengeluaran');
    $departemen       = $this->input->post('departemen');
    $qty              = str_replace(",", "", $this->input->post('qty'));
    $keterangan       = $this->input->post('keterangan');
    $id_admin         = $this->session->userdata('id_user');

    $data2 = array(

      'nobukti_pengeluaran'   => $nobukti,
      'kode_barang'           => $kode_barang,
      'qty'                   => $qty,
      'keterangan'            => $keterangan

    );
    if ($kodeedit == "") {
      $this->db->insert('detail_pengeluaran_gp',$data2);
    }else{
      $this->db->where('kode_barang',$kode_barang);
      $this->db->where('nobukti_pengeluaran',$nobukti);
      $this->db->update('detail_pengeluaran_gp',$data2);
    }

  }

  function update_pemasukan(){

    $nobukti      = $this->input->post('nobukti');
    $tgl_pemasukan= $this->input->post('tgl_pemasukan');
    $departemen   = $this->input->post('departemen');
    
    $data = array(

      'tgl_pemasukan'       => $tgl_pemasukan,
      'kode_dept'           => $departemen

    );
    $this->db->where('nobukti_pemasukan',$nobukti);
    $this->db->update('pemasukan_gp',$data);
    redirect('produksi/pemasukan','refresh');

  }

  function update_pengeluaran(){

    $nobukti          = $this->input->post('nobukti');
    $tgl_pengeluaran  = $this->input->post('tgl_pengeluaran');
    $departemen       = $this->input->post('departemen');
    
    $data = array(

      'tgl_pengeluaran'     => $tgl_pengeluaran,
      'kode_dept'           => $departemen

    );
    $this->db->where('nobukti_pengeluaran',$nobukti);
    $this->db->update('pengeluaran_gp',$data);
    redirect('produksi/pengeluaran','refresh');

  }

  function insert_pemasukan(){

    $nobukti              = $this->input->post('nobukti');
    $tgl_pemasukan        = $this->input->post('tgl_pemasukan');
    $departemen           = $this->input->post('departemen');
    $id_admin             = $this->session->userdata('id_user');

    $data = array(

     'nobukti_pemasukan'      => $nobukti,
     'tgl_pemasukan'          => $tgl_pemasukan,
     'kode_dept'              => $departemen
   );

    $this->db->insert('pemasukan_gp',$data);

    $data = $this->db->query("SELECT * FROM detailpemasukan_temp_gp WHERE id_admin = '$id_admin' ");

    foreach ($data->result() as $d) {

      $data = array(

        'nobukti_pemasukan' => $nobukti,
        'kode_barang'       => $d->kode_barang,
        'qty'               => $d->qty,
        'keterangan'        => $d->keterangan

      );
      $this->db->insert('detail_pemasukan_gp',$data);
    }

    $this->db->query("DELETE FROM detailpemasukan_temp_gp WHERE id_admin = '$id_admin' ");
    redirect('produksi/pemasukan');

  }

  function getPemasukantemp(){

    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_produksi','detailpemasukan_temp_gp.kode_barang = master_barang_produksi.kode_barang');
    return $this->db->get_where('detailpemasukan_temp_gp',array('id_admin'=>$id_user));

  }

  function view_detaileditpemasukan(){

    $nobukti  = $this->input->post('nobukti');
    $this->db->join('master_barang_produksi','detail_pemasukan_gp.kode_barang = master_barang_produksi.kode_barang');
    return $this->db->get_where('detail_pemasukan_gp',array('nobukti_pemasukan'=>$nobukti));

  }

  function view_detaileditpengeluaran(){

    $nobukti  = $this->input->post('nobukti');
    $this->db->join('master_barang_produksi','detail_pengeluaran_gp.kode_barang = master_barang_produksi.kode_barang');
    return $this->db->get_where('detail_pengeluaran_gp',array('nobukti_pengeluaran'=>$nobukti));

  }

  function hapus_detailpemasukan_temp(){

    $kodebarang  = $this->input->post('kodebarang');
    $ket         = $this->input->post('keterangan');
    $idadmin     = $this->input->post('idadmin');
    $this->db->delete('detailpemasukan_temp_gp',array('kode_barang'=>$kodebarang,'id_admin'=>$idadmin,'keterangan'=>$ket));

  }

  function hapus_detaileditpemasukan(){

    $kodebarang   = $this->input->post('kodebarang');
    $nobukti      = $this->input->post('nobukti');
    $ket          = $this->input->post('keterangan');
    $this->db->delete('detail_pemasukan_gp',array('kode_barang'=>$kodebarang,'nobukti_pemasukan'=>$nobukti,'keterangan'=>$ket));

  }


  function hapus_detaileditpengeluaran(){

    $kodebarang   = $this->input->post('kodebarang');
    $nobukti      = $this->input->post('nobukti');
    $ket          = $this->input->post('keterangan');
    $this->db->delete('detail_pengeluaran_gp',array('kode_barang'=>$kodebarang,'nobukti_pengeluaran'=>$nobukti,'keterangan'=>$ket));

  }

  function insertpengeluaran_temp(){

    $kode_barang  = $this->input->post('kodebarang');
    $kodeedit     = $this->input->post('kode_edit');
    $qty          = str_replace(",", "", $this->input->post('qty'));
    $keterangan   = $this->input->post('keterangan');
    $id_admin     = $this->session->userdata('id_user');

    $data = array(

      'kode_barang'         => $kode_barang,
      'qty'                 => $qty,
      'keterangan'          => $keterangan,
      'id_admin'            => $id_admin

    );

    if ($kodeedit == "") {
      $this->db->insert('detailpengeluaran_temp_gp',$data);
    }else{
      $this->db->where('kode_barang',$kode_barang);
      $this->db->update('detailpengeluaran_temp_gp',$data);
    }

  }

  function insert_pengeluaran(){

    $nobukti            = $this->input->post('nobukti');
    $tgl_pengeluaran    = $this->input->post('tgl_pengeluaran');
    $kode_dept          = $this->input->post('departemen');
    $id_admin           = $this->session->userdata('id_user');

    $data = array(

      'nobukti_pengeluaran'   => $nobukti,
      'tgl_pengeluaran'       => $tgl_pengeluaran,
      'kode_dept'             => $kode_dept

    );

    $this->db->insert('pengeluaran_gp',$data);

    $data = $this->db->query("SELECT * FROM detailpengeluaran_temp_gp WHERE id_admin = '$id_admin' ")->result();

    foreach ($data as $d) {


      $data = array(

        'nobukti_pengeluaran' => $nobukti,
        'kode_barang'         => $d->kode_barang,
        'qty'                 => $d->qty,
        'keterangan'          => $d->keterangan

      );
      $this->db->insert('detail_pengeluaran_gp',$data);
    }

    $this->db->query("DELETE FROM detailpengeluaran_temp_gp WHERE id_admin = '$id_admin' ");
    redirect('produksi/pengeluaran');

  }

  function getPengeluarantemp(){

    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_produksi','detailpengeluaran_temp_gp.kode_barang = master_barang_produksi.kode_barang');
    return $this->db->get_where('detailpengeluaran_temp_gp',array('id_admin'=>$id_user));

  }

  function hapus_detailpengeluaran_temp(){

    $kodebarang  = $this->input->post('kodebarang');
    $idadmin     = $this->input->post('idadmin');
    $ket         = $this->input->post('keterangan');
    $this->db->delete('detailpengeluaran_temp_gp',array('kode_barang'=>$kodebarang,'id_admin'=>$idadmin,'keterangan'=>$ket));

  }

  function jsonPilihAkun(){

    $this->datatables->select('set_coa_cabang.kode_akun,nama_akun');
    $this->datatables->from('set_coa_cabang');
    $this->datatables->join('coa','set_coa_cabang.kode_akun = coa.kode_akun');
    $this->datatables->where('kategori','pembelian');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2" class="btn btn-danger btn-sm waves-effect pilih">Pilih</a>', 'kode_akun,nama_akun');
    return $this->datatables->generate();

  }

  function jsonPilihBarang(){

    $departemen    = $this->uri->segment(3);
    $this->datatables->select('kode_barang,nama_barang,satuan,master_barang_produksi.kode_dept,jenis_barang');
    $this->datatables->from('master_barang_produksi');
    $this->datatables->where('master_barang_produksi.status','Aktif');
    if ($departemen == "Gudang" OR $departemen == "Seasoning") {
      $this->datatables->where('master_barang_produksi.kode_dept',$departemen);
    }
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2"  data-jenis="$3" class="btn btn-danger btn-sm waves-effect pilih">Pilih</a>', 'kode_barang,nama_barang,jenis_barang');
    return $this->datatables->generate();

  }

}
