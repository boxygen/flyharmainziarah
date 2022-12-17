<div class="modal fade mob-none" id="flights_load" tabindex="1" role="dialog" aria-hidden="ture">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:100%;height:100%;margin:0px!important;overflow-y: hidden;">

    <div style="position: fixed; z-index: 9999; top: 0; left: 0; height: 100vh; background: #fff; width: 100%">

        <div class="container">
            <div class="row mt-5">

                <div class="col-md-12">

                    <div class="modal-content" style="border-radius:5px !important">

                        <div id="loading_flight" class="loading-results-globe-wrapper" style="background:#fff;overflow:hidden;border-radius:15px">
                        <div class="loading-results-globe ski-svg-responsive ski-svg-globe-geometry-loadingpage">
                        <span class="origin"><small><?=T::flights_flyingfrom?></small>
                        <div class="clear"></div>
                        <strong><span class="flying_from"></span>
                        <div class="clear"></div>
                        </strong><small class="date"></small></span>
                        <span class="destination-prefix"><?=T::flights_todestination?></span> <span class="destination flying_to" id=""></span>
                        <div class="loading-results-track">
                        <div class="loading-results-track-progress is-active"></div>
                        <div class="loading-results-progress is-active"></div>
                        </div>
                        </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>