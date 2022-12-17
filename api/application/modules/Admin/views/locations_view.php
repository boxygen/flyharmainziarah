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