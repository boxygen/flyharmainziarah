<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://live.ipms247.com/booking/reservation_api/listing.php?request_type=InsertBooking&HotelCode=18727&APIKey=2c1298c80f8c@9148790807c57666de-bb8c-11ea-a&BookingData=%7B%0A%20%20%20%22Room_Details%22:%7B%0A%20%20%20%20%20%20%22room_1%22:%7B%0A%20%20%20%20%20%20%20%20%20%22Rateplan_Id%22:%223%22,%0A%20%20%20%20%20%20%20%20%20%22Ratetype_Id%22:%223%22,%0A%20%20%20%20%20%20%20%20%20%22Roomtype_Id%22:%223%22,%0A%20%20%20%20%20%20%20%20%20%22baserate%22:%223500%22,%0A%20%20%20%20%20%20%20%20%20%22extradultrate%22:%22500%22,%0A%20%20%20%20%20%20%20%20%20%22extrachildrate%22:%220%22,%0A%20%20%20%20%20%20%20%20%20%22number_adults%22:%222%22,%0A%20%20%20%20%20%20%20%20%20%22number_children%22:%220%22,%0A%20%20%20%20%20%20%20%20%20%22ExtraChild_Age%22:%220%22,%0A%20%20%20%20%20%20%20%20%20%22Title%22:%22%22,%0A%20%20%20%20%20%20%20%20%20%22First_Name%22:%22ABC%22,%0A%20%20%20%20%20%20%20%20%20%22Last_Name%22:%22Joy%22,%0A%20%20%20%20%20%20%20%20%20%22Gender%22:%22%22,%0A%20%20%20%20%20%20%20%20%20%22SpecialRequest%22:%22%22%0A%20%20%20%20%20%20%7D%0A%20%20%20%7D,%0A%20%20%20%22check_in_date%22:%222022-02-22%22,%0A%20%20%20%22check_out_date%22:%222022-02-23%22,%0A%20%20%20%22Booking_Payment_Mode%22:%22%22,%0A%20%20%20%22Email_Address%22:%22abc@gmail.com%22,%0A%20%20%20%22Source_Id%22:%22%22,%0A%20%20%20%22MobileNo%22:%22%22,%0A%20%20%20%22Address%22:%22%22,%0A%20%20%20%22State%22:%22%22,%0A%20%20%20%22Country%22:%22%22,%0A%20%20%20%22City%22:%22%22,%0A%20%20%20%22Zipcode%22:%22%22,%0A%20%20%20%22Fax%22:%22%22,%0A%20%20%20%22Device%22:%22%22,%0A%20%20%20%22Languagekey%22:%22%22,%0A%20%20%20%22paymenttypeunkid%22:%22%22%0A%7D',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: AWSALB=w9ZK1WTxn1kleOWen5HmkqZdyDN3k9wsWei6TKb0k+I43uRQXpiZ5ibf5jgwy2UJ4GG9uXA2Yby+hwN2RnrQykvsLdousAxMfmtF99KYJmouzET7I3FAkmn0vo49QkUM+XnUBN+cxs5wFwQxb2QfTCyyWEKv/T8Rqjyk7jxu1sQZVjQx3R9fDmsggx3ffQ==; AWSALBCORS=w9ZK1WTxn1kleOWen5HmkqZdyDN3k9wsWei6TKb0k+I43uRQXpiZ5ibf5jgwy2UJ4GG9uXA2Yby+hwN2RnrQykvsLdousAxMfmtF99KYJmouzET7I3FAkmn0vo49QkUM+XnUBN+cxs5wFwQxb2QfTCyyWEKv/T8Rqjyk7jxu1sQZVjQx3R9fDmsggx3ffQ==; SSID=1unggf1gku0n9va3btael1q0g4'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
