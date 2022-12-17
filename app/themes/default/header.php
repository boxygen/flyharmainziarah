<?php

// ALL RIGHTS RESERVED BY PHPTRAVELS HTTPS://WWW.PHPTRAVELS.COM 

// APP DATA
$app = $_SESSION['app'];
foreach ($app->currencies as $curreny){ if($curreny->default == true && $curreny->status == true){ $default_currency = $curreny->name; } }
$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST']; $root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

// MODULES CONDITIONS
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'flights' ) { $flights = 1; $flights_order = $model->order; } }
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'hotels' ) { $hotels = 1; $hotels_order = $model->order; } }
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'tours' ) { $tours = 1; $tours_order = $model->order; } }
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'cars' ) { $cars = 1; $cars_order = $model->order; } }
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'visa' ) { $visa = 1; $visa_order = $model->order; } }
foreach ($app->extras  as $model){if($model->status == true && $model->title == 'newsletter' ) { $newsletter = 1; } }
foreach ($app->extras  as $model){if($model->status == true && $model->title == 'blog' ) { $blog = 1; } }
foreach ($app->extras  as $model){if($model->status == true && $model->title == 'offers' ) { $offers = 1; } }

// CURRENCY SESSION
$currency = $_SESSION['session_currency'];
$session_currency = $_SESSION['session_currency'];
$session_lang = $_SESSION['session_lang'];
$_SESSION['admin_email'] = $app->app->email;
require_once theme_url."partcials.php";
?>

<!DOCTYPE html>
<?php

// RTL LANGUAGE
$dir='app/lang';
$indir = array_filter(scandir($dir,1), function($item)
{return !is_dir('app/lang/'.$item);}); $fils_data = array();
foreach ($indir as $key=>$value){ $string = file_get_contents("app/lang/".$value);
array_push ($fils_data,json_decode($string));}
foreach ($fils_data as $key){ if ($key->lang_code == $_SESSION['session_lang']){
if ($key->language_type == "RTL"){
$RTL = 1; ?>
<html lang='ar' dir='rtl'>
<?php } else { echo '<html lang="en">'; } } } ?>
<head>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta http-equiv="refresh" content="6000; <?=$root?>timeout" />

<!-- VERIFICATIONS -->
<meta name="agd-partner-manual-verification" />

<!-- MEDA FOR SEARCH ENGINES AND SOCIAL PLATFORMS -->
<?php if ($meta == 1) {?>
<meta property="og:title" content="<?=$meta_title;?>"/>
<meta property="og:site_name" content="<?=$app->app->appname;?>"/>
<meta property="og:description" content="<?=$meta_desc;?>"/>
<meta property="og:image" content="<?=$meta_img;?>"/>
<meta property="og:url" content="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>"/>
<meta property="og:publisher" content="<?=$app->app->appname;?>"/>

<!-- TWITTER CARD -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@<?=$meta_title;?>" />
<meta name="twitter:title" content="<?=$meta_title;?>" />
<meta name="twitter:description" content="<?=$meta_desc;?>" />
<meta name="twitter:image" content="<?=$meta_img;?>" />

<!-- GOOGLE JSON SCHEMA -->
<script type="application/ld+json">
{
"@context" : "http://schema.org",
"@type" : "Corporation",
"brand": "<?=$meta_title;?>",
"description": "<?=$meta_desc;?>",
"name" : "<?=$meta_title;?>",
"foundingDate": "2014-05",
"knowsAbout": "Online Travel Agency",
"legalName": "<?=$meta_title;?>",
"logo" : "<?=root."api/uploads/global/logo.png";?>",
"numberOfEmployees": "15",
"ownershipFundingInfo": "<?=root?>contact",
"url" : "<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>",
"slogan": "Online Tavel Booking Services",
"tickerSymbol": [
"NYSE:SHOP",
"TSX:SHOP"
]
</script>

<?php } ?>

<title><?=$title;?> - <?=$app->app->appname?></title>
<base href="<?=root;?>">

<!-- ASSETS -->
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/line-awesome.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/owl.theme.default.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/jquery.fancybox.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/animate.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/animated-headline.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/flag-icon.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/style.css">
<link rel="stylesheet" href="<?=root.theme_url?>style.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/mobile.css"> 
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/childstyle.css">

<link rel="shortcut icon" href="<?=api_url;?>uploads/global/favicon.png">
<script src="<?=root.theme_url?>assets/js/jquery/jquery.min.js"></script>
<script> var baseurl = "<?=root?>"; let root = "<?=root?>";</script>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

<!-- PACEJS -->
<script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>

<!-- RTL -->
<?php if (isset($RTL)) { ?>
<link rel='stylesheet' href='<?=root;?><?=theme_url?>assets/css/style-rtl.css'/>
<link rel='stylesheet' href='<?=root;?><?=theme_url?>assets/css/bootstrap-rtl.min.css'/>
<link href="https://fonts.googleapis.com/css?family=Tajawal:300,400,500,700,800&amp;subset=arabic" rel="stylesheet">
<?php } ?>

</head>
<body id="fadein" class="fixed-nav" style="padding-top:70px !important;">

<!-- loading effect -->
<div class="preloader centerrotate" id="preloader">
 <div class="rotatingDiv"></div>
</div>

<!-- LOADING MODAL -->
<?php include "loading.php"; ?>

<!-- ================================
         START HEADER AREA
================================= -->
<header class="header-area">
    <!-- <div class="header-top-bar padding-right-100px padding-left-100px">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="header-top-content">
                        <div class="header-left">
                            <ul class="list-items">
                                <li><a href="tel:<?=$app->app->phone?>"> <i class="la la-phone mr-1"></i> <?=$app->app->phone?></a></li>
                                <li><a href="mailto:<?=$app->app->email?>"><i class="la la-envelope mr-1"></i><?=$app->app->email?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php $indir = array_filter(scandir('app/lang',1), function($item) {return !is_dir('app/lang/'.$item);}); $files_data = array(); foreach ($indir as $key=>$value){ $string = file_get_contents("app/lang/".$value); array_push ($files_data,json_decode($string)); } ?>
            </div>
        </div>
    </div> -->

    <div class="header-menu-wrapper padding-right-100px padding-left-100px d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="menu-wrapper d-flex">
                        <!-- <script>
                        function takeup() {
                            window.scrollTo({top: 0, behavior: 'smooth'});
                        }
                        </script> -->
                        <!-- <a href="javascript:void(0)" onclick="takeup();" class="down-button"><i class="la la-angle-down"></i></a> -->
                        <div class="logo">
                            <a href="<?=root;?>" style="border-radius:5px">
                            <img style="max-height:40px;border-radius:5px;background:transparent;padding:4px;" src="<?=api_url;?>uploads/global/logo.png" alt="logo">
                            </a>
                            <div class="menu-toggler">
                                <i class="la la-bars"></i>
                                <i class="la la-times"></i>
                            </div>
                        </div>

                        <div class="main-menu-content w-100">
                                <div class="align-items-center d-flex justify-content-between gap-3">

                                  <div class="w-100">
                                    <nav class="px-5">
                                        <ul style="padding-top:10px!important"">
                                            <!-- <li><a href="<?=root;?>" title="home"><?=T::home?></a></li> -->
                                            <?php foreach ($app->modules as $model){ ?>

                                            <?php  if ($model->status == true && $model->name == 'hotels') { ?>
                                            <li><a class="active_hotels" href="<?=root;?><?=$model->name?>" title="hotels"><?=T::hotels_hotels?></a></li>
                                            <?php } ?>

                                            <?php if ($model->status == true && $model->name == 'flights') { ?>
                                            <li><a class="active_flights" href="<?=root;?><?=$model->name?>" title="flights"><?=T::flights_flights?></a></li>
                                            <?php } ?>

                                            <?php if ($model->status == true && $model->name == 'tours') { ?>
                                            <li><a class="active_tours" href="<?=root;?><?=$model->name?>" title="tours"><?=T::tours_tours?></a></li>
                                            <?php } ?>

                                            <?php if ($model->status == true && $model->name == 'cars') { ?>
                                            <li><a class="active_cars" href="<?=root;?><?=$model->name?>" title="cars"><?=T::cars_cars?></a></li>
                                            <?php } ?>

                                            <?php if ($model->status == true && $model->name == 'visa') { ?>
                                            <li><a class="active_visa" href="<?=root;?><?=$model->name?>" title="visa"><?=T::visa_visa?></a></li>
                                            <?php } } ?>

                                            <?php  if (isset($blog)) { if ($blog == 1) {?>
                                            <li><a class="active_blog" href="<?=root;?>blog" title="blog"><?=T::blog?></a></li>
                                            <?php } } ?>

                                            <?php  if (isset($offers)) { if ($offers == 1) {?>
                                            <li><a class="active_offers" href="<?=root;?>offers" title="offers"><?=T::offers?></a></li>
                                            <?php } } ?>

                                            <!-- header manue -->
                                            <?php foreach ($app->cms->header as $key => $value) {
                                            foreach ($value as $k => $v) { ?>
                                            <li class="footm">
                                            <?php if ($k == $v[0]->title && count($v) < 2){ ?>
                                            <a href="<?=$v[0]->href?>"><?= $k ?></a>
                                            <?php  }elseif($k == $v[0]->title && count($v) > 1){?>
                                            <a href="<?=$v[0]->href?>"><?= $k ?> <i class="la la-angle-down"></i></a>
                                            <?php }?>
                                            <?php if (count($v) > 1) {?>
                                            <ul class="dropdown-menu-item">
                                            <?php foreach ($v as $mk => $mv) { if ($mv->title != $k) {?>
                                            <li><a href="<?=$root;?><?= $mv->href ?>"><?= $mv->title ?></a></li><?php }} ?>
                                            </ul> <?php } ?>
                                            </li> <?php } } ?>
                                        </ul>
                                    </nav>
                                </div>

                                <script>
                                    
                                    // FUNCTION TO ADD ACTIVE CLASS TO ACTIVE PAGE MENU
                                    const pathArray = window.location.pathname.split("/");
                                    const segment_2 = pathArray[1];

                                    if ( segment_2 == "hotels") { $(".active_hotels").css("font-weight", "bold"); }
                                    if ( segment_2 == "flights") { $(".active_flights").css("font-weight", "bold"); }
                                    if ( segment_2 == "tours") { $(".active_tours").css("font-weight", "bold"); }
                                    if ( segment_2 == "cars") { $(".active_cars").css("font-weight", "bold"); }
                                    if ( segment_2 == "visa") { $(".active_visa").css("font-weight", "bold"); }
                                    if ( segment_2 == "blog") { $(".active_blog").css("font-weight", "bold"); }
                                    if ( segment_2 == "offers") { $(".active_offers").css("font-weight", "bold"); }

                                 </script>

                                <div class="d-flex header-top-bar">

                                    <?php if ($app->app->multi_language == true) { ?>
                                    <div class="header-right-action pt-1 multi_language">
                                    <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="languages" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="flag-icon flag-icon-<?php foreach ($files_data as $lang){ if($lang->lang_code == $session_lang){ echo $lang->country_code; } }?> mr-1"></span>
                                    <?php foreach ($files_data as $lang){ if($lang->lang_code == $session_lang){ echo $lang->language_name; } }?>
                                    <i class="la la-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="languages" style="max-height: 260px; overflow: auto;">
                                    <?php foreach($files_data as $item){ $lan = $item->lang_code; { ?>
                                    <li><a class="dropdown-item" href="<?=root?>lang-<?=$item->lang_code?>"><span class="flag-icon flag-icon-<?=$item->country_code?> mr-1"></span> <?=$item->language_name?></a></li>
                                    <?php } } ?>
                                    </ul>
                                    </div>
                                    </div>
                                    <?php } ?>

                                    <?php if ($app->app->multi_currency == true) { ?>
                                    <div class="header-right-action  pt-1 pe-2 multi_currency">
                                    <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="currency" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?=$session_currency?>
                                    <i class="la la-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="currency" style="max-height: 260px; overflow: auto;">
                                    <?php foreach ($app->currencies as $currencies){ if($currencies->status == true){ ?>
                                    <li><a class="dropdown-item" href="<?=root?>currency-<?=$currencies->name?>"> <?=$currencies->name?></a></li>
                                    <?php } } ?>
                                    </ul>
                                    </div>
                                    </div>
                                    <?php } ?>

                                    <?php if (!isset($_SESSION['user_login']) == true) { ?>

                                    <div class="header-right-action pt-1 pe-2">
                                    <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="ACCOUNT" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg class="pe-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <?=T::account?>
                                    <i class="la la-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="ACCOUNT">

                                    <!-- CUSTOMERS -->
                                    <?php if ($app->app->allow_registration == true) { ?>
                                    <li><a class="dropdown-item" href="<?=root?>login"><?=T::customer?> <?=T::login?></a></li>
                                    <li><a class="dropdown-item" href="<?=root?>signup"><?=T::customer?> <?=T::signup?></a></li>
                                    <?php } ?>

                                    <div class="dropdown-divider"></div>

                                    <!-- AGENTS -->
                                    <?php if ($app->app->allow_agent_registration == true) { ?>
                                    <li><a class="dropdown-item b2b_agents" href="<?=root?>login" target="_blank"><?=T::agents?> <?=T::login?></a></li>
                                    <li><a class="dropdown-item b2b_agents" href="<?=root?>signup-agent"><?=T::agents?> <?=T::signup?></a></li>
                                    <?php } ?>

                                    <div class="dropdown-divider"></div>

                                    <!-- SUPPLIERS -->
                                    <?php if ($app->app->suppliers_registration == true) { ?>
                                    <li><a class="dropdown-item suppliers" href="<?=root?>signup-supplier"><?=T::supplier?> <?=T::signup?></a></li>
                                    <li><a class="dropdown-item suppliers" href="<?=api_url?>supplier" target="_blank"><?=T::supplier?> <?=T::login?></a></li>
                                    <?php } ?>

                                    </ul>
                                    </div>
                                    </div>
                                    <?php } ?>

                                    <!-- USER LOGGED IN -->
                                    <?php if (isset($_SESSION['user_login']) == true) { ?>
                                    <div class="header-right-action pt-1 pe-2">
                                    <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="currency" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg class="pe-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <?=T::account?>
                                    <i class="la la-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="currency">
                                    <li><a class="dropdown-item" href="<?=root?>account/dashboard"> <?=T::dashboard?></a></li>
                                    <li><a class="dropdown-item" href="<?=root?>account/bookings"> <?=T::mybookings?></a></li>
                                    <li><a class="dropdown-item" href="<?=root?>account/add_funds"> <?=T::add_funds?></a></li>
                                    <li><a class="dropdown-item" href="<?=root?>account/profile"> <?=T::myprofile?></a></li>
                                    <li><a class="dropdown-item" href="<?=root?>account/logout"> <?=T::logout?></a></li>
                                    </ul>
                                    </div>
                                    </div>
                                    <?php } ?>

                                </div>
                                </div>

                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ================================
         END HEADER AREA
================================= -->