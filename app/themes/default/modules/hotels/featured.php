<!-- ================================
    START HOTEL AREA
================================= -->
<section class="hotel-area section-bg section-padding overflow-hidden padding-right-100px padding-left-100px pb-5">
    <div class="container">
    <div style="padding: 42px; border-radius: 8px; background:url('') no-repeat right 24px top 4px,radial-gradient(ellipse 30% 26% at 80% 0,rgba(255,233,236,.6),transparent),radial-gradient(ellipse 30% 26% at bottom left,rgba(255,233,236,.6),transparent),#fcf9f6">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2 class="sec__title line-height-55"><?=T::hotels_featured_hotels?></h2>
                </div>
            </div>
        </div>
        <div class="row padding-top-10px">
            <div class="col-lg-12">
                <div class="hotel-card-wrap">
                    <div class="hotel-card-carousel-2 carousel-action">
                    <?php
                    foreach ($app->featured_hotels as $hotels){ {
                    $link = root.'hotel/'.$session_lang.'/'.strtolower($currency).'/'.strtolower(str_replace(' ', '-', $hotels->location)).'/'.strtolower(str_replace(" ", "-", $hotels->title)).'/'.$hotels->id.'/'.date('d-m-Y',strtotime('+3 day')).'/'.date('d-m-Y',strtotime('+4 day')).'/1/2/0/1/IN/IN/0';
                    ?>
                    <div class="card-item mb-0">
                            <div class="card-img">
                                <a href="<?=$link?>" class="d-block">
                                 <img data-src="<?=$hotels->thumbnail?>" class="lazyload" alt="hotel-img" style="height:200px">
                                </a>
                              <span class="badge text-dark"><?php if(!empty($hotels->discount)){echo $hotels->discount;}else{echo "0";} ?> % <strong><?=T::discount?></strong> </span>
                            </div>
                            <div class="card-body">
                                <h6 class=""><a href="<?=$link?>"><strong><?=$hotels->title?></strong></a></h6>
                                <p class="card-meta"><?=$hotels->location?></p>
                                <div class="mb-2">
                                    <span class="">
                                    <?php for ($i = 1; $i <= $hotels->starsCount; $i++) { ?>
                                    <div class="la la-star-o text-danger"></div>
                                    <?php } ?>
                                    </span>
                                </div>
                                <div class="card-price d-flex align-items-center justify-content-between">
                                      <p>
                                        <span class="price__num"><?=$currency?> <strong><?=$hotels->price?></strong></span>
                                        <!-- <span class="price__text"><?=T::price?></span> -->
                                      </p>
                                    <a href="<?=$link?>" class="btn-text"><?=T::details?> <i class="la la-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- ================================
    END HOTEL AREA
================================= -->