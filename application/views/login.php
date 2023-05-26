<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    	<!-- # Information Web # -->
    	<title>S I B A Y U - Halaman Masuk</title>
		<?php
			$iden = $this->superuser_model->getIdentitas();
		?>
    	<link rel="shortcut icon" href="<?php echo base_url('_assets/images/'.$iden[7]); ?>">

    	<!-- # CSS # -->
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('_assets/css/lumen.bootstrap.min.css'); ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('_assets/css/font-awesome.min.css'); ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('_assets/css/login.css'); ?>">
	</head>

	<body>
		<div class="container h-100">
			<div class="row align-items-center h-100">
				<div class="col-md-5 col-sm-10 col-xs-12 mx-auto">
					<?php $iden = $this->superuser_model->getIdentitas(); ?>
					<h1 class="login-title">
						<?php 
							echo strtoupper($iden[1]);
						?>
					<br/>
					<small style="font-size: 18px;" class="text-muted">
						Sistem Informasi Pembayaran Keuangan Sekolah
					</small></h1>
					
					<?php
						if ($this->session->userdata('login_error') != NULL) {
							$login_error = $this->session->userdata('login_error');
							$login_error_type = $this->session->userdata('login_error_type');

							echo '
								<div class="alert '.$login_error_type.' alert-dismissible fade show login-alert" role="alert" class="close" data-dismiss="alert">
									'.$login_error.'
									<button class="close" data-dismiss="alert" aria-label="Close">
										<small aria-hidden="true"><i class="fa fa-warning"></i></small>
									</button>
								</div>
							';

							$this->session->unset_userdata('login_error');
							$this->session->unset_userdata('login_error_type');
						}

						echo form_open('login/check','class="login-form"');
						echo form_input('login_username', $login_username, 'class="login-input no-radius" placeholder="Nama Pengguna" required autocomplete="off" autofocus');
						echo form_password('login_password', '', 'class="login-input no-radius" placeholder="Kata Sandi" required');
						echo '
							<p class="float-right login-ket">Jika mengalami kesulitan dalam <i>login</i>, hubungi teknisi aplikasi.</p>
							<div class="clear"></div>
						';
						echo form_submit('login_submit', 'MASUK', 'class="btn btn-lg login-btn"'); 
						echo '<small class="keterangan text-light text-muted"></small>';
						echo form_close();
					?>
					<br>
					<h6 class="login-title" style="font-size: 15px;"><small class="text-muted">Hak Cipta &copy; 2023 | Egi Nugraha - Pelatihan KPTK | v.1</small></h6>
				</div>
			</div>
		</div>

		<!-- # JS # -->
    	<script type="text/javascript" src="<?php echo base_url('_assets/js/jquery-3.3.1.slim.min.js'); ?>"></script>
    	<script type="text/javascript" src="<?php echo base_url('_assets/js/popper.min.js'); ?>"></script>
    	<script type="text/javascript" src="<?php echo base_url('_assets/js/bootstrap.min.js'); ?>"></script>
    	<script type="text/javascript" src="<?php echo base_url('_assets/js/login.js'); ?>"></script>
    	<script type="text/javascript">
    		$('form').submit(function(){
				$('small.keterangan').text("Sedang memproses, mohon tunggu ...");
				$('input:submit').addClass("disabled");
			});
    	</script>
	</body>
</html>