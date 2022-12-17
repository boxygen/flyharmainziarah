<?php
  // dd($hotel->rooms);
  if (!empty($hotel->rooms)) { ?>
<div id="availability" class="page-scroll">
  <div class="section-heading mt-1 mb-1">
    <h3 class="sec__title_left left-line"><?=T::hotels_availablerooms?></h3>
  </div>
  <div class="single-content-item padding-top-20px padding-bottom-5px rooms">
    <?php foreach ($hotel->rooms as $index => $room) { ?>
    <div class="card mb-4">
      <div class="card-header default">
        <strong><?=$room->name?></strong>
      </div>
      <div class="card-body" style="padding-bottom: 0px !important;">
        <div class="row">
          <div class="col-md-1">
            <?php
              if (!isset($room->img[0])) { ?>
            <img data-expand="-20" data-src="<?=root?>app/themes/default/assets/img/data/hotel.jpg" alt="image" class="img-fluid lazyload" style="max-height: 178px; width: 100%;cursor:pointer">
            <?php } else {?>
            <img data-expand="-20" data-src="<?=$room->img[0]?>" alt="image" class="img-fluid room_img lazyload" style="height: 60px; margin-top: 20px; width: 100%; border-radius: 5px !important; cursor: pointer;" data-fancybox="rooms_<?=$index?>">
            <?php } ?>
            <?php
              foreach ($room->img as $img) { ?>
            <a class="d-none" data-src="<?=$img?>"
              data-fancybox="rooms_<?=$index?>"
              data-caption=""
              data-speed="700">
            </a>
            <?php } ?>
          </div>
          <div class="col-md-11">
            <form action="<?=root?>hotels/booking" method="POST">
              <?php foreach ($room->options as $rms){
                //  dd($room);
                ?>
              <div class="row g-3">
                <div class="col-md-3">
                  <p><strong><?=T::amenities?></strong></p>
                  <div class="d-grid">
                    <?php  $i = 0;  $items = $room->amenities; shuffle($items); foreach ($items as $it) { if (++$i == 4) break; ?>
                    <p class="hotels_amenities"><i class="la la-check me-2"></i> <?=$it->name?></p>
                    <?php } ?>
                    <!--<p><i class="la la-info-circle me-2"></i> <small><strong><?=T::showmore?></strong></small></p>-->
                  </div>
                </div>
                <div class="col-md-2">
                  <p><strong><?=T::max_guests?></strong></p>
                  <div class="">
                    <div class="row">
                      <div class="col responsive-column">
                        <div class="single-tour-feature d-flex align-items-center mb-1">
                          <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-0" style="width: 25px; height: 25px; font-size: 14px; line-height: 26px;;margin:0">
                            <i class="la la-user"></i>
                          </div>
                          <div class="single-feature-titles">
                            <h3 class="title font-size-15 font-weight-medium mx-2"><?=T::adults?> <?=$rms->adults?></h3>
                          </div>
                        </div>
                      </div>
                      <div class="clear"></div>
                      <div class="col responsive-column">
                        <div class="single-tour-feature d-flex align-items-center">
                          <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-0" style="width: 25px; height: 25px; font-size: 14px; line-height: 26px;;margin:0">
                            <i class="la la-female"></i>
                          </div>
                          <div class="single-feature-titles">
                            <h3 class="title font-size-15 font-weight-medium y-2 mx-2"><?=T::child?> <?=$rms->child?></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                  // if price by travellers
                  if ($rms->price_type == "1"){
                  
                  $adults_price = $adults * $rms->room_adult_price;
                  $childs_price = $childs * $rms->room_child_price;
                  
                  $travellers_price = $adults_price + $childs_price;
                  
                  // check if agent is login
                  if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "agent") {
                  
                  $price_b2b = ($rms->b2b_markup / 100) * $travellers_price;
                  $price = $price_b2b + $travellers_price;
                  
                  } } else {
                  
                  $price_b2c = ($rms->b2c_markup / 100) * $travellers_price;
                  $price = $price_b2c + $travellers_price;
                  
                  }
                  
                  // check if customer is login
                  if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "customers") {
                  
                  $price_b2c = ($rms->b2c_markup / 100) * $travellers_price;
                  $price = $price_b2c + $travellers_price;
                  
                  } } }
                  
                  // if price fixed by night
                  else {
                  
                  // check if agent is login
                  if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "agent") { $price = $rms->b2b_price; }
                  } else { $price = $rms->b2c_price; }
                  
                  // check if customer is login
                  if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "customers") { $price = $rms->b2c_price; }
                  } }
                  
                  ?>
                <div class="col-md-2">
                  <p><strong><?=T::price?>
                    </strong>
                  </p>
                  <div class="d-flex">
                    <p class="text-uppercase font-size-14" style="width:150px;">
                      <!--<?=T::pernight?>--><strong class="mt-n1 text-black font-size-18 font-weight-black d-block"><?=$currency?> <?=number_format( $price,2); //will give you string(4) "1.00" ?></strong>
                    </p>
                    <small>
                      <?php if ($rms->price_type == 1){ ?>
                      <input name="room_quantity" type="hidden" value="1" />
                      <p style="line-height:1"> <?=$adults .' '. T::hotels_adults ?> <strong class="d-block"><?=$currency .' '. $adults * $rms->room_adult_price ?></strong></p>
                      <hr>
                      <p style="line-height:1"> <?=$childs .' '. T::hotels_childs ?> <strong class="d-block"><?=$currency .' '. $childs * $rms->room_child_price?></strong></p>
                      <?php } ?>
                    </small>
                  </div>
                </div>
                <div class="col-md-2">
                  <p><strong><?=T::hotels_noofrooms?></strong></p>
                  <div class="">
                    <?php
                      // remove option if price by travellers
                      if ($rms->price_type == 0){
                      if ($rms->quantity == "") { } else { ?>
                    <div>
                      <select name="room_quantity" class="form-select" style="font-size:11px;height:45px">
                        <?php for ($i = 1; $i <= $rms->quantity; $i++){ ?>
                        <option class="" value="<?=$i?>"><?=$i?> - <?=$currency?> <?=$i * $price ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <?php } } ?>
                  </div>
                  <div class="col-md-3 booked_<?=$rms->id?>">
                    <p><strong>&nbsp;</strong></p>
                    <?php
                      if (isset($hotel->hotel_phone)) { $hotel_phone = $hotel->hotel_phone; } else { $hotel_phone = ""; }
                      if (isset($hotel->hotel_email)) { $hotel_email = $hotel->hotel_email; } else { $hotel_email = ""; }
                      if (isset($hotel->hotel_website)) { $hotel_website = $hotel->hotel_website; } else { $hotel_website = ""; }
                      
                      // $price = number_format( $rms->price,2);
                      $real_price = number_format( $rms->real_price,2);
                      
                      // to fix hotel image bug
                      if (isset($hotel_img)){ $hotel_img = $hotel_img; } else { $hotel_img ="";  }
                      
                      // take travellers from session
                      if ($rms->price_type == "1"){
                          $adults_numb = $adults;
                          $childs_numb = $childs;
                      } else {
                          $adults_numb = $adults;
                          $childs_numb = $childs;
                      
                      }
                      
                      if (!empty($rms->cancellation_info)) { $cancellation_policy = $rms->cancellation_info; }
                      else { $cancellation_policy = ""; }
                      
                      $payload = [
                      "supplier_name" => $hotel->supplier_name,
                      "hotel_id" => $hotel->id,
                      "hotel_name" => $hotel->name,
                      "hotel_img" => $hotel_img,
                      "hotel_address" => $hotel->location . "&nbsp;" . $hotel->address,
                      "hotel_stars" => $hotel->stars,
                      "room_id" => $room->id,
                      "room_type" => $room->name,
                      "currency" => $currency,
                      "room_price" => $price,
                      "real_price" => $real_price,
                      "checkin" => $checkin,
                      "checkout" => $checkout,
                      "adults" => $adults_numb,
                      "childs" => $childs_numb,
                      "supplier" => $supplier,
                      "nationality" => $nationality,
                      "tax_type" => $hotel->tax_type,
                      "tax" => $hotel->tax_amount,
                      "deposit_type" => $hotel->deposit_type,
                      "deposit_amount" => $hotel->deposit_amount,
                      "country_code" => $country_code,
                      "city_code" => $city_code,
                      "city_name" => $city,
                      "latitude" => $hotel->latitude,
                      "longitude" => $hotel->longitude,
                      "bookingKey" => $rms->bookingKey,
                      "hotel_phone" => $hotel_phone,
                      "hotel_email" => $hotel_email,
                      "hotel_website" => $hotel_website,
                      "children_ages" => $rms->children_ages,
                      "cancellation_policy" => $cancellation_policy,
                      "room_data" => $room->options[0]->room_data,
                      "actual_currency" => $room->actual_currency,
                      "actual_price" => $room->real_price,
                      ];
                      ?>
                    <?php
                      // CHECK ROOM AVAILABILITY
                      if ($rms->room_booked == 1) { ?>
                    <i style="font-size: 33px; position: absolute; margin-top: -70px;" class="la la-calendar"></i>
                    <?=T::booked_on_dates?>
                    <style>
                      .booked_<?=$rms->id?>{background: #f5f7fc; color: #0d6efd; margin-top: 28px; display: flex; justify-content: center; align-items: center; font-size: 12px; font-weight: bold; text-transform: uppercase;}
                    </style>
                    <?php } else { ?>
                    <small>
                      <?php if ($rms->price_type == 1){ ?>
                      <input name="room_quantity" type="hidden" value="1" />
                      <p style="line-height:1"> <?=$adults .' '. T::hotels_adults ?> <strong class="d-block"><?=$currency .' '. $adults * $rms->room_adult_price ?></strong></p>
                      <hr>
                      <p style="line-height:1"> <?=$childs .' '. T::hotels_childs ?> <strong class="d-block"><?=$currency .' '. $childs * $rms->room_child_price?></strong></p>
                      <?php } ?>
                    </small>
                  </div>
                </div>
                <input name="payload" type="hidden" value="<?php echo base64_encode(json_encode($payload)) ?>">
                <div class="col">
                  <div class="">
                    <p class="mb-0"><strong>&nbsp;</strong></p>
                    <?php if (isset($_SESSION['user_login']) == true OR $app->app->restrict_website == false ) { ?>
                    <button type="submit" class="effect ladda effect" data-style="zoom-in">
                    <span class="ladda-label"><i class="la la-basket"></i> <?=T::booknow?></span>
                    </button>
                    <?php } else { ?>
                    <a href="<?=root?>login" class="effect ladda effect d-grid gap-2 text-center">
                    <span class="ladda-label"><i class="la la-basket"></i> <?=T::login_to_book?></span>
                    </a>
                    <p><small style="display: inline-block; line-height: 18px; font-size: 10px;" class="text-danger"><?=T::only_registered_users_book?></small></p>
                    <?php } ?>
                    <style>
                      .break { flex-basis: 100%; height: 0; }
                    </style>
                    <!--<div class="custom-checkbox mt-4">
                      <input type="checkbox" id="select">
                      <label for="select" class=""><?=T::select?></label>
                      </div>-->
                  </div>
                  <?php } ?>
                  <?php
                    if (!empty($room->refundable)) {
                    if ($room->refundable == "Yes" ) { ?>
                  <div class="break"></div>
                  <div class="py-2" style="display:flex;font-size: 12px;justify-content: space-between;font-weight: bold;flex-wrap: wrap;">
                    <p class="text-success"><i class="la la-refresh me-2"></i> <?=T::refundable?></p>
                    &nbsp;&nbsp;
                    <p><i class="fa fa-clock"></i> <?=$room->refundable_date?></p>
                  </div>
                  <?php } } ?>
                </div>
              </div>
          </div>
          <?php } ?>
          </form>
        </div>
      </div>
      <?php // CANCELLATION POLICY
        if (!empty($rms->cancellation_info)) {
        ?>
      <div class="alert alert-danger p-3 mt-2" style="font-size: 14px; line-height: normal;">
        <p><strong><?=T::cancelpolicy?></strong></p>
        <p> <?=$rms->cancellation_info?> </p>
      </div>
      <?php } ?>
    </div>
    <!-- end cabin-type -->
  </div>
  <!-- end cabin-type -->
  <?php } ?>
 
<!-- end single-content-item -->
<div class="section-block"></div>
</div><!-- end location-map -->
<?php } else { ?>
<div class="card-body alert-danger mt-5" role="alert">
  <p><i class="la la-info-circle"></i> <?=T::noroomsavailabletrydifferentdates?></p>
</div>
<?php require_once 'search.php';?>
<?php } ?>
 
