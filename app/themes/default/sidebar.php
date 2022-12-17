
    <button class="hide-button-sidebar menu-bar-button" <?php if(isset($menu_active)) { echo 'style="display:none"'; } ?>><i class="la la-bars mx-1"></i></button>
    <button class="show-button-sidebar menu-bar-button" <?php if(isset($menu_active)) { } else { echo 'style="display:none"'; } ?> ><i class="la la-bars mx-1"></i></button>

    <div class="p-2 main-menu sticky-top bg-white" style="top: 60px;">
   

        <!-- <div class="w-100 main-menu-content text">
            <nav class="px-5">
                <ul style="padding-top:10px!important"">
                <li><a href="<?=root;?>" title="home"><?=T::home?></a></li>  
                    <?php foreach ($app->modules as $model){ ?>

                    <?php  if ($model->status == true && $model->name == 'hotels') { ?>
                    <li><a class="active_hotels" href="<?=root;?><?=$model->name?>" title="hotels"><?=T::hotels_hotels?></a></li>
                    <?php } ?>

                    <?php if ($model->status == true && $model->name == 'flights') { ?>
                    <li><a class="active_flights" href="<?=root;?><?=$model->name?>" title="flights"><?=T::flights_flights?></a></li>
                    <?php } ?>

                    <?php if ($model->status == true && $model->name == 'tours') { ?>
                    <li><a class="active_tours" href="<?=root;?><?=$model->name?>" title="tours"><?=T::tours_tours?></a></li>
                    <?php } ?>

                    <?php if ($model->status == true && $model->name == 'cars') { ?>
                    <li><a class="active_cars" href="<?=root;?><?=$model->name?>" title="cars"><?=T::cars_cars?></a></li>
                    <?php } ?>

                    <?php if ($model->status == true && $model->name == 'visa') { ?>
                    <li><a class="active_visa" href="<?=root;?><?=$model->name?>" title="visa"><?=T::visa_visa?></a></li>
                    <?php } } ?>

                    <?php foreach ($app->cms->header as $key => $value) {
                    foreach ($value as $k => $v) { ?>
                    <li class="footm">
                    <?php if ($k == $v[0]->title && count($v) < 2){ ?>
                    <a href="<?=$v[0]->href?>"><?= $k ?></a>
                    <?php  }elseif($k == $v[0]->title && count($v) > 1){?>
                    <a href="<?=$v[0]->href?>"><?= $k ?> <i class="la la-angle-down"></i></a>
                    <?php }?>
                    <?php if (count($v) > 1) {?>
                    <ul class="dropdown-menu-item">
                    <?php foreach ($v as $mk => $mv) { if ($mv->title != $k) {?>
                    <li><a href="<?=$root;?><?= $mv->href ?>"><?= $mv->title ?></a></li><?php }} ?>
                    </ul> <?php } ?>
                    </li> <?php } } ?>  
                </ul>
            </nav>
        </div>  -->
            

            <ul class="nav nav-tabs gap-2 cms-pages">
                    
            <li class="w-100 d-block">
                <ul class="mb-0 pb-0 dropdown-menu-item">
                    <?php  if (isset($blog)) { if ($blog == 1) {?>
                    <li class="w-100 d-block"><a class="nav-link w-100 text-start text-capitalize py-0 d-block active_blog" href="<?=root;?>blog" title="blog"><strong><?=T::blog?></strong></a></li>
                    <?php } } ?>

                    <?php  if (isset($offers)) { if ($offers == 1) {?>
                    <li class="w-100 d-block"><a class="nav-link w-100 text-start text-capitalize py-0 active_offers" href="<?=root;?>offers" title="offers"><strong><?=T::offers?></strong></a></li>
                    <?php } } ?> 
                </ul>   
            </li> 

            </li>
                <?php foreach ($app->cms->header as $key => $value) { foreach ($value as $k => $v) { ?>
                <li class="w-100">
                    <?php if ($k == $v[0]->title && count($v) < 2){ ?>
                    <a href="<?=$v[0]->href?>"><strong><?= $k ?></strong></a>
                    <?php  }elseif($k == $v[0]->title && count($v) > 1){?>
                    <!-- <a class="nav-link w-100 text-start text-capitalize" href="<?=$v[0]->href?>"> <strong><?= $k ?></strong>  -->
                    <!-- <i class="la la-angle-down"></i> -->
                    </a>
                    <?php }?>
                    <?php if (count($v) > 1) {?>
                    <ul class="dropdown-menu-item">
                    <?php foreach ($v as $mk => $mv) { if ($mv->title != $k) {?>
                    <li><a class="nav-link w-100 text-start text-capitalize py-0" href="<?=$root;?><?= $mv->href ?>"><small><?= $mv->title ?></small></a></li><?php }} ?>
                    </ul> <?php } ?>
                </li> <?php } } ?>
                </ul>

            </div>

            <script>

                // FUNCTION TO SET AND GET SESSION VALUES
                function set(item, value){ window.sessionStorage.setItem(item, value); }
                function get(item){ return window.sessionStorage.getItem(item); }

                // FUNCTION TO ADD ACTIVE CLASS TO ACTIVE PAGE MENU
                const pathArray = window.location.pathname.split("/");
                const segment_2 = pathArray[1];

                if ( segment_2 == "hotels") { $(".active_hotels").css("font-weight", "bold"); }
                if ( segment_2 == "flights") { $(".active_flights").css("font-weight", "bold"); }
                if ( segment_2 == "tours") { $(".active_tours").css("font-weight", "bold"); }
                if ( segment_2 == "cars") { $(".active_cars").css("font-weight", "bold"); }
                if ( segment_2 == "visa") { $(".active_visa").css("font-weight", "bold"); }
                if ( segment_2 == "blog") { $(".active_blog").css("font-weight", "bold"); }
                if ( segment_2 == "offers") { $(".active_offers").css("font-weight", "bold"); }

                // $('.hide-button-sidebar').click( function(){
                //     $(".menu-sidebar").addClass("sidebar-small").fadeIn(100);
                //     $(".hide-button-sidebar").hide();
                //     $(".show-button-sidebar").show();
                //     set('menu_small', true);
                // })

                // $('.show-button-sidebar').click( function(){
                //     $(".menu-sidebar").removeClass("sidebar-small").fadeIn(100);
                //     $('.menu-sidebar').attr('style', 'width:220px');
                //     $(".hide-button-sidebar").show();
                //     $(".show-button-sidebar").hide();
                //     set('menu_small', false);
                // })

                //  if (get('menu_small') == 'true') {
                //     $(".menu-sidebar").addClass("sidebar-small").fadeIn(100);
                //     $(".hide-button-sidebar").hide();
                //     $(".show-button-sidebar").show();
                // }

                // function checkPosition() {
                //     if (window.matchMedia('(max-width: 700px)').matches) {
                //     $(".menu-sidebar").addClass("sidebar-small").fadeIn(100);
                //     // $(".hide-button-sidebar").hide();
                //     // $(".show-button-sidebar").hide();
                //     }
                // }

                // checkPosition()

                // SCROLL TO TOP WITH SMOOTH 
                // $('.nav-tabs .nav-link').click( function(){
                //     window.scrollTo({top: 0, behavior: 'smooth'});
                // })

                <?php if(isset($menu_active)) { ?>
                    // REDIRECT TO MODULE PAGES 
                    // $('.nav-link').click( function(){
                    //     var text = $(this).text();
                    //     var anchor = text.toLowerCase();
                    //     var module_name = anchor.replace(/ /g, ""); 
                    //     window.location.href = '<?=root?>' + module_name;
                    // })

                    // REMOVE ACTIVE AND ADD ACTIVE CLASS ON MODULES

                    // setTimeout( function(){ 
                    //     $(".menu-sidebar .nav-link").removeClass("active");
                    // }  , 1000 );

                <?php } ?>

            </script>



        
       
    
    
    