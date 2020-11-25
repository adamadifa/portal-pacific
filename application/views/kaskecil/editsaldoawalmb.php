
<div class="card">
    <div class="header bg-cyan">
        <h2>
            Edit Saldo Awal Mutasi Bank
            <small>Input Saldo Awal Mutasi Bank</small>
        </h2>

    </div>
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-12">
               <form autocomplete="off" class="formValidate" id="saldoawal"  method="POST" action="<?php echo base_url(); ?>kaskecil/update_saldoawalmb">
                 <div class="row">
                   <div class="body">
                      <label>Tanggal</label>
                      <div class="input-group demo-masked-input"  >
                          <span class="input-group-addon">
                              <i class="material-icons">date_range</i>
                          </span>
                          <div class="form-line">
                              <input type="text" value="<?php echo $saldoawal['tgl_mutasi']; ?>"   id="tanggal" name="tanggal" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt1" />

                          </div>
                          <div class="errorTxt1"></div>
                      </div>
                     <label>Jumlah</label>
                     <div class="input-group demo-masked-input"  >
                         <span class="input-group-addon">
                             <i class="material-icons">chrome_reader_mode</i>
                         </span>
                         <div class="form-line">
                             <input type="text" value="<?php echo number_format($saldoawal['jumlah'],'0','','.'); ?>"  style="text-align:right"  id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" data-error=".errorTxt2" />
                         </div>
                         <div class="errorTxt2"></div>
                     </div>
                  </div>
                </div>
                <div class="row">
                  <div class="body">
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
                  </div>
                </div>
               </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var jumlah = document.getElementById('jumlah');
    jumlah.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        jumlah.value = formatRupiah(this.value, '');
    });


		/* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }
</script>
<script type="text/javascript">
	$(function(){
    $('.datepicker').bootstrapMaterialDatePicker({
				format: 'YYYY-MM-DD',
				clearButton: true,
				weekStart: 1,
				time: false
		});

    $("#saldoawal").submit(function(){
       var tanggal       = $("#tanggal").val();
       var jumlah        = $("#jumlah").val();
       if(tanggal == ""){
           swal("Oops!", "Tanggal Masih Kosong!", "warning");
           $("#tanggal").focus()
           return false;
       }else if(jumlah == ""){
           swal("Oops!", "Jumlah Masih Kosong!", "warning");
           $("#jumlah").focus()
           return false;
       }else{
         return true;
       }
    });
	});
</script>
