<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class V1_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function gethotel($code){
        $this->db->where('city',$code);
        $query = $this->db->get('_modules_hotels_hotelston');
        $check = $query->result();
        $arr = [];
        $i = 0;
        foreach ($check as $hotelid){
            $arr[] = $hotelid->hotel_id;
            if ($i++ == 500) break;
        }
        return $arr;
    }

}
