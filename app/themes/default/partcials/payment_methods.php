<div class="form-box">
<div class="form-title-wrap">
    <h3 class="title"><?=T::paymentmethod?></h3>
</div><!-- form-title-wrap -->
<div class="form-content">
    <div class="section-tab check-mark-tab text-center pb-4">
        <ul class="nav nav-tabs gateways row" id="myTab" role="tablist">

        <?php

        $gateways = array_reverse($app->payment_gateways);

        // loop for available payment gateways fetched from session
        foreach ($gateways as $items => $item){

        // hide wallet balance payment option if user is not logged in
        if(!isset($_SESSION['user_login']) == true) { echo "<style>.gateway_wallet-balance{display:none}</style>"; }

        // ACTIVE CLASS FOR COLUMN OF GATEWAY
        if ($items == 0) { $checked = "checked"; }

        // dd($app->payment_gateways);
        // echo $items;

        ?>

        <label style="width:100%" class="form-check-label" for="gateway_<?=$item->title ?>">

        <div class="col-md-12 mb-1 gateway_<?=$item->title ?>">
        <div class="form-check nav-link p-2 px-3 m-1 d-flex" style="justify-content: space-between;border-radius: 4px !important;">

        <div class="d-flex mb-2 input" style="gap: 16px; align-items: center;">
        <input <?=$checked?> class="form-check-input mx-auto" type="radio" name="payment_gateway" id="gateway_<?=$item->title ?>" value="<?=$item->title ?>" required>
        <span class="d-block pt-2"><?php if ($item->title == "pay-later") { } else { ?><?=T::paywith?> <?php } ?> <strong><?=str_replace('-', ' ', $item->title)?></strong></span>
        </div>

        <div class="d-block">
        <img src="<?=root.theme_url?>assets/img/gateways/<?=$item->title ?>.png" style="max-height:40px;background:transparent" alt="<?=$item->title ?>">
        </div>
        </label>
        </div>
        </div>
        <?php } ?>

        </ul>
    </div><!-- end section-tab -->
    <!--<div class="tab-content">
        <div class="tab-pane fade show active" id="credit-card" role="tabpanel" aria-labelledby="credit-card-tab">
            <div class="contact-form-action">
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Card Holder Name</label>
                                <div class="form-group">
                                    <span class="la la-credit-card form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="Card holder name">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Card Number</label>
                                <div class="form-group">
                                    <span class="la la-credit-card form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="Card number">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6 responsive-column">
                                    <div class="input-box">
                                        <label class="label-text">Expiry Month</label>
                                        <div class="form-group">
                                            <span class="la la-credit-card form-icon"></span>
                                            <input class="form-control" type="text" name="text" placeholder="MM">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 responsive-column">
                                    <div class="input-box">
                                        <label class="label-text">Expiry Year</label>
                                        <div class="form-group">
                                            <span class="la la-credit-card form-icon"></span>
                                            <input class="form-control" type="text" name="text" placeholder="YY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-box">
                                <label class="label-text">CVV</label>
                                <div class="form-group">
                                    <span class="la la-pencil form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="CVV">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
            <div class="contact-form-action">
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Email Address</label>
                                <div class="form-group">
                                    <span class="la la-envelope form-icon"></span>
                                    <input class="form-control" type="email" name="email" placeholder="Enter email address">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Password</label>
                                <div class="form-group">
                                    <span class="la la-lock form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="btn-box">
                                <button class="theme-btn" type="submit">Login Account</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="payoneer" role="tabpanel" aria-labelledby="payoneer-tab">
            <div class="contact-form-action">
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Email Address</label>
                                <div class="form-group">
                                    <span class="la la-envelope form-icon"></span>
                                    <input class="form-control" type="email" name="email" placeholder="Enter email address">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Password</label>
                                <div class="form-group">
                                    <span class="la la-lock form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="btn-box">
                                <button class="theme-btn" type="submit">Login Account</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>-->
</div>
</div><!-- end form-box -->