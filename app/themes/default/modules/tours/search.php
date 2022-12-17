<form id="tours-search" method="post">
    <div class="main_search contact-form-action">
        <div class="row g-1">
            <div class="col-md-5">
                <div class="input-wrapper">
                    <span class="label-text"><?=T::tours_destination?></span>
                    <div class="form-group">
                        <span class="la la-map-marker form-icon"></span>
                        <div class="input-items">
                        <select id="tours_city" name="city" class="city form-control" required>
                        <?php if(isset($_SESSION['tours_location'])){ ?>
                        <option value="<?=$_SESSION['tours_location']; ?>"> <?= str_replace("-", " ", $_SESSION['tours_location']); ?></option>
                        <?php } else { ?>
                        <option value=""> <?=T::searchbycity?></option>
                        <?php } ?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row g-0 items-center">
                    <div class="col-md-12">
                        <span class="label-text"><?=T::date?></span>
                        <div class="form-group">
                        <span class="la la-calendar form-icon"></span>
                        <input name="checkin" class="dp form-control form-control-lg" id="date" type="text" placeholder="" value="<?php if(isset($_SESSION['tours_date'])){ echo $_SESSION['tours_date']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?>" readonly="readonly"/>
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
                        <a class="dropdown-toggle dropdown-btn travellers" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <p><?=T::travellers?> <span class="guest_tours"></span></p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-wrap">
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-user"></i> <?=T::adults?> <!--<small>(+12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="adults" id="tours_adults" value="<?php if(isset($_SESSION['tours_adults'])){ echo $_SESSION['tours_adults']; } else { echo "1"; } ?>" class="qtyInput_tours">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-female"></i> <?=T::child?>  <!--<small>(-12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="childs" id="tours_child" value="<?php if(isset($_SESSION['tours_childs'])){ echo $_SESSION['tours_childs']; } else { echo "0"; } ?>" class="qtyInput_tours">
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
                 <button type="submit" id="submit" class="more_details w-100 btn-lg effect" data-style="zoom-in">
                 <svg style="fill:currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="c8LPF-icon" role="img" height="24" cleanup=""><path d="M174.973 150.594l-29.406-29.406c5.794-9.945 9.171-21.482 9.171-33.819C154.737 50.164 124.573 20 87.368 20S20 50.164 20 87.368s30.164 67.368 67.368 67.368c12.345 0 23.874-3.377 33.827-9.171l29.406 29.406c6.703 6.703 17.667 6.703 24.371 0c6.704-6.702 6.704-17.674.001-24.377zM36.842 87.36c0-27.857 22.669-50.526 50.526-50.526s50.526 22.669 50.526 50.526s-22.669 50.526-50.526 50.526s-50.526-22.669-50.526-50.526z"></path></svg>
                <!-- <i class="mdi mdi-search"></i> <?=T::search?> -->
                </button>
             </div>
            </div>
        </div>
    </div>
</form>

<script>

// collecting params to send for beutified URI
$("#tours-search").submit(function() {
event.preventDefault();
var city = $('#tours_city').val().toLowerCase();
var date = $('#date').val();
var language = $('#language').val();
var tours_adults = $('#tours_adults').val();
var tours_child = $('#tours_child').val();
var pagination = $('#pagination').val();
var city_trims = city.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var actionURL = '<?=tours?>/' + '<?=strtolower($session_lang);?>' +'/'+ '<?=strtolower($session_currency);?>' +'/';
var finelURL = actionURL + city_trims+'/'+date+'/'+tours_adults+'/'+tours_child;

/* append in search box */
$('.cityname').append(city);
$('.d').append(date);
$('.a').append(tours_adults);
$('.c').append(tours_child);

// BACK TOP
$("html, body").animate({ scrollTop: 0 }, "fast");

/* final call to URI */
window.location.href = '<?=root?>'+finelURL;
$('#loading').modal('show'); 

// SIDEBAR SMALLER
$(".menu-sidebar").addClass("sidebar-small").fadeIn(100);

});

</script>