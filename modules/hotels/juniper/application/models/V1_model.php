<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class V1_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function getcode($name){
        $this->db->where('Name',str_replace('-',' ',$name));
        $query = $this->db->get('juniper_zone_list')->result();
        if(!empty($query[0]->JPDCode)){
            $this->db->where('Zone_JPDCode',$query[0]->JPDCode);
            $query = $this->db->get('juniper_hotels_list')->result();
            $arr = array();
            foreach ($query as $code){
                $arr[] = $code->JPCode;
            }
            return $arr;
        }

    }

}
