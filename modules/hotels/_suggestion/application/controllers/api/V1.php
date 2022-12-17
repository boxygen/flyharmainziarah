<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ApiClient');
        $this->load->model('Suggestion_Model');

        $this->output->set_content_type('application/json');



    }

    function search_get()
    {
        $data = $this->get();


        $param = array(
            'term' => $data['city'],
            'lang' => $data['lang'],
            'limit' => '50',
            'endpoint' => "https://yasen.hotellook.com/autocomplete",
        );

        $checkdata = $this->Suggestion_Model->getloac($data['city']);
        if(empty($checkdata)) {
            $tphotl = new ApiClient();
            $response = $tphotl->sendRequest('GET', 'search', $param);
            $rep = (json_decode($response));
            if(!empty($rep->cities)) {
                $par = array(
                    'loc_name' => $data['city'],
                    'loc_data' => $response
                );
                $this->Suggestion_Model->savedata($par);
            }
           // header("Access-Control-Allow-Origin: http://localhost:3000");

            $this->response($rep, 200);
        }else{
            $this->response(json_decode($checkdata[0]->loc_data), 200);
        }

    }
}
