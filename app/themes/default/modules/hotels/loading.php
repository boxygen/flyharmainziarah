<!-- search loading animation -->
<div class="modal fade mob-none" id="hotels_load" tabindex="1" role="dialog" aria-hidden="ture">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:100%;height:100%;margin:0px!important;overflow-y: hidden;">

    <div style="position: fixed; z-index: 9999; top: 0; left: 0; height: 100vh; background: #fff; width: 100%">

        <div class="container">
            <div class="row mt-5">

                <div class="col-md-12">

                    <div class="modal-content" style="border-radius:5px !important;padding-bottom:150px">
                    <img src="<?=root.theme_url;?>/assets/img/hotel_loading.gif" class="img-fluid mx-auto d-block"
                        style="max-width:180px; position: relative; display: flex !important; align-items: center; justify-content: center; margin-top: 100px; left: 0; right: 0;"
                        alt="" />
                    <p class="text-center" style="position: relative;text-transform: capitalize;margin-top:10px">
                    <strong class="cityname"></strong> <i class="la la-arrow-right"></i>
                    <span class="ci"></span> - <span class="co"></span> <?=T::hotels_adults?>
                    <span class="a"></span> <?=T::hotels_child?>
                    <span class="c"></span> <?=T::hotels_rooms?>
                    <span class="r"></span>
                    </p>
                    </div>

                </div>

                <!-- <div class="col-md-4">
                    <div class="placeholder-content">
                        <div class="placeholder-content_item"></div>
                        <div class="placeholder-content_item"></div>
                        <div class="placeholder-content_item"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="placeholder-content">
                        <div class="placeholder-content_item"></div>
                        <div class="placeholder-content_item"></div>
                        <div class="placeholder-content_item"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="placeholder-content">
                        <div class="placeholder-content_item"></div>
                        <div class="placeholder-content_item"></div>
                        <div class="placeholder-content_item"></div>
                    </div>
                 -->
            </div>
        </div>
    </div>
</div>
</div>