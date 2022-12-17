<?php
class Flights_lib {
/**
* Protected variables
*/
  protected $ci = NULL; //codeigniter instance
  protected $db; //database instatnce instance
  public $hotelid;
  public $appSettings;
  public $tripadvisorid;
  public $title;
  public $slug;
  public $bookingSlug;
  public $stars;
  public $basicprice;
  public $discountprice;
  public $desc;
  public $location;
  public $country;
  public $policy;
  public $roomid;
  public $roomtitle;
  public $roomdesc;
  public $roomprice;
  public $roompernight;
  public $thumbnail;
  public $isspecial;
  public $currencysign;
  public $currencycode;
  public $isfeatured;
  public $trusted;
  public $bestprice;
  public $refundable;
  public $arrivalpay;
  public $comm_type;
  public $comm_value;
  public $tax_type;
  public $tax_value;
  public $deposit = 0;
  public $taxamount = 0;
  public $bookingtotal = 0;
  public $phone;
  public $email;
  public $website;
  public $checkin;
  public $checkout;
  public $defcheckin;
  public $defcheckout;
  public $adults;
  public $children;
  public $stay = 1;
  public $roomscount = 1;
  public $stayerror = "";
  public $roomscounterror = "";
  public $checkinout = "";
  public $langdef;
  public $lowestprice;
  public $roomsavailable = false;
  public $amenities;
  public $paymentOptions;
  public $sliderImages;
  public $latitude;
  public $logitude;
  public $relatedHotels;
  public $selectedLocation;
  public $keywords;
  public $metadesc;
  public $createdAt;
  protected $lang;
  function __construct() {
//get the CI instance
    $this->ci = & get_instance();
    $this->db = $this->ci->db;
    $this->appSettings = $this->ci->Settings_model->get_settings_data();
    $this->ci->load->model('Flights/Flights_model');
    $this->currencysign = $this->appSettings[0]->currency_sign;
    $this->currencycode = $this->appSettings[0]->currency_code;
    $this->checkin = $this->ci->input->get('checkin');
    $this->checkout = $this->ci->input->get('checkout');
    $loc = $this->ci->input->get('searching');
    $this->children = 0;
    $adultss = $this->ci->input->get('adults');
    if (empty($adultss)) {
      $this->adults = 2;
    }
    else {
      $this->adults = $this->ci->input->get('adults');
    }
    $childd = $this->ci->input->get('child');
    if (empty($childd)) {
      $this->children = 0;
    }
    else {
      $this->children = $this->ci->input->get('child');
    }
    $rcc = $this->ci->input->get('roomscount');
    if (empty($rcc)) {
      $this->roomscount = 1;
    }
    else {
      $this->roomscount = $this->ci->input->get('roomscount');
    }
    $this->stay = pt_count_days($this->checkin, $this->checkout);
    if (empty($this->checkin) || empty($this->checkout)) {
      $this->stay = 1;
      $this->checkin = date($this->appSettings[0]->date_f, strtotime('+' . CHECKIN_SPAN . ' day', time()));
      $this->checkout = date($this->appSettings[0]->date_f, strtotime('+' . CHECKOUT_SPAN . ' day', time()));
    }
    $unixcheckin = convert_to_unix($this->checkin);
    $unixcheckout = convert_to_unix($this->checkout);
    $current = strtotime(date('m/d/Y'));
    if (empty($this->checkin) || empty($this->checkout)) {
//	$this->showprice = false;
    }
    elseif ($unixcheckin < $current || $unixcheckout < $current || $unixcheckin > $unixcheckout) {
      $this->stayerror = "1";
    }
    else {
      $getVariables = $this->ci->input->get();
      if (!empty($getVariables)) {
        $this->checkinout = "?&checkin=" . $this->checkin . "&checkout=" . $this->checkout . "&adults=" . $this->adults . "&child=" . $this->children;
      }
    }
    if (!empty($loc)) {
      $this->selectedLocation = $loc;
    }
    else {
      $this->selectedLocation = "";
    }
    $this->set_lang($this->ci->session->userdata('set_lang'));
    $this->langdef = DEFLANG;
  }
  function set_hotelid($hotelslug) {
    $this->db->select('hotel_id');
    $this->db->where('hotel_slug', $hotelslug);
    $r = $this->db->get('pt_hotels')->result();
    $this->hotelid = $r[0]->hotel_id;
  }
  function set_lang($lang) {
    if (empty($lang)) {
      $defaultlang = pt_get_default_language();
      $this->lang = $defaultlang;
    }
    else {
      $this->lang = $lang;
    }
  }
//set hotel id by id
  function set_id($id) {
    $this->hotelid = $id;
  }


    function getUpdatedDataBookResultObject($itemid,$adult,$child,$infants,$extra){
        $this->ci->load->library('currconverter');
        $tax = $this->ci->Flights_model->get_taxdeposite($itemid);
        $price = 0;
        foreach ($tax as $res)
        {
            $price  = $price + ($res->adults_price * $adult)+ ($res->child_price * $child) + ($res->infants_price * $infants);
        }
//        echo "<pre>";
//        print_r($tax[0]->tax);
//        echo "</pre>";
//        exit();
        $result = array();
        $curr = $this->ci->currconverter;
        $total = $curr->convertPriceFloat($price);
        $taxpay = $tax[0]->tax/100;
        $depositepay = $tax[0]->deposite/100;
        $final_tax = $taxpay*$total;
        $final_deposite = $depositepay*($total+$result->tax);
        $final_total_price = $total+$result->tax;
        $bookingData = (object) array('grandTotal' => $final_total_price, 'taxAmount' => $final_tax, 'depositAmount' => $final_deposite, 'extrashtml' => "", 'bookingType' => "flights", 'currCode' => $curr->code, 'stay' => 1, 'currSymbol' => $curr->symbol, 'subitem' => $extra, 'extrasInfo' => "");
        return json_encode($bookingData);
    }


    function get_id() {
    return $this->hotelid;
  }
  function settings() {
    return $this->ci->Settings_model->get_front_settings('hotels');
  }
  public function convertAmount($price) {
        $this->ci->load->library('currconverter');
        $curr = $this->ci->currconverter;
        return $curr->convertPriceFloat($price, 0);
  }

  function featured_flights_list() {
    $this->db->where('status','Yes');
    $this->db->order_by('id','desc');
    return $this->db->get('pt_flights')->result();
  }
  function getFeaturedFlights() {
    $flights = $this->featured_flights_list();
    $result = $this->getResultObject($flights);
    return $result;
  }
//make a result object all data of flights array
  function getResultObject($flights) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    foreach ($flights as $f) {
    //  $this->set_id($f->id);
    if(empty($f->thumbnail)){
$thumbnail = "blank.jpg";
    }else{
$thumbnail = $f->thumbnail;
    }


      $result[] = (object) array('id' => $f->id, 'title' => $f->title,'from' => $f->from,'to' => $f->to, 'thumbnail' => PT_FLIGHTS_SLIDER.$thumbnail, 'desc' => '', 'price' => $f->price, 'currCode' => $curr->code);
    }
    $this->currencycode = $curr->code;
    $this->currencysign = $curr->symbol;
    return $result;
  }


      public function search_logs($paylod){
      $parms = array(
          'from_code' =>$paylod['origin'],
          'to_code' =>$paylod['destination'],
          'date_departure' =>date('Y-m-d',strtotime($paylod['departure_date'])),
          'date_arrival' =>date('Y-m-d',strtotime($paylod['return_date'])),
          'adults' =>$paylod['adults'],
          'infant' =>$paylod['infants'],
          'chlids' =>$paylod['childrens'],

          'ip' =>$paylod['ip'],
          'browser_version' =>$paylod['browser_version'],
          'type' =>$paylod['request_type'],
          'os' =>$paylod['os'],
          'date_time' =>date('Y-m-d H:i:s')
      );
      // dd($parms);
      $this->db->insert('flights_search_logs',$parms);
        $logid = $this->db->insert_id();
      return $logid;
    }

    public function invoceurlupdate($id,$invoice_url){
        $this->ci->load->model('Admin/Emails_model');
        $parm = array('invoice_url'=>$invoice_url);

        $this->db->where('booking_id',$id);
        $this->db->update('flights_bookings',$parm);

        $this->db->select('flights_bookings.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
        $this->db->where('flights_bookings.booking_id',$id);
        $this->db->join('pt_accounts','flights_bookings.booking_user_id = pt_accounts.accounts_id','left');
        $invoiceData = $this->db->get('flights_bookings')->result();

        $type = $invoiceData[0]->booking_supplier;
       // dd($type);
        if($type == 1){
            $moduletype = 'flights';
            $invoiceData['module'] = $moduletype;
            $this->ci->Emails_model->send_suppliermail($invoiceData);
        }

        $this->ci->Emails_model->send_customeremail($invoiceData);
        $this->ci->Emails_model->send_adminemail($invoiceData);


    }


    public function get_booking($booking_id)
    {
       $this->db->select('flights_bookings.*,pt_accounts.*');
       $this->db->from('flights_bookings');
       $this->db->where('flights_bookings.booking_id',$booking_id);
       $this->db->join('pt_accounts','flights_bookings.booking_user_id = pt_accounts.accounts_id');
       return $this->db->get()->row();
    }


      public function get_supplier_id($get_supplier) {
         $this->db->where('name', $get_supplier);
         $get_supplier_id = $this->db->get('modules')->row();
         return $get_supplier_id->id;
    }

    public function response_booking($id,$bookconf,$booking_pnr){
      // var_dump($booking_pnr);
      // exit();
      //if ($module_name == 'aerticket') {
       // if (isset(json_decode($bookconf)->pnr)) {
          $parm = array('booking_response'=>$bookconf,'booking_pnr'=>$booking_pnr);
        //}

      //}elseif ($module_name == 'amadeus') {
        //if (isset(json_decode($bookconf)->response->data)) {
          //$parm = array('booking_response'=>$bookconf,'booking_pnr'=>json_decode($bookconf)->response->data->id
          //);
        //}
     // }
        $this->db->where('booking_id',$id);
        $this->db->update('flights_bookings',$parm);
        $this->db->where('booking_id',$id);
        $getinovice_link = $this->db->get('flights_bookings')->result();
       return $getinovice_link;
    }

}
