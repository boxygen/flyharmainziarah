<style type="text/css">
  .modal .modal-body {
    max-height: 450px;
    overflow-y: auto;
}
</style>
<?php if ($this->session->flashdata('flashmsgs')) {echo NOTIFY;}?>
<h3 class="margin-top-0">Cars Settings</h3>
<form action="" method="POST">
  <div class="panel panel-default">
    <!-- <ul class="nav nav-tabs nav-justified" role="tablist">
      <li class="active" id="Generaltab"><a href="#GENERAL" data-toggle="tab">General</a></li>
      <li class=""><a href="#CARTYPES" data-toggle="tab">Types</a></li>
      <li class=""><a href="#PAYMENT" data-toggle="tab">Payment Methods</a></li>
    </ul> -->

    <mwc-tab-bar class="nav nav-tabs" role="tablist">
      <mwc-tab id="GENERAL-tab" label="General" data-bs-toggle="tab" data-bs-target="#GENERAL" role="tab" aria-controls="GENERAL" aria-selected="true" dir="" class="active" active=""></mwc-tab>
      <mwc-tab id="CARTYPES-tab" label="Types" data-bs-toggle="tab" data-bs-target="#CARTYPES" role="tab" aria-controls="CARTYPES" aria-selected="true" dir="" class="" active=""></mwc-tab>
      <mwc-tab id="PAYMENT-tab" label="Payment Methods" data-bs-toggle="tab" data-bs-target="#PAYMENT" role="tab" aria-controls="PAYMENT" aria-selected="true" dir="" class="" active=""></mwc-tab>
      </mwc-tab-bar>

    <div class="panel-body">
      <br>
      <div class="tab-content form-horizontal">
        <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
          <div class="clearfix"></div>
          <!--<div class="row form-group">
            <label class="col-md-2 control-label text-left">Icon Class</label>
     <div class="col-md-4">
            <input type="text" name="page_icon" class="form-control" placeholder="Select icon" value="<?php echo $settings[0]->front_icon;?>" >
            </div>
          </div>-->
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Target</label>
            <div class="col-md-4">
              <select  class="form-control" name="target">
                <option  value="_self" <?php if ($settings[0]->linktarget == "_self") {echo "selected";}?>   >Self</option>
                <option  value="_blank"  <?php if ($settings[0]->linktarget == "_blank") {echo "selected";}?>  >Blank</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Header Title</label>
            <div class="col-md-4">
              <input type="text" name="headertitle" class="form-control" placeholder="title" value="<?php echo $settings[0]->header_title;?>" />
            </div>
          </div>
          <hr>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Featured Cars</label>
            <div class="col-md-2">
      <input class="form-control" type="text" placeholder="" name="home"  value="<?php echo $settings[0]->front_homepage;?>">
            </div>
            <label class="col-md-2 control-label text-left">Display Order</label>
            <div class="col-md-3">
              <select class="form-control" name="homeorder">
                <option value="ol" label="By Order Given" <?php if ($settings[0]->front_homepage_order == "ol") {echo "selected";}?>>By Order Given</option>
                <option value="newf" label="By Latest First" <?php if ($settings[0]->front_homepage_order == "newf") {echo "selected";}?> >By Latest First</option>
                <option value="oldf" label="By Oldest First" <?php if ($settings[0]->front_homepage_order == "oldf") {echo "selected";}?>>By Oldest First</option>
                <option value="az" label="Ascending Order (A-Z)" <?php if ($settings[0]->front_homepage_order == "az") {echo "selected";}?>>Ascending Order (A-Z)</option>
                <option value="za" label="Descending  Order (Z-A)" <?php if ($settings[0]->front_homepage_order == "za") {echo "selected";}?>>Descending  Order (Z-A)</option>
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Listings Cars</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="listings"  value="<?php echo $settings[0]->front_listings;?>">
            </div>
            <label class="col-md-2 control-label text-left">Display Order</label>
            <div class="col-md-3">
              <select class="form-control" name="listingsorder">
                <option value="ol" label="By Order Given" <?php if ($settings[0]->front_listings_order == "ol") {echo "selected";}?>>By Order Given</option>
                <option value="newf" label="By Latest First" <?php if ($settings[0]->front_listings_order == "newf") {echo "selected";}?>>By Latest First</option>
                <option value="oldf" label="By Oldest First" <?php if ($settings[0]->front_listings_order == "oldf") {echo "selected";}?>>By Oldest First</option>
                <option value="az" label="Ascending Order (A-Z)" <?php if ($settings[0]->front_listings_order == "az") {echo "selected";}?>>Ascending Order (A-Z)</option>
                <option value="za" label="Descending  Order (Z-A)" <?php if ($settings[0]->front_listings_order == "za") {echo "selected";}?>>Descending  Order (Z-A)</option>
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Search Result Cars</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="searchresult"  value="<?php echo $settings[0]->front_search;?>">
            </div>
            <label class="col-md-2 control-label text-left">Display Order</label>
            <div class="col-md-3">
              <select class="form-control" name="searchorder">
                <option value="ol" label="By Order Given" <?php if ($settings[0]->front_search_order == "ol") {echo "selected";}?>>By Order Given</option>
                <option value="newf" label="By Latest First" <?php if ($settings[0]->front_search_order == "newf") {echo "selected";}?>>By Latest First</option>
                <option value="oldf" label="By Oldest First" <?php if ($settings[0]->front_search_order == "oldf") {echo "selected";}?>>By Oldest First</option>
                <option value="az" label="Ascending Order (A-Z)" <?php if ($settings[0]->front_search_order == "az") {echo "selected";}?>>Ascending Order (A-Z)</option>
                <option value="za" label="Descending  Order (Z-A)" <?php if ($settings[0]->front_search_order == "za") {echo "selected";}?>>Descending  Order (Z-A)</option>
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
          <!-- <div class="row form-group">
            <label class="col-md-2 control-label text-left">Popular Cars</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="popular"  value="<?php echo $settings[0]->front_popular;?>">
            </div>
            <label class="col-md-4 control-label text-left">Popuar cars are based on best reviews</label>
            <div class="col-md-3">
            </div>
          </div> -->
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Related Cars</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="related"  value="<?php echo $settings[0]->front_related;?>">
            </div>
          </div>
          <hr>
          <h4 class="text-danger">SEO</h4>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Meta Keywords</label>
            <div class="col-md-4">
              <input class="form-control" type="text" placeholder="" name="keywords" value="<?php echo $settings[0]->meta_keywords;?>">
            </div>
            <label  class="col-md-2 control-label text-left">Meta Description</label>
            <div class="col-md-4">
              <input class="form-control" type="text" placeholder="" name="description"  value="<?php echo $settings[0]->meta_description;?>">
            </div>
          </div>
          <hr>
          <h4 class="text-danger">Search Settings</h4>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Minimum Price</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="minprice"  value="<?php echo $settings[0]->front_search_min_price;?>">
            </div>
            <label  class="col-md-2 control-label text-left">Maximum Price</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="maxprice"  value="<?php echo $settings[0]->front_search_max_price;?>">
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="CARTYPES">
          <div class="add_button_modal">
            <button type="button" data-toggle="modal" data-target="#ADD_CARS_TYPES" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add</button>
          </div>
          <div class="clearfix"></div>
       <?php echo $contentctypes; ?>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="PAYMENT">
          <div class="add_button_modal">
            <button type="button" data-toggle="modal" data-target="#ADD_PAYMENT_TYPES" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add</button>
          </div>
          <div class="clearfix"></div>
         <?php echo $contentcpayments; ?>
        </div>
      </div>
    </div>
    <div class="panel-footer">
      <input name="updatesettings" value="1" type="hidden">
      <input name="updatefor" value="cars" type="hidden">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>
<script>
  $(document).ready(function(){
  if(window.location.hash != "") {
  $('a[href="' + window.location.hash + '"]').click() } });
</script>
<!--Add payment types Modal -->
<div class="modal fade" id="ADD_PAYMENT_TYPES" tabindex="-1" role="dialog" aria-labelledby="ADD_PAYMENT_TYPES" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Payment Type</h4>
        </div>
        <div class="modal-body form-horizontal">
          <div class="row form-group">
            <label  class="col-md-3 control-label text-left">Payment Type Name</label>
            <div class="col-md-8">
              <input type="text" name="name" class="form-control" placeholder="Name" value="" >
            </div>
          </div>
          <div class="row form-group">
            <label  class="col-md-3 control-label text-left">Selected</label>
            <div class="col-md-8">
              <select name="setselect" class="form-control" id="">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <label  class="col-md-3 control-label text-left">Status</label>
            <div class="col-md-8">
              <select name="statusopt" class="form-control" id="">
                <option value="Yes">Enable</option>
                <option value="No">Disable</option>
              </select>
            </div>
          </div>
          <?php foreach($languages as $lang => $val){ if($lang != "en"){  ?>
          <div class="row form-group">
            <label  class="col-md-3 control-label text-left"> Name in <img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" />&nbsp;<?php echo $val['name'];?></label>
            <div class="col-md-8">
              <input type="text" name='<?php echo "translated[$lang][name]"; ?>' class="form-control" placeholder="Name" value="" >
            </div>
          </div>
          <?php } } ?>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="add" value="1" />
          <input type="hidden" name="typeopt" value="cpayments" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--end add payment types modal-->

<!--Add car type types Modal -->
<div class="modal fade" id="ADD_CARS_TYPES" tabindex="-1" role="dialog" aria-labelledby="ADD_CARS_TYPES" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="POST" enctype="multipart/form-data" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Car Type</h4>
        </div>
        <div class="modal-body form-horizontal">
          <div class="row form-group">
            <label  class="col-md-3 control-label text-left">Type Name</label>
            <div class="col-md-8">
              <input type="text" name="name" class="form-control" placeholder="Name" value="" >
            </div>
          </div>

          <div class="row form-group">
            <label  class="col-md-3 control-label text-left">Status</label>
            <div class="col-md-8">
              <select name="statusopt" class="form-control" id="">
                <option value="Yes">Enable</option>
                <option value="No">Disable</option>
              </select>
            </div>
          </div>
          <?php foreach($languages as $lang => $val){ if($lang != "en"){   ?>
          <div class="row form-group">
            <label  class="col-md-3 control-label text-left"> Name in <img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" />&nbsp;<?php echo $val['name'];?></label>
            <div class="col-md-8">
              <input type="text" name='<?php echo "translated[$lang][name]"; ?>' class="form-control" placeholder="Name" value="" >
            </div>
          </div>
          <?php } } ?>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="add" value="ctypes" />
          <input type="hidden" name="typeopt" value="ctypes" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!---end add car type modal-->

<!-- Edit Modal -->
<?php foreach($typeSettings as $ts){ ?>
<div class="modal fade" id="sett<?php echo $ts->sett_id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update <?php echo $ts->sett_name;?></h4>
        </div>
        <div class="modal-body form-horizontal">
          <div class="row form-group">
            <label  class="col-md-3 control-label text-left">Type Name</label>
            <div class="col-md-8">
              <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $ts->sett_name;?>" >
            </div>
          </div>

          <div class="row form-group">
            <label  class="col-md-3 control-label text-left">Selected</label>
            <div class="col-md-8">
              <select name="setselect" class="form-control" id="">
                <option value="Yes" <?php makeSelected($ts->sett_selected,"Yes"); ?> >Yes</option>
                <option value="No" <?php makeSelected($ts->sett_selected,"No"); ?>  >No</option>
              </select>
            </div>
          </div>

          <div class="row form-group">
            <label  class="col-md-3 control-label text-left">Status</label>
            <div class="col-md-8">
              <select name="statusopt" class="form-control" id="">
                <option value="Yes" <?php makeSelected($ts->sett_status,"Yes"); ?> >Enable</option>
                <option value="No" <?php makeSelected($ts->sett_status,"No"); ?>  >Disable</option>
              </select>
            </div>
          </div>
          <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getTypesTranslation($lang, $ts->sett_id); ?>
          <div class="row form-group">
            <label  class="col-md-3 control-label text-left"> Name in <img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" />&nbsp;<?php echo $val['name'];?></label>
            <div class="col-md-8">
              <input type="text" name='<?php echo "translated[$lang][name]"; ?>' class="form-control" placeholder="Name" value="<?php echo @$trans[0]->trans_name;?>" >
            </div>
          </div>
          <?php } } ?>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="updatetype" value="1" />
          <input type="hidden" name="settid" value="<?php echo $ts->sett_id;?>" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>

<!--edit modal -->