<!DOCTYPE html>
<html>

    <!--
    Product:        PHPTRAVELS
    Copyright:      2012 - 2022 @ phptravels.com
    License:        https://phptravels.com/terms-and-conditions/
    Purchase:       https://phptravels.com/order
    Demo:           https://phptravels.com/demo
    -->

    <head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="PHPTRAVELS">
    <base href="<?php echo base_url(); ?>" />
    <script>var base_url = '<?php echo base_url(); ?>'; </script>
    <!-- <script src="<?php echo base_url(); ?>assets/include/pace/pace.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/include/pace/dataurl.css" rel="stylesheet" /> -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/global/favicon.png">

    <?php if(empty($dontload)){ ?><script src="<?php echo base_url(); ?>assets/include/ckeditor/ckeditor.js"></script><?php } ?>
    <script src="<?php echo base_url();?>assets/js/jquery-1.11.2.js"></script>

    <link href="<?php echo base_url(); ?>assets/include/alert/css/alert.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/include/alert/themes/default/theme.css" rel="stylesheet" />
    <script src="<?php echo base_url();?>assets/include/alert/js/alert.js"></script>
    <script src="<?php echo base_url();?>assets/include/jquery-form/jquery.form.min.js"></script> 

    <!--[if lte IE 8]>
    <script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/excanvas.min.js"></script>
    <![endif]-->
    
    <link href="<?php echo base_url(); ?>assets/include/select2/select2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/include/select2/select2-default.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/include/select2/select2.min.js"></script>

    <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet">
    <link href="../modules/app.css" rel="stylesheet">

    <style>.sb-customizer-toggler{display:none !important}</style>
    </head>
    <body class="nav-fixed bg-light">

    <div class="bodyload">
    <div class="rotatingDiv"></div>
    </div>

    <script>
    setTimeout(function() { $('.bodyload').fadeOut(); }, 500);

    // delegate all clicks on "a" tag (links)
    $(document).on("click", ".drawer-menu .drawer-menu-nested nav a,.drawer-menu .navload a,.loadeffect", function () {
    var newUrl = $(this).attr("href");

    // veryfy if the new url exists or is a hash
    if (!newUrl || newUrl[0] === "#") { location.hash = newUrl; return; }
    $('.bodyload').fadeIn();
    location = newUrl;
    // prevent the default browser behavior.
    return false;
    });

    </script>


    <?php include 'head.php'; ?>

    <!-- Layout content-->
    <div id="layoutDrawer_content">
        
    <!-- Main page content-->
    <main>

    <div class="container-xl p-4">