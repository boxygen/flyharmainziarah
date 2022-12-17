<?php
class ApiClient
{


    public function __construct()
    {

    }

    function curl_call($method,$url, $params, $headers = array())
    {

       // dd($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if($method == 'post')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        else
        {
           // dd($params);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $url = $url."?".http_build_query($params);
        }
        $content = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return $err;
        } else {
            return $content;
        }
    }
}