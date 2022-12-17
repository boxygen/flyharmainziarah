<div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Main settings</div>
        <div class="card-subtitle mb-4">Application name and tags</div>

        <div class="row form-group mb-3">
              <label  class="col-md-2 control-label text-left">Enable</label>
              <div class="col-md-5">
                <select data-placeholder="Select" class="form-select form-select-lg" aria-label="Large select example" name="wm_status" >
                  <option value="1" <?php echo makeSelected("1",$wm_settings[0]->wm_status); ?> >Yes</option>
                  <option value="0" <?php echo makeSelected("0",$wm_settings[0]->wm_status); ?> >No</option>
                </select>
              </div>
            </div>

            <div class="row form-group mb-3">
              <label  class="col-md-2 control-label text-left">Position</label>
              <div class="col-md-5">
                <select data-placeholder="Select" class="form-select form-select-lg" aria-label="Large select example" name="img_position">
                  <option value="tr" <?php echo makeSelected("tr",$wm_settings[0]->wm_position); ?> >Top Right</option>
                  <option value="tl" <?php echo makeSelected("tl",$wm_settings[0]->wm_position); ?> >Top Left</option>
                  <option value="tc" <?php echo makeSelected("tc",$wm_settings[0]->wm_position); ?> >Top Center</option>
                  <option value="br" <?php echo makeSelected("br",$wm_settings[0]->wm_position); ?> >Bottom Right</option>
                  <option value="bl" <?php echo makeSelected("bl",$wm_settings[0]->wm_position); ?> >Bottom Left</option>
                  <option value="bc" <?php echo makeSelected("bc",$wm_settings[0]->wm_position); ?> >Bottom Center</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Watermark Image</label>
              <div class="col-md-4">
                <div class="input-group input-xs">
                  <input type="file" class="btn btn-light" id="wmlogo" name="wmimg" style="width:100%">
                  <small class="help-block">Only PNG file supported</small>
                </div>
              </div>
              <div class="col-md-4 pull-right">
                <img src="<?php echo PT_GLOBAL_IMAGES_FOLDER.'watermark.png?id='.rand(1,99);?>"  class="wmlogo_preview_img img-responsive" />
              </div>
            </div>

         <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
      </div>
    </div>

