<?php

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';
class Flight extends REST_Controller {
    
    function __construct() {
        // Construct our parent class
        parent :: __construct();
        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->output->set_content_type('application/json');
        $this->load->library('ApiClient');
        $this->load->library('Flights/Flights_lib');
        $this->load->model('Admin/Modules_model');
        $this->load->model('Flights/Flights_model');
       header('Content-type: application/json');

    }

    public function search_post(){
        //Manaul Flights API Api
        $Flights = $this->App->service('ModuleService')->isActive("Flights");
        if ($this->post('type') == 'return') {
            $checktrip = 'round';
        }else{
            $checktrip = 'oneway';
        }
        $curr_code = $this->Flights_lib->currencycode;
        if(!empty($this->post('currency'))){
            $currency = $this->post('currency');
        }else{
            $currency = $curr_code;
        }

        if ($checktrip == 'round' ) {
            $returndate = $this->post('return_date');
            $adults = intval($this->post('adults') ? $this->post('adults') : 1);
            $childrens = intval($this->post('childrens') ? $this->post('childrens') : 0);
            $infants =  intval($this->post('infants') ? $this->post('infants') : 0);
        } else {
            $returndate = "";
            $adults = intval($this->post('adults') ? $this->post('adults') : 1);
            $childrens = intval($this->post('childrens') ? $this->post('childrens') : 0);
            $infants =  intval($this->post('infants') ? $this->post('infants') : 0);
        }
        if ($this->post('class_type') == 'economy') {
            $class = "economy";
        } else if ($this->post('class_type') == 'business') {
            $class = "business";
        } else {
            $class = "Y";
        }

        if($Flights == 1) {
            $origin =  ($this->post('origin')) ? strtoupper($this->post('origin')) : "";
            $destination = ($this->post('destination')) ? strtoupper($this->post('destination')) : "";
            $type = $checktrip ? $checktrip : 'oneway';
            $departure_date = date('Y-m-d', strtotime($this->post('departure_date')));
            $return_date = $returndate;
            $class_trip = $class;

            $paylod = $this->post();
            $this->Flights_lib->search_logs($paylod);


            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  site_url().'/api/new_flights/search?appKey='.$this->input->get('appKey').'&from='.$origin.'&to='.$destination.'&departure_date='.$departure_date.'&arrival_date='.$return_date.'&type='.$type.'&cabinclass='.$class_trip.'&adults='.$adults.'&childs='.$childrens.'&infants='.$infants.'&currency='.$currency,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: ci_session=4dd34e644b9cf60f6b6dd035da89da1f5215fc9c'
                )
            ));
            
            $res = curl_exec($curl);
            $rep = json_decode($res);
            curl_close($curl);
            
            
        }

        // Multithreading Flights Search Api's
        $Multithreading = $this->App->service('ModuleService')->flightmodules();
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        if($_SERVER['HTTP_HOST'] == 'localhost')
        {
            $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'].'/'.$uri[1];
        } else {
            $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
        }
        $array = array();
       foreach ($Multithreading as $key=>$value){
          $getvalue = $this->Modules_model->getmodulename($value['name']);
           $b2c_markup =  $getvalue[0]->b2c_markup;
           $b2b_markup =  $getvalue[0]->b2b_markup;
           $b2e_markup =  $getvalue[0]->b2e_markup;
           $servicefee =  $getvalue[0]->servicefee;
           $desposit =  $getvalue[0]->desposit;
           $module_currency =  $getvalue[0]->module_currency;
           $color =  $getvalue[0]->color;
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
                'evn' => $evn,
                'origin' => ($this->post('origin')) ? strtoupper($this->post('origin')) : "",
                'destination' => ($this->post('destination')) ? strtoupper($this->post('destination')) : "",
                'triptypename' => $this->post('triptypename') ? $this->post('triptypename') : 'oneway',
                'departure_date' => $this->post('departure_date'),
                'return_date' => $returndate,
                'adults' => $adults,
                'childrens' => $childrens,
                'infants' => $infants,
                'endpoint' => $root."/modules/flights/".strtolower($value['name'])."/api/v1/search",
                'class_trip' => $class,
                "currency" => $module_currency,
                "user_ip" => $this->post('ip'),
                "type" => $checktrip,
                "api_mode" => $getvalue[0]->payment_mode,
            );

            $fligts = new ApiClient();
            $response = $fligts->sendRequest('POST', 'search', $param);
            $fligt_rep = json_decode($response);

            // var_dump($fligt_rep[0]->msg);exit();
            // exit();
            if($fligt_rep[0]->msg !== 'no_result'){
                $arr_rep = [];
                
                foreach ($fligt_rep as $data_rep){
                    $return_rep["segments"] = array();
                    foreach ($data_rep->segments as $seg_rep ) {
                        $one_array_rep = array();
                        $segments_rep["segments"] = array();
                        foreach ($seg_rep as $segment_rep) {
    
                            // Price Conversion
                            $current_currency_price = $this->Flights_model->currencyrate($segment_rep->currency_code);
    
                            $con_rate = $this->Flights_model->currencyrate($currency);
    
                            if(!empty($segment_rep->price) && !empty($current_currency_price)) {
                                $price_get = ceil(str_replace(',','',$segment_rep->price) / $current_currency_price);
                            }else{
                                $price_get = 0;
                            }
    
                           if(!empty($segment_rep->adult_price) && !empty($current_currency_price)) {
                               $adult_price = ceil(str_replace(',','',$segment_rep->adult_price) / $current_currency_price);
                           }else{
                               $adult_price = 0;
                           }
    
                           if(!empty($segment_rep->child_price) && !empty($current_currency_price)) {
                               $child_price = ceil(str_replace(',','',$segment_rep->child_price) / $current_currency_price);
                           }else{
                               $child_price = 0;
                           }
    
                           if(!empty($segment_rep->infant_price) && !empty($current_currency_price)) {
                               $infant_price = ceil(str_replace(',','',$segment_rep->infant_price) / $current_currency_price);
                           }else{
                               $infant_price = 0;
                           }
    
                           $price = $price_get * $con_rate;
                           $a_price = $adult_price * $con_rate;
                           $c_price = $child_price * $con_rate;
                           $i_price = $infant_price * $con_rate;
    
                           //Adult Price
                           //$a_price = (int)str_replace(',', '', $segment_rep->adult_price);
                           $adult_price_b2c = ($b2c_markup / 100) * $a_price;
                           $adult_price_b2b = ($b2b_markup / 100) * $a_price;
                           $adult_price_b2e = ($b2e_markup / 100) * $a_price;
    
                           //Chlid Price
                           //$c_price = (int)str_replace(',', '', $segment_rep->child_price);
                           $child_price_b2c = ($b2c_markup / 100) * $c_price;
                           $child_price_b2b = ($b2b_markup / 100) * $c_price;
                           $child_price_b2e = ($b2e_markup / 100) * $c_price;
    
    
                           //Infnat Price
                           //$i_price = (int)str_replace(',', '', $segment_rep->infant_price);
                           $infant_price_b2c = ($b2c_markup / 100) * $i_price;
                           $infant_price_b2b = ($b2b_markup / 100) * $i_price;
                           $infant_price_b2e = ($b2e_markup / 100) * $i_price;
    
                           $b2c_price = ($b2c_markup / 100) * str_replace(',', '', $price);
                           $b2b_price = ($b2b_markup / 100) * str_replace(',', '', $price);
                           $b2e_price = ($b2e_markup / 100) * str_replace(',', '', $price);
    
                           $bj_rep = (object)[
                               "departure_flight_no" => $segment_rep->departure_flight_no,
                               "img" => $segment_rep->img,
                               "departure_time" => $segment_rep->departure_time,
                               "departure_date" => $segment_rep->departure_date,
                               "arrival_time" => $segment_rep->arrival_time,
                               "arrival_date" => $segment_rep->arrival_date,
                               "departure_code" => $segment_rep->departure_code,
                               "departure_airport" => $segment_rep->departure_airport,
                               "arrival_code" => $segment_rep->arrival_code,
                               "arrival_airport" => $segment_rep->arrival_airport,
                               "duration_time" => $segment_rep->duration_time,
                               "currency_code" => $segment_rep->currency_code,
                               "price" => $price,
                               'actual_price' => $segment_rep->price,
                               'b2c_price' => ($price + $b2c_price),
                               'b2b_price' => ($price + $b2b_price),
                               'b2e_price' =>  ($price+ $b2e_price),
                               'b2c_markup' => $b2c_markup,
                               'b2b_markup' =>  $b2b_markup,
                               'b2e_markup' => $b2e_markup,
                               'service_fee' => $servicefee,
                               'desposit' => $desposit,
                               "adult_price_b2b"=>($a_price+ $adult_price_b2b),
                               "adult_price_b2c"=>($a_price + $adult_price_b2c),
                               "adult_price_b2e"=>($a_price + $adult_price_b2e),
                               "child_price_b2b"=>($c_price + $child_price_b2b),
                               "child_price_b2c"=>($c_price + $child_price_b2c),
                               "child_price_b2e"=>($c_price + $child_price_b2e),
                               "infant_price_b2b"=>($i_price + $infant_price_b2b),
                               "infant_price_b2c"=>($i_price + $infant_price_b2c),
                               "infant_price_b2e"=>($i_price + $infant_price_b2e),
                               "adult_price" => $segment_rep->adult_price,
                               "child_price" => $segment_rep->child_price,
                               "infant_price" => $segment_rep->infant_price,
                               "url" => $segment_rep->url,
                               "redirect" => $segment_rep->redirect,
                               "airline_name" => $segment_rep->airline_name,
                               "class_type" => $segment_rep->class_type,
                               "form" => $segment_rep->form,
                               "form_name" => $segment_rep->form_name,
                               "action" => $segment_rep->action,
                               "type" => $segment_rep->type,
                               "supplier" => strtolower($value['name']),
                               "supplier_id" => $getvalue[0]->id,
                               'module_color' => $color,
                               "luggage" => $segment_rep->luggage,
                               "desc" => $segment_rep->desc,
                               "booking_token" => $segment_rep->booking_token,
                               "refundable" => $segment_rep->refundable,
                           ];
                           array_push($one_array_rep, $bj_rep);
                       }
                       if($checktrip == 'round'){
                           $return_rep["segments"][] = $one_array_rep;
                        }else{
                            $segments_rep["segments"][] = $one_array_rep;
                        }
                    }
                    if($checktrip == 'round') {
                        array_push($arr_rep, $return_rep);
                    }else{
                        array_push($arr_rep, $segments_rep);
                    }
                }
                array_push($array,$arr_rep);
            }
        }
        $json = $array;
        $arr = [];
        foreach ($json as $value){
            foreach ($value as $data){
                $return["segments"] = array();
                foreach ($data['segments'] as $seg ) {
                    $one_array = array();
                    $segments["segments"] = array();
                    foreach ($seg as $segment) {
                        
                        // Price Conversion
                        $current_currency_price_x = $this->Flights_model->currencyrate($segment->currency_code);
                        $con_rate_x = $this->Flights_model->currencyrate($currency);
                        
                        if(!empty($segment->price) && !empty($current_currency_price_x)) {
                            $price_get = ceil($segment->price / $current_currency_price_x);
                        }else{
                            $price_get = 0;
                        }
                        
                        $price = $price_get * $con_rate_x; // $segment->price
                        
                        
                        $bj = (object)[
                            "departure_flight_no" => $segment->departure_flight_no,
                            "img" => $segment->img,
                            "departure_time" => $segment->departure_time,
                            "departure_date" => $segment->departure_date,
                            "arrival_time" => $segment->arrival_time,
                            "arrival_date" => $segment->arrival_date,
                            "departure_code" => $segment->departure_code,
                            "departure_airport" => $segment->departure_airport,
                            "arrival_code" => $segment->arrival_code,
                            "arrival_airport" => $segment->arrival_airport,
                            "duration_time" => $segment->duration_time,
                            "currency_code" => $segment->currency_code,
                            "price" => $price,
                            'actual_price' =>$segment->actual_price,
                            'b2c_price' =>$segment->b2c_price,
                            'b2b_price' => $segment->b2b_price,
                            'b2e_price' =>  $segment->b2e_price,
                            'b2c_markup' => $segment->b2c_markup,
                            'b2b_markup' =>  $segment->b2b_markup,
                            'b2e_markup' => $segment->b2e_markup,
                            'service_fee' => $segment->service_fee,
                            'desposit' => $segment->desposit,
                            "adult_price_b2b"=>$segment->adult_price_b2b,
                            "adult_price_b2c"=>$segment->adult_price_b2c,
                            "adult_price_b2e"=>$segment->adult_price_b2e,
                            "child_price_b2b"=>$segment->child_price_b2b,
                            "child_price_b2c"=>$segment->child_price_b2c,
                            "child_price_b2e"=>$segment->child_price_b2e,
                            "infant_price_b2b"=>$segment->infant_price_b2b,
                            "infant_price_b2c"=>$segment->infant_price_b2c,
                            "infant_price_b2e"=>$segment->infant_price_b2e,
                            "adult_price" => $segment->adult_price,
                            "child_price" => $segment->child_price,
                            "infant_price" => $segment->infant_price,
                            "url" => $segment->url,
                            "redirect" => $segment->redirect,
                            "airline_name" => $segment->airline_name,
                            "class_type" => $segment->class_type,
                            "form" => $segment->form,
                            "form_name" => $segment->form_name,
                            "action" => $segment->action,
                            "type" => $segment->type,
                            "supplier" => $segment->supplier,
                            "module_color" => $segment->module_color,
                            "supplier_id" => $segment->supplier_id,
                            "luggage" => $segment->luggage,
                            "desc" => $segment->desc,
                            "booking_token" => $segment->booking_token,
                            "refundable" => $segment->refundable,
                        ];
                        array_push($one_array, $bj);
                    }
                    if($checktrip == 'round'){
                        $return["segments"][] = $one_array;
                    }else{
                        $segments["segments"][] = $one_array;
                    }
                }
                if($checktrip == 'round') {
                    array_push($arr, $return);
                }else{
                    array_push($arr, $segments);
                }
            }
        }

        if(!empty($arr[0]['segments']) && !empty($rep)){
            $data = array_merge($rep,$arr);
        }elseif (!empty($arr[0]['segments'])){
            $data = $arr;
        }elseif (!empty($rep)){
            $data = $rep;
        }else{
            $data = '';
        }
        
        $this->response($data);
    }

    function book_post()
    {
        $token = $this->post('token');
        if (!empty($token) && $token == 'SABSEPOWERFULLANDSECURECODESIGNUPKAYLIYE') {
            $param = array(
                'flight_id' => $this->post('flight_id'),
                'total_price' => $this->post('total_price'),
                'firstname' => $this->post('firstname'),
                'lastname' => $this->post('lastname'),
                'email' => $this->post('email'),
                'address' => $this->post('address'),
                'phone' => $this->post('phone'),
                'flight_type' => $this->post('flight_type'),
                'booking_adults' => $this->post('adults'),
                'booking_childs' => $this->post('childs'),
                'booking_infants' => $this->post('infants'),
                'booking_deposit' => $this->post('deposit'),
                'booking_tax' => $this->post('tax'),
                'booking_curr_code' => $this->post('curr_code'),
                'tax_type' => $this->post('tax_type'),
                'deposit_type' => $this->post('deposit_type'),
                'booking_supplier' => $this->post('supplier'),
                'booking_payment_gateway' => $this->post('payment_gateway'),
                'booking_user_id' => $this->post('user_id'),
                'flights_data' => $this->post('flights_data'),
                'endpoint' => site_url() . "/api/flights/flightbooking?appKey=" . $this->input->get('appKey'),
                'booking_key' => $this->post('booking_key'),
                'guest' => $this->post('guest'),
                'supplier_name' => $this->post('supplier_name'),
                'nationality' => $this->post('nationality'),
                'booking_from' => $this->post('booking_from'),
            );
            // $this->response($param); exit;

            $flights = new ApiClient();
            $book = $flights->sendRequest('POST', 'search', $param);
            if (!empty($book)) {
                $checkbooking = json_decode($book);
                $site_url = $this->post('invoice_url') . $checkbooking->response->sessid . "/" . $checkbooking->response->id;
                $this->Flights_lib->invoceurlupdate($checkbooking->response->id, $site_url);
                $bookingResult = array('response' => true, 'id' => $checkbooking->response->id, 'sessid' => $checkbooking->response->sessid);
                $this->response($bookingResult);
            }
        }
    }


    function invoice_get(){
    $parm = array(
      'booking_id' =>$this->get('booking_id'),
      'invoice_id' =>$this->get('invoice_id'),
      'endpoint' => site_url() . "api/flights/flightinovice?appKey=phptravels",
    );
        $flights = new ApiClient();
        $get_invoice = $flights->sendRequest('POST', 'search', $parm);
        $this->response($get_invoice);
    }

    function invoicebooking_post(){
        $parm = array(
            'id' => $this->post('booking_id'),
            'invoice_id' => $this->post('invoice_id'),
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
            'endpoint' => site_url()."/api/flights/invoicebooking?appKey=".$this->input->get('appKey'),
        );
        $flights = new ApiClient();
        $bookinvoice = $flights->sendRequest('POST', 'search', $parm);
        $this->response($bookinvoice);
    }

    function cancellation_post(){
        $parm = array(
            'id' => $this->post('booking_id'),
            'invoice_id' => $this->post('invoice_id'),
            'booking_cancellation_request' => $this->post('cancellation_request'),
            'endpoint' => site_url()."/api/flights/cancellationbooking?appKey=".$this->input->get('appKey'),
        );
        $flights = new ApiClient();
        $cancelbook = $flights->sendRequest('POST', 'search', $parm);
        $this->response($cancelbook);
    }
 
/*flight booking*/
function booking_post(){
    $booking_id = $this->input->post('booking_id');
    $check = $this->Flights_lib->get_booking($booking_id);
      if(!empty($check)){
             $getvalue = $this->Modules_model->getmodule_id($check->booking_supplier);
             $module_name = strtolower($getvalue[0]->name);
             $hit_url = substr(site_url(), 0, -4);
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $hit_url."/modules/flights/".$module_name."/api/v1/booking",
            // CURLOPT_URL => "https://travelapi.co/modules/flights/".$module_name."/api/v1/booking",
            // CURLOPT_URL => "https://etravelplus.net/modules/flights/".$module_name."/api/v1/booking",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 40,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array(
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
                'data' => json_encode($check)
            ),
              CURLOPT_HTTPHEADER => array(
                'Cookie: ci_session=hm7ie4t83ne1ulp5srqvksgjbsrgrvcs'
              ),
            ));


            $bookingResult = curl_exec($curl);

            $abc['curl_error'] = curl_error($curl);
            $abc['curl_error_number'] = curl_errno($curl);
            $abc['http_code'] = curl_getinfo($curl,CURLINFO_HTTP_CODE);
            $abc['res'] = $bookingResult;
            $booking_pnr = json_decode($bookingResult)->booking_pnr;
            // echo "<pre>";
            // print_r($bookingResult);
            // exit();
        // $this->response($bookingResult);
             if(!empty($bookingResult)){
             $store = $this->Flights_lib->response_booking($booking_id,$bookingResult,$booking_pnr);
                 $this->response(array('status' => true,'invoice_url' => $store[0]->invoice_url, 'ccc' => $bookingResult, 'x' => site_url()), 200);
             }else{
                //  $this->response(array('status' => false,'msg' => 'something is worng please check your request'.$bookingResult), 200);
                 $this->response(array('status' => false,'msg' => $abc ), 200);
             }  
         }else{
             $this->response(array('status' => false,'msg' => 'Record not found'), 200);
         }
    }

}