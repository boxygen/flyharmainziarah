<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class New_flights extends REST_Controller {
    public $final_array = [];
    private $settings;
    function __construct() {
// Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
// Configure limits on our controller methods. Ensure
// you have created the 'limits' table and enabled 'limits'
// within application/config/rest.php
        $this->methods['list_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
        $this->load->model('Flights/Flights_model');
        $this->load->model('Admin/Modules_model');
        header('Content-type: application/json');
    }


    function search_get() {

        $arrival_date= $this->get('arrival_date');
        $departure_date= $this->get('departure_date');
        $type = $this->get('type');
        $form = $this->get('from');
        $to = $this->get('to');
        $adults = $this->get('adults');
        $childs = $this->get('childs');
        $infants = $this->get('infants');
        $cabinclass = $this->get('cabinclass');
        $currency_code = $this->get('currency');
        $this->load->model('Flights/Flights_model');
        $this->load->library('Flights/Flights_lib');

        $currency = $this->db->select('rate')->where('pt_currencies.code',$currency_code)->get('pt_currencies')->row();
        $currency_int = $currency->rate;
        // dd($currency_int);
       $details = $this->Flights_model->getApiRoutes($arrival_date, $departure_date, $type,$form,$to,$cabinclass,app()->service("ModuleService")->get('flights')->test);
       $details2 = $this->Flights_model->getApiRoutes_return($arrival_date, $departure_date, $type,$form,$to,$cabinclass,app()->service("ModuleService")->get('flights')->test);

       if($type == 'round'){
         if(empty($details) && app()->service("ModuleService")->get('flights')->test == "true")
            {$details = $this->Flights_model->getApiRoutes($arrival_date, $departure_date, $type,$form,$to,$cabinclass,app()->service("ModuleService")->get('flights')->test);

            $details2 = $this->Flights_model->getApiRoutes_return($arrival_date, $departure_date, $type,$form,$to,$cabinclass,app()->service("ModuleService")->get('flights')->test);}
        }else{
       if(empty($details) && app()->service("ModuleService")->get('flights')->test == "true")
          {$details = $this->Flights_model->getApiRoutes($arrival_date, $departure_date, $type,$form,$to,$cabinclass,app()->service("ModuleService")->get('flights')->test);}
        }

        // dd($details);
        if($type == 'round'){
            $typeof = 'return';
        }else{
            $typeof = $type;
        }

$main_array = array();
$object_array = array();
$object_array2 = array();
$obj_Array = array();
$obj_Array2 = array();
$related = array();


    if ($typeof == 'oneway') {
        $test_array = array();
        foreach ($details as $i => $dt ) {
        $get_price = $this->Flights_model->flightprice($dt->id,date('Y-m-d',strtotime($arrival_date)),date('Y-m-d',strtotime($departure_date)),$type);



            $price = ($get_price[0]->adults * $adults) + ($get_price[0]->childs * $childs) + ($get_price[0]->infants * $infants);
          if (($dt->date_departure == "0000-00-00") || (empty($dt->date_departure))) {
                $date_departure = date('Y-m-d');
            } else {
                $date_departure = $dt->date_departure;
            }
            $ob = (object)["code" => $dt->from_code, "label" => $dt->from_location, "date" => $date_departure
                ,"flight_no" => json_decode($dt->flight_no)[0], "time" => $dt->time_departure, "aero_img" => PT_FLIGHTS_AIRLINES . $details[$i]->thumbnail];
            array_push($obj_Array, $ob);
            $transact = json_decode($dt->transact);
            $date_trans = json_decode($dt->date_trans);
            $time_trans = json_decode($dt->time_trans);
            $flight_no = json_decode($dt->flight_no);
            $aero_trans = json_decode($dt->aero_trans);
            for ($index = 0; $index < count($transact); $index++) {
                if (($date_trans[$index] == "0000-00-00") || (empty($date_trans[$index]))) {
                    $date_t = date('Y-m-d', strtotime("+" . ($index + 1) . " day"));
                } else {
                    $date_t = $date_trans[$index];
                }
                $ob = (object)["code" => json_decode($transact[$index])->code, "label" => json_decode($transact[$index])->label, "date" => $date_t
                    , "flight_no" => $flight_no[$index + 1], "time" => $time_trans[$index], "aero_img" => ""];
                array_push($obj_Array, $ob);
            }
            if (($dt->date_arrival == "0000-00-00") || (empty($date_trans[$index]))) {
                $date_arrival = date('Y-m-d', strtotime("+" . (count($date_trans) + 1) . " day"));
            } else {
                $date_arrival = $dt->date_arrival;
            }
            $ob = (object)["code" => $dt->to_code, "label" => $dt->to_location, "date" => $date_arrival
                , "flight_no" => json_decode($dt->flight_no)[0], "time" => $dt->time_arrival, "aero_img" => ""];
            array_push($obj_Array, $ob);




if (!empty($get_price)) {
           for ($h = 0; $h < count($obj_Array)-1; $h +=1) {
               if (!empty(json_decode($dt->flight_no)[0])) {
                   $flight_no = json_decode($dt->flight_no)[0];
               } else {
                   $flight_no = "";
               }


              $hidden_parameters = (object)[
                   'tripType' => $type,
                   'setting_id' => $dt->setting_id,
                   'adults' => $adults,
                   'children' => $childs,
                   'infant' => $infants,
               ];

               $form = $this->hidden_parameters($hidden_parameters);

               $getvalue = $this->Modules_model->getmodulename('Flights');

               $price = ($get_price[0]->adults * $currency_int * $adults) + ($get_price[0]->childs * $currency_int * $childs) + ($get_price[0]->infants * $currency_int * $infants);
               $b2c_markup =  $getvalue[0]->b2c_markup;
               $b2b_markup =  $getvalue[0]->b2b_markup;
               $b2e_markup =  $getvalue[0]->b2e_markup;
               $servicefee =  $getvalue[0]->servicefee;
               $desposit =  $getvalue[0]->desposit;
               $supplier_id =  $getvalue[0]->id;

               //Adult Price
               $adult_price_b2b = ($b2b_markup / 100) * $get_price[0]->adults;
               $adult_price_b2c = ($b2c_markup / 100) * $get_price[0]->adults;
               $adult_price_b2e = ($b2e_markup / 100) * $get_price[0]->adults;

               //Chlid Price
               $child_price_b2b = ($b2b_markup / 100) * $get_price[0]->childs;
               $child_price_b2c = ($b2c_markup / 100) * $get_price[0]->childs;
               $child_price_b2e = ($b2e_markup / 100) * $get_price[0]->childs;


               //Infnat Price
               $infant_price_b2b = ($b2b_markup / 100) * $get_price[0]->infants;
               $infant_price_b2c = ($b2c_markup / 100) * $get_price[0]->infants;
               $infant_price_b2e = ($b2e_markup / 100) * $get_price[0]->infants;

               $b2c_price = ($b2c_markup / 100) * $price;
               $b2b_price = ($b2b_markup / 100) * $price;
               $b2e_price = ($b2e_markup / 100) * $price;

        array_push($test_array, (object)array(
           "departure_flight_no" => $flight_no,
           "img" => PT_FLIGHTS_AIRLINES . $details[$i]->thumbnail,
           "departure_time" => $obj_Array[$h]->time,
           "departure_date" => date('d-m-Y', strtotime($departure_date)),
           "arrival_time" => $obj_Array[$h + 1]->time,
           "arrival_date" => date('d-m-Y', strtotime($departure_date)),
           "departure_code" => $obj_Array[$h]->code,
           "departure_airport" => $obj_Array[$h]->label,
           "arrival_code" => $obj_Array[$h + 1]->code,
           "arrival_airport" => $obj_Array[$h + 1]->label,
           "duration_time" => $details[$i]->total_hours,
           "currency_code" => $this->Flights_lib->currencycode,
           "price" => ($get_price[0]->adults * $currency_int * $adults) + ($get_price[0]->childs * $currency_int * $childs) + ($get_price[0]->infants * $currency_int * $infants),
            'actual_price' =>$price,
            'b2c_price' => number_format($price + $b2c_price,2, '.', ''),
            'b2b_price' => number_format($price + $b2b_price,2, '.', ''),
            'b2e_price' =>  number_format($price + $b2e_price,2, '.', ''),
            'b2c_markup' => $b2c_markup,
            'b2b_markup' =>  $b2b_markup,
            'b2e_markup' => $b2e_markup,
            'service_fee' => $servicefee,
            'desposit' => $desposit,
            "adult_price_b2b"=>number_format($get_price[0]->adults + $adult_price_b2b,2, '.', ''),
            "adult_price_b2c"=>number_format($get_price[0]->adults + $adult_price_b2c,2, '.', ''),
            "adult_price_b2e"=>number_format($get_price[0]->adults + $adult_price_b2e,2, '.', ''),
            "child_price_b2b"=>number_format($get_price[0]->childs + $child_price_b2b,2, '.', ''),
            "child_price_b2c"=>number_format($get_price[0]->childs + $child_price_b2c,2, '.', ''),
            "child_price_b2e"=>number_format($get_price[0]->childs + $child_price_b2e,2, '.', ''),
            "infant_price_b2b"=> number_format($get_price[0]->infants + $infant_price_b2b,2, '.', ''),
            "infant_price_b2c"=> number_format($get_price[0]->infants + $infant_price_b2c,2, '.', ''),
            "infant_price_b2e"=> number_format($get_price[0]->infants + $infant_price_b2e,2, '.', ''),
            "adult_price"=>$get_price[0]->adults,
            "child_price"=>$get_price[0]->childs,
            "infant_price"=>$get_price[0]->infants,
           "url" => '',
           "airline_name" => $details[$i]->name,
           "class_type" => $details[$i]->flight_type,
           "form" => $form,
           "form_name" => '',
           "action" => site_url('flights/book'),
           "desc" => $details[$i]->desc_flight,
           "luggage" => $details[$i]->bagage,
           "refundable" => $details[$i]->refundable,
           "supplier_id" => $supplier_id,
           "supplier" => 'manual',
           "module_color" => '',
        ));
       }

        $obj_Array = array();
        array_push($object_array, $test_array);
        $test_array = [];
        $main_array[]["segments"] = $object_array;
        $object_array = [];
     }



    }
}

    else if ($typeof == 'return') {
        $test_array = array();
        // dd($details);
        foreach ($details as $i => $dt ) {

// $count1 = 0;
// foreach ($details2 as $i2 => $dt2 ) {
//     if ($count1 == 0) {
//     $get_price1 = $this->Flights_model->flightprice($dt2->id,date('Y-m-d',strtotime($arrival_date)),date('Y-m-d',strtotime($departure_date)),$typeof);

//     $price1 = ($get_price1[0]->adults * $adults) + ($get_price1[0]->childs * $childs) + ($get_price1[0]->infants * $infants);
//     $count1++;
//   }}
        $get_price = $this->Flights_model->flightprice($dt->id,date('Y-m-d',strtotime($arrival_date)),date('Y-m-d',strtotime($departure_date)),$type);

          
            $price = ($get_price[0]->adults * $adults) + ($get_price[0]->childs * $childs) + ($get_price[0]->infants * $infants);
        if ($price) {
          if (($dt->date_departure == "0000-00-00") || (empty($dt->date_departure))) {
                $date_departure = date('Y-m-d');
            } else {
                $date_departure = $dt->date_departure;
            }
            $ob = (object)["code" => $dt->from_code, "label" => $dt->from_location, "date" => $date_departure
                ,"flight_no" => json_decode($dt->flight_no)[0], "time" => $dt->time_departure, "aero_img" => PT_FLIGHTS_AIRLINES . $details[$i]->thumbnail];
            array_push($obj_Array, $ob);
            $transact = json_decode($dt->transact);
            $date_trans = json_decode($dt->date_trans);
            $time_trans = json_decode($dt->time_trans);
            $flight_no = json_decode($dt->flight_no);
            $aero_trans = json_decode($dt->aero_trans);
            for ($index = 0; $index < count($transact); $index++) {
                if (($date_trans[$index] == "0000-00-00") || (empty($date_trans[$index]))) {
                    $date_t = date('Y-m-d', strtotime("+" . ($index + 1) . " day"));
                } else {
                    $date_t = $date_trans[$index];
                }
                $ob = (object)["code" => json_decode($transact[$index])->code, "label" => json_decode($transact[$index])->label, "date" => $date_t
                    , "flight_no" => $flight_no[$index + 1], "time" => $time_trans[$index], "aero_img" => ""];
                array_push($obj_Array, $ob);
            } 
            if (($dt->date_arrival == "0000-00-00") || (empty($date_trans[$index]))) {
                $date_arrival = date('Y-m-d', strtotime("+" . (count($date_trans) + 1) . " day"));
            } else {
                $date_arrival = $dt->date_arrival;
            }
            $ob = (object)["code" => $dt->to_code, "label" => $dt->to_location, "date" => $date_arrival
                , "flight_no" => json_decode($dt->flight_no)[0], "time" => $dt->time_arrival, "aero_img" => ""];
            array_push($obj_Array, $ob);





           for ($h = 0; $h < count($obj_Array)-1; $h +=1) {
               if (!empty(json_decode($dt->flight_no)[0])) {
                   $flight_no = json_decode($dt->flight_no)[0];
               } else {
                   $flight_no = "";
               }


              $hidden_parameters = (object)[
                   'tripType' => $type,
                   'setting_id' => $dt->setting_id,
                   'adults' => $adults,
                   'children' => $childs,
                   'infant' => $infants,
               ];

               $form = $this->hidden_parameters($hidden_parameters);

               $getvalue = $this->Modules_model->getmodulename('Flights');

               $price = ($get_price[0]->adults*2 * $currency_int * $adults) + ($get_price[0]->childs*2 * $currency_int * $childs) + ($get_price[0]->infants*2 * $currency_int * $infants);
               $b2c_markup =  $getvalue[0]->b2c_markup;
               $b2b_markup =  $getvalue[0]->b2b_markup;
               $b2e_markup =  $getvalue[0]->b2e_markup;
               $servicefee =  $getvalue[0]->servicefee;
               $desposit =  $getvalue[0]->desposit;

               //Adult Price
               $a_price = $get_price[0]->adults*2;
               $adult_price_b2c = ($b2c_markup / 100) * $get_price[0]->adults*2;
               $adult_price_b2b = ($b2b_markup / 100) * $get_price[0]->adults*2;
               $adult_price_b2e = ($b2e_markup / 100) * $get_price[0]->adults*2;

               //Chlid Price
               $c_price = $get_price[0]->childs*2;
               $child_price_b2c = ($b2c_markup / 100) * $get_price[0]->childs*2;
               $child_price_b2b = ($b2b_markup / 100) * $get_price[0]->childs*2;
               $child_price_b2e = ($b2e_markup / 100) * $get_price[0]->childs*2;


               //Infnat Price
               $i_price = $get_price[0]->infants*2;
               $infant_price_b2c = ($b2c_markup / 100) * $get_price[0]->infants*2;
               $infant_price_b2b = ($b2b_markup / 100) * $get_price[0]->infants*2;
               $infant_price_b2e = ($b2e_markup / 100) * $get_price[0]->infants*2;

               $b2c_price = ($b2c_markup / 100) * $price;
               $b2b_price = ($b2b_markup / 100) * $price;
               $b2e_price = ($b2e_markup / 100) * $price;

        array_push($test_array, (object)array(
           "departure_flight_no" => $flight_no,
           "img" => PT_FLIGHTS_AIRLINES . $details[$i]->thumbnail,
           "departure_time" => $obj_Array[$h]->time,
           "departure_date" => date('d-m-Y', strtotime($departure_date)),
           "arrival_time" => $obj_Array[$h + 1]->time,
           "arrival_date" => date('d-m-Y', strtotime($departure_date)),
           "departure_code" => $obj_Array[$h]->code,
           "departure_airport" => $obj_Array[$h]->label,
           "arrival_code" => $obj_Array[$h + 1]->code,
           "arrival_airport" => $obj_Array[$h + 1]->label,
           "duration_time" => $details[$i]->total_hours,
           "currency_code" => $this->Flights_lib->currencycode,
            "price" => $price,
            'actual_price' =>$price,
            'b2c_price' => number_format($price + $b2c_price,2, '.', ''),
            'b2b_price' => number_format($price + $b2b_price,2, '.', ''),
            'b2e_price' =>  number_format($price + $b2e_price,2, '.', ''),
            'b2c_markup' => $b2c_markup,
            'b2b_markup' =>  $b2b_markup,
            'b2e_markup' => $b2e_markup,
            'service_fee' => $servicefee,
            'desposit' => $desposit,
            "adult_price_b2b"=>number_format($a_price + $adult_price_b2b,2, '.', ''),
            "adult_price_b2c"=>number_format($a_price + $adult_price_b2c,2, '.', ''),
            "adult_price_b2e"=>number_format($a_price + $adult_price_b2e,2, '.', ''),
            "child_price_b2b"=>number_format($c_price + $child_price_b2b,2, '.', ''),
            "child_price_b2c"=>number_format($c_price + $child_price_b2c,2, '.', ''),
            "child_price_b2e"=>number_format($c_price + $child_price_b2e,2, '.', ''),
            "infant_price_b2b"=> number_format($i_price + $infant_price_b2b,2, '.', ''),
            "infant_price_b2c"=> number_format($i_price + $infant_price_b2c,2, '.', ''),
            "infant_price_b2e"=> number_format($i_price + $infant_price_b2e,2, '.', ''),
            "adult_price"=>$a_price,
            "child_price"=>$c_price,
            "infant_price"=>$i_price,
           "url" => '',
           "airline_name" => $details[$i]->name,
           "class_type" => $details[$i]->flight_type,
           "form" => $form,
           "form_name" => '',
           "action" => site_url('flights/book'),
           "desc" => $details[$i]->desc_flight,
           "luggage" => $details[$i]->bagage,
           "supplier_id" => 1,
           "supplier" => 'manual',
            "module_color" => '',
        ));
       }


        $obj_Array = array();
        array_push($object_array, $test_array) ;
        $test_array = [];








 /*related flights start*/
      $related_count = 0;
       foreach ($details2 as $i2 => $dt2 ) {
        $get_price1 = $this->Flights_model->flightprice($dt2->id,date('Y-m-d',strtotime($arrival_date)),date('Y-m-d',strtotime($departure_date)),$typeof);
          $price1 = ($get_price1[0]->adults * $adults) + ($get_price1[0]->childs * $childs) + ($get_price1[0]->infants * $infants);

if ($price1) {
if ($related_count > 0) {


          if (($dt2->date_departure == "0000-00-00") || (empty($dt2->date_departure))) {
                $date_departure = date('Y-m-d');
            } else {
                $date_departure = $dt2->date_departure;
            }
            $ob = (object)["code" => $dt2->from_code, "label" => $dt2->from_location, "date" => $date_departure
                ,"flight_no" => json_decode($dt2->flight_no)[0], "time" => $dt2->time_departure, "aero_img" => PT_FLIGHTS_AIRLINES . $details[$i2]->thumbnail];
            array_push($obj_Array2, $ob);
            $transact = json_decode($dt2->transact);
            $date_trans = json_decode($dt2->date_trans);
            $time_trans = json_decode($dt2->time_trans);
            $flight_no = json_decode($dt2->flight_no);
            $aero_trans = json_decode($dt2->aero_trans);
            for ($index = 0; $index < count($transact); $index++) {
                if (($date_trans[$index] == "0000-00-00") || (empty($date_trans[$index]))) {
                    $date_t = date('Y-m-d', strtotime("+" . ($index + 1) . " day"));
                } else {
                    $date_t = $date_trans[$index];
                }
                $ob = (object)["code" => json_decode($transact[$index])->code, "label" => json_decode($transact[$index])->label, "date" => $date_t
                    , "flight_no" => $flight_no[$index + 1], "time" => $time_trans[$index], "aero_img" => ""];
                array_push($obj_Array2, $ob);
            } 
            if (($dt2->date_arrival == "0000-00-00") || (empty($date_trans[$index]))) {
                $date_arrival = date('Y-m-d', strtotime("+" . (count($date_trans) + 1) . " day"));
            } else {
                $date_arrival = $dt2->date_arrival;
            }
            $ob = (object)["code" => $dt2->to_code, "label" => $dt2->to_location, "date" => $date_arrival
                , "flight_no" => json_decode($dt2->flight_no)[0], "time" => $dt2->time_arrival, "aero_img" => ""];
            array_push($obj_Array2, $ob);
          




           for ($h = 0; $h < 1; $h ++) {
               if (!empty(json_decode($dt2->flight_no)[0])) {
                   $flight_no = json_decode($dt2->flight_no)[0];
               } else {
                   $flight_no = "";
               }


              $hidden_parameters = (object)[
                   'tripType' => $type,
                   'setting_id' => $dt->setting_id,
                   'adults' => $adults,
                   'children' => $childs,
                   'infant' => $infants,
               ];

               $form = $this->hidden_parameters($hidden_parameters);


               $getvalue = $this->Modules_model->getmodulename('Flights');

               $price = ($get_price1[0]->adults * $currency_int * $adults) + ($get_price1[0]->childs * $currency_int * $childs) + ($get_price1[0]->infants * $currency_int * $infants);
               $b2c_markup =  $getvalue[0]->b2c_markup;
               $b2b_markup =  $getvalue[0]->b2b_markup;
               $b2e_markup =  $getvalue[0]->b2e_markup;
               $servicefee =  $getvalue[0]->servicefee;
               $desposit =  $getvalue[0]->desposit;

               //Adult Price
               $adult_price_b2c = ($b2c_markup / 100) * $get_price1[0]->adults;
               $adult_price_b2b = ($b2b_markup / 100) * $get_price1[0]->adults;
               $adult_price_b2e = ($b2e_markup / 100) * $get_price1[0]->adults;

               //Chlid Price
               $child_price_b2c = ($b2c_markup / 100) * $get_price1[0]->childs;
               $child_price_b2b = ($b2b_markup / 100) * $get_price1[0]->childs;
               $child_price_b2e = ($b2e_markup / 100) * $get_price1[0]->childs;


               //Infnat Price
               $infant_price_b2c = ($b2c_markup / 100) * $get_price1[0]->infants;
               $infant_price_b2b = ($b2b_markup / 100) * $get_price1[0]->infants;
               $infant_price_b2e = ($b2e_markup / 100) * $get_price1[0]->infants;

               $b2c_price = ($b2c_markup / 100) * $price;
               $b2b_price = ($b2b_markup / 100) * $price;
               $b2e_price = ($b2e_markup / 100) * $price;
               // dd($obj_Array2);
        array_push($related, (object)array(
           "departure_flight_no" => $flight_no,
           "img" => PT_FLIGHTS_AIRLINES . $details2[$i2]->thumbnail,
           "departure_time" => $obj_Array2[$h]->time,
           "departure_date" => date('d-m-Y', strtotime($departure_date)),
           "arrival_time" => $obj_Array2[$h + 1]->time,
           "arrival_date" => date('d-m-Y', strtotime($departure_date)),
           "departure_code" => $obj_Array2[$h]->code,
           "departure_airport" => $obj_Array2[$h]->label,
           "arrival_code" => $obj_Array2[$h + 1]->code,
           "arrival_airport" => $obj_Array2[$h + 1]->label,
           "duration_time" => $details2[$i2]->total_hours,
           "currency_code" => $this->Flights_lib->currencycode,
           "price" => ($get_price1[0]->adults * $currency_int * $adults) + ($get_price1[0]->childs * $currency_int * $childs) + ($get_price1[0]->infants * $currency_int * $infants),
            'actual_price' =>$price,
            'b2c_price' => number_format($price + $b2c_price,2, '.', ''),
            'b2b_price' => number_format($price + $b2b_price,2, '.', ''),
            'b2e_price' =>  number_format($price + $b2e_price,2, '.', ''),
            'b2c_markup' => $b2c_markup,
            'b2b_markup' =>  $b2b_markup,
            'b2e_markup' => $b2e_markup,
            'service_fee' => $servicefee,
            'desposit' => $desposit,
            "adult_price_b2b"=>number_format($get_price1[0]->adults + $adult_price_b2b,2, '.', ''),
            "adult_price_b2c"=>number_format($get_price1[0]->adults + $adult_price_b2c,2, '.', ''),
            "adult_price_b2e"=>number_format($get_price1[0]->adults + $adult_price_b2e,2, '.', ''),
            "child_price_b2b"=>number_format($get_price1[0]->childs + $child_price_b2b,2, '.', ''),
            "child_price_b2c"=>number_format($get_price1[0]->childs + $child_price_b2c,2, '.', ''),
            "child_price_b2e"=>number_format($get_price1[0]->childs + $child_price_b2e,2, '.', ''),
            "infant_price_b2b"=> number_format($get_price1[0]->infants + $infant_price_b2b,2, '.', ''),
            "infant_price_b2c"=> number_format($get_price1[0]->infants + $infant_price_b2c,2, '.', ''),
            "infant_price_b2e"=> number_format($get_price1[0]->infants + $infant_price_b2e,2, '.', ''),
            "adult_price"=>$get_price1[0]->adults,
            "child_price"=>$get_price1[0]->childs,
            "infant_price"=>$get_price1[0]->infants,
           "url" => '',
           "airline_name" => $details2[$i2]->name,
           "class_type" => $details2[$i2]->flight_type,
           "form" => $form,
           "form_name" => '',
           "action" => site_url('flights/book'),
           "desc" => $details[$i]->desc_flight,
           "luggage" => $details[$i]->bagage,
           "type" => "manual",
        ));
       }
     }
      $related_count++;}
}
/*related flights end*/

/*start $details[0]->return2*/
      $count = 0;
       foreach ($details2 as $i2 => $dt2 ) {
        $get_price1 = $this->Flights_model->flightprice($dt2->id,date('Y-m-d',strtotime($arrival_date)),date('Y-m-d',strtotime($departure_date)),$typeof);
          $price1 = ($get_price1[0]->adults * $adults) + ($get_price1[0]->childs * $childs) + ($get_price1[0]->infants * $infants);

        if ($price1) {
        if ($count == 0) {


          if (($dt2->date_departure == "0000-00-00") || (empty($dt2->date_departure))) {
                $date_departure = date('Y-m-d');
            } else {
                $date_departure = $dt2->date_departure;
            }
            $ob = (object)["code" => $dt2->from_code, "label" => $dt2->from_location, "date" => $date_departure
                ,"flight_no" => json_decode($dt2->flight_no)[0], "time" => $dt2->time_departure, "aero_img" => PT_FLIGHTS_AIRLINES . $details[$i2]->thumbnail];
            array_push($obj_Array2, $ob);
            $transact = json_decode($dt2->transact);
            $date_trans = json_decode($dt2->date_trans);
            $time_trans = json_decode($dt2->time_trans);
            $flight_no = json_decode($dt2->flight_no);
            $aero_trans = json_decode($dt2->aero_trans);
            for ($index = 0; $index < count($transact); $index++) {
                if (($date_trans[$index] == "0000-00-00") || (empty($date_trans[$index]))) {
                    $date_t = date('Y-m-d', strtotime("+" . ($index + 1) . " day"));
                } else {
                    $date_t = $date_trans[$index];
                }
                $ob = (object)["code" => json_decode($transact[$index])->code, "label" => json_decode($transact[$index])->label, "date" => $date_t
                    , "flight_no" => $flight_no[$index + 1], "time" => $time_trans[$index], "aero_img" => ""];
                array_push($obj_Array2, $ob);
            } 
            if (($dt2->date_arrival == "0000-00-00") || (empty($date_trans[$index]))) {
                $date_arrival = date('Y-m-d', strtotime("+" . (count($date_trans) + 1) . " day"));
            } else {
                $date_arrival = $dt2->date_arrival;
            }
            $ob = (object)["code" => $dt2->to_code, "label" => $dt2->to_location, "date" => $date_arrival
                , "flight_no" => json_decode($dt2->flight_no)[0], "time" => $dt2->time_arrival, "aero_img" => ""];
            array_push($obj_Array2, $ob);
          




           for ($h = 0; $h < 1; $h ++) {
               if (!empty(json_decode($dt2->flight_no)[0])) {
                   $flight_no = json_decode($dt2->flight_no)[0];
               } else {
                   $flight_no = "";
               }


              $hidden_parameters = (object)[
                   'tripType' => $type,
                   'setting_id' => $dt->setting_id,
                   'adults' => $adults,
                   'children' => $childs,
                   'infant' => $infants,
               ];

               $form = $this->hidden_parameters($hidden_parameters);

               $getvalue = $this->Modules_model->getmodulename('Flights');

               $price = ($get_price1[0]->adults * $currency_int * $adults) + ($get_price1[0]->childs * $currency_int * $childs) + ($get_price1[0]->infants * $currency_int * $infants);
               $b2c_markup =  $getvalue[0]->b2c_markup;
               $b2b_markup =  $getvalue[0]->b2b_markup;
               $b2e_markup =  $getvalue[0]->b2e_markup;
               $servicefee =  $getvalue[0]->servicefee;
               $desposit =  $getvalue[0]->desposit;

               //Adult Price
               $adult_price_b2c = ($b2c_markup / 100) * $get_price1[0]->adults;
               $adult_price_b2b = ($b2b_markup / 100) * $get_price1[0]->adults;
               $adult_price_b2e = ($b2e_markup / 100) * $get_price1[0]->adults;

               //Chlid Price
               $child_price_b2c = ($b2c_markup / 100) * $get_price1[0]->childs;
               $child_price_b2b = ($b2b_markup / 100) * $get_price1[0]->childs;
               $child_price_b2e = ($b2e_markup / 100) * $get_price1[0]->childs;


               //Infnat Price
               $infant_price_b2c = ($b2c_markup / 100) * $get_price1[0]->infants;
               $infant_price_b2b = ($b2b_markup / 100) * $get_price1[0]->infants;
               $infant_price_b2e = ($b2e_markup / 100) * $get_price1[0]->infants;

               $b2c_price = ($b2c_markup / 100) * $price;
               $b2b_price = ($b2b_markup / 100) * $price;
               $b2e_price = ($b2e_markup / 100) * $price;
               // dd($obj_Array2);
        array_push($test_array, (object)array(
           "departure_flight_no" => $flight_no,
           "img" => PT_FLIGHTS_AIRLINES . $details2[$i2]->thumbnail,
           "departure_time" => $obj_Array2[$h]->time,
           "departure_date" => date('d-m-Y', strtotime($departure_date)),
           "arrival_time" => $obj_Array2[$h + 1]->time,
           "arrival_date" => date('d-m-Y', strtotime($departure_date)),
           "departure_code" => $obj_Array2[$h]->code,
           "departure_airport" => $obj_Array2[$h]->label,
           "arrival_code" => $obj_Array2[$h + 1]->code,
           "arrival_airport" => $obj_Array2[$h + 1]->label,
           "duration_time" => $details2[$i2]->total_hours,
           "currency_code" => $this->Flights_lib->currencycode,
           "price" => ($get_price1[0]->adults * $currency_int * $adults) + ($get_price1[0]->childs * $currency_int * $childs) + ($get_price1[0]->infants * $currency_int * $infants),
            'actual_price' =>$price,
            'b2c_price' => number_format($price + $b2c_price,2, '.', ''),
            'b2b_price' => number_format($price + $b2b_price,2, '.', ''),
            'b2e_price' =>  number_format($price + $b2e_price,2, '.', ''),
            'b2c_markup' => $b2c_markup,
            'b2b_markup' =>  $b2b_markup,
            'b2e_markup' => $b2e_markup,
            'service_fee' => $servicefee,
            'desposit' => $desposit,
            "adult_price_b2b"=>number_format($get_price1[0]->adults + $adult_price_b2b,2, '.', ''),
            "adult_price_b2c"=>number_format($get_price1[0]->adults + $adult_price_b2c,2, '.', ''),
            "adult_price_b2e"=>number_format($get_price1[0]->adults + $adult_price_b2e,2, '.', ''),
            "child_price_b2b"=>number_format($get_price1[0]->childs + $child_price_b2b,2, '.', ''),
            "child_price_b2c"=>number_format($get_price1[0]->childs + $child_price_b2c,2, '.', ''),
            "child_price_b2e"=>number_format($get_price1[0]->childs + $child_price_b2e,2, '.', ''),
            "infant_price_b2b"=> number_format($get_price1[0]->infants + $infant_price_b2b,2, '.', ''),
            "infant_price_b2c"=> number_format($get_price1[0]->infants + $infant_price_b2c,2, '.', ''),
            "infant_price_b2e"=> number_format($get_price1[0]->infants + $infant_price_b2e,2, '.', ''),
            "adult_price"=>$get_price1[0]->adults,
            "child_price"=>$get_price1[0]->childs,
            "infant_price"=>$get_price1[0]->infants,
           "url" => '',
           "airline_name" => $details2[$i2]->name,
           "class_type" => $details2[$i2]->flight_type,
           "form" => $form,
           "form_name" => '',
           "action" => site_url('flights/book'),
           "desc" => $details[$i]->desc_flight,
           "luggage" => $details[$i]->bagage,
           "type" => "manual",
           "related_return_flights"=> $related
        ));
       }
// dd($test_array2);
/*end $details[0]->return2*/
      
      // dd($test_array);

        $related = [];
        $obj_Array2 = array();
        array_push($object_array, $test_array);
        $test_array = [];
        $main_array[]["segments"] = $object_array;
        // $main_array[]["segments"] = ;
        $object_array = [];

      /*if clouse break;*/}
    /*END  details2*/$count++;}
   /*END  price1 condetion*/ }
   /*END details1*/ }
   /*END price condetion*/ }


    }
    if (empty($main_array[0]["segments"])) {
        echo json_encode(array());
    }else{
        echo json_encode($main_array);
    }
}


    public function hidden_parameters($hidden_parameters){
        $input = '';
        $input .= '<input name="tripType" type="hidden"  value="'.$hidden_parameters->tripType.'" />';
        $input .= '<input name="setting_id" type="hidden"  value="'.$hidden_parameters->setting_id.'" />';
        $input .= '<input name="adults" type="hidden"  value="'.$hidden_parameters->adults.'" />';
        $input .= '<input name="children" type="hidden"  value="'.$hidden_parameters->children.'" />';
        $input .= '<input name="infant" type="hidden"  value="'.$hidden_parameters->infant.'" />';
        return $input;

    }

}
