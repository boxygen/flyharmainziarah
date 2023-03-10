<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

include 'db_connect.php';

header('Content-Type: application/json');

// $apiKey = "489a33f836b46cc19383a08e996abdba";
// $sharedSecret = "1469a993fb";

// $apiKey = "c75bdfb6aba33d03804092fb331a2c17";
// $sharedSecret = "6b81e5a09b";

// $apiKey = "4e80108efedcea1296fd3e5171bc3843";
// $sharedSecret = "38f0309151";

// $apiKey = "eebb256acbadf94ecbbeba9ef81a6c49";
// $sharedSecret = "1359c6b1cd";

$apiKey = $_POST['apiKey']; // "eebb256acbadf94ecbbeba9ef81a6c49";
$sharedSecret = $_POST['sharedSecret']; //"1359c6b1cd";

// $apiKey = "96f70c9cce408ceb5eabd6542c4a72ad";
// $sharedSecret = "5492a7ef72";

// $apiKey = "c7be5614b7989ba46a8bf144c9cc65dd";
// $sharedSecret = "e44ac5e6b6";

// Signature is generated by SHA256 (Api-Key + Shared Secret + Timestamp (in seconds))
$signature = hash("sha256", $apiKey . $sharedSecret . time());


function callAPI($method, $url, $data)
{
    global $apiKey;
    global $signature;
    $curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Api-key: ' . $apiKey,
        'X-Signature:' . $signature,
        'Accept: application/json',
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if (!$result) {
        die("Connection Failure");
    }
    curl_close($curl);
    return $result;
}


function getRoomsDetails()
{
    $hotel_url = "https://api.test.hotelbeds.com/hotel-content-api/1.0/types/rooms";
    $post_opt = array(
        'fields' => 'all',
        'language' => 'ENG',
        'from' => '1',
        'to' => '1000',
        'useSecondaryLanguage' => 'true'
    );
    $get_data = callAPI('GET', $hotel_url, $post_opt);
    $response = json_decode($get_data, true);

    // $rooms = array(
    //     ''
    // );

    if (!isset($response['error'])) {
        return $get_data;
    } else {
        return [];
    }
}




function hotelDetails($details_opt)
{

    $hotel_id = $details_opt['hotel_id'];

    $hotel_url = "https://api.test.hotelbeds.com/hotel-content-api/1.0/hotels/{$hotel_id}/details";

    $get_data = callAPI('GET', $hotel_url, FALSE);
    $response = json_decode($get_data, true);

    // return json_encode($response);

    if (isset($response['hotel'])) {
        $hotelDetails = $response['hotel'];


        $hotel_booking_search_url = "https://api.test.hotelbeds.com/hotel-api/1.0/hotels";

        $checkin = date('Y-m-d', strtotime($details_opt['arrival_date']));
        $checkout = date('Y-m-d', strtotime($details_opt['departure_date']));


        $hotelCodeArray = array(0 => $details_opt['hotel_id']);
        $filter = [];
        for ($i = 0; $i < $details_opt['childs']; $i++) {
            $filter[] = '{ "type": "CH", "age": ' . $details_opt['child_age'] . ' }';
        }

        $checkAvailibility = '{
                "stay": {
                    "checkIn": "' . $checkin . '",
                    "checkOut": "' . $checkout . '"
                },
                "occupancies": [
                    {
                        "rooms": ' . (isset($details_opt['rooms']) ? $details_opt['rooms'] : 1) . ',
                        "adults": ' . $details_opt['adults'] . ',
                        "children": ' . $details_opt['childs'] . ' ';

        ($details_opt['childs'] >= 1) ? ($checkAvailibility .= ',"paxes": [
                        ' . implode(' , ', $filter) . '
                        ]') : null;

        $checkAvailibility .= '}
                ],
                "hotels": {
                    "hotel": ' . json_encode($hotelCodeArray) . '
                }
            }';
        $get_data1 = callAPI('POST', $hotel_booking_search_url, $checkAvailibility);
        $response1 = json_decode($get_data1, true);
        // return json_encode($response1);

        if ($response1['hotels']['total'] > 0) {

            $filteredHotels = $response1['hotels']['hotels'];
            $responseObj = array();
            $hotel_id = $hotelDetails['code'];
            $hotel_name = $hotelDetails['name']['content'];
            $location = $hotelDetails['destination']['name']['content'];
            $stars = $filteredHotels[0]['categoryName'];
            $rating = $hotelDetails['ranking'];
            $longitude = $hotelDetails['coordinates']['longitude'];
            $latitude = $hotelDetails['coordinates']['latitude'];
            $desc = $hotelDetails['description'];
            $amenities = array();
            $img = array();
            $rooms = $filteredHotels[0]['rooms'];
            $address = isset($hotelDetails['address']) ? $hotelDetails['address']['content'] : "";
            $policy = isset($hotelDetails['web']) ? $hotelDetails['web'] : "";


            foreach ($hotelDetails['images'] as $image) {
                $imageName = explode('/', $image['path']);
                $imageName = end($imageName);
                $image_url = "https://photos.hotelbeds.com/giata/" . $image['path'];
                $imgArray = array(
                    'type' => $image['type'],
                    'path' => $image_url,
                    'roomCode' => $image['roomCode'],
                    'roomType' => $image['roomType'],
                    'characteristicCode' => $image['characteristicCode'],
                    'order' => $image['order'],
                    'visualOrder' => $image['visualOrder'],
                );
                $img[] = $imgArray;
            }
            foreach ($hotelDetails['amenities'] as $amenity) {
                array_push($amenities, $amenity['description']['content']);
            }

            array_push($responseObj, array(
                'hotel_id' => $hotel_id,
                'name' => $hotel_name,
                'location' => $location,
                'stars' => $stars,
                'rating' => $rating,
                'latitude' => $longitude,
                'longitude' => $latitude,
                'desc' => $desc,
                'img' => isset($img) ? $img : [],
                'amenities' => isset($amenities) ? $amenities : [],
                'rooms' => $rooms,
                'policy' => $policy,
                'address' => $address
            ));

            // return (json_encode($response1, JSON_PRETTY_PRINT));
            // return (json_encode($filteredHotels, JSON_PRETTY_PRINT));
            return (json_encode($responseObj, JSON_PRETTY_PRINT));
        } else {
            // return "Error in Else";
            return json_encode($response1);
        }
    } else {
        return json_encode($response);
    }
}



// $details_opt = array(
//     "hotel_id" => "13439",  // 13007  // 13439  // 14742  // 107255
//     "city_code" => "NYC",
//     "country_code" => "US",
//     "arrival_date" => "2022-06-15",
//     "departure_date" => "2022-06-30",
//     "guest_nationality" => "Pakistani",
//     "adults" => "3",
//     "childs" => "0",
//     "child_age" => "0",
//     "Typeroom" => "2 Double Beds Room",
//     // "rooms" => "2",
// );

$details_opt = array(
    "hotel_id" => $_POST['hotel_id'],
    "city_code" => $_POST['city_code'],
    "country_code" => $_POST['country_code'],
    "arrival_date" => $_POST['arrival_date'],
    "departure_date" => $_POST['departure_date'],
    "guest_nationality" => $_POST['guest_nationality'],
    "adults" => $_POST['adults'],
    "childs" => $_POST['childs'],
    "child_age" => $_POST['child_age'],
    "typeroom" => $_POST['typeroom'],
    // "rooms" => $_POST['rooms'],
);

// echo getRoomsDetails();
$data = hotelDetails($details_opt);
echo $data;
