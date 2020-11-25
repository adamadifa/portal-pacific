
<div class="row clearfix">
    <div class="col-md-5">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                    Manajemen Menu
                    <small>Mengelola Data Menu</small>
                </h2>
                
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                    <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>menu/insert_menu">
                        <div class="form-group input-field">
                            <div class="form-line">
                                <input type="hidden" value="<?php echo $getmenu['id']; ?>" id="id" name="id" class="form-control" placeholder="Menu*" />
                                <input type="text" value="<?php echo $getmenu['name']; ?>" id="namamenu" name="namamenu" class="form-control" placeholder="Menu*" data-error=".errorTxt1" />
                            </div>
                            <div class="errorTxt1"></div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <input id="link" value="<?php echo $getmenu['link']; ?>"  type="text" class="form-control" name="link" placeholder="Link*" data-error=".errorTxt2" >
                            </div>
                            <div class="errorTxt2"></div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <input id="icon" value="<?php echo $getmenu['icon']; ?>"  type="text" name="icon"  class="form-control"  placeholder="Icon*" data-error=".errorTxt3">

                            </div>
                            <div class="errorTxt3"></div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="parentmenu" name="parentmenu" data-error=".errorTxt6">
                                     <option value="" <?php if($getmenu['is_parent']==""){ echo "selected";} ?>>-- Select Parent -- </option>
                                     <option value="0" <?php if($getmenu['is_parent']== 0){ echo "selected";} ?>>Is Parent</option>
                                    <?php foreach($parent as $m){ ?>
                                        <option value="<?php echo $m->id; ?>" <?php if($getmenu['is_parent']==$m->id){ echo "selected";} ?>><?php echo strtoupper($m->name) ." | ". ucwords($m->role); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="errorTxt6"></div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="role" name="role" data-error=".errorTxt6">
                                    <option value="Administrator" <?php if($getmenu['role']=="Administrator"){ echo "selected";} ?>>Administrator</option>
                                    <option value="manager marketing" <?php if($getmenu['role']=="manager marketing"){ echo "selected";} ?>>Mananger Marketing</option>
                                    <option value="admin gudang pusat" <?php if($getmenu['role']=="kepala gudang"){ echo "selected";} ?>>Admin Gudang Pusat</option>
                                    <option value="keuangan" <?php if($getmenu['role']=="keuangan"){ echo "selected";} ?>>Keuangan</option>
                                    <option value="kepala gudang" <?php if($getmenu['role']=="kepala gudang"){ echo "selected";} ?>>Kepala Gudang</option>
                                    <option value="admin penjualan" <?php if($getmenu['role']=="admin penjualan"){ echo "selected";} ?>>Admin Penjualan</option>
                                    <option value="admin penjualan" <?php if($getmenu['role']=="kasir"){ echo "selected";} ?>>Kasir</option>
                                    <option value="admin gudang" <?php if($getmenu['role']=="admin gudang"){ echo "selected";} ?>>Admin Gudang</option>
                                    <option value="admin produksi" <?php if($getmenu['role']=="admin produksi"){ echo "selected";} ?>>Admin Produksi</option>
                                    
                                   
                                   
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <div class="demo-radio-button">
                                
                                <input name="status" checked type="radio" value="1" id="radio_13" class="radio-col-light-blue" />
                                <label for="radio_13">Aktif</label>
                                <input name="status" type="radio" value="0" id="radio_14" class="radio-col-light-blue" />
                                <label for="radio_14">NonAktif</label>
                               
                            </div>
                            </div>
                        </div>
                       
                              
                         <div class="form-group" >
                             <button type="submit"  name="submit" class="btn bg-blue waves-effect">
                                <i class="material-icons">save</i>
                                <span>SIMPAN</span>
                            </button>
                            <button type="button" class="btn bg-red waves-effect">
                                <i class="material-icons">cancel</i>
                                <span>Batal</span>
                            </button>
                        </div>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                    Menu
                    <small>Datfar Menu</small>
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                           <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="width:130%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Menu</th>
                                        <th>Link</th>
                                        <th>Parent</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($menu as $d){ ?>
                                    <tr>
                                        <td><?php echo $d->id; ?></td>
                                        <td><?php echo ucwords($d->name); ?></td>
                                        <td><?php echo $d->link; ?></td>
                                        <td><?php echo $d->is_parent; ?></td>
                                        <td><?php echo $d->role; ?></td>
                                        <td>
                                             <a href="<?php echo base_url('menu/index/'.$d->id); ?>"  class="btn bg-green  btn-xs waves-effect edit">Edit</a>
                                             <a href="#"  class="btn bg-red  btn-xs waves-effect" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url("menu/hapus/".$d->id);?>">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#formValidate").validate({
            rules: {
                namamenu    :"required",
                link        :"required",
                icon        :"required",
                parentmenu  :"required",
                
            },
            //For custom messages
            messages: {
                
                namamenu        : "Nama Menu Harus Diisi !",
                link            : "Link Harus Diisi !",
                icon            : "Icon Harus Diisi !",
                parentmenu      : "Harus Diisi !",
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

        $('.edit').click(function(){

            var id = $(this).attr('data-id');

            $.ajax({ 

                type        : 'POST',
                url         : '<?php echo base_url();?>menu/get_menu',
                data        : {id:id},
                cache       : false,
                success     : function(respond){
                data=respond.split("|");

                    alert(data[1]);

                }





            });




        });
    });
</script>