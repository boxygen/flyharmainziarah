<script>
  $(function(){
    themeinfo();
    offstatus();
  // mailserver options
  var mailserver = $("#mailserver").val();
  if(mailserver == "php"){
  $(".smtp").hide();
   }else{
  $(".smtp").show();
  }
  // mailserver options
  $("#mailserver").on('change', function() {
  var mserver = $(this).val();
  if(mserver == "php"){
  $(".smtp").hide();
  }else{
  $(".smtp").show();
  }
  });

    // offline status option
  $(".offstatus").on('change', function() {
    offstatus();

  });

  $("#hlogo").change(function(){

  var preview = $('.hlogo_preview_img');
  preview.fadeOut();

  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("hlogo").files[0]);

  oFReader.onload = function (oFREvent) {
  preview.attr('src', oFREvent.target.result).fadeIn();
  };

  });

  $("#favimage").change(function(){
  var abc = $(this).attr('name');


  var preview = $('.favimage_preview_img');
  preview.fadeOut();

  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("favimage").files[0]);

  oFReader.onload = function (oFREvent) {
  preview.attr('src', oFREvent.target.result).fadeIn();
  };

  });

  $("#wmlogo").change(function(){

  var preview = $('.wmlogo_preview_img');
  preview.fadeOut();

  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("wmlogo").files[0]);

  oFReader.onload = function (oFREvent) {
  preview.attr('src', oFREvent.target.result).fadeIn();
  };

  });

  $(".testEmail").on('click',function(){
    var id = $(".testemailtxt").val();
    $.post("<?php echo base_url();?>admin/ajaxcalls/testingEmail", {email: id}, function(resp){
    alert(resp);
    console.log(resp);
    });
  })

  });

  function themeinfo(){
  var id = $(".theme").val();

  $.post("<?php echo base_url();?>admin/ajaxcalls/ThemeInfo", {theme: id}, function(resp){
  var obj = jQuery.parseJSON(resp);

  $("#themename").html(obj.Name);
  $("#themedesc").html(obj.Description);
  $("#themeauthor").html(obj.Author);
  $("#themeversion").html(obj.Version);
  $("#screenshot").prop("src",obj.screenshot);

  });
  }

  function offstatus(){
  var status = $(".offstatus").val();
  if(status == "1"){
    $("#offmsg").prop("readonly",false);
  }else{
    $("#offmsg").prop("readonly",true);
  }
  }
</script>
 

<?php if(!empty($errormsg)){  echo '<div class="alert alert-success">'.$errormsg.'</div>'; } ?>

<form action="" method="POST" enctype="multipart/form-data" class="row form-horizontal">

<div class="tab-pane show active" role="tabpanel" id="materialTabBarJsDemo" aria-labelledby="materialTabBarJsDemoTab">
        <mwc-tab-bar class="nav nav-tabs" role="tablist">
            <mwc-tab id="general-tab" label="General" data-bs-toggle="tab" data-bs-target="#general" role="tab" aria-controls="general" aria-selected="true" dir="" class="active" active=""></mwc-tab>
            <mwc-tab id="watermark-tab" label="Watermark" data-bs-toggle="tab" data-bs-target="#watermark" role="tab" aria-controls="watermark" aria-selected="false" dir="" class=""></mwc-tab>
            <mwc-tab id="email-tab" label="Email Settings" data-bs-toggle="tab" data-bs-target="#email" role="tab" aria-controls="email" aria-selected="false" dir="" class=""></mwc-tab>
            <mwc-tab id="themes-tab" label="Themes" data-bs-toggle="tab" data-bs-target="#themes" role="tab" aria-controls="themes" aria-selected="false" dir="" class=""></mwc-tab>
            <mwc-tab id="contact-tab" label="contact" data-bs-toggle="tab" data-bs-target="#contact" role="tab" aria-controls="contact" aria-selected="false" dir="" class=""></mwc-tab>
            <mwc-tab id="server-tab" label="server" data-bs-toggle="tab" data-bs-target="#server" role="tab" aria-controls="server" aria-selected="false" dir="" class=""></mwc-tab>
        </mwc-tab-bar>
        <div class="tab-content border border-top-0 p-3" id="myTabBarContent">
            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab"><?php include "settings_general.php"?></div>
            <div class="tab-pane fade" id="watermark" role="tabpanel" aria-labelledby="watermark-tab"><?php include "settings_watermark.php"?></div>
            <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab"><?php include "settings_email.php"?></div>
            <div class="tab-pane fade" id="themes" role="tabpanel" aria-labelledby="themes-tab"><?php include "settings_themes.php"?></div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"><?php include "settings_contact.php"?></div>
            <div class="tab-pane fade" id="server" role="tabpanel" aria-labelledby="server-tab"><?php include "settings_server.php"?></div>
    </div>
</div>




   
  <div class="col-md-8">
    <div class="panel panel-default">
       
      <div class="panel-body">
        <div class="tab-content form-horizontal">
          
          <div class="tab-pane wow fadeIn animated in form-horizontal" id="SINGLE">
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Status</label>
              <div class="col-md-2">
                <select class="form-control" name="spa_status">
                  <option>Select Status</option>
                  <option value="enable" <?=($spa_settings->spa_status == 'enable')?'selected':''?>>Enable</option>
                  <option value="disable" <?=($spa_settings->spa_status == 'disable')?'selected':''?>>Disable</option>
                </select>
              </div>
              <div class="col-md-6">
                <p style="padding: 5px;">By enabling this feauture you site will convert to one page content site.</p>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Module Name</label>
              <div class="col-md-2">
                <select class="form-control" name="spa_module">
                  <!--<option>Select Module</option>-->
                  <option value="hotels" <?=($spa_settings->spa_module == 'hotels')?'selected':''?>>Hotels</option>
                  <option value="tours" <?=($spa_settings->spa_module == 'tours')?'selected':''?>>Tours</option>
                  <option value="cars" <?=($spa_settings->spa_module == 'cars')?'selected':''?>>Cars</option>
                </select>
              </div>
              <div class="col-md-8">
                <select class="chosen-multi-select" data-placeholder="my placeholder"  name="spa_homepage"><?=$spa_homepage_dd?></select>
              </div>
            </div>
            <script>
              $('[name=spa_module]').change(function(){
                  var payload = { module: $(this).val() };
                  $.get('<?=base_url("suggestions/spaAutoComplete")?>',payload,function(res){
                      // var res=JSON.parse(res);
                      $('[name=spa_homepage]').html(res.html);
                  });
              });
            </script>
            <div class="alert alert-danger">
              <p>Please select your disired content from selectbox to appear on main site. please note this is highly recommended to use this option only when you are running single business website for example : Hotel owner, tour operator or car rental only.</p>
            </div>
          </div>
          <div class="tab-pane wow fadeIn animated in" id="MOBILE">
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Mobile Section Footer</label>
              <div class="col-md-2">
                <select data-placeholder="Select" class="form-control" name="mobile[mobileSectionStatus]">
                  <option value="Yes" <?php makeSelected('Yes',$mobileSettings->mobileSectionStatus); ?> >Enable</option>
                  <option value="No" <?php makeSelected('No',$mobileSettings->mobileSectionStatus); ?> > Disable</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="mobile[iosUrl]" placeholder="iOS Store URL" value="<?php echo $mobileSettings->iosUrl;?>" />
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="mobile[androidUrl]" placeholder="Android Store URL" value="<?php echo $mobileSettings->androidUrl;?>" />
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Front-end Mob Redirect</label>
              <div class="col-md-2">
                <select data-placeholder="Select" class="form-control" name="mobile[mobileRedirectStatus]">
                  <option value="Yes" <?php makeSelected('Yes',$mobileSettings->mobileRedirectStatus); ?> >Enable</option>
                  <option value="No" <?php makeSelected('No',$mobileSettings->mobileRedirectStatus); ?> > Disable</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="mobile[mobileRedirectUrl]" placeholder="URL" value="<?php echo @$mobileSettings->mobileRedirectUrl;?>" />
              </div>
              <p>Enable this only if you want to redirect mobile users.</p>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">About Us</label>
              <div class="col-md-10">
                <textarea class="form-control" rows="10"  name="mobile[aboutUs]" placeholder="About Us" ><?php echo @$mobileSettings->aboutUs;?></textarea>
              </div>
            </div>
          </div>
       
      
        </div>
      </div>
         <input type="hidden" name="globalsettings" value="1"/>
     </div>
  </div>
</form>