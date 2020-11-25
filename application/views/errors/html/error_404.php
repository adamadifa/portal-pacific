<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>
	<style type="text/css">
		#error-page {
			background-color:#e9e9e9;
			position:fixed !important;
			position:absolute;
			text-align:center;
			top:0;
			right:0;
			bottom:0;
			left:0;
			z-index:99999;
		}
		#error-inner {
			margin:11% auto;
		}
		#error-inner .box-404 {
			position:relative;
			font-weight:bold;
			width:220px;
			height:210px;
			background:#cd0000;
			color:#fff;
			font-size:80px;
			line-height:200px;
			margin:0 auto 25px;
		}

		#error-inner .box-404::after {content:""; width:0;  height:0;  position:absolute; top:0;  right:0;  border-width:30px;  border-style:solid;  border-color:#e9e9e9 #e9e9e9 transparent transparent;  display:block;}
		#error-inner .box-404::before {content:""; width:0;  height:0;  position:absolute; top:0;  left:0;  border-width:30px;  border-style:solid;  border-color:#e9e9e9 transparent transparent #e9e9e9;  display:block;}
		#error-inner .boxx-404::after {content:""; width:0;  height:0;  position:absolute; bottom:0;  left:0;  border-width:30px;  border-style:solid;  border-color:transparent transparent #e9e9e9 #e9e9e9;  display:block;}
		#error-inner .boxx-404::before {content:""; width:0;  height:0;  position:absolute; bottom:0;  right:0;  border-width:30px;  border-style:solid;  border-color:transparent #e9e9e9 #e9e9e9 transparent;  display:block;}

		#error-inner h2 {text-transform:uppercase;color:#cd0000;font-size:50px;margin:0 auto 20px;font-family:monospace}
		#error-inner h1 {text-transform:uppercase;color:#399edf;}
		#error-inner p {line-height:0.7em;font-size:15px;color:#999;}/code>
	</style>
</head>
<body>
	<div id="container">
		<b:if cond='data:blog.pageType == &quot;error_page&quot;'>
		<div id='error-page'>
			<div id='error-inner'>
				<h2>ERROR</h2>
				<div class='box-404'><div class='boxx-404'>404</div></div>
				<h1>Halaman tidak ditemukan</h1>
				<p>Kemungkinan halaman telah dihapus, atau anda salah menulis URL blog<br/><br/>
					Kembali ke beranda <a href='<?php echo base_url();?>' title='MayCyber-Download'>Kembali</a></p>
				</div>
			</div>
		</b:if>
	</div>
</body>
</html>