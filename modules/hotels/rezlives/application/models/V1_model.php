<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class V1_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function getcode($name){

        $this->db->where('name',$name);
        $query = $this->db->get('_modules_hotels_rezlive_cities')->result();
        return $query;

    }

}
