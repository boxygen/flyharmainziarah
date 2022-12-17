<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('HotelApiClient');
        $this->load->model('V1_model');

        $this->output->set_content_type('application/json');

    }

    public function search_post()
    {
        $searchForm = (object)$this->post();
        $hotel_id = $this->V1_model->gethotel($this->post("city"));
        $hotelston_list = new HotelApiClient();
        $hotelson = $hotelston_list->getroom($hotel_id,$searchForm);
        $get_hotels = $hotelson->hotel;
        $hotel_store = array();
        foreach ($get_hotels as $key=>$value){
            if(!empty($value->channel->room)){
                if(!empty($value->channel->room->price)) {
                    $price = $value->channel->room->price;
                }else{
                    $price = $value->channel->room[0]->price;
                }
            }
            $hotel_store[] = (object)[
                'hotel_id' =>$value->id,
                'name' => $value->name,
                'location' => '',
                'stars' => '',
                'rating' =>'',
                'latitude' => '',
                'longitude' => '',
                'price' => $price,
                'actual_price' => $price,
                'currency' => '',
                'actual_currency' => '',
                'img' => $this->image(),
                'redirect' => "",
                'city_code' => '',
                'country_code' => '',
                'address' => '',
                'discount' => '',
                'amenities' => '',
            ];
        }
        $this->response( $hotel_store,  200);
    }


    public function detail_post(){
        $searchForm = (object)$this->post();

        $hotelston_list = new HotelApiClient();
        $rep = $hotelston_list->callApi($searchForm->hotel_id,$searchForm);

        $reproom = $hotelston_list->getroom($searchForm->hotel_id,$searchForm);
        $rooms = array();
        foreach ($reproom->hotel->channel->room as $room){

            $ro_ament = [];
            foreach ($rep->hotel->feature as $ro_aem){
                if(!empty($ro_aem->name)) {
                    $ro_ament[] = (object)array("icon" => '', "name" => $ro_aem->name);
                }
            }

            $rooms[] = (object)[
                'id' => $room->id,
                'name' => $room->boardType->name,
                'price' => $room->price,
                'real_price' => $room->price,
                'actual_currency' => '',
                'currency' => '',
                'refundable' => '',
                'refundable_date' => '',
                'img' => [$this->image()],
                'amenities' => $ro_ament,
                'options' => array([
                    'id' => $room->id,
                    'currCode' => '',
                    'price' => $room->price,
                    'real_price' => $room->price,
                    'quantity' => '',
                    'adults' => $searchForm->adults,
                    'child' => $searchForm->chlids,
                    'children_ages' => '',
                    'bookingurl' => '',
                    'extrabeds_quantity' => '',
                    'bookingKey' => '',
                    'extrabed_price' => '',
                    'room_adult_price' => $room->price,
                    'room_child_price' => 0,
                    'price_type' => '',
                    'cancellation_info' => '',
                    'room_data' => [
                        'boardTypeid' => $room->boardType->id,
                        'roomTypeid' => $room->roomType->id,
                        'roomTypename' => $room->roomType->name,
                        'roomId' =>  $room->id,
                    ],
                ]),
            ];
        }


        $image = [];
        foreach ($rep->hotel->image as $img){
            $image[] = $img->url;
        }


        $detail = array(
            'id' => $rep->hotel->id,
            'name' => str_replace('&', '', $rep->hotel->name),
            'location' => $rep->hotel->city->name,
            'stars' => $rep->hotel->starRating,
            'rating' => $rep->hotel->starRating,
            'longitude' =>  '',
            'latitude' => '',
            'desc' => $rep->hotel->descriptions->description[0]->_,
            'img' =>  $image,
            'amenities' => $ro_ament,
            'rooms' => $rooms,
            'policy' => '',
            'address' => $rep->hotel->address->_,
        );

        $this->response( $detail,  200);
    }

    public function booking_post()
    {

        $param = array(
            'hotel_id' => $this->post('hotel_id'),
            'agentcode' => $this->post('c1'),
            'username' => $this->post('c2'),
            'arrival_date' => $this->post('checkin'),
            'departure_date' => $this->post('checkout'),
            'adults' => $this->post('adults'),
            'chlids' => $this->post('chlids'),
            'booking_ref_no' => $this->post('booking_ref_no'),
            'room_data' => json_decode($this->post('room_data')),
            'guest' => json_decode($this->post('booking_guest_info')),
            'children_ages' => $this->post('children_ages'),
            'actual_price' => $this->post('actual_price'),
            'actual_currency' => $this->post('actual_currency'),
        );

        $hotelston_booking = new HotelApiClient();
        $rep = $hotelston_booking->callApibooking($param);
        $check = array('booking_rep'=>$rep,'TermsAndConditions'=>$rep->newAvailability->hotel->channel->room->bookingTerms->bookingRemarks);
        $this->response($check);
    }

    public function image(){
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $img_code = $root . "/" . $uri[1] . "/modules/global/img/room.jpg";
        } else {
            $img_code = $root . "/modules/global/img/room.jpg";
        }
        return $img_code;
    }
}
