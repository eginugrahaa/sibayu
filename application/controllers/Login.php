<?php
	class Login extends CI_Controller{
		
		function __construct(){
			parent:: __construct();
			$this->load->model("login_model");
		}

		function index(){
			if ($this->session->userdata("peserta_login") == TRUE) {
				redirect('ujian');
			}elseif ($this->session->userdata("operator_login") == TRUE) {
				redirect('operator');
			}

			if ($this->session->userdata("login_username") != NULL) {
				$data["login_username"] = $this->session->userdata("login_username");
				$this->session->unset_userdata("login_username");
			}else{
				$data["login_username"] = "";
			}
			$this->load->view("login", $data);
		}

		function alert($alert, $alert_type){
			$this->session->set_userdata('login_error', $alert);
			$this->session->set_userdata('login_error_type', $alert_type);
			redirect();
		}

		function check(){
			if ($this->input->post("login_submit")) {
				$username = $this->input->post("login_username", TRUE);
				$password = $this->input->post("login_password", TRUE);
				$this->session->set_userdata('login_username', $username);

				/* # CHECK USERNAME ACCOUNT #*/
				$check_username = $this->login_model->check_username($username);
				if ($check_username->num_rows() > 0) {
					/* # CONDITION CORRECT ACCOUNT #*/
					$select_peserta = $this->login_model->select_akun($username, $password);
					if ($select_peserta->num_rows() > 0) {
						/* # CONDITION LEVEL #*/
						$petugas_id = $check_username->row()->petugas_id;
						$petugas_nama = $check_username->row()->nama_petugas;
						$level = $check_username->row()->level;
						$aktif_petugas = $check_username->row()->aktif_petugas;
						
						if ($aktif_petugas == "1"){
							$this->db->query("UPDATE petugas SET masuk_terakhir = NOW() WHERE petugas_id = '".$petugas_id."'; ");

							$this->session->set_userdata("session_petugas_id", $petugas_id);
							$this->session->set_userdata("session_petugas_nama", $petugas_nama);
							$this->session->set_userdata("session_petugas_level", $level);
								
							if ($level == "admin") {
								$this->session->set_userdata("superuser_login", TRUE);
								redirect('superuser');
							}else if ($level == "teller") {
								$this->session->set_userdata("operator_login", TRUE);
								redirect('operator');
							}else{
								$this->alert('<strong>Akun Ambigu.</strong> Hubungi teknisi aplikasi', 'alert-danger');
							}

						}else{
							$this->alert('<strong>Akun Petugas Tidak Aktif.</strong> Hubungi teknisi aplikasi.', 'alert-danger');
						}
					}else{
						$this->alert('<strong>Kata Sandi Petugas</strong> tidak sesuai.', 'alert-danger');
					}
				}else{
					$this->alert('<strong>Nama Pengguna Petugas</strong> tidak ditemukan.', 'alert-danger');
				}
			}else{
				redirect();
			}
		}

		function destroy(){
			$this->session->sess_destroy();
			redirect();
		}

	}