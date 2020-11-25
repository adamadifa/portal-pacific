<section id="about" class="about">
	<div class="container-fluid" data-aos="fade-up">
		<div class="row">
			<div class='col-md-4'>
				<div class="row mb-3">
					<div class="col-md-12">
						<div id='team' class='team'>
							<div class='container' data-aos='fade-up'>
								<div class='member d-flex align-items-start' data-aos='zoom-in' data-aos-delay='100'>
									<div class='pic'><img src='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/team/team-1.jpg' class='img-fluid' alt=''></div>
									<div class='member-info'>
										<h4>K.H Ukar Sukarya</h4>
										<span>Pimpinan Pesantren</span>
										<p>Bismillahirrahmaanirrahimm.. ا لسَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ Kemajuan teknologi informasi begitu cepat dan pesat juga merambah seluruh bidang kehidupan tak…</p>
										<p><a href="">Selengkapnya ></a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="ml-3">
							<iframe style="width:100%;" height="300" src="https://www.youtube.com/embed/D9UahfLm4fU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="ml-3">
							<?php
							$tag = $this->model_utama->view_ordering_limit('tag', 'id_tag', 'RANDOM', 0, 50);
							foreach ($tag->result_array() as $row) {
								echo "<a href='" . base_url() . "tag/detail/$row[tag_seo]' class='btn btn-outline-success btn-sm ml-2 mt-2'>$row[nama_tag]</a>";
							}
							?>

						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="section-title">
					<h2> <i class="fa fa-bar-chart-o mr-2"></i>Nilai Yang Dikembangkan</h2>
				</div>
				<div id='why-us' class='why-us section-bg'>
					<div class='container-fluid' data-aos='fade-up'>
						<div class='d-flex flex-column justify-content-center'>
							<div class='accordion-list mt-3'>
								<ul>
									<li>
										<a data-toggle='collapse' class='collapse' href='#accordion-list-1'><span>01</span> Mahabbah - محبة <i class='bx bx-chevron-down icon-show'></i><i class='bx bx-chevron-up icon-close'></i></a>
										<div id='accordion-list-1' class='collapse show' data-parent='.accordion-list'>
											<p>
												Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur
												gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
											</p>
										</div>
									</li>

									<li>
										<a data-toggle='collapse' href='#accordion-list-2' class='collapsed'><span>02</span> Ta'awun - تعاون <i class='bx bx-chevron-down icon-show'></i><i class='bx bx-chevron-up icon-close'></i></a>
										<div id='accordion-list-2' class='collapse' data-parent='.accordion-list'>
											<p>
												Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet
												id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est
												pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt
												dui.
											</p>
										</div>
									</li>

									<li>
										<a data-toggle='collapse' href='#accordion-list-3' class='collapsed'><span>03</span> Mujahadah - مجاھدة <i class='bx bx-chevron-down icon-show'></i><i class='bx bx-chevron-up icon-close'></i></a>
										<div id='accordion-list-3' class='collapse' data-parent='.accordion-list'>
											<p>
												Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar
												elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque
												eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis
												sed odio morbi quis
											</p>
										</div>
									</li>
									<li>
										<a data-toggle='collapse' href='#accordion-list-3' class='collapsed'><span>04</span> Amanah - أمانة <i class='bx bx-chevron-down icon-show'></i><i class='bx bx-chevron-up icon-close'></i></a>
										<div id='accordion-list-3' class='collapse' data-parent='.accordion-list'>
											<p>
												Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar
												elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque
												eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis
												sed odio morbi quis
											</p>
										</div>
									</li>
									<li>
										<a data-toggle='collapse' href='#accordion-list-3' class='collapsed'><span>05</span> Tawadu' - تواضع <i class='bx bx-chevron-down icon-show'></i><i class='bx bx-chevron-up icon-close'></i></a>
										<div id='accordion-list-3' class='collapse' data-parent='.accordion-list'>
											<p>
												Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar
												elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque
												eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis
												sed odio morbi quis
											</p>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="section-title">
					<h2> <i class="fa fa-newspaper-o mr-2"></i>Berita Terbaru</h2>
				</div>
				<?php
				$no = 1;
				$hot = $this->model_utama->view_join_two('berita', 'users', 'kategori', 'username', 'id_kategori', array('status' => 'Y'), 'tanggal', 'DESC', 0, 3);
				foreach ($hot->result_array() as $row) {
					$total_komentar = $this->model_utama->view_where('komentar', array('id_berita' => $row['id_berita']))->num_rows();
					$tgl = tgl_indo($row['tanggal']);
					$isi_berita = (strip_tags($row['isi_berita']));
					$isi = substr($isi_berita, 0, 170);
					$isi = substr($isi_berita, 0, strrpos($isi, " "));
					$judul = $row['judul'];
				?>
					<div class="card mb-3">
						<div class="card-body ">

							<?php
							if ($row['gambar'] == '') {
								echo "<img src='" . base_url() . "asset/foto_berita/no-image.jpg' class='rounded float-left mr-3' style='width:200px; height:150px' alt='no-image.jpg'>";
							} else {
								echo "<img src='" . base_url() . "asset/foto_berita/$row[gambar]' alt='$row[gambar]' class='rounded float-left mr-3' style='width:200px; height:150px'>";
							}
							?>
							<h5 class="card-title"><?php echo "<a title='$row[judul]' href='" . base_url() . "$row[judul_seo]'>$judul</a>"; ?></h5>
							<h6 class="card-subtitle mb-2 text-muted">
								<?php
								echo "<a href='" . base_url() . "kategori/detail/$row[kategori_seo]'><b>$row[nama_kategori]</b></a>
									<a href='" . base_url() . "$row[judul_seo]'><span class='icon-text'>&#128340;</span>$row[jam], " . tgl_indo($row['tanggal']) . "</a>";
								?>
							</h6>
							<p class="card-text"><?php echo $isi . ". . ."; ?></p>


						</div>
					</div>
				<?php
				}
				?>

			</div>
		</div>
	</div>
</section>
<section id='cta' class='cta'>
	<div class='container' data-aos='zoom-in'>

		<div class='row'>
			<div class='col-lg-9 text-center text-lg-left'>
				<h3>Informasi Penerimaan Santri Baru 2021/2022</h3>
				<p> Untuk Mengetahui Informasi Penerimaan Santri Baru Pesantren Persatuan Islam Al Amin Sindangkasih Silahkan Klik Tombol Pendaftaran</p>
			</div>
			<div class='col-lg-3 cta-btn-container text-center'>
				<a class='cta-btn align-middle' href='#'>Pendaftaran</a>
			</div>
		</div>

	</div>
</section>
<section>
	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div id='portfolio' class='portfolio'>

						<div class="container-fluid" data-aos='fade-up'>
							<div class='section-title'>
								<h2><i class="fa fa-graduation-cap mr-2"></i>PROGRAM PENDIDIKAN</h2>
							</div>
							<div class='row portfolio-container' data-aos='fade-up' data-aos-delay='200'>
								<div class='col-lg-3 col-md-6 portfolio-item filter-app'>
									<div class='portfolio-img'><img src='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/portfolio/portfolio-2.jpg' class='img-fluid' alt=''></div>
									<div class='portfolio-info'>
										<h4>TK CALISHA Al AMIN</h4>
										<p>TK Calisha Al Amin</p>
										<a href='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/portfolio/portfolio-2.jpg' data-gall='portfolioGallery' class='venobox preview-link' title='App 1'><i class='bx bx-plus'></i></a>
										<a href='portfolio-details.html' class='details-link' title='More Details'><i class='bx bx-link'></i></a>
									</div>
								</div>
								<div class='col-lg-3 col-md-6 portfolio-item filter-app'>
									<div class='portfolio-img'><img src='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/portfolio/portfolio-2.jpg' class='img-fluid' alt=''></div>
									<div class='portfolio-info'>
										<h4>SDIT AL AMIN</h4>
										<p>SDIT Al Amin</p>
										<a href='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/portfolio/portfolio-2.jpg' data-gall='portfolioGallery' class='venobox preview-link' title='App 1'><i class='bx bx-plus'></i></a>
										<a href='portfolio-details.html' class='details-link' title='More Details'><i class='bx bx-link'></i></a>
									</div>
								</div>
								<div class='col-lg-3 col-md-6 portfolio-item filter-app'>
									<div class='portfolio-img'><img src='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/portfolio/portfolio-2.jpg' class='img-fluid' alt=''></div>
									<div class='portfolio-info'>
										<h4>MTS PERSIS AL AMIN</h4>
										<p>MTs Persis Al Amin</p>
										<a href='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/portfolio/portfolio-2.jpg' data-gall='portfolioGallery' class='venobox preview-link' title='App 1'><i class='bx bx-plus'></i></a>
										<a href='portfolio-details.html' class='details-link' title='More Details'><i class='bx bx-link'></i></a>
									</div>
								</div>
								<div class='col-lg-3 col-md-6 portfolio-item filter-app'>
									<div class='portfolio-img'><img src='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/portfolio/portfolio-2.jpg' class='img-fluid' alt=''></div>
									<div class='portfolio-info'>
										<h4>MA PERSIS AL AMIN</h4>
										<p>MA Persis Al Amin</p>
										<a href='<?php echo base_url(); ?>template/<?php echo template(); ?>/assets/img/portfolio/portfolio-2.jpg' data-gall='portfolioGallery' class='venobox preview-link' title='App 1'><i class='bx bx-plus'></i></a>
										<a href='portfolio-details.html' class='details-link' title='More Details'><i class='bx bx-link'></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-12">
					<div id='contact' class='contact'>
						<div class="container-fluid" data-aos='fade-up'>
							<div class='row'>
								<div class='col-lg-6 d-flex align-items-stretch'>
									<div class='info'>
										<div class='address'>
											<i class='icofont-google-map'></i>
											<h4>Location:</h4>
											<p>A108 Adam Street, New York, NY 535022</p>
										</div>
										<iframe src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621' frameborder='0' style='border:0; width: 100%; height: 290px;' allowfullscreen></iframe>
									</div>
								</div>
								<div class='col-lg-6 d-flex align-items-stretch'>
									<div class='info'>
										<div class='address'>
											<i class='icofont-chat'></i>
											<h4>Jejak Pendapat</h4>
											<p>Pendapat Anda Sangat Berarti Untuk Pengembangan Website Ini</p>
										</div>
										<?php
										$t = $this->model_utama->view('poling', array('aktif' => 'Y', 'status' => 'Pertanyaan'))->row_array();
										echo " <div style='color:#000; font-weight:bold;' class='mb-2'>$t[pilihan] <br></div>";
										echo "<form method=POST action='" . base_url() . "polling/hasil'>";
										$pilih = $this->model_utama->view_where('poling', array('aktif' => 'Y', 'status' => 'Jawaban'));
										foreach ($pilih->result_array() as $p) {
											echo "<input class=marginpoling type=radio name=pilihan value='$p[id_poling]' />
										<class style=\"color:#666;font-size:14px;\">&nbsp;&nbsp;$p[pilihan]<br />";
										}
										echo "<br><center><input style='width: 110px;' class='btn btn-success btn-sm' type=submit class=simplebtn value='PILIH' />
									</form>
									<a href='" . base_url() . "polling'>
									<input style='width: 110px;' class='btn btn-warning btn-sm' type=button class=simplebtn value='LIHAT HASIL' /></a></center>";
										?>
									</div>
								</div>
							</div>
						</div>
					</div><!-- End Contact Section -->
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div id='portfolio' class='portfolio'>
						<div class="container-fluid" data-aos='fade-up'>
							<div class='section-title'>
								<h2><i class="fa fa-calendar-o mr-2"></i>AGENDA KEGIATAN</h2>
							</div>
							<?php
							$agenda = $this->model_utama->view_ordering_limit('agenda', 'tgl_mulai', 'DESC', 0, 4);
							foreach ($agenda->result_array() as $r) {
								$tgl_posting = tgl_indo($r['tgl_posting']);
								$tgl_mulai   = tgl_indo($r['tgl_mulai']);
								$tgl_selesai = tgl_indo($r['tgl_selesai']);
								$tanggal = explode("-", $r['tgl_mulai']);
								$daftar_hari = array(
									'Sunday' => 'Minggu',
									'Monday' => 'Senin',
									'Tuesday' => 'Selasa',
									'Wednesday' => 'Rabu',
									'Thursday' => 'Kamis',
									'Friday' => 'Jumat',
									'Saturday' => 'Sabtu'
								);
								$daftar_bulan = array(
									'01' => 'Jan',
									'02' => 'Feb',
									'03' => 'Mar',
									'04' => 'Apr',
									'05' => 'Mei',
									'06' => 'Jun',
									'07' => 'Jul',
									'8' => 'Agu',
									'09' => 'Sep',
									'10' => 'Okt',
									'11' => 'Nov',
									'12' => 'Des'
								);
								$namahari = date('l', strtotime($r['tgl_mulai']));
								$baca = $r['dibaca'] + 1;
								$judull = substr($r['tema'], 0, 33);
								$isi_agenda = (strip_tags($r['isi_agenda']));
								$isi = substr($isi_agenda, 0, 100);
								$isi = substr($isi_agenda, 0, strrpos($isi, " "));
							?>
								<div class="row row-striped">
									<div class="col-2 text-center">
										<h1><span class="badge badge-warning text-white"><?php echo $tanggal[2]; ?></span></h1>
										<h4><?php echo strtoupper($daftar_bulan[$tanggal[1]]); ?></h4>
									</div>
									<div class="col-10 mt-2">
										<h5 class="text-uppercase" style="margin-bottom:5px !important"><strong><a href="<?php echo base_url(); ?>agenda/detail/<?php echo $r['tema_seo']  ?>"><?php echo $judull; ?></a></strong></h5>
										<ul class="list-inline" style="font-size:14px; margin-bottom:5px !important; color:#438142">
											<li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $daftar_hari[$namahari]; ?></li>
											<li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $r['jam']; ?></li>
											<li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i> <?php echo $r['tempat']; ?></li>
										</ul>
										<p style="font-size:14px"><?php echo $isi; ?></p>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>