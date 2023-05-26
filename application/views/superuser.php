<!DOCTYPE html>
<html lang="en">
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>S I B A Y U - Halaman Admin</title>
		<meta name="description" content="Sistem Informasi Ujian Berbasis Website - MKKS SMK KABUPATEN SUBANG">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Global Theme Styles -->
		<link href="<?php echo base_url('_metronic/vendors/base/vendors.bundle.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('_metronic/demo/default/base/style.bundle.css'); ?>" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="<?php echo base_url('_metronic/vendors/custom/fullcalendar/fullcalendar.bundle.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('_assets/css/main.css'); ?>" rel="stylesheet" type="text/css" />
		<?php
			if(isset($land)){
				echo '<link href="'.base_url('_assets/css/landscape-print.css').'" media="print" rel="stylesheet" type="text/css" />';
			}
			$iden = $this->superuser_model->getIdentitas();
		?>
		<!--end::Page Vendors Styles -->
		<link rel="shortcut icon" href="<?php echo base_url('_assets/images/'.$iden[7]); ?>" />
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="<?php echo base_url('superuser'); ?>" class="m-brand__logo-wrapper">
										<img alt="" src="<?php echo base_url('_assets/images/sibayu-text.png'); ?>" />
									</a>
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">

									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>

									<!-- END -->
								</div>
							</div>
						</div>
						<!-- END: Brand -->

						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
							<!-- BEGIN: Horizontal Menu -->
							<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
							<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
								<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                                        <div class="m-menu__link m-menu__toggle" title="Non functional dummy link">
                                        <i class="m-menu__link-icon flaticon-placeholder-2"></i>
                                        	<span class="m-menu__link-text" style="font-size: 18px;">
                                        		<?php 
								                    $iden = $this->superuser_model->getIdentitas();
								                    echo strtoupper($iden[1]) ."<small> - ". tgl_lengkap(date('Y-m-d'))."</small>";
								                ?>
                                        	</span>
                                        </div>
									</li>
								</ul>
							</div>
							<!-- END: Horizontal Menu -->
						</div>
					</div>
				</div>
			</header>
			<!-- END: Header -->

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				
				<!-- BEGIN: Left Aside -->
				<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
				<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
					
					<!-- BEGIN: Aside Menu -->
					<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
						<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
							
							<li class="m-menu__section "  aria-haspopup="true" style="margin-top:-10px;">
								<h4 class="m-menu__section-text">
									<?php
										echo '<strong> WELCOME,</strong>';
										echo '<br>';
										echo '<strong>'.$this->session->userdata("session_petugas_nama").' ['.$this->session->userdata("session_petugas_level").']</strong>';
									?>
								</h4>
								<i class="m-menu__section-icon flaticon-more-v2"></i>
							</li>

							<li class="m-menu__item ">
								<a href="<?php echo base_url('superuser'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-dashboard"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text"><strong>
												Dashboard
											</strong></span>
										</span>
									</span>
								</a>
							</li>

							<li class="m-menu__section ">
								<h4 class="m-menu__section-text">Transaksi</h4>
								<i class="m-menu__section-icon flaticon-more-v2"></i>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/pembayaran'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-list-1"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Pembayaran</span>
										</span>
									</span>
								</a>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/pembayaran_laporan'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-profile"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Laporan Transaksi</span>
										</span>
									</span>
								</a>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/pembayaran_beritaacara'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-book"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Berita Acara</span>
										</span>
									</span>
								</a>
							</li>

							<li class="m-menu__section "  aria-haspopup="true">
								<h4 class="m-menu__section-text">Data Master</h4>
								<i class="m-menu__section-icon flaticon-more-v2"></i>
							</li>


							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/tagihan'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-coins"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Tagihan</span>
										</span>
									</span>
								</a>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/peserta'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-users"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Peserta Didik</span>
										</span>
									</span>
								</a>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/tahun_masuk'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-book"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Tahun Masuk</span>
										</span>
									</span>
								</a>
							</li>


							<li class="m-menu__section">
								<h4 class="m-menu__section-text">Cetak</h4>
								<i class="m-menu__section-icon flaticon-more-v2"></i>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/rekap_kelas'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-time"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Rekap Tagihan <br>Per-Kelas</span>
										</span>
									</span>
								</a>
							</li>

							<!-- <li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/rekap_harian'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-clipboard"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Rekap Keuangan <br>Harian</span>
										</span>
									</span>
								</a>
							</li> -->
							
							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/rekap_bulanan'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon la la-sort-amount-asc"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Rekap Pemasukan</span>
										</span>
									</span>
								</a>
							</li>
							
							<li class="m-menu__section">
								<h4 class="m-menu__section-text">Pengaturan</h4>
								<i class="m-menu__section-icon flaticon-more-v2"></i>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/petugas'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-user"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Petugas</span>
										</span>
									</span>
								</a>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('superuser/identitas'); ?>" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-home-2"></i>
									<span class="m-menu__link-title"> 
										<span class="m-menu__link-wrap"> 
											<span class="m-menu__link-text">Identitas Sekolah</span>
										</span>
									</span>
								</a>
							</li>
							
							
							<li class="m-menu__section">
								<h4 class="m-menu__section-text">Keluar Aplikasi</h4>
								<i class="m-menu__section-icon flaticon-more-v2"></i>
							</li>

							<li class="m-menu__item" aria-haspopup="true">
								<a href="<?php echo base_url('destroy'); ?>" class="m-menu__link ">
									<button type="button" class="btn m-btn--pill btn-danger m-btn m-btn--custom btn-block">Log Out</button>
								</a>
							</li>
						</ul>
					</div>
					<!-- END: Aside Menu -->
				</div>
				<!-- END: Left Aside -->
				
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<div class="m-content">
						<!-- begin::Content Body -->
						<?php $this->load->view($content); ?>
						<!-- end::Content Body -->
					</div>
				</div>
			</div>
			<!-- end:: Body -->

			<!-- begin::Footer -->
			<footer class="m-grid__item		m-footer ">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								Hak Cipta &copy; 2023 | Egi Nugraha - Pelatihan KPTK | v.1
							</span>
						</div>
					</div>
				</div>
			</footer>
			<!-- end::Footer -->
		</div>
		<!-- end:: Page -->

		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top -->

		<!--begin::Global Theme Bundle -->
		<script src="<?php echo base_url('_metronic/vendors/base/vendors.bundle.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo base_url('_metronic/demo/default/base/scripts.bundle.js'); ?>" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts -->
		<script src="<?php echo base_url('_metronic/demo/default/custom/crud/forms/widgets/select2.js'); ?>" type="text/javascript"></script>		
		<script src="<?php echo base_url('_metronic/demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo base_url('_assets/js/autoNumeric-1.8.3.js'); ?>" type="text/javascript"></script>		
		<script src="<?php echo base_url('_metronic/app/js/dashboard.js'); ?>" type="text/javascript"></script>		
		<script type="text/javascript">
			$('#select2').select2({
				placeholder: "- Pilih Data -"
			});

			$('#daterange').daterangepicker();
			$('.rupiah_format').autoNumeric('init');

			var $angsur = $('input[id=input_angsur]');
			var $diskon = $('input[id=input_diskon]');
			var $sekali = $('input[type=checkbox]');

			function hitung(){
				total_angsur = 0;
				$angsur.each(function(e) {
					e.preventDefault;
					value_angsur = rupiah_to_normal(".", "", this.value);
					total_angsur += parseInt(value_angsur , 10);
				});

				total = parseInt(total_angsur , 10);
				value_sekali = [0,0];
				$sekali.each(function() {
					value_sekali = this.value.toString().split("-");
					if (this.checked)
						total =  total + parseInt(value_sekali[1] , 10);
				});

				$("#sub_total").html(rupiah(total, 0, ',', '.'));

				diskon = rupiah_to_normal(".", "", $diskon.val(), 10);
				total = total - parseInt(diskon, 10);

				$("#total_bayar").html(rupiah(total, 0, ',', '.'));
			}

			$angsur.keypress(hitung);
			$diskon.keypress(hitung);
			$sekali.click(hitung);

    		$('form').submit(function(){
				$('small.keterangan').text("Sedang memproses, mohon tunggu ...");
				$('input:submit').addClass("disabled");
			});

			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(0, function(){
					$(this).remove(); 
				});
			}, 10000);

			$('#select-all').click(function(event) {   
				if(this.checked) {
					// Iterate each checkbox
					$(':checkbox').each(function() {
						this.checked = true;
						document.getElementById('deleted_checkbox').style.display = "block";                    
					});
				} else {
					$(':checkbox').each(function() {
						this.checked = false;
						document.getElementById('deleted_checkbox').style.display = "none";                       
					});
				}
			});

			$('input[id=checbox_id]').click(function(event) {   
				if(this.checked) {
					// Iterate each checkbox
					$(':checkbox').each(function() {
						document.getElementById('deleted_checkbox').style.display = "block";       
					});
				} else {
					$(':checkbox').each(function() {
						document.getElementById('deleted_checkbox').style.display = "none";                       
					});
				}
			});

			$('#select-all2').click(function(event) {   
				if(this.checked) {
					// Iterate each checkbox
					$(':checkbox').each(function() {
						this.checked = true;
						document.getElementById('deleted_checkbox2').style.display = "block";                    
					});
				} else {
					$(':checkbox').each(function() {
						this.checked = false;
						document.getElementById('deleted_checkbox2').style.display = "none";                       
					});
				}
			});

			$('input[id=checbox_id2]').click(function(event) {   
				if(this.checked) {
					// Iterate each checkbox
					$(':checkbox').each(function() {
						document.getElementById('deleted_checkbox2').style.display = "block";       
					});
				} else {
					$(':checkbox').each(function() {
						document.getElementById('deleted_checkbox2').style.display = "none";                       
					});
				}
			});

			$('.row_box tr').click(function(event){
				if(event.target.type !== 'checkbox'){
					$(':checkbox', this).trigger('click');
				}
			});

			function printDiv(divName){
				var printContents = document.getElementById(divName).innerHTML;
				var originalContents = document.body.innerHTML;

				document.body.innerHTML = printContents;
				window.print();
				document.body.innerHTML = originalContents;
			}

			var password = document.getElementById("katasandi") , confirm_password = document.getElementById("konfirmasi_katasandi");
			function validatePassword(){
				if(password.value != confirm_password.value) {
					confirm_password.setCustomValidity("Password do not match.");
				} else {
					confirm_password.setCustomValidity('');
				}
			}
			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;

			function rupiah(number,decimals,dec_point,thousands_sep) {
				number = (number + '')
				.replace(/[^0-9+\-Ee.]/g, '');
				var n = !isFinite(+number) ? 0 : +number,
				prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
				sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
				dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
				s = '',
				toFixedFix = function(n, prec) {
				var k = Math.pow(10, prec);
				return '' + (Math.round(n * k) / k)
				.toFixed(prec);
				};
				// Fix for IE parseFloat(0.55).toFixed(0) = 0;
				s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
				.split('.');
				if (s[0].length > 3) {
				s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
				}
				if ((s[1] || '')
				.length < prec) {
				s[1] = s[1] || '';
				s[1] += new Array(prec - s[1].length + 1)
				.join('0');
				}
				return s.join(dec);
			}

			function rupiah_to_normal(search, replace, subject, count) {
				var i = 0,
				j = 0,
				temp = '',
				repl = '',
				sl = 0,
				fl = 0,
				f = [].concat(search),
				r = [].concat(replace),
				s = subject,
				ra = Object.prototype.toString.call(r) === '[object Array]',
				sa = Object.prototype.toString.call(s) === '[object Array]';
				s = [].concat(s);
				if (count) {
				this.window[count] = 0;
				}

				for (i = 0, sl = s.length; i < sl; i++) {
				if (s[i] === '') {
				continue;
				}
				for (j = 0, fl = f.length; j < fl; j++) {
				temp = s[i] + '';
				repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
				s[i] = (temp)
				.split(f[j])
				.join(repl);
				if (count && s[i] !== temp) {
				this.window[count] += (temp.length - s[i].length) / f[j].length;
				}
				}
				}
				return sa ? s : s[0];
			}

    	</script>
		<!--end::Page Scripts -->
	</body>
	<!-- end::Body -->
</html>