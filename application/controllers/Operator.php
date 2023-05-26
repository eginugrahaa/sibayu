<?php
	class Operator extends CI_Controller{

	/* # Begin:Default # */
		function __construct(){
			parent:: __construct();
			$this->load->model("operator_model");
			$this->load->model("superuser_model");
			$this->load->library(array('pagination'));
			
			if ($this->session->userdata("operator_login") != TRUE) {
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
			$data["content"] 	= "operator_dashboard";
			$this->load->view("operator", $data);
		}
	/* # End:Dashboard Page # */

	/* # Begin:Pembayaran Page # */
		function pembayaran(){
			$this->session->unset_userdata('filter_nama');
			$this->session->unset_userdata('filter_kelas');
			$this->session->unset_userdata('filter_tahun');

			$this->db->select("*");
			$this->db->from("peserta");
			$this->db->join("tahun_masuk", "tahun_masuk.tahun_masuk_id = peserta.tahun_masuk_id");
			$this->db->where("aktif_peserta", "1");

			$pagination['base_url'] = base_url() . '/operator/pembayaran/';
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
			$data['content'] 	= "operator_pembayaran";
			$this->load->view('operator',$data);
		}

		function pembayaran_filter(){
			if (isset($_POST['filter_nama']) || isset($_POST['filter_kelas']) || isset($_POST['filter_tahun']) ) {
				if($_POST['filter_nama']=="" && $_POST['filter_kelas']=="" && $_POST['filter_tahun']==""){
					redirect('operator/pembayaran');
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
	
			$pagination['base_url'] = base_url() . '/operator/pembayaran_filter/';
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
			$data['content'] = 'operator_pembayaran';
			$this->load->vars($data);
			$this->load->view('operator');
		}

		function pembayaran_detail($peserta_id=NULL){
			if($peserta_id != NULL){
				$cekIDPserta = $this->superuser_model->getAkun($peserta_id);
				if($cekIDPserta->num_rows() > 0){
					$data["peserta"] = $cekIDPserta->row_array();
					$data["tagihan"] = $this->superuser_model->getTagihanPeserta($cekIDPserta->row()->peserta_id);
					$data["transaksi"] = $this->superuser_model->getTransaksiPeserta($cekIDPserta->row()->peserta_id);
					$data["content"] = "operator_pembayaran_detail";
					$this->load->view("operator", $data);
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
					$data["content"] = "operator_pembayaran_tambah";
					$this->load->view("operator", $data);
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
				/*
				if($input_diskon[0] != "0"){
					$entri_diskon = [
						"transaksi_id" => $transaksi_id,
						"peserta_id" => $peserta_id,
						"tagihan_id" => NULL,
						"tipe_transaksi" => 'diskon',
						"nominal_bayar" => toNumberFormat($input_diskon[0]),
						"petugas_id" => $this->session->userdata("session_petugas_id"),
					];
					$this->db->set('waktu_entri', 'NOW()', FALSE);
					$this->db->insert('rincian', $entri_diskon);
				}
				*/
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$this->alert('<strong>Data gagal disimpan,</strong><br>Silahkan coba lagi.', 'alert-danger','operator/pembayaran_detail/'.$peserta_id);
				}else{
					$this->db->trans_commit();
					$this->alert('<strong>Status : </strong><br>Proses pembayaran berhasil disimpan.', 'alert-success','operator/pembayaran_cetak/'.$transaksi_id);				
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
					$data["land"] = TRUE;
					$data["content"] = "operator_pembayaran_cetak";
					$this->load->view("operator", $data);

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
					$data["content"] = "operator_pembayaran_cetak_riwayat";
					$data["land"] = TRUE;
					$this->load->view("operator", $data);
				}else{
					show_404();
				}
			}else{
				show_404();
			}
			
		}

		function pembayaran_laporan(){
			$tombol_submit = $this->input->post("tombol_submit");
			if(isset($tombol_submit)){
				$tanggal = $this->input->post("tanggal");
				$petugas_id = $this->input->post("petugas_id");

				$data["transaksi"] = $this->operator_model->laporanRincianPetugas($tanggal, $petugas_id);
				$data["tanggal"] = $tanggal;
				$data["petugas_id"] = $petugas_id;

				$data["tombol_submit"] = $tombol_submit;
			}else{
				$data["transaksi"] = NULL;
				$data["tanggal"] = "";
				$data["petugas_id"] = "";

				$data["tombol_submit"] = NULL;
			}

			$data["dropdownPetugas"] = $this->operator_model->dropdownPetugas();
			$data["content"] = "operator_pembayaran_laporan";
			$this->load->view("operator", $data);
		}

		function pembayaran_beritaacara(){
			$tombol_submit = $this->input->post("tombol_submit");
			if(isset($tombol_submit)){
				$tanggal = $this->input->post("tanggal");
				$petugas_id = $this->input->post("petugas_id");

				$data["transaksi"] = $this->operator_model->laporanRincianPetugas($tanggal, $petugas_id);
				$data["tanggal"] = $tanggal;
				$data["petugas_id"] = $petugas_id;

				$data["tombol_submit"] = $tombol_submit;
			}else{
				$data["transaksi"] = NULL;
				$data["tanggal"] = "";
				$data["petugas_id"] = "";

				$data["tombol_submit"] = NULL;
			}

			$data["dropdownPetugas"] = $this->operator_model->dropdownPetugas();
			$data["content"] = "operator_pembayaran_beritaacara";
			$this->load->view("operator", $data);
		}
	/* # End:Pembayaran Page # */
	}
?>