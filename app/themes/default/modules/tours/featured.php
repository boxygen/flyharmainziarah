<!-- ================================
START DESTINATION AREA
================================= -->
<section class="destination-area section--padding pt-0 pb-5">
<div class="container">
<div class="featured_tours">
<div class="row align-items-center">
<div class="col-lg-8">
<div class="section-heading">
<h2 class="sec__title_left" style="font-size:22px"><?=T::tours_featured_tours?></h2>
<!--<p class="sec__desc pt-3">Morbi convallis bibendum urna ut viverra Maecenas quis</p> -->
</div><!-- end section-heading -->
</div><!-- end col-lg-8 -->
<div class="col-lg-4">
<!--<div class="btn-box btn--box text-right">
 <a href="<?=root?>tours" class="theme-btn"><?=T::tours_view_more_tours?></a>
</div>-->
</div>
</div><!-- end row -->

<div class="row">
    <div class="col-md-6">
<div class="row padding-top-50px">
<?php 

foreach($app->featured_tours as $item){
$name = str_replace(' ', '-', $item->title);
$link = root.'tour/'.$session_lang.'/'.strtolower($currency).'/'.strtolower(str_replace(' ', '-', $item->location)).'/'.strtolower(str_replace(" ", "-", $item->title)).'/'.$item->id.'/'.date('d-m-Y',strtotime('+3 day')).'/1/1/0'; ?>

<div class="col-lg-6">
<a href="<?=$link?>">
    <div class="card-item destination-card mb-2">
        <div class="card-img">
            <img data-src="<?=$item->thumbnail?>" class="lazyload" style="height:250px" alt="destination-img">
            <span class="badge" style="background-color: rgb(0 0 0 / 23%);top: 10px; left: 10px; padding: 10px; font-size: 12px;"
            ><?=$item->location?></span>
        </div>
    </div>
</a>

<div class="card-body mb-3" style="
    margin-top: -98px;
    z-index: 9999;
    position: relative;
    padding: 15px;
    color: #fff;
    font-size: 13px;
    line-height: 20px;
    background: rgb(0 0 0 / 53%);
    border-radius: 7px;">
    <a href="<?=$link?>" style="color:#fff">
            <span class="ratings d-flex align-items-center mr-1">
                <?php for ($i = 1; $i <= $item->starsCount; $i++) { ?>
                <small class="stars la la-star-o text-light"></small>
                <?php } ?>
                <span class="rating__text cw"> <small>( <?=$item->avgReviews->overall?> )</small></span>
                </span>
            <p class="card-title"><?=$item->title?></p>
            <p>
            <?php if($item->price > 0){ ?>
                <p>
                    <span class="price__from"><?=T::price?></span>
                    <span class="price__num"><strong><?=$currency?> <?php echo $item->price?></strong></span>
                </p>
                <?php } ?>
            </p>
            <div class="card-rating d-flex align-items-center">
            </div>
        </div>
    </a>
</div>

<?php } ?>
</div><!-- end row -->

    </div>
    <div class="col-md-6">
        <div class="row padding-top-50px">
                <div class="card-img">
                      <img src="<?=root?>app/themes/default/assets/img/tours.jpg" class="img-fluid" alt="tours" style="width:100%;border-top-left-radius: 5px; border-top-right-radius: 5px;">
                      <div style="background: #ffffff; border: 1px solid #eeeeee; display: flex; justify-content: space-between; padding: 55px 28px; align-items: center; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                      
                      <?=T::tours_findbesttours?>

                    <a href="<?=root?>tours" class="btn btn-dark">
                       <?=T::tours_view_more_tours?>
                    </a>
                      </div>
                </div>
        </div>
    </div>
</div>

</div> 
</div><!-- end container -->
</section><!-- end destination-area -->
<!-- ================================
END DESTINATION AREA
================================= -->