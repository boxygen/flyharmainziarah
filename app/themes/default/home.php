<style>
.lazyloading{background:#c3cdd6}
/* data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 460 55'%3E%3Cg fill='none' fill-rule='evenodd' stroke='%23fff' stroke-width='7' opacity='.1'%3E%3Cpath d='M-345 34.5s57.5-13.8 115-13.8 115 13.8 115 13.8S-57.5 48.3 0 48.3s115-13.8 115-13.8 57.5-13.8 115-13.8 115 13.8 115 13.8 57.5 13.8 115 13.8 115-13.8 115-13.8'/%3E%3Cpath d='M-345 20.7s57.5-13.8 115-13.8 115 13.8 115 13.8S-57.5 34.5 0 34.5s115-13.8 115-13.8S172.5 6.9 230 6.9s115 13.8 115 13.8 57.5 13.8 115 13.8 115-13.8 115-13.8m-920 27.6s57.5-13.8 115-13.8 115 13.8 115 13.8S-57.5 62.1 0 62.1s115-13.8 115-13.8 57.5-13.8 115-13.8 115 13.8 115 13.8 57.5 13.8 115 13.8 115-13.8 115-13.8'/%3E%3Cpath d='M-345 6.9s57.5-13.8 115-13.8S-115 6.9-115 6.9-57.5 20.7 0 20.7 115 6.9 115 6.9 172.5-6.9 230-6.9 345 6.9 345 6.9s57.5 13.8 115 13.8S575 6.9 575 6.9'/%3E%3Cpath d='M-345-6.9s57.5-13.8 115-13.8S-115-6.9-115-6.9-57.5 6.9 0 6.9 115-6.9 115-6.9s57.5-13.8 115-13.8S345-6.9 345-6.9 402.5 6.9 460 6.9 575-6.9 575-6.9m-920 69s57.5-13.8 115-13.8 115 13.8 115 13.8S-57.5 75.9 0 75.9s115-13.8 115-13.8 57.5-13.8 115-13.8 115 13.8 115 13.8 57.5 13.8 115 13.8 115-13.8 115-13.8'/%3E%3C/g%3E%3C/svg%3E%0A */
</style>

<section class="hero-wrappe">
  <!-- <div class="hero-box hero-bg active p-4" data-bg="" style="min-height:500px;background-attachment: fixed;background-image: url('#<?=api_url?>uploads/images/slider/<?php foreach ($app->slider as $x => $i){ if( $i->slide_status == "Yes" ) $y = $i->slide_image; } if (isset($y)) { $array = array($y); echo $array[0]; } ?>');"> -->
  <div class="hero-box hero-bg active p-4" data-bg="" style="min-height:600px;background-attachment: fixed;background-image: url('<?=root?>app/themes/default/assets/img/bg.webp');margin-bottom: -35px;">
  <!-- <div class="hero-box hero-bg active p-4" data-bg="" style="min-height:500px;background-attachment: fixed;background-image: url('');"> -->
    <div class="container g-0-xs">
      <div class="row g-0-xs">
        <div class="col-lg-12 g-0-xs mx-auto responsive--column-l">
          <div class="hero-content pb-4 d-none d-sm-block d-lg-block d-xl-block">
            <div class="section-heading">

            <!-- <h2 class="sec__titles cd-headline zoom d-none d-sm-block" style="color:#fff">
                <?=T::hero1; ?> <span class="cd-words-wrapper" style="width: 252.5px;">
                <?php foreach ($app->modules as $model){ if($model->status == true){ ?>
                <b class="is-hidden" style="text-transform: capitalize;"><?=$model->name ?></b>
                <?php } } ?>
                <b class="is-visible">Flights</b>
                </span>
              </h2>
              <p class="text-white strong"><?=T::hero2; ?></p> -->
            </div>
          </div>
           
          <div class="section-tab fade-in" style="min-height:167px;color: #fff;">
            <div class="d-none d-sm-block d-lg-block d-xl-block">
               <h2 class="pb-1"><strong> <?=T::hero_text_1?></strong></h2>
               <p><?=T::hero_text_2?></p>
               <div class="mb-5"></div>
            </div>

          <ul class="nav nav-tabs mb-0 gap-1" id="Tab" role="tablist">
         <?php if (isset($hotels)) { if ($hotels == 1) {?><li data-position="<?= $hotels_order ?>" class="nav-item" role="presentation"><button class="nav-link text-start text-capitalize <?php if (isset($menu_active)){ if ($menu_active == "hotels"){echo "actives";} }?>" id="hotels-tab" data-bs-toggle="tab" data-bs-target="#hotels" type="button" role="tab" aria-controls="hotels" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-hotel mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-hotel mx-1"></i> <span class="text"><?=T::hotels_hotels; ?></span></span></button></li><?php } } ?>
         <?php if (isset($flights)) { if ($flights == 1) {?><li data-position="<?= $flights_order ?>" class="nav-item" role="presentation"><button class="nav-link text-start text-capitalize <?php if (isset($menu_active)){ if ($menu_active == "flights"){echo "actives";} }?>" id="flights-tab" data-bs-toggle="tab" data-bs-target="#flights" type="button" role="tab" aria-controls="flights" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-plane mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-plane mx-1"></i> <span class="text"><?=T::flights_flights; ?></span></span></button></li><?php } } ?>
         <?php if (isset($tours)) { if ($tours == 1) {?><li data-position="<?= $tours_order ?>" class="nav-item" role="presentation"><button class="nav-link text-start text-capitalize <?php if (isset($menu_active)){ if ($menu_active == "tours"){echo "actives";} }?>" id="tours-tab" data-bs-toggle="tab" data-bs-target="#tours" type="button" role="tab" aria-controls="tours" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-briefcase mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-briefcase mx-1"></i> <span class="text"><?=T::tours_tours; ?></span></span></button></li><?php } } ?>
         <?php if (isset($cars)) { if ($cars == 1) {?><li data-position="<?= $cars_order ?>" class="nav-item" role="presentation"><button class="nav-link text-start text-capitalize <?php if (isset($menu_active)){ if ($menu_active == "cars"){echo "actives";} }?>" id="cars-tab" data-bs-toggle="tab" data-bs-target="#cars" type="button" role="tab" aria-controls="cars" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-car mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-car mx-1"></i> <span class="text"><?=T::cars_cars; ?></span></span></button></li><?php } } ?>
         <?php if (isset($visa)) { if ($visa == 1) {?><li data-position="<?= $visa_order ?>" class="nav-item" role="presentation"><button class="nav-link text-start text-capitalize <?php if (isset($menu_active)){ if ($menu_active == "visa"){echo "actives";} }?>" id="visa-tab" data-bs-toggle="tab" data-bs-target="#visa" type="button" role="tab" aria-controls="visa" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-passport mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-passport mx-1"></i> <span class="text"><?=T::visa_visa; ?></span></span></button></li><?php } } ?>
         </ul>
            
            <div class="tab-content search-fields-container search_area search_tabs" id="TabContent">
              <?php foreach ($app->modules as $model){ if($model->status == true){ ?>
              <div class="tab-pane fade" id="<?=$model->name ?>" role="<?=$model->name ?>" aria-labelledby="<?=$model->name ?>-tab">
              <?php require_once 'modules/'.$model->name.'/search.php';?>
              </div>
              <?php } } ?>
            </div>
          </div>
          <?php // recent searches from session
          if (isset($_SESSION['SEARCHES'])) { ?>
          <div class="row mt-3" style="margin-bottom: 100px;">
          <div class="col-md-12">
          <p class="mb-4 mt-2" style="color:#fff"><?=T::recentsearches?></p>
          <hr style="margin: 4px 0; color: #fff;border-color:#fff">
          </div>
            <?php  $max = 12;
            $max_print = count(array_unique($_SESSION['SEARCHES'], SORT_REGULAR));
            krsort($_SESSION['SEARCHES']); foreach (array_unique($_SESSION['SEARCHES'], SORT_REGULAR) as $index => $SEARCHES)  if ($max_print < $max) {
            { $urlm = 0; $urlc = 1; $urlb = 2; }
            ?>
            <div class="col-md-2 mt-3">
            <div class="list-group drop-reveal-list recentsearches">
            <a href="<?=$SEARCHES->$urlb?>" class="list-group-item list-group-item-action border-top-0" target="_blank">
            <div class="msg-body d-flex align-items-center">
                <div class="icon-element flex-shrink-0 mr-3 ml-0">
                <?php if(strtolower($SEARCHES->$urlm) =="hotels"){?><i class="la la-hotel"></i><?php } ?>
                <?php if(strtolower($SEARCHES->$urlm) =="flights"){?><i class="la la-plane"></i><?php } ?>
                <?php if(strtolower($SEARCHES->$urlm) =="tours"){?><i class="la la-briefcase"></i><?php } ?>
                <?php if(strtolower($SEARCHES->$urlm) =="cars"){?><i class="la la-car"></i><?php } ?>
                <?php if(strtolower($SEARCHES->$urlm) =="visa"){?><i class="la la-passport"></i><?php } ?>
                </div>
                <div class="msg-content w-100">
                    <h3 class="title pb-0 px-2" style="text-transform:uppercase"><?=$SEARCHES->$urlm?></h3>
                    <p class="msg-text px-2" style="text-transform:capitalize"><?=$SEARCHES->$urlc?></p>
                </div>
            </div>
            </a>
            </div>
            </div>
            <?php } ?>
          </div>
          <?php } else {} ?>
        </div>
      </div>
    </div>
    <!-- <svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
      <path d="M0 10 0 0 A 90 59, 0, 0, 0, 100 0 L 100 10 Z"></path>
    </svg> -->
  </div>
</section>

<section class="info-area info-bg padding-top-50px padding-bottom-50px text-center home-body-container-new">
   <div class="container">
      <div class="row">
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <i class="la la-bullhorn"></i>
               </div>
               <div class="info-content">
                  <h4 class="info__title"><?=T::hero1?></h4>
                  <p class="info__desc">
                     <?=T::hero2?>
                  </p>
               </div>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <i class="la la-globe"></i>
               </div>
               <!-- end info-icon-->
               <div class="info-content">
                  <h4 class="info__title"><?=T::hero3?></h4>
                  <p class="info__desc">
                     <?=T::hero4?>
                  </p>
               </div>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <i class="la la-thumbs-up"></i>
               </div>
               <div class="info-content">
                  <h4 class="info__title"><?=T::hero5?></h4>
                  <p class="info__desc">
                     <?=T::hero6?>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<?php
if (isset($flights)) { if ($flights == 1) { include theme_url."modules/flights/featured.php"; } }
if (isset($hotels)) { if ($hotels == 1) { include theme_url."modules/hotels/featured.php"; } }
if (isset($tours)) { if ($tours == 1) { include theme_url."modules/tours/featured.php"; } }
if (isset($cars)) { if ($cars == 1) { include theme_url."modules/cars/featured.php"; } }
if (isset($offers)) { if ($offers == 1) { include theme_url."modules/offers/featured.php"; } }
if (isset($blog)) { if ($blog == 1) { include theme_url."modules/blog/featured.php"; } }
?>