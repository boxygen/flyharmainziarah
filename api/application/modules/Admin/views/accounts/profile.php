<form action="" method="POST">
<?php echo @$msg; ?>





<div class="row gx-3">
  <div class="col-lg-12">
     <div class="card card-raised mb-5" style="">
       <div class="card-body p-5">
           <div class="card-title">Profile Update</div>
               <div class="card-subtitle mb-4">Update or modify personal details</div>

               

<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12 mb-4">
        <div class="form-group ">
          <label class="required">Account Type</label>
          <input class="form-control" type="text" disabled="disabled" placeholder="Account Type" name="" value="<?php echo $accType;?>">
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="form-group ">
          <label class="required">First Name</label>
          <input class="form-control" type="text" placeholder="First name" name="fname" value="<?php echo $profile[0]->ai_first_name;?>">
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="form-group ">
          <label class="required">Last Name</label>
          <input class="form-control" type="text" placeholder="Last name" name="lname" value="<?php echo $profile[0]->ai_last_name;?>">
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="form-group ">
          <label class="required">Email</label>
          <input class="form-control" type="email" placeholder="Email address" name="email" value="<?php echo $profile[0]->accounts_email;?>">
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
          <input class="form-control" type="text" placeholder="Mobile Number" name="mobile" value="<?php echo $profile[0]->ai_mobile;?>">
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="form-group ">
          <label class="required">Country</label>
          <select class="chosen-select" name="country" id="">
          <option value="">Select</option>
            <?php foreach($countries as $c){ ?>
            <option value="<?php echo $c->iso2;?>" <?php if($profile[0]->ai_country == $c->iso2){ echo "selected"; }?> ><?php echo $c->short_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-6 mb-3">
        <div class="form-group ">
          <label class="required">Address 1</label>
          <input class="form-control" type="text" placeholder="Full address" name="address1" value="<?php echo $profile[0]->ai_address_1;?>">
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="form-group ">
          <label class="required">Address 2</label>
          <input class="form-control" type="text" placeholder="Full address" name="address2" value="<?php echo $profile[0]->ai_address_2;?>">
        </div>
      </div>
      <?php if(empty($isSuperAdmin)){ ?>
        <div class="col-md-6 mb-3">
        <div class="col-md-12">
        <div class="row">
        <label>
              <input class="checkbox" type="checkbox" name="newssub" value="1" <?php if($isSubscribed){ echo "checked"; }?> > <strong>Email Newsletter Subscriber</strong>
        </label>
        </div>
        </div>
      </div>
      <?php } ?>
      <div class="clearfix"></div>
    </div>
  </div>
   <input type="hidden" name="update" value="1" />
  <input type="hidden" name="type" value="<?php echo $profile[0]->accounts_type;?>" />
  <input type="hidden" name="status" value="<?php echo $profile[0]->accounts_status;?>" />
  <input type="hidden" name="oldemail" value="<?php echo $profile[0]->accounts_email;?>" />
 </div>
              
              <div class="text-end">
                <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
              </div>  

              </div>
         </div>
     </div>
  </div>
</div>
</div>
</div>
</div>
</div>

</form>
