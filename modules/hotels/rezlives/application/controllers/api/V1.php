<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
ini_set('memory_limit', '-1');
class V1 extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('V1_model');
        $this->load->library('ApiClient');


        $this->output->set_content_type('application/json');
    }



    function search_post()
    {

        $getcode = $this->V1_model->getcode($this->post("city"));
        $param = array(
            'city_code' => $getcode[0]->city_code,
            'country_code' => $getcode[0]->country_code,
            'agentcode' => $this->post('c1'),
            'username' => $this->post('c2'),
            'password' =>$this->post('c3'),
            'arrival_date' => str_replace('-','/',$this->post('checkin')),
            'departure_date' => str_replace('-','/',$this->post('checkout')),
            'guest_nationality' => $this->post('nationality'),
            'adults' => $this->post('adults'),
            'chlids' => $this->post('chlids'),
            'typeroom' => $this->post('rooms'),
            'child_age' => json_decode($this->post('child_age')),
        );
        $rezlive = new ApiClient();
        $reposne = $rezlive->callApi($param);
        $xml = simplexml_load_string($reposne, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmlJson = json_encode($xml);
        $xmlArr = json_decode($xmlJson, 1); // Returns associative array
        $arry = array();
        foreach ($xmlArr['Hotels']['Hotel'] as $index => $item) {

            $arry[] = (object)[
                'hotel_id' => $item['Id'],
                'name' => $item['Name'],
                'location' => '',
                'stars' => str_replace('Stars', '', $item['Rating']),
                'rating' => str_replace('Stars', '', $item['Rating']),
                'latitude' => '',
                'longitude' => '',
                'price' => $item['Price'],
                'actual_price' => $item['Price'],
                'img' => $item['ThumbImages'],
                'currency' => $xmlArr['Currency'],
                'actual_currency' => $xmlArr['Currency'],
                'redirect' => "",
                'city_code' => $getcode[0]->city_code,
                'country_code' => $getcode[0]->country_code,
                'address' => '',
                'discount' => '',
                'amenities' => '',
            ];

        }
        $this->response($arry, 200);
    }



    function detail_post()
    {

        $param = array(
            'hotel_id' => $this->post('hotel_id'),
            'city_code' => $this->post('city_code'),
            'country_code' => $this->post('country_code'),
            'agentcode' => $this->post('c1'),
            'username' => $this->post('c2'),
            'password' =>$this->post('c3'),
            'arrival_date' => str_replace('-','/',$this->post('checkin')),
            'departure_date' => str_replace('-','/',$this->post('checkout')),
            'guest_nationality' => $this->post('nationality'),
            'adults' => $this->post('adults'),
            'chlids' => $this->post('chlids'),
            'typeroom' => $this->post('rooms'),
            'child_age' => json_decode($this->post('child_age')),
        );

        $rezlive = new ApiClient();
        $reposne = $rezlive->getdetail($param);
        $xml = simplexml_load_string($reposne, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmlJson = json_encode($xml);
        $xmlArr = json_decode($xmlJson, 1); // Returns associative array

        $string_parts = explode(",", $xmlArr['Hotels']['HotelAmenities']);
        $amenities = array();
        foreach ($string_parts  as $amenities_name){
            $amenities[] = (object)[
                'icon' => '',
                'name' => $amenities_name,
            ];
        }

        $RoomsAmenities = explode(",", $xmlArr['Hotels']['RoomAmenities']);
        $amenitiesroom = array();
        foreach ($RoomsAmenities  as $roomsamenities){
            $amenitiesroom[] = (object)[
                'icon' => '',
                'name' => $roomsamenities,
            ];
        }

        $reposneget = $rezlive->getdetailid($param);
        $xmldetail = simplexml_load_string($reposneget, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmlJsondetail = json_encode($xmldetail);
        $xmlArrdetail = json_decode($xmlJsondetail, 1); // Returns associative array
        $room = [];
        $roomcount = 1;
        foreach ($xmlArrdetail['Hotels']['Hotel']['RoomDetails']['RoomDetail'] as $ro){


            $paramcancel = array(
                'hotel_id' => $this->post('hotel_id'),
                'city_code' => $this->post('city_code'),
                'country_code' => $this->post('country_code'),
                'agentcode' => $this->post('c1'),
                'username' => $this->post('c2'),
                'password' =>$this->post('c3'),
                'arrival_date' => str_replace('-','/',$this->post('checkin')),
                'departure_date' => str_replace('-','/',$this->post('checkout')),
                'guest_nationality' => $this->post('nationality'),
                'booking_key' => $ro['BookingKey'],
            );

            $roomcancel = new ApiClient();
            $reposnecancel = $roomcancel->roomcancelpolicy($paramcancel);
            $xmlcancel = simplexml_load_string($reposnecancel, 'SimpleXMLElement', LIBXML_NOCDATA);
            $xmlJsoncancel = json_encode($xmlcancel);
            $xmlArrcancel = json_decode($xmlJsoncancel, 1); // Returns associative array



            if(!empty($ro['CancellationPolicy']['TillDate'])){
                $refundable_date = $ro['CancellationPolicy']['TillDate'];
            }else{
                $refundable_date = '';

            }
            $room[] = (object)[
                'id' => $roomcount,
                'name' => $ro['Type'],
                'price' => $ro['TotalRate'],
                'real_price' => $ro['TotalRate'],
                'actual_currency' => $xmlArrdetail['Currency'],
                'currency' => $xmlArrdetail['Currency'],
                'refundable' => $ro['CancellationPolicy']['Refundable'],
                'refundable_date' => $refundable_date,
                'img' => ['https://travelapi.co/modules/global/img/room.jpg'],
                'amenities' => $amenitiesroom,
                'options' => array([
                    'id' => $roomcount,
                    'currCode' => $xmlArrdetail['Currency'],
                    'price' => $ro['TotalRate'],
                    'real_price' => $ro['TotalRate'],
                    'quantity' => 1,
                    'adults' => $ro['Adults'],
                    'child' => $ro['Children'],
                    'children_ages' => $ro['ChildrenAges'],
                    'bookingurl' => '',
                    'bookingKey' => $ro['BookingKey'],
                    'extrabeds_quantity' => '',
                    'extrabed_price' => '',
                    'room_adult_price' => '',
                    'room_child_price' => '',
                    'price_type' => '',
                    'cancellation_info' => $xmlArrcancel['CancellationInformations']['Info'],
                    'room_data' => '',

                ]),
            ];
            $roomcount++;

        }

        if(empty($xmlArr['Hotels']['MainImage'])){
            $img = $xmlArr['Hotels']['MainImage'];
        }else{
            $img = array($xmlArr['Hotels']['MainImage']);
        }

        $detail = array(
            'id' => $xmlArr['Hotels']['HotelId'],
            'name' => $xmlArr['Hotels']['HotelName'],
            'location' =>$xmlArr['Hotels']['HotelAddress'],
            'stars' => $xmlArr['Hotels']['Rating'],
            'rating' => $xmlArr['Hotels']['Rating'],
            'longitude' =>  $xmlArr['Hotels']['Latitude'],
            'latitude' => $xmlArr['Hotels']['Longitude'],
            'desc' =>  $xmlArr['Hotels']['Description'],
            'img' =>  $img,
            'amenities' => $amenities,
            'rooms' => $room,
            'policy' => '',
            'address' => $xmlArr['Hotels']['HotelAddress'],
        );

        $this->response($detail, 200);

    }

    public function booking_post()
    {
        $param = array(
            'hotel_id' => $this->post('hotel_id'),
            'city_code' => $this->post('city_code'),
            'country_code' => $this->post('country_code'),
            'agentcode' => $this->post('c1'),
            'username' => $this->post('c2'),
            'password' =>$this->post('c3'),
            'arrival_date' => str_replace('-','/',$this->post('checkin')),
            'departure_date' => str_replace('-','/',$this->post('checkout')),
            'guest_nationality' => $this->post('nationality'),
            'adults' => $this->post('adults'),
            'chlids' => $this->post('chlids'),
            'typeroom' => $this->post('total_rooms'),
            'booking_key' => $this->post('booking_key'),
            'room_name' => $this->post('room_name'),
            'room_price' => $this->post('room_price'),
            'hotel_name' => $this->post('hotel_name'),
            'guest' => json_decode($this->post('booking_guest_info')),
            'children_ages' => $this->post('children_ages'),
        );
       $rezlive = new ApiClient();
        $reposne = $rezlive->prebooking($param);
        $xml = simplexml_load_string($reposne, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmlJson = json_encode($xml);
        $xmlArr = json_decode($xmlJson, 1); // Returns associative array
        if(!empty($xmlArr['PreBookingRequest']['PreBooking']['RoomDetails']['RoomDetail']['BookingKey'])) {
            $book = array(
                'hotel_id' => $this->post('hotel_id'),
                'city_code' => $this->post('city_code'),
                'country_code' => $this->post('country_code'),
                'agentcode' => $this->post('c1'),
                'username' => $this->post('c2'),
                'password' => $this->post('c3'),
                'arrival_date' => str_replace('-','/',$this->post('checkin')),
                'departure_date' => str_replace('-','/',$this->post('checkout')),
                'guest_nationality' => $this->post('nationality'),
                'adults' => $this->post('adults'),
                'chlids' => $this->post('chlids'),
                'typeroom' => $this->post('total_rooms'),
                'BookingKey' => $xmlArr['PreBookingRequest']['PreBooking']['RoomDetails']['RoomDetail']['BookingKey'],
                'room_name' => $this->post('room_name'),
                'room_price' => $this->post('room_price'),
                'hotel_name' => $this->post('hotel_name'),
                'booking_id' => $this->post('booking_id'),
                'booking_ref_no' => $this->post('booking_ref_no'),
                'searchSessionId' => $xmlArr['PreBookingRequest']['PreBooking']['SearchSessionId'],
                'guest' => json_decode($this->post('booking_guest_info')),
                'children_ages' => $this->post('children_ages'),
            );
            $rezlive = new ApiClient();
            $reposnee = $rezlive->book($book);
            $xmlresponse = simplexml_load_string($reposnee, 'SimpleXMLElement', LIBXML_NOCDATA);
            $xmlJsonresponse = json_encode($xmlresponse);
            $xmlArrresponse = json_decode($xmlJsonresponse, 1); // Returns associative array
            $after_booking = html_entity_decode($xmlArr['PreBookingRequest']['PreBooking']['RoomDetails']['RoomDetail']['TermsAndConditions']);
            $after_booking_policy = strip_tags(html_entity_decode($after_booking));
            $check = array('booking_rep'=>$xmlArrresponse,'TermsAndConditions'=>$after_booking_policy);
            $this->response($check);
        }else{
           $this->response($xmlArr['error']);
        }
    }
}
