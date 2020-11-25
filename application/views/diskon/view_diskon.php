s
<div class="row clearfix">
    <div class="col-md-5">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                   Data Diskon
                    <small>Mengelola Data Diskon</small>
                </h2>
                
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>diskon/insert_diskon">
                            <input type="hidden" name="id" value="<?php echo $getdiskon['id']; ?>">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" id="kategori" name="kategori" data-error=".errorTxt9">
                                         <option value="">-- Pilih Kategori -- </option>
                                         <option <?php if($getdiskon['kategori']=="SWAN"){ echo "selected";} ?> value="SWAN">SWAN</option>
                                         <option <?php if($getdiskon['kategori']=="AIDA"){ echo "selected";} ?> value="AIDA">AIDA</option>
                                    </select>
                                </div>
                                <div class="errorTxt9"></div>
                            </div> 
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="<?php echo $getdiskon['dari']; ?>"  id="dari" name="dari" class="form-control" data-error=".errorTxt2" />
                                    <label class="form-label">Dari</label>
                                </div>
                                <div class="errorTxt2"></div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="<?php echo $getdiskon['sampai']; ?>"  id="sampai" name="sampai" class="form-control" data-error=".errorTxt3" />
                                    <label class="form-label">Sampai</label>
                                </div>
                                <div class="errorTxt3"></div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="<?php echo $getdiskon['diskon']; ?>"  id="diskon" name="diskon" class="form-control" data-error=".errorTxt4" />
                                    <label class="form-label">Diskon</label>
                                </div>
                                <div class="errorTxt4"></div>
                            </div>
                            <div class="form-group" >
                                 <button type="submit"  name="submit" class="btn bg-blue waves-effect">
                                    <i class="material-icons">save</i>
                                    <span>SIMPAN</span>
                                </button>
                                <a href="<?php echo base_url('diskon/view_diskon'); ?>" class="btn bg-red waves-effect">
                                    <i class="material-icons">cancel</i>
                                    <span>Batal</span>
                                </a>
                            </div>
                         </form>

                    </div>
                 </div>
             </div>
         </div>
    </div> 
    <div class="col-md-7">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                    List Dikson
                    <small>List Diskon Produk</small>
                </h2>
            </div>
            <div class="body">
               
                   
                <div class="table-responsive">
                   <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="width:600px">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Dari</th>
                                <th>Sampai</th>
                                <th>Diskon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                            <?php foreach($diskon->result() as $d){ ?>
                            <tr>
                                <td><?php echo $d->kategori; ?></td>
                                <td><?php echo $d->dari; ?></td>
                                <td><?php echo $d->sampai; ?></td>
                                <td align="right"><?php echo number_format($d->diskon,'0','','.'); ?></td>
                               <td>
                                     <a href="<?php echo base_url('diskon/view_diskon/'.$d->id); ?>"  class="btn bg-green  btn-xs waves-effect edit">Edit</a>
                                     <a href="#"  class="btn bg-red  btn-xs waves-effect" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url("diskon/hapus/".$d->id);?>">Hapus</a>
                                </td>
                            </tr>
                            <?php } ?>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

                  
                
             </div>
        </div>

    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>   
<script type="text/javascript">
    $(function(){
        $("#formValidate").validate({
            rules: {
                kategori        :"required",
                dari            :"required",
                sampai          :"required",
                diskon          :"required",
               
                
            },
            //For custom messages
            messages: {
                
                kategori         :"Silahkan Pilih Kategori Terlebih Dahulu !",
                 dari            :"Harus Diisi !",
                 sampai          :"Harus Diisi !",
                 diskon          :"Harus Diisi !",
               },
            errorElement : 'div',
            errorPlacement: function(error, element) {
              var placement = $(element).data('error');
              if (placement) {
                $(placement).append(error)
              } else {
                error.insertAfter(element);
              }
            }
         });

        $('.js-basic-example').DataTable({
            responsive: true
        });
    });
</script>