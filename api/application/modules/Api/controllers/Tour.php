<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Tour extends REST_Controller {

    function __construct() {
        // Construct our parent class
        parent :: __construct();
        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->output->set_content_type('application/json');
        $this->load->library('ApiClient');
        $this->load->model('Admin/Modules_model');
        $this->load->model('Admin/Locations_model');
        $this->load->library('Tours/Tours_lib');
        $this->load->model('Tours/Tours_model');

    }


    public function geturl(){
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        if($_SERVER['HTTP_HOST'] == 'localhost')
        {
            $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'].'/'.$uri[1];
        } else {
            $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
        }
        return $root;
    }
    //Aggregate Feature
    public function search_post(){
        //Manaul Tour Search API
        $Tours = $this->App->service('ModuleService')->isActive("Tours");
        $manaultour = $this->App->service('ModuleService')->getmodulesdata("Tours");
        $paylod = $this->post();
        $this->Tours_lib->search_logs($paylod);
        $this->load->library('Hotels/Hotels_lib');
        $curr_code = $this->Tours_lib->currencycode;
        if(!empty($this->post('currency'))){
            $currency = $this->post('currency');
        }else{
            $currency = $curr_code;
        }
       if($Tours == 1) {
           $loc_id = $this->Locations_model->getLocationDet(str_replace('-',' ', $this->post('loaction')));
           if (!empty($loc_id)) {
           $param = array(
               'endpoint' => site_url() . 'api/tours/search?appKey=' . $this->input->get('appKey'),
               'city' => $loc_id
           );

           $tours = new ApiClient();
           $response = $tours->sendRequest('POST', 'search', $param);
           $re = json_decode($response);
           $arry = array();

           $b2c_markup = $manaultour[0]->b2c_markup;
           $b2b_markup = $manaultour[0]->b2b_markup;
           $b2e_markup = $manaultour[0]->b2e_markup;
           $servicefee = $manaultour[0]->servicefee;

           foreach ($re->response as $index => $data) {

               $current_currency_price = $this->Tours_model->currencyrate($data->currency_code);
               $con_rate = $this->Tours_model->currencyrate($currency);

               if(!empty($data->price) && !empty($current_currency_price)) {
                $price_convert = str_replace(',','',$data->price);
                $price_get = ceil($price_convert / $current_currency_price);
               }else{
                   $price_get = 0;
               }

               $price = round($price_get * $con_rate);
               $b2c_price = ($b2c_markup / 100) * $price;
               $b2b_price = ($b2b_markup / 100) * $price;
               $b2e_price = ($b2e_markup / 100) * $price;
               $arry[] = (object)[
                   'tour_id' => $data->tour_id,
                   'name' => $data->name,
                   'location' => $data->location,
                   'img' => $data->img,
                   'desc' => strip_tags($data->desc),
                   'price' => $price,
                   'actual_price' => $data->price,
                   'b2c_price' => round($price + $b2c_price),
                   'b2b_price' => round($price + $b2b_price),
                   'b2e_price' => round($price + $b2e_price),
                   'b2c_markup' => $b2c_markup,
                   'b2b_markup' => $b2b_markup,
                   'b2e_markup' => $b2e_markup,
                   'service_fee' => $servicefee,
                   'duration' => $data->duration,
                   'rating' => $data->rating,
                   'redirected' => $data->redirected,
                   'supplier' => 1,
                   'supplier_name' => 'manual',
                   'module_color' => '',
                   'latitude' => $data->latitude,
                   'longitude' => $data->longitude,
                   'currency_code' => $data->currency_code,
                   'currency_convert' => $this->post('currency')

               ];

           }
       }
       }


        // Multithreading Tours Search Api's
        $Multithreading = $this->App->service('ModuleService')->tourmodules();
        $array = array();

        foreach ($Multithreading as $key=>$value){
            $getvalue = $this->Modules_model->getmodulename($value['name']);
            $b2c_markup =  $getvalue[0]->b2c_markup;
            $b2b_markup =  $getvalue[0]->b2b_markup;
            $b2e_markup =  $getvalue[0]->b2e_markup;
            $servicefee =  $getvalue[0]->servicefee;
            $desposit =  $getvalue[0]->desposit;
            $color =  $getvalue[0]->color;
            $module_currency =  $getvalue[0]->module_currency;
            if ($getvalue[0]->developer_mode == 1) { $evn = 'pro'; }else{ $evn = 'dev'; }
            $param = array(
                'c1' => $getvalue[0]->c1,
                'c2' => $getvalue[0]->c2,
                'c3' => $getvalue[0]->c3,
                'c4' => $getvalue[0]->c4,
                'c5' => $getvalue[0]->c5,
                'c6' => $getvalue[0]->c6,
                'c7' => $getvalue[0]->c7,
                'c8' => $getvalue[0]->c8,
                'c9' => $getvalue[0]->c9,
                'c10' => $getvalue[0]->c10,
                'checkin' => ($this->post('checkin')) ? strtoupper($this->post('checkin')) : "",
                'checkout' => ($this->post('checkout')) ? strtoupper($this->post('checkout')) : "",
                'loaction' => ($this->post('loaction')) ? strtoupper($this->post('loaction')) : "",
                'country' => ($this->post('country')) ? strtoupper($this->post('country')) : "",
                'mode' => $evn,
                'currency' => $module_currency,
                'endpoint' =>  $this->geturl()."/modules/tours/".strtolower($value['name'])."/api/v1/search",
            );
            $tours = new ApiClient();
            $response = $tours->sendRequest('POST', 'search', $param);
            $array_aggrate = array();
            $aggrate = json_decode($response);

            foreach ($aggrate as $add_price){
                // Price Conversion
                $current_currency_price = $this->Tours_model->currencyrate($module_currency);
                $con_rate = $this->Tours_model->currencyrate($currency);

                $price_get = ceil($add_price->actual_price / $current_currency_price);


                $price = ceil($price_get * $con_rate);

                $b2c_price = ($b2c_markup / 100) * $price;
                $b2b_price = ($b2b_markup / 100) * $price;
                $b2e_price = ($b2e_markup / 100) * $price;

                $array_aggrate[] = (object)[

                    'tour_id' => $add_price->tour_id,
                    'name' => $add_price->name,
                    'location' => $add_price->location,
                    'img' => $add_price->img,
                    'desc' => strip_tags($add_price->desc),
                    'price' => round($add_price->price),
                    'actual_price' => $add_price->price,
                    'b2c_price' => round($price + $b2c_price),
                    'b2b_price' => round($price + $b2b_price),
                    'b2e_price' => round($price+ $b2e_price),
                    'b2c_markup' => $b2c_markup,
                    'b2b_markup' => $b2b_markup,
                    'b2e_markup' => $b2e_markup,
                    'service_fee' => $servicefee,
                    'duration' => $add_price->duration,
                    'rating' => round($add_price->rating),
                    'redirected' => $add_price->redirected,
                    'supplier' => $getvalue[0]->id,
                    'supplier_name' => strtolower($value['name']),
                    'module_color' => $color,
                    'latitude' => $add_price->latitude,
                    'longitude' => $add_price->longitude,
                    'currency_code' => $add_price->currency_code,
                ];
            }
            array_push($array,$array_aggrate);
        }
        $json = $array;
        $arr = [];
        foreach ($json as $key=>$value){
            foreach ($value as $num=>$data){
                $arr[] = (object)[
                    'tour_id' => $data->tour_id,
                    'name' => $data->name,
                    'location' => $data->location,
                    'img' => $data->img,
                    'desc' => strip_tags($data->desc),
                    'price' => round($data->price),
                    'actual_price' => $data->price,
                    'b2c_price' => $data->b2c_price,
                    'b2b_price' => $data->b2b_price,
                    'b2e_price' => $data->b2e_price,
                    'b2c_markup' => $data->b2c_markup,
                    'b2b_markup' => $data->b2b_markup,
                    'b2e_markup' => $data->b2e_markup,
                    'service_fee' => $data->service_fee,
                    'duration' => $data->duration,
                    'rating' => $data->rating,
                    'redirected' => $data->redirected,
                    'supplier' => $data->supplier,
                    'supplier_name' => $data->supplier_name,
                    'module_color' => $data->module_color,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                    'currency_code' => $data->currency_code,
                     'currency_convert' => '',
                ];
            }
        }
        if(!empty($arr) && !empty($arry)){
            $data = array_merge($arry,$arr);
        }elseif (!empty($arr)){
            $data = $arr;
        }elseif (!empty($arry)){
            $data = $arry;
        }else{
            $data = '';
        }

        $this->response($data);
    }


    function detail_post(){
        if($this->post('supplier') == 1){
            $manaultours = $this->App->service('ModuleService')->getmodulesdata("Tours");
            $param = array(
                'endpoint' => site_url()."api/tours/details?appKey=".$this->input->get('appKey')."&id=".$this->post('tour_id'),
            );
            $tourdet = new ApiClient();
            $manaul = $tourdet->sendRequest('GET', 'search', $param);       
            $manaultour = json_decode($manaul);
            
            $b2c_markup = $manaultours[0]->b2c_markup;
            $b2b_markup = $manaultours[0]->b2b_markup;
            $b2e_markup = $manaultours[0]->b2e_markup;
            $servicefee = $manaultours[0]->servicefee;
            $desposit = $manaultours[0]->desposit;
            $tax = $manaultours[0]->tax;
            $deposit_type = $manaultours[0]->deposit_type;
            $tax_type = $manaultours[0]->tax_type;
            
            
            
            $price = round(str_replace(',','',str_replace(',','',$manaultour->response->tour->perAdultPrice)));
            $b2c_price = ($b2c_markup / 100) * $price;
            $b2b_price = ($b2b_markup / 100) * $price;
            $b2e_price = ($b2e_markup / 100) * $price;
            
            
            
            $price_chlid = round(str_replace(',','',str_replace(',','',$manaultour->response->tour->perChildPrice)));
            $b2c_price_chlid = ($b2c_markup / 100) * $price_chlid;
            $b2b_price_chlid = ($b2b_markup / 100) * $price_chlid;
            $b2e_price_chlid = ($b2e_markup / 100) * $price_chlid;

            $price_infant = round(str_replace(',','',str_replace(',','',$manaultour->response->tour->perInfantPrice)));
            $b2c_price_infant = ($b2c_markup / 100) * $price_infant;
            $b2b_price_infant = ($b2b_markup / 100) * $price_infant;
            $b2e_price_infant = ($b2e_markup / 100) * $price_infant;

            $img = [];
            foreach ($manaultour->response->tour->sliderImages as $photo){
                $img[] = $photo->fullImage;
            }

            $inclusions = [];
            foreach ($manaultour->response->tour->inclusions as $inclusion){
                $inclusions[] = $inclusion->name;
            }

            $exclusions = [];
            foreach ($manaultour->response->tour->exclusions as $exclusion){
                $exclusions[] = $exclusion->name;
            }


            $array = array(
                'tour_id' => $manaultour->response->tour->id,
                'name' => $manaultour->response->tour->title,
                'tour_type' => '',
                'location' => $manaultour->response->tour->location,
                'img' => $img,
                'desc' => $manaultour->response->tour->desc,
                'price' => $price,
                'actual_price' => str_replace(',','',$manaultour->response->tour->perAdultPrice),
                'b2c_price_adult' => round(str_replace(',','',$manaultour->response->tour->perAdultPrice) + $b2c_price),
                'b2b_price_adult' => round(str_replace(',','',$manaultour->response->tour->perAdultPrice) + $b2b_price),
                'b2e_price_adult' => round(str_replace(',','',$manaultour->response->tour->perAdultPrice) + $b2e_price),
                'b2c_price_child' => round($manaultour->response->tour->perChildPrice + $b2c_price_chlid),
                'b2b_price_child' => round($manaultour->response->tour->perChildPrice + $b2b_price_chlid),
                'b2e_price_child' => round($manaultour->response->tour->perChildPrice + $b2e_price_chlid),
                'b2c_price_infant' => round($manaultour->response->tour->perInfantPrice + $b2c_price_infant),
                'b2b_price_infant' => round($manaultour->response->tour->perInfantPrice + $b2b_price_infant),
                'b2e_price_infant' => round($manaultour->response->tour->perInfantPrice + $b2e_price_infant),
                'b2c_markup' => $b2c_markup,
                'b2b_markup' =>  $b2b_markup,
                'b2e_markup' => $b2e_markup,
                'service_fee' => $servicefee,
                'desposit' => $desposit,
                'tax' => $tax,
                'deposit_type' => $deposit_type,
                'tax_type' => $tax_type,
                'adult_price' => str_replace(',','',$manaultour->response->tour->perAdultPrice),
                'child_price' => $manaultour->response->tour->perChildPrice,
                'infant_price' => $manaultour->response->tour->perInfantPrice,
                'maxAdults' => $manaultour->response->tour->maxAdults,
                'maxChild' => $manaultour->response->tour->maxChild,
                'maxInfant' => $manaultour->response->tour->maxInfant,
                'rating' => $manaultour->response->tour->starsCount,
                'longitude' => $manaultour->response->tour->longitude,
                'latitude' => $manaultour->response->tour->latitude,
                'redirect' => '',
                'inclusions' => $inclusions,
                'exclusions' => $exclusions,
                'currencycode' => $manaultour->response->tour->currCode,
                'duration' => '',
                'policy' => $manaultour->response->tour->policy,
                'max_travellers' => '',
                'departure_time' => '',
                'departure_point' => '',
                'supplier' =>$this->post('supplier'),
                'multi_destinations' =>$manaultour->response->tour->multi_destinations
            );
            $this->response($array);
        }

        // Multithreading Hotels Details Api's
        if($this->post('supplier') != 1) {
            $getvalue = $this->Modules_model->getmodule_id($this->post('supplier'));
            $b2c_markup =  $getvalue[0]->b2c_markup;
            $b2b_markup =  $getvalue[0]->b2b_markup;
            $b2e_markup =  $getvalue[0]->b2e_markup;
            $servicefee =  $getvalue[0]->servicefee;
            $param = array(
                'c1' => $getvalue[0]->c1,
                'c2' => $getvalue[0]->c2,
                'c3' => $getvalue[0]->c3,
                'c4' => $getvalue[0]->c4,
                'c5' => $getvalue[0]->c5,
                'c6' => $getvalue[0]->c6,
                'c7' => $getvalue[0]->c7,
                'c8' => $getvalue[0]->c8,
                'c9' => $getvalue[0]->c9,
                'c10' => $getvalue[0]->c10,
                'currency' =>$this->post('currency'),
                'tour_id' => $this->post('tour_id'),
                'endpoint' =>   $this->geturl()."/modules/tours/".strtolower($getvalue[0]->name)."/api/v1/detail",
            );
            $tours = new ApiClient();
            $toursapi = $tours->sendRequest('POST', 'search', $param);
            $rep = json_decode($toursapi);

            $price = $rep->adult_price;
            $b2c_price = ($b2c_markup / 100) * $price;
            $b2b_price = ($b2b_markup / 100) * $price;
            $b2e_price = ($b2e_markup / 100) * $price;

            $price_chlid = $rep->child_price;
            $b2c_price_chlid = ($b2c_markup / 100) * $price_chlid;
            $b2b_price_chlid = ($b2b_markup / 100) * $price_chlid;
            $b2e_price_chlid = ($b2e_markup / 100) * $price_chlid;

            $price_infant =  $rep->infant_price;
            $b2c_price_infant = ($b2c_markup / 100) * $price_infant;
            $b2b_price_infant = ($b2b_markup / 100) * $price_infant;
            $b2e_price_infant = ($b2e_markup / 100) * $price_infant;

            $detail = array(
                'tour_id' => $rep->tour_id,
                'name' =>  $rep->name,
                'tour_type' =>  $rep->name,
                'location' =>  $rep->location,
                'img' =>  $rep->img,
                'desc' =>  $rep->desc,
                'price' =>  $rep->price,
                'actual_price' =>  number_format($rep->actual_price ,2, '.', ''),
                'b2c_price_adult' => number_format($rep->adult_price + $b2c_price,2, '.', ''),
                'b2b_price_adult' => number_format($rep->adult_price + $b2b_price,2, '.', ''),
                'b2e_price_adult' => number_format($rep->adult_price + $b2e_price,2, '.', ''),
                'b2c_price_child' => number_format($rep->child_price + $b2c_price_chlid,2, '.', ''),
                'b2b_price_child' => number_format($rep->child_price + $b2b_price_chlid,2, '.', ''),
                'b2e_price_child' => number_format($rep->child_price + $b2e_price_chlid,2, '.', ''),
                'b2c_price_infant' =>number_format($rep->infant_price + $b2c_price_infant,2, '.', ''),
                'b2b_price_infant' => number_format($rep->infant_price + $b2b_price_infant,2, '.', ''),
                'b2e_price_infant' => number_format($rep->infant_price + $b2e_price_infant,2, '.', ''),
                'b2c_markup' => $b2c_markup,
                'b2b_markup' =>  $b2b_markup,
                'b2e_markup' => $b2e_markup,
                'service_fee' => $servicefee,
                'desposit' => '',
                'tax' => '',
                'deposit_type' => '',
                'tax_type' => '',
                'adult_price' =>number_format($rep->infant_price,2, '.', ''),
                'child_price' => number_format($rep->child_price,2, '.', ''),
                'infant_price' => number_format($rep->infant_price,2, '.', ''),
                'maxAdults' => $rep->maxAdults,
                'maxChild' => $rep->maxChild,
                'maxInfant' => $rep->maxInfant,
                'rating' => $rep->rating,
                'longitude' => $rep->longitude,
                'latitude' => $rep->latitude,
                'redirect' => $rep->redirect,
                'inclusions' => $rep->inclusions,
                'exclusions' => $rep->exclusions,
                'currencycode' => $rep->currencycode,
                'duration' => $rep->duration,
                'policy' => $rep->policy,
                'max_travellers' => $rep->max_travellers,
                'departure_time' => $rep->departure_time,
                'departure_point' => $rep->departure_point,
                'supplier' =>$getvalue[0]->id,
                'multi_destinations' =>''
            );
            $this->response($detail);
        }
    }


    function book_post()
    {
        $token = $this->post('token');
        if (!empty($token) && $token == 'SABSEPOWERFULLANDSECURECODESIGNUPKAYLIYE') {
            $param = array(
                'tour_id' => $this->post('tour_id'),
                'total_price' => $this->post('total_price'),
                'firstname' => $this->post('firstname'),
                'lastname' => $this->post('lastname'),
                'email' => $this->post('email'),
                'address' => $this->post('address'),
                'phone' => $this->post('phone'),
                'booking_checkin' => $this->post('checkin'),
                'booking_adults' => $this->post('adults'),
                'booking_childs' => $this->post('childs'),
                'booking_infants' => $this->post('infants'),
                'booking_deposit' => $this->post('deposit'),
                'booking_tax' => $this->post('tax'),
                'booking_curr_code' => $this->post('curr_code'),
                'tour_name' => $this->post('tour_name'),
                'loaction' => $this->post('loaction'),
                'tour_img' => $this->post('tour_img'),
                'tours_name' => $this->post('tours_name'),
                'booking_supplier' => $this->post('supplier'),
                'booking_payment_gateway' => $this->post('payment_gateway'),
                'booking_user_id' => $this->post('user_id'),
                'latitude' => $this->post('latitude'),
                'longitude' => $this->post('longitude'),
                'endpoint' => site_url() . "/api/tours/tourbooking?appKey=" . $this->input->get('appKey'),
                'guest' => $this->post('guest'),
                'supplier_name' => $this->post('supplier_name'),
                'tour_stars' => $this->post('stars'),
                'booking_from' => $this->post('booking_from'),
                'tour_adult_price' => $this->post('tour_adult_price'),
                'tour_child_price' => $this->post('tour_child_price'),
                'tour_infant_price' => $this->post('tour_infant_price'),
                'redirect' => $this->post('redirect'),
            );
            $tours = new ApiClient();
            $book = $tours->sendRequest('POST', 'search', $param);
            if (!empty($book)) {
                $checkbooking = json_decode($book);
                $site_url = $this->post('invoice_url') . $checkbooking->response->sessid . "/" . $checkbooking->response->id;
                $this->Tours_lib->invoceurlupdate($checkbooking->response->id, $site_url);
                $bookingResult = array('response' => true, 'id' => $checkbooking->response->id, 'sessid' => $checkbooking->response->sessid);
                $this->response($bookingResult);
            }
        }
    }

    function invoice_post(){
        $parm = array(
            'id' => $this->post('booking_id'),
            'ref_id' => $this->post('ref_id'),
            'status' => $this->post('status'),
            'payment_gateway' => $this->post('payment_gateway'),
            'amount_paid' => $this->post('amount_paid'),
            'remaining_amount' => $this->post('remaining_amount'),
            'payment_date' => $this->post('payment_date'),
            'txn_id' => $this->post('txn_id'),
            'token' => $this->post('token'),
            'logs' => $this->post('logs'),
            'payment_status' => $this->post('payment_status'),
            'desc' => $this->post('desc'),
            'endpoint' => site_url()."/api/tours/invoicebooking?appKey=".$this->input->get('appKey'),
        );
        dd($parm);exit();
        $tour = new ApiClient();
        $bookinvoice = $tour->sendRequest('POST', 'search', $parm);
        $this->response($bookinvoice);
    }

    function cancellation_post(){
        $parm = array(
            'id' => $this->post('booking_id'),
            'invoice_id' => $this->post('invoice_id'),
            'booking_cancellation_request' => $this->post('cancellation_request'),
            'endpoint' => site_url()."/api/tours/cancellationbooking?appKey=".$this->input->get('appKey'),
        );
        $flights = new ApiClient();
        $cancelbook = $flights->sendRequest('POST', 'search', $parm);
        $this->response($cancelbook);
    }
    function invoice_get(){
        $parm = array(
            'booking_id' =>$this->get('booking_id'),
            'invoice_id' =>$this->get('invoice_id'),
            'endpoint' => site_url() . "api/tours/tourinovice?appKey=".$this->input->get('appKey'),
        );
        $flights = new ApiClient();
        $get_invoice = $flights->sendRequest('POST', 'search', $parm);
        $this->response($get_invoice);
    }

}