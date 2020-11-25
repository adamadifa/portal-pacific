<script type="text/javascript">
	
		$(function(){


			$("#formValidate").validate({
            rules: {
                nofaktur      :"required",
                tgltransaksi  :"required",
                pelanggan 	  :"required",
                salesman 	  :"required",
                
            },
            //For custom messages
            messages: {
                
                nofaktur      :"No Faktur Harus Diisi !",
                tgltransaksi  :"Tanggal harus Diisi",
                pelanggan 	  :"Pelanggan Harus Diisi",
                salesman 	  :"Salesman Harus Diisi",
                
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

			$('.datepicker').bootstrapMaterialDatePicker({
		        format: 'YYYY-MM-DD',
		        clearButton: true,
		        weekStart: 1,
		        time: false
		    });

			function loadDataTmp(){

				$("#loadpnjtmp").load("<?php echo base_url();?>penjualan/view_detailtmp");
			}

			function hitungjatuhtempo(){

	  			var tgltransaksi = $("#tgltransaksi").val();
				$.ajax({
					type	:'POST',
					url 	:"<?php echo base_url(); ?>penjualan/hitungjatuhtempo",
					data    :{tgltransaksi:tgltransaksi},
					cache	:false,
					success : function(respond){
						$("#jatuhtempo").val(respond);
					}

				});
	  		}

			function kosong(){

				$("#Bjatuhtempo").hide();
				$("#Btitipan").hide();
				$("#Bmaterai").hide();
				$("#Bnamabank").hide();
				$("#Btglcair").hide();
				$("#Bbayar").hide();
				$("#Buanglebih").hide();

			}

			function showTitipan(){

				$("#Bjatuhtempo").show();
				$("#Btitipan").show();
				$("#Bmaterai").hide();
				$("#Bnamabank").hide();
				$("#Btglcair").hide();
				$("#Bbayar").hide();
				$("#Buanglebih").hide();
			}

			function showGiro(){
				$("#Bbayar").hide();
				$("#Buanglebih").hide();
				$("#Bjatuhtempo").hide();
				$("#Btitipan").hide();
				$("#Bmaterai").show();
				$("#Bnamabank").show();
				$("#Btglcair").show();

			}

			function showTransfer(){
				$("#Bbayar").hide();
				$("#Buanglebih").hide();
				$("#Bjatuhtempo").hide();
				$("#Btitipan").hide();
				$("#Bmaterai").hide();
				$("#Bnamabank").hide();
				$("#Btglcair").show();
			}

			function showTunai(){

				$("#Bbayar").show();
				$("#Buanglebih").show();
				$("#Bjatuhtempo").hide();
				$("#Btitipan").hide();
				$("#Bmaterai").hide();
				$("#Bnamabank").hide();
				$("#Btglcair").hide();
			}
			
			
			function ResetBrg(){

				$("#kodebarang").val("");
				$("#barang").val("");
				$("#hargadus").val("");
				$("#hargapack").val("");
				$("#hargapcs").val("");
				$("#stokdus").val("");
				$("#stokpcs").val("");
				$("#stok").val("");
				$("#isipcsdus").val("");
				$("#isipcspack").val("");
				$("#stokpack").val("");
				$("#jmlpcs").val(0);
				$("#jmlpack").val(0);
				$("#jmldus").val(0);


			}		
			
			
			kosong();
			loadDataTmp();
			hitungjatuhtempo();



			$("#bayar").change(function(){
				var totalbayar	= $("#totalbayar").val();
				var bayar 		= $("#bayar").val();

				if(bayar < totalbayar){

					swal("Oops!", "Jumlah Bayar Kurang !", "warning");

				}



			});


			$("#tgltransaksi").change(function(){

				hitungjatuhtempo();

			});

			$("#pelanggan").click(function() {

				 $("#datapelanggan").modal("show");


			});

			$("#jenistransaksi").change(function(){
				var jt = $("#jenistransaksi").val();
				$.ajax({

					type 	: 'POST',
					url 	: '<?php echo base_url(); ?>penjualan/jenistransaksi',
					data 	: {jt:jt},
					cache 	: false,
					success : function(respond){
						console.log(respond);
						$("#jenisbayar").html(respond);
						$("#jenisbayar").selectpicker("refresh");
					}



				});


			});

			$("#jenisbayar").change(function(){

				var jenisbayar = $("#jenisbayar").val();
				if (jenisbayar == "titipan"){
					
					showTitipan();

				}else if(jenisbayar=="giro"){
					showGiro();
				}else if(jenisbayar=="transfer"){
					showTransfer();
				}else if(jenisbayar=="tunai"){
					showTunai();
				}else{

					kosong();
				}

			});

			$("#jenistransaksi").change(function(){
				kosong();

			});

			$("#barang").click(function() {
				var kodecabang = $("#kodecabang").val();
				var pelanggan  = $("#pelanggan").val();
				if(pelanggan == ""){

					swal("Oops!", "Nama Pelanggan Harus Diisi Terlebih Dahulu !", "warning");
					$("#pelanggan").focus();
				}else{

					$("#databarang").modal("show");
					$.ajax({

						type 	: 'POST',
						url 	: '<?php echo base_url(); ?>barang/view_barangcab',
						data 	: {kodecabang:kodecabang},
						cache 	: false,
						success : function(respond){
							//alert(kodecabang);
							$("#loadBarang").html(respond);

						}



					});
				}

			});

			$('.js-exportable').DataTable({

				 bLengthChange: false,
			});

			
			$("#kodebarang").change(function(){
				var id = $("#kodebarang").val();
				$.ajax({

					type  	: 'POST',
					url   	: '<?php echo base_url();?>penjualan/get_barang',
					data  	: {kodebarang:id},
					cache 	: false,
					success	: function(respond){
						data=respond.split("|");
						$("#satuan").val(data[0]);
						$("#hargadus").val(data[1]);
						$("#hargapack").val(data[2]);
						$("#hargapcs").val(data[3]);
						var hargapack =  $("#hargapack").val();

						if(hargapack == 0){

							$("#pack").hide();
						}else{
							$("#pack").show();
						}



					}
				});



			});

			$("#tambahbarang").click(function(e){
				var kodebarang = $("#kodebarang").val();
				var jmldus 	   = $("#jmldus").val();
				var hargadus   = $("#hargadus").val();
				var jmlpack    = $("#jmlpack").val();
				var hargapack  = $("#hargapack").val();
				var jmlpcs 	   = $("#jmlpcs").val();
				var hargapcs   = $("#hargapcs").val();
				var isipcsdus  = $("#isipcsdus").val();
				var isipcspack = $("#isipcspack").val();
				var stok 	   = $("#stok").val();
				var jumlahpcs  = (jmldus * isipcsdus) + (jmlpack * isipcspack) + (jmlpcs * 1);
				e.preventDefault();
				if(kodebarang ==""){
					swal("Oops!", "Silahkan Pilih Barang Terlebih Dahulu !", "warning");
				}
				else if(jmldus == 0 && jmlpack ==0 && jmlpcs== 0){

					swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");
			
				}else if(jumlahpcs > stok){

					swal("Oops!", "Stok Tidak Memenuhi !" , "warning");
			
				}else{
						$.ajax({

							type  	: 'POST',
							url   	: '<?php echo base_url();?>penjualan/insert_detailtmp',
							data  	: {
										kodebarang:kodebarang,
										jmldus:jmldus,
										hargadus:hargadus,
										jmlpack:jmlpack,
										hargapack:hargapack,
										jmlpcs:jmlpcs,
										hargapcs:hargapcs
								  	},
							cache 	: false,
							success : function(respond){
								ResetBrg();
								loadDataTmp();
								
							}


						});
				}

			});

			//Datatables Pelanggan 

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