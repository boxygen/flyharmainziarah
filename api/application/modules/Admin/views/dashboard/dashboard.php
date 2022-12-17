<?php 
// dd($annual_report); exit;
$module_data = []; $submodule_data = []; $module_extra = []; if (empty($supplier)) {
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
'name'=>'visa',
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
}}}}

//for searches graph
$hotels = ''; $flights = ''; $tours = ''; $cars = ''; $visa = '';
$hotels_data = ''; $flights_data = ''; $tours_data = ''; $cars_data = ''; $visa_data='';
foreach ($module_data as $key) {
if ($key->name == 'hotels') { $hotels = $key->name; $hotels_data=hotels_data();}
if ($key->name == 'flights') { $flights = $key->name; $flights_data=flights_data();}
if ($key->name == 'visa') { $visa = $key->name; $visa_data=visa_data();}
if ($key->name == 'tours') { $tours = $key->name; $tours_data=tours_data();}
if ($key->name == 'cars') { $cars = $key->name; $cars_data=cars_data();}
} ?>



<div class="row justify-content-between align-items-center mb-5">
<div class="col flex-shrink-0 mb-5 mb-md-0">
    <h1 class="display-4 mb-0">Dashboard</h1>
    <div class="text-muted">Sales overview &amp; summary</div>
</div>
<div class="col-12 col-md-auto">
    <!-- <div class="d-flex flex-column flex-sm-row gap-3">
        <mwc-select class="mw-50 mb-2 mb-md-0" outlined="" label="View by">
            <mwc-list-item selected="" value="0">Order type</mwc-list-item>
            <mwc-list-item value="1">Paid and Confirmed</mwc-list-item>
            <mwc-list-item value="2">Pending or Cancelled</mwc-list-item>
        </mwc-select>
        <mwc-select class="mw-50" outlined="" label="Sales from">
            <mwc-list-item selected value="0">Last 7 days</mwc-list-item>
            <mwc-list-item value="1">Last 30 days</mwc-list-item>
            <mwc-list-item value="2">Last month</mwc-list-item>
            <mwc-list-item value="3">Last year</mwc-list-item>
        </mwc-select>
    </div> -->
</div>
</div>
<!-- Colored status cards-->
<?php include "booking_status.php"; ?>

<div class="row gx-5">
<!-- Revenue breakdown chart example-->
<div class="col-lg-8 mb-5">
    <div class="card card-raised h-100">
        <div class="card-header bg-transparent px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="me-4">
                    <h2 class="card-title mb-0">Revenue Breakdown <?=date('Y')?></h2>
                    <div class="card-subtitle">Total Bookings And Payments</div>
                </div>
                <!-- <div class="d-flex gap-2 me-n2">
                    <button class="btn btn-lg btn-text-primary btn-icon" type="button"><i class="material-icons">download</i></button>
                    <button class="btn btn-lg btn-text-primary btn-icon" type="button"><i class="material-icons">print</i></button>
                </div> -->
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row gx-4">
                <div class="col-12 col-xxl-2">
                    <div class="d-flex flex-column flex-md-row flex-xxl-column align-items-center align-items-xl-start justify-content-between">
                        <div class="mb-4 text-center text-md-start">
                            <div class="text-xs font-monospace text-muted mb-1">Total Revenue</div>
                            <div class="display-5 fw-500"><?=$annual_report[1]['total_revenue']?></div>
                        </div>
                        <div class="mb-4 text-center text-md-start">
                            <div class="text-xs font-monospace text-muted mb-1">Total Bookings</div>
                            <div class="display-5 fw-500"><?=$annual_report[0]['total_booking']?></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-10"><canvas id="dashboardBarChart"></canvas></div>
            </div>
            <hr>
            <div class="row mt-5">
            <div class="col-md-2 mb-4 text-center text-md-start">
                <div class="text-xs font-monospace text-muted mb-1 text-center">Confirmed</div>
                <div class="display-5 fw-500 text-info text-center"><?=$annual_report[5]['all_confirmedBookings']?></div>
            </div>
            <div class="col-md-2  mb-4 text-center text-md-start">
                <div class="text-xs font-monospace text-muted mb-1 text-center">Pending</div>
                <div class="display-5 fw-500 text-warning text-center"><?=$annual_report[4]['all_pendingBookings']?></div>
            </div>
            <div class="col-md-2 mb-4 text-center text-md-start">
                <div class="text-xs font-monospace text-muted mb-1 text-center">Cancelled</div>
                <div class="display-5 fw-500 text-danger text-center"><?=$annual_report[6]['all_cancelledBookings']?></div>
            </div>

            <div class="col-md-2 mb-4 text-center text-md-start">
                <div class="text-xs font-monospace text-muted mb-1 text-center">Paid</div>
                <div class="display-5 fw-500 text-primary text-center"><?=$annual_report[2]['all_paidBookings']?></div>
            </div>
            <div class="col-md-2 mb-4 text-center text-md-start">
                <div class="text-xs font-monospace text-muted mb-1 text-center">Unpaid</div>
                <div class="display-5 fw-500 text-secondary text-center"><?=$annual_report[3]['all_unpaidBookings']?></div>
            </div>
            <div class="col-md-2 mb-4 text-center text-md-start">
                <div class="text-xs font-monospace text-muted mb-1 text-center">Refunded</div>
                <div class="display-5 fw-500 text-dark text-center"><?=$annual_report[7]['all_refundedBookings']?></div>
            </div>

            </div>
        </div>
        <div class="card-footer bg-transparent position-relative ripple-gray">
            <!-- <a class="d-flex align-items-center justify-content-end text-decoration-none stretched-link text-primary" href="#"> -->
                <div class="fst-button">Stats of year <?=date('Y')?></div>
                <!-- <i class="material-icons icon-sm ms-1">chevron_right</i> -->
            <!-- </a> -->
        </div>
    </div>
</div>
<!-- Segments pie chart example-->
<div class="col-lg-4 mb-5">
    <div class="card card-raised h-100">
        <div class="card-header bg-transparent px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="me-4">
                    <h2 class="card-title mb-0">Searches</h2>
                    <div class="card-subtitle"></div>
                </div>
                <!-- <div class="dropdown">
                    <button class="btn btn-lg btn-text-gray btn-icon me-n2 dropdown-toggle" id="segmentsDropdownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></button>
                    <ul class="dropdown-menu" aria-labelledby="segmentsDropdownButton">
                        <li><a class="dropdown-item" href="#!">Action</a></li>
                        <li><a class="dropdown-item" href="#!">Another action</a></li>
                        <li><a class="dropdown-item" href="#!">Something else here</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Separated link</a></li>
                        <li><a class="dropdown-item" href="#!">Separated link</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
        <div class="card-body p-4">
            <div class="d-flex h-100 w-100 align-items-center justify-content-center">
                <div class="w-100" style="max-width: 20rem"><canvas id="myPieChart"></canvas></div>
            </div>
        </div>

        <div class="card-footer bg-transparent p-0">
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between">
                    <div class="caption font-monospace text-muted">Searches</div>
                    <div class="caption font-monospace text-muted ms-2">Stats</div>
                </div>



<?php if(isset($hotels) && $hotels != ''){  ?>
<div class="list-group-item d-flex justify-content-between">
    <div class="me-2">
        <span class="text-primary me-1">●</span>
        Hotels
    </div>
    <div class="ms-2"><?php if(isset($hotels_data) && $hotels_data != ''){  echo hotels_data(); } ?></div>
</div>
<?php } ?>
<?php if(isset($flights) && $flights != ''){  ?>
<div class="list-group-item d-flex justify-content-between">
    <div class="me-2">
        <span class="text-info me-1">●</span>
        Flights
    </div>
    <div class="ms-2"><?php if(isset($flights_data) && $flights_data != ''){ echo flights_data(); } ?></div>
</div>
<?php } ?>
<?php if(isset($tours) && $tours != ''){  ?>
<div class="list-group-item d-flex justify-content-between">
    <div class="me-2">
        <span class="text-secondary me-1">●</span>
        Tours
    </div>
    <div class="ms-2"><?php if(isset($tours_data) && $tours_data != ''){ echo tours_data(); } ?>
    </div>
</div>
<?php } ?>
<?php if(isset($cars) && $cars != ''){  ?>
<div class="list-group-item d-flex justify-content-between">
    <div class="me-2">
        <span class="text-warning me-1">●</span>
        Cars
    </div>
    <div class="ms-2"><?php if(isset($cars_data) && $cars_data != ''){  echo cars_data(); } ?></div>
</div>
<?php } ?>
<?php if(isset($visa) && $visa != ''){  ?>
<div class="list-group-item d-flex justify-content-between">
    <div class="me-2">
        <span class="text-danger me-1">●</span>
        Visa
    </div>
    <div class="ms-2"><?php if(isset($visa_data) && $visa_data != ''){  echo visa_data(); } ?></div>
</div>
<?php } ?>
</div>
</div>
        
        <!-- <div class="card-footer bg-transparent position-relative ripple-gray">
            <a class="d-flex align-items-center justify-content-end text-decoration-none stretched-link text-primary" href="#!">
                <div class="fst-button">Open Report</div>
                <i class="material-icons icon-sm ms-1">chevron_right</i>
            </a>
        </div> -->
    </div>
</div>
</div>
<div class="row">
    <div class="col-xl-12 mb-5">
        <div class="card card-raised h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div class="me-4">
                        <h2 class="card-title mb-0">Cancellation Requests</h2>
                        <p class="card-text">Booking cancellation requests.</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="xcrud-th">
                                <th class="xcrud-num" style="width: 5px !important;">#</th>
                                <th class="xcrud-column xcrud-action">ID</th>
                                <th class="xcrud-column xcrud-action">Ref</th>
                                <th class="xcrud-column xcrud-action">Customer</th>
                                <th class="xcrud-column xcrud-action">Module</th>
                                <th class="xcrud-column xcrud-action">Supplier</th>
                                <th class="xcrud-column xcrud-action">From</th>
                                <th class="xcrud-column xcrud-action">Date</th>
                                <th class="xcrud-column xcrud-action" style="width: 100px;">Price</th>
                                <th class="xcrud-column xcrud-action text-center">PNR</th>
                                <th class="xcrud-column xcrud-action text-center">Booking Status</th>
                                <th class="xcrud-column xcrud-action text-center">Invoice</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sno=0; foreach($cancellation_requests as $data){ ?>

                                <tr>
                                    <td class="xcrud-num" style="widtd: 5px !important;"><?= ++$sno ?></td>
                                    <td class="xcrud-column xcrud-action"><?= $data->booking_id?></td>
                                    <td class="xcrud-column xcrud-action"><?= $data->booking_ref_no?></td>
                                    <td class="xcrud-column xcrud-action"><?= $data->ai_first_name?></td>
                                    <td class="xcrud-column xcrud-action"><?= $data->module?></td>
                                    <td class="xcrud-column xcrud-action"><?= $data->supplier_name?></td>
                                    <td class="xcrud-column xcrud-action"><?= $data->booking_from?></td>
                                    <td class="xcrud-column xcrud-action"><?= pt_show_date_php($data->booking_date)?></td>
                                    <td class="xcrud-column xcrud-action" style="widtd: 100px;"><?= $data->total_price.' '.$data->booking_curr_code?></td>
                                    <td class="xcrud-column xcrud-action text-center"><?= $data->pnr?></td>
                                    <td class="text-center"><?=$data->booking_status?></td>
                                    <td class="xcrud-column xcrud-action text-center"><a title="Preview Invoice" data-toggle="tooltip" data-placement="top"href="<?php echo base_url();?>../<?php echo $data->module;?>/booking/invoice/<?php echo $data->booking_ref_no;?>/<?php echo $data->booking_id;?>" target="_blank" ><span class="btn btn-sm btn-primary"> Invoice</span> </a></td>              
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
                
            </div>
        </div>
    </div>
<!-- 
 
<div class="col-xl-6 mb-5">
    <div class="card card-raised h-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between">
                <div class="me-4">
                    <h2 class="card-title mb-0">Account Storage</h2>
                    <p class="card-text">Your account storage is shared across all devices.</p>
                    <div class="progress mb-2" style="height: 0.25rem"><div class="progress-bar" role="progressbar" style="width: 33%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="30"></div></div>
                    <div class="card-text">10 GB of 30 GB used</div>
                </div>
                <img src="assets/img/illustrations/cloud.svg" alt="..." style="height: 6rem" />
            </div>
        </div>
        <div class="card-footer bg-transparent position-relative ripple-gray px-4"><a class="stretched-link text-decoration-none" href="#!">Manage storage</a></div>
    </div>
</div> -->
</div>

<!-- 
<div class="card card-raised">
<div class="card-header bg-transparent px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="me-4">
            <h2 class="card-title mb-0">Orders</h2>
            <div class="card-subtitle">Details and history</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-lg btn-text-primary btn-icon" type="button"><i class="material-icons">download</i></button>
            <button class="btn btn-lg btn-text-primary btn-icon" type="button"><i class="material-icons">print</i></button>
        </div>
    </div>
</div>
<div class="card-body p-4">
 
<table id="datatablesSimple">
        <thead>
            <tr>
                <th>Name</th>
                <th>Ext.</th>
                <th>City</th>
                <th data-type="date" data-format="YYYY/MM/DD">Start Date</th>
                <th>Completion</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Unity Pugh</td>
                <td>9958</td>
                <td>Curicó</td>
                <td>2005/02/11</td>
                <td>37%</td>
            </tr>
            <tr>
                <td>Theodore Duran</td>
                <td>8971</td>
                <td>Dhanbad</td>
                <td>1999/04/07</td>
                <td>97%</td>
            </tr>
            <tr>
                <td>Zelenia Roman</td>
                <td>7516</td>
                <td>Redwater</td>
                <td>2012/03/03</td>
                <td>31%</td>
            </tr>
        </tbody>
    </table>
</div>
</div> -->
<script src="<?=base_url()?>assets/js/chart.min.js" crossorigin="anonymous"></script>
<script src="<?=base_url()?>assets/js/charts/chart-defaults.js"></script>


<script>
var ctx = document.getElementById('myPieChart').getContext('2d');
var dengerColor = '#d32f2f';
var myPieChart = new Chart(ctx, {
type: 'pie',
data: {
    labels: [
    <?php if(isset($hotels) && $hotels != ''){  ?> 'Hotels', <?php } ?>
    <?php if(isset($flights) && $flights != ''){  ?> 'Flights', <?php } ?>
    <?php if(isset($tours) && $tours != ''){  ?> 'Tours', <?php } ?>
    <?php if(isset($cars) && $cars != ''){  ?> 'Cars', <?php } ?>
    <?php if(isset($visa) && $visa != ''){  ?> 'Visa', <?php } ?>
    ],
    datasets: [{
        data: [
                <?php if(isset($hotels_data) && $hotels_data != ''){  ?> '<?=hotels_data()?>', <?php } ?>
                <?php if(isset($flights_data) && $flights_data != ''){  ?> '<?=flights_data()?>', <?php } ?>
                <?php if(isset($tours_data) && $tours_data != ''){  ?> '<?=tours_data()?>', <?php } ?>
                <?php if(isset($cars_data) && $cars_data != ''){  ?> '<?=cars_data()?>', <?php } ?>
                <?php if(isset($visa_data) && $visa_data != ''){  ?> '<?=visa_data()?>', <?php } ?>
        ],
        backgroundColor: [primaryColor, infoColor, secondaryColor, warningColor, dengerColor],
    }],
},
});
</script>

<script>
var ctx = document.getElementById('dashboardBarChart').getContext('2d');
var myBarChart = new Chart(ctx, {
type: 'bar',
data: {
    // labels: ['01 Jan', '02 Feb', '03 Mar', '04 Apr', '05 May', '06 Jun'],
    labels: [
    <?php 
        $month_arr=array('01 Jan', '02 Feb', '03 Mar', '04 Apr', '05 May', '06 Jun', '07 Jul', '08 Aug', '09 Sep', '20 Oct', '11 Nov', '12 Dec');
        for ($i=0; $i < count($month_arr); $i++) {
            $month_name = explode(' ',$month_arr[$i]);
            if ($month_name[0] <= date('m')) {
                echo "'".$month_arr[$i]."'".',';
            }
        }

    ?>
    ],
    datasets: [{
            label: 'Bookings',
            backgroundColor: '#808080',
            borderColor: '#808080',
            borderRadius: 4,
            maxBarThickness: 32,
            data: [
            <?php 
            if ($annual_report[8]['all_month']['jan']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['jan']['bookings'];
            }else{echo '';} ?>,<?php
            if ($annual_report[8]['all_month']['feb']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['feb']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['mar']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['mar']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['apr']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['apr']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['may']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['may']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jun']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['jun']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jul']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['jul']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['aug']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['aug']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['sep']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['sep']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['oct']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['oct']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['nov']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['nov']['bookings'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['dec']['bookings'] != 0) {
            echo $annual_report[8]['all_month']['dec']['bookings'];
            }{echo '';} ?>,<?php
             ?>

             ],
        },
        {
            label: 'Paid',
            backgroundColor: '#0031bc',
            borderColor: '#0031bc',
            borderRadius: 4,
            maxBarThickness: 32,
            data: [
            <?php 
            if ($annual_report[8]['all_month']['jan']['paid'] != 0) {
            echo $annual_report[8]['all_month']['jan']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['feb']['paid'] != 0) {
            echo $annual_report[8]['all_month']['feb']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['mar']['paid'] != 0) {
            echo $annual_report[8]['all_month']['mar']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['apr']['paid'] != 0) {
            echo $annual_report[8]['all_month']['apr']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['may']['paid'] != 0) {
            echo $annual_report[8]['all_month']['may']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jun']['paid'] != 0) {
            echo $annual_report[8]['all_month']['jun']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jul']['paid'] != 0) {
            echo $annual_report[8]['all_month']['jul']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['aug']['paid'] != 0) {
            echo $annual_report[8]['all_month']['aug']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['sep']['paid'] != 0) {
            echo $annual_report[8]['all_month']['sep']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['oct']['paid'] != 0) {
            echo $annual_report[8]['all_month']['oct']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['nov']['paid'] != 0) {
            echo $annual_report[8]['all_month']['nov']['paid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['dec']['paid'] != 0) {
            echo $annual_report[8]['all_month']['dec']['paid'];
            }{echo '';} ?>,<?php
             ?>

            ],
        },{
            label: 'Confirmed',
            backgroundColor: '#20c997',
            borderColor: '#20c997',
            borderRadius: 4,
            maxBarThickness: 32,
            data: [
            <?php 
            if ($annual_report[8]['all_month']['jan']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['jan']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['feb']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['feb']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['mar']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['mar']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['apr']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['apr']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['may']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['may']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jun']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['jun']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jul']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['jul']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['aug']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['aug']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['sep']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['sep']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['oct']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['oct']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['nov']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['nov']['confirmed'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['dec']['confirmed'] != 0) {
            echo $annual_report[8]['all_month']['dec']['confirmed'];
            }{echo '';} ?>,<?php
             ?>

            ],
        },{
            label: 'Pending',
            backgroundColor: '#ffb300',
            borderColor: '#ffb300',
            borderRadius: 4,
            maxBarThickness: 32,
            data: [
            <?php 
            if ($annual_report[8]['all_month']['jan']['pending'] != 0) {
            echo $annual_report[8]['all_month']['jan']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['feb']['pending'] != 0) {
            echo $annual_report[8]['all_month']['feb']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['mar']['pending'] != 0) {
            echo $annual_report[8]['all_month']['mar']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['apr']['pending'] != 0) {
            echo $annual_report[8]['all_month']['apr']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['may']['pending'] != 0) {
            echo $annual_report[8]['all_month']['may']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jun']['pending'] != 0) {
            echo $annual_report[8]['all_month']['jun']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jul']['pending'] != 0) {
            echo $annual_report[8]['all_month']['jul']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['aug']['pending'] != 0) {
            echo $annual_report[8]['all_month']['aug']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['sep']['pending'] != 0) {
            echo $annual_report[8]['all_month']['sep']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['oct']['pending'] != 0) {
            echo $annual_report[8]['all_month']['oct']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['nov']['pending'] != 0) {
            echo $annual_report[8]['all_month']['nov']['pending'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['dec']['pending'] != 0) {
            echo $annual_report[8]['all_month']['dec']['pending'];
            }{echo '';} ?>,<?php
             ?>

            ]
        },
        {
            label: 'Unpaid',
            backgroundColor: '#9c27b0',
            borderColor: '#9c27b0',
            borderRadius: 4,
            maxBarThickness: 32,
            data: [
            <?php 
            if ($annual_report[8]['all_month']['jan']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['jan']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['feb']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['feb']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['mar']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['mar']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['apr']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['apr']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['may']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['may']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jun']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['jun']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jul']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['jul']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['aug']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['aug']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['sep']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['sep']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['oct']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['oct']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['nov']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['nov']['unpaid'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['dec']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['dec']['unpaid'];
            }{echo '';} ?>,<?php
             ?>

            ],
        },{
            label: 'Refunded',
            backgroundColor: '#000',
            borderColor: '#000',
            borderRadius: 4,
            maxBarThickness: 32,
            data: [
            <?php 
            if ($annual_report[8]['all_month']['jan']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['jan']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['feb']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['feb']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['mar']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['mar']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['apr']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['apr']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['may']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['may']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jun']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['jun']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jul']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['jul']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['aug']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['aug']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['sep']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['sep']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['oct']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['oct']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['nov']['refunded'] != 0) {
            echo $annual_report[8]['all_month']['nov']['refunded'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['dec']['unpaid'] != 0) {
            echo $annual_report[8]['all_month']['dec']['unpaid'];
            }{echo '';} ?>,<?php
             ?>

            ],
        },
        {
            label: 'Cancelled',
            backgroundColor: '#ff1b1b',
            borderColor: '#ff1b1b',
            borderRadius: 4,
            maxBarThickness: 32,
            data: [
            <?php 
            if ($annual_report[8]['all_month']['jan']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['jan']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['feb']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['feb']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['mar']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['mar']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['apr']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['apr']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['may']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['may']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jun']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['jun']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['jul']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['jul']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['aug']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['aug']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['sep']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['sep']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['oct']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['oct']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['nov']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['nov']['cancelled'];
            }{echo '';} ?>,<?php

            if ($annual_report[8]['all_month']['dec']['cancelled'] != 0) {
            echo $annual_report[8]['all_month']['dec']['cancelled'];
            }{echo '';} ?>,<?php
             ?>
             ],
        },
    ],
},
options: {
    scales: {
        x: {
            time: {
                unit: 'month'
            },
            gridLines: {
                display: false
            },
            ticks: {
                maxTicksLimit: 12
            },
        },
        y: {
            ticks: {
                min: 0,
                max: 50000,
                maxTicksLimit: 5
            },
            gridLines: {
                color: 'rgba(0, 0, 0, .075)',
            },
        },
    },
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            displayColors: true
        }
    },
}
});

</script>