<form id="hotels-search" method="post">
    <div class="main_search contact-form-action">
        <div class="row g-1">
            <div class="col-md-4">
                <div class="input-wrapper">
                    <span class="label-text"><?=T::hotels_cityname?></span>
                    <div class="form-group">
                        <span class="la la-map-marker form-icon"></span>
                        <div class="input-items">
                            <select id="hotels_city" name="city" class="city form-control" required>
                                <?php if(isset($_SESSION['hotels_location'])){ ?>
                                <option value="<?=$_SESSION['hotels_location']; ?>">
                                    <?= str_replace("-", " ", $_SESSION['hotels_location']); ?></option>
                                <?php } else { ?>
                                <option value=""> <?=T::searchbycity?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row g-0 items-center">
                    <div class="col-md-6">
                        <span class="label-text"><?=T::hotels_checkin?></span>
                        <div class="form-group">
                            <span class="la la-calendar form-icon"></span>
                            <input name="checkin" class="checkin form-control form-control-lg border-top-r0"
                                id="checkin" type="text" placeholder=""
                                value="<?php if(isset($_SESSION['hotels_checkin'])){ echo $_SESSION['hotels_checkin']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?>"
                                readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="label-text"><?=T::hotels_checkout?></span>
                        <div class="form-group">
                            <span class="la la-calendar form-icon"></span>
                            <input name="checkout" class="checkout form-control form-control-lg border-top-l0"
                                id="checkout" type="text" placeholder=""
                                value="<?php if(isset($_SESSION['hotels_checkout'])){ echo $_SESSION['hotels_checkout']; } else { $d=strtotime("+4 Days"); echo date("d-m-Y", $d); } ?>"
                                readonly="readonly" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-box">
                    <label class="label-text"><?=T::travellers?></label>
                    <div class="form-group">
                        <span class="la la-male form-icon"></span>
                        <div class="dropdown dropdown-contain">
                            <a class="dropdown-toggle dropdown-btn travellers" href="#" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <p><?=T::travellers?> <span class="guest_hotels"></span>
                                    <span><?=T::hotels_rooms?> <span class="roomTotal">0</span></span>
                                </p>
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-wrap">
                                <div class="dropdown-item">
                                    <div class="roomBtn d-flex align-items-center justify-content-between">
                                        <label>
                                            <i class="la la-bed"></i> <?=T::hotels_rooms?>
                                            <!--<small>(-12)</small>-->
                                        </label>
                                        <div class="qtyBtn d-flex align-items-center">
                                            <input type="text" name="roomInput" id="rooms"
                                                value="<?php if(isset($_SESSION['hotels_rooms'])){ echo $_SESSION['hotels_rooms']; } else { echo "1"; } ?>"
                                                class="">
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                        <label>
                                            <i class="la la-user"></i> <?=T::hotels_adults?>
                                            <!--<small>(+12)</small>-->
                                        </label>
                                        <div class="qtyBtn d-flex align-items-center">
                                            <input type="text" name="adults" id="adults"
                                                value="<?php if(isset($_SESSION['hotels_adults'])){ echo $_SESSION['hotels_adults']; } else { echo "2"; } ?>"
                                                class="qtyInput_hotels">
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                        <label>
                                            <i class="la la-female"></i> <?=T::hotels_childs?>
                                            <!--<small>(-12)</small>-->
                                        </label>

                                        <div class="qtyBtn d-flex align-items-center child_ages">
                                            <input type="text" name="childs" id="childs"
                                                value="<?php if(isset($_SESSION['hotels_childs'])){ echo $_SESSION['hotels_childs']; } else { echo "0"; } ?>"
                                                class="qtyInput_hotels">
                                        </div>
                                    </div>
                                </div>

                                <ol class="row g-1 m-0 p-1" id="append">

                                    <?php
                                    if (isset($_SESSION['ages'])) {
                                    $ages = json_decode($_SESSION['ages']);
                                    // dd($ages);
                                    foreach ($ages as $key => $val) {
                                    ?>

                                    <li class="col px-2" id="child_ages">
                                        <div class="dropdown-item p-2" style="margin-top:-36px">
                                            <p style="color:#000"><small> <strong class="px-2"> <?=T::child?> <?=T::age?></strong></small></p>
                                            <div class="form-group"> <span class="la la-child select form-icon"></span>
                                                <div class="input-items">
                                                    <select onchange="show_values(`<?=$key+1?>`);" class="form-select child_<?=$key+1?>" id="ages<?=$key+1?>" name="ages[<?=$key+1?>]">
                                                        <option value="0" selected disabled>0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } } ?>

                                </ol>

                                <?php
                                if (isset($_SESSION['ages'])) {
                                $ages = json_decode($_SESSION['ages']);
                                // dd($ages);
                                foreach ($ages as $key => $val) {?>

                                <script>
                                $('.child_<?=$key+1?> option[value=<?=$val->ages?>]')
                                .attr('selected', 'selected');
                                </script>
                                <?php } } ?>

                                <div class="dropdown-item">
                                    <p style="color:#000"><small><strong><?=T::nationality?></strong></small></p>
                                    <div class="form-group">
                                        <span class="la la-globe select form-icon"></span>
                                        <div class="input-items">
                                            <select style="background-color:#e9eef2" class="form-select nationality"
                                                id="nationality">
                                                <?=countries_list();?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end dropdown -->
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="btn-search text-center">
                    <button type="submit" id="submit" class="more_details effect btn btn-primary btn-block btn-lg" data-style="zoom-in">
                        <!-- <i class="mdi mdi-search"></i> <?=T::search?> -->
                        <svg style="fill:currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="c8LPF-icon" role="img" height="24" cleanup=""><path d="M174.973 150.594l-29.406-29.406c5.794-9.945 9.171-21.482 9.171-33.819C154.737 50.164 124.573 20 87.368 20S20 50.164 20 87.368s30.164 67.368 67.368 67.368c12.345 0 23.874-3.377 33.827-9.171l29.406 29.406c6.703 6.703 17.667 6.703 24.371 0c6.704-6.702 6.704-17.674.001-24.377zM36.842 87.36c0-27.857 22.669-50.526 50.526-50.526s50.526 22.669 50.526 50.526s-22.669 50.526-50.526 50.526s-50.526-22.669-50.526-50.526z"></path></svg>
                    </button>
                    <!--<label for="nearby" class="direct f-right btn m"><input type="checkbox" id="nearby" class="mr-10"><small><?=T::hotels_nearbyme; ?></small> </label> -->
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="form-control" name="language" id="language" value="<?=strtolower($session_lang);?>">
</form>

<script>
var child_age = "<?=T::child_age?>";

// collecting params to send for beutified URI
$("#hotels-search").submit(function() {
    event.preventDefault();
    var city = $('#hotels_city').val().toLowerCase();
    var checkin = $('#checkin').val();
    var checkout = $('#checkout').val();
    var rooms = $('#rooms').val();
    var nationality = $('#nationality').val();
    var language = $('#language').val();
    var adults = $('#adults').val();
    var child = $('#childs').val();
    var room = $('#room').val();
    var pagination = $('#pagination').val();
    var city_trims = city.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
    var actionURL = '<?=hotels?>/' + language + '/' + '<?=strtolower($session_currency);?>' + '/';

    // REMOVE - DASH FROM END OF THE CITY
    if(city_trims.slice(-1) == '-') { var city_ = city_trims.slice(0, -1);
    } else { var city_ = city_trims; }

    var finelURL = actionURL + city_ + '/' + checkin + '/' + checkout + '/' + rooms + '/' + adults + '/' + child + '/' + nationality;

    /* append in search box */
    $('.cityname').append(city_);
    $('.ci').append(checkin);
    $('.co').append(checkout);
    $('.a').append(adults);
    $('.c').append(child);
    $('.r').append(rooms);

    // PAGE TOP
    $("html, body").animate({ scrollTop: 0 }, "fast");

    /* final call to URI */
    window.location.href = '<?=root?>' + finelURL;
    $('#loading').modal('show');

    // SIDEBAR SMALLER
    $(".menu-sidebar").addClass("sidebar-small").fadeIn(100);
});

// get users country
var requestUrl = "https://ipwhois.app/json/";
fetch(requestUrl)
.then(function(response) { return response.json(); })
.then(function(c) {

var user_country = c['country_code'];

if( typeof user_country !== 'undefined' ) {
    console.log(user_country);

    <?php if(isset($_SESSION['hotels_nationality'])){ ?>
    $('.nationality option[value=<?php if(isset($_SESSION['hotels_nationality'])){ echo $_SESSION['hotels_nationality']; } ?>]').attr('selected', 'selected');
    <?php } else { ?>
    $('.nationality option[value='+user_country+']').attr('selected', 'selected');
    <?php } ?>

} else {
    user_country = 'US';
    console.log(user_country);

    <?php if(isset($_SESSION['hotels_nationality'])){ ?>
    $('.nationality option[value=<?php if(isset($_SESSION['hotels_nationality'])){ echo $_SESSION['hotels_nationality']; } ?>]').attr('selected', 'selected');
    <?php } else { ?>
    $('.nationality option[value='+user_country+']').attr('selected', 'selected');
    <?php } ?>
}

});

</script>

<style>
::marker {
    color: #0d6efd;
    font-size: 1em;
    font-weight: bold;
}

ol {
    list-style-position: inside;
    padding: 0;
}
</style>