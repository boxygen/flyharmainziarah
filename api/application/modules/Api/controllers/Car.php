<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Car extends REST_Controller {

    function __construct() {
        // Construct our parent class
        parent :: __construct();
        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->output->set_content_type('application/json');
        $this->load->library('ApiClient');
        $this->load->library('Cars/Cars_lib');
        $this->load->library('Cars/Cars_model');
        $this->load->model('Admin/Modules_model');
    }

    //Call Api
    public function apicall($method,$param){
        $car = new ApiClient();
        $response = $car->sendRequest($method, 'search', $param);
        return $response;
    }

    //Aggregate Feature
    public function search_post(){
        //Manaul Car Search API
        $Cars = $this->App->service('ModuleService')->isActive("Cars");
        $manaulcar = $this->App->service('ModuleService')->carmanaulmodules();

        $curr_code = $this->Cars_lib->currencycode;
        if(!empty($this->post('currency'))){
            $currency = $this->post('currency');
        }else{
            $currency = $curr_code;
        }
        if($Cars == 1) {
            $paylod = $this->post();
            $pickuplocations = $this->Cars_lib->getLocationsid($paylod['origin']);
            $dropofflocations = $this->Cars_lib->getLocationsid($paylod['destination']);

            $param = array(
                'endpoint' => site_url().'api/cars/search?appKey='.$this->input->get('appKey').'&pickupLocation='.$pickuplocations[0]->id.'&dropoffLocation='.$dropofflocations[0]->id.'&lang='.$this->post('lang'),
            );

            $manaul = $this->apicall('GET',$param);
            $re = json_decode($manaul);
            $arry = array();
            foreach ($re->response as $index => $item) {

                $current_currency_price = $this->Cars_model->currencyrate($item->currCode);
                $con_rate = $this->Cars_model->currencyrate($currency);

                if(!empty($item->price) && !empty($current_currency_price)) {
                    $price_get = ceil($item->price / $current_currency_price);
                }else{
                    $price_get = 0;
                }

                $b2c_markup = $manaulcar[0]->b2c_markup;
                $b2b_markup = $manaulcar[0]->b2b_markup;
                $b2e_markup = $manaulcar[0]->b2e_markup;
                $servicefee = $manaulcar[0]->servicefee;

                $price = $price_get * $con_rate;

                $b2c_price = ($b2c_markup / 100) * $price;
                $b2b_price = ($b2b_markup / 100) * $price;
                $b2e_price = ($b2e_markup / 100) * $price;

                $checkout = strtotime($this->post('checkout'));
                $checkin = strtotime($this->post('checkin'));
                $nights = $checkout - $checkin;
                $totaldays =  round($nights / (60 * 60 * 24));
               // dd($price + $b2c_price *$totaldays );
                $arry[] = (object)[
                    'id' => $item->id,
                    'title' => $item->title,
                    'thumbnail' => $item->thumbnail,
                    'stars' => $item->starsCount,
                    'location' => $paylod['origin'],
                    'desc' => $item->desc,
                    'doors' => $item->doors,
                    'passengers' => $item->passengers,
                    'transmission' => $item->transmission,
                    'supplier' => 1,
                    'supplier_name' => 'manual',
                    'module_color' => '',
                    'airportPickup' => $item->airportPickup,
                    'baggage' => $item->baggage,
                    'price' => $price,
                    'b2c_price' => round($price + $b2c_price),
                    'b2b_price' => round($price + $b2b_price),
                    'b2e_price' => round($price + $b2e_price),
                    'b2c_markup' => $b2c_markup,
                    'b2b_markup' => $b2b_markup,
                    'b2e_markup' => $b2e_markup,
                    'service_fee' => $servicefee,
                    'currency' => $currency,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'carType' => $item->carType,
                    'redirect' => '',
                ];

            }
        }

        // Multithreading Hotels Search Api's
        $Multithreading = $this->App->service('ModuleService')->carmodules();
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
            $color =  $getvalue[0]->color;
            $module_currency =  $getvalue[0]->module_currency;

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
                'origin' => $this->post('origin'),
                'destination' => $this->post('destination'),
                'adults' => $this->post('adults'),
                'chlids' => $this->post('chlid'),
                'currency' =>$module_currency,
                'endpoint' => $root."/modules/cars/".strtolower($value['name'])."/api/v1/search",
            );
            $response = $this->apicall('POST',$param);
            $array_aggrate = array();
            $aggrate = json_decode($response);
            foreach ($aggrate as $item){
                $current_currency_price = $this->Cars_model->currencyrate($module_currency);
                $con_rate = $this->Cars_model->currencyrate($currency);
                $price_get = ceil($item->price / $current_currency_price);
                $price = ceil($price_get * $con_rate);

                $b2c_price = ($b2c_markup / 100) * $price;
                $b2b_price = ($b2b_markup / 100) * $price;
                $b2e_price = ($b2e_markup / 100) * $price;

                $array_aggrate[] = (object)[
                    'id' => $item->id,
                    'title' => $item->title,
                    'thumbnail' => $item->thumbnail,
                    'stars' => $item->starsCount,
                    'location' => $item->location,
                    'desc' => $item->desc,
                    'doors' => $item->doors,
                    'passengers' => $item->passengers,
                    'transmission' => $item->transmission,
                    'supplier' =>  $getvalue[0]->id,
                    'supplier_name' => strtolower($value['name']),
                    'module_color' => $color,
                    'airportPickup' => $item->airportPickup,
                    'baggage' => $item->baggage,
                    'price' => $price,
                    'b2c_price' => round($price + $b2c_price),
                    'b2b_price' => round($price + $b2b_price),
                    'b2e_price' => round($price + $b2e_price),
                    'b2c_markup' => $b2c_markup,
                    'b2b_markup' => $b2b_markup,
                    'b2e_markup' => $b2e_markup,
                    'service_fee' => $servicefee,
                    'currency' => $currency,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'carType' => $item->carType,
                    'redirect' => $item->redirect,

                ];
            }
            $array[] = $array_aggrate;
        }

        $json = $array;
        $arr = [];
        foreach ($json as $key=>$value){
            foreach ($value as $num=>$data){
                $arr[] = (object)[
                    'id' => $data->id,
                    'title' => $data->title,
                    'thumbnail' => $data->thumbnail,
                    'stars' => $data->starsCount,
                    'location' => $data->location,
                    'desc' => $data->desc,
                    'doors' => $data->doors,
                    'passengers' => $data->passengers,
                    'transmission' => $data->transmission,
                    'supplier' => $data->supplier,
                    'supplier_name' =>  $data->supplier,
                    'module_color' =>  $data->supplier,
                    'airportPickup' => $data->airportPickup,
                    'baggage' => $data->baggage,
                    'price' =>  $data->price,
                    'b2c_price' => $data->b2c_price,
                    'b2b_price' =>  $data->b2b_price,
                    'b2e_price' =>  $data->b2e_price,
                    'b2c_markup' =>  $data->b2c_markup,
                    'b2b_markup' =>  $data->b2b_markup,
                    'b2e_markup' =>  $data->b2e_markup,
                    'service_fee' =>  $data->service_fee,
                    'currency' =>  $data->currency,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                    'carType' => $data->carType,
                    'redirected' => $data->redirect,
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

    function book_post()
    {
        $token = $this->post('token');
        if(!empty($token) && $token == 'SABSEPOWERFULLANDSECURECODESIGNUPKAYLIYE') {
            $param = array(
                'car_id' => $this->post('car_id'),
                'total_price' => $this->post('total_price'),
                'firstname' => $this->post('firstname'),
                'lastname' => $this->post('lastname'),
                'email' => $this->post('email'),
                'address' => $this->post('address'),
                'phone' => $this->post('phone'),
                'car_type' => $this->post('car_type'),
                'booking_adults' => $this->post('adults'),
                'booking_childs' => $this->post('childs'),
                'booking_deposit' => $this->post('deposit'),
                'booking_tax' => $this->post('tax'),
                'booking_curr_code' => $this->post('curr_code'),
                'tax_type' => $this->post('tax_type'),
                'deposit_type' => $this->post('deposit_type'),
                'booking_supplier' => $this->post('supplier'),
                'booking_payment_gateway' => $this->post('payment_gateway'),
                'booking_user_id' => $this->post('user_id'),
                'endpoint' => site_url() . "/api/cars/carbooking?appKey=" . $this->input->get('appKey'),
                'booking_key' => $this->post('booking_key'),
                'guest' => $this->post('guest'),
                'supplier_name' => $this->post('supplier_name'),
                'nationality' => $this->post('nationality'),
                'booking_from' => $this->post('booking_from'),
            );

            $book = $this->apicall('POST', $param);
            if (!empty($book)) {
                $checkbooking = json_decode($book);
                $site_url = $this->post('invoice_url') . $checkbooking->response->sessid . "/" . $checkbooking->response->id;
                $this->Cars_lib->invoceurlupdate($checkbooking->response->id, $site_url);
                $bookingResult = array('response' => true, 'id' => $checkbooking->response->id, 'sessid' => $checkbooking->response->sessid);
                $this->response($bookingResult);
            }
        }
    }

    function invoice_get(){
        $parm = array(
            'booking_id' =>$this->get('booking_id'),
            'invoice_id' =>$this->get('invoice_id'),
            'endpoint' => site_url() . "api/cars/carinovice?appKey=".$this->input->get('appKey'),
        );
        $get_invoice = $this->apicall('POST',$parm);
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
            'endpoint' => site_url()."/api/cars/invoicebooking?appKey=".$this->input->get('appKey'),
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
            'endpoint' => site_url()."/api/cars/cancellationbooking?appKey=".$this->input->get('appKey'),
        );
        $cancelbook = $this->apicall('POST', $parm);
        $this->response($cancelbook);
    }

}

