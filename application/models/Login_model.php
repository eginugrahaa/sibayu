<?php
	class Login_model extends CI_Model{
		function check_username($username){
			$this->db->where('nama_pengguna', $username);
			return $this->db->get('petugas');
		}

		function select_akun($username, $password){
			$this->db->where('nama_pengguna', $username);
			$this->db->where('kata_sandi', MD5($password));
			return $this->db->get('petugas');
		}
	}