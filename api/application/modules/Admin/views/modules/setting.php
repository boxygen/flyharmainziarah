  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>

  <form action="<?php echo base_url('admin/settings/modules/modules_save')?>" method="POST">
    <div class="card p-5">
    <div class="panel-heading">
      <h4 class="mb-3"><i class="fa fa-cog"></i> Settings Module Name</h4>
      <div class="pull-right">
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>
      <div class="panel-body">
      <div class="tab-content form-horizontal">
        <input name="modulename" type="hidden" value="<?=$modulename?>">

        <div class="row form-group mb-3">
        <div class="col-md-3">
        <mwc-textfield class="w-100" type="number" name="b2c_markup" label="B2C Markup" outlined value="<?php if(!empty($data[0]->b2c_markup)){ echo $data[0]->b2c_markup;}else{echo "0";} ?>"></mwc-textfield>
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <div class="col-md-3">
        <mwc-textfield class="w-100" type="number" name="desposit" label="Desposit on Booking" outlined value="<?php if(!empty($data[0]->desposit)){ echo $data[0]->desposit;}else{echo "0";} ?>"></mwc-textfield>
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>

        <hr class="mb-4" />

        <div class="row form-group mb-3">
        <div class="col-md-3">
        <mwc-textfield class="w-100" type="number" name="b2b_markup" label="B2B Markup" outlined value="<?php if(!empty($data[0]->b2b_markup)){ echo $data[0]->b2b_markup;}else{echo "0";} ?>"></mwc-textfield>
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <div class="col-md-3">
        <mwc-textfield class="w-100" type="number" name="tax" label="Tax Vat on Booking" outlined value="<?php if(!empty($data[0]->tax)){ echo $data[0]->tax;}else{echo "0";} ?>"></mwc-textfield>
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>

        <hr class="mb-4" />

        <div class="row form-group mb-3">
        <div class="col-md-3">
        <mwc-textfield class="w-100" type="number" name="b2e_markup" label="B2E Markup" outlined value="<?php if(!empty($data[0]->b2e_markup)){ echo $data[0]->b2e_markup;}else{echo "0";} ?>"></mwc-textfield>
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <div class="col-md-3">
        <mwc-textfield class="w-100" type="number" name="servicefee" label="Booking Service Fee" outlined value="<?php if(!empty($data[0]->servicefee)){ echo $data[0]->servicefee;}else{echo "0";} ?>"></mwc-textfield>
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>

        <hr>
        <h4>API Credentials</h4>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 1</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100 demo" type="text" name="c1" label="Credential 1" outlined value="<?php if(!empty($data[0]->c1)){ echo $data[0]->c1;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 2</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100 demo" type="text" name="c2" label="Credential 2" outlined value="<?php if(!empty($data[0]->c2)){ echo $data[0]->c2;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 3</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100 demo" type="text" name="c3" label="Credential 3" outlined value="<?php if(!empty($data[0]->c3)){ echo $data[0]->c3;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 4</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100" type="text" name="c4" label="Credential 4" outlined value="<?php if(!empty($data[0]->c4)){ echo $data[0]->c4;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 5</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100" type="text" name="c5" label="Credential 5" outlined value="<?php if(!empty($data[0]->c5)){ echo $data[0]->c5;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 6</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100" type="text" name="c6" label="Credential 6" outlined value="<?php if(!empty($data[0]->c6)){ echo $data[0]->c6;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 7</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100" type="text" name="c7" label="Credential 7" outlined value="<?php if(!empty($data[0]->c7)){ echo $data[0]->c7;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 8</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100" type="text" name="c8" label="Credential 8" outlined value="<?php if(!empty($data[0]->c8)){ echo $data[0]->c8;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 9</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100" type="text" name="c9" label="Credential 9" outlined value="<?php if(!empty($data[0]->c9)){ echo $data[0]->c9;} ?>"></mwc-textfield>
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Credential 10</label>
        <div class="col-md-4">
        <mwc-textfield class="w-100" type="text" name="c10" label="Credential 10" outlined value="<?php if(!empty($data[0]->c10)){ echo $data[0]->c10;} ?>"></mwc-textfield>
        </div>
        </div>

        <hr>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Mode</label>
        <div class="col-md-4">

        <mwc-select outlined="" label="Status" name="mode" class="w-100">
          <mwc-list-item value="1" <?=($data[0]->developer_mode == '1') ? 'selected' : '' ?> > Production</mwc-list-item>
          <mwc-list-item value="0" <?=($data[0]->developer_mode == '0') ? 'selected' : '' ?> > Development</mwc-list-item>
        </mwc-select>

        </div>
        </div>

          <div class="row form-group mb-3">
              <label class="col-md-2 control-label text-left">API mode</label>
              <div class="col-md-4">

                  <mwc-select outlined="" label="Status" name="payment_mode" class="w-100">
                      <mwc-list-item value="1" <?=($data[0]->payment_mode == '1') ? 'selected' : '' ?> >Merchant API - Booking on Site</mwc-list-item>
                      <mwc-list-item value="0" <?=($data[0]->payment_mode == '0') ? 'selected' : '' ?> > Affiliate API - Booking on other site</mwc-list-item>
                  </mwc-select>

              </div>
          </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Default Currency</label>
        <div class="col-md-4">

        <select class="w-100" type="text" name="default_currency" id="" style="height: 55px; padding: 10px; border-radius: 4px; border: 1px solid #9f9f9f; font-size: 16px;">
          <?php $ptCurrencies=ptCurrencies(); foreach($ptCurrencies as $Currencies):?>
            <option value="<?php echo $Currencies->name;?>" <?php if($data[0]->module_currency == $Currencies->name){echo 'selected';}?>><?php echo $Currencies->name;?></option>
          <?php endforeach; ?>
         </select>

         <!-- <mwc-textfield   label="Default Currency" outlined ></mwc-textfield> -->
        </div>
        </div>

        <div class="row form-group mb-3">
        <label class="col-md-2 control-label text-left">Module Color</label>
        <div class="col-md-1">
          <input style="height: 40px; padding: 6px;" type="color" id="module_color" name="module_color" class="form-control" value="<?php if(!empty($data[0]->color)){ echo $data[0]->color;} ?>">
         </div>
        </div>

      </div>
      </div>
    </div>

    <div class="mt-3">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save mx-2"></i> Submit</button>
    </div>
  </form>

<style>
.form-horizontal .control-label {   max-height: 60px;}
</style>

<script>
document.getElementById("module_color").value = "<?php if(!empty($data[0]->color)){ echo $data[0]->color;} ?>";

$('body').bind('copy',function(e) {
e.preventDefault(); return false;
});
</script>