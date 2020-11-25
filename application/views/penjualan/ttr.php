
<div class="row clearfix">
  <div class="col-md-10">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
           INPUT TTR
          <small>Input TTR</small>
        </h2>
      </div>
      <div class="body">
        <div class="row clearfix">
          <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>penjualan/input_ttr">
            <div class="row">
              <div class="body">
                <div class="col-md-12">
                  <div class="input-group demo-masked-input"  >
                    <span class="input-group-addon">
                      <i class="material-icons">date_range</i>
                    </span>
                    <div class="form-line">
                      <input type="text" value=""  id="tgl_ttr" name="tgl_ttr" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="input-group" >
                    <span class="input-group-addon">
                      <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                      <input type="hidden" readonly  id="kodepelanggan" name="kodepelanggan" class="form-control" />
                        <input type="text" readonly  id="pelanggan" name="pelanggan" class="form-control" placeholder="Pelanggan" data-error=".errorTxt2" />
                    </div>
                    <div class="errorTxt2"></div>
                  </div>
                  <div class="input-group" >
                    <span class="input-group-addon">
                      <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                      <input type="hidden"  id="kodesales" name="kodesales" class="form-control"/>
                      <input type="text"    id="salesman"  disabled name="salesman" class="form-control" placeholder="Salesman" data-error=".errorTxt3" />
                    </div>
                    <div class="errorTxt3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
           <div class="row">
            <div class="body">
              <div class="col-md-4">
                <label>Barang</label>
                <div class="input-group" >
                  <span class="input-group-addon">
                    <i class="material-icons">chrome_reader_mode</i>
                  </span>
                  <div class="form-line">
                    <input type="hidden" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Barang"/>
                    <input type="text" readonly id="barang" name="barang" class="form-control" placeholder="Barang"  />
                    <input type="hidden" readonly id="kodecabang" name="kodecabang" class="form-control" placeholder="Kode Cabang"  />
                    <input type="hidden"   id="cekdetailttrtemp" name="cekdetailttrtemp" class="form-control" data-error=".errorTxt1" />
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <label>Jumlah</label>
                <div class="form-group form-float">
                  <div class="form-line">
                    <input type="text" style="text-align:center" value="0"  id="jmldus" name="jmldus" class="form-control" />
                  </div>
                  <div class="form-line">
                    <input style="text-align:right; font-weight: bold" readonly type="hidden" id="hargadus" name="hargadus" class="form-control"  placeholder="Harga" />
                  </div>
                  <div class="form-line">
                    <input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcsdus" name="isipcsdus" class="form-control"  />
                  </div>
                   <div class="form-line">
                     <input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcspack" name="isipcspack" class="form-control" />
                    </div>
                </div>
              </div>
              <div class="col-md-2" id="pack">
                <label>Jumlah Pack</label>
                <div class="form-group form-float">
                  <div class="form-line">
                    <input type="text" style="text-align:center" value="0"  id="jmlpack" name="jmlpack" class="form-control"  />
                  </div>
                  <div class="form-line">
                    <input style="text-align:right; font-weight: bold" type="hidden" id="hargapack" name="hargapack" class="form-control" readonly   placeholder="Harga / Pack"/>
                  </div>
                </div>
              </div>
              <div class="col-md-2" >
                <label>Jumlah Pcs</label>
                <div class="form-group form-float">
                  <div class="form-line">
                    <input type="text"  style="text-align:center" value="0"  id="jmlpcs" name="jmlpcs" class="form-control" placeholder="Jumlah Pcs"  />
                  </div>
                  <div class="form-line">
                    <input style="text-align:right; font-weight: bold"  type="hidden" id="hargapcs" name="hargapcs" class="form-control" readonly placeholder="Harga / Pcs"  />
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <a href="#" id="tambahbarang" class="btn bg-blue waves-effect">
                  <i class="material-icons">add_shopping_cart</i>
                </a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="body">
              <div class="col-md-12  table-responsive" >
                <table class="table table-bordered table-striped table-hover" id="detailbarang">
                  <thead class="bg-teal">
                    <tr>
                      <th rowspan="2" style="text-align:center; vertical-align: middle">Kode Produk</th>
                      <th rowspan="2" style="text-align:center; vertical-align: middle">Nama Barang</th>
                      <th colspan="3" style="text-align:center; vertical-align: middle">Jumlah</th>
                      <th rowspan="2" style="text-align:center; vertical-align: middle">Aksi</th>
                    </tr>
                    <tr>
                      <th style="text-align: center">DUS</th>
                      <th style="text-align: center">PACK</th>
                      <th style="text-align: center">PCS</th>
                    </tr>
                  </thead>
                  <tbody id="loadDetail">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div style="float:right; margin-right: 100px;">
              <button type="submit" name="submit" class="btn btn-sm bg-blue"><span>Simpan</span> <i class="material-icons">send</i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row clearfix">
  <div class="col-md-10">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          DATA TTR
          <small>Data TTR</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <form class="" method="post" action="" autocomplete="off">
			        <label>Nama Pelanggan</label>
        			<div class="form-group">
        				<div class="form-line">
        					<input type="text" id="nama_pelanggan" value="<?php echo $namapel; ?>"  name="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan">
        				</div>
        			</div>
        			<label>Tanggal</label>
        			<div class="form-group">
        				<div class="form-line">
        					<input type="text" value="<?php echo $tgl_mutasi; ?>" id="tgl_mutasi" name="tgl_mutasi" class="form-control datepicker" placeholder="Tanggal">
        				</div>
        			</div>
        			<div class="form-group" >
        				<input type="submit" name="submit" class="btn bg-blue m-2-15 waves-effect" value="CARI DATA">
        			</div>
            </form>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="table-responsive">
             <table class="table table-bordered table-striped table-hover" >
              <thead>
                <tr>
                  <th width="10px">No</th>
                  <th>No. TTR</th>
                  <th>Tanggal</th>
                  <th>Kode Pelanggan</th>
                  <th>Nama Pelanggan</th>
                	<th>Nama Sales</th>
                	<th>No Faktur</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sno  = $row+1;
                  foreach ($result as $d){
                     $tanggal = explode("-",$d['tgl_mutasi_gudang_cabang']);
                     $hari    = $tanggal[2];
                     $bulan   = $tanggal[1];
                     $tahun   = $tanggal[0];
                     $tgl     = $hari."/".$bulan."/".substr($tahun,2,2);
              			if(empty($d['no_fak_penj'])){
              				$status = "<span class='badge bg-red'>Belum Di Fakturkan</span>";
              			}else{
              				$status = "<span class='badge bg-green'>".$d['no_fak_penj']."</span>";
              			}
                    ?>
                        <tr>
                           <td><?php echo $sno; ?></td>
                           <td>
                            <a href="#" data-nomutasi="<?php echo $d['no_mutasi_gudang_cabang']; ?>"  class="detail">
                              <?php echo $d['no_mutasi_gudang_cabang']; ?>
                            </a>
                           </td>
                           <td><?php  echo  $tgl; ?></td>
                           <td><?php  echo  $d['kode_pelanggan']; ?></td>
                           <td><?php  echo  $d['nama_pelanggan']; ?></td>
                    			 <td><?php  echo  $d['nama_karyawan']; ?></td>
                    			 <td><?php  echo  $status; ?></td>
                          <td>
                            <a href="#" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url(); ?>penjualan/hapusttr/<?php echo $d['no_mutasi_gudang_cabang']; ?>" class="btn bg-red btn-xs"><i class="material-icons">delete</i></a>
                          </td>
                        </tr>
                    <?php
                        $sno++;
                    }
                    ?>
              </tbody>
            </table>
            <div style='margin-top: 10px;'>
              <?php echo $pagination; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailmutasi" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            Detail TTR
            <small>Detail TTR</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
                <div id="loadmutasi"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--------------------------------------MODAL DATA BARANG---------------------------------------->
<div class="modal fade" id="databarang" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
            <h2>
              Data Barang
              <small>Pilih Data Barang</small>
            </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
                 <div id="loadBarang"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="datapelanggan" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            Data Pelanggan
            <small>Pilih Data Pelanggan</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
              <div class="col-sm-12">
                <div class="table-responsive">
                 <table class="table table-bordered table-striped table-hover" style="font-size:12px" id="mytable" style="width:1330px">
                      <thead>
                          <tr>
                            <th width="10px">No</th>
                            <th>Kode Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>No HP</th>
                            <th>Pasar</th>
                            <th>Cabang</th>
                            <th>Salesman</th>
                            <th>Aksi</th>
                          </tr>
                      </thead>
                  </table>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</div>

<script type="text/javascript">

     $(function(){

        function loadDetail(){
          var kodepelanggan = $("#kodepelanggan").val();
          $("#loadDetail").load("<?php echo base_url();?>penjualan/view_detailttrtemp/");
        }

        function cekdetail(){

            $.ajax({

                type    : 'POST',
                url     : '<?php echo base_url(); ?>penjualan/cekdetailttrtemp',
                cache   :false,
                success : function(respond){

                    $("#cekdetailttrtemp").val(respond);
                }

            });
        }
        cekdetail();
        loadDetail();

        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });

        $("#barang").click(function(){
            var pelanggan = $("#pelanggan").val();
            var cabang    = $("#kodecabang").val();
            if(pelanggan == ""){
                 swal("Oops!", "Silahkan Pilih Pelanggan Terlebih Dahulu!", "warning");
            }else{

               $("#databarang").modal("show");
                $.ajax({

                        type    : 'POST',
                        url     : '<?php echo base_url(); ?>barang/view_barangcab_gj',
                        data    : {kodecabang:cabang},
                        cache   : false,
                        success : function(respond){
                            //alert(kodecabang);
                            $("#loadBarang").html(respond);

                        }

                });
            }


        });

        $("#tambahbarang").click(function(e){
            e.preventDefault();
            var kode_produk = $("#kodebarang").val();
            var jmldus      = $("#jmldus").val();
            var hargadus    = $("#hargadus").val();
            var jmlpack     = $("#jmlpack").val();
            var hargapack   = $("#hargapack").val();
            var jmlpcs      = $("#jmlpcs").val();
            var hargapcs    = $("#hargapcs").val();
            var isipcsdus   = $("#isipcsdus").val();
            var isipcspack  = $("#isipcspack").val();


            if(kode_produk ==""){
                swal("Oops!", "Silahkan Pilih Barang Terlebih Dahulu !", "warning");
            }
            else if(jmldus == 0 && jmlpack ==0 && jmlpcs== 0){

                swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");

            }else{
                    $.ajax({

                        type    : 'POST',
                        url     : '<?php echo base_url();?>penjualan/insert_detailttrtemp',
                        data    : {
                                    kode_produk:kode_produk,
                                    jmldus:jmldus,
                                    hargadus:hargadus,
                                    jmlpack:jmlpack,
                                    hargapack:hargapack,
                                    jmlpcs:jmlpcs,
                                    hargapcs:hargapcs,

                                    isipcsdus:isipcsdus,
                                    isipcspack:isipcspack


                                },
                        cache   : false,
                        success : function(respond){
                            console.log(respond);

                             if(respond == 1){

                                swal("Oops!", "Data Sudah Di Inputkan!", "warning");
                             }
                            cekdetail();
                            loadDetail();

                        }


                    });
            }

        });

        $("#cabang").change(function(e){

            e.preventDefault();
            cekdetail();
            loadDetail();

        });

        $(".formValidate").submit(function(){


            var tgl_ttr         = $("#tgl_ttr").val();
            var pelanggan       = $("#kodepelanggan").val();
            var cek             = $("#cekdetailkirimpusattemp").val();

            if(tgl_ttr == ""){
                swal("Oops!", "Tanggal TTR Masih Kosong!", "warning");
                return false;
            }else if(pelanggan == ""){
                swal("Oops!", "Silahkan Pilih Pelanggan Terlebih Dahulu!", "warning");
                return false;
            }else if(cek == ""){
                swal("Oops!", "Data Barang Masih Kosong!", "warning");
                return false;
            }else{
                return true;
            }


         });


         $('.detail').click(function(e){
            e.preventDefault();
            var nomutasi        = $(this).attr('data-nomutasi');
            var jenis_mutasi    = "TTR";
            $.ajax({

                type    : 'POST',
                url     : '<?php echo base_url(); ?>repackreject/detail_mutasi_cab',
                data    : {nomutasi:nomutasi,jenis_mutasi:jenis_mutasi},
                cache   : false,
                success : function(respond){

                    $("#loadmutasi").html(respond);
                }


            });
            $("#detailmutasi").modal("show");

        });

         $("#pelanggan").click(function() {

            $("#datapelanggan").modal("show");


        });

         $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
          {
              return {
                  "iStart": oSettings._iDisplayStart,
                  "iEnd": oSettings.fnDisplayEnd(),
                  "iLength": oSettings._iDisplayLength,
                  "iTotal": oSettings.fnRecordsTotal(),
                  "iFilteredTotal": oSettings.fnRecordsDisplay(),
                  "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                  "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
              };
          };

          var t = $("#mytable").dataTable({

              initComplete: function() {

                  var api = this.api();
                  $('#mytable_filter input').off('.DT').on('keyup.DT', function(e) {

                            if (e.keyCode == 13) {
                                api.search(this.value).draw();
                       }
              });
              },
              oLanguage: {
                  sProcessing: "loading..."
              },
              processing: true,
              serverSide: true,
              bLengthChange: false,

              ajax: {"url": "<?php echo base_url();?>penjualan/jsonPelanggan", "type": "POST"},
              columns: [
                  {
                      "data": "kode_pelanggan",
                      "orderable": false
                  },
                  {"data": "kode_pelanggan"},
                  {"data": "nama_pelanggan"},
                  {"data": "no_hp"},
                  {"data": "pasar"},
                  {"data": "nama_cabang"},
                  {"data": "nama_karyawan"},
                  {"data": "view"}
              ],
              order: [[1, 'desc']],
              rowCallback: function(row, data, iDisplayIndex) {
                  var info = this.fnPagingInfo();
                  var page = info.iPage;
                  var length = info.iLength;
                  var index = page * length + (iDisplayIndex + 1);
                  $('td:eq(0)', row).html(index);


              }


          });

          $('#mytable tbody').on('click', 'a', function () {
            $("#kodepelanggan").val($(this).attr("data-kodepel"));
            $("#pelanggan").val($(this).attr("data-namapel"));
            $("#kodesales").val($(this).attr("data-kodesales"));
            $("#salesman").val($(this).attr("data-namasales"));
            $("#kodecabang").val($(this).attr("data-cabang"));
            $("#datapelanggan").modal("hide");

        });



     });
</script>
