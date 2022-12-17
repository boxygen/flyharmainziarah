<?php
class ApiClient
{

    public function __construct()
    {
    }

    public function callApi($search,$code)
    {

        try {
            $client = new \SoapClient("http://xml-uat.bookingengine.es/webservice/JP/WebServiceJP.asmx?WSDL", array(
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
                'trace' => true,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ));

            $client->__setLocation("https://xml-uat.bookingengine.es/WebService/jp/operations/availtransactions.asmx");

            $response = $client->HotelAvail([
                "HotelAvailRQ" =>[
                    "Version" => "1.1",
                    "Language" => "en",
                    "Login" => [
                        "Email" => $search['c3'],
                        "Password" => $search['c4'],
                    ],
                    "Paxes" =>[
                        "Pax"=> [
                            [
                                "IdPax"=>"1",
                                "Age"=>30
                            ],
                            [
                                "IdPax"=>"2",
                                "Age"=>30
                            ],
                        ],

                    ],
                    "HotelRequest" => [
                        "SearchSegmentsHotels" => [
                            "SearchSegmentHotels" => [
                                "Start"=> date("Y-m-d", strtotime($search['checkin'])),
                                "End"=> date("Y-m-d", strtotime($search['checkout'])),
                            ],
                            "CountryOfResidence"=>"ES",
                            "HotelCodes"=>[
                                "HotelCode" => $code,

                            ],

                        ],
                        "RelPaxesDist"=>[
                            "RelPaxDist"=>[
                                "RelPaxes"=>[
                                    "RelPax"=>[
                                        [
                                            "IdPax"=>"1",
                                        ],
                                        [
                                            "IdPax"=>"2",
                                        ],
                                    ],

                                ],
                            ],
                        ],
                    ],
                    "AdvancedOptions"=>[
                        "ShowHotelInfo"=>true,
                        "ShowOnlyBestPriceCombination"=>true,
                        "TimeOut"=>8000,
                    ],
                ],
            ]);

            //header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }



    public function getimage($code,$data)
    {
        try {
            $client = new \SoapClient("http://xml-uat.bookingengine.es/webservice/JP/WebServiceJP.asmx?WSDL", array(
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
                'trace' => true,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ));

            $client->__setLocation("https://xml-uat.bookingengine.es/WebService/jp/operations/staticdatatransactions.asmx");

            $response = $client->HotelContent([
                "HotelContentRQ" =>[
                    "Version" => "1.1",
                    "Language" => "en",
                    "Login" => [
                        "Email" => $data['c3'],
                        "Password" => $data['c4'],
                    ],
                    "HotelContentList" => [
                        "Hotel" => [
                            "Code" => $code,
                        ]
                    ],
                ],
            ]);

            //header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}