<?php

class Apivisa_model extends CI_Model {

   public function book_user($insert){
   	$query=$this->db->insert('booking_visa',$insert);
      return $query;
   }
   

   public function visa_search_logs($search_log){
      $query=$this->db->insert('visa_search_logs',$search_log);
      return $query;
   }
}

