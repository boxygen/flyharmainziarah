<div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Email settings</div>
        <div class="card-subtitle mb-4">Mailer configurations</div>

<div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left">Mailer</label>
    <div class="col-md-4">
    <select name="defmailer" class="form-select " id="mailserver">
        <option value="php" <?php if( $mailserver[0]->mail_default == "php"){ echo "selected"; } ?> >PHP Mailer</option>
        <option value="smtp" <?php if( $mailserver[0]->mail_default == "smtp"){ echo "selected"; } ?>   >SMTP</option>
    </select>
    </div>
</div>

<div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left">Email</label>
    <div class="col-md-4">
    <input type="email" name="fromemail" placeholder="Email" class="form-control" value="<?php echo $mailserver[0]->mail_fromemail;?>" />
    </div>
</div>
<hr>
<div class="smtp">
<div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left">SMTP Secure</label>
    <div class="col-md-2">
        <select name="smtpsecure" class="form-select">
        <option value="ssl" <?php if( $mailserver[0]->mail_secure == "ssl"){ echo "selected"; } ?>>SSL</option>
        <option value="tls" <?php if($mailserver[0]->mail_secure == "tls"){ echo "selected"; } ?> >TLS</option>
        <option value="no" <?php if($mailserver[0]->mail_secure == "no"){ echo "selected"; } ?> >No</option>
        </select>
    </div>
    </div>
    <div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left">SMTP Host</label>
    <div class="col-md-4">
        <input type="text" name="smtphost" placeholder="Host" class="form-control" value="<?php echo $mailserver[0]->mail_hostname;?>" />
    </div>
    </div>
    <div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left">SMTP Port</label>
    <div class="col-md-2">
        <input type="text" name="smtpport" placeholder="Port" value="<?php echo $mailserver[0]->mail_port;?>" class="form-control"/>
    </div>
    </div>
    <div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left">SMTP Username</label>
    <div class="col-md-4">
        <input type="text" name="smtpuser" placeholder="Username" value="<?php echo $mailserver[0]->mail_username;?>" class="form-control"/>
    </div>
    </div>
    <div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left">SMTP Password</label>
    <div class="col-md-4">
        <input type="text" name="smtppass" placeholder="password" value="<?php echo $mailserver[0]->mail_password;?>" class="form-control"/>
    </div>
    </div>
</div>
<div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left">Test Email Reciever </label>
    <div class="col-md-4">
    <input type="text" name="" placeholder="Email" value="" class="form-control testemailtxt"/>
    </div>
</div>
<div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left "><br></label>
    <div class="col-md-4">
    <span class="btn btn-sm btn-primary testEmail">Test Email</span>
    </div>
</div>
<hr>
<div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left ">Global Email Header</label>
    <div class="col-md-10">
    <textarea name="mailheader" class="form-control" rows="40" cols="100"><?php echo $mailserver[0]->mail_header;?></textarea>
    </div>
</div>
<div class="row form-group mb-2">
    <label  class="col-md-2 control-label text-left ">Global Email Footer</label>
    <div class="col-md-10">
    <textarea name="mailfooter" class="form-control" rows="40" cols="100"><?php echo $mailserver[0]->mail_footer;?></textarea>
    </div>
</div>

<div class="text-end">
<button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
</div>

</div>
</div>