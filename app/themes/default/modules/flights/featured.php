<div class="container">

<section class="round-trip-flight section--padding featured_flights mb-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2 class="sec__title line-height-55"><?=T::flights_featured_flights?></h2>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row padding-top-0px">
            <div class="col-lg-12">

                <div class="popular-round-trip-wrap padding-top-10px">
                    <div class="tab-content" id="myTabContent4">
                        <div class="tab-pane fade show active" id="new-york" role="tabpanel" aria-labelledby="new-york-tab">
                            <div class="row g-3 mb-1">

                            <?php 
                            
                            use Curl\Curl;

                            foreach ($app->featured_flights as $flights){ {

                            $from = explode(" ", $flights->from);
                            $froms = end($from);

                            $to = explode(" ", $flights->to);
                            $tos = end($to);

                            // get flights codes
                            $from_code = explode(' ',trim($flights->from));
                            $to_code = explode(' ',trim($flights->to));

                            ?>

                            <script>

                            $.ajax({
                            type: "GET",
                            url: "https://www.kayak.com/mvm/smartyv2/search?f=j&s=airportonly&where=<?=strtolower($from_code[0])?>",
                            cache: false,
                            success: function(data){
                            // console.log(data[0].destination_images.image_jpeg)

                            if (typeof data[0].destination_images !== 'undefined') {
                            // the variable is defined
                            // console.log(1)

                            var flight_bg = data[0].destination_images.image_jpeg;

                            } else { 
                                var flight_bg = "./app/themes/default/assets/img/data/tour.jpg";
                            }
                                $('.featured_flight_<?=$flights->id?>').append('<img style="max-width:135px" class="img-fluid" src='+flight_bg+' />').hide().fadeIn(500);
                            }
                            });

                            </script>

                            <div class="col-lg-4 responsive-column">
                            <a href="<?=root?>flights/<?=$_SESSION['session_lang']?>/<?=strtolower($currency)?>/<?=strtolower($from_code[0])?>/<?=strtolower($to_code[0])?>/oneway/economy/<?php $d=strtotime("+5 Days"); echo date("d-m-Y", $d);?>/1/0/0">
                                    <div class="deal-card">
                                    <div class="row" style="display: flex; justify-content: center; align-items: center;    width: 100%;">
                                        <div class="col-5" style="background: #ffff; border-radius: 3px;">
                                        <div class="deal-title d-flex align-items-center">
                                        <div class="clear featured_flight_<?=$flights->id?>"></div>
                                        <!--  IMG -->
                                        </div>
                                        </div>
                                        <div class="col-7">
                                        <h6><?=$flights->title?></h6>
                                        <hr>
                                        <h3 class="deal__title"><?=$froms?> <i class="la la-arrow-right mx-2"></i> <?=$tos?></h3>
                                        <div class="deal-action-box d-flex align-items-center justify-content-between pt-1">
                                        <div class="price-box d-flex align-items-center"><span class="price__from mr-1"><?=T::from?></span><span class="price__num"><?=$session_currency?> <?=$flights->price?></span></div>

                                        <img data-src="<?=$flights->thumbnail?>" alt="air-line-img" class="lazyload" style="max-width: 50px;">
                                        
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                   </a>
                                   <div class="clear"></div>
                                </div>

                                <?php } } ?>

                            </div>
                        </div><!-- end tab-pane -->
                    </div><!-- end tab-content -->
                    <div class="tab-content-info d-flex justify-content-between align-items-center">
                        <!-- <p class="font-size-15"><i class="la la-question-circle mr-1"></i>Average round-trip price per person, taxes and fees included.</p> -->
                        <!--<a href="http://localhost/v8/flights" class="btn-text font-size-15">Top Rated Tours <i class="la la-angle-right"></i></a>-->
                    </div><!-- end tab-content-info -->
                </div>
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
</section>

</div><!-- end container -->
