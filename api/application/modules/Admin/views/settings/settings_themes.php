<div class="card card-raised mb-5">
      <div class="card-body p-5">
        <div class="card-title">Themes settings</div>
        <div class="card-subtitle mb-4">Template configurations</div>

        <div class="row form-group">
              <div class="col-md-2">
              <label  class="control-label">Theme Name</label>
                <select name="theme" class="form-select theme">
                  <?php foreach($themes as $theme => $v )
                    {  @$themeinfo = pt_getThemeInfo( "../app/themes/$theme/style.css" );
                    ?>
                  <option value="<?php echo $theme;?>" <?php if($settings[0]->default_theme == $theme){ echo "selected"; } ?> ><?php echo $themeinfo['Name']; ?></option>
                  <?php  } ?>
                </select>
              </div>
              <div class="col-md-2">
                <img id="screenshot" src="" class="img-responsive img-thumbnail" alt="themes" />
              </div>
              <div class="col-md-6">
                <p><strong>Theme Name :</strong> <span id="themename"></span></p>
                <p><strong>Description :</strong> <span id="themedesc"></span></p>
                <p><strong>Author :</strong> <span id="themeauthor"></span></p>
                <p><strong>Version :</strong> <span id="themeversion"></span></p>
              </div>
            </div>

            <div class="text-end">
          <button class="btn btn-primary mdc-ripple-upgraded" type="submit"> <i class="leading-icon material-icons">save</i> Update Settings</button>
        </div>
        
        </div>
    </div>

