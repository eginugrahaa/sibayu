<?php
    class Superuser_model extends CI_Model{
        function getIdentitas($where = NULL){ 
            $query = $this->db->get('pengaturan');
            $array = $query->result_array();

            $arr = array_map (function($value){
                return $value['pengaturan_isi'];
            } , $array);

            return $arr;
        }

        function updateIdentitas($where, $value){
            $data = array(
                'pengaturan_isi' => $value,
            );
 
            $this->db->where('pengaturan_nama', $where);
            $query = $this->db->update('pengaturan', $data);
            return $query; 
        }

        function searchPeserta($perPage, $uri, $ringkasan, $kelas, $tahun) {
            $this->db->select("*");
			$this->db->from("peserta");
            $this->db->order_by("peserta.waktu_entri","DESC");
    
            if (!empty($ringkasan)) {
                $this->db->like('nama_lengkap', $ringkasan);
                $this->db->or_like('no_identitas', $ringkasan);
            }

            $kelas_ex = explode("-", $kelas);

            if (!empty($kelas)) {
                $this->db->where('tingkat', $kelas_ex[0]);
                $this->db->where('kelas', $kelas_ex[1]);
            }

            if (!empty($tahun)) {
                $this->db->where('peserta.tahun_masuk_id', $tahun);
            }
    
            $getData = $this->db->get('', $perPage, $uri);
    
            if ($getData->num_rows() > 0)
                return $getData->result_array();
            else
                return [];
        }

        function searchTagihan($perPage, $uri, $ringkasan, $kelas) {
            $this->db->select("*");
			$this->db->from("tagihan");
            $this->db->join("tahun_masuk", "tahun_masuk.tahun_masuk_id = tagihan.tahun_masuk_id");
            $this->db->order_by("tagihan.waktu_entri","DESC");

    
            if (!empty($ringkasan)) {
                $this->db->like('nama_tagihan', $ringkasan);
            }

            if (!empty($kelas)) {
                $this->db->where('tagihan.tahun_masuk_id', $kelas);
            }
            
            $getData = $this->db->get('', $perPage, $uri);
    
            if ($getData->num_rows() > 0)
                return $getData->result_array();
            else
                return [];
        }

        function searchTahunMasuk($perPage, $uri, $ringkasan, $kelas) {
            $this->db->select("*");
			$this->db->from("tahun_masuk");
            $this->db->order_by("waktu_entri","DESC");
    
            if (!empty($ringkasan)) {
                $this->db->like('nama_tahun_masuk', $ringkasan);
            }
            
            $getData = $this->db->get('', $perPage, $uri);
    
            if ($getData->num_rows() > 0)
                return $getData->result_array();
            else
                return [];
        }

        function searchPetugas($perPage, $uri, $ringkasan, $kelas) {
            $this->db->select("*");
			$this->db->from("petugas");
            $this->db->order_by("waktu_entri","DESC");
    
            if (!empty($ringkasan)) {
                $this->db->like('nama_petugas', $ringkasan);
            }

            $getData = $this->db->get('', $perPage, $uri);
    
            if ($getData->num_rows() > 0)
                return $getData->result_array();
            else
                return [];
        }

        function dropdownKelas(){
			$data = array();
			$this->db->select("kelas as nama, tingkat");
			$this->db->where("kelas !=", NULL);
			$this->db->group_by("tingkat");
            $this->db->group_by("kelas");
			$this->db->order_by("tingkat", "ASC");
			$this->db->order_by("kelas", "ASC");
			$kelas = $this->db->get("peserta");
			
			$data[""] = "- Semua Kelas -";
			foreach ($kelas->result() as $rkelas) {
				$data[$rkelas->tingkat."-".$rkelas->nama] = $rkelas->tingkat."-".$rkelas->nama;
			}
			
			return $data;
        }

        function dropdownTahunMasuk(){
            $data = array();
            $this->db->where("aktif_tahun_masuk", 1);
            $this->db->order_by("waktu_entri", "DESC");
            $kelas = $this->db->get("tahun_masuk");
            
            foreach ($kelas->result() as $rkelas) {
                $data[$rkelas->tahun_masuk_id] = $rkelas->nama_tahun_masuk;
            }
            
            return $data;
        }

        function dropdownTahunMasukPencarian(){
            $data = array();
            $this->db->where("aktif_tahun_masuk", 1);
            $this->db->order_by("waktu_entri", "DESC");
            $kelas = $this->db->get("tahun_masuk");
            
            $data[""] = "- Semua Tahun Masuk -";
            foreach ($kelas->result() as $rkelas) {
                $data[$rkelas->tahun_masuk_id] = $rkelas->nama_tahun_masuk;
            }
            
            return $data;
        }

        function dropdownTagihan(){
            $data = array();
            $this->db->where("aktif_tagihan", 1);
            $this->db->order_by("nama_tagihan", "ASC");
            $kelas = $this->db->get("tagihan");
            
            //$data[""] = "- Pilih Tagihan -";
            foreach ($kelas->result() as $rkelas) {
                $data[$rkelas->tagihan_id] = $rkelas->nama_tagihan;
            }
            
            return $data;
        }

        function dropdownPetugas(){
            $data = array();
            $this->db->where("aktif_petugas", 1);
            $this->db->order_by("nama_petugas", "ASC");
            $kelas = $this->db->get("petugas");
            
            $data[""] = "- Pilih Petugas -";
            foreach ($kelas->result() as $rkelas) {
                $data[$rkelas->petugas_id] = $rkelas->nama_petugas;
            }
            
            return $data;
        }
        
        function getAkunID($peserta_id){
            $this->db->where("no_identitas", $peserta_id);
            $query = $this->db->get('peserta');
            return $query;
        }

        function getPetugasUsername($username){
            $this->db->where("nama_pengguna", $username);
            $query = $this->db->get('petugas');
            return $query;
        }

        function getAkun($akun_uuid){
            $this->db->where("peserta_id", $akun_uuid);
            $query = $this->db->get('peserta');
            return $query;
        }

        function getTagihanTahunMasuk(){
            $this->db->join("tahun_masuk","tahun_masuk.tahun_masuk_id = tagihan.tahun_masuk_id");
            $query = $this->db->get('tagihan');
            return $query;
        }

        function getTahunMasuk($akun_uuid){
            $this->db->where("tahun_masuk_id", $akun_uuid);
            $query = $this->db->get('tahun_masuk');
            return $query;
        }

        function getTagihan($akun_uuid){
            $this->db->where("tagihan_id", $akun_uuid);
            $query = $this->db->get('tagihan');
            return $query;
        }

        function getPetugas($akun_uuid){
            $this->db->where("petugas_id", $akun_uuid);
            $query = $this->db->get('petugas');
            return $query;
        }

        function getTransaksi($akun_uuid){
            $this->db->select("*, transaksi.waktu_entri as waktu_transaksi");
            $this->db->join("petugas","petugas.petugas_id = transaksi.petugas_id");
            $this->db->where("transaksi_id", $akun_uuid);
            $query = $this->db->get('transaksi');
            return $query;
        }

        function searchPembayaran($perPage, $uri, $ringkasan, $kelas, $tahun) {
            $this->db->select("*");
			$this->db->from("peserta");
            $this->db->where("aktif_peserta","1");
            $this->db->order_by("tingkat","ASC");
            $this->db->order_by("kelas","ASC");
            $this->db->order_by("nama_lengkap","ASC");
    
            if (!empty($ringkasan)) {
                $this->db->like('nama_lengkap', $ringkasan);
                $this->db->or_like('no_identitas', $ringkasan);
            }

            $kelas_ex = explode("-", $kelas);

            if (!empty($kelas)) {
                $this->db->where('tingkat', $kelas_ex[0]);
                $this->db->where('kelas', $kelas_ex[1]);
            }

            if (!empty($tahun)) {
                $this->db->where('peserta.tahun_masuk_id', $tahun);
            }
    
            $getData = $this->db->get('', $perPage, $uri);
    
            if ($getData->num_rows() > 0)
                return $getData->result_array();
            else
                return [];
        }

        function getTagihanPeserta($peserta_id){
            $this->db->join('tagihan','tagihan.tagihan_id = tagihan_peserta.tagihan_id');
            $this->db->where("aktif_tagihan","1");
            $this->db->where("peserta_id", $peserta_id);
            $query = $this->db->get('tagihan_peserta');
            
            if ($query->num_rows() > 0)
                return $query->result_array();
            else
                return [];
        }

        function getTransaksiPeserta($peserta_id){
            $this->db->select("*, transaksi.waktu_entri as waktu_transaksi");
            $this->db->join("petugas","petugas.petugas_id = transaksi.petugas_id");
            $this->db->where("transaksi.peserta_id", $peserta_id);
            $query = $this->db->get('transaksi');
            
            if ($query->num_rows() > 0)
                return $query->result_array();
            else
                return [];
        }

        function rincianCek($peserta_id, $tagihan_id){
            $this->db->select("sum(nominal_bayar) as total_bayar");
            $this->db->where("peserta_id", $peserta_id);
            $this->db->where("tagihan_id", $tagihan_id);
            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function getDiskon($peserta_id){
            $this->db->select("sum(nominal_bayar) as total_diskon");
            $this->db->where("peserta_id", $peserta_id);
            $this->db->where("tagihan_id", NULL);
            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_diskon;
            else
                return 0;
        }

        function getTagihanTransaksi($transaksi_id){
            $this->db->select("sum(nominal_bayar) as total");
            $this->db->where("transaksi_id", $transaksi_id);
            $this->db->where("tipe_transaksi", "tunai");
            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total;
            else
                return 0;
        }

        function getTagihanDiskon_lama($transaksi_id){
            $this->db->select("sum(nominal_bayar) as total");
            $this->db->where("transaksi_id", $transaksi_id);
            $this->db->where("tipe_transaksi", "diskon");
            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total;
            else
                return 0;
        }

        function getTagihanDiskon($transaksi_id){
            $this->db->select("rincian_id, nominal_bayar");
            $this->db->where("transaksi_id", $transaksi_id);
            $this->db->where("tipe_transaksi", "diskon");
            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row_array();
            else
                return 0;
        }

        function getRincian($transaksi_id){
            $this->db->join("tagihan","tagihan.tagihan_id = rincian.tagihan_id");
            $this->db->where("rincian.transaksi_id", $transaksi_id);
            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->result_array();
            else
                return [];
        }

        function laporanRincianPetugas($tanggal, $petugas_id){
            $this->db->join("peserta","peserta.peserta_id = rincian.peserta_id");
            $this->db->join("tagihan","tagihan.tagihan_id = rincian.tagihan_id","LEFT OUTER");
            
            $this->db->where("rincian.petugas_id", $petugas_id);
            $this->db->where("DATE(rincian.waktu_entri)", $tanggal);
            $this->db->order_by("rincian.rincian_id", "ASC");
            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->result_array();
            else
                return [];
        }

        function countTransaksi($tanggal, $petugas_id){
            $this->db->select("count(transaksi_id) as count_transaksi");

            $this->db->where("transaksi.petugas_id", $petugas_id);
            $this->db->where("DATE(transaksi.waktu_entri)", $tanggal);

            $query = $this->db->get('transaksi');
            
            if ($query->num_rows() > 0)
                return $query->row()->count_transaksi;
            else
                return 0;
        }

        function countRincian($tanggal, $petugas_id){
            $this->db->select("count(rincian_id) as count_rincian");

            $this->db->where("rincian.petugas_id", $petugas_id);
            $this->db->where("DATE(rincian.waktu_entri)", $tanggal);

            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->count_rincian;
            else
                return 0;
        }

        function sumRincian($tanggal, $petugas_id, $tipe){
            $this->db->select("sum(nominal_bayar) as total_bayar");

            $this->db->where("rincian.petugas_id", $petugas_id);
            $this->db->where("DATE(rincian.waktu_entri)", $tanggal);
            $this->db->where("rincian.tipe_transaksi", $tipe);

            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function getRekapPerkelas($kelas){
            $kelas_ex = explode("-", $kelas);

            $this->db->where('tingkat', $kelas_ex[0]);
            $this->db->where('kelas', $kelas_ex[1]);
            $query = $this->db->get('peserta');
            
            if($query->num_rows() > 0)
                return $query->result_array();
            else
                return [];
        }

        function getRekapTagihan($peserta_id){
            $this->db->select("sum(nominal) as total_bayar");

            $this->db->join("tagihan", "tagihan.tagihan_id = tagihan_peserta.tagihan_id");
            $this->db->where("tagihan_peserta.peserta_id", $peserta_id);

            $query = $this->db->get('tagihan_peserta');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function getRekapBayar($peserta_id){
            $this->db->select("sum(nominal_bayar) as total_bayar");
            $this->db->where('rincian.tipe_transaksi', 'tunai');
            $this->db->where("rincian.peserta_id", $peserta_id);

            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function getRekapDiskon($peserta_id){
            $this->db->select("sum(nominal_bayar) as total_bayar");
            $this->db->where('rincian.tipe_transaksi', 'diskon');
            $this->db->where("rincian.peserta_id", $peserta_id);

            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function getTanggalInterval($tanggal_awal, $tanggal_akhir){
            $this->db->select('DATE(rincian.waktu_entri) as tanggal_transaksi');
            $this->db->where('DATE(rincian.waktu_entri) >=', $tanggal_awal);
            $this->db->where('DATE(rincian.waktu_entri) <=', $tanggal_akhir);
            
            $this->db->group_by('DATE(rincian.waktu_entri)'); 
            $query = $this->db->get('rincian');
            
            if($query->num_rows() > 0)
                return $query->result_array();
            else
                return [];
        }

        function getBulananInterval($tanggal_awal, $tanggal_akhir){
            $this->db->select('MONTH(rincian.waktu_entri) as bulan_transaksi, YEAR(rincian.waktu_entri) as tahun_transaksi');
            $this->db->where('DATE(rincian.waktu_entri) >=', $tanggal_awal);
            $this->db->where('DATE(rincian.waktu_entri) <=', $tanggal_akhir);
            $this->db->group_by('MONTH(rincian.waktu_entri)'); 
            $this->db->group_by('YEAR(rincian.waktu_entri)'); 
            $query = $this->db->get('rincian');
            
            if($query->num_rows() > 0)
                return $query->result_array();
            else
                return [];
        }
        
        function getRekapBayarTanggal($tanggal, $tagihan_id){
            $this->db->select("sum(nominal_bayar) as total_bayar");
            $this->db->where('rincian.tipe_transaksi', 'tunai');
            $this->db->where("DATE(rincian.waktu_entri)", $tanggal);

            if (!empty($tagihan_id)) {
                $this->db->where('rincian.tagihan_id', $tagihan_id);
            }

            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function getRekapDiskonTanggal($tanggal){
            $this->db->select("sum(nominal_bayar) as total_bayar");
            $this->db->where('rincian.tipe_transaksi', 'diskon');
            $this->db->where("DATE(rincian.waktu_entri)", $tanggal);

            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function getRekapBayarBulanan($bulan, $tahun){
            $this->db->select("sum(nominal_bayar) as total_bayar");
            $this->db->where('rincian.tipe_transaksi', 'tunai');
            $this->db->where("MONTH(rincian.waktu_entri)", $bulan);
            $this->db->where("YEAR(rincian.waktu_entri)", $tahun);

            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function getRekapDiskonBulanan($bulan, $tahun){
            $this->db->select("sum(nominal_bayar) as total_bayar");
            $this->db->where('rincian.tipe_transaksi', 'diskon');
            $this->db->where("MONTH(rincian.waktu_entri)", $bulan);
            $this->db->where("YEAR(rincian.waktu_entri)", $tahun);

            $query = $this->db->get('rincian');
            
            if ($query->num_rows() > 0)
                return $query->row()->total_bayar;
            else
                return 0;
        }

        function countTahunMasukTagihan($tahun_masuk_id){
            $this->db->select("count(tagihan_id) as count_angka");
            $this->db->where("tagihan.tahun_masuk_id", $tahun_masuk_id);
            
            $query = $this->db->get('tagihan');
            
            if ($query->num_rows() > 0)
                return $query->row()->count_angka;
            else
                return 0;
        }

        function countPesertaTagihan($peserta_id){
            $this->db->select("count(tagihan_id) as count_angka");
            $this->db->where("tagihan_peserta.peserta_id", $peserta_id);
            
            $query = $this->db->get('tagihan_peserta');
            
            if ($query->num_rows() > 0)
                return $query->row()->count_angka;
            else
                return 0;
        }

        function countTahunMasukPeserta($tahun_masuk_id){
            $this->db->select("count(peserta_id) as count_angka");
            $this->db->where("peserta.tahun_masuk_id", $tahun_masuk_id);
            
            $query = $this->db->get('peserta');
            
            if ($query->num_rows() > 0)
                return $query->row()->count_angka;
            else
                return 0;
        }
    }