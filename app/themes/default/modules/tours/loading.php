<!-- search loading animation -->
<div class="modal fade mob-none" id="tours_load" tabindex="1" role="dialog" aria-hidden="ture">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:100%;height:100%;margin:0px!important;overflow-y: hidden;">

    <div style="position: fixed; z-index: 9999; top: 0; left: 0; height: 100vh; background: #fff; width: 100%">
       
        <!-- <div class="placeholder-content-header" style="background: #f0f2f5;height: 85px;">
            <div class="container" style="position:relative">
        </div>
        </div> -->

        <div class="container">
            <div class="row mt-5">

                <div class="col-md-12">

                    <div class="modal-content" style="border-radius:5px !important;padding-bottom:50px">
                    
                    <img src="<?=root.theme_url;?>/assets/img/tour_loading.gif" class="img-fluid mx-auto d-block" style="max-width:280px; position: relative; display: flex !important; align-items: center; justify-content: center; margin-top: 20px; left: 0; right: 0; top: 26px;" alt="" />
                    <p class="text-center" style="padding-top: 40px; position: relative;text-transform: capitalize;">
                    <strong class="cityname"></strong> <i class="la la-arrow-right"></i> 
                    <span class="d"></span> <?=T::hotels_adults?> <span class="a"></span> 
                    <?=T::hotels_child?> <span class="c"></span></p>

                    </div>
                                   
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>