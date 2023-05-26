<?php
	class Superuser extends CI_Controller{

	/* # Begin:Default # */
		function __construct(){
			parent:: __construct();
			$this->load->model("operator_model");
			$this->load->library(array('pagination'));
			
			if ($this->session->userdata("superuser_login") != TRUE) {
				redirect();
			}
		}

		function alert($alert, $alert_type, $url=NULL){
			$this->session->set_userdata('alert_error', $alert);
			$this->session->set_userdata('alert_error_type', $alert_type);		
			if(!empty($url)){redirect($url);};
		}
	/* # End:Default # */
	
	/* # Begin:Dashboard Page # */
		function index(){
			$this->dashboard();
		}

		function dashboard(){
			$data["content"] 	= "superuser_dashboard";
			$this->load->view("superuser", $data);
		}
	/* # End:Dashboard Page # */

	/* # Begin:Identitas Page # */
		function identitas(){
			$data["identitas"] 	= $this->superuser_model->getIdentitas();
			$data["content"] 	= "superuser_identitas";
			$this->load->view("superuser", $data);
		}

		function identitas_proses(){
			$iden_submit = $this->input->post("iden_submit");
			if(isset($iden_submit)){
				/* ## Proses Updating ## */
				$this->db->trans_start();
					//$this->superuser_model->updateIdentitas('1_nama_sekolah', $this->input->post('iden_nama'));
					$this->superuser_model->updateIdentitas('0_no_instansi', $this->input->post('iden_npsn'));
					$this->superuser_model->updateIdentitas('1_nama_sekolah', $this->input->post('iden_nama'));
					$this->superuser_model->updateIdentitas('2_nama_kepala', $this->input->post('iden_kepala'));
					$this->superuser_model->updateIdentitas('3_nip', $this->input->post('iden_nip'));
					$this->superuser_model->updateIdentitas('4_alamat', $this->input->post('iden_alamat'));
					$this->superuser_model->updateIdentitas('5_kota', $this->input->post('iden_kota'));
					$this->superuser_model->updateIdentitas('6_kontak', $this->input->post('iden_kontak'));
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					/*#Jika terjadi gagal mengupdate jawaban#*/
					$this->db->trans_rollback();
					$this->alert('<strong>Data gagal disimpan,</strong><br>Silahkan coba lagi.', 'alert-danger','superuser/identitas');
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Status : </strong><br>Data berhasil disimpan.', 'alert-success','superuser/identitas');				
				}
			}else{
				show_404();
			}
		}
	/* # End:Identitas Page # */
	
	/* # Begin:Petugas Page # */
		function petugas(){
			$this->session->unset_userdata('filter_nama');

			$this->db->select("*");
			$this->db->from("petugas");

			$pagination['base_url'] = base_url() . '/superuser/petugas/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;

			$this->pagination->initialize($pagination);

			$data['nomor'] = $this->uri->segment(3, 0);
			$data['query'] = $this->superuser_model->searchPetugas($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama = "", $filter_kelas = "");
			$data['total'] = $pagination['total_rows'];
			
			$data['value_nama'] = "";

			$data['content'] 	= "superuser_petugas";
			$this->load->view('superuser',$data);
		}

		function petugas_filter(){
			if ( isset($_POST['filter_nama']) ) {
				if($_POST['filter_nama']==""){
					redirect('superuser/petugas');
				}else{
					$filter_nama = @htmlspecialchars($this->input->post('filter_nama'));

					$this->session->set_userdata('filter_nama', $filter_nama);
				}
			} else {
				$filter_nama = @htmlspecialchars($this->session->userdata('filter_nama'));
			}

			$this->db->select("*");
			$this->db->from("petugas");
			$this->db->like('nama_petugas', $filter_nama);

			$pagination['base_url'] = base_url() . '/superuser/petugas_filter/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;
			
			$this->pagination->initialize($pagination);

			$data['nomor'] = $this->uri->segment(3, 0);
			$data['query'] = $this->superuser_model->searchPetugas($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama, $filter_kelas = "");
			$data['total'] = $pagination['total_rows'];
			
			$data['value_nama'] = $filter_nama;

			$data['content'] 	= "superuser_petugas";
			$this->load->view('superuser',$data);
		}

		function petugas_tambah(){
			$data["petugas_username"] = $this->input->post("petugas_username");
			$data["petugas_password"] = $this->input->post("petugas_password");
			$data["petugas_nama"] = $this->input->post("petugas_nama");
			$data["petugas_level"] = $this->input->post("petugas_level");

			if( isset($_POST["peserta_submit"]) ){
				$cekIDPserta = $this->superuser_model->getPetugasUsername($data["petugas_username"]);
				if($cekIDPserta->num_rows() > 0){
					$this->alert('<strong>Status : </strong><br>Nama Pengguna <strong>'.$cekIDPserta->row()->nama_pengguna.'</strong>  atas nama <strong>'.$cekIDPserta->row()->nama_petugas.'</strong>. Perbaharui Nama Pengguna dengan yang lain.', 'alert-danger', 'superuser/petugas_tambah');
					$data["petugas_username"] = $this->input->post("petugas_username");
					$data["petugas_password"] = "";
					$data["petugas_nama"] = $this->input->post("petugas_nama");
					$data["petugas_level"] = $this->input->post("petugas_level");
				}else{
					/* ## Proses Inserting ## */
					$this->db->trans_start();
					$data = [
						'nama_pengguna' => $data["petugas_username"],
						'kata_sandi' => md5($data["petugas_password"]),
						'nama_petugas' => $data["petugas_nama"],
						'level' => $data["petugas_level"],

						'masuk_terakhir' => NULL,
						'aktif_petugas' => '1',
						'parent_id' => $this->session->userdata("session_petugas_id"),									
					];
					$this->db->set('waktu_entri', 'NOW()', FALSE);
					$this->db->set('waktu_update', 'NOW()', FALSE);
					$query = $this->db->insert("petugas", $data);
					$this->db->trans_complete();

					if ($this->db->trans_status() === FALSE) {
						/*#Jika terjadi gagal mengupdate jawaban#*/
						$this->db->trans_rollback();
						$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/petugas_tambah');
					}else{
						$this->db->trans_commit();
						$data["petugas_username"] = $this->input->post("petugas_username");
						$data["petugas_nama"] = $this->input->post("petugas_nama");
						$this->alert('<strong>Status : </strong><br>Data <strong>'.$data["petugas_username"].'</strong> atas nama <strong>'.$data["petugas_nama"].'</strong> berhasil disimpan.', 'alert-success','superuser/petugas');				
						
						$data["petugas_username"] = "";
						$data["petugas_password"] = "";
						$data["petugas_nama"] = "";
						$data["petugas_level"] = "";
					}
				}
			}

			$data["content"] = "superuser_petugas_tambah";
			$this->load->view("superuser", $data);
		}

		function petugas_edit($akun_uuid=NULL){
			if($akun_uuid != NULL){
				$cekIDPserta = $this->superuser_model->getPetugas($akun_uuid);
				if($cekIDPserta->num_rows() > 0){
					$data["petugas_id"] = $cekIDPserta->row()->petugas_id;
					
					$data["petugas_username"] = $cekIDPserta->row()->nama_pengguna;
					$data["petugas_nama"] = $cekIDPserta->row()->nama_petugas;
					$data["petugas_level"] = $cekIDPserta->row()->level;
					$data["petugas_active"] = $cekIDPserta->row()->aktif_petugas;
					/* ## Page Edit ## */
					if( isset($_POST["peserta_submit"]) ){
						$data["petugas_id"] = $this->input->post("petugas_id");
					
						$data["petugas_username"] = $this->input->post("petugas_username");
						$data["petugas_nama"] = $this->input->post("petugas_nama");
						$data["petugas_level"] = $this->input->post("petugas_level");
						$data["petugas_active"] = $this->input->post("petugas_active");

						$cekIDNIS = $this->superuser_model->getPetugasUsername($data["petugas_username"]);
						if($cekIDNIS->num_rows() > 0 && ($data['petugas_username'] != $cekIDPserta->row()->nama_pengguna)){
							$this->alert('<strong>Status : </strong><br>Nama Pengguna <strong>'.$cekIDNIS->row()->nama_pengguna.'</strong>  atas nama <strong>'.$cekIDPserta->row()->nama_petugas.'</strong>. Mohon ulangi dan perbaharui Nama Pengguna dengan yang lain.', 'alert-danger', 'superuser/petugas_edit/'.$data["petugas_id"]);
							$data["petugas_id"] = $this->input->post("petugas_id");

							$data["petugas_username"] = $cekIDPserta->row()->nama_pengguna;
							$data["petugas_nama"] = $cekIDPserta->row()->nama_petugas;
							$data["petugas_level"] = $cekIDPserta->row()->level;
							$data["petugas_active"] = $cekIDPserta->row()->aktif_petugas;
						}else{
							/* ## Proses Editing ## */
							$this->db->trans_start();
							$data = [
								'nama_pengguna' => $data["petugas_username"],
								'nama_petugas' => $data["petugas_nama"],
								'level' => $data["petugas_level"],

								'aktif_petugas' => $data["petugas_active"],
								'parent_id' => $this->session->userdata("session_petugas_id"),									
							];
							$this->db->set('waktu_update', 'NOW()', FALSE);
							$this->db->where("petugas_id", $this->input->post("petugas_id"));
							$query = $this->db->update("petugas", $data);
							$this->db->trans_complete();
		
							if ($this->db->trans_status() === FALSE) {
								/*#Jika terjadi gagal mengupdate jawaban#*/
								$this->db->trans_rollback();
								$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/petugas_edit/'.$data["petugas_id"]);
							}else{
								$this->db->trans_commit();
								$data["petugas_id"] = $this->input->post("petugas_id");
								$data["petugas_username"] = $this->input->post("petugas_username");
								$data["petugas_nama"] = $this->input->post("petugas_nama");
								$this->alert('<strong>Status : </strong><br>Data <strong>'.$data["petugas_username"].'</strong> atas nama <strong>'.$data["petugas_nama"].'</strong> berhasil diperbaharui.', 'alert-success','superuser/petugas_edit/'.$data["petugas_id"]);				
							}
						}
					}

					$data["content"] = "superuser_petugas_edit";
					$this->load->view("superuser", $data);
					
					/* ## Page Edit ## */
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}

		function petugas_katasandi($akun_uuid=NULL){
			if($akun_uuid != NULL){
				$cekIDPserta = $this->superuser_model->getPetugas($akun_uuid);
				if($cekIDPserta->num_rows() > 0){
					$data["petugas_id"] = $cekIDPserta->row()->petugas_id;
					
					$data["petugas_username"] = $cekIDPserta->row()->nama_pengguna;
					$data["petugas_password"] = "";
					$data["petugas_nama"] = $cekIDPserta->row()->nama_petugas;
					/* ## Page Edit ## */
					if( isset($_POST["peserta_submit"]) ){
						$data["petugas_id"] = $this->input->post("petugas_id");
					
						$data["petugas_username"] = $this->input->post("petugas_username");
						$data["petugas_password"] = $this->input->post("petugas_password");
						$data["petugas_nama"] = $this->input->post("petugas_nama");

						
						/* ## Proses Editing ## */
						$this->db->trans_start();
						$data = [
							'kata_sandi' => md5($data["petugas_password"]),

							'parent_id' => $this->session->userdata("session_petugas_id"),									
						];
						$this->db->set('waktu_update', 'NOW()', FALSE);
						$this->db->where("petugas_id", $this->input->post("petugas_id"));
						$query = $this->db->update("petugas", $data);
						$this->db->trans_complete();

						if ($this->db->trans_status() === FALSE) {
							/*#Jika terjadi gagal mengupdate jawaban#*/
							$this->db->trans_rollback();
							$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/petugas_katasandi/'.$data["petugas_id"]);
						}else{
							$this->db->trans_commit();
							$data["petugas_id"] = $this->input->post("petugas_id");
							$data["petugas_username"] = $this->input->post("petugas_username");
							$data["petugas_nama"] = $this->input->post("petugas_nama");
							$this->alert('<strong>Status : </strong><br>Data Kata Sandi <strong>'.$data["petugas_username"].'</strong> atas nama <strong>'.$data["petugas_nama"].'</strong> berhasil diperbaharui.', 'alert-success','superuser/petugas_katasandi/'.$data["petugas_id"]);				
						}
					}

					$data["content"] = "superuser_petugas_katasandi";
					$this->load->view("superuser", $data);
					
					/* ## Page Edit ## */
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}

		function petugas_hapus(){
			$berhasil = 0;
			$kode_id = $this->input->post("kode_id");
			
			if(count($kode_id) > 0){
				$this->db->trans_start();
					for($i = 0; $i<count($kode_id); $i++){
						
						$this->db->where("petugas_id", $kode_id[$i]);
						$this->db->delete("petugas");

						$berhasil++;
					}
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE) {
					/*# Jika terjadi gagal mengupdate jawaban #*/
					$this->db->trans_rollback();
					echo 'Gagal';
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Success: </strong>
					<br>Hapus Data peserta berhasil, Petugas yang di-hapus sebanyak <strong>'.$berhasil.' data </strong> secara permanen.
					', 'alert-success', 'superuser/petugas');
				}
			}else{
				$this->alert('<strong>Status : Gagal</strong><br> Tidak ada data yang dipilih atau dicentang.', 'alert-danger', 'superuser/petugas');
			}
		}
	/* # End:Petugas Page # */

	/* # Begin:Peserta Page # */
		function peserta(){
			$this->session->unset_userdata('filter_nama');
			$this->session->unset_userdata('filter_kelas');
			$this->session->unset_userdata('filter_tahun');

			$this->db->select("*");
			$this->db->from("peserta");

			$pagination['base_url'] = base_url() . '/superuser/peserta/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;
			$this->pagination->initialize($pagination);

			$data['nomor'] = $this->uri->segment(3, 0);
			$data['query'] = $this->superuser_model->searchPeserta($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama = "", $filter_kelas = "", $filter_tahun = "");
			$data['total'] = $pagination['total_rows'];
			
			$data['value_nama'] = "";
			$data['value_kelas'] = "";
			$data['value_tahun'] = "";

			$data['kelas'] = $this->superuser_model->dropdownKelas();
			$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasuk();
			$data['content'] 	= "superuser_peserta";
			$this->load->view('superuser',$data);
		}

		function peserta_filter(){
			if (isset($_POST['filter_nama']) || isset($_POST['filter_kelas']) || isset($_POST['filter_tahun']) ) {
				if($_POST['filter_nama']=="" && $_POST['filter_kelas']=="" && $_POST['filter_tahun']==""){
					redirect('superuser/peserta');
				}else{
					$filter_nama = @htmlspecialchars($this->input->post('filter_nama'));
					$filter_kelas = @htmlspecialchars($this->input->post('filter_kelas'));
					$filter_tahun = @htmlspecialchars($this->input->post('filter_tahun'));

					$this->session->set_userdata('filter_nama', $filter_nama);
					$this->session->set_userdata('filter_kelas', $filter_kelas);
					$this->session->set_userdata('filter_tahun', $filter_tahun);
				}
			} else {
				$filter_nama = @htmlspecialchars($this->session->userdata('filter_nama'));
				$filter_kelas = @htmlspecialchars($this->session->userdata('filter_kelas'));
				$filter_tahun = @htmlspecialchars($this->session->userdata('filter_tahun'));
			}

			$this->db->select("*");
			$this->db->from("peserta");
			$this->db->join("tahun_masuk", "tahun_masuk.tahun_masuk_id = peserta.tahun_masuk_id");

			$kelas_ex = explode("-", $filter_kelas);
			if(!empty($filter_kelas)){
				$this->db->where('tingkat', $kelas_ex[0]);
                $this->db->where('kelas', $kelas_ex[1]);
			}

			if(!empty($filter_tahun)){
				$this->db->where('peserta.tahun_masuk_id', $filter_tahun);
			}

			if(!empty($filter_nama)){
				$this->db->like("nama_lengkap", $filter_nama);
				$this->db->or_like('no_identitas', $filter_nama);
			}
	
			$pagination['base_url'] = base_url() . '/superuser/peserta_filter/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;
			$this->pagination->initialize($pagination);
			$data['query'] = $this->superuser_model->searchPeserta($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama, $filter_kelas, $filter_tahun);
			$data['nomor'] = $this->uri->segment(3, 0);
			$data['total']=$pagination['total_rows'];

			$data['value_nama'] = $filter_nama;
			$data['value_kelas'] = $filter_kelas;
			$data['value_tahun'] = $filter_tahun;

			$data['kelas'] = $this->superuser_model->dropdownKelas();
			$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasuk();
			$data['content'] = 'superuser_peserta';
			$this->load->vars($data);
			$this->load->view('superuser');
		}

		function peserta_tambah(){
			$data["peserta_id"] = $this->input->post("peserta_id");
			$data["peserta_tingkat"] = $this->input->post("peserta_tingkat");
			$data["peserta_nama"] = $this->input->post("peserta_nama");
			$data["peserta_jk"] = $this->input->post("peserta_jk");
			$data["peserta_kelas"] = $this->input->post("peserta_kelas");
			$data["peserta_tahun_masuk"] = $this->input->post("peserta_tahun_masuk");

			if( isset($_POST["peserta_submit"]) ){
				$cekIDPserta = $this->superuser_model->getAkunID($data["peserta_id"]);
				if($cekIDPserta->num_rows() > 0){
					$this->alert('<strong>Status : </strong><br>ID Peserta <strong>'.$cekIDPserta->row()->no_identitas.'</strong>  atas nama <strong>'.$cekIDPserta->row()->nama_lengkap.'</strong>. Perbaharui ID Peserta dengan yang lain.', 'alert-danger', NULL);
					$data["peserta_id"] = $this->input->post("peserta_id");
					$data["peserta_tingkat"] = $this->input->post("peserta_tingkat");
					$data["peserta_nama"] = $this->input->post("peserta_nama");
					$data["peserta_jk"] = $this->input->post("peserta_jk");
					$data["peserta_kelas"] = $this->input->post("peserta_kelas");
					$data["peserta_tahun_masuk"] = $this->input->post("peserta_tahun_masuk");
				}else{
					/* ## Proses Inserting ## */
					$this->db->trans_start();
					$data = [
						// 'tahun_masuk_id' => $data["peserta_tahun_masuk"],
						
						'no_identitas' => $data["peserta_id"],
						'nama_lengkap' => $data["peserta_nama"],
						'jenis_kelamin' => $data["peserta_jk"],

						'tingkat' => $data["peserta_tingkat"],
						'kelas' => $data["peserta_kelas"],

						'aktif_peserta' => '1',
						'petugas_id' => $this->session->userdata("session_petugas_id"),									
					];
					$this->db->set('waktu_entri', 'NOW()', FALSE);
					$this->db->set('waktu_update', 'NOW()', FALSE);
					$query = $this->db->insert("peserta", $data);
					$this->db->trans_complete();

					if ($this->db->trans_status() === FALSE) {
						/*#Jika terjadi gagal mengupdate jawaban#*/
						$this->db->trans_rollback();
						$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/peserta_tambah');
					}else{
						$this->db->trans_commit();
						$data["peserta_id"] = $this->input->post("peserta_id");
						$data["peserta_nama"] = $this->input->post("peserta_nama");
						$this->alert('<strong>Status : </strong><br>Data <strong>'.$data["peserta_id"].'</strong> atas nama <strong>'.$data["peserta_nama"].'</strong> berhasil disimpan.', 'alert-success','superuser/peserta');				
						
						$data["peserta_id"] = "";
						$data["peserta_tingkat"] = "";
						$data["peserta_nama"] = "";
						$data["peserta_jk"] = "";
						$data["peserta_kelas"] = "";
						$data["peserta_tahun_masuk"] = "";
					}
				}
			}

			$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasuk();
			$data["content"] = "superuser_peserta_tambah";
			$this->load->view("superuser", $data);
		}

		function peserta_edit($akun_uuid=NULL){
			if($akun_uuid != NULL){
				$cekIDPserta = $this->superuser_model->getAkun($akun_uuid);
				if($cekIDPserta->num_rows() > 0){
					$data["peserta_id_key"] = $cekIDPserta->row()->peserta_id;
					
					$data["peserta_tahun_masuk"] = $cekIDPserta->row()->tahun_masuk_id;
					$data["no_identitas"] = $cekIDPserta->row()->no_identitas;
					$data["peserta_nama"] = $cekIDPserta->row()->nama_lengkap;
					$data["peserta_jk"] = $cekIDPserta->row()->jenis_kelamin;
					$data["peserta_tingkat"] = $cekIDPserta->row()->tingkat;
					$data["peserta_kelas"] = $cekIDPserta->row()->kelas;
					$data["peserta_active"] = $cekIDPserta->row()->aktif_peserta;
					/* ## Page Edit ## */
					if( isset($_POST["peserta_submit"]) ){
						$data["peserta_id_key"] = $this->input->post("peserta_id_key");
					
						$data["peserta_tahun_masuk"] = $this->input->post("peserta_tahun_masuk");
						$data["no_identitas"] = $this->input->post("no_identitas");
						$data["peserta_nama"] = $this->input->post("peserta_nama");
						$data["peserta_jk"] = $this->input->post("peserta_jk");
						$data["peserta_tingkat"] = $this->input->post("peserta_tingkat");
						$data["peserta_kelas"] = $this->input->post("peserta_kelas");
						$data["peserta_active"] = $this->input->post("peserta_active");

						$cekIDNIS = $this->superuser_model->getAkunID($data["no_identitas"]);
						if($cekIDNIS->num_rows() > 0 && ($data['no_identitas'] != $cekIDPserta->row()->no_identitas)){
							$this->alert('<strong>Status : </strong><br>Nomor Identitas <strong>'.$cekIDNIS->row()->no_identitas.'</strong>  atas nama <strong>'.$cekIDPserta->row()->nama_lengkap.'</strong>. Mohon ulangi dan perbaharui Nomor Identitas dengan yang lain.', 'alert-danger', 'superuser/peserta_edit/'.$data["peserta_id_key"]);
							$data["peserta_id_key"] = $this->input->post("peserta_id_key");

							$data["peserta_tahun_masuk"] = $cekIDPserta->row()->tahun_masuk_id;
							$data["no_identitas"] = $cekIDPserta->row()->no_identitas;
							$data["peserta_nama"] = $cekIDPserta->row()->nama_lengkap;
							$data["peserta_jk"] = $cekIDPserta->row()->jenis_kelamin;
							$data["peserta_tingkat"] = $cekIDPserta->row()->tingkat;
							$data["peserta_kelas"] = $cekIDPserta->row()->kelas;
							$data["peserta_active"] = $cekIDPserta->row()->aktif_peserta;
						}else{
							/* ## Proses Editing ## */
							$this->db->trans_start();
							$data = [
								//'tahun_masuk_id' => $data["peserta_tahun_masuk"],
								'no_identitas' => $data["no_identitas"],
								'nama_lengkap' => $data["peserta_nama"],
								'jenis_kelamin' => $data["peserta_jk"],
								
								'tingkat' => $data["peserta_tingkat"],
								'kelas' => $data["peserta_kelas"],

								'aktif_peserta' => $data["peserta_active"],
								'petugas_id' => $this->session->userdata("session_petugas_id"),									
							];
							$this->db->set('waktu_update', 'NOW()', FALSE);
							$this->db->where("peserta_id", $this->input->post("peserta_id_key"));
							$query = $this->db->update("peserta", $data);
							$this->db->trans_complete();
		
							if ($this->db->trans_status() === FALSE) {
								/*#Jika terjadi gagal mengupdate jawaban#*/
								$this->db->trans_rollback();
								$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/peserta_edit/'.$data["peserta_id_key"]);
							}else{
								$this->db->trans_commit();
								$data["peserta_id_key"] = $this->input->post("peserta_id_key");
								$data["peserta_id"] = $this->input->post("peserta_id");
								$data["peserta_nama"] = $this->input->post("peserta_nama");
								$this->alert('<strong>Status : </strong><br>Data <strong>'.$data["peserta_id"].'</strong> atas nama <strong>'.$data["peserta_nama"].'</strong> berhasil diperbaharui.', 'alert-success','superuser/peserta_edit/'.$data["peserta_id_key"]);				
							}
						}
					}

					$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasuk();
					$data["content"] = "superuser_peserta_edit";
					$this->load->view("superuser", $data);
					
					/* ## Page Edit ## */
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}

		function peserta_hapus(){
			$berhasil = 0;
			$peserta_id = $this->input->post("peserta_id");
			
			if(count($peserta_id) > 0){
				$this->db->trans_start();
					for($i = 0; $i<count($peserta_id); $i++){
						
						$this->db->where("peserta_id", $peserta_id[$i]);
						$this->db->delete("peserta");

						$berhasil++;
					}
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE) {
					/*# Jika terjadi gagal mengupdate jawaban #*/
					$this->db->trans_rollback();
					echo 'Gagal';
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Success: </strong>
					<br>Hapus Data peserta berhasil, Nomor Identitas yang di-hapus sebanyak <strong>'.$berhasil.' peserta </strong> secara permanen.
					', 'alert-success', 'superuser/peserta');
				}
			}else{
				$this->alert('<strong>Status : Gagal</strong><br> Tidak ada data yang dipilih atau dicentang.', 'alert-danger', 'superuser/peserta');
			}
			
		}
	
		function peserta_import(){
			$fileName = time().$_FILES['import_data']['name'];
         
			$config['upload_path'] = './_uploads/excel/'; //buat folder dengan nama assets di root folder
			$config['file_name'] = $fileName;
			$config['remove_spaces'] = FALSE;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size'] = 10000;
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			
			if(! $this->upload->do_upload('import_data') )
			$this->alert('<strong>Status : </strong><br>'.$this->upload->display_errors(), 'alert-danger', 'superuser/peserta');
			//echo $this->upload->display_errors();

			$media = $this->upload->data('import_data');
			$file = "./_uploads/excel/".$fileName;
			$inputFileName = $file;
			
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		
			try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
			
			$berhasil = 0;
			for ($row = 3; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

				$data = [
					"id_peserta"=> $rowData[0][1],
					"nama_lengkap"=> $rowData[0][2],
					"jk"=> $rowData[0][3],
					"tingkat"=> $rowData[0][4],
					"kelas"=> $rowData[0][5],
				];

				if( is_numeric($data["id_peserta"]) ){
					$cekIDPserta = $this->superuser_model->getAkunID($data["id_peserta"]);
					if($cekIDPserta->num_rows() > 0){
						unlink($inputFileName);
						$this->alert('<strong>Error baris ke-'.($berhasil+3).' pada file excel : </strong>
						<br>Data Nomor Identitas <strong>'.$cekIDPserta->row()->no_identitas.'</strong> telah terdaftar atas nama <strong>'.$cekIDPserta->row()->nama_lengkap.'</strong>. Mohon diperbaiki terlebih dahulu.
						<br>Data yang berhasil masuk ke sistem : <strong>'.$berhasil.' baris.</strong>
						', 'alert-danger', 'superuser/peserta');
						break;
					}else{
						$data = [
							'tahun_masuk_id' => $this->input->post("peserta_tahun_masuk"),
							
							'no_identitas' => $data["id_peserta"],
							'nama_lengkap' => $data["nama_lengkap"],
							'jenis_kelamin' => $data["jk"],

							'tingkat' => $data["tingkat"],
							'kelas' => $data["kelas"],
							'petugas_id' => $this->session->userdata("session_petugas_id"),											
						];
						$this->db->set('waktu_entri', 'NOW()', FALSE);
						$query = $this->db->insert("peserta", $data);
						
						$berhasil++;
					}
				}else{
					unlink($inputFileName);
					$this->alert('<strong>Error baris ke-'.($berhasil+3).' pada file excel : </strong>
						<br>Data Nomor Identitas di File Excel mengandung selain Angka. Mohon diperbaiki terlebih dahulu.
						<br>Data yang berhasil masuk ke sistem : <strong>'.$berhasil.' baris.</strong>
					', 'alert-danger', 'superuser/peserta');
					break;
				}

				// print("<pre>".print_r($data, true)."</pre>");
			}

			unlink($inputFileName);
			$this->alert('<strong>Success: </strong>
				<br>Proses import berhasil, data yang berhasil masuk sebanyak <strong>'.$berhasil.' baris</strong>.
			', 'alert-success', 'superuser/peserta');
			
			
		}
	/* # End:Peserta Page # */

	/* # Begin:Tahun Masuk Page # */
		function tahun_masuk(){
			$this->session->unset_userdata('filter_nama');

			$this->db->select("*");
			$this->db->from("tahun_masuk");

			$pagination['base_url'] = base_url() . '/superuser/tahun_masuk/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;

			$this->pagination->initialize($pagination);

			$data['nomor'] = $this->uri->segment(3, 0);
			$data['query'] = $this->superuser_model->searchTahunMasuk($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama = "", $filter_kelas = "");
			$data['total'] = $pagination['total_rows'];
			
			$data['value_nama'] = "";

			$data['content'] 	= "superuser_tahun_masuk";
			$this->load->view('superuser',$data);
		}

		function tahun_masuk_filter(){
			if ( isset($_POST['filter_nama']) ) {
				if($_POST['filter_nama']==""){
					redirect('superuser/tahun_masuk');
				}else{
					$filter_nama = @htmlspecialchars($this->input->post('filter_nama'));

					$this->session->set_userdata('filter_nama', $filter_nama);
				}
			} else {
				$filter_nama = @htmlspecialchars($this->session->userdata('filter_nama'));
			}

			$this->db->select("*");
			$this->db->from("tahun_masuk");
			$this->db->like('nama_tahun_masuk', $filter_nama);

			$pagination['base_url'] = base_url() . '/superuser/tahun_masuk_filter/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;
			
			$this->pagination->initialize($pagination);

			$data['nomor'] = $this->uri->segment(3, 0);
			$data['query'] = $this->superuser_model->searchTahunMasuk($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama, $filter_kelas = "");
			$data['total'] = $pagination['total_rows'];
			
			$data['value_nama'] = $filter_nama;

			$data['content'] 	= "superuser_tahun_masuk";
			$this->load->view('superuser',$data);
		}

		function tahun_masuk_tambah(){
			$data["peserta_tahun_masuk"] = $this->input->post("peserta_tahun_masuk");

			if( isset($_POST["peserta_submit"]) ){
				$this->db->trans_start();
				$data = [
					'nama_tahun_masuk' => $data["peserta_tahun_masuk"],

					'petugas_id' => $this->session->userdata("session_petugas_id"),									
				];
				$this->db->set('waktu_entri', 'NOW()', FALSE);
				$this->db->set('waktu_update', 'NOW()', FALSE);
				$query = $this->db->insert("tahun_masuk", $data);
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					/*#Jika terjadi gagal mengupdate jawaban#*/
					$this->db->trans_rollback();
					$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/tahun_masuk_tambah');
				}else{
					$this->db->trans_commit();
					$data["peserta_nama"] = $this->input->post("peserta_tahun_masuk");
					$this->alert('<strong>Status : </strong><br>Data atas nama <strong>'.$data["peserta_nama"].'</strong> berhasil disimpan.', 'alert-success','superuser/tahun_masuk');				
					
					$data["peserta_tahun_masuk"] = "";
				}
			}

			$data["content"] = "superuser_tahun_masuk_tambah";
			$this->load->view("superuser", $data);
		}

		function tahun_masuk_edit($akun_uuid=NULL){
			if($akun_uuid != NULL){
				$cekIDPserta = $this->superuser_model->getTahunMasuk($akun_uuid);
				if($cekIDPserta->num_rows() > 0){
					$data["tahun_masuk_id"] = $cekIDPserta->row()->tahun_masuk_id;
					
					$data["peserta_tahun_masuk"] = $cekIDPserta->row()->nama_tahun_masuk;
					$data["peserta_active"] = $cekIDPserta->row()->aktif_tahun_masuk;
					/* ## Page Edit ## */
					if( isset($_POST["peserta_submit"]) ){
						$data["tahun_masuk_id"] = $this->input->post("tahun_masuk_id");
					
						$data["peserta_tahun_masuk"] = $this->input->post("peserta_tahun_masuk");
						$data["peserta_active"] = $this->input->post("peserta_active");

						
						/* ## Proses Editing ## */
						$this->db->trans_start();
						$data = [
							'nama_tahun_masuk' => $data["peserta_tahun_masuk"],

							'aktif_tahun_masuk' => $data["peserta_active"],
							'petugas_id' => $this->session->userdata("session_petugas_id"),									
						];
						$this->db->set('waktu_update', 'NOW()', FALSE);
						$this->db->where("tahun_masuk_id", $this->input->post("tahun_masuk_id"));
						$query = $this->db->update("tahun_masuk", $data);
						$this->db->trans_complete();
	
						if ($this->db->trans_status() === FALSE) {
							/*#Jika terjadi gagal mengupdate jawaban#*/
							$this->db->trans_rollback();
							$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/tahun_masuk_edit/'.$data["tahun_masuk_id"]);
						}else{
							$this->db->trans_commit();
							$data["tahun_masuk_id"] = $this->input->post("tahun_masuk_id");
							$data["peserta_nama"] = $this->input->post("peserta_tahun_masuk");
							$this->alert('<strong>Status : </strong><br>Data atas nama <strong>'.$data["peserta_nama"].'</strong> berhasil diperbaharui.', 'alert-success','superuser/tahun_masuk_edit/'.$data["tahun_masuk_id"]);				
						}
					}

					$data["content"] = "superuser_tahun_masuk_edit";
					$this->load->view("superuser", $data);
					
					/* ## Page Edit ## */
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}

		function tahun_masuk_hapus(){
			$berhasil = 0;
			$kode_id = $this->input->post("kode_id");
			
			if(count($kode_id) > 0){
				$this->db->trans_start();
					for($i = 0; $i<count($kode_id); $i++){
						
						$this->db->where("tahun_masuk_id", $kode_id[$i]);
						$this->db->delete("tahun_masuk");

						$berhasil++;
					}
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE) {
					/*# Jika terjadi gagal mengupdate jawaban #*/
					$this->db->trans_rollback();
					echo 'Gagal';
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Success: </strong>
					<br>Hapus Data peserta berhasil, Tahun Masuk yang di-hapus sebanyak <strong>'.$berhasil.' data </strong> secara permanen.
					', 'alert-success', 'superuser/tahun_masuk');
				}
			}else{
				$this->alert('<strong>Status : Gagal</strong><br> Tidak ada data yang dipilih atau dicentang.', 'alert-danger', 'superuser/tahun_masuk');
			}
		}
	/* # End:Tahun Masuk Page # */

	/* # Begin:Tagihan Page# */
		function tagihan(){
			$this->session->unset_userdata('filter_nama');
			$this->session->unset_userdata('filter_kelas');

			$this->db->select("*");
			$this->db->from("tagihan");
			$this->db->join("tahun_masuk", "tahun_masuk.tahun_masuk_id = tagihan.tahun_masuk_id");

			$pagination['base_url'] = base_url() . '/superuser/tagihan/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;

			$this->pagination->initialize($pagination);

			$data['nomor'] = $this->uri->segment(3, 0);
			$data['query'] = $this->superuser_model->searchTagihan($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama = "", $filter_kelas = "");
			$data['total'] = $pagination['total_rows'];
			
			$data['value_nama'] = "";
			$data['value_kelas'] = "";

			$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasukPencarian();
			$data['content'] 	= "superuser_tagihan";
			$this->load->view('superuser',$data);
		}

		function tagihan_filter(){
			if (isset($_POST['filter_nama']) || isset($_POST['filter_kelas']) ) {
				if($_POST['filter_nama']=="" && $_POST['filter_kelas']==""){
					redirect('superuser/tagihan');
				}else{
					$filter_nama = @htmlspecialchars($this->input->post('filter_nama'));
					$filter_kelas = @htmlspecialchars($this->input->post('filter_kelas'));

					$this->session->set_userdata('filter_nama', $filter_nama);
					$this->session->set_userdata('filter_kelas', $filter_kelas);
				}
			} else {
				$filter_nama = @htmlspecialchars($this->session->userdata('filter_nama'));
				$filter_kelas = @htmlspecialchars($this->session->userdata('filter_kelas'));
			}

			$this->db->select("*");
			$this->db->from("tagihan");
			$this->db->join("tahun_masuk", "tahun_masuk.tahun_masuk_id = tagihan.tahun_masuk_id");

			if(!empty($filter_kelas)){
				$this->db->where('tagihan.tahun_masuk_id', $filter_kelas);
			}
			$this->db->like("nama_tagihan", $filter_nama);

			$pagination['base_url'] = base_url() . '/superuser/tagihan_filter/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;
			// $pagination['num_links'] = 4;
			$this->pagination->initialize($pagination);
			$data['query'] = $this->superuser_model->searchTagihan($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama, $filter_kelas);
			$data['nomor'] = $this->uri->segment(3, 0);
			$data['total']=$pagination['total_rows'];

			$data['value_nama'] = $filter_nama;
			$data['value_kelas'] = $filter_kelas;

			$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasukPencarian();
			$data['content'] = 'superuser_tagihan';
			$this->load->vars($data);
			$this->load->view('superuser');
		}

		function tagihan_tambah(){

			$data["tagihan_tahun_masuk"] = $this->input->post("tagihan_tahun_masuk");
			$data["tagihan_nama"] = $this->input->post("tagihan_nama");
			$data["tagihan_nominal"] = $this->input->post("tagihan_nominal");
			$data["tagihan_tipe"] = $this->input->post("tagihan_tipe");

			if( isset($_POST["peserta_submit"]) ){
			
				$this->db->trans_start();
				$data = [
					'tahun_masuk_id' => $data["tagihan_tahun_masuk"],
					
					'nama_tagihan' => $data["tagihan_nama"],
					'nominal' => toNumberFormat($data["tagihan_nominal"]),
					'tipe_tagihan' => $data["tagihan_tipe"],

					'aktif_tagihan' => '1',
					'petugas_id' => $this->session->userdata("session_petugas_id"),									
				];
				$this->db->set('waktu_entri', 'NOW()', FALSE);
				$this->db->set('waktu_update', 'NOW()', FALSE);
				$query = $this->db->insert("tagihan", $data);
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					/*#Jika terjadi gagal mengupdate jawaban#*/
					$this->db->trans_rollback();
					$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/tagihan_tambah');
				}else{
					$this->db->trans_commit();
					$data["peserta_nama"] = $this->input->post("peserta_nama");
					$this->alert('<strong>Status : </strong><br>Data atas nama <strong>'.$data["peserta_nama"].'</strong> berhasil disimpan.', 'alert-success','superuser/tagihan');				
					
					$data["tagihan_nama"] = "";
					$data["tagihan_nominal"] = "";
					$data["tagihan_tipe"] = "";
					$data["tagihan_tahun_masuk"] = "";
				}
			}
			
			$data["tagihan_nominal"] = 0;
			$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasuk();
			$data["content"] = "superuser_tagihan_tambah";
			$this->load->view("superuser", $data);
		}

		function tagihan_edit($akun_uuid=NULL){
			if($akun_uuid != NULL){
				$cekIDPserta = $this->superuser_model->getTagihan($akun_uuid);
				if($cekIDPserta->num_rows() > 0){
					$data["tagihan_id"] = $cekIDPserta->row()->tagihan_id;
					
					$data["tagihan_tahun_masuk"] = $cekIDPserta->row()->tahun_masuk_id;
					$data["tagihan_nama"] = $cekIDPserta->row()->nama_tagihan;
					$data["tagihan_nominal"] = $cekIDPserta->row()->nominal;
					$data["tagihan_tipe"] = $cekIDPserta->row()->tipe_tagihan;
					$data["tagihan_active"] = $cekIDPserta->row()->aktif_tagihan;
					/* ## Page Edit ## */
					if( isset($_POST["peserta_submit"]) ){
						$data["tagihan_id"] = $this->input->post("tagihan_id");
					
						$data["tagihan_tahun_masuk"] = $this->input->post("tagihan_tahun_masuk");
						$data["tagihan_nama"] = $this->input->post("tagihan_nama");
						$data["tagihan_nominal"] = $this->input->post("tagihan_nominal");
						$data["tagihan_tipe"] = $this->input->post("tagihan_tipe");
						$data["tagihan_active"] = $this->input->post("tagihan_active");

							$this->db->trans_start();
							$data = [
								'tahun_masuk_id' => $data["tagihan_tahun_masuk"],
								
								'nama_tagihan' => $data["tagihan_nama"],
								'nominal' => toNumberFormat($data["tagihan_nominal"]),
								'tipe_tagihan' => $data["tagihan_tipe"],

								'aktif_tagihan' => $data["tagihan_active"],
								'petugas_id' => $this->session->userdata("session_petugas_id"),
							];
							$this->db->set('waktu_update', 'NOW()', FALSE);
							$this->db->where("tagihan_id", $this->input->post("tagihan_id"));
							$query = $this->db->update("tagihan", $data);
							$this->db->trans_complete();
		
							if ($this->db->trans_status() === FALSE) {
								/*#Jika terjadi gagal mengupdate jawaban#*/
								$this->db->trans_rollback();
								$this->alert('<strong>Status : </strong><br>Data gagal disimpan, Silahkan coba lagi.', 'alert-danger','superuser/tagihan_edit/'.$data["tagihan_id"]);
							}else{
								$this->db->trans_commit();
								$data["tagihan_id"] = $this->input->post("tagihan_id");
								$data["peserta_nama"] = $this->input->post("tagihan_nama");
								$this->alert('<strong>Status : </strong><br>Data atas nama <strong>'.$data["peserta_nama"].'</strong> berhasil diperbaharui.', 'alert-success','superuser/tagihan_edit/'.$data["tagihan_id"]);				
							}

					}

					$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasuk();
					$data["content"] = "superuser_tagihan_edit";
					$this->load->view("superuser", $data);
					
					/* ## Page Edit ## */
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}

		function tagihan_hapus(){
			$berhasil = 0;
			$kode_id = $this->input->post("kode_id");
			
			if(count($kode_id) > 0){
				$this->db->trans_start();
					for($i = 0; $i<count($kode_id); $i++){
						
						$this->db->where("tagihan_id", $kode_id[$i]);
						$this->db->delete("tagihan");

						$berhasil++;
					}
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE) {
					/*# Jika terjadi gagal mengupdate jawaban #*/
					$this->db->trans_rollback();
					echo 'Gagal';
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Success: </strong>
					<br>Hapus Data peserta berhasil, Tahun Masuk yang di-hapus sebanyak <strong>'.$berhasil.' data </strong> secara permanen.', 'alert-success', 'superuser/tagihan');
				}
			}else{
				$this->alert('<strong>Status : Gagal</strong><br> Tidak ada data yang dipilih atau dicentang.', 'alert-danger', 'superuser/tagihan');
			}

		}
	/* # End:Tagihan Page# */
	
	/* # Begin:Pembayaran Page # */
		function pembayaran(){
			$this->session->unset_userdata('filter_nama');
			$this->session->unset_userdata('filter_kelas');
			$this->session->unset_userdata('filter_tahun');

			$this->db->select("*");
			$this->db->from("peserta");
			$this->db->where("aktif_peserta", "1");

			$pagination['base_url'] = base_url() . '/superuser/pembayaran/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;
			$this->pagination->initialize($pagination);

			$data['nomor'] = $this->uri->segment(3, 0);
			$data['query'] = $this->superuser_model->searchPembayaran($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama = "", $filter_kelas = "", $filter_tahun = "");
			$data['total'] = $pagination['total_rows'];
			
			$data['value_nama'] = "";
			$data['value_kelas'] = "";
			$data['value_tahun'] = "";

			$data['kelas'] = $this->superuser_model->dropdownKelas();
			$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasuk();
			$data['content'] 	= "superuser_pembayaran";
			$this->load->view('superuser',$data);
		}

		function pembayaran_filter(){
			if (isset($_POST['filter_nama']) || isset($_POST['filter_kelas']) || isset($_POST['filter_tahun']) ) {
				if($_POST['filter_nama']=="" && $_POST['filter_kelas']=="" && $_POST['filter_tahun']==""){
					redirect('superuser/pembayaran');
				}else{
					$filter_nama = @htmlspecialchars($this->input->post('filter_nama'));
					$filter_kelas = @htmlspecialchars($this->input->post('filter_kelas'));
					$filter_tahun = @htmlspecialchars($this->input->post('filter_tahun'));

					$this->session->set_userdata('filter_nama', $filter_nama);
					$this->session->set_userdata('filter_kelas', $filter_kelas);
					$this->session->set_userdata('filter_tahun', $filter_tahun);
				}
			} else {
				$filter_nama = @htmlspecialchars($this->session->userdata('filter_nama'));
				$filter_kelas = @htmlspecialchars($this->session->userdata('filter_kelas'));
				$filter_tahun = @htmlspecialchars($this->session->userdata('filter_tahun'));
			}

			$this->db->select("*");
			$this->db->from("peserta");
			$this->db->join("tahun_masuk", "tahun_masuk.tahun_masuk_id = peserta.tahun_masuk_id");
			$this->db->where("aktif_peserta", "1");

			$kelas_ex = explode("-", $filter_kelas);
			if(!empty($filter_kelas)){
				$this->db->where('tingkat', $kelas_ex[0]);
                $this->db->where('kelas', $kelas_ex[1]);
			}

			if(!empty($filter_tahun)){
				$this->db->where('peserta.tahun_masuk_id', $filter_tahun);
			}

			if(!empty($filter_nama)){
				$this->db->like("nama_lengkap", $filter_nama);
				$this->db->or_like('no_identitas', $filter_nama);
			}
	
			$pagination['base_url'] = base_url() . '/superuser/pembayaran_filter/';
			$pagination['total_rows'] = $this->db->count_all_results();
			$pagination['full_tag_open'] = '<ul class="pagination">';
			$pagination['full_tag_close'] = '</ul>';

			$pagination['first_link'] = '&laquo; First';
			$pagination['first_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['first_tag_close'] = '</li>';

			$pagination['last_link'] = 'Last &raquo;';
			$pagination['last_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['last_tag_close'] = '</li>';

			$pagination['next_link'] = 'Next &rarr;';
			$pagination['next_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['next_tag_close'] = '</li>';

			$pagination['prev_link'] = '&larr; Previous';
			$pagination['prev_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['prev_tag_close'] = '</li>';

			$pagination['cur_tag_open'] = '<li class="btn m-btn--square  btn-brand btn-sm active" style="margin: 0 2px;"><a href="" style="color: #FFF;">';
			$pagination['cur_tag_close'] = '</a></li>';

			$pagination['num_tag_open'] = '<li class="btn m-btn--square  btn-outline-metal btn-sm" style="margin: 0 2px;">';
			$pagination['num_tag_close'] = '</li>';
			$pagination['per_page'] = "10";
			$pagination['uri_segment'] = 3;
			$this->pagination->initialize($pagination);
			$data['query'] = $this->superuser_model->searchPembayaran($pagination['per_page'], $this->uri->segment(3, 0), $filter_nama, $filter_kelas, $filter_tahun);
			$data['nomor'] = $this->uri->segment(3, 0);
			$data['total']=$pagination['total_rows'];

			$data['value_nama'] = $filter_nama;
			$data['value_kelas'] = $filter_kelas;
			$data['value_tahun'] = $filter_tahun;

			$data['kelas'] = $this->superuser_model->dropdownKelas();
			$data['tahun_masuk'] = $this->superuser_model->dropdownTahunMasuk();
			$data['content'] = 'superuser_pembayaran';
			$this->load->vars($data);
			$this->load->view('superuser');
		}

		function pembayaran_detail($peserta_id=NULL){
			if($peserta_id != NULL){
				$cekIDPserta = $this->superuser_model->getAkun($peserta_id);
				if($cekIDPserta->num_rows() > 0){
					$data["peserta"] = $cekIDPserta->row_array();
					$data["tagihan"] = $this->superuser_model->getTagihanPeserta($cekIDPserta->row()->peserta_id);
					$data["transaksi"] = $this->superuser_model->getTransaksiPeserta($cekIDPserta->row()->peserta_id);
					$data["content"] = "superuser_pembayaran_detail";
					$this->load->view("superuser", $data);
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}

		function pembayaran_pemetaan($peserta_id=NULL){
			if($peserta_id != NULL){
				$cekIDPserta = $this->superuser_model->getAkun($peserta_id);
				if($cekIDPserta->num_rows() > 0){
					$data["value_tahun_masuk"] = "";
					$data["tahun_masuk"] = $this->superuser_model->dropdownTahunMasuk();
					
					$data["peserta"] = $cekIDPserta->row_array();
					$data["tagihan"] = $this->superuser_model->getTagihanPeserta($cekIDPserta->row()->peserta_id);
					$data["transaksi"] = $this->superuser_model->getTagihanTahunMasuk();
					$data["content"] = "superuser_pembayaran_pemetaan";
					$this->load->view("superuser", $data);
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}

		function pembayaran_tambah($peserta_id=NULL){
			if($peserta_id != NULL){
				$cekIDPserta = $this->superuser_model->getAkun($peserta_id);
				if($cekIDPserta->num_rows() > 0){
					$data["peserta"] = $cekIDPserta->row_array();
					$data["tagihan"] = $this->superuser_model->getTagihanPeserta($cekIDPserta->row()->peserta_id);
					$data["transaksi"] = $this->superuser_model->getTransaksiPeserta($cekIDPserta->row()->peserta_id);
					$data["content"] = "superuser_pembayaran_tambah";
					$this->load->view("superuser", $data);
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}

		function pembayaran_proses(){
			$peserta_id = $this->input->post("peserta_id");
			$id_angsur = $this->input->post("id_angsur");
			$input_angsur = $this->input->post("input_angsur");
			$input_sekali = $this->input->post("input_sekali");
			$input_diskon = $this->input->post("input_diskon");

			if ($this->input->post("bayar_submit")){
				$this->db->trans_start();

				$entri_transaksi = [
					"peserta_id" => $peserta_id,
					"petugas_id" => $this->session->userdata("session_petugas_id"),
				];
				$this->db->set('waktu_entri', 'NOW()', FALSE);
				$this->db->insert('transaksi', $entri_transaksi);
				$transaksi_id = $this->db->insert_id();


				// Angsur
				if($input_angsur != NULL){
					for($i=0; $i < count($input_angsur); $i++){
						if ($input_angsur[$i] != "0"){

							$entri_angsur = [
								"transaksi_id" => $transaksi_id,
								"peserta_id" => $peserta_id,
								"tagihan_id" => $id_angsur[$i],
								"tipe_transaksi" => 'tunai',
								"nominal_bayar" => toNumberFormat($input_angsur[$i]),
								"petugas_id" => $this->session->userdata("session_petugas_id"),
							];
							$this->db->set('waktu_entri', 'NOW()', FALSE);
							$this->db->insert('rincian', $entri_angsur);

						}
					}
				}

				// Sekali
				if($input_sekali != NULL){
					for($i=0; $i < count($input_sekali); $i++){
						$input_split = explode("-",$input_sekali[$i]); 

						$entri_sekali = [
							"transaksi_id" => $transaksi_id,
							"peserta_id" => $peserta_id,
							"tagihan_id" => $input_split[0],
							"tipe_transaksi" => 'tunai',
							"nominal_bayar" => toNumberFormat($input_split[1]),
							"petugas_id" => $this->session->userdata("session_petugas_id"),
						];
						$this->db->set('waktu_entri', 'NOW()', FALSE);
						$this->db->insert('rincian', $entri_sekali);
					}
				}

				// Diskon
				// if($input_diskon[0] != "0"){
				// 	$entri_diskon = [
				// 		"transaksi_id" => $transaksi_id,
				// 		"peserta_id" => $peserta_id,
				// 		"tagihan_id" => NULL,
				// 		"tipe_transaksi" => 'diskon',
				// 		"nominal_bayar" => toNumberFormat($input_diskon[0]),
				// 		"petugas_id" => $this->session->userdata("session_petugas_id"),
				// 	];
				// 	$this->db->set('waktu_entri', 'NOW()', FALSE);
				// 	$this->db->insert('rincian', $entri_diskon);
				// }
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$this->alert('<strong>Data gagal disimpan,</strong><br>Silahkan coba lagi.', 'alert-danger','superuser/pembayaran_detail/'.$peserta_id);
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Status : </strong><br>Proses pembayaran berhasil disimpan.', 'alert-success','superuser/pembayaran_cetak/'.$transaksi_id);				
				}

			}else{
				show_404();
			}
		}

		function pembayaran_cetak($transaksi_id = NULL){
			if($transaksi_id != NULL){
				$cekData = $this->superuser_model->getTransaksi($transaksi_id);
				if($cekData->num_rows() > 0){
					$data["row"] = $cekData->row_array();
					
					$data["peserta"] = $this->superuser_model->getAkun($cekData->row()->peserta_id)->row_array();
					$data["rincian"] = $this->superuser_model->getRincian($cekData->row()->transaksi_id);
					$data["diskon"] = $this->superuser_model->getTagihanDiskon($cekData->row()->transaksi_id);
					
					$data["content"] = "superuser_pembayaran_cetak";
					$data["land"] = TRUE;
					$this->load->view("superuser", $data);

				}else{
					show_404();
				}
			}else{
				show_404();
			}
			
		}

		function pembayaran_cetak_riwayat($peserta_id = NULL){
			if($peserta_id != NULL){
				$cekIDPserta = $this->superuser_model->getAkun($peserta_id);
				if($cekIDPserta->num_rows() > 0){
					$data["peserta"] = $cekIDPserta->row_array();
					$data["tagihan"] = $this->superuser_model->getTagihanPeserta($cekIDPserta->row()->peserta_id);
					$data["transaksi"] = $this->superuser_model->getTransaksiPeserta($cekIDPserta->row()->peserta_id);
					$data["content"] = "superuser_pembayaran_cetak_riwayat";
					$data["land"] = TRUE;
					$this->load->view("superuser", $data);
				}else{
					show_404();
				}
			}else{
				show_404();
			}
			
		}

		
		function pembayaran_tambah_tagihan(){
			$berhasil = 0;
			$kode_id = $this->input->post("kode_id");
			$peserta_id = $this->input->post("peserta_id");
			
			if($kode_id != NULL){
				$this->db->trans_start();
					for($i = 0; $i<count($kode_id); $i++){
						
						$data = [
							'tagihan_id' => $kode_id[$i],									
							'peserta_id' => $peserta_id,									
							'petugas_id' => $this->session->userdata("session_petugas_id"),									
						];
						$this->db->set('waktu_entri', 'NOW()', FALSE);
						$query = $this->db->insert("tagihan_peserta", $data);

						$berhasil++;
					}
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE) {
					/*# Jika terjadi gagal mengupdate jawaban #*/
					$this->db->trans_rollback();
					echo 'Gagal';
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Success: </strong>
					<br>Tambah Data Tagihan peserta berhasil, sebanyak <strong>'.$berhasil.' data </strong>.', 'alert-success', 'superuser/pembayaran_pemetaan/'.$peserta_id);
				}
			}else{
				$this->alert('<strong>Status : Gagal</strong><br> Tidak ada data yang dipilih atau dicentang.', 'alert-danger', 'superuser/pembayaran_pemetaan/'.$peserta_id);
			}

		}

		function pembayaran_hapus_tagihan(){
			$berhasil = 0;
			$kode_id = $this->input->post("kode_id");
			$peserta_id = $this->input->post("peserta_id");
			
			if($kode_id != NULL){
				$this->db->trans_start();
					for($i = 0; $i<count($kode_id); $i++){
						
						$this->db->where('tagihan_id', $kode_id[$i]);
						$this->db->where('peserta_id', $peserta_id);
						$query = $this->db->delete("tagihan_peserta");

						$berhasil++;
					}
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE) {
					/*# Jika terjadi gagal mengupdate jawaban #*/
					$this->db->trans_rollback();
					echo 'Gagal';
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Success: </strong>
					<br>Hapus Data Tagihan peserta berhasil, sebanyak <strong>'.$berhasil.' data </strong>.', 'alert-success', 'superuser/pembayaran_pemetaan/'.$peserta_id);
				}
			}else{
				$this->alert('<strong>Status : Gagal</strong><br> Tidak ada data yang dipilih atau dicentang.', 'alert-danger', 'superuser/pembayaran_pemetaan/'.$peserta_id);
			}

		}

		function pembayaran_transaksi_hapus(){
			$berhasil = 0;
			$kode_id = $this->input->post("kode_id");
			$peserta_id = $this->input->post("peserta_id");
			
			if(count($kode_id) > 0){
				$this->db->trans_start();
					for($i = 0; $i<count($kode_id); $i++){
						
						$this->db->where("transaksi_id", $kode_id[$i]);
						$this->db->delete("rincian");

						$this->db->where("transaksi_id", $kode_id[$i]);
						$this->db->delete("transaksi");

						$berhasil++;
					}
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE) {
					/*# Jika terjadi gagal mengupdate jawaban #*/
					$this->db->trans_rollback();
					echo 'Gagal';
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Success: </strong>
					<br>Hapus Data peserta berhasil, Transaksi yang di-hapus sebanyak <strong>'.$berhasil.' data </strong> secara permanen.', 'alert-success', 'superuser/pembayaran_detail/'.$peserta_id);
				}
			}else{
				$this->alert('<strong>Status : Gagal</strong><br> Tidak ada data yang dipilih atau dicentang.', 'alert-danger', 'superuser/pembayaran_detail/'.$peserta_id);
			}

		}

		function pembayaran_rincian_hapus(){
			$berhasil = 0;
			$kode_id = $this->input->post("kode_id");
			$transaksi_id = $this->input->post("transaksi_id");
			
			if(count($kode_id) > 0){
				$this->db->trans_start();
					for($i = 0; $i<count($kode_id); $i++){
						
						$this->db->where("rincian_id", $kode_id[$i]);
						$this->db->delete("rincian");

						$berhasil++;
					}
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE) {
					/*# Jika terjadi gagal mengupdate jawaban #*/
					$this->db->trans_rollback();
					echo 'Gagal';
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Success: </strong>
					<br>Hapus Data peserta berhasil, Transaksi yang di-hapus sebanyak <strong>'.$berhasil.' data </strong> secara permanen.', 'alert-success', 'superuser/pembayaran_cetak/'.$transaksi_id);
				}
			}else{
				$this->alert('<strong>Status : Gagal</strong><br> Tidak ada data yang dipilih atau dicentang.', 'alert-danger', 'superuser/pembayaran_cetak/'.$transaksi_id);
			}

		}

		function pembayaran_laporan(){
			$tombol_submit = $this->input->post("tombol_submit");
			if(isset($tombol_submit)){
				$tanggal = $this->input->post("tanggal");
				$petugas_id = $this->input->post("petugas_id");

				$data["transaksi"] = $this->superuser_model->laporanRincianPetugas($tanggal, $petugas_id);
				$data["tanggal"] = $tanggal;
				$data["petugas_id"] = $petugas_id;

				$data["tombol_submit"] = $tombol_submit;
			}else{
				$data["transaksi"] = NULL;
				$data["tanggal"] = date("Y-m-d");
				$data["petugas_id"] = "";

				$data["tombol_submit"] = NULL;
			}

			$data["dropdownPetugas"] = $this->superuser_model->dropdownPetugas();
			$data["content"] = "superuser_pembayaran_laporan";
			$this->load->view("superuser", $data);
		}

		function pembayaran_beritaacara(){
			$tombol_submit = $this->input->post("tombol_submit");
			if(isset($tombol_submit)){
				$tanggal = $this->input->post("tanggal");
				$petugas_id = $this->input->post("petugas_id");

				$data["transaksi"] = $this->superuser_model->laporanRincianPetugas($tanggal, $petugas_id);
				$data["tanggal"] = $tanggal;
				$data["petugas_id"] = $petugas_id;

				$data["tombol_submit"] = $tombol_submit;
			}else{
				$data["transaksi"] = NULL;
				$data["tanggal"] = date("Y-m-d");
				$data["petugas_id"] = "";

				$data["tombol_submit"] = NULL;
			}

			$data["dropdownPetugas"] = $this->superuser_model->dropdownPetugas();
			$data["content"] = "superuser_pembayaran_beritaacara";
			$this->load->view("superuser", $data);
		}
	/* # End:Pembayaran Page # */

	/* # Begin:Rekap Page */
		function rekap_kelas(){
			$tombol_submit = $this->input->post("tombol_submit");
			if(isset($tombol_submit)){
				$filter_kelas = $this->input->post("filter_kelas");

				$data["peserta"] = $this->superuser_model->getRekapPerkelas($filter_kelas);
				$data["value_kelas"] = $filter_kelas;
				$data["tombol_submit"] = $tombol_submit;
			}else{
				
				$data["value_kelas"] = "";
				$data["tombol_submit"] = NULL;
			}

			$data["kelas"] = $this->superuser_model->dropdownKelas();
			$data["content"] = "superuser_rekap_kelas";
			$this->load->view("superuser", $data);
		}

		function rekap_harian(){
			$tombol_submit = $this->input->post("tombol_submit");
			if(isset($tombol_submit)){
				$filter_tagihan = $this->input->post("filter_tagihan");
				$filter_tanggal = $this->input->post("filter_tanggal");
				$ex_tanggal 	= explode("-",$filter_tanggal);
				
				$tanggal_awal = date("Y-m-d", strtotime($ex_tanggal[0]));
				$tanggal_akhir = date("Y-m-d", strtotime($ex_tanggal[1]));
				
				$data["tanggal"] = $this->superuser_model->getTanggalInterval($tanggal_awal, $tanggal_akhir);
				$data["value_tanggal"] = $filter_tanggal;
				$data["value_tagihan"] = $filter_tagihan;
				$data["ex_tanggal"] = $ex_tanggal;
				$data["tombol_submit"] = $tombol_submit;
			}else{
				
				$data["value_tanggal"] = "";
				$data["value_tagihan"] = "";
				$data["tombol_submit"] = NULL;
			}

			$data["tagihan"] = $this->superuser_model->dropdownTagihan();
			$data["content"] = "superuser_rekap_harian";
			$this->load->view("superuser", $data);
		}

		function rekap_bulanan(){
			$tombol_submit = $this->input->post("tombol_submit");
			if(isset($tombol_submit)){
				$filter_tanggal = $this->input->post("filter_tanggal");
				$filter_tagihan = $this->input->post("filter_tagihan");
				$ex_tanggal 	= explode("-",$filter_tanggal);
				
				$tanggal_awal = date("Y-m-d", strtotime($ex_tanggal[0]));
				$tanggal_akhir = date("Y-m-d", strtotime($ex_tanggal[1]));
				
				$data["tanggal"] = $this->superuser_model->getTanggalInterval($tanggal_awal, $tanggal_akhir);
				$data["value_tanggal"] = $filter_tanggal;
				$data["value_tagihan"] = $filter_tagihan;
				$data["ex_tanggal"] = $ex_tanggal;
				$data["tombol_submit"] = $tombol_submit;
			}else{
				
				$data["value_tanggal"] = "";
				$data["tombol_submit"] = NULL;
				$data["value_tagihan"] = "";
			}

			$data["content"] = "superuser_rekap_bulanan";
			$this->load->view("superuser", $data);
		}
	/* # End:Rekap Page */
	}	
?>