<div class="form-content">

<div class="card mt-2 mb-3">
        <div class="card-title px-3 pt-2 strong">
            <?=T::travelerdetails?>  
        </div>
        <div class="card-body">
            <?php
            $travellers = ( json_decode($booking->booking_guest_info));
            foreach ($travellers as $index => $guest ) {
                ?>

                <div class="row">
                    <div class="col-md-6">
                    <ul class="customer">
                <li><span class="text-black font-weight-bold"><?=T::guest?> <?=$index+1?> :</span> <?=$guest->title?> <?=$guest->first_name?> <?=$guest->last_name?> </li>
                <!-- <li><span class="text-black font-weight-bold"><?=T::full_name?> :</span>  <?=$guest->first_name?> <?=$guest->last_name?> </li> -->
                <li><span class="text-black font-weight-bold"><?=T::nationality?> :</span> <?=$guest->nationality?></li>
                <li><span class="text-black font-weight-bold"><?=T::date_of_birth?> :</span> <?=$guest->dob_day?>-<?=$guest->dob_month?>-<?=$guest->dob_year?></li>
                </ul>
                    </div>
                    <div class="col-md-6">
                    <ul class="customer">
                <li><span class="text-black font-weight-bold"><?=T::passport_no?> :</span>  <?=$guest->passport?></li>
                <li><span class="text-black font-weight-bold"><?=T::passport_expiry?> :</span> <?=$guest->passport_day?>-<?=$guest->passport_month?>-<?=$guest->passport_year?></li>
                <li><span class="text-black font-weight-bold"><?=T::passport?> <?=T::issuance_date?> :</span> <?=$guest->passport_issuance_day?>-<?=$guest->passport_issuance_month?>-<?=$guest->passport_issuance_year?></li>
                </ul>
                    </div>
                </div>
                

                <hr>
            <?php } ?>
        </div>
    </div>


<div class="card mb-3">
    <div class="row g-0 p-3">
     <?php require "partcials/flight.php" ?>
    </div>
</div>

    <div class="mb-3">
        <div class="card">
            <div class="card-title px-3 pt-2 strong">
                <?=T::bookingdetails?>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span><strong><?=T::adults?></strong>: <?=$booking->booking_adults?> </span> <span><strong><?=T::child?></strong>: <?=$booking->booking_childs?></span> - <span><strong><?=T::infants?></strong>:</span> <?=$booking->booking_childs?></li>
                <li class="list-group-item"><span><strong><?=T::bookingtax?></strong>:</span> <?=$booking->booking_curr_code?> <?=$booking->booking_tax?></li>
                <li class="list-group-item"><span><strong><?=T::depositnow?> <?=T::price?></strong>:</span> <?=$booking->booking_curr_code?> <?=$booking->booking_deposit?></li>
                <hr style="margin:0">
                <li style="background:#f1f4f8" class="list-group-item"><span class=""><strong><?=T::total?> <?=T::price?></strong>:</span> <?=$booking->booking_curr_code?> <?=$booking->total_price?></li>
            </ul>
        </div>
    </div>

    <div class="btn-box px-1">
    <div class="row g-2">
    <?php if ($booking->booking_cancellation_request == "1") { ?>
     <div class="alert alert-danger"><?=T::cancellationrequestmsg?></div>
    <?php } ?>
    <div class="col-md-4">
        <?php if ($booking->booking_cancellation_request == "0") { ?>
            <form onSubmit="if(!confirm('<?=T::areyousureforcancellationofthisbooking?>')){return false;}" action="<?=root?>flights/cancellation" method="post">
                <input type="hidden" name="booking_no" value="<?=$booking->booking_ref_no?>" />
                <input type="hidden" name="booking_id" value="<?=$booking->booking_id?>" />
                <input type="submit" value="<?=T::requestcancellation?>" class="btn btn-outline-danger btn-block">
            </form>
        <?php } ?>
        <script>
         function show_alert() { if(!confirm("<?=T::thisrequestwillsubmitcancellation?>")) { return false; } this.form.submit(); }
        </script>
        </div>
        <div class="col-md-3 float-right text-right">
        <button class="btn btn-outline-success btn-block text-right" id="download"><i class="la la-print"></i> <?=T::downloadinvoice?></button>
        </div>
        </div>
    </div>
    </div>