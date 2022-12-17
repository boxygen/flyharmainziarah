<?php
class Suggestion_Model extends CI_Model{

    public function getdata($data){
        $this->db->where('code',$data);
        return $this->db->get('flights_airports')->result();

    }
}
