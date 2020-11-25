
<div class="card">
    <div class="header bg-cyan">
        <h2>
            Data Chart Of Account
            <small>Input Data Chart Of Account</small>
        </h2>

    </div>
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-12">
                 <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>coa/input_coa">

                   <label for="kode_pelanggan">*Kode Akun</label>
                   <div class="form-group" >
                       <div class="form-line">
                           <input type="text"  id="kode_akun" value="<?php echo $akun['kode_akun']; ?>" readonly name="kode_akun" class="form-control" placeholder="Kode Akun" data-error=".errorTxt1" />

                       </div>
                       <div class="errorTxt1"></div>
                   </div>
                   <label for="nama_akun">*Nama Akun</label>
                   <div class="form-group" >
                       <div class="form-line">
                           <input type="text" value="<?php echo $akun['nama_akun']; ?>"  id="nama_akun" name="nama_akun" class="form-control" placeholder="Nama Akun" data-error=".errorTxt1" />

                       </div>
                       <div class="errorTxt1"></div>
                   </div>
                   <label>*Sub AKun</label>
                   <div class="form-group">
                       <div class="form-line">
                           <select class="form-control show-tick" id="sub_akun" name="sub_akun" data-error=".errorTxt6">
                              <option value="0" <?php if($akun['sub_akun']=='0'){echo "selected";} ?>>-- Is Main Header --</option>
                              <?php
                                foreach($coa as $r){
                                $cek = $this->db->get_where('coa',array('sub_akun'=>$r->kode_akun))->num_rows();
                              ?>
                                <option <?php if($akun['sub_akun']==$r->kode_akun){echo "selected";} ?> value="<?php echo $r->kode_akun; ?>"><b><?php echo $r->kode_akun." ".$r->nama_akun; ?></b></option>
                                <?php
                                if($cek !=0){
                                  $subheader = $this->db->get_where('coa',array('sub_akun'=>$r->kode_akun))->result();
                                    foreach($subheader as $s){
                                      $cek2 = $this->db->get_where('coa',array('sub_akun'=>$s->kode_akun))->num_rows();
                                ?>
                                      <option <?php if($akun['sub_akun']==$s->kode_akun){echo "selected";} ?> value="<?php echo $s->kode_akun; ?>"><b><?php echo "-------------".$s->kode_akun." ".$s->nama_akun; ?></b></option>
                                <?php
                                    }
                                }
                                ?>
                              <?php
                                }
                             ?>

                           </select>
                       </div>
                        <div class="errorTxt6"></div>
                   </div>
                   <div class="form-group" >
                       <button type="submit"  name="submit" class="btn bg-blue waves-effect">
                          <i class="material-icons">save</i>
                          <span>SIMPAN</span>
                      </button>
                      <button type="button" data-dismiss="modal" class="btn bg-red waves-effect">
                          <i class="material-icons">cancel</i>
                          <span>Batal</span>
                      </button>
                  </div>
                 </form>
            </div>
        </div>
    </div>
</div>




<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/forms/advanced-form-elements.js"></script>
<script>
  $(function(){
    $("#sub_akun").selectpicker("refresh");
    $("form").submit(function(){

       var kode_akun     = $("#kode_akun").val();
       var nama_akun     = $("#nama_akun").val();

       if(kode_akun == ""){
           swal("Oops!", "Kode Akun Masih Kosong!", "warning");
           return false;
       }else if(nama_akun == ""){
           swal("Oops!", "Nama Akun BPBJ Masih Kosong!", "warning");
           return false;
       }else{
           return true;
       }


    });

  });
</script>
