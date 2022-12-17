<!--<a href="<?=base_url("admin/modules/add")?>" class="btn btn-warning form-group" role="button"><strong>Add Module</strong></a>-->

<style>.rows{--bs-gutter-x: 3rem;}</style>
<header class="bg-primary row mb-2 rows mainhead">
  <div class="container-xl p-2 px-3">
      <div class="row align-items-center justify-content-between">
          <div class="col-12 col-md mb-4 mb-md-0">
              <!-- <h1 class="mb-1 display-4 fw-500 text-white">Welcome back, Robert!</h1> -->
              <p class="lead mb-0 text-white"><small>Modules</small></p>
          </div>
          <div class="col-12 col-md-auto flex-shrink-0">
          </div>
  </div>
</header>

<div class="panel-group"  style="padding:15px 0">
<div class="row">

<?php
foreach($all_mod_name as $item){?>

 <div class="col-md-12">

 <?php  foreach($all_main as $module1 => $mod_value) { if (strtolower($mod_value['parent_id']) == $item->parent_id) { $count++;?>
 
<div class="card card-raised card-collapsible mb-5 M_<?=$item->parent_id?>" id="usersCollapse">
    <div style="background-color: #dee0e6 !important;height: 60px; display: flex; align-items: center; padding: 12px 10px 0px 5px;" class="card-header bg-transparent mdc-ripple-upgraded" data-bs-toggle="collapse" data-bs-target="#<?=$item->parent_id?>" aria-expanded="true" aria-controls="usersCollapseContent" style="--mdc-ripple-fg-size:216px; --mdc-ripple-fg-scale:1.74998; --mdc-ripple-fg-translate-start:137.8px, -79.8px; --mdc-ripple-fg-translate-end:72.0313px, -70px;">
        <div class="d-flex align-items-center">
            <!-- <i class="material-icons text-primary">person</i> -->
            <div class="ms-3">
                <!-- <div class="fs-10 mb-1 fw-500"><?php echo $count; ?> - <?=$item->parent_id?></div> -->
                <div class="fs-10 mb-1 fw-500"><h5 style="display: flex; gap: 13px; text-transform: uppercase; font-weight: bolder;">
                  
                <span class="material-icons">
                label_important
                </span>
                <?=$item->parent_id?> <span style="font-weight: 100;">Modules</span>
                </h5> </div>
                <div class="small">
                </div>
            </div>
        </div>
        <i class="material-icons card-header-icon">expand_less</i>
    </div>
    <div class="card-body px-0 collapse show" id="<?=$item->parent_id?>" data-bs-parent="#usersCollapse" style="">

    <span class="mx-4 d-flex justify-content-end">
    <span  style="font-weight: 100; font-size: 14px; display: flex; align-items: center; margin-right: 10px;"> <small>Module Order</small> </span>
    <input style="width: 70px; height: 30px;" class="order form-control w-40 text-center" type="number" id="order_<?php echo $mod_value['parent_id'];?>" onblur="updateOrder($(this).val(),<?php echo $mod_value['parent_id'];?>,<?php echo $mod_value['order'];?>)" value="<?php echo $mod_value['order'];?>"><?php } } ?>

<?php if ($item->parent_id != 'extra') {?>
<button class="btn btn-outline-dark mx-2" style="height:30px">Update</button>
<?php } ?> 

    </span>

    <div id="<?=$item->parent_id?>" class="p-3" role="tabpanel" aria-labelledby="">
     <div class="row" style="">
         
        <?php $index = 1;
        $count = 0;
        ?>
        <?php foreach($modules as $module) { if ($module->parent_id == $item->parent_id) { $count++;?>


          <?php echo $module->icon; ?>

          <?php 
          
          // strip out all whitespace
          $zname_clean = preg_replace('/\s*/', '', $module->label);
          // convert the string to all lowercase
          $z = strtolower($zname_clean);

          ?>
          
<div class="col-md-4 col-lg-6 col-xxl-3 mb-4 mb-lg-3 mb-3 modules_<?php echo $module->label; ?>">
    <div class="card card-quick-link card-raised ripple-gray mdc-ripple-upgraded" style="--mdc-ripple-fg-size:162px; --mdc-ripple-fg-scale:1.94303; --mdc-ripple-fg-translate-start:108.8px, 4px; --mdc-ripple-fg-translate-end:54.3562px, -11px;">
        <div class="card-body">
            <img class="card-quick-link-img" src="<?=base_url()?>assets/img/modules/<?=$z?>.png" style="border-radius: 6px;">
            <div class="card-title text-truncate mb-2"> <?php echo $module->label; ?> </div>
            <p class="card-text">To configure or setup credentials click on settings</p>
        </div>
        <div class="card-actions">

        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Module Color" style="background:<?php if ($module->parent_id != 'extra') {if(!isset($module->color)){ echo "#000"; } else { echo $module->color; }} ?>;width: 15px; height: 15px; position: absolute; z-index: 1; top: 14px; right: 18px; border-radius: 12px;"></span>  

        <?php if($module->label == 'Hotels') {  ?>
        <a href="<?php echo base_url(); ?>admin/<?php echo $module->slug; ?>/settings/">
        <button class="btn btn-danger btn-sm pull-left" style="height:22px;line-height: 12px;margin-right: 5px;"><i class="fa fa-cog mx-1"></i> Settings</button>
        </a>

        <?php }
        if($module->label == 'Tours'){ ?>
            <a href="<?php echo base_url(); ?>admin/<?php echo $module->slug; ?>/settings/">
        <button class="btn btn-danger btn-sm pull-left" style="height:22px;line-height: 12px;margin-right: 5px;"><i class="fa fa-cog mx-1"></i> Settings</button>
        </a>
        <?php }
        if (!empty($module->slug) && $module->label != 'Hotels' && $module->label != 'Tours'): ?>
        <a href="<?php echo base_url(); ?>admin/settings/modules/module_setting/<?php echo $module->slug; ?>/">
        <button class="btn btn-danger btn-sm pull-left" style="height:22px;line-height: 12px;margin-right: 5px;"><i class="fa fa-cog mx-1"></i> Settings</button>
        </a>
        <?php endif; ?>
        <label class="form-check-label" for="<?php echo $module->name; ?>">Status</label>

        <!-- <input value="<?php echo $module->order;?>" data-modulename="<?php echo $module->name;?>" type="number" id="order_set" class="input-sm form-control pull-left <?php echo $module->name;?>" style="width:60px;height:22px;margin-right: 5px;"/> -->
        <label class=" ellipsis pull-right">

      <div class="form-check form-switch">
      <label class="form-check-label" for="<?php echo $module->name; ?>"></label>
      <input <?php if($module->active == 1){echo "checked";}?> class="form-check-input" data-value="<?php echo $module->name; ?>" data-item="<?php echo $item->parent_id; ?>" id="checkedbox" type="checkbox">
      </div>

          <!-- <input type="checkbox" id="" name="" value="1" <?php if($module->active == 1){echo "checked";}?> data-value="<?php echo $module->name; ?>" data-item="<?php echo $item->parent_id; ?>" /> -->
        </label>

            <!-- <a class="card-link text-muted text-decoration-none stretched-link btn btn-danger px-3" style="color: #fff!important; font-size: 10px;" href="<?php echo base_url(); ?>admin/<?php echo $module->slug; ?>/settings/">settings</a>

            <div class="form-check form-switch">
            <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox">
            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
            </div> -->

            <!-- <i class="material-icons text-muted rotate-45">arrow_upward</i> -->
        </div>
        
    </div>
</div>


        <?php } } ?>
      </div>
    </div>
  </div>

 
    </div>
</div>

 <?php } ?>

 <div class="d-flex mb-5 credentials" style="margin-bottom:100px !important">
 <form action="<?php echo base_url("admin/settings/modules/modules_update/");?>" method="POST">
    <input class="btn btn-outline-dark" name="update" value="update modules" type="submit">
</form>
<form action="<?php echo base_url("admin/settings/modules/modules_reset/");?>" method="POST">
    <input class="btn btn-outline-dark mx-3 credentials" name="reset" value="Reset All Modules Credentials" type="submit">
</form>

</div>

</div>
</div>

<!--<div class="row">
  <?php $array = ['hotels','flights','tours','cars','visa','extra']; foreach($array as $key => $item){?>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading"><label style="width:100%"><?=$item?><span class="pull-right"></span></label></div>
      <div class="panel-body">
        <?php $index = 1; ?>
        <?php  foreach($modules as $module) { if ($module->parent_id == $item) { ?>
        <div class="zebra" style="width:100%">
          <?php echo $module->icon; ?> <?php echo $module->label; ?>
          <span class="pull-right">
            <?php if (!empty($module->slug)): ?>
            <a href="<?php echo base_url(); ?>admin/<?php echo $module->slug; ?>/settings/">
            <button class="btn btn-danger btn-sm pull-left" style="height:22px;line-height: 12px;margin-right: 5px;"><i class="fa fa-cog"></i> Settings</button>
            </a>
            <?php endif; ?>
            <input value="<?php echo $module->order;?>" data-modulename="<?php echo $module->name;?>" type="number" id="order_set" class="input-sm form-control pull-left <?php echo $module->name;?>"
              style="width:60px;height:22px;margin-right: 5px;"/>
            <label class="control control--checkbox ellipsis pull-right">
              <input type="checkbox" id="checkedbox" name="" value="1" <?php if($module->active == 1){echo "checked";}?> data-value="<?php echo $module->name; ?>" data-item="<?php echo $item; ?>" />
              <div class="control__indicator"></div>
            </label>
          </span>
        </div>
        <?php } }?>
      </div>
    </div>
  </div>
  <?php } ?>
</div>-->

 
<style>

.form-switch .form-check-input {height: 24px;width:2.7rem;cursor:pointer}

   #order_set{height:25px !important}
  .btn-enable{background-color:#00bd00;color:white}
  .btn-enable:hover{background-color:#00a300;color:white}
  .btn-disable{color:#fff;background-color:#f70000;border-color:#c00}
  .btn-disable:hover{color:#fff;background-color:#e60000;border-color:#c00}
   td{text-transform:uppercase;letter-spacing:2px;font-weight:600}
  .input-sm{height:28px;padding:1px 10px;font-size:12px}
  .table>thead>tr>th,.table>tbody>tr>th,.table>tfoot>tr>th,.table>thead>tr>td,.table>tbody>tr>td,.table>tfoot>tr>td{line-height:2}
  /*============================================================================================*/
  /* Radio-Check */
 /*============================================================================================*/
    /* input[type="checkbox"]:focus{outline: none;}
    input[type="checkbox"]{top:0px;margin:0px 5px;-webkit-appearance:none;-moz-appearance:none;appearance:none;width:2.2rem;height:1.8rem !important;position:relative;cursor:pointer}
    input[type="checkbox"]::after{content:"";position:absolute;top:0;right:0;bottom:0;left:0;color:rgba(255,255,255,0);background-color:white;border-radius:2px;box-shadow:inset 0 0 0 2px #949494;font-size:0rem;font-weight:bolder;line-height:2rem;text-align:center;transition:background-color 100ms 0ms ease,color 100ms 100ms ease,font-size 100ms 100ms ease;}
    input[type="checkbox"]:hover::after{content:"";position:absolute;top:0;right:0;bottom:0;left:0;color:rgba(255,255,255,0);background-color:#F2F2F2;border-radius:2px;box-shadow:inset 0 0 0 2px #383838;font-size:0rem;font-weight:bolder;text-align:center;transition:background-color 100ms 0ms ease,color 100ms 100ms ease,font-size 100ms 100ms ease;}
    input[type="checkbox"]:checked::after{border-radius: 5px;content:"\02714";color:white;background-color:#3056d3;font-size:0.7rem;line-height:2rem; box-shadow:inset 0 0 0 2px #1f40ac; }

    input[type="radio"]:focus{outline: none;}
    input[type="radio"]{top:0px;margin:0px 5px;-webkit-appearance:none;-moz-appearance:none;appearance:none;width:3.2rem;height:3.2rem;position:relative;cursor:pointer;}
    input[type="radio"]::after{content:"";position:absolute;top:0;right:0;bottom:0;left:0;color:rgba(255,255,255,0);background-color:white;border-radius:15px;box-shadow:inset 0 0 0 2px #949494;font-size:0rem;font-weight:bolder;line-height:2rem;text-align:center;transition:background-color 100ms 0ms ease,color 100ms 100ms ease,font-size 100ms 100ms ease;}
    input[type="radio"]:hover::after{content:"";position:absolute;top:0;right:0;bottom:0;left:0;color:rgba(255,255,255,0);background-color:#F2F2F2;border-radius:15px;box-shadow:inset 0 0 0 2px #383838;font-size:0rem;font-weight:bolder;text-align:center;transition:background-color 100ms 0ms ease,color 100ms 100ms ease,font-size 100ms 100ms ease;}
    input[type="radio"]:checked::after{border-radius:15px;content:"\02714";color:white;background-color:#3056d3;font-size:1rem;line-height:3.3rem; box-shadow:inset 0 0 0 2px #1f40ac; } */

    .control{display:block;position:relative;padding-left:30px;margin-bottom:2px;cursor:pointer;font-size:14px;padding-top:2px}
    .control:hover input~.control__indicator,.control input:hover~.control__indicator{background:#ccc}
    /* input[type="checkbox"]:checked::after { border-radius: 5px; content: "\02714"; color: white; background-color: #000000; font-size: 0.7rem; line-height: 2rem; box-shadow: inset 0 0 0 2px #000000; } */
  /*============================================================================================*/
  /* Radio-Check */
  /*============================================================================================*/
</style>
<!--<div class="panel panel-default">
  <button class="btn btn-primary pull-right" style="margin-top:10px;margin-right:10px" id="order_reset">Reset modules order</button>
  <div class="panel-heading">Primary Modules</div>
  <div class="panel-body">
  <form id="docsSearch" class="form-group">
    <div style="width: 100%;" class="input-group">
        <i class="fa fa-search" style="position: absolute; z-index: 9999; left: 15px; top: 15px;"></i>
        <input style="padding-left:35px" type="text" id="docsQuery" class="form-control input-lg" placeholder="Search Module" autocomplete="off">
    </div>
   </form>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th class="col-md-1 text-center">No</th>
          <th class="col-md-5"><i class="fa fa-laptop"></i> Modules</th>
          <th class="col-md-2 text-center"><i class="fa fa-info-circle"></i> Status</th>
          <th class="text-center" style="min-width: 200px;position: static; float: none; display: table-cell;"><i class="fa fa-wrench"></i> Configuration</th>
          <th class="col-md-1 text-center"><i class="fa fa-cog"></i> Order by</th>
          <th class="col-md-1 text-center"><i class="fa fa-wrench"></i> Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $index = 1; ?>
        <?php  foreach($modules as $module): ?>
        <?php
    $label = 'Disabled';
    $statusClass = 'btn btn-sm btn-disable';
    if($module->active) {
        $label = 'Enabled';
        $statusClass = 'btn btn-sm btn-enable';
    }
    ?>
        <?php
    $label = 'Disabled';
    $TR = 'background-color:#fef7f7';
    if($module->active) {
        $label = 'Enabled';
        $TR = 'background-color:#e3f8df';
    }
    ?>
        <?php
    $label = 'Disabled';
    $STATUS = 'Disabled';
    if($module->active) {
        $label = 'Enabled';
        $STATUS = 'Enabled';
    }
    ?>
        <tr data-name="<?php echo $module->name;?>" id="document" style="<?= $TR ?>">
          <td class="text-center"><?=$module->order?></td>
          <td><?=$module->label?></td>
          <td class="text-center">
            <?=$STATUS;?>
          </td>
          <td>
            <button class="<?= $statusClass ?> pull-left" id="moduleStatus" data-modulename="<?php echo $module->name;?>">
            <i class="fa fa-external-link"></i> <span class="moduleStatusText"><?= $label ?></span>
            </button>
            <?php if( ! empty($module->slug) ): ?>
            <a href="<?php echo base_url(); ?>admin/<?php echo $module->slug;?>/settings/">
            <button class="btn btn-sm btn-primary pull-right"><i class="fa fa-gear"></i> Settings</button>
            </a><?php endif; ?>
          </td>
          <td><input value="<?php echo $module->order;?>" data-modulename="<?php echo $module->name;?>" type="number" id="order_set"  class="text-center form-control input-sm <?php echo $module->name;?>"/></td>
          <td>
            <div style="min-width:200px">
             <a class="btn btn-sm btn-success" href="<?=base_url('admin/modules/edit/'.strtolower($module->name)) ?>">Edit</a>
             <button type="button" class="btn btn-sm btn-danger" data-p="<?=$module->name?>" id="delete_module" >Delete</button>
             <button class="btn btn-sm btn-default pull-right" id="moduleOrder" data-order="up" data-modulename="<?php echo $module->name;?>">
              <span class="fa fa-arrow-up"></span>
              </button>
              <button class="btn btn-sm btn-default pull-right" id="moduleOrder" data-order="down" data-modulename="<?php echo $module->name;?>">
              <span class="fa fa-arrow-down"></span>
              </button>
            </div>
          </td>
        </tr>
        <?php $index += 1; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  </div>-->
<script>
  $("#delete_module").click(function (e) {
      var value = $("#delete_module").data("p")
      $.alert.open('Danger', 'Are you sure you want to delete this module', function(answer) {
      if (answer == 'ok') {
          //alert('<?//=base_url('admin/modules/delete/') ?>//'+value)
          window.location.href = '<?=base_url('admin/modules/delete/') ?>'+value;
      }
      });
  });
  //  $('[id=moduleStatus]').on("click", function() {
  //      var btnStatus = $(this);
  //      var statusText = btnStatus.find('span.moduleStatusText').text();
  //      statusText = (statusText == 'Enabled') ? 'Disable' : 'Enable';
  //      $.alert.open('confirm', 'Are you sure you want to '+statusText+' it', function(answer) {
  //          if (answer == 'yes') {
  //              var payload = { 'modulename': btnStatus.data('modulename') };
  //              $.post('<?//=base_url("admin/modules/ajaxController/updateStatus")?>//', payload, function(response) {
  //                  // console.log(btnStatus.attr('class'));
  //                  // if(response.status == 'enabled') {
  //                  //     btnStatus.removeClass("btn-disable").addClass("btn-enable");
  //                  //     btnStatus.find('span.moduleStatusText').text('Enabled');
  //                  // } else if(response.status == 'disabled') {
  //                  //     btnStatus.removeClass("btn-enable").addClass("btn-disable");
  //                  //     btnStatus.find('span.moduleStatusText').text('Disabled');
  //                  // }
  //                  window.location.reload();
  //              });
  //          }
  //      });
  //  });

  $('[id=checkedbox]').on('click', function() {
      var name = $(this).data("value");
      var item = $(this).data("item");
      var isChecked = this.checked;
      // alert(isChecked);
      var payload = { 'modulename': name,'parentid':item,'status':isChecked };
      $.post('<?=base_url("admin/modules/ajaxController/updateStatus")?>', payload, function(response) {
          // console.log(btnStatus.attr('class'));
          // if(response.status == 'enabled') {
          //     btnStatus.removeClass("btn-disable").addClass("btn-enable");
          //     btnStatus.find('span.moduleStatusText').text('Enabled');
          // } else if(response.status == 'disabled') {
          //     btnStatus.removeClass("btn-enable").addClass("btn-disable");
          //     btnStatus.find('span.moduleStatusText').text('Disabled');
          // }
         window.location.reload();
      });
  });

  $('[id=moduleOrder]').on('click', function() {
    var orderButton = $(this);
    var payload = { 'modulename': orderButton.data('modulename'), 'order': orderButton.data('order') };
    $.post('<?=base_url("admin/modules/ajaxController/updateOrder")?>', payload, function(response) {
        window.location.reload();
    });
  });

  $('[id=order_set]').on('change', function() {
    var orderButton = $(this);
    var order_number = $("." + orderButton.data('modulename')).val();
    var payload = { 'modulename': orderButton.data('modulename'), 'order': order_number };
    // alert(order_number);
    $.post('<?=base_url("admin/modules/ajaxController/order_set")?>', payload, function(response) {
        window.location.reload();
    });
  });

$('.order').bind('blur', function() {
  var id =  $(this).attr('id');
  var arr= id.split('_');
    var modulename = arr[1];
    var ordering = $("#"+id).val();
    $.ajax({
    type: 'ajax',
    method: 'post',
    async: false,
    url: '<?=base_url("admin/modules/ajaxController/main_order_set")?>',
    data:{modulename:modulename,ordering:ordering},
    dataType: 'json',
    });
    window.location.reload();
    });

  $('[id=main_order_set]').on('change', function() {
    var orderButton = $(this);
    var order_number = $("." + orderButton.data('modulename')).val();
    var payload = { 'modulename': orderButton.data('modulename'), 'ordering': order_number };
    // alert(order_number);
    $.post('<?=base_url("admin/modules/ajaxController/main_order_set")?>', payload, function(response) {
        window.location.reload();
    });
  });

  $('[id=order_reset]').on('click', function() {
    $.post('<?=base_url("admin/modules/ajaxController/order_reset")?>', function(response) {
        //alert("response");
       window.location.reload();
    });

  });
</script>
<script>
  $("#docsQuery").on("keyup", function () {
      var query = $(this).val();
      var document = $("[id^=document]");
      console.log(query);
      if (query != '') {
          $.each(document, function (i, d) {
              d = $(d);
              if (d.data('name').toLowerCase().includes(query.toLowerCase())) {
                  d.show();
              } else {
                  d.hide();
              }
          })
      } else {
          $.each(document, function (i, d) {
              $(d).show();
          })
      }
  });
  function pending_accounts(){$("li.pending_accounts").hide()}$(document).ready(function(){$("#sidebarCollapse").on("click",function(){$("#sidebar").toggleClass("active");$(".container-fluid").toggleClass("go_left");$("#content").toggleClass("p15");$(this).toggleClass("active")})});
</script>