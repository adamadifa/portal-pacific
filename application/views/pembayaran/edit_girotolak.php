
<div class="card">
    <div class="header bg-cyan">
        <h2>
            Update Pembayaran Giro
            <small>Update Data Pembayaran Giro</small>
        </h2>
        
    </div>
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-12">
                 <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>pembayaran/editgirotolak">
                    <input type="hidden" name="id_giro" value="<?php echo $giro['id_giro']; ?>">
                    <input type="hidden" name="nofaktur" value="<?php echo $giro['no_fak_penj']; ?>">
                    <input type="hidden" name="nogiro" value="<?php echo $giro['no_giro']; ?>">
                    <input type="hidden" name="namabank" value="<?php echo $giro['namabank']; ?>">
                    <input type="hidden" name="materai" value="<?php echo $giro['materai']; ?>">
                    <input type="hidden" name="jumlah" value="<?php echo $giro['jumlah']; ?>">

                    <table class="table">
                         <tr>
                            <td><b>No Faktur</b></td>
                            <td>:</td>
                            <td><?php echo $giro['no_fak_penj']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Nama Pelanggan</b></td>
                            <td>:</td>
                            <td><?php echo $giro['nama_pelanggan']; ?></td>
                        </tr>
                        <tr>
                            <td><b>No Giro</b></td>
                            <td>:</td>
                            <td><?php echo $giro['no_giro']; ?></td>
                        </tr>
                         <tr>
                            <td><b>Nama Bank</b></td>
                            <td>:</td>
                            <td><?php echo $giro['namabank']; ?></td>
                        </tr>
                         <tr>
                            <td><b>Materai</b></td>
                            <td>:</td>
                            <td><?php echo $giro['materai']; ?></td>
                        </tr>
                         <tr>
                            <td><b>Jumlah</b></td>
                            <td>:</td>
                            <td><?php echo number_format($giro['jumlah'],'0','','.'); ?></td>
                        </tr>
                        <tr>
                            <td><b>Jatuh Tempo</b></td>
                            <td>:</td>
                            <td><?php echo DateToIndo2($giro['tglcair']); ?></td>
                        </tr>

                    </table>
                   
               
                    <label>Tanggal Mundur</label>
                    <div class="input-group demo-masked-input"  >
                        <span class="input-group-addon">
                            <i class="material-icons">date_range</i>
                        </span>
                        <div class="form-line">
                            <input type="text"   value="<?php echo date('Y-m-d'); ?>"  id="tglcair" name="tglcair" class="datepicker form-control date" placeholder="Tanggal Cair" data-error=".errorTxt1" />
                           
                        </div>
                        <div class="errorTxt1"></div>
                    </div>
              
                    
                     <div class="form-group" style="margin-left:350px" >
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

<script type="text/javascript">
    
    $(function(){
        
      
            
        $('.datepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false
        });

        

    });

</script>