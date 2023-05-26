<?php
    class Destroy extends CI_Controller{
        function index(){
            if ($this->session->userdata("peserta_uuid") != NULL) {
				$data = array('status'=>'0');
				$this->db->where('akun_uuid', $this->session->userdata("peserta_uuid"));
				$this->db->update('akun', $data);
			}

			$this->session->set_userdata("operator_login", FALSE);

			$this->session->set_userdata("peserta_login", FALSE);
			$this->session->unset_userdata("peserta_uuid");

			$this->session->unset_userdata("kerjakan");
			$this->session->unset_userdata("ujian_uuid");

			$this->session->sess_destroy();
			redirect();
        }
    }
