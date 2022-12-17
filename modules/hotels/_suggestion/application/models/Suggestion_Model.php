<?php
class Suggestion_Model extends CI_Model{

    public function getloac($name){
        $this->db->select('loc_data');
        $this->db->where('loc_name',$name);
        $query = $this->db->get('loaction');
        return $query->result();
    }

    public function savedata($data){
        $this->db->insert('loaction',$data);
        return $this->db->insert_id();
    }
}
