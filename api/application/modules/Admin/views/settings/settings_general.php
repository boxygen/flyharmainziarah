<style>
  mwc-textfield, mwc-textarea, mwc-select {width:100% !important}
</style>
<div class="row gx-3">
  <div class="col-lg-8">
    <!-- Change password card-->
    <div class="card card-raised mb-5" style="min-height:760px;">
      <div class="card-body p-5">
        <div class="card-title">Main settings</div>
        <div class="card-subtitle mb-4">Application name and tags</div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Business Name</label>
          <div class="col-md-9">
            <mwc-textfield name="site_title" label="Business Name" outlined value="<?php echo $settings[0]->site_title;?>"></mwc-textfield>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Domain Name</label>
          <div class="col-md-9">
            <mwc-textfield name="site_url" label="Site URL" outlined value="<?php echo $settings[0]->site_url;?>"></mwc-textfield>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">License Key</label>
          <div class="col-md-9">
            <mwc-textfield name="license" label="License Key" outlined value="<?php echo $settings[0]->license_key;?>"></mwc-textfield>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">API AppKey</label>
          <div class="col-md-9">
            <mwc-textfield name="mobile[apiKey]" label="API AppKey" outlined value="<?php echo $mobileSettings->apiKey;?>"></mwc-textfield>
            <div style="width: 100%; text-align: left; background: #eee; padding: 6px;">API URL : <a target="_blank" href="<?php echo base_url(); ?>"><strong><?php echo base_url(); ?></strong></a> </div>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Copyrights</label>
          <div class="col-md-9">
            <mwc-textfield name="copyright" label="Copyrights" outlined value="<?php echo $settings[0]->copyright;?>"></mwc-textfield>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Website Offline</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="site_offine" class="offstatus">
              <mwc-list-item value="1" <?php if ($settings[0]->site_offline == '1') {echo 'selected';}?> > Yes</mwc-list-item>
              <mwc-list-item value="0" <?php if ($settings[0]->site_offline == '0') {echo 'selected';}?> > No</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Copyrights</label>
          <div class="col-md-9">
            <div class="form-floating">
              <textarea class="form-control" placeholder="Our website is currently offline for maintenance. Please visit us later."  name="offlinemsg" id="offmsg" style="height: 100px"><?php echo $settings[0]->offline_message; ?></textarea>
              <label for="">Message</label>
            </div>
          </div>
        </div>
        <!-- <div class="mb-4"><mwc-textfield class="w-100" label="Current Password" outlined="" type="password"></mwc-textfield></div>
          <div class="mb-4"><mwc-textfield class="w-100" label="New Password" outlined="" type="password"></mwc-textfield></div>
          <div class="mb-4"><mwc-textfield class="w-100" label="Confirm New Password" outlined="" type="password"></mwc-textfield></div>
          <div class="text-end"><button class="btn btn-primary mdc-ripple-upgraded" type="submit">Reset Password</button></div> -->
        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
      </div>
    </div>
    <div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">SEO</div>
        <div class="card-subtitle mb-4">SEO and meta tags</div>
        <div class="row form-group mb-2">
          <label  class="col-md-3 control-label text-left">Meta Title</label>
          <div class="col-md-9">
            <label class="pure-material-textfield-outlined">
            <input name="slogan" type="text"  placeholder=" " class="form-control" value="<?php echo $settings[0]->home_title;?>" />
            <span>Home Title</span>
            </label>  
          </div>
        </div>
        <div class="row form-group mb-2">
          <label  class="col-md-3 control-label text-left">Meta Keywords</label>
          <div class="col-md-9">
            <label class="pure-material-textfield-outlined">
            <input name="keywords" type="text"  placeholder=" " class="form-control" value="<?php echo $settings[0]->keywords;?>" />
            <span>Default Keywords</span>
            </label>  
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Meta Description</label>
          <div class="col-md-9">
            <div class="form-floating">
              <textarea class="form-control" placeholder="Description of Homepage"  name="meta_description"  style="height: 100px"><?php echo $settings[0]->meta_description; ?></textarea>
              <label for="">Message</label>
            </div>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">RSS Feeds</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="RSS" name="rss" class="">
              <mwc-list-item value="1" <?php if ($settings[0]->rss == '1') {echo 'selected';}?> > Enabled</mwc-list-item>
              <mwc-list-item value="0" <?php if ($settings[0]->rss == '0') {echo 'selected';}?> > Disabled</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">XML SiteMap</label>
          <div class="col-md-9">
            <div class="row">
              <label class="col-md-6"><a class="btn btn-success w-100" target="_blank" href="<?php base_url(); ?>admin/settings/downloadSitemap">Download Sitemap</a></label>
              <label class="col-md-6"><a class="btn btn-warning w-100" target="_blank" href="<?php base_url(); ?>sitemap.xml">Show Sitemap</a></label>
            </div>
          </div>
        </div>
        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
      </div>
    </div>
    <div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Accounts</div>
        <div class="card-subtitle mb-4">Users and accounts settings</div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Guest Booking</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="restrict">
              <mwc-list-item value="No" <?php makeSelected('No',$settings[0]->restrict_website); ?> > No</mwc-list-item>
              <mwc-list-item value="Yes" <?php makeSelected('Yes',$settings[0]->restrict_website); ?> > Yes</mwc-list-item>
            </mwc-select>
            <small>if selected yes only registered users can book</small>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Users Registration</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="allow_registration">
              <mwc-list-item value="1" <?php if ($settings[0]->allow_registration == "1") {echo "selected";}?> > Yes</mwc-list-item>
              <mwc-list-item value="0" <?php if ($settings[0]->allow_registration == "0") {echo "selected";}?> > No</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Suppliers</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="allow_supplier_registration">
              <mwc-list-item value="1" <?php if ($settings[0]->allow_supplier_registration == "1") {echo "selected";}?> > Enabled</mwc-list-item>
              <mwc-list-item value="0" <?php if ($settings[0]->allow_supplier_registration == "0") {echo "selected";}?> > Disabled</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Agents</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="allow_agent_registration">
              <mwc-list-item value="1" <?php if ($settings[0]->allow_agent_registration == "1") {echo "selected";}?> > Enabled</mwc-list-item>
              <mwc-list-item value="0" <?php if ($settings[0]->allow_supplier_registration == "0") {echo "selected";}?> > Disabled</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Users Registration Approval</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="user_reg_approval">
              <mwc-list-item value="Yes" <?php if ($settings[0]->user_reg_approval == "Yes") {echo "selected";}?> > Required</mwc-list-item>
              <mwc-list-item value="No" <?php if ($settings[0]->user_reg_approval == "No") {echo "selected";}?> > Not Required</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
      </div>
    </div>
    <div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">System Settings</div>
        <div class="card-subtitle mb-4">System settings and configurations</div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Google Maps ApiKey</label>
          <div class="col-md-9">
            <mwc-textfield name="mapapi" label="Maps API Key" outlined value="<?php echo $settings[0]->mapApi;?>"></mwc-textfield>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Tracking & Analytics</label>
          <div class="col-md-9">
            <div class="form-floating">
              <textarea class="form-control" placeholder="Paste your tracking & analytics code here."  name="gacode" style="height: 100px"><?php echo $settings[0]->google; ?></textarea>
              <label for="">Tracking Code</label>
            </div>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Booking Expiry</label>
          <div class="col-md-9">
            <mwc-textfield type="number" name="bookingexpiry" label="Max Days" min="1"  outlined value="<?php echo $settings[0]->booking_expiry;?>"></mwc-textfield>
            <small> Enter Number of days in which unpaid booking expires</small>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Coupon code type</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="coupon_code_type">
              <mwc-list-item value="alpha" <?php if ($settings[0]->coupon_code_type == "alpha") {echo "selected";}?> > Alphabets Only</mwc-list-item>
              <mwc-list-item value="numeric" <?php if ($settings[0]->coupon_code_type == "numeric") {echo "selected";}?> > Numbers Only</mwc-list-item>
              <mwc-list-item value="alnum" <?php if ($settings[0]->coupon_code_type == "alnum") {echo "selected";}?> > Alphabets and Numbers both</mwc-list-item>
            </mwc-select>
            <small>Select Coupon Code type to be generated as coupon codes</small>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Coupon code length</label>
          <div class="col-md-9">
            <mwc-textfield type="number" name="codelength" min="4" max="8" label="Coupon Length" outlined value="<?php echo $settings[0]->coupon_code_length;?>"></mwc-textfield>
            <small> Enter coupon code length min: 4, max: 8 </small>
          </div>
        </div>
          <div class="row form-group mb-3" style="display:none">
          <label  class="col-md-3 control-label text-left">Calender Date Format</label>
              <div class="col-md-9">
                  <mwc-select outlined="" label="Status" name="pt_date_format">
                  <mwc-list-item value="d/m/Y" <?php if ($settings[0]->date_f == "d/m/Y") {echo "selected";}?> > dd/mm/yyyy</mwc-list-item>
                  <mwc-list-item value="m/d/Y" <?php if ($settings[0]->date_f == "m/d/Y") {echo "selected";}?> > mm/dd/yyyy</mwc-list-item>
                  </mwc-select>
          </div>
          </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">Reviews Approval</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="reviews">
              <mwc-list-item value="Yes" <?php if ($settings[0]->reviews == "Yes") {echo "selected";}?> > Auto Approve</mwc-list-item>
              <mwc-list-item value="No" <?php if ($settings[0]->reviews == "No") {echo "selected";}?> > Admin Approve</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-3 control-label text-left">System Updates Check</label>
          <div class="col-md-9">
            <mwc-select outlined="" label="Status" name="updates">
              <?php for($i = 1; $i <= 7; $i++){ $d = $i * 24; if($i > 1){ $days = "Days"; }else{ $days = "Day"; } ?>
              <mwc-list-item value="<?php echo $d;?>" <?php if ($settings[0]->updates_check == $d) {echo 'selected';}?> > Every <?php echo $i." ".$days; ?></mwc-list-item>
              <?php } ?>
              <mwc-list-item value="0" <?php if ($settings[0]->updates_check == '0') {echo 'selected';}?> > Never </mwc-list-item>
            </mwc-select>
            <small>Select Coupon Code type to be generated as coupon codes</small>
          </div>
        </div>
        <!-- <div class="row form-group">
          <label  class="col-md-2 control-label text-left">Force SSL</label>
          <div class="col-md-2">
          <select data-placeholder="Select" class="form-control" name="ssl_url">
          <option value="1" <?php if ($settings[0]->ssl_url == '1') {echo 'selected';}?> >Enabled</option>
          <option value="0" <?php if ($settings[0]->ssl_url == '0') {echo 'selected';}?> >Disabled</option>
          </select>
          </div>
          </div> -->
        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card card-raised mb-5" style="min-height:770px;">
      <div class="card-body p-5">
        <div class="card-title">Branding</div>
        <div class="card-subtitle mb-1">Business logo and favicon.</div>
        <!-- Account privacy optinos-->
        <div class="card p-3 mb-3">
          <label><strong>Business Logo</strong></label>
          <div class="caption fst-italic text-muted mb-4">Only PNG file supported max size 1 MB</div>
          <img src="<?php echo PT_GLOBAL_IMAGES_FOLDER.'logo.png?id='.rand(1,99);?>"  class="hlogo_preview_img img-fluid" />
          <hr>
          <input type="file" class="btn btn-light mdc-ripple-upgraded" id="hlogo" name="hlogo">  
        </div>
        <div class="card p-3 mb-3">
          <label><strong>Favicon</strong></label>
          <div class="caption fst-italic text-muted mb-4">Only PNG file supported max size 1 MB</div>
          <img src="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png?id='.rand(1,99);?>" class="favimage_preview_img img-fluid" style="max-width:60px" />
          <hr>
          <input type="file" class="btn btn-light mdc-ripple-upgraded" id="favimage" name="favimg">  
        </div>
        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
        <!-- 
          <div class="mb-4">
          <mwc-formfield label="On"><mwc-radio name="twoFactorAuth" checked=""></mwc-radio></mwc-formfield>
          <mwc-formfield label="Off"><mwc-radio name="twoFactorAuth"></mwc-radio></mwc-formfield>
          </div>
          <mwc-textfield class="w-100" label="SMS Number" outlined="" type="tel" value="407-555-0187"></mwc-textfield>
          -->
      </div>
    </div>
    <!-- Delete account card-->
    <div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Language & Currencies</div>
        <div class="card-subtitle mb-4">Confifure for default language and multiple currencies options</div>
        <div class="row form-group mb-3">
          <label  class="col-md-4 control-label text-left">Multi Language</label>
          <div class="col-md-8">
            <mwc-select outlined="" label="Status" name="multi_lang" class="">
              <mwc-list-item value="1" <?php if ($settings[0]->multi_lang == '1') {echo 'selected';}?> > Yes</mwc-list-item>
              <mwc-list-item value="0" <?php if ($settings[0]->multi_lang == '0') {echo 'selected';}?> > No</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-4 control-label text-left">Default Language</label>
          <div class="col-md-8">
            <mwc-select outlined="" label="Status" name="default_lang" class="">
              <?php $language_list = pt_get_languages(); foreach ($language_list as $langid => $langname) { ?>
              <mwc-list-item value="<?php echo $langid;?>" <?php if ($settings[0]->default_lang == $langid) {echo 'selected';}?> > <?= $langname['name'];?></mwc-list-item>
              <?php } ?>
            </mwc-select>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label  class="col-md-4 control-label text-left">Multi Currency</label>
          <div class="col-md-8">
            <mwc-select outlined="" label="Status" name="multicurr" class="">
              <mwc-list-item value="1" <?php if ($settings[0]->multi_curr == '1') {echo 'selected';}?> > Yes</mwc-list-item>
              <mwc-list-item value="0" <?php if ($settings[0]->multi_curr == '0') {echo 'selected';}?> > No</mwc-list-item>
            </mwc-select>
          </div>
        </div>
        <br />
        <br />
        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
        <!-- <button class="btn btn-text-danger mdc-ripple-upgraded" type="button">I understand, delete my account</button> -->
      </div>
    </div>
  </div>
</div>