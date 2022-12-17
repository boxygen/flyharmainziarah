<?php
class HotelApiClient
{
    public $client;

    public function __construct()
    {
    }

    public function callApi($hotel_id, $searchForm)
    {

        try {
            $client = new \SoapClient("https://dev.hotelston.com/ws/StaticDataServiceV2?wsdl", array(
                'soap_version' => 'SOAP_1_2',
                'encoding' => 'UTF-8',
                'exceptions' => true,
                'stream_context' => stream_context_create(array(
                    'http' => array(
                        'header' => array(
                            'Content-Type: text/xml; charset=UTF-8',
                            'Accept-Encoding: gzip, deflate'
                        )),
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    )
                )),
                'trace' => true
            ));

            $client->__setLocation("http://dev.hotelston.com/ws/StaticDataServiceV2/StaticDataServiceHttpSoap11Endpoint");

            $response = $client->getHotelDetails([
                "loginDetails" => [
                    "email" => $searchForm->c1,
                    "password" => $searchForm->c2
                ],
                "hotelId" => $hotel_id,
            ]);

            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function getroom($hotel_id, $searchForm)
    {


        if($searchForm->chlids == 0){
            $checkchlid = [
                "adults" => $searchForm->adults,
                "children" => $searchForm->chlids,
                "seqNo" => 0,

            ];
        }else{
            $checkchlid = [
                "adults" => $searchForm->adults,
                "children" => $searchForm->chlids,
                "seqNo" => 0,
                "childAge" => 8,

            ];
        }
        try {
            $client = new \SoapClient("https://dev.hotelston.com/ws/HotelServiceV2?wsdl", array(
                'soap_version' => 'SOAP_1_2',
                'encoding' => 'UTF-8',
                'exceptions' => true,
                'stream_context' => stream_context_create(array(
                    'http' => array(
                        'header' => array(
                            'Content-Type: text/xml; charset=UTF-8',
                            'Accept-Encoding: gzip, deflate'
                        )),
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    )
                )),
                'trace' => true
            ));

            $client->__setLocation("http://dev.hotelston.com/ws/HotelServiceV2/HotelServiceHttpSoap11Endpoint/");

            $response = $client->searchHotels([
                "loginDetails" => [
                    "email" => $searchForm->c1,
                    "password" => $searchForm->c2
                ],
                "criteria" => [
                    "checkIn" => date("Y-m-d", strtotime($searchForm->checkin)),
                    "checkOut" => date("Y-m-d", strtotime($searchForm->checkout)),
                    "clientNationality" => "ES",
                    "hotelSelector" => [
                        "hotelIds" => [
                            "hotelId" => $hotel_id,
                        ]
                    ],
                    "room" => $checkchlid
                ]

            ]);

            // header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function callApibooking($data)
    {
//        $arry['adult'] = [];
//        $final_array = [];
//        foreach ($data['guest'] as $key=>$val){
//            $arry['adult'] = array(
//                "title" =>$val->title,
//                "firstname" => $val->first_name,
//                "lastname" =>$val->last_name,
//            );
//            $final_array[] = $arry;
//        }
//        dd($final_array);

        try {
            $client = new \SoapClient("https://dev.hotelston.com/ws/HotelServiceV2?wsdl", array(
                'soap_version' => 'SOAP_1_2',
                'encoding' => 'UTF-8',
                'exceptions' => true,
                'stream_context' => stream_context_create(array(
                    'http' => array(
                        'header' => array(
                            'Content-Type: text/xml; charset=UTF-8',
                            'Accept-Encoding: gzip, deflate'
                        )),
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    )
                )),
                'trace' => true
            ));

            $client->__setLocation("http://dev.hotelston.com/ws/HotelServiceV2/HotelServiceHttpSoap11Endpoint/");

            $response = $client->bookHotel([
                "loginDetails" => [
                    "email" => $data['agentcode'],
                    "password" => $data['username']
                ],
                "currency" =>$data['actual_currency'],
                "hotelId" =>$data['hotel_id'],
                "checkIn" => date("Y-m-d", strtotime($data['arrival_date'])),
                "checkOut" =>date("Y-m-d", strtotime($data['departure_date'])),
                "agentReferenceNumber" =>$data['booking_ref_no'],
                "clientNationality" =>"LT",
                "contactPerson" => [
                    "title" => 'MR',
                    "firstname" => "usama",
                    "lastname" => 'malik',
                    "email" => 'usama@gmail.com',
                    "phone" => '923487653223',
                ],
                "room" => [
                    "seqNo" => 0,
                    "roomId" => $data['room_data']->roomId,
                    "roomTypeId" => $data['room_data']->roomTypeid,
                    "boardTypeId" => $data['room_data']->boardTypeid,
                    "price" => $data['actual_price'],
                    "adult" => [
                        "title" =>strtoupper($data['guest'][0]->title),
                        "firstname" => $data['guest'][0]->first_name,
                        "lastname" => $data['guest'][0]->last_name,
                    ],
                    "adult" => [
                        "title" =>strtoupper($data['guest'][1]->title),
                        "firstname" => $data['guest'][1]->first_name,
                        "lastname" => $data['guest'][1]->last_name,
                    ],
                ],

            ]);

            header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}