<!-- Top app bar navigation menu-->
<nav class="top-app-bar navbar navbar-expand navbar-dark bg-dark">
            <div class="container-fluid px-4">
                <!-- Drawer toggle button-->
                <button class="btn btn-lg btn-icon order-1 order-lg-0" id="drawerToggle" href="javascript:void(0);"><i class="material-icons">menu</i></button>
                <!-- Navbar brand-->
                <a class="navbar-brand me-auto loadeffect" href="<?= base_url().$this->uri->segment(1);?>"><div class="text-uppercase font-monospace">Dashboard</div></a>
                <!-- Navbar items-->
                <div class="d-flex align-items-center mx-3 me-lg-0">
                    <!-- Navbar-->
                    <ul class="navbar-nav d-none d-lg-flex">
                        <li class="nav-item"><a class="nav-link" href="../sd" target="_blank">Website</a></li>
                        <li class="nav-item"><a class="nav-link loadeffect" href="<?= base_url().$this->uri->segment(1);?>/bookings" target="">Bookings</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://docs.phptravels.com" target="_blank">Docs</a></li>
                    </ul>
                    <!-- Navbar buttons-->
                    <div class="d-flex">
                        <!-- Messages dropdown-->
                        <div class="dropdown dropdown-notifications d-none d-sm-block">
                            <!-- <button class="btn btn-lg btn-icon dropdown-toggle me-3" id="dropdownMenuMessages" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">mail_outline</i></button> -->
                            <ul class="dropdown-menu dropdown-menu-end me-3 mt-3 py-0 overflow-hidden" aria-labelledby="dropdownMenuMessages">
                                <li><h6 class="dropdown-header bg-primary text-white fw-500 py-3">Messages</h6></li>
                                <li><hr class="dropdown-divider my-0" /></li>
                                <li>
                                    <a class="dropdown-item unread" href="#!">
                                        <div class="dropdown-item-content">
                                            <div class="dropdown-item-content-text"><div class="text-truncate d-inline-block" style="max-width: 18rem">Hi there, I had a question about something, is there any way you can help me out?</div></div>
                                            <div class="dropdown-item-content-subtext">Mar 12, 2021 · Juan Babin</div>
                                        </div>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-0" /></li>
                                <li>
                                    <a class="dropdown-item" href="#!">
                                        <div class="dropdown-item-content">
                                            <div class="dropdown-item-content-text"><div class="text-truncate d-inline-block" style="max-width: 18rem">Thanks for the assistance the other day, I wanted to follow up with you just to make sure everyting is settled.</div></div>
                                            <div class="dropdown-item-content-subtext">Mar 10, 2021 · Christine Hendersen</div>
                                        </div>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-0" /></li>
                                <li>
                                    <a class="dropdown-item" href="#!">
                                        <div class="dropdown-item-content">
                                            <div class="dropdown-item-content-text"><div class="text-truncate d-inline-block" style="max-width: 18rem">Welcome to our group! It's good to see new members and I know you will do great!</div></div>
                                            <div class="dropdown-item-content-subtext">Mar 8, 2021 · Celia J. Knight</div>
                                        </div>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-0" /></li>
                                <li>
                                    <a class="dropdown-item py-3" href="#!">
                                        <div class="d-flex align-items-center w-100 justify-content-end text-primary">
                                            <div class="fst-button small">View all</div>
                                            <i class="material-icons icon-sm ms-1">chevron_right</i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Notifications and alerts dropdown-->
                        <div class="dropdown dropdown-notifications d-none d-sm-block">
                            <!-- <button class="btn btn-lg btn-icon dropdown-toggle me-3" id="dropdownMenuNotifications" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">notifications</i></button> -->
                            <ul class="dropdown-menu dropdown-menu-end me-3 mt-3 py-0 overflow-hidden" aria-labelledby="dropdownMenuNotifications">
                                <li><h6 class="dropdown-header bg-primary text-white fw-500 py-3">Alerts</h6></li>
                                <li><hr class="dropdown-divider my-0" /></li>
                                <li>
                                    <a class="dropdown-item unread" href="#!">
                                        <i class="material-icons leading-icon">assessment</i>
                                        <div class="dropdown-item-content me-2">
                                            <div class="dropdown-item-content-text">Your March performance report is ready to view.</div>
                                            <div class="dropdown-item-content-subtext">Mar 12, 2021 · Performance</div>
                                        </div>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-0" /></li>
                                <li>
                                    <a class="dropdown-item" href="#!">
                                        <i class="material-icons leading-icon">check_circle</i>
                                        <div class="dropdown-item-content me-2">
                                            <div class="dropdown-item-content-text">Tracking codes successfully updated.</div>
                                            <div class="dropdown-item-content-subtext">Mar 12, 2021 · Coverage</div>
                                        </div>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-0" /></li>
                                <li>
                                    <a class="dropdown-item" href="#!">
                                        <i class="material-icons leading-icon">warning</i>
                                        <div class="dropdown-item-content me-2">
                                            <div class="dropdown-item-content-text">Tracking codes have changed and require manual action.</div>
                                            <div class="dropdown-item-content-subtext">Mar 8, 2021 · Coverage</div>
                                        </div>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-0" /></li>
                                <li>
                                    <a class="dropdown-item py-3" href="#!">
                                        <div class="d-flex align-items-center w-100 justify-content-end text-primary">
                                            <div class="fst-button small">View all</div>
                                            <i class="material-icons icon-sm ms-1">chevron_right</i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- User profile dropdown-->
                        <div class="dropdown">
                            <button class="btn btn-lg btn-icon dropdown-toggle" id="dropdownMenuProfile" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">person</i></button>
                            <ul class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="dropdownMenuProfile">
                                <li>
                                    <a class="dropdown-item loadeffect" href="<?php echo base_url().$this->uri->segment(1);?>/profile">
                                        <i class="material-icons leading-icon">person</i>
                                        <div class="me-3">Profile</div>
                                    </a>
                                </li>
                                <?php if ($isSuperAdmin) {?>
                                <li>
                                    <a class="dropdown-item loadeffect" href="<?=base_url('admin/settings')?>">
                                        <i class="material-icons leading-icon">settings</i>
                                        <div class="me-3">Settings</div>
                                    </a>
                                </li>
                                <?php } ?>
                                <li>
                                    <a class="dropdown-item" href="https://docs.phptravels.com" target="_blank">
                                        <i class="material-icons leading-icon">help</i>
                                        <div class="me-3">Help</div>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                    <a class="dropdown-item loadeffect" href="<?php echo base_url().$this->uri->segment(1);?>/logout">
                                        <i class="material-icons leading-icon">logout</i>
                                        <div class="me-3">Logout</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>


        <!-- Layout wrapper-->
        <div id="layoutDrawer">
            <!-- Layout navigation-->
            <div id="layoutDrawer_nav">
                <!-- Drawer navigation-->
                <nav class="drawer accordion drawer-light bg-white" id="drawerAccordion">
                    <div class="drawer-menu">
                        <div class="nav">
                            <!-- Drawer section heading (Account)-->
                            <div class="drawer-menu-heading d-sm-none">Account</div>
                            <!-- Drawer link (Notifications)-->
                            <a class="nav-link d-sm-none" href="#!">
                                <div class="nav-link-icon"><i class="material-icons">notifications</i></div>
                                Notifications
                            </a>
                            <!-- Drawer link (Messages)-->
                            <a class="nav-link d-sm-none" href="#!">
                                <div class="nav-link-icon"><i class="material-icons">mail</i></div>
                                Messages
                            </a>
                            <!-- Divider-->
                            <div class="drawer-menu-divider d-sm-none"></div>
                            <!-- Drawer section heading (Interface)-->
                            <div class="drawer-menu-heading" style="padding-top:0rem">
                                <!-- <small>Menu</small> -->
                            </div>
                            <!-- Drawer link (Overview)-->
                            <a class="nav-link loadeffect" href="<?= base_url().$this->uri->segment(1);?>">
                                <div class="nav-link-icon"><i class="material-icons">space_dashboard</i></div>
                                Dashboard
                            </a>

                            <?php if ($isadmin) { ?>
                            <?php if ($isSuperAdmin) {?>

                            <!-- Drawer link (Dashboards)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i class="material-icons">settings</i></div>
                                Settings
                                <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                            </a>
                            <!-- Nested drawer nav (Dashboards)-->
                                <div class="collapse" id="collapseDashboards" aria-labelledby="headingOne" data-bs-parent="#drawerAccordion">
                                <nav class="drawer-menu-nested nav navload">

                                <a class="nav-link" href="<?php echo base_url(); ?>admin/settings/"> <?php echo trans('03'); ?> <?php echo trans('04'); ?></a>
                                <?php $chkupdates = checkUpdatesCount();if ($chkupdates->showUpdates) {if ($isSuperAdmin) {?>

                                <a class="nav-link" href="<?php echo base_url(); ?>admin/updates/">
                                <span>Updates</span><span class="pull-right label label-danger" id="updatescount"><?php if ($chkupdates->count > 0) {echo $chkupdates->count;} ;?></span>
                                </a>

                                <?php }}?>
                                <a class="nav-link multi_currency" href="<?php echo base_url(); ?>admin/settings/currencies/"> Currencies</a> </li>
                                <a class="nav-link" href="<?php echo base_url(); ?>admin/settings/paymentgateways/"> <?php echo trans('05'); ?></a>
                                <a class="nav-link" href="<?php echo base_url(); ?>admin/settings/social/"> <?php echo trans('07'); ?></a>
                                <!-- <a class="nav-link" href="<?php echo base_url(); ?>admin/settings/widgets/"> <?php echo trans('010'); ?></a> -->
                                <a class="nav-link" href="<?php echo base_url(); ?>admin/settings/sliders/">Homepage Sliders</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>admin/templates/email/"> <?php echo trans('012'); ?></a>
                                <a class="nav-link" href="<?php echo base_url(); ?>admin/templates/sms_settings/"> SMS API Settings</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>admin/backup/"> BackUp</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>admin/banip/">Ban IP</a>

                                <!-- <?php if($this->uri->segment(1) != 'admin' ){ ?>
                                <a href="<?php echo base_url(); ?>supplier/widget"> Widgets <span class="pull-right label label-danger"></span></a>
                                <?php } ?>-->

                                </nav>
                            </div>

                            <?php }?>

                            <a class="nav-link collapsed loadeffect" href="<?php echo base_url(); ?>admin/settings/modules/">
                                <div class="nav-link-icon"><i class="material-icons">dns</i></div>
                                <?php echo trans('08'); ?>
                                <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                            </a>

                            <!-- Drawer link (Layouts)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="nav-link-icon"><i class="material-icons">people</i></div>
                                Accounts
                                <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                            </a>
                            <!-- Nested drawer nav (Layouts)-->
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#drawerAccordion">
                                <nav class="drawer-menu-nested nav navload">

                                <?php if ($role != "admin") {?>
                                <a class="nav-link" href="<?php echo base_url(); ?>admin/accounts/admins/">Admins</a>
                                <?php }?>
                                 <a class="nav-link suppliers" href="<?php echo base_url(); ?>admin/accounts/suppliers/"><?php echo trans('023'); ?></a>
                                 <a class="nav-link b2b_agents" href="<?php echo base_url(); ?>admin/accounts/agents/">Agents</a>
                                 <a class="nav-link" href="<?php echo base_url(); ?>admin/accounts/customers/"><?php echo trans('025'); ?></a>
                                 <a class="nav-link" href="<?php echo base_url(); ?>admin/accounts/guest/"><?php echo trans('027'); ?> <?php echo trans('025'); ?></a>

                                </nav>
                            </div>

                            <!-- Drawer link (Layouts)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCMS" aria-expanded="false" aria-controls="collapseCMS">
                                <div class="nav-link-icon"><i class="material-icons">layers</i></div>
                                CMS
                                <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                            </a>
                            <!-- Nested drawer nav (Layouts)-->
                            <div class="collapse" id="collapseCMS" aria-labelledby="headingOne" data-bs-parent="#drawerAccordion">
                                <nav class="drawer-menu-nested nav navload">
                                    <a class="nav-link" href="<?php echo base_url(); ?>admin/cms"><?php echo trans('015'); ?></a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>admin/cms/menus/manage"><?php echo trans('016'); ?></a>
                                </nav>
                            </div>

                            <?php } ?>

                            <!-- Drawer link (Pages)-->
                            <!-- <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="nav-link-icon"><i class="material-icons">layers</i></div>
                                Pages
                                <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                            </a> -->
                            <!-- Nested drawer nav (Pages)-->
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#drawerAccordion">
                                <nav class="drawer-menu-nested nav accordion" id="drawerAccordionPages">
                                    <!-- Drawer link (Pages -> Account)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAccount" aria-expanded="false" aria-controls="pagesCollapseAccount">
                                        Account
                                        <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>
                                    <!-- Nested drawer nav (Pages -> Account)-->
                                    <div class="collapse" id="pagesCollapseAccount" aria-labelledby="headingOne" data-bs-parent="#drawerAccordionPages">
                                        <nav class="drawer-menu-nested nav">
                                            <a class="nav-link" href="app-account-billing.html">Billing</a>
                                            <a class="nav-link" href="app-account-notifications.html">Notifications</a>
                                            <a class="nav-link" href="app-account-profile.html">Profile</a>
                                            <a class="nav-link" href="app-account-security.html">Security</a>
                                        </nav>
                                    </div>
                                    <!-- Drawer link (Pages -> Authentication)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>
                                    <!-- Nested drawer nav (Pages -> Authentication)-->
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#drawerAccordionPages">
                                        <nav class="drawer-menu-nested nav">
                                            <a class="nav-link" href="app-auth-login-basic.html">Login 1</a>
                                            <a class="nav-link" href="app-auth-login-styled-1.html">Login 2</a>
                                            <a class="nav-link" href="app-auth-login-styled-2.html">Login 3</a>
                                            <a class="nav-link" href="app-auth-register-basic.html">Register</a>
                                            <a class="nav-link" href="app-auth-password-basic.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <!-- Drawer link (Pages -> Blank Pages)-->
                                    <a class="nav-link" href="app-blank-page.html">Blank Page</a>
                                    <!-- Drawer link (Pages -> Error)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>
                                    <!-- Nested drawer nav (Pages -> Error)-->
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#drawerAccordionPages">
                                        <nav class="drawer-menu-nested nav">
                                            <a class="nav-link" href="app-error-400.html">400 Error Page</a>
                                            <a class="nav-link" href="app-error-401.html">401 Error Page</a>
                                            <a class="nav-link" href="app-error-403.html">403 Error Page</a>
                                            <a class="nav-link" href="app-error-404.html">404 Error Page</a>
                                            <a class="nav-link" href="app-error-429.html">429 Error Page</a>
                                            <a class="nav-link" href="app-error-500.html">500 Error Page</a>
                                            <a class="nav-link" href="app-error-503.html">503 Error Page</a>
                                            <a class="nav-link" href="app-error-504.html">504 Error Page</a>
                                        </nav>
                                    </div>
                                    <!-- Drawer link (Pages -> Pricing)-->
                                    <a class="nav-link" href="app-invoice.html">Invoice</a>
                                    <!-- Drawer link (Pages -> Knowledgebase)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseKnowledgebase" aria-expanded="false" aria-controls="pagesCollapseKnowledgebase">
                                        Knowledgebase
                                        <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>
                                    <!-- Nested drawer nav (Pages -> Knowledgebase)-->
                                    <div class="collapse" id="pagesCollapseKnowledgebase" aria-labelledby="headingOne" data-bs-parent="#drawerAccordionPages">
                                        <nav class="drawer-menu-nested nav">
                                            <a class="nav-link" href="app-knowledgebase-home.html">Home</a>
                                            <a class="nav-link" href="app-knowledgebase-categories.html">Categories</a>
                                            <a class="nav-link" href="app-knowledgebase-article.html">Article</a>
                                        </nav>
                                    </div>
                                    <!-- Drawer link (Pages -> Pricing)-->
                                    <a class="nav-link" href="app-pricing.html">Pricing</a>
                                </nav>
                            </div>

                            <!-- Divider-->
                            <div class="drawer-menu-divider"></div>
                            <!-- Drawer section heading (UI Toolkit)-->
                            <div class="drawer-menu-heading"><small>Modules</small></div>
                            <!-- Drawer link (Components)-->

                            <?php $module_data = []; $submodule_data = []; $module_extra = []; if (empty($supplier)) {
                            $moduleslist = app()->service('ModuleService')->all();
                            $baseurl = base_url();
                            $urisegment = $this->uri->segment(1);
                            $hotels =1; $flights =1; $tours =1; $cars =1; $visa =1; $cruise =1; $rental =1;
                            foreach ($moduleslist as $modl) {
                            $isenabled = isModuleActive($modl->name);
                            if ($isenabled) {
                            if (pt_permissions($modl->name, $userloggedin) && !in_array(strtolower($modl->name), ['offers', 'newsletter', 'coupons', 'reviews'])) {
                            if ($modl->parent_id == 'hotels' && $hotels ==1) {
                            array_push($module_data, (object)[
                            'name'=>'hotels',
                            'icon'=>'king_bed',
                            'parent_id'=>'hotels']);
                            $hotels++;}
                            if ($modl->parent_id == 'hotels') {array_push($submodule_data, $modl);}
                            if ($modl->parent_id == 'flights' && $flights ==1) {
                            array_push($module_data, (object)[
                            'name'=>'flights',
                            'icon'=>'local_airport',
                            'parent_id'=>'flights']);
                            $flights++;}
                            if ($modl->parent_id == 'flights') {array_push($submodule_data, $modl);}
                            if ($modl->parent_id == 'tours' && $tours ==1) {
                            array_push($module_data, (object)[
                            'name'=>'tours',
                            'icon'=>'luggage',
                            'parent_id'=>'tours']);
                            $tours++;}
                            if ($modl->parent_id == 'tours') {array_push($submodule_data, $modl);}
                            if ($modl->parent_id == 'cars' && $cars ==1) {
                            array_push($module_data, (object)[
                            'name'=>'cars',
                            'icon'=>'directions_car',
                            'parent_id'=>'cars']);
                            $cars++;}
                            if ($modl->parent_id == 'cars') {array_push($submodule_data, $modl);}
                            if ($modl->parent_id == 'visa' && $visa ==1) {
                            array_push($module_data, (object)[
                            'name'=>'ivisa',
                            'icon'=>'class',
                            'parent_id'=>'visa']);
                            $visa++;}
                            if ($modl->parent_id == 'visa') {array_push($submodule_data, $modl);}
                            if ($modl->parent_id == 'cruise' && $cruise ==1) {
                            array_push($module_data, (object)[
                            'name'=>'cruise',
                            'icon'=>'fa fa-suitcase',
                            'parent_id'=>'cruise']);
                            $cruise++;}
                            if ($modl->parent_id == 'cruise') {array_push($submodule_data, $modl);}
                            if ($modl->parent_id == 'rental' && $rental ==1) {
                            array_push($module_data, (object)[
                            'name'=>'rental',
                            'icon'=>'fa fa-suitcase',
                            'parent_id'=>'rental']);
                            $rental++;}
                            if ($modl->parent_id == 'rental') {array_push($submodule_data, $modl);}
                            if ($modl->parent_id == 'extra') {
                            array_push($module_extra, $modl);}
                            }
                            }
                            }
                            }?>


                <!-- ///////////////////////////////////////////// -->
                <!-- //////////////////Main module Work///////////////-->
                <!-- //////////////////////////////////////////// -->
                <?php $urisegment = $this->uri->segment(1); foreach ($module_data as $key) { $main_mod_arr =[]; array_push($main_mod_arr,array($key->name)); ?>

                            <!-- Drawer link (Pages)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#<?php echo $key->name; ?>module" aria-expanded="false" aria-controls="<?php echo $key->name; ?>module">
                                <div class="nav-link-icon"><i class="material-icons"><?=$key->icon;?></i></div>
                                <?php echo $key->parent_id; ?>
                                <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                            </a>

                            <div class="collapse" id="<?php echo $key->name; ?>module" aria-labelledby="headingTwo" data-bs-parent="#drawerAccordion">
                                <nav class="drawer-menu-nested nav accordion" id="drawerAccordionPages">

                                    <?php foreach ($submodule_data as $sub_key) {  if ($sub_key->parent_id == $key->parent_id) { ?>
                                    <!-- Drawer link (Pages -> Account)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#<?php echo $sub_key->name; ?>" aria-expanded="false" aria-controls="pagesCollapseAccount">
                                    <?php echo $sub_key->label; ?>
                                        <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>

                                    <?php if ($urisegment == "admin" && !empty($sub_key->menus->admin)) {?>
                                    <!-- Nested drawer nav (Pages -> Account)-->
                                    <div class="collapse" id="<?php echo $sub_key->name; ?>" aria-labelledby="headingOne" data-bs-parent="#drawerAccordionPages">
                                        <nav class="drawer-menu-nested nav navload">
                                            <?php foreach ($sub_key->menus->admin as $menu): ?> <?php if ($menu->label!= 'Booking') {?>
                                                <a class="nav-link" href="<?=base_url($menu->link);?>"><?php echo $menu->label;?></a>
                                            <?php } ?> <?php endforeach;?>
                                        </nav>
                                    </div>

                                    <!-- FOR SUPPLIERS -->
                                    <?php } else if (!empty($sub_key->menus->supplier)) {?>
                                    <!-- Nested drawer nav (Pages -> Account)-->
                                    <div class="collapse" id="<?php echo $sub_key->name; ?>" aria-labelledby="headingOne" data-bs-parent="#drawerAccordionPages">
                                        <nav class="drawer-menu-nested nav navload">
                                            <?php foreach ($sub_key->menus->supplier as $menu): ?> <?php if ($menu->label!= 'Booking') {?>
                                                <a class="nav-link" href="<?=base_url($menu->link);?>"><?php echo $menu->label;?></a>
                                            <?php } ?> <?php endforeach;?>
                                        </nav>
                                    </div>
                                    <?php } ?>

                                    <?php } }?>

                                    <div class="drawer-menu-divider"></div>

                                    <?php if ($isSuperAdmin) {?>
                                    <!-- //////////////////////////////sub module code end////////////////////// -->

                                    <?php if ($key->name == "hotels" ) { ?>
                                    <a class="loadeffect nav-link" href="<?php echo base_url().$this->uri->segment(1);?>/locations"><small>Locations</small></a></li>
                                    <?php } ?>

                                    <?php if ($key->name == "cars" ) { ?>
                                    <a class="loadeffect nav-link" href="<?php echo base_url().$this->uri->segment(1);?>/locations"><small>Locations</small></a></li>
                                    <?php } ?>

                                    <?php if ($key->name == "tours" ) { ?>
                                    <a class="loadeffect nav-link" href="<?php echo base_url().$this->uri->segment(1);?>/locations"><small>Locations</small></a></li>
                                    <?php } ?>

                                    <a class="loadeffect nav-link" href="<?php echo base_url().$this->uri->segment(1);?>/<?php echo $key->name; ?>/booking"><small>Bookings</small></a>
                                    <a class="loadeffect nav-link" href="<?php echo base_url().$this->uri->segment(1);?>/<?php echo $key->name; ?>/searches"><small>Searches</small></a>
                                    <?php }?>


                                <!-- Drawer link (Pages -> Pricing)-->
                                </nav>
                            </div>

                            <?php } ?>


                            <!-- Divider-->
                            <div class="drawer-menu-divider"></div>

                            <?php if ($isSuperAdmin) {?>

                                    <!-- Drawer section heading (Plugins)-->
                                    <div class="drawer-menu-heading"><small>Extras</small></div>
                                    <!-- Drawer link (Charts)-->

                                    <?php if ($isadmin && $role != "admin") { if (isModuleActive('offers')) {?>
                                    <!-- Drawer link (offers)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#Discount" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="nav-link-icon"><i class="material-icons">discount</i></div>
                                    Offers
                                    <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>
                                    <!-- Nested drawer nav (Layouts)-->
                                    <div class="collapse" id="Discount" aria-labelledby="headingOne" data-bs-parent="#drawerAccordion">
                                        <nav class="drawer-menu-nested nav navload" id="Discount">
                                                <a class="nav-link" href="<?php echo base_url(); ?>admin/offers/"><?php echo trans('029'); ?> <?php echo trans('030'); ?></a>
                                                <a class="nav-link" href="<?php echo base_url(); ?>admin/offers/settings/"><?php echo trans('030'); ?> <?php echo trans('04'); ?></a>
                                        </nav>
                                    </div>
                                    <?php } } ?>

                                    <?php  foreach ($module_extra as $modl) { ?>

                                    <!-- Drawer link (Layouts)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#<?php echo $modl->name; ?>" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="nav-link-icon"><i class="material-icons"><?=$modl->menus->icon;?></i></div>
                                    <?php echo $modl->label; ?>
                                    <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>
                                    <!-- Nested drawer nav (Layouts)-->
                                    <div class="collapse" id="<?php echo $modl->name; ?>" aria-labelledby="headingOne" data-bs-parent="#drawerAccordion">

                                    <?php if ($urisegment == "admin" && !empty($modl->menus->admin)) {?>
                                        <nav class="drawer-menu-nested nav navload" id="<?php echo $modl->name; ?>">
                                            <?php foreach ($modl->menus->admin as $menu): ?>
                                                <a class="nav-link" href="<?=base_url($menu->link);?>"><?=$menu->label;?></a>
                                            <?php endforeach;?>
                                        </nav>
                                    </div>
                                    <?php } ?>

                                    <?php }?>

                                    <?php if (isModuleActive('coupons')) {?>
                                    <!-- Drawer link (coupons)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#Coupon" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="nav-link-icon"><i class="material-icons">bookmarks</i></div>
                                    Coupons
                                    <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>
                                    <!-- Nested drawer nav (Layouts)-->
                                    <div class="collapse" id="Coupon" aria-labelledby="headingOne" data-bs-parent="#drawerAccordion">
                                        <nav class="drawer-menu-nested nav navload" id="Coupon">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/coupons/"> Coupons </a>
                                        </nav>
                                    </div>
                                    <?php }?>


                                <?php if (pt_permissions('newsletter', @$userloggedin)) {?>
                                    <!-- Drawer link (offers)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#Newsletter" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="nav-link-icon"><i class="material-icons">mail</i></div>
                                    Newsletter
                                    <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                                    </a>
                                    <!-- Nested drawer nav (Layouts)-->
                                    <div class="collapse" id="Newsletter" aria-labelledby="headingOne" data-bs-parent="#drawerAccordion">
                                        <nav class="drawer-menu-nested nav navload" id="Discount">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/newsletter/">  <?php echo trans('031'); ?> </a>
                                        </nav>
                                    </div>
                                    <?php } ?>

                            <?php } ?>


                            <?php if ($isSuperAdmin) if (empty($supplier)) { if (isModuleActive('hotels') ||  isModuleActive('tours') || isModuleActive('cars') ) { ?>
                            <!-- Drawer link (payouts)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#Payouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="nav-link-icon"><i class="material-icons">paid</i></div>
                            Payouts
                            <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                            </a>
                            <!-- Nested drawer nav (Layouts)-->
                            <div class="collapse" id="Payouts" aria-labelledby="headingOne" data-bs-parent="#drawerAccordion">

                                <nav class="drawer-menu-nested nav navload" id="Payouts">
                                <?php if (empty($supplier)) { $moduleslist = app()->service('ModuleService')->all();
                                foreach ($moduleslist as $modl) {
                                $isenabled = isModuleActive($modl->name);
                                if ($isenabled) {
                                if (pt_permissions($modl->name, $userloggedin) && in_array(strtolower($modl->name), ['hotels', 'tours', 'cars']) ) { ?>

                                <a class="nav-link" href="admin/payouts/unpaid/<?php echo strtolower($modl->name); ?>">  <?php echo $modl->label; ?> </a>

                                <?php } } } } ?>
                                </nav>
                            </div>
                            <?php } } ?>


                            <?php if (pt_permissions('booking', @$userloggedin)) {?>

                            <a class="loadeffect nav-link collapsed" href="<?php echo base_url() . $this->uri->segment(1); ?>/bookings">
                                <div class="nav-link-icon"><i class="material-icons">receipt</i></div>
                                <?php echo trans('034'); ?>
                                <div class="drawer-collapse-arrow"><i class="material-icons">expand_more</i></div>
                            </a>
                            <?php }?>

                            <!--
                            <a class="nav-link" href="plugins-code-blocks.html">
                                <div class="nav-link-icon"><i class="material-icons">code</i></div>
                                Code Blocks
                            </a>

                            <a class="nav-link" href="plugins-data-tables.html">
                                <div class="nav-link-icon"><i class="material-icons">filter_alt</i></div>
                                Data Tables
                            </a>

                            <a class="nav-link" href="plugins-date-picker.html">
                                <div class="nav-link-icon"><i class="material-icons">date_range</i></div>
                                Date Picker
                            </a> -->
                        </div>
                    </div>
                    <!-- Drawer footer        -->
                    <!-- <div class="drawer-footer border-top">
                        <div class="d-flex align-items-center">
                            <i class="material-icons text-muted">account_circle</i>
                            <div class="ms-3">
                                <div class="caption">Logged in as:</div>
                                <div class="small fw-500" style="text-transform:capitalize"><?=$this->uri->segment(1);?></div>
                            </div>
                        </div>
                    </div> -->
                </nav>
            </div>