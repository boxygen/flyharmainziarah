<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class V1_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    function get_airport_name($code)
    {
        $this->db->select("_modules_flights_airports.*");
        $this->db->where('code',$code);
        return $this->db->get('_modules_flights_airports')->row()->name;
    }
    function get_airline_name($code)
    {
        $this->db->select("_modules_flights_airlines.*");
        $this->db->where('thumbnail',$code.'.png');
        return $this->db->get('_modules_flights_airlines')->row();
    }


}
