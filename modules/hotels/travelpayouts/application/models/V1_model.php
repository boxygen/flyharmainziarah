<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class V1_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    //Get amenities
    public function amenities($id){
        $this->db->where('a_id',$id);
        $query = $this->db->get('travelpayouthotel_amenities');
        return $query->result();
    }


}
