<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller
{

    public $final_array = [];
    public function __construct()
    {
        parent::__construct();

        $this->load->library('ApiClient');
        $this->load->model('V1_model','tm');

        $this->output->set_content_type('application/json');
    }

    function search_post()
    {
        $origin = $this->post('origin');
        $destination = $this->post('destination');
        $departureDate = date("d/m/Y", strtotime($this->post('departure_date')));
        $returnDate = date("d/m/Y", strtotime($this->post('return_date')));
        $adults = $this->post('adults');
        $infants = $this->post('infants');
        $childrens = $this->post('childrens');
        $partner = $this->post('c1');
        $currceny = $this->post('currency');
        $selected_cabins = $this->post('class_trip');
        $type = $this->post('type');
        $api_mode = $this->post('api_mode');
        if($selected_cabins == 'economy'){
            $class = "M";
        } else if($selected_cabins == 'business'){
            $class = "C";
        } else if($selected_cabins == 'first'){
            $class = "F";
        }else{
            $class = "M";
        }

        if($type == 'round'){
            $parm =  array(
                'endpoint' => 'https://api.skypicker.com/flights',
                'flyFrom' => $origin,
                'to' => $destination,
                'date_from' => $departureDate,
                'date_to' => $departureDate,
                'return_from' => $returnDate,
                'return_to' => $returnDate,
                'adults' => $adults,
                'infants' => $infants,
                'children' => $childrens,
                'curr' => $currceny,
                'selected_cabins' => $class,
                'partner' => $partner,
                'limit' => 50,
                'typeFlight' => $type,
            );
        }else{
            $parm =  array(
                'endpoint' => 'https://api.skypicker.com/flights',
                'flyFrom' => $origin,
                'to' => $destination,
                'date_from' => $departureDate,
                'date_to' => $departureDate,
                'adults' => $adults,
                'infants' => $infants,
                'children' => $childrens,
                'curr' => $currceny,
                'selected_cabins' => $class,
                'partner' => $partner,
                'limit' => 50,
                'typeFlight' => $type,
            );
        }


      $kiwi = new ApiClient();
      $kiwi_flight = $kiwi->sendRequest('GET', 'search', $parm);

        //$kiwi_flight = file_get_contents(FCPATH."application/response.json");
        $main_array = json_decode($kiwi_flight);
        foreach ($main_array->data as $segment) {
            $segments["segments"] = array();
                foreach ($segment->route as $value) {

                    $arrival_time = $value->aTime;
                    $arrival_date = $value->aTimeUTC;
                    $departure_date = $value->dTimeUTC;
                    $departure_time = $value->dTime;

                    $airline_name = $this->tm->get_airline_name($value->operating_carrier);

                    $departure_code = $value->cityCodeFrom;
                    $departure_airport = $this->tm->get_airport_name($departure_code);
                    $arrival_code = $value->cityCodeTo;

                    $arrival_airport = $this->tm->get_airport_name($arrival_code);

                    $uri = explode('/', $_SERVER['REQUEST_URI']);
                    $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
                    if ($_SERVER['HTTP_HOST'] == 'localhost') {
                        $img_code = $root . "/" . $uri[1] . "/modules/global/resources/flights/airlines/$value->operating_carrier.png";
                    } else {
                        $img_code = $root . "/modules/global/resources/flights/airlines/$value->operating_carrier.png";
                    }


                    if($api_mode == 0){
                        $redirect = $segment->deep_link;
                    }else{
                        $token = $segment->booking_token;
                    }
                    if ($value->return == 0 ) {

                        $bj = (object)[
                            "return" => $value->return,
                            "combination_id" => $value->combination_id,
                            "departure_flight_no" => $value->flight_no,
                            "img" => $img_code,
                            "departure_time" => date("h:i:s", $departure_time),
                            "departure_date" => date("d-m-Y", $departure_date),
                            "arrival_time" => date("h:i:s", $arrival_time),
                            "arrival_date" => date("d-m-Y", $arrival_date),
                            "departure_code" => $value->cityCodeFrom,
                            "departure_airport" => $departure_airport,
                            "arrival_code" => $value->cityCodeTo,
                            "arrival_airport" => $arrival_airport,
                            "duration_time" => $segment->fly_duration,
                            "currency_code" => $currceny,
                            "price" => $segment->price,
                            "adult_price" => $segment->fare->adults,
                            "child_price" => $segment->fare->children,
                            "infant_price" => $segment->fare->infants,
                            "url" => '',
                            "airline_name" => $airline_name->name,
                            "class_type" => ucfirst($selected_cabins),
                            "form" => '',
                            "form_name" => '',
                            "action" => '',
                            "type" => 'kiwi',
                            "luggage" => '',
                            "desc" => '',
                            "booking_token" => $token,
                            "redirect" => $redirect,
                        ];
                        $segments["segments"][0][] = $bj;
                    }
                }



                if($type == 'round') {
                    foreach ($segment->route as $value) {

                        $arrival_time = $value->aTime;
                        $arrival_date = $value->aTimeUTC;
                        $departure_date = $value->dTimeUTC;
                        $departure_time = $value->dTime;

                        $airline_name = $this->tm->get_airline_name($value->operating_carrier);

                        $departure_code = $value->cityCodeFrom;
                        $departure_airport = $this->tm->get_airport_name($departure_code);
                        $arrival_code = $value->cityCodeTo;

                        $arrival_airport = $this->tm->get_airport_name($arrival_code);

                        $uri = explode('/', $_SERVER['REQUEST_URI']);
                        $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
                        if($_SERVER['HTTP_HOST'] == 'localhost')
                        {
                            $img_code = $root."/".$uri[1]."/modules/global/resources/flights/airlines/$value->operating_carrier.png";
                        } else {
                            $img_code = $root . "/modules/global/resources/flights/airlines/$value->operating_carrier.png";
                        }

                        if($api_mode == 0){
                            $redirect = $segment->deep_link;
                        }else{
                            $token = $segment->booking_token;
                        }

                        if ($value->return == 1) {
                            $bj = (object)[
                                "return" => $value->return,
                                "combination_id" => $value->combination_id,
                                "departure_flight_no" => $value->flight_no,
                                "img" => $img_code,
                                "departure_time" => date("h:i:s", $departure_time),
                                "departure_date" => date("d-m-Y", $departure_date),
                                "arrival_time" => date("h:i:s", $arrival_time),
                                "arrival_date" => date("d-m-Y", $arrival_date),
                                "departure_code" => $value->cityCodeFrom,
                                "departure_airport" => $departure_airport,
                                "arrival_code" => $value->cityCodeTo,
                                "arrival_airport" => $arrival_airport,
                                "duration_time" => $segment->return_duration,
                                "currency_code" => $currceny,
                                "price" => $segment->price,
                                "adult_price" => $segment->fare->adults,
                                "child_price" => $segment->fare->children,
                                "infant_price" => $segment->fare->infants,
                                "url" => '',
                                "airline_name" => $airline_name->name,
                                "class_type" => ucfirst($selected_cabins),
                                "form" => '',
                                "form_name" => '',
                                "action" => '',
                                "type" => 'kiwi',
                                "luggage" => '',
                                "desc" => '',
                                "booking_token" => $token,
                                "redirect" => $redirect,
                            ];
                            $segments["segments"][1][] = $bj;
                        }
                    }
                }
                $this->final_array[] = $segments;
        }
        $this->response($this->final_array,200);
    }

    function book_post(){
        $booking_token = $this->post('booking_token');
        $bnum = $this->post('bnum');
        $adults = $this->post('adults');
        $infants = $this->post('infants');
        $childrens = $this->post('children');
        $pnum = $this->post('pnum');
        $currceny = $this->post('currency');
        $affily = $this->post('affily');
        $pass = $this->post('pass');
        $parm =  array(
            'endpoint' => 'https://booking-api.skypicker.com/api/v0.1/check_flights',
            'booking_token' => $booking_token,
            'adults' => $adults,
            'infants' => $infants,
            'children' => $childrens,
            'currency' => $currceny,
            'affily' => $affily,
            'bnum' => $bnum,
            'pnum' => $pnum,
            'v' => 2
        );

        $kiwi = new ApiClient();
        $kiwi_booking = $kiwi->sendRequest('GET', 'search', $parm);
        $check = json_decode($kiwi_booking);

        if(!empty($kiwi_booking)){

            $pass = '[
   {
        "birthday": "1995-09-03",
        "category": "adult",
        "cardno": "N12345678",
        "expiration": "2030-12-03",
        "email": "test.test@kiwi.com",
        "name": "test",
        "surname": "test",
        "nationality": "ES",
        "phone": "+77778887788",
        "title": "mr"
      }
  ]';
            $savebookinparm =  array(
                'endpoint' => 'https://tequila-api.kiwi.com/v2/booking/save_booking',
                'lang' =>'en',
                'currency' =>"USD",
                'passengers' => $pass,
                'session_id' => $check->session_id,
                'booking_token' => $check->booking_token,

            );
dd($savebookinparm);
            $kiwi = new ApiClient();
            $kiwi_save_booking = $kiwi->sendRequest('POST', 'search', $savebookinparm);
            dd($kiwi_save_booking);
        }

    }
}