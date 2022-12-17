<div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Contact</div>
        <div class="card-subtitle mb-4">Contact settings</div>

        <div class="panel-body">
              <div class="row form-group mb-3">
                <label class="col-md-2 control-label text-left">Phone Number</label>
                <div class="col-md-4">
                  <input class="form-control input-sm" type="text" placeholder="Phone Number" name="contact_phone" value="<?php echo $contact_data[0]->contact_phone;?>">
                </div>
              </div>
              <div class="row form-group mb-3">
                <label class="col-md-2 control-label text-left">Email</label>
                <div class="col-md-4">
                  <input class="form-control input-sm" type="text" placeholder="Email address" name="contact_email" value="<?php echo $contact_data[0]->contact_email;?>">
                </div>
              </div>
              <div class="row form-group mb-3">
                <label class="col-md-2 control-label text-left">Address</label>
                <div class="col-md-6">
                  <textarea cols="20" rows="5" type="text" class="form-control" placeholder="Office Address" name="contact_address"  /><?php echo $contact_data[0]->contact_address;?></textarea>
                </div>
              </div>
              <input type="hidden" name="contact_page_id" value="<?php echo $contact_data[0]->contact_id;?>">
            </div>

            <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
        
        </div>
    </div>

