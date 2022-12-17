<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ApiClient');
        $this->load->model('V1_model');

        $this->output->set_content_type('application/json');
    }

    function search_post()
    {
        $data = $this->post();

        $param = array(
            'query' => $data['city'],
            'token' => $data['c1'],
            'limit' => 1,
            'lookFor' => 'both',
            'lang' => 'en',
            'endpoint' => 'http://engine.hotellook.com/api/v2/lookup.json',
        );

        $tphotl = new ApiClient();
        $response = $tphotl->sendRequest('GET', 'search', $param);

        $loc = json_decode($response);
       
        if(!empty($loc->results->locations[0]->iata[0])){

            $checkin =  date("Y-m-d", strtotime($data['checkin']));
            $checkout = date("Y-m-d", strtotime($data['checkout']));

            //Make Signature
            $sing = md5($data['c1'] . ':' . $data['c2'] . ':' . $data['adults'] . ':' . $checkin . ':' .  $checkout . ':' . $data['child_age'] . ':' . $data['childs'] . ':' . $data['user_currency'] . ':' . $data['user_ip'] . ':' . $loc->results->locations[0]->iata[0] . ':' . $data['user_lang'] . ":" . '0');

            $payload = array(
                'iata' =>  $loc->results->locations[0]->iata[0],
                'checkIn' =>  $checkin,
                'checkOut' =>  $checkout,
                'adultsCount' =>  $data['adults'],
                'endpoint' =>  "http://engine.hotellook.com/api/v2/search/start.json",
                'customerIP' =>  $data['user_ip'],
                'childrenCount' =>  $data['childs'],
                'childAge1' =>  $data['child_age'],
                'lang' =>  $data['user_lang'],
                'currency' =>  $data['user_currency'],
                'waitForResult' => 0,
                'marker' => $data['c2'],
                'signature' => $sing,
            );
                $tphotl_list = new ApiClient();
                $response = $tphotl_list->sendRequest('GET', 'search', $payload);

            $search_id = json_decode($response);
            if(!empty($search_id->searchId)){

                //Make Signature
                $sing = md5($data['c1'] . ':' . $data['c2'] . ':' . $data['limit'] . ':0:0:' . $search_id->searchId . ':1:price');

                $list_payload = array(
                    'searchId' => $search_id->searchId,
                    'limit' => $data['limit'],
                    'sortBy' => 'price',
                    'sortAsc' => '1',
                    'roomsCount' => '0',
                    'offset' => '0',
                    'marker' => $data['c2'],
                    'signature' => $sing,
                    'endpoint' => 'http://engine.hotellook.com/api/v2/search/getResult.json',
                );

                $tphotl_list = new ApiClient();
                $response = $tphotl_list->sendRequest('GET', 'search', $list_payload);
                $datachk = json_decode($response);
                if ($datachk->status == 'ok') {
                    $arry = [];
                    $count = 0;
                    foreach ($datachk->result as $getdata) {
                        array_push($arry, (object)[
                            'id' => $count,
                            'hotel_id' => $getdata->id,
                            'name' => $getdata->name,
                            'location' => $getdata->address,
                            'stars' => $getdata->stars,
                            'rating' => $getdata->rating,
                            'latitude' => $getdata->location->lat,
                            'longitude' => $getdata->location->lon,
                            'price' => $getdata->maxPrice,
                            'img' => "https://photo.hotellook.com/image_v2/limit/h".$getdata->id."_0/320/240.auto",
                            'supplier' => "travelpayoutshotels",
                            'redirect' => "",
                        ]);
                        $count++;
                    }
                    $this->response(array('response' => $arry, 'error' => array('status' => False,'msg' => 'Success')), 200);

                }else{
                    $this->search_post();
                }
            }else{
                $this->response(array('response' => '', 'error' => array('status' => True,'msg' => 'Record not found')), 200);
            }
        }else{
            $this->response(array('response' => '', 'error' => array('status' => True,'msg' => 'Record not found')), 200);
        }
    }


    function detail_post()
    {

        $data = $this->post();
        $checkin =  date("Y-m-d", strtotime($data['checkin']));
        $checkout = date("Y-m-d", strtotime($data['checkout']));

        //Make Signature
        $sing = md5($data['c1'] . ':' . $data['c2'] . ':' . $data['adults'] . ':' . $checkin . ':' .  $checkout . ':' . $data['child_age'] . ':' . $data['childs'] . ':' . $data['user_currency'] . ':' . $data['user_ip'] . ':' . $data['hotel_id'] . ':' . $data['user_lang'] . ":" . '0');

        $payload = array(
        'hotelId' =>  $data['hotel_id'],
        'checkIn' =>  $checkin,
        'checkOut' =>  $checkout,
        'adultsCount' =>  $data['adults'],
        'endpoint' =>  "http://engine.hotellook.com/api/v2/search/start.json",
        'customerIP' =>  $data['user_ip'],
        'childrenCount' =>  $data['childs'],
        'childAge1' =>  $data['child_age'],
        'lang' =>  $data['user_lang'],
        'currency' =>  $data['user_currency'],
        'waitForResult' => 0,
        'marker' => $data['c2'],
        'signature' => $sing,
    );
    $tphotl_list = new ApiClient();
    $response = $tphotl_list->sendRequest('GET', 'search', $payload);

    $search_id = json_decode($response);
    if(!empty($search_id->searchId)){

        //Make Signature
        $sing = md5($data['c1'] . ':' . $data['c2'] . ':1:0:0:' . $search_id->searchId . ':1:price');

        $list_payload = array(
            'searchId' => $search_id->searchId,
            'limit' => '1',
            'sortBy' => 'price',
            'sortAsc' => '1',
            'roomsCount' => '0',
            'offset' => '0',
            'marker' => $data['c2'],
            'signature' => $sing,
            'endpoint' => 'http://engine.hotellook.com/api/v2/search/getResult.json',
        );

        $tphotl_list = new ApiClient();
        $response = $tphotl_list->sendRequest('GET', 'search', $list_payload);
        $datachk = json_decode($response);

        if ($datachk->status == 'ok' && !empty($datachk->result)) {
            $img = array();
            for ($x = 0; $x <= $datachk->result[0]->photoCount; $x++) {
                $img[] = "https://photo.hotellook.com/image_v2/limit/h".$datachk->result[0]->id."_".$x."/800/520.auto";
            }

            $amenities = [];
            foreach ($datachk->result[0]->amenities as $am){
                $name = $this->V1_model->amenities($am);
                $amenities[] = $name[0]->a_name;
            }

            $room = [];
            $roomcount = 1;
            foreach ($datachk->result[0]->rooms as $ro){

                if(!empty($ro->options->refundable)){
                    $ref = $ro->options->refundable;
                }else{
                    $ref = '';
                }
                array_push($room, (object)[
                    'id' => $roomcount,
                    'name' => $ro->desc,
                    'price' => $ro->total,
                    'refundable' => $ref,
                    'img' => "https://travelapi.co/global/img/room.jpg",
                    'options' => [
                        'id' => $roomcount,
                        'price' => $ro->total,
                        'quantity' => 5,
                        'adults' => 2,
                        'child' => 0,
                        'bookingurl' => $ro->fullBookingURL,

                    ],
                ]);
                $roomcount++;

            }
            $detail = array(
                'id' => $datachk->result[0]->id,
                'name' => $datachk->result[0]->name,
                'location' => $datachk->result[0]->address,
                'stars' => $datachk->result[0]->stars,
                'rating' => $datachk->result[0]->rating,
                'longitude' => $datachk->result[0]->location->lon,
                'latitude' => $datachk->result[0]->location->lat,
                'price' => $datachk->result[0]->maxPrice,
                'desc' => 'Hotel is located in best area. Boasting a 24-hour front desk, this property also provides guests with a terrace. The in-house restaurant serves Mediterranean cuisine.
All units are fitted with a flat-screen TV with satellite channels, fridge, a kettle, a bath and a wardrobe. All rooms have a private bathroom with free toiletries.
The hotel offers a continental or buffet breakfast.
Guests can make sightseeing and ticketing arrangements at the tour desk, or conduct business at the business center.
The malls hospitals and stores are very near to hotel. The nearest airport is International Airport,
16 mi from the property.
We speak your language!',
                'img' => $img,
                'amenities' => $amenities,
                'supplier' => "travelpayoutshotels",
                'rooms' => $room,
            );
            $this->response(array('response' => $detail, 'error' => array('status' => False,'msg' => 'Success')), 200);
        }else{
            $this->detail_post();
        }
    }else{
        $this->response(array('response' => '', 'error' => array('status' => True,'msg' => 'Record not found')), 200);
    }
    }


//    public function related_post()
//    {
//        $data = $this->post();
//
//        $param = array(
//            'query' => $data['city'],
//            'token' => $data['c1'],
//            'limit' => 1,
//            'lookFor' => 'both',
//            'lang' => 'en',
//            'endpoint' => 'http://engine.hotellook.com/api/v2/lookup.json',
//        );
//
//        $tphotl = new ApiClient();
//        $response = $tphotl->sendRequest('GET', 'search', $param);
//
//        $loc = json_decode($response);
//        if(!empty($loc->results->locations[0]->iata[0])){
//
//            $checkin =  date("Y-m-d", strtotime($data['checkin']));
//            $checkout = date("Y-m-d", strtotime($data['checkout']));
//
//            //Make Signature
//            $sing = md5($data['c1'] . ':' . $data['c2'] . ':' . $data['adults'] . ':' . $checkin . ':' .  $checkout . ':' . $data['child_age'] . ':' . $data['childs'] . ':' . $data['user_currency'] . ':' . $data['user_ip'] . ':' . $loc->results->locations[0]->iata[0] . ':' . $data['user_lang'] . ":" . '0');
//
//            $payload = array(
//                'iata' =>  $loc->results->locations[0]->iata[0],
//                'checkIn' =>  $checkin,
//                'checkOut' =>  $checkout,
//                'adultsCount' =>  $data['adults'],
//                'endpoint' =>  "http://engine.hotellook.com/api/v2/search/start.json",
//                'customerIP' =>  $data['user_ip'],
//                'childrenCount' =>  $data['childs'],
//                'childAge1' =>  $data['child_age'],
//                'lang' =>  $data['user_lang'],
//                'currency' =>  $data['user_currency'],
//                'waitForResult' => 0,
//                'marker' => $data['c2'],
//                'signature' => $sing,
//            );
//            $tphotl_list = new ApiClient();
//            $response = $tphotl_list->sendRequest('GET', 'search', $payload);
//
//            $search_id = json_decode($response);
//            if(!empty($search_id->searchId)){
//
//                //Make Signature
//                $sing = md5($data['c1'] . ':' . $data['c2'] . ':' . $data['limit'] . ':0:0:' . $search_id->searchId . ':1:price');
//
//                $list_payload = array(
//                    'searchId' => $search_id->searchId,
//                    'limit' => $data['limit'],
//                    'sortBy' => 'price',
//                    'sortAsc' => '1',
//                    'roomsCount' => '0',
//                    'offset' => '0',
//                    'marker' => $data['c2'],
//                    'signature' => $sing,
//                    'endpoint' => 'http://engine.hotellook.com/api/v2/search/getResult.json',
//                );
//
//                $tphotl_list = new ApiClient();
//                $response = $tphotl_list->sendRequest('GET', 'search', $list_payload);
//                $datachk = json_decode($response);
//                if ($datachk->status == 'ok') {
//                    $arry = [];
//                    $count = 0;
//                    $i = 1;
//                    foreach ($datachk->result as $getdata) {
//                        array_push($arry, (object)[
//                            'id' => $count,
//                            'hotel_id' => $getdata->id,
//                            'name' => $getdata->name,
//                            'location' => $getdata->address,
//                            'stars' => $getdata->stars,
//                            'rating' => $getdata->rating,
//                            'latitude' => $getdata->location->lat,
//                            'longitude' => $getdata->location->lon,
//                            'price' => $getdata->maxPrice,
//                            'img' => "https://photo.hotellook.com/image_v2/limit/h".$getdata->id."_0/320/240.auto",
//                            'supplier' => "travelpayoutshotels",
//                            'redirect' => "",
//                        ]);
//                        $count++;
//                        if ($i++ == 3) break;
//                    }
//                    $this->response($arry, 200);
//                }else{
//                    $this->related_post();
//                }
//            }else{
//                $this->response(array('response' => '', 'error' => array('status' => True,'msg' => 'Record not found')), 200);
//            }
//        }else{
//            $this->response(array('response' => '', 'error' => array('status' => True,'msg' => 'Record not found')), 200);
//        }
//    }


}
