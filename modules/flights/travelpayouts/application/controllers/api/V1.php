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


        $orgin = $this->post('origin');
        $destination = $this->post('destination');
        $triptypename = $this->post('type');
        $departureDate =  date('Y-m-d', strtotime($this->post('departure_date')));
        $adult = $this->post('adults');
        $children = $this->post('childrens');
        $infant = $this->post('infants');
        $return_date =  date('Y-m-d', strtotime($this->post('return_date')));
        $class_trip = $this->post('class_trip');
        $marker_id = $this->post('c2');
        $token = $this->post('c1');
        $currceny = $this->post('currency');
        $user_ip = $this->post('user_ip');

        if($triptypename != 'round' ) {
            $sing =md5($token.':'.$currceny.':localhost:en:' .$marker_id. ':' .$adult.':' . $children . ':' . $infant . ':' . $departureDate . ':' . $destination . ':' . $orgin . ':' . $class_trip . ':' . $user_ip);
            $segments = array((object)[
                "origin" => $orgin,
                "destination" => $destination,
                "date" => $departureDate
            ]
            );
        } else{
            $sing =  md5($token.':'.$currceny.':localhost:en:' .$marker_id. ':' .$adult.':' . $children . ':' . $infant . ':' . $departureDate . ':' . $destination . ':' . $orgin . ':' . $return_date. ':' .$orgin. ':' .$destination. ':' . $class_trip . ':' . $user_ip);
            $segments = array((object)[
                "origin"         => $orgin,
                "destination"        => $destination,
                "date"         => $departureDate
            ],
                [
                    "origin"         => $destination,
                    "destination"        => $orgin,
                    "date"         => $return_date
                ]
            );


        }
        $data_array =  array(
            "signature"        => $sing,
            "marker"        => $marker_id,
            "host"        => 'localhost',
            "user_ip"        => $user_ip,
            "currency" => $currceny,
            "locale"        => 'en',
            "trip_class"        => $class_trip,
            "passengers"         => array(
                "adults"         => $adult,
                "children"        => $children,
                "infants"         => $infant
            ),
            "segments"         =>$segments,
            'endpoint' => 'http://api.travelpayouts.com/v1/flight_search',

        );

        $tpflight = new ApiClient();
        $response = $tpflight->sendRequest('POST', 'search', $data_array);
        $data1 = json_decode($response);

        if(!empty($data1)){

            $data_array =  array(
                'endpoint' => 'http://api.travelpayouts.com/v1/flight_search_results',
                'uuid' => $data1->search_id,

            );
            $tpflight = new ApiClient();
            $response = $tpflight->sendRequest('GET', 'search', $data_array);

        }
        $main_array = json_decode($response);

        foreach ($main_array as $item) {

            if(!empty($item->proposals)) {
                foreach ($item->proposals as $fligtdata) {

                    foreach ($fligtdata->terms as $getprice) {

                        $return_array = [];
                        foreach ($fligtdata->segment as $segment) {
                            $sub_array = array();
                            $i = 1;
                            foreach ($segment->flight as $flights) {

                                $arrival_time = $flights->arrival_time;

                                $arrival_date = $flights->arrival_date;
                                $departure_date = $flights->departure_date;
                                $departure_time = $flights->departure_time;
                                $duration = $flights->duration;
                                //$trip_class = $flights->trip_class;
                                //$trip_class = ucfirst($this->post('class_trip'));
                                //$aircraft = $flights->aircraft;
                                $airline_name = $this->tm->get_airline_name($flights->operating_carrier);

                                $departure_code = $flights->departure;
                                $departure_airport = $this->tm->get_airport_name($departure_code);
                                $arrival_code = $flights->arrival;

                                $arrival_airport = $this->tm->get_airport_name($arrival_code);


                                $cur = $currceny;

                                $hours = str_pad(floor($duration /60),2,"0",STR_PAD_LEFT);
                                $mins  = str_pad($duration %60,2,"0",STR_PAD_LEFT);

                                if((int)$hours > 24){
                                    $hours = str_pad($hours %24,2,"0",STR_PAD_LEFT);
                                }

                                $uri = explode('/', $_SERVER['REQUEST_URI']);
                                $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
                                if($_SERVER['HTTP_HOST'] == 'localhost')
                                {
                                    $img_code = $root."/".$uri[1]."/modules/global/resources/flights/airlines/$flights->operating_carrier.png";
                                } else {
                                    $img_code = $root."/modules/global/resources/flights/airlines/$flights->operating_carrier.png";
                                }

                                $get_link = $this->urlgent($data1->search_id,$getprice->url,$marker_id);

                                $sub_array[] = (object)[
                                    "id" => $i,
                                    "flight_id" => '',
                                    'departure_flight_no' => $flights->number,
                                    'img' => $img_code,
                                    'departure_time' => $departure_time,
                                    'departure_date' => date("d-m-Y", strtotime($departure_date)),
                                    'arrival_date' => date("d-m-Y", strtotime($arrival_date)),
                                    'arrival_time' => $arrival_time,
                                    'departure_code' => $departure_code,
                                    'departure_airport' => $departure_airport,
                                    'arrival_code' => $arrival_code,
                                    'arrival_airport' => $arrival_airport,
                                    'duration_time' => $hours . ":" . $mins,
                                    'currency_code' => $cur,
                                    'adult_price' => $getprice->price,
                                    'child_price' => '',
                                    'infant_price' => '',
                                    'price' => $getprice->price,
                                    'url' => '',
                                    'airline_name' => $airline_name->name,
                                    'class_type' => $class_trip,
                                    'luggage' => '',
                                    'type' => '',
                                    'form' => '',
                                    'form_name' => '',
                                    'action' => '',
                                    'supplier' => 'travelpayoutfligts',
                                    "redirect" => $get_link,
                                    "desc" => '',
                                    "booking_token" => '',
                                    "refundable" => '',
                                ];
                                $i++;
                            }
                            $return_array["segments"][] = $sub_array;
                        }
                    }
                    $this->final_array[] = $return_array;
                }

            }

        }

        if(!empty($this->final_array) && $getprice->price !='0') {
            $this->response($this->final_array,200);
        }else{
            $this->search_post();
        }
    }

    public function urlgent($search_id,$url,$marker_id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.travelpayouts.com/v1/flight_searches/'.$search_id.'/clicks/'.$url.'.json?marker='.$marker_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $link_ge = curl_exec($curl);

        curl_close($curl);

        $get_link = json_decode($link_ge);
        return  $get_link->url;
    }
}


