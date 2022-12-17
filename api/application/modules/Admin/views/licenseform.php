<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?php echo $pagetitle;?></title>
    <!-- Load Favicon-->
    <link rel="shortcut icon" href="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png';?> ">

    <!-- Load main stylesheet-->
    <link href="<?=base_url()?>assets/css/styles.css" rel="stylesheet" />
    <script async src='<?=base_url()?>assets/js/api.js'></script>
    <style>.sb-customizer-toggler{display:none !important}</style>
    </head>
    <body class="bg-primary">
        <!-- Layout wrapper-->
        <div id="layoutAuthentication">
            <!-- Layout content-->
            <div id="layoutAuthentication_content">
                <!-- Main page content-->
                <main>
                    <!-- Main content container-->
                    <div class="container">
                        <div class="row justify-content-center">

                        <?=demo_header();?>

                        <!-- <img data-wow-duration="0.2s" data-wow-delay="0.2s" src="<?php echo base_url(); ?>assets/img/admin.png" class="wow fadeIn center-block" style="width:78px;height:60px;margin-bottom:25px" alt="" /> -->
                            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8">
                                <div class="card card-raised shadow-10 mt-5 mt-xl-10 mb-4">
                                    <div class="card-body p-5">
                                        <!-- Auth header with logo image-->
                                        <div class="text-center">
                                            <img class="mb-3" src="<?=base_url()?>uploads/global/favicon.png" alt="..." style="max-height: 48px;border-radius: 8px;" />
                                            <h1 class="display-5 mb-0"><strong>License Required</strong></h1>
                                            <div class="subheading-1 mb-5">Software license verification</div>
                                        </div>
                                        <!-- Login submission form-->
                                        
                                    <div class="adminimg"><?php echo $this->session->flashdata('invalid'); ?></div>
                                      <div class="panel-body">
                                        <form class="form-signin my-5 d-block mx-auto" method="POST" action="<?php echo base_url();?>admin/license" role="form" >
                                          <fieldset>
                                            <div class="form-group">
                                              <input class="form-control" placeholder="License Key" name="licensekey" type="text" required>
                                            </div>
                                            <input type="hidden" name="check" value="1" />
                                            <input class="btn btn-primary d-block mx-auto my-2" type="submit" value="Submit">
                                          </fieldset>
                                        </form>
                                        <p class="text-center">How to obtain <a href="https://docs.phptravels.com/startup/configuration/license-key" target="_blank"><strong>License</strong></a></p>
                                  

                                    </div>
                                </div>
                                <!-- Auth card message-->
                                <div class="text-center mb-5"><                        
                                  <div class="me-sm-3 mb-2 mb-sm-0"><div class="fw-500 text-white">Powered by  <a target="_blank" style="color: #FFFFFF" href="http://phptravels.com"><b>PHPTRAVELS</b></a> <a href="http://phptravels.com/change-log/#<?php echo PT_VERSION; ?>"></a><?php echo PT_VERSION; ?></p> </small></div></div></div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

                  <div class="templates-page area" style="height:auto;max-height: 240px; overflow: hidden;">

<ul class="circles">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    </ul>
</div>

 
        </div>
        <!-- Load Bootstrap JS bundle-->
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
        <script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script type="module" src="<?=base_url()?>assets/js/material.js"></script>
        <script src="<?=base_url()?>assets/js/scripts.js"></script>
        <script src="<?=base_url()?>assets/js/sb-customizer.js"></script>
        <sb-customizer project="material-admin-pro"></sb-customizer>
</body>
</html>

    <link href="<?php echo base_url(); ?>assets/css/login.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/fa.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/include/login/ladda-themeless.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/include/login/spin.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/include/login/ladda.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
    
  <style>
 
    .matrialprogress{position:relative;height:10px;display:block;width:100%;background-color:#bfc1ce;border-radius:2px;background-clip:padding-box;margin:.5rem 0 1rem 0;overflow:hidden}
    .matrialprogress .determinate{position:absolute;background-color:inherit;top:0;bottom:0;background-color:#3f51b5;transition:width .3s linear}
    .matrialprogress .indeterminate{background-color:#3f51b5}
    .matrialprogress .indeterminate:before{content:'';position:absolute;background-color:inherit;top:0;left:0;bottom:0;will-change:left,right;-webkit-animation:indeterminate 2.1s cubic-bezier(0.65,0.815,0.735,0.395) infinite;animation:indeterminate 2.1s cubic-bezier(0.65,0.815,0.735,0.395) infinite}
    .matrialprogress .indeterminate:after{content:'';position:absolute;background-color:inherit;top:0;left:0;bottom:0;will-change:left,right;-webkit-animation:indeterminate-short 2.1s cubic-bezier(0.165,0.84,0.44,1) infinite;animation:indeterminate-short 2.1s cubic-bezier(0.165,0.84,0.44,1) infinite;-webkit-animation-delay:1.15s;animation-delay:1.15s}
    @-webkit-keyframes indeterminate{0%{left:-35%;right:100%}
    60%{left:100%;right:-90%}
    100%{left:100%;right:-90%}
    }@keyframes indeterminate{0%{left:-35%;right:100%}
    60%{left:100%;right:-90%}
    100%{left:100%;right:-90%}
    }@-webkit-keyframes indeterminate-short{0%{left:-200%;right:100%}
    60%{left:107%;right:-8%}
    100%{left:107%;right:-8%}
    }@keyframes indeterminate-short{0%{left:-200%;right:100%}
    60%{left:107%;right:-8%}
    100%{left:107%;right:-8%}
    }
      
  .context{width:100%;position:absolute;top:50vh;z-index:10}
  .area{background:#0031bc;background:radial-gradient(circle at 23% 0,#0031bc,#004ad1);width:100%;height:100vh}
  .circles{position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden;z-index:-10;}
  .circles li{position:absolute;display:block;list-style:none;width:20px;height:20px;background:rgba(255,255,255,0.2);animation:animate 25s linear infinite;bottom:-150px}
  .circles li:nth-child(1){left:25%;width:80px;height:80px;animation-delay:0s}
  .circles li:nth-child(2){left:10%;width:20px;height:20px;animation-delay:2s;animation-duration:12s}
  .circles li:nth-child(3){left:70%;width:20px;height:20px;animation-delay:4s}
  .circles li:nth-child(4){left:40%;width:60px;height:60px;animation-delay:0s;animation-duration:18s}
  .circles li:nth-child(5){left:65%;width:20px;height:20px;animation-delay:0s}
  .circles li:nth-child(6){left:75%;width:110px;height:110px;animation-delay:3s}
  .circles li:nth-child(7){left:35%;width:150px;height:150px;animation-delay:7s}
  .circles li:nth-child(8){left:50%;width:25px;height:25px;animation-delay:15s;animation-duration:45s}
  .circles li:nth-child(9){left:20%;width:15px;height:15px;animation-delay:2s;animation-duration:35s}
  .circles li:nth-child(10){left:85%;width:150px;height:150px;animation-delay:0s;animation-duration:11s}
  @keyframes animate{0%{transform:translateY(0) rotate(0deg);opacity:1;border-radius:0}
  100%{transform:translateY(-1000px) rotate(720deg);opacity:0;border-radius:50%}
  }
  @keyframes rotate{100%{transform:rotate(360deg)}
  }@keyframes dash{0%{stroke-dasharray:1,200;stroke-dashoffset:0}
  50%{stroke-dasharray:89,200;stroke-dashoffset:-35px}
  100%{stroke-dasharray:89,200;stroke-dashoffset:-124px}
  }@keyframes color{50%{stroke:transparent}
  }

</style>

 
  
    <script>
    Ladda.bind( 'div:not(.progress-demo) button', { timeout: 2000 } );
    Ladda.bind( '.progress-demo button', {
    	callback: function( instance ) {
    		var progress = 0;
    		var interval = setInterval( function() {
    			progress = Math.min( progress + Math.random() * 0.1, 1 );
    			instance.setProgress( progress );
    			if( progress === 1 ) {
    				instance.stop();
    				clearInterval( interval );
    			}
    		}, 200 );
    	}
    } );
  </script>

<script src="<?php echo base_url(); ?>assets/include/icheck/icheck.min.js"></script>
  <link href="<?php echo base_url(); ?>assets/include/icheck/square/grey.css" rel="stylesheet">
  <script>
    var cb, optionSet1;
        $(".checkbox").iCheck({
          checkboxClass: "icheckbox_square-grey",
          radioClass: "iradio_square-grey"
        });

        $(".radio").iCheck({
          checkboxClass: "icheckbox_square-grey",
          radioClass: "iradio_square-grey"
        });
  </script>

  <!-- WOWJs -->
  <script>
    new WOW().init();
  </script>
  <!-- WOWJs -->
















