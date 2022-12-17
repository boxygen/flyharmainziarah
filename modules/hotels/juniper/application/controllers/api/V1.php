<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

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
        $data = $this->post();
        $check = $this->V1_model->getcode($data['city']);
        $arry = array();
        $jhotl = new ApiClient();
        $reposne = $jhotl->callApi($data,$check);
        $count = 0;
        foreach ($reposne->AvailabilityRS->Results->HotelResult as $rep){
            if(empty($reposne->AvailabilityRS->Errors->Error)){
                $reposne_det = $jhotl->getimage($rep->Code,$data);
                //dd($reposne_det->ContentRS->Contents->HotelContent->Images->Image[0]->FileName);
                if(!empty($reposne_det->ContentRS->Contents->HotelContent->Images->Image[0]->FileName)) {
                    array_push($arry, (object)[
                        'id' => $count,
                        'hotel_id' => $rep->Code,
                        'name' => $rep->HotelInfo->Name,
                        'location' => $rep->HotelInfo->Address,
                        'stars' => str_replace('Stars', '', $rep->HotelInfo->HotelCategory->_),
                        'rating' => str_replace('Stars', '', $rep->HotelInfo->HotelCategory->_),
                        'latitude' => $rep->HotelInfo->Latitude,
                        'longitude' => $rep->HotelInfo->Longitude,
                        'price' => round($rep->HotelOptions->HotelOption->Prices->Price->TotalFixAmounts->Service->Amount),
                        'img' => $reposne_det->ContentRS->Contents->HotelContent->Images->Image[0]->FileName,
                        'supplier' => "juniper",
                        'redirect' => "",
                    ]);
                    $count++;
                }


//                array_push($arry, (object)[
//                    'id' => $rep->Code,
//                    'company_name' => $rep->HotelInfo->Name,
//                    'description' => $reposne_det->ContentRS->Contents->HotelContent->Descriptions->Description[0]->_,
//                    'image' => $reposne_det->ContentRS->Contents->HotelContent->Images->Image[0]->FileName,
//                    'city_name' => $rep->HotelInfo->Address,
//                    'rating' => str_replace('Stars','',$rep->HotelInfo->HotelCategory->_),
//                    'price' => $price,
//                    'convarte_price' => '',
//                    'percent' => '',
//                    'actuall_price' => $rep->HotelOptions->HotelOption->Prices->Price->TotalFixAmounts->Service->Amount,
//                    'actuall_curr' => $rep->HotelOptions->HotelOption->Prices->Price->Currency,
//                    'RatePlanCode' => $rep->HotelOptions->HotelOption->RatePlanCode,
//                ]);

            }else{
                $this->response(array('response' => '', 'error' => array('status' => True,'msg' => 'Record not found')), 200);
            }
        }

        $this->response($arry, 200);

    }

}
