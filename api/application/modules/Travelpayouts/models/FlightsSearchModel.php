<?php

class FlightsSearchModel
{
    public $form_type;
    public $form_source;

    public $listing_type;
    public $listing_source;

    public $adults;
    public $children;
    public $infants;

    public $show_adult;
    public $show_children;
    public $show_infant;

    public $show_oneway;
    public $show_return;
    public $show_multi_city;

    public $origin;
    public $destination;
    public $arrival;
    public $tripType;
    public $classType;
    public $classOfService;
    public $passenger;
    public $route;
    public $url;


    public function __construct()
    {
        $this->form_type = "form";  // url , form , iframe
        $this->listing_type = "iframe"; // api , iframe
        $this->adults = 1;
        $this->children = 0;
        $this->infants = 0;
        $this->show_adult = true;
        $this->show_children = true;
        $this->show_infant = true;
        $this->show_oneway = true;
        $this->show_return = true;
        $this->show_multi_city = false;
        $this->show_classtype = true;
        $this->tripType = 'oneway'; // oneway retuen muti_city
        $this->classType = 'economy'; // economy bussiness first
        $this->origin = '';
        $this->destination = '';
        $this->route = base_url().'tpflight/search/';

        $settings = app()->service("ModuleService")->get('travelpayouts')->settings;
        $this->url = $settings->WidgetURL;
    }

    public function parseUriString($args)
    {
        $this->origin = $args[0];
        $this->destination = $args[1];
        $this->tripType = $args[2];
        $this->departure_date = $args[4];
        if ($this->tripType == 'round') {
            $this->arrival = $args[5];
            $this->adults = $args[6];
            $this->children = $args[7];
            $this->tripType = "return";
            $this->infant = $args[8];
        } else {
            $this->adults = $args[5];
            $this->children = $args[6];
            $this->infant = $args[7];
            $this->reture_date = $args[7];
        }
        $date = new DateTime($this->departure_date);
        $reture_date = new DateTime($this->arrival);
        if($this->tripType == "round")
        {
            $url = $this->url .$this->origin.$date->format('d').$date->format('m').$this->destination.$reture_date->format('d').$reture_date->format('m').$this->adults.$this->children.$this->infants;
        }else{
            $url = $this->url .$this->origin.$date->format('d').$date->format('m').$this->destination.$this->adults.$this->children.$this->infants;
        }
        $this->listing_source = ' <style> .iframe-container { overflow: hidden; // Calculated from the aspect ration of the content (in case of 16:9 it is 9/16= 0.5625) padding-top: 56.25%; } .iframe-container iframe { border: 0; height: 100%; left: 0; position: absolute; top: 0; width: 100%; margin-top: 96px; } .iframe-container{height:100vh} html{overflow: hidden;} </style> '.'<div class="iframe-container"> <iframe src='.$url.' frameborder="0" style="" height="100%" width="100%"></iframe></div>' ;

    }
}
