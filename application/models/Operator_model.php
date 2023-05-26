<?php
    class Operator_model extends CI_Model{
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
    }
?>