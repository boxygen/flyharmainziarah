<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class V1_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_destination($code){
        $this->db->where('destinationName',$code);
        $query = $this->db->get('_modules_viator_countries');
        $check = $query->result();
        return $check[0]->destinationId;
    }
}
