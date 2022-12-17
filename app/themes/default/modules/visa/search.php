<form id="visa-submit" method="post">
    <div class="main_search contact-form-action">
        <div class="row g-1">
            <div class="col-md-4">
                <div class="input-wrapper">
                    <span class="label-text"><?=T::fromcountry?></span>
                    <div class="form-group">
                        <span class="la la-flag form-icon"></span>
                        <div class="input-items">
                        <select id="from_country" name="city" class="select_ form-control" required>
                            <option value=""><?=T::selectcountry?></option>
                            <?= countries_list();?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-wrapper">
                    <span class="label-text"><?=T::tocountry?></span>
                    <div class="form-group">
                        <span class="la la-flag form-icon"></span>
                        <div class="input-items">
                        <select id="to_country" name="city" class="select_ form-control" required>
                            <option value=""><?=T::selectcountry?></option>
                            <?= countries_list();?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <span class="label-text"><?=T::date?></span>
                <div class="form-group">
                <span class="la la-calendar form-icon"></span>
                <input name="checkin" class="dp form-control form-control-lg" id="date" type="text" placeholder="" value="<?php $d=strtotime("+10 Days"); echo date("d-m-Y", $d);?>" readonly="readonly"/>
                </div>
            </div>
            <div class="col-md-1">
             <div class="btn-search text-center">
              <button type="submit" id="submit" class="more_details w-100 btn-lg effect" data-style="zoom-in">
                <!-- <i class="mdi mdi-search"></i> <?=T::submit?> -->
                <svg style="fill:currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="c8LPF-icon" role="img" height="24" cleanup=""><path d="M174.973 150.594l-29.406-29.406c5.794-9.945 9.171-21.482 9.171-33.819C154.737 50.164 124.573 20 87.368 20S20 50.164 20 87.368s30.164 67.368 67.368 67.368c12.345 0 23.874-3.377 33.827-9.171l29.406 29.406c6.703 6.703 17.667 6.703 24.371 0c6.704-6.702 6.704-17.674.001-24.377zM36.842 87.36c0-27.857 22.669-50.526 50.526-50.526s50.526 22.669 50.526 50.526s-22.669 50.526-50.526 50.526s-50.526-22.669-50.526-50.526z"></path></svg>
            </button>
             </div>
            </div>
        </div>
    </div>
</form>

<script>
// visa submit
$("#visa-submit").submit(function() {
event.preventDefault();
var from_co = $('#from_country').val().toLowerCase();
var to_co = $('#to_country').val().toLowerCase();
var date = $('#date').val();
var from_c = from_co.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var to_c = to_co.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var finelURL = '<?=visa?>'+'/'+'submit'+'/'+from_c+'/'+ to_c+'/'+date;

// BACK TOP
$("html, body").animate({ scrollTop: 0 }, "fast");

// alert(finelURL);
window.location.href = '<?=root?>'+finelURL; });
</script>