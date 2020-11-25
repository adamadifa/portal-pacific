<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>gudangbahan/insert_pemasukan">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <!-- Content here -->
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Input Data Barang</h4>
                </div>
                <div class="card-body">
                  <label>*Kode Barang</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="kodebarang" name="kodebarang" class="form-control" placeholder="Kode Barang" data-error=".errorTxt1" />

                    </div>
                    <div class="errorTxt1"></div>
                  </div>
                  <label>*Nama Barang</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="namabarang" name="namabarang" class="form-control" placeholder="Nama Barang" data-error=".errorTxt2" />

                    </div>
                    <div class="errorTxt2"></div>
                  </div>
                  <label>*Kategori</label>
                  <div class="form-group">
                    <div class="form-line">
                      <select class="form-control" id="kategori" name="kategori" data-error=".errorTxt3">
                        <option value=""> -- Pilih Kategori -- </option>
                        <option value="SWAN">SWAN</option>
                        <option value="AIDA">AIDA</option>
                      </select>

                    </div>
                    <div class="errorTxt3"></div>
                  </div>
                  <label>*Satuan</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="satuan" name="satuan" class="form-control" placeholder="Satuan" data-error=".errorTxt14" />

                    </div>
                    <div class="errorTxt14"></div>
                  </div>
                  <label>*Jml Pcs /Dus</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="jmlpcsdus" name="jmlpcsdus" class="form-control" placeholder="Jumlah Pcs / Dus" data-error=".errorTxt15" />

                    </div>
                    <div class="errorTxt15"></div>
                  </div>
                  <label>*Jml Pack /Dus</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="jmlpackdus" name="jmlpackdus" class="form-control" placeholder="Jumlah Pack / Dus" data-error=".errorTxt16" />

                    </div>
                    <div class="errorTxt16"></div>
                  </div>
                  <label>*Jml Pcs /Pack</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="jmlpcspack" name="jmlpcspack" class="form-control" placeholder="Jumlah Pcs / Pack" data-error=".errorTxt17" />

                    </div>
                    <div class="errorTxt17"></div>
                  </div>
                  <label>*Harga/Dus</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="hargadus" name="hargadus" class="form-control" placeholder="Harga / Dus" data-error=".errorTxt4" />

                    </div>
                    <div class="errorTxt4"></div>
                  </div>
                  <label>*Harga/Pack</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="hargapack" name="hargapack" class="form-control" placeholder="Harga / Pack" data-error=".errorTxt5" />

                    </div>
                    <div class="errorTxt5"></div>
                  </div>
                  <label>*Harga/Pcs</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="hargapcs" name="hargapcs" class="form-control" placeholder="Harga / Pcs" data-error=".errorTxt6" />

                    </div>
                    <div class="errorTxt6"></div>
                  </div>
                  <label>*Harga Retur/Dus</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="hargareturdus" name="hargareturdus" class="form-control" placeholder="Harga / Dus" data-error=".errorTxt7" />

                    </div>
                    <div class="errorTxt7"></div>
                  </div>
                  <label>*Harga Retur/Pack</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="hargareturpack" name="hargareturpack" class="form-control" placeholder="Harga / Pack" data-error=".errorTxt8" />

                    </div>
                    <div class="errorTxt8"></div>
                  </div>
                  <label>*Harga Retur/Pcs</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="hargareturpcs" name="hargareturpcs" class="form-control" placeholder="Harga / Pcs" data-error=".errorTxt9" />

                    </div>
                    <div class="errorTxt9"></div>
                  </div>

                  <label>*Stok Dus</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="stokdus" name="stokdus" class="form-control" placeholder="Stok Dus" data-error=".errorTxt10" />

                    </div>
                    <div class="errorTxt10"></div>
                  </div>

                  <label>*Stok Pack</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="stokpack" name="stokpack" class="form-control" placeholder="Stok Pack" data-error=".errorTxt11" />

                    </div>
                    <div class="errorTxt11"></div>
                  </div>

                  <label>*Stok Pcs</label>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="stokpcs" name="stokpcs" class="form-control" placeholder="Stok Pcs" data-error=".errorTxt12" />

                    </div>
                    <div class="errorTxt12"></div>
                  </div>
                  <label>*Cabang</label>
                  <div class="form-group">
                    <div class="form-line">
                      <select class="form-control" id="cabang" name="cabang" data-error=".errorTxt13">
                        <option value="">-- Pilih Cabang -- </option>

                        <?php foreach ($cabang as $c) { ?>
                          <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="errorTxt13"></div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="submit" class="btn bg-blue waves-effect">
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>






<script type="text/javascript">
  $(function() {



    $("#cabang").change(function() {

      id = $("#cabang").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pelanggan/get_salespel',
        data: {
          kode_cabang: id
        },
        cache: false,
        success: function(respond) {

          $("#salesman").html(respond);


        }
      });

    });
    $("#formValidate").validate({
      rules: {
        kodebarang: "required",
        namabarang: "required",
        kategori: "required",
        satuan: "required",
        hargadus: "required",
        hargapack: "required",
        hargapcs: "required",
        hargareturdus: "required",
        hargareturpack: "required",
        hargareturpcs: "required",
        stokdus: "required",
        stokpack: "required",
        stokpcs: "required",
        cabang: "required",
        jmlpcsdus: "required",
        jmlpackdus: "required",
        jmlpcspack: "required",
      },
      //For custom messages
      messages: {

        kodebarang: "Kode Barang Harus Diisi !",
        namabarang: "Nama Barang Harus Diisi !",
        kategori: "Kategori Harus Diisi !",
        satuan: "Satuan Harus Diisi !",
        hargadus: "Harga Dus Harus Diisi !",
        hargapack: "Harga Pack Harus Diisi !",
        hargapcs: "Harga Pcs Harus Diisi !",
        hargareturdus: "Harga Retur Dus Harus Diisi !",
        hargareturpack: "Harga Retur Pack Harus Diisi !",
        hargareturpcs: "Harga Retur PCs Harus Diisi !",
        stokdus: "Stok Dus Harus Diisi !",
        stokpack: "Stok Pack Harus Diisi !",
        stokpcs: "Stok Pcs Harus Diisi !",
        cabang: "Cabang Harus Diisi !",
        jmlpcsdus: "Jumlah Pcs / Dus Harus Diisi !",
        jmlpackdus: "Jumlah Pack / Dus Harus Diisi !",
        jmlpcspack: "Jumlah Pcs / Pack Harus Diisi !",
      },
      errorElement: 'div',
      errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error)
        } else {
          error.insertAfter(element);
        }
      }
    });


  });
</script>