<div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Server Inoformation</div>
        <div class="card-subtitle mb-4">Server configuration information</div>

        <div class="list-group">
        <a href="#!" class="list-group-item"><strong> Server OS </strong> <span  class="pull-right"><?php echo info_general('os');?></span></a>
        <a href="#!" class="list-group-item"><strong> Browser </strong> <span  class="pull-right"><?php echo $browserlib->getBrowser()." ".$browserlib->getVersion() ?> </span></a>
        <a href="#!" class="list-group-item"><strong> PHP Version </strong> <span  class="pull-right"><?php echo phpversion(); echo phpversion('tidy'); ?></span></a>
        <a href="#!" class="list-group-item"><strong> MySQL Version </strong> <span  class="pull-right"><?php echo info_general('mysqlversion');?></span></a>
        <a href="#!" class="list-group-item"><strong> MySQLi </strong> <span  class="pull-right"> <?php $mysqli = info_general('mysqli'); if($mysqli){ ?><i class='fa fa-check'></i><?php }else{?><i class='fa fa-times'></i> <?php } ?> </span></a>
        <a href="#!" class="list-group-item"><strong> Mod_Rewrite </strong> <span  class="pull-right"> <?php $modrewrite = info_general('modrewrite'); if($modrewrite){ ?><i class='fa fa-check'></i><?php }else{?><i class='fa fa-times'></i> <?php } ?> </span></a>
        </div>
        
        </div>
    </div>

