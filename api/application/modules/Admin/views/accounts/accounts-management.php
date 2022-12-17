<style>
.form-horizontal .radio, .form-horizontal .checkbox { min-height: 20px; margin-right: 10px;}
.list-unstyled { margin-bottom: 0px }
.list-unstyled label { margin-bottom: 0px }
.permissions .panel-heading { padding : 10px 15px}
.permissions .panel { margin-bottom : 10px }
.select2-container .select2-choice { height: 44px; line-height: 1.42857143; border-radius: 4px; }
.select2-container .select2-choice > .select2-chosen { line-height: 30px; }
.select2-container .select2-choice .select2-arrow b, .select2-container .select2-choice div b { background-position: 0 9px; }
</style>

<?php
    $validationerrors = validation_errors();
    if(isset($errormsg) || !empty($validationerrors)){
    ?>
<div class="alert alert-danger">
    <i class="fa fa-times-circle"></i>
    <?php
        echo @$errormsg;
        echo $validationerrors; ?>
</div>
<?php } ?>

<form class="row" action="" method="POST" enctype="multipart/form-data">

<div class="row gx-3">
  <div class="col-lg-8">
    <!-- Change password card-->
    <div class="card card-raised mb-5" style="">
      <div class="card-body p-5">
        <div class="card-title"><?= $headertitle;?></div>
        <div class="card-subtitle mb-4">Update or modify personal details</div>

                <div class="row">

                    <!-- <div class="row form-group mb-3">
                        <label class="col-md-3 control-label text-left">Business Name</label>
                        <div class="col-md-9">
                            <mwc-textfield name="site_title" label="Business Name" outlined="" value="PHPTRAVELS"></mwc-textfield>
                        </div>
                    </div> -->

                    <div class="col-md-6 mb-3">
                        <div class="form-group ">
                            <label class="required">First Name</label>
                            <input class="form-control" type="text" placeholder="First name" name="fname" value="<?php echo setFrmVal(@$profile[0]->ai_first_name,set_value('fname')); ?>">
                        </div>
                    </div>


                    <div class="col-md-6 mb-3">
                        <div class="form-group ">
                            <label class="required">Last Name</label>
                            <input class="form-control" type="text" placeholder="Last name" name="lname" value="<?php echo setFrmVal(@$profile[0]->ai_last_name,set_value('lname')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group ">
                            <label class="required">Email</label>
                            <input class="form-control" type="email" placeholder="Email address" name="email" value="<?php echo setFrmVal(@$profile[0]->accounts_email,set_value('email')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group ">
                            <label class="required">Password</label>
                            <input class="form-control" type="password" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group ">
                            <label class="required">Mobile Number</label>
                            <input class="form-control" type="text" placeholder="Mobile Number" name="mobile" value="<?php echo setFrmVal(@$profile[0]->ai_mobile,set_value('mobile')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group ">
                            <label class="required">Country</label>
                            <select class="chosen-select" name="country" id="">
                                <option value="">Please Select</option>
                                <?php foreach($countries as $c){ ?>
                                <option value="<?php echo $c->iso2;?>" <?php if(setFrmVal(@$profile[0]->ai_country,set_value('country')) == $c->iso2){ echo "selected"; }?> ><?php echo $c->short_name;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group ">
                            <label class="required">Address 1</label>
                            <input class="form-control" type="text" placeholder="Full address" name="address1" value="<?php echo setFrmVal(@$profile[0]->ai_address_1,set_value('address1')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group ">
                            <label class="required">Address 2</label>
                            <input class="form-control" type="text" placeholder="Full address" name="address2" value="<?php echo setFrmVal(@$profile[0]->ai_address_2,set_value('address2')); ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php if($profile[0]->accounts_verified == '0'){ ?>
                        <div class="col-md-6 mb-3">
                        <div class="col-md-12">
                            <div class="row">
                                <span id="<?php echo $profile[0]->accounts_id;?>" class="btn btn-primary pull-right verify">Send Verification Details</span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <?php if($type == "supplier"){ ?>
                        <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label>Supplier For </label>
                            <select name="applyfor" class="form-control">
                                <?php foreach($modules as $md): ?>
                                <option value="<?php echo $md->name;?>" <?php makeSelected($md->name,$appliedFor); ?> > <?php echo $md->name; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" placeholder="Name" name="itemname" value="<?php echo @$propertyName;?>">
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-6 mb-3">
                        <div class="col-md-12">
                            <div class="row">
                                <label>
                                <input class="checkbox" type="checkbox" name="newssub" value="1" <?php if(setFrmVal(@$isSubscribed,set_value('newssub'))){ echo "checked"; }?> > &nbsp; <strong>Email Newsletter Subscriber</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                   
    
            </div>
            <div class="text-end">
            <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
            </div>
            <input type="hidden" name="<?php echo $viewtype;?>" value="1" />
            <input type="hidden" name="type" value="<?php echo $type;?>" />
            <input type="hidden" name="oldemail" value="<?php echo @$profile[0]->accounts_email;?>" />
      </div>
    </div>

    <?php if($type == "supplier"){ ?>
    <div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Modules</div>
        <div class="card-subtitle mb-4">Assigned modules and services</div>
      
                   <div class="clearfix"></div>
                    <?php if($type == "supplier"){  if(@$chkinghotels){ ?>
                    <div class="col-md-12 mb-3">
                        <div class="form-group ">
                            <label class="required">Assign Hotels</label>
                            <select class="chosen-multi-select" name="hotels[]" id="" multiple>
                                <?php foreach($hotels as $hotel){ ?>
                                <option value="<?php echo $hotel->hotel_id;?>" <?php if(in_array($hotel->hotel_id,@$userhotels)){ echo "selected"; } ?> ><?php echo $hotel->hotel_title;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } if(@$chkingtours){ ?>
                        <div class="col-md-12 mb-3">
                        <div class="form-group ">
                            <label class="required">Assign Tours</label>
                            <select class="chosen-multi-select" name="tours[]" id="" multiple>
                                <?php foreach($tours as $tour){ ?>
                                <option value="<?php echo $tour->tour_id;?>" <?php if(in_array($tour->tour_id,@$usertours)){ echo "selected"; } ?> ><?php echo $tour->tour_title;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                        <!-- <div class="col-md-12">
                            <div class="form-group ">
                                <label class="required">Assign Rentals</label>
                                <select class="chosen-multi-select" name="rentals[]" id="" multiple>
                                    <?php foreach($rentals as $rental){ ?>
                                        <option value="<?php echo $rental->rental_id;?>" <?php if(in_array($rental->rental_id,@$userrentals)){ echo "selected"; } ?> ><?php echo $rental->rental_title;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div> -->
                    <?php  if(@$chkingcars){ ?>
                        <div class="col-md-12 mb-3">
                        <div class="form-group ">
                            <label class="required">Assign Cars</label>
                            <select class="chosen-multi-select" name="cars[]" id="" multiple>
                                <?php foreach($cars as $car){ ?>
                                <option value="<?php echo $car->car_id;?>" <?php if(in_array($car->car_id,@$usercars)){ echo "selected"; } ?> ><?php echo $car->car_title;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>

        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
      </div>
    </div>
    <?php } ?>

    
    
</div>
  <div class="col-lg-4">
    <div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Settings</div>
        <div class="card-subtitle mb-5">Configuration & Status</div>
        <!-- Account privacy optinos-->
        
        <div class="panel panel-default">
 
                <div class="form-group row mb-3">
                    <label class="required col-md-4" style="line-height:30px">Status</label>
                    <div class="col-md-8">
                        <select name="status" class="form-select">
                            <option value="yes" <?php  makeSelected($profile[0]->accounts_status,"yes"); ?>>Enabled</option>
                            <option value="no"  <?php  makeSelected($profile[0]->accounts_status,"no"); ?> >Disabled</option>
                        </select>
                    </div>
                </div>

                <?php if($type == "supplier"){ ?>
                    <div class="form-group row mb-3">
                    <label class="required col-md-4" style="line-height:30px">Comission</label>
                    <div class="col-md-8">
                      <input name="commission" value="<?php echo @$profile[0]->commission;?>" class="form-control" placeholder="Comission Percentage">
                    </div>
                </div>
                <?php } ?>


                <div class="form-group row mb-3">
                    <label class="required col-md-4" style="line-height:30px">Currency</label>
                    <div class="col-md-8">
                        <select name="currency" class="form-select">
                            <?php foreach ($currencies as $curr){?>
                                <option value="<?php echo $curr->name;?>" <?php if(setFrmVal(@$profile[0]->currency,set_value('currency')) == $curr->name){ echo "selected"; }?> ><?php echo $curr->name;?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <?php //if ($type == "supplier"){ ?>
                    <div class="form-group row mb-3">
                    <label class="required col-md-4" style="line-height:30px">Balance</label>
                    <div class="col-md-8">
                        <input name="balance" value="<?php echo @$profile[0]->balance;?>" class="form-control" placeholder="Balance">
                    </div>
                </div>
                <?php // } ?>

             
        </div>

    </div>
    </div>

    <?php if($type == "admin" || $type == "supplier"){   ?>

    <div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Permissions</div>
        <div class="card-subtitle mb-4">
            Modules add edit remove previliges
        </div>


        
        
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add</div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <?php
                                        foreach($modules as $md):
                                        ?>
                                    <li>

                                        <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "add".$md->name;?>" <?php if(in_array("add".$md->name,$permitted) || set_value('permissions[]') == "add".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> <?php echo ucfirst($md->name);?></label>
                                        </div>

                                    </li>
                                    <?php endforeach; ?>
                                    <li>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "addbooking".$md->name;?>" <?php if(in_array("addbooking".$md->name,$permitted) || set_value('permissions[]') == "addbooking".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> Bookings </label>
                                        </div>

                                        <!-- <label>
                                        <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "addbooking";?>" <?php if(in_array("addbooking",$permitted) || set_value('permissions[]') == "addbooking"){ echo "checked"; } ?>   > 
                                        </label> -->
                                    </li>
                                    <li>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "addlocations".$md->name;?>" <?php if(in_array("addlocations".$md->name,$permitted) || set_value('permissions[]') == "addlocations".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> Locations </label>
                                        </div>

                                        <!-- <label>
                                        <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "addlocations";?>" <?php if(in_array("addlocations",$permitted) || set_value('permissions[]') == "addlocations"){ echo "checked"; } ?>   > 
                                        </label> -->
                                    </li>
                                    <!--    <li>
                                        <label>
                                                <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "addextras";?>" <?php if(in_array("addextras",$permitted) || set_value('permissions[]') == "addextras"){ echo "checked"; } ?>   > Extras
                                        </label>
                                        </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <?php foreach($modules as $md): ?>
                                    <li>

                                        <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "edit".$md->name;?>" <?php if(in_array("edit".$md->name,$permitted) || set_value('permissions[]') == "edit".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> <?php echo ucfirst($md->name);?></label>
                                        </div>
                                    

                                        <!-- <label>
                                        <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "edit".$md->name;?>" <?php if(in_array("edit".$md->name,$permitted) || set_value('permissions[]') == "edit".$md->name){ echo "checked"; } ?>  > <?php echo ucfirst($md->name);?>
                                        </label> -->
                                    </li>
                                    <?php endforeach; ?>
                                    <li>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "editbooking".$md->name;?>" <?php if(in_array("editbooking".$md->name,$permitted) || set_value('permissions[]') == "editbooking".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> Bookings </label>
                                        </div>


                                        <!-- <label>
                                        <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "editbooking";?>" <?php if(in_array("editbooking",$permitted) || set_value('permissions[]') == "editbooking"){ echo "checked"; } ?>   > Bookings
                                        </label> -->
                                    </li>
                                    <li>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "editlocations".$md->name;?>" <?php if(in_array("editlocations".$md->name,$permitted) || set_value('permissions[]') == "editlocations".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> Locations </label>
                                        </div>


                                        <!-- <label>
                                        <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "editlocations";?>" <?php if(in_array("editlocations",$permitted) || set_value('permissions[]') == "editlocations"){ echo "checked"; } ?>   > Locations
                                        </label> -->
                                    </li>
                                    <!--   <li>
                                        <label>
                                                <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "editextras";?>" <?php if(in_array("editextras",$permitted) || set_value('permissions[]') == "editextras"){ echo "checked"; } ?>   > Extras
                                        </label>
                                        </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">Remove</div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <?php foreach($modules as $md): ?>
                                    <li>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "delete".$md->name;?>" <?php if(in_array("delete".$md->name,$permitted) || set_value('permissions[]') == "delete".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> <?php echo ucfirst($md->name);?></label>
                                        </div>

<!-- 
                                        <label>
                                        <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "delete".$md->name;?>" <?php if(in_array("delete".$md->name,$permitted) || set_value('permissions[]') == "delete".$md->name){ echo "checked"; } ?>  > <?php echo ucfirst($md->name);?>
                                        </label> -->
                                    </li>
                                    <?php endforeach; ?>
                                    <li>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "deletebooking".$md->name;?>" <?php if(in_array("deletebooking".$md->name,$permitted) || set_value('permissions[]') == "deletebooking".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> Bookings </label>
                                        </div>


                                        <!-- <label>
                                        <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "deletebooking";?>" <?php if(in_array("deletebooking",$permitted) || set_value('permissions[]') == "deletebooking"){ echo "checked"; } ?>   > Bookings
                                        </label> -->
                                    </li>
                                    <li>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" name="permissions[]" value="<?php echo "deletelocations".$md->name;?>" <?php if(in_array("deletelocations".$md->name,$permitted) || set_value('permissions[]') == "deletelocations".$md->name){ echo "checked"; } ?> >
                                        <label class="form-check-label" for="flexSwitchCheckDefault"> Bookings </label>
                                        </div>

                                        <!-- <label>
                                        <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "deletelocations";?>" <?php if(in_array("deletelocations",$permitted) || set_value('permissions[]') == "deletelocations"){ echo "checked"; } ?>   > Locations
                                        </label> -->
                                    </li>
                                    <!-- <li>
                                        <label>
                                                <input class="checkbox" type="checkbox" name="permissions[]" value="<?php echo "deleteextras";?>" <?php if(in_array("deleteextras",$permitted) || set_value('permissions[]') == "deleteextras"){ echo "checked"; } ?>   > Extras
                                        </label>
                                        </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
               
        <br>
        <br>
        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
        <!-- <button class="btn btn-text-danger mdc-ripple-upgraded" type="button">I understand, delete my account</button> -->
      </div>
      <?php } ?>




      <?php if($type == "agent"){ ?>
    <div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Agency Details</div>
        <div class="card-subtitle mb-4">
          Agency business details
        </div>


        <div class="form-group row mb-3">
                <label class="required col-md-12" style="line-height:30px">Agency Name</label>
                <div class="col-md-12">
                    <input name="agency_name" value="<?php echo @$profile[0]->agency_name;?>" class="form-control" placeholder="Agency Name">
                </div>
                </div>

                <div class="form-group row mb-3">
                <label class="required col-md-12" style="line-height:30px">Agency Phone</label>
                <div class="col-md-12">
                    <input name="agency_phone" value="<?php echo @$profile[0]->agency_phone;?>" class="form-control" placeholder="Agency Phone">
                </div>
                </div>

                <div class="form-group row mb-3">
                <label class="required col-md-12" style="line-height:30px">Registration No</label>
                <div class="col-md-12">
                    <input name="registration_no" value="<?php echo @$profile[0]->registration_no;?>" class="form-control" placeholder="Registration No">
                </div>
                </div>

                <div class="form-group row mb-3">
                <label class="required col-md-12" style="line-height:30px">Agency Logo</label>
                <div class="col-md-12">
                    <input type="file" name="agency_logo" value="" class="form-control">
                </div>
                </div>


                <?php if (!empty(@$profile[0]->agency_logo)) {?>
                        <input type="hidden" value="<?=@$profile[0]->agency_logo?>" name="agenyimage">
                <img id="show" class="img-responsive" src="<?php echo base_url('uploads/images/accounts/').@$profile[0]->agency_logo?>" alt="logo" />
                <script>
                logo.onchange = evt => {
                const [file] = logo.files
                if (file) { show.src = URL.createObjectURL(file) }
                }
                </script>
                <?php } ?>

                <!-- <div class="form-group">
                    <label class="required col-md-4" style="line-height:30px">Status</label>
                    <div class="col-md-8">
                        <select name="status" class="form-control">
                            <option value="yes" <?php  makeSelected($profile[0]->accounts_status,"yes"); ?>>Enabled</option>
                            <option value="no"  <?php  makeSelected($profile[0]->accounts_status,"no"); ?> >Disabled</option>
                        </select>
                    </div>
                </div> -->
        
        
               
        <br>
        <br>
        <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
       </div>

       <?php } ?>





    </div>
  </div>
</div>

<?php if($type == "admin" || $type == "supplier" || $type == "agent") { } else { ?>
</div>
<?php } ?>

</form>

<script type="text/javascript">
$(function(){
$(".verify").on("click",function(){
var id = $(this).prop('id');
var accType = "<?php echo $type;?>";
var ask = confirm("Proceed to Verify this user.");
if(ask){
$.post("<?php echo base_url();?>admin/ajaxcalls/verifyAccount", {id: id, accType: accType}, function(resp){
location.reload();
});
}else{
return false;
}
})
})
</script>
