<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Suggestion_Model');

        $this->output->set_content_type('application/json');


    }

    function search_get()
    {
        $data = $this->get();

        $rep = $this->Suggestion_Model->getdata($data['city']);
        if(!empty($rep)) {
            $this->response(array('response' => $rep, 'error' => array('status' => False,'msg' => 'Success')), 200);
        }else{
            $this->response(array('response' => '', 'error' => array('status' => True,'msg' => 'Record not found')), 200);
        }

    }
}
