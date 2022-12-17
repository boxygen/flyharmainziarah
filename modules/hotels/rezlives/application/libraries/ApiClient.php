<?php
class ApiClient
{

    public function __construct()
    {

    }

    public function callApi($param)
    {
       $check ='<?xml version="1.0" encoding="UTF-8"?>
<HotelFindRequest>
   <Authentication>
      <AgentCode>'.$param['agentcode'].'</AgentCode>
      <UserName>'.$param['username'].'</UserName>
      <Password>'.$param['password'].'</Password>
   </Authentication>
   <Booking>
      <ArrivalDate>'.$param['arrival_date'].'</ArrivalDate>
      <DepartureDate>'.$param['departure_date'].'</DepartureDate>
      <CountryCode>'.$param['country_code'].'</CountryCode>
      <City>'.$param['city_code'].'</City>
      <GuestNationality>'.$param['guest_nationality'].'</GuestNationality>
      <HotelRatings>
         <HotelRating>1</HotelRating>
         <HotelRating>2</HotelRating>
         <HotelRating>3</HotelRating>
         <HotelRating>4</HotelRating>
         <HotelRating>5</HotelRating>
      </HotelRatings>
      <Rooms>
         <Room>
            <Type>Room- '.$param['typeroom'].'</Type>
            <NoOfAdults>'.$param['adults'].'</NoOfAdults>
            <NoOfChilds>'.$param['chlids'].'</NoOfChilds>';
       if($param['chlids'] != 0) {
           $check .= '<ChildrenAges>';
           foreach ($param['child_age'] as $value) {
               $check .='<ChildAge>' . $value->ages . '</ChildAge>';
           }
           $check .='</ChildrenAges>';
       }
        $check .='</Room>
      </Rooms>
   </Booking>
</HotelFindRequest>';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://test.xmlhub.com/testpanel.php/action/findhotel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'XML='.$check,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);

       return $response;

    }

    public function getdetail($param){

        $detail = '<?xml version="1.0"?>
<HotelDetailsRequest>
  <Authentication>
    <AgentCode>'.$param['agentcode'].'</AgentCode>
    <UserName>'.$param['username'].'</UserName>
    <Password>'.$param['password'].'</Password>
  </Authentication>
  <Hotels>
    <HotelId>'.$param['hotel_id'].'</HotelId>
  </Hotels>
</HotelDetailsRequest>
';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://test.xmlhub.com/testpanel.php/action/gethoteldetails',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'XML='.$detail,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;


    }


    public function getdetailid($param){

        $getdetail = '<?xml version="1.0"?>
<HotelFindRequest>
  <Authentication>
    <AgentCode>'.$param['agentcode'].'</AgentCode>
    <UserName>'.$param['username'].'</UserName>
    <Password>'.$param['password'].'</Password>
  </Authentication>
  <Booking>
  <ArrivalDate>'.$param['arrival_date'].'</ArrivalDate>
      <DepartureDate>'.$param['departure_date'].'</DepartureDate>
      <CountryCode>'.$param['country_code'].'</CountryCode>
      <City>'.$param['city_code'].'</City>
      
    <HotelIDs>
      <Int>'.$param['hotel_id'].'</Int>
    </HotelIDs>
    <GuestNationality>'.$param['guest_nationality'].'</GuestNationality>
    <Rooms>
      <Room>
        <Type>Room- '.$param['typeroom'].'</Type>
            <NoOfAdults>'.$param['adults'].'</NoOfAdults>
             <NoOfChilds>'.$param['chlids'].'</NoOfChilds>';
        if($param['chlids'] != 0) {
            $getdetail .= '<ChildrenAges>';
            foreach ($param['child_age'] as $value) {
                $getdetail .='<ChildAge>' . $value->ages . '</ChildAge>';
            }
            $getdetail .='</ChildrenAges>';
        }
        $getdetail .='</Room>
    </Rooms>
  </Booking>
</HotelFindRequest>';


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://test.xmlhub.com/testpanel.php/action/findhotelbyid',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'XML='.$getdetail,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;


    }



    public function prebooking($param){
        $perbooking = '<?xml version="1.0" encoding="UTF-8"?>
<PreBookingRequest>
  <Authentication>
    <AgentCode>'.$param['agentcode'].'</AgentCode>
    <UserName>'.$param['username'].'</UserName>
    <Password>'.$param['password'].'</Password>
  </Authentication>
  <PreBooking>
   <ArrivalDate>'.$param['arrival_date'].'</ArrivalDate>
      <DepartureDate>'.$param['departure_date'].'</DepartureDate>
      <GuestNationality>'.$param['guest_nationality'].'</GuestNationality>
      <CountryCode>'.$param['country_code'].'</CountryCode>
      <City>'.$param['city_code'].'</City>
    <HotelId>'.$param['hotel_id'].'</HotelId>
    <Currency>USD</Currency>
    <RoomDetails>
      <RoomDetail>
        <Type><![CDATA['.$param['room_name'].'
        ]]></Type>
        <BookingKey>'.$param['booking_key'].'</BookingKey>
        <Adults>'.$param['adults'].'</Adults>
        <Children>'.$param['chlids'].'</Children>
        <ChildrenAges>'.$param['children_ages'].'</ChildrenAges>
        <TotalRooms>'.$param['typeroom'].'</TotalRooms>
        <TotalRate>'.$param['room_price'].'</TotalRate>
        <TermsAndConditions/>
      </RoomDetail>
    </RoomDetails>
    <Guests></Guests>
  </PreBooking>
</PreBookingRequest>';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://test.xmlhub.com/testpanel.php/action/prebook',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'XML='.$perbooking,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;


    }


    public function roomcancelpolicy($param){
        $roomcancel = '<?xml version="1.0"?>
  <CancellationPolicyRequest>
    <Authentication>
      <AgentCode>'.$param['agentcode'].'</AgentCode>
    <UserName>'.$param['username'].'</UserName>
    <Password>'.$param['password'].'</Password>
    </Authentication>
 <ArrivalDate>'.$param['arrival_date'].'</ArrivalDate>
      <DepartureDate>'.$param['departure_date'].'</DepartureDate>
   <HotelId>'.$param['hotel_id'].'</HotelId>
    <CountryCode>'.$param['country_code'].'</CountryCode>
   <City>'.$param['city_code'].'</City>
 <GuestNationality>'.$param['guest_nationality'].'</GuestNationality>
  <Currency>USD</Currency>
  <RoomDetails>
    <RoomDetail>
      <BookingKey>'.$param['booking_key'].'</BookingKey>
    </RoomDetail>
  </RoomDetails>
</CancellationPolicyRequest>';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://test.xmlhub.com/testpanel.php/action/getcancellationpolicy',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'XML='.$roomcancel,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function book($param){
        $book = '<?xml version="1.0"?>
<BookingRequest>
  <Authentication>
    <AgentCode>'.$param['agentcode'].'</AgentCode>
    <UserName>'.$param['username'].'</UserName>
    <Password>'.$param['password'].'</Password>
  </Authentication>
  <Booking>
  <SearchSessionId>'.$param['searchSessionId'].'</SearchSessionId>
  <AgentRefNo>'.$param['booking_ref_no'].'-'.$param['booking_id'].'</AgentRefNo>
    <ArrivalDate>'.$param['arrival_date'].'</ArrivalDate>
      <DepartureDate>'.$param['departure_date'].'</DepartureDate>
      <GuestNationality>'.$param['guest_nationality'].'</GuestNationality>
      <CountryCode>'.$param['country_code'].'</CountryCode>
      <City>'.$param['city_code'].'</City>
    <HotelId>'.$param['hotel_id'].'</HotelId>
    <Name>'.$param['hotel_name'].'</Name>
    <Currency>USD</Currency>
    <RoomDetails>
      <RoomDetail>
         <Type><![CDATA['.$param['room_name'].'
        ]]></Type>
        <BookingKey>'.$param['BookingKey'].'</BookingKey>
        <Adults>'.$param['adults'].'</Adults>
        <Children>'.$param['chlids'].'</Children>
         <ChildrenAges>'.$param['children_ages'].'</ChildrenAges>
        <TotalRooms>'.$param['typeroom'].'</TotalRooms>
        <TotalRate>'.$param['room_price'].'</TotalRate>
        <Guests>';
        foreach($param['guest'] as $value){
            $book .= '<Guest>
            <Salutation>'.$value->title.'</Salutation>
            <FirstName>'.$value->first_name.'</FirstName>
            <LastName>'.$value->last_name.'</LastName>';
            if(!empty($value->age)){
                $book .= '<IsChild>1</IsChild>
                        <Age>'.$value->age.'</Age>';
            }
            $book .= '</Guest>';
        }
        $book.=' </Guests>
      </RoomDetail>
    </RoomDetails>
  </Booking>
</BookingRequest>
';
        //dd($book);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://test.xmlhub.com/testpanel.php/action/bookhotel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'XML='.$book,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }



}