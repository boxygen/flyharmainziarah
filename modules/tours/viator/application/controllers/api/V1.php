<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ApiClient');
        $this->output->set_content_type('application/json');
        $this->load->model('V1_model');
    }

    public function search_post(){
        $uri = $this->post();

        $destination = $this->V1_model->get_destination($this->post("loaction"));
        $url = "https://api.viator.com/partner/products/search";
        $payload = array(
            "filtering"=>array(
                "destination"=>$destination,
                "tags"=>[
                21972
                ],
                "flags"=>[
                "FREE_CANCELLATION"
                ],
                "highestPrice"=>500,
                "startDate"=>date("Y-m-d", strtotime($uri['checkin'])),
                "endDate"=>date('Y-m-d', strtotime($uri['checkin']. ' + 2 days')),
            ),
            "sorting"=>array(
                "sort"=>"PRICE",
                "order"=>"DESCENDING",
            ),
            "pagination"=>array(
                "start"=>1,
                "count"=>50,
            ),
            "currency"=>$uri['currency'],
        );
        $headers  = array("Content-Type:application/json","exp-api-key:".$uri['c1'],"Accept:application/json;version=2.0","Accept-Language:en-US");
        $viator = new ApiClient();
        $response = $viator->curl_call('post',$url,json_encode($payload),$headers);
        $results = json_decode($response);
        $array = [];

        foreach ($results->products as $key => $value){
                    $array[] = (object)[
                        'tour_id' => $value->productCode,
                        'name' => $value->title,
                        'location' => $this->post("loaction"),
                        'img' => $value->images[0]->variants[2]->url,
                        'desc' => $value->description,
                        'price' => round($value->pricing->summary->fromPrice),
                        'actual_price' => round($value->pricing->summary->fromPrice),
                        'duration' => '',
                        'rating' => round($value->reviews->combinedAverageRating),
                        'redirected' => '',
                        'latitude' => '',
                        'longitude' => '',
                        'currency_code' => $value->pricing->currency
                    ];
                }
        $this->response( $array,  200);
    }

    public function detail_post()
    {
        $data = $this->post();
        $url = "https://api.viator.com/partner/products/".$data['tour_id'];
        $getPayload = array("tour_id" => $data['tour_id']);
        $headers  = array("Content-Type:application/json","exp-api-key:".$data['c1'],"Accept:application/json;version=2.0","Accept-Language:en-US");
        $viat = new ApiClient();
        $detailResponse = $viat->curl_call('get', $url, $getPayload, $headers);
        $details = json_decode($detailResponse);

            $img = [];
            foreach ($details->images as $photo) {
                $img[] = $photo->variants[11]->url;
            }
        $inclusions = [];
        foreach ($details->inclusions as $inclusion) {
            if(!empty($inclusion->otherDescription)) {
                $inclusions[] = $inclusion->otherDescription;
            }
        }
        $exclusions = [];
        foreach ($details->exclusions as $exclusion) {
            if(!empty($exclusion->otherDescription)) {
                $exclusions[] = $exclusion->otherDescription;
            }
        }
            $array = array(
                'tour_id' => $details->productCode,
                'name' => $details->title,
                'tour_type' => '',
                'location' => '',
                'img' => $img,
                'desc' => $details->description,
                'price' => 0,
                'actual_price' => 0,
                'adult_price' => 0,
                'child_price' => 0,
                'infant_price' => 0,
                'maxAdults' => '',
                'maxChild' => '',
                'maxInfant' => '',
                'rating' => $details->reviews->sources[0]->averageRating,
                'longitude' => '',
                'latitude' => '',
                'redirect' => $details->productUrl,
                'inclusions' => $inclusions,
                'exclusions' =>$exclusions,
                'currencycode' =>  $data['currency'],
                'duration' => '',
                'policy' => '',
                'max_travellers' => $details->bookingRequirements->maxTravelersPerBooking,
                'departure_time' => '',
                'departure_point' => '',
            );
            $this->response($array, 200);
            //  $this->response(array('response' => $detail, 'error' => array('status' => False,'msg' => 'Success')), 200);
    }
////        else{
////            $this->response(array('response' => $details, 'error' => array('status' => True,'msg' => 'Record not found')), 200);
////
////        }
//    }
}