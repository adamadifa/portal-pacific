<form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>fsthp/input_fsthp">
<div class="row clearfix">
	<div class="col-md-6">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                    INPUT SERAH TERIMA  HASIL PRODUKSI (FSTHP)
                    <small>Input FSTHP</small>
                </h2>
            </div>

            <div class="body">
                <div class="row clearfix">
                    <div class="row">
                        <div class="body">
                            <div class="col-md-6">
                                <div class="input-group" >
                                    <span class="input-group-addon">
                                        <i class="material-icons">chrome_reader_mode</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="text" readonly  id="no_fsthp" name="no_fsthp" class="form-control" placeholder="No FSTHP" data-error=".errorTxt1" />

                                    </div>
                                    <div class="errorTxt1"></div>
                                </div>

                                <div class="input-group demo-masked-input"  >
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="text" value=""  id="tgl_fsthp" name="tgl_fsthp" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />

                                    </div>
                                    <div class="errorTxt19"></div>
                                </div>

                                <div class="input-group" >
                                    <span class="input-group-addon">
                                        <i class="material-icons">chrome_reader_mode</i>
                                    </span>
                                    <div class="form-line">
                                       <input type="hidden" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Barang"/>
                                        <input type="text" readonly id="barang" name="barang" class="form-control" placeholder="Barang"  />

                                    </div>
                                    <div class="errorTxt1"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="body">
                            <div class="col-md-2">
                                <label>Shift</label>
                                <div class="input-group" >
                                    <div class="form-line">
                                        <select class="form-control" name="shift" id="shift">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>Jumlah</label>
                                <div class="input-group" >
                                    <div class="form-line">
                                        <input type="text"  id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="#" id="tambahbarang" class="btn bg-blue waves-effect">
                                    <i class="material-icons">add_shopping_cart</i>
                                    <span>Tambah</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="body">
                            <div class="col-md-12  table-responsive" >
                                <table class="table table-bordered table-striped table-hover" id="detailbarang">
                                    <thead class="bg-green">
                                        <tr>
                                            <th>Kode Produk</th>
                                            <th>Nama Barang</th>
                                            <th>Shift</th>
                                            <th>Jml</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loadfsthp">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div style="float:right; margin-right: 100px;">
                            <button type="submit" name="submit" style=" font-size:16px" class="btn btn-lg bg-blue"><span>SIMPAN</span> <i class="material-icons">send</i></button>
                        </div>
                    </div>  
                </div>
             </div>
        </div>
    </div>
</div>
</form>
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
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

<script type="text/javascript">

    $(function(){

        function ladFsthp(){
            var kode_produk = $("#kodebarang").val();
            $("#loadfsthp").load('<?php echo base_url(); ?>fsthp/view_detailfsthp_temp/'+kode_produk);
        }
        ladFsthp();

        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });

        $("#barang").click(function(){
            var tgl_fsthp    = $("#tgl_fsthp").val();
             if(tgl_fsthp==""){

                swal("Oops!", "Isi Tanggal Terlebih Dahulu!", "warning");

            }else{
                $("#databarang").modal("show");
                $.ajax({

                    type    : 'POST',
                        url     : '<?php echo base_url(); ?>fsthp/view_barang',
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
            var shift       = $("#shift").val();
            var jumlah      = $("#jumlah").val();
            var tgl_fsthp   = $("#tgl_fsthp").val();
            if(tgl_fsthp==""){

                swal("Oops!", "Isi Tanggal Terlebih Dahulu!", "warning");

            }else if(kode_produk ==""){
                swal("Oops!", "Silahkan Pilih Barang/Produk Terlebih Dahulu !", "warning");
            }
            else if(jumlah==""){

                swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");

            }else {
                $.ajax({

                    type    : 'POST',
                    url     : '<?php echo base_url(); ?>fsthp/insert_detailtmp',
                    data    : {kode_produk:kode_produk,shift:shift,jumlah:jumlah,tgl_fsthp:tgl_fsthp},
                    cache   : false,
                    success : function(respond){
                        console.log(respond);
                        if(respond == 1){
                            swal("Oops!", "Data Untuk Produk "+kode_produk+" Tanggal "+tgl_fsthp+" Shift "+shift+" Sudah Ada!", "warning");
                        }else if(respond == 2){
                            swal("Oops!", "Data Untuk Produk "+kode_produk+" Shift "+shift+" Sudah Ada!", "warning");
                        }
                        ladFsthp();
                    }



                });
            }


        });


         $("form").submit(function(){

            var no_bpbj     = $("#no_bpbj").val();
            var tgl_bpbj    = $("#tgl_bpbj").val();

            if(no_bpbj == ""){
                swal("Oops!", "No BPBJ Masih Kosong!", "warning");
                return false;
            }else if(tgl_bpbj == ""){
                swal("Oops!", "Tanggal BPBJ Masih Kosong!", "warning");
                return false;
            }else{
                return true;
            }


         });


         $("#tgl_bpbj").change(function(){

            var tgl_bpbj       = $("#tgl_bpbj").val();
            var kode_produk    = $("#kodebarang").val();
            if(kode_produk !=""){
                    $.ajax({

                        type    : 'POST',
                        url     : '<?php echo base_url();?>bpbj/buat_nomor_bpbj',
                        data    : {tgl_bpbj:tgl_bpbj,kode_produk:kode_produk},
                        cache   : false,
                        success : function(respond){

                            console.log(respond);
                            $("#no_bpbj").val("");
                            $("#no_bpbj").val(respond);
                        }

                    });
            }
        });



    });



</script>
