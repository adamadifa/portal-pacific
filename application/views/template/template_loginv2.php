<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}


		html,
		body {
			height: 100%;
		}



		/*body*/

		body {
			font-family: 'Montserrat', sans-serif;
			background-color: #f5f5f5;
			font-size: 1rem;
			line-height: 1.55;
			display: flex;
			justify-content: center;
			align-items: center;
			background: linear-gradient(60deg, rgba(22, 131, 194, 0.8), rgba(17, 79, 212, 0.9)),
				url('<?php echo base_url(); ?>assets/images/bg.jpg') center center;
			background-size: cover;
		}

		/*Login Styles*/

		.login__card {
			width: 900px;
			display: flex;
			justify-content: space-between;
			background-color: #edf2f7;
			border-radius: 5px;
			box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
		}

		.login__intro {
			flex-basis: 45%;
			text-align: center;
			padding: 4rem 3rem;
			background-color: #3498db;
			color: #fff;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			clip-path: polygon(0% 0%, 90% 0%, 100% 50%, 90% 100%, 0% 100%);
		}

		.login__image {
			display: block;
			width: 180px;
			height: 200px;
		}

		.login__image2 {
			width: 300px;
			height: 80px;
		}

		.login__intro h2 {
			font-weight: 600;
			font-size: 25px;
			text-transform: uppercase;
			letter-spacing: 1.5px
		}

		.login__intro h4 {
			font-weight: normal;
		}

		.login__form {
			flex-basis: 55%;
			padding: 4rem 3rem;
			text-align: center;
		}

		.login__heading {
			font-size: 20px;
			font-weight: 600;
			margin-bottom: 1.5rem;
		}

		.input {
			font-size: 100%;
			font-family: inherit;
			padding: 1rem;
			display: block;
			width: 100%;
			border-radius: 2px;
			border: 1px solid rgba(0, 0, 0, .15);
		}

		.input:focus {
			border-color: #3498db;
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
		}

		.login__form p+p {
			margin-top: .75rem;
		}

		input.submit {
			background-color: #3498db;
			cursor: pointer;
			color: #fff;
			border: none;
		}

		.input.submit:hover {
			filter: brightness(110%);
		}

		.login__helper {
			margin-top: 1.5rem;
			font-size: 14px;
			color: #718096;
		}

		.login__helper span {
			display: block;
			text-align: center;
		}

		.login__helper a {
			text-decoration: none;
			color: #3498db;
		}

		.create__account {
			margin-top: .5rem;
		}
	</style>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">

	<title>Login</title>
</head>

<body>
	<div class="limiter">
		<div class="login__card">
			<div class="login__intro">
				<img src="<?php echo base_url(); ?>assets/images/avatar.png" alt="" class="login__image">
				<h2>Selamat Datang</h2>
				<h4>Silahkan Login Untuk Melanjutkan !</h4>
			</div>
			<div class="login__form">
				<img src="<?php echo base_url(); ?>assets/images/logofi.png" alt="" class="login__image2">
				<br>
				<?php echo $contents; ?>
				<div class="login__helper">
					<span class="forget__password">

					</span>
					<span class="create__account">Tidak Punya Akun ? <a href="#">Sign Up</a></span>
				</div>
			</div>
		</div>
		<div style="margin-top:20px; color:white; text-align:center;">
			&copy; <a href="http://www.pacific-tasikmalaya.com" style="color:white; text-decoration:none" target="_blank">http://www.pacific-tasikmalaya.com</a>
		</div>
	</div>

</body>

</html>