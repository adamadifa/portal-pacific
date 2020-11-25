
<div class="row clearfix">
    <div class="col-md-5">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                   Ubah Password
                    <small>Reset Password</small>
                </h2>
                
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>setting/ubah_password">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password"  id="passwordlama" name="passwordlama" class="form-control" data-error=".errorTxt1" />
                                    <label class="form-label">Password Lama</label>
                                </div>
                                <div class="errorTxt1"></div>
                            </div> 
                             <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password"  id="passwordbaru" name="passwordbaru" class="form-control" data-error=".errorTxt1" />
                                    <label class="form-label">Password Baru</label>
                                </div>
                                <div class="errorTxt1"></div>
                            </div>  
                           
                            <div class="form-group" >
                                 <button type="submit"  name="submit" class="btn bg-blue waves-effect">
                                    <i class="material-icons">save</i>
                                    <span>SIMPAN</span>
                                </button>
                                <a href="<?php echo base_url('setting/ubah_password'); ?>" class="btn bg-red waves-effect">
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
   
</div>   
