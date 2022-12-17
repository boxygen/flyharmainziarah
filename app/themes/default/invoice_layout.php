<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>

<?php
// dd($booking);

// IF INVOICE ID OR DATA IS WRONG
if (empty($booking)) {echo "<style>header{display:none;}</style><p style='display:flex;justify-content:center;height:100vh;align-items:center;'><strong>Invoice ID or Number is Wrong!</strong></p>"; die; }

// payment status
if ($booking->booking_payment_status == "unpaid" ) { $payment_status = T::unpaid; }
if ($booking->booking_payment_status == "paid" ) { $payment_status = T::paid; }
if ($booking->booking_payment_status == "cancelled" ) { $payment_status = T::cancelled; }
if ($booking->booking_payment_status == "disputed" ) { $payment_status = T::disputed; }

// booking status
if ($booking->booking_status == "pending" ) { $booking_status = T::pending; }
if ($booking->booking_status == "confirmed" ) { $booking_status = T::confirmed; }
if ($booking->booking_status == "cancelled" ) { $booking_status = T::cancelled; }

?>
    <section class="payment-area section-bg section-padding pt-4">
        <div class="container">
            <div class="row">
            <div>
                <div class="col-lg-8 mx-auto print" id="">

                    <?php if ($booking->booking_payment_gateway == "pay-later"){ ?>
                        <div class="infobox infobox-warning">
                            <span><i class="la la-clock"></i></span><?=T::yourbookingstatusis?> ( <strong><?=T::pending?></strong> ) <?=T::andpaymentstatusis?> <strong class="ttc"><?=str_replace('-', ' ', $booking->booking_payment_gateway);?></strong> ( <?=T::unpaid?> )
                        </div>
                    <?php } else { ?>

                        <?php if ($booking->booking_status == "pending") {?>
                            <div class="infobox infobox-danger">
                                <span><i class="la la-clock"></i></span><?=T::yourbookingstatusis?> ( <strong><?=$booking_status?></strong> ) <?=T::andpaymentstatusis?> <strong class="ttc"><?=str_replace('-', ' ', $booking->booking_payment_gateway);?></strong> ( <?=$payment_status?> )
                            </div>
                        <?php } ?>

                        <?php if ($booking->booking_status == "cancelled") {?>
                            <div class="infobox infobox-danger">
                                <span><i class="la la-thumbs-down"></i></span><?=T::yourbookingstatusis?> ( <strong><?=$booking_status?></strong> ) <?=T::andpaymentstatusis?> <strong class="ttc"><?=str_replace('-', ' ', $booking->booking_payment_gateway);?></strong> ( <?=$payment_status?> )
                            </div>
                        <?php } ?>

                        <?php if ($booking->booking_status == "confirmed") {?>
                            <div class="infobox infobox-success">
                                <span><i class="la la-thumbs-up"></i></span><?=T::yourbookingstatusis?> ( <strong> <?=$booking_status?> </strong> ) <?=T::andpaymentstatusis?> <strong class="ttc"><?=str_replace('-', ' ', $booking->booking_payment_gateway);?></strong> ( <?=$payment_status?> )
                            </div>
                        <?php } ?>

                        <?php if ($booking->booking_payment_status == "paid"  ) {} else { ?>
                            <div class="form-box payment-received-wrap mb-2">
                                <div class="form-title-wrap">
                                    <h3 class="title"><?=T::payment?></h3>
                                </div>
                                <div class="card-body mt-3">
                                    <form action="<?=root?>payment" method="post">
                                        <div class="row">
                                            <div class="col-md-2 pt-1"><?=T::paywith?></div>
                                            <div class="col-md-4">
                                                <select style="min-height: 38px!important" class="form-select payment_gateway" name="payment_gateway">
                                                    <?php foreach ($app->payment_gateways as $item){ ?>
                                                    <option <?php if(!isset($_SESSION['user_login']) == true) {  if($item->title =="wallet-balance"){echo "hidden";} } ?>   data="<?=$item->title?>" value="<?=$item->title?>"><?=str_replace('-', ' ', $item->title)?></option>
                                                    <?php } ?>
                                                </select>
                                                <div id="response"></div>
                                            </div>
                                            <div class="col-md-3">

                                                <?php

                                                // CURRENT URL
                                                $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                                                // GET URL
                                                $url = explode('/', $_GET['url']);

                                                if ($url[0] == "hotels") { $price = $booking->booking_deposit; }
                                                if ($url[0] == "flights") { $price = $booking->total_price; }

                                                $price_value = number_format( $booking->booking_remaining,2);
                                                        
                                                $payload = [
                                                'booking_id' => $booking->booking_id,
                                                'booking_no' => $booking->booking_ref_no,
                                                'supplier_name' => $booking->supplier_name,
                                                'status' => 'confirmed',
                                                'amount_paid' => '', 
                                                'remaining_amount' => "",
                                                'payment_date' => date("d-m-Y"),
                                                'txn_id' => '',
                                                'token' => '',
                                                'logs' => '',
                                                'payment_status' => 'paid',
                                                'currency' => $booking->booking_curr_code,
                                                'price' => $price_value,
                                                'desc' => '',
                                                'client_email' => $booking->accounts_email,
                                                'invoice_url' => $link,
                                                'type' => 'invoice',
                                                'booking_module' => $url[0] // name of module for redirection
                                                ];

                                                ?>
                                                <input type="hidden" name="payload" value="<?php echo base64_encode(json_encode($payload)) ?>" />
                                                <input id="form" type="submit" class="btn btn-success btn-block" value="<?=T::proceed?>">
                                            </div>
                                            <div class="col-md-3 pt-1 text-center"><strong class=""><h4><small style="font-weight:300;font-size:16px"><?=$booking->booking_curr_code?></small> <?=number_format( $booking->booking_remaining,2) ?></h4></strong></div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <div class="form-box payment-received-wrap mb-0">
                        <div class="form-title-wrap">
                        <h3 class="title"><?=T::bookinginvoice?>
                            <span class="text-right" style="color:#0d6efd;font-weight:bold"><strong class="text-black mr-1"><?=T::reservationnumber?>:</strong> <?=$booking->booking_ref_no?>-<?=$booking->booking_id?>
                                <?php if (isset($booking->booking_pnr)) {?>
                                    <?php if (!empty($booking->booking_pnr)) {?>
                                        <strong class="text-black mr-1"> PNR :</strong> <?=$booking->booking_pnr?>
                                    <?php } ?>
                                <?php } ?>
                            </span>
                        </h3>
                        </div>
                        <div class="form-content pb-0">
                        <div class="payment-received-list">
                            <!-- <div class="d-flex align-items-center mb-4">
                            <i class="la la-check icon-element flex-shrink-0 mr-3 ml-0"></i>
                                <div class="mx-2">
                                    <h3 class="title pb-1"><?=T::thanks?> <small><?=$booking->ai_first_name ?> <?=$booking->ai_last_name ?></small></h3>
                                    <h3 class="title"> <?=T::yourbookingfor?> <?php //$booking->hotel_name?></h3>
                                </div>
                            </div> -->
                            <div class="card mt-2 mb-0">
                                <div class="card-body">
                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <ul class="customer">
                                                <li><span class="text-black font-weight-bold"><?=T::firstname?>:</span> <?=$booking->ai_first_name ?></li>
                                                <li><span class="text-black font-weight-bold"><?=T::lastname?>:</span> <?=$booking->ai_last_name ?></li>
                                                <li><span class="text-black font-weight-bold"><?=T::email?>:</span> <?=$booking->accounts_email ?></li>
                                                <li><span class="text-black font-weight-bold"><?=T::phone?>:</span> <?=$booking->ai_mobile ?></li>
                                                <li><span class="text-black font-weight-bold"><?=T::address?>:</span> <?=$booking->ai_address_1 ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="customer">
                                                <li><strong><?=T::company?>:</strong> <?=$app->app->appname?></li>
                                                <li><span class="text-black font-weight-bold"><?=T::email?>:</span> <?=$app->app->email?></li>
                                                <li><span class="text-black font-weight-bold"><?=T::phone?>:</span> <?=$app->app->phone?></li>
                                                <li><span class="text-black font-weight-bold"><?=T::address?>:</span></li>
                                                <li><?=strip_tags($app->app->address)?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        <!--  invoice view  -->
                        <?php include $invoice; ?>
                    </div>

                <?php // CANCELLATION POLICY 
                 if (!empty($booking->cancellation_policy)) { 
                 if (!empty($booking->after_booking_policy)) { 
                ?>
                <div class="alert alert-danger p-3 mt-2" style="font-size: 14px; line-height: normal;">
                    <p><strong><?=T::cancelpolicy?></strong></p>
                    <p> <?php if (isset($booking->cancellation_policy)) { echo $booking->cancellation_policy; } ?> </p>
                    <hr>
                    <p> <?php if (isset($booking->after_booking_policy)) { echo strip_tags($booking->after_booking_policy); } ?> </p>
                </div>
                <?php  } } ?>

                </div><!-- end payment-card -->
            </div><!-- end col-lg-12 -->
            </div><!-- end col-lg-12 -->
        </div><!-- end container -->
    </section>


<script>
$('.payment_gateway option[data=<?=$booking->booking_payment_gateway?>]').attr('selected','selected');
</script>

<script>
$('#download').click(function(){
 html2canvas(document.getElementsByClassName("print")[0], { useCORS:true}).then(function (canvas){
        var imgBase64 = canvas.toDataURL();
        console.log("imgBase64:", imgBase64);
        var imgURL = "data:image/" + imgBase64;
        var triggerDownload = $("<a>").attr("href", imgURL).attr("download", "<?=$booking->booking_ref_no?>_<?=$booking->booking_id?>"+".jpg").appendTo("body");
        triggerDownload[0].click();
        triggerDownload.remove();
    });
});
</script>