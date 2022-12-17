<style>.rows{--bs-gutter-x: 3rem;}</style>
<header class="bg-primary row mb-2 rows mainhead">
    <div class="container-xl p-2 px-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-12 col-md mb-4 mb-md-0">
                <!-- <h1 class="mb-1 display-4 fw-500 text-white">Welcome back, Robert!</h1> -->
                <p class="lead mb-0 text-white"><small><?= $header_title; ?></small></p>
            </div>
            <div class="col-12 col-md-auto flex-shrink-0">

            <?php if(@$addpermission && !empty($add_link)){ ?>
            <form class="add_button" action="<?php echo $add_link; ?>" method="post"><button type="submit" class="btn btn-success"><i style="font-size:16px" class="material-icons">add</i> Add</button></form>
            <?php } ?>

           </div>
    </div>
</header>

    <?php echo $content; ?>
     
    <script>
    function show_packages(id){
    var base_url = "<?=base_url()?>";
    $('#iframe').attr('src',base_url+'admin/tours/dates?id='+id);
    $('#packages').modal('show');
    }
    </script>
    <div id="packages" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="padding-left: 250px;width:100%; margin: 0px; height: 100vh;">
    <!-- Modal content-->
    <div class="modal-content" style="border-radius: 0px; border: 0px;">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><strong>Tour Packages</strong></h4>
    </div>
    <div class="modal-body" style="background:#f7f7f7">
    <iframe id="iframe" style="width:100%;height:80vh" src="" frameborder="0" scrolling="no"></iframe>
    </div>
    </div>
    <div class="panel-footer" style="position:fixed;bottom:0px;width:100%;background:#fff">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    </div>
    </div>