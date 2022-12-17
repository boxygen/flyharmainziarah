<div class="row gx-3">

<style>
    .<?=$this->uri->segment(3);?>_ { background: #d3d6da; color: #000; font-weight: bold; }
</style>

    <div class="col-xxl-2 col-md-6 mb-3 ripple_primary">
        <a href="<?=base_url($this->uri->segment('1').'/bookings/confirmed')?>" class="text-decoration-none">
        <div class="card card-raised border-start border-info border-4 confirmed_">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5"><?=$confirmedCount?></div>
                        <div class="card-text" style="font-size: 12px">Confrimed Bookings</div>
                    </div>
                    <div class="icon-circle bg-info text-white" style="min-width:50px"><i class="material-icons">task_alt</i></div>
                </div>
                <!-- <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div> -->
            </div>
        </div>
        </a>
    </div>

    <div class="col-xxl-2 col-md-6 mb-3">
        <a href="<?=base_url($this->uri->segment('1').'/bookings/pending')?>" class="text-decoration-none">
        <div class="card card-raised border-start border-warning border-4 pending_">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5"><?=$pendingCount?></div>
                        <div class="card-text" style="font-size: 12px">Pending Bookings</div>
                    </div>
                    <div class="icon-circle bg-warning text-white" style="min-width:50px"><i class="material-icons">event</i></div>
                </div>
                <!-- <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div> -->
            </div>
        </div>
        </a>
    </div>

    <div class="col-xxl-2 col-md-6 mb-3">
        <a href="<?=base_url($this->uri->segment('1').'/bookings/cancelled')?>" class="text-decoration-none">
        <div class="card card-raised border-start border-danger border-4 cancelled_">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5"><?=$cancelledCount?></div>
                        <div class="card-text" style="font-size: 12px">Cancelled Bookings</div>
                    </div>
                    <div class="icon-circle bg-danger text-white" style="min-width:50px"><i class="material-icons">clear</i></div>
                </div>
                <!-- <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div> -->
            </div>
        </div>
        </a>
    </div>

    <div class="col-xxl-2 col-md-6 mb-5">
        <a href="<?=base_url($this->uri->segment('1').'/bookings/paid')?>" class="text-decoration-none">
        <div class="card card-raised border-start border-primary border-4 paid_">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5"><?=$paidCount?></div>
                        <div class="card-text" style="font-size: 12px">Paid Bookings</div>
                    </div>
                    <div class="icon-circle bg-primary text-white" style="min-width:50px"><i class="material-icons">credit_score</i></div>
                </div>
                <!-- <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div> -->
            </div>
        </div>
        </a>
    </div>

    <div class="col-xxl-2 col-md-6 mb-5">
        <a href="<?=base_url($this->uri->segment('1').'/bookings/unpaid')?>" class="text-decoration-none">
        <div class="card card-raised border-start border-secondary border-4 unpaid_">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5"><?=$unpaidCount?></div>
                        <div class="card-text" style="font-size: 12px">Unpaid Bookings</div>
                    </div>
                    <div class="icon-circle bg-secondary text-white" style="min-width:50px"><i class="material-icons">production_quantity_limits</i></div>
                </div>
                <!-- <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div> -->
            </div>
        </div>
        </a>
    </div>

    <div class="col-xxl-2 col-md-6 mb-5">
        <a href="<?=base_url($this->uri->segment('1').'/bookings/refunded')?>" class="text-decoration-none">
        <div class="card card-raised border-start border-dark border-4 refunded_">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5"><?=$refundedCount?></div>
                        <div class="card-text" style="font-size: 12px">Refunded Bookings</div>
                    </div>
                    <div class="icon-circle bg-dark text-white" style="min-width:50px"><i class="material-icons">money_off</i></div>
                </div>
                <!-- <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div> -->
            </div>
        </div>
        </a>
    </div>


<!--
    <div class="col-xxl-3 col-md-6 mb-5">
        <div class="card card-raised border-start border-warning border-4">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5">12.2K</div>
                        <div class="card-text">Purchases</div>
                    </div>
                    <div class="icon-circle bg-warning text-white"><i class="material-icons">storefront</i></div>
                </div>
                <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6 mb-5">
        <div class="card card-raised border-start border-secondary border-4">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5">5.3K</div>
                        <div class="card-text">Customers</div>
                    </div>
                    <div class="icon-circle bg-secondary text-white"><i class="material-icons">people</i></div>
                </div>
                <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6 mb-5">
        <div class="card card-raised border-start border-info border-4">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="me-2">
                        <div class="display-5">7</div>
                        <div class="card-text">Channels</div>
                    </div>
                    <div class="icon-circle bg-info text-white"><i class="material-icons">devices</i></div>
                </div>
                <div class="card-text">
                    <div class="d-inline-flex align-items-center">
                        <i class="material-icons icon-xs text-success">arrow_upward</i>
                        <div class="caption text-success fw-500 me-2">3%</div>
                        <div class="caption">from last month</div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
