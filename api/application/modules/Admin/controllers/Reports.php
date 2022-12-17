<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MX_Controller
{


    function __construct()
    {

        parent::__construct();

        modules::load('Admin');

        // $chkadmin = modules::run('Admin/validadmin');

        // if (!$chkadmin) {
        //     $this->session->set_userdata('prevURL', current_url());
        //     redirect('admin');

        // }

        // $this->data['app_settings'] = $this->Settings_model->get_settings_data();

        // $this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
        // $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
        // $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');


    }

    public function index()

    {

//strtotime(date('Y-m-01'))." ".date('Y-m-t');

        $this->data['modules'] = $this->Modules_model->get_module_names();

        $this->data['chklib'] = $this->ptmodules;

        $filter = $this->input->post('filtermod');

        $this->data['selmodule'] = $this->input->post('module');

        $module = $this->data['selmodule'];

        if (!empty($filter) && !empty($module)) {

            $this->$module();

        } else {

            $this->data['monthly'] = $this->monthly_report();

            $this->data['thismonth'] = $this->this_month_report();

            $this->data['thisyear'] = $this->this_year_report();

            $this->data['thisday'] = $this->this_day_report();

            $this->data['main_content'] = 'modules/reports/reports';

            $this->data['page_title'] = 'Reports';

            $this->load->view('template', $this->data);

        }

    }

    public function hotels()

    {

        $this->data['monthly'] = $this->monthly_report('hotels');

        $this->data['thismonth'] = $this->this_month_report('hotels');

        $this->data['thisyear'] = $this->this_year_report('hotels');

        $this->data['thisday'] = $this->this_day_report('hotels');

        $this->data['main_content'] = 'modules/reports/reports';

        $this->data['page_title'] = 'Reports';

        $this->load->view('template', $this->data);

    }

    public function cruises()

    {

        $this->data['monthly'] = $this->monthly_report('cruises');

        $this->data['thismonth'] = $this->this_month_report('cruises');

        $this->data['thisyear'] = $this->this_year_report('cruises');

        $this->data['thisday'] = $this->this_day_report('cruises');

        $this->data['main_content'] = 'modules/reports/reports';

        $this->data['page_title'] = 'Reports';

        $this->load->view('template', $this->data);

    }

    public function tours()

    {

        $this->data['monthly'] = $this->monthly_report('tours');

        $this->data['thismonth'] = $this->this_month_report('tours');

        $this->data['thisyear'] = $this->this_year_report('tours');

        $this->data['thisday'] = $this->this_day_report('tours');

        $this->data['main_content'] = 'modules/reports/reports';

        $this->data['page_title'] = 'Reports';

        $this->load->view('template', $this->data);

    }

    public function cars()

    {

        $this->data['monthly'] = $this->monthly_report('cars');

        $this->data['thismonth'] = $this->this_month_report('cars');

        $this->data['thisyear'] = $this->this_year_report('cars');

        $this->data['thisday'] = $this->this_day_report('cars');

        $this->data['main_content'] = 'modules/reports/reports';

        $this->data['page_title'] = 'Reports';

        $this->load->view('template', $this->data);

    }

    function this_day_report($type = null)
    {

        $first = time() - 86400;

        $last = time();

        $this->db->select_sum('booking_amount_paid');

        if (!empty($type)) {

            $this->db->where('booking_type', $type);

        }

        $this->db->where('booking_payment_date >=', $first);

        $this->db->where('booking_payment_date <=', $last);

        $this->db->where('booking_status', 'paid');

        $res = $this->db->get('pt_bookings')->result();

        return round($res[0]->booking_amount_paid, 2);

    }

    function this_month_report($type = null)
    {

        $from = strtotime(date('Y-m-01'));

        $to = strtotime(date('Y-m-t'));

        $this->db->select_sum('booking_amount_paid');

        if (!empty($type)) {

            $this->db->where('booking_type', $type);

        }

        $this->db->where('booking_payment_date >=', $from);

        $this->db->where('booking_payment_date <=', $to);

        $this->db->where('booking_status', 'paid');

        $res = $this->db->get('pt_bookings')->result();

        return round($res[0]->booking_amount_paid, 2);

    }

    function this_year_report($type = null)
    {

        $year = date("Y");

        $first = strtotime($year . "-01-01");

        $last = strtotime($year . "-12-31");

        $this->db->select_sum('booking_amount_paid');

        if (!empty($type)) {

            $this->db->where('booking_type', $type);

        }

        $this->db->where('booking_payment_date >=', $first);

        $this->db->where('booking_payment_date <=', $last);

        $this->db->where('booking_status', 'paid');

        $res = $this->db->get('pt_bookings')->result();

        return round($res[0]->booking_amount_paid, 2);

    }

//  from and to date report

    function from_to_report()
    {

        $from = str_replace("/", "-", $this->input->post('from'));

        $to = str_replace("/", "-", $this->input->post('to'));

        $type = $this->input->post('type');

        $this->db->select_sum('booking_amount_paid');

        if (!empty($type)) {

            $this->db->where('booking_type', $type);

        }

        $this->db->where('booking_payment_date >=', strtotime($from));

        $this->db->where('booking_payment_date <=', strtotime($to));

        $this->db->where('booking_status', 'paid');

        $res = $this->db->get('pt_bookings')->result();

        $html = "

<h1><strong>" . $this->data['app_settings'][0]->currency_sign . round($res[0]->booking_amount_paid, 2) . "</strong></h1>

";

        $html .= "

<h5>From " . $this->input->post('from') . " <br> to " . $this->input->post('to') . "</h5>

";

        echo $html;

    }

    function monthly_report($type = null)
    {

        $datearray = array();

        $resultarray = array();

        $year = date("Y");

        for ($m = 1; $m < 13; $m++) {

            $datearray[strtotime($year . "-" . $m . "-1")] = strtotime($year . "-" . $m . "-31");

        }

        foreach ($datearray as $start => $end) {

            $this->db->select_sum('booking_amount_paid');

            if (!empty($type)) {

                $this->db->where('booking_type', $type);

            }

            $this->db->where('booking_date >=', $start);

            $this->db->where('booking_date <=', $end);

            $this->db->where('booking_status', 'paid');

            $res = $this->db->get('pt_bookings')->result();

            $resultarray[] = round($res[0]->booking_amount_paid, 2);

        }

        return $resultarray;

    }


//Last today bookingreport
    function today($type = null)
    {

        $info = new stdClass;
        $info->paidAmount = 0;
        $info->paidCount = 0;

        $info->unpaidAmount = 0;
        $info->unpaidCount = 0;

        $info->reservedCount = 0;

        $first = strtotime(date('Y-m-d'));

        $last = time();


        if (!empty($type)) {

            $this->db->where('booking_type', $type);

        }

        $this->db->where('booking_date >=', $first);

        $this->db->where('booking_date <=', $last);


        $result = $this->db->get('pt_bookings')->result();

        if (!empty($result)) {

            foreach ($result as $res) {
                if ($res->booking_status == "paid") {
                    $info->paidCount += 1;
                    $info->paidAmount += $res->booking_amount_paid;

                } elseif ($res->booking_status == "unpaid") {
                    $info->unpaidCount += 1;
                    $info->unpaidAmount += $res->booking_deposit;

                } elseif ($res->booking_status == "reserved") {
                    $info->reservedCount += 1;

                }


            }

        }

        $info->totalCount = $info->paidCount + $info->unpaidCount + $info->reservedCount;
        $info->totalAmount = $info->paidAmount;


        return $info;


    }

//end Today booking report


//Last 30 days bookingreport
    function thirtydays($type = null)
    {
        $info = new stdClass;
        $info->paidAmount = 0;
        $info->paidCount = 0;

        $info->unpaidAmount = 0;
        $info->unpaidCount = 0;

        $info->reservedCount = 0;

        $bookingAmount = 0;

        $from = strtotime(date('Y-m-d', strtotime('-30 days')));

        $to = time();


        if (!empty($type)) {

            $this->db->where('booking_type', $type);

        }

        $this->db->where('booking_date >=', $from);

        $this->db->where('booking_date <=', $to);


        $result = $this->db->get('pt_bookings')->result();
        if (!empty($result)) {

            foreach ($result as $res) {

                $temp = 0;
                if ($res->booking_status == "paid") {

                    $info->paidCount += 1;
                    $info->paidAmount += $res->booking_amount_paid;


                } elseif ($res->booking_status == "unpaid") {
                    $info->unpaidCount += 1;
                    $info->unpaidAmount += $res->booking_deposit;

                } elseif ($res->booking_status == "reserved") {
                    $info->reservedCount += 1;

                }


            }

        }


        $info->totalCount = $info->paidCount + $info->unpaidCount + $info->reservedCount;
        $info->totalAmount = $info->paidAmount;


        return $info;


    }

//end last 30 days booking report


//different durations bookings booking report
    function diffLastDuration($duration, $type = null)
    {

        $info = new stdClass;
        $info->paidAmount = 0;
        $info->paidCount = 0;

        $info->unpaidAmount = 0;
        $info->unpaidCount = 0;

        $info->reservedCount = 0;

        $first = strtotime(date('Y-m-d', strtotime('-' . $duration . ' days')));

        $last = time();


        if (!empty($type)) {

            $this->db->where('booking_type', $type);

        }

        $this->db->where('booking_date >=', $first);

        $this->db->where('booking_date <=', $last);


        $result = $this->db->get('pt_bookings')->result();

        if (!empty($result)) {

            foreach ($result as $res) {
                if ($res->booking_status == "paid") {
                    $info->paidCount += 1;
                    $info->paidAmount += $res->booking_amount_paid;

                } elseif ($res->booking_status == "unpaid") {
                    $info->unpaidCount += 1;
                    $info->unpaidAmount += $res->booking_deposit;

                } elseif ($res->booking_status == "reserved") {
                    $info->reservedCount += 1;


                }


            }

        }

        $info->totalCount = $info->paidCount + $info->unpaidCount + $info->reservedCount;
        $info->totalAmount = $info->paidAmount;


        return $info;


    }

//end different duration booking report


//different durations bookings booking report
    function diffLastDurationPaid($duration, $type = null)
    {

        $info = new stdClass;
        $info->paidAmount = 0;
        $info->paidCount = 0;

        if ($duration > 0) {
            $first = strtotime(date('Y-m-d', strtotime('-' . $duration . ' days')));
        } else {

            $first = strtotime(date('Y-m-d'));

        }


        $last = time();


        if (!empty($type)) {

            $this->db->where('booking_type', $type);

        }

        $this->db->where('booking_payment_date >=', $first);

        $this->db->where('booking_payment_date <=', $last);


        $result = $this->db->get('pt_bookings')->result();

        if (!empty($result)) {

            foreach ($result as $res) {
                if ($res->booking_status == "paid") {
                    $info->paidCount += 1;
                    $info->paidAmount += $res->booking_amount_paid;

                }


            }

        }

        $info->totalCount = $info->paidCount;
        $info->totalPaidAmount = $info->paidAmount;


        return $info;


    }

//end different duration booking report
    function accountsCount($type)
    {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("accounts_type", $type);
        $counts = $this->db->get("pt_accounts")->row()->total;
        return $counts;
    }

/*booking count reports*/
    function pendingbCount($type)
    {
        $count_res = [];
        $m = ['hotels_bookings','flights_bookings','tours_bookings'];
        foreach ($m as $key => $value) {
            $this->db->select("COUNT(*) AS total");
            $this->db->where("".$value.".booking_status", $type);
            $counts_ = $this->db->get($value)->row()->total;
            array_push($count_res,$counts_);
        }
        
        $a = 0;
        for ($i=0; $i < count($count_res); $i++) { 
            $a = $a + $count_res[$i];
        }
        return $a;
    }

        function confirmedbCount($type)
    {
        $count_res = [];
        $m = ['hotels_bookings','flights_bookings','tours_bookings'];
        foreach ($m as $key => $value) {
            $this->db->select("COUNT(*) AS total");
            $this->db->where("".$value.".booking_status", $type);
            $counts_ = $this->db->get($value)->row()->total;
            array_push($count_res,$counts_);
        }
        
        $a = 0;
        for ($i=0; $i < count($count_res); $i++) { 
            $a = $a + $count_res[$i];
        }
        return $a;
    }

        function cancelledbCount($type)
    {

        $count_res = [];
        $m = ['hotels_bookings','flights_bookings','tours_bookings'];
        foreach ($m as $key => $value) {
            $this->db->select("COUNT(*) AS total");
            $this->db->where("".$value.".booking_status", $type);
            $counts_ = $this->db->get($value)->row()->total;
            array_push($count_res,$counts_);
        }
        
        $a = 0;
        for ($i=0; $i < count($count_res); $i++) { 
            $a = $a + $count_res[$i];
        }
        return $a;

    }

        function paidbCount($type)
    {
        $count_res = [];
        $m = ['hotels_bookings','flights_bookings','tours_bookings'];
        foreach ($m as $key => $value) {
            $this->db->select("COUNT(*) AS total");
            $this->db->where("".$value.".booking_payment_status", $type);
            $counts_ = $this->db->get($value)->row()->total;
            array_push($count_res,$counts_);
        }
        
        $a = 0;
        for ($i=0; $i < count($count_res); $i++) { 
            $a = $a + $count_res[$i];
        }
        return $a;
    }

        function unpaidbCount($type)
    {
        $count_res = [];
        $m = ['hotels_bookings','flights_bookings','tours_bookings'];
        foreach ($m as $key => $value) {
            $this->db->select("COUNT(*) AS total");
            $this->db->where("".$value.".booking_payment_status", $type);
            $counts_ = $this->db->get($value)->row()->total;
            array_push($count_res,$counts_);
        }
        
        $a = 0;
        for ($i=0; $i < count($count_res); $i++) { 
            $a = $a + $count_res[$i];
        }
        return $a;
    }

        function refundedbCount($type)
    {
        $count_res = [];
        $m = ['hotels_bookings','flights_bookings','tours_bookings'];
        foreach ($m as $key => $value) {
            $this->db->select("COUNT(*) AS total");
            $this->db->where("".$value.".booking_payment_status", $type);
            $counts_ = $this->db->get($value)->row()->total;
            array_push($count_res,$counts_);
        }
        
        $a = 0;
        for ($i=0; $i < count($count_res); $i++) { 
            $a = $a + $count_res[$i];
        }
        return $a;
    }
 
function annual_report()
{

$annual_report = [];
$first_day_of_year  = strtotime(date('Y-m-d', strtotime('first day of january this year')));

//all_booking
$this->db->where('hotels_bookings.booking_date >=', $first_day_of_year);
$hotels_bookings=$this->db->get('hotels_bookings')->num_rows();
$this->db->where('flights_bookings.booking_date >=', $first_day_of_year);
$flights_bookings=$this->db->get('flights_bookings')->num_rows();
$this->db->where('tours_bookings.booking_date >=', $first_day_of_year);
$tours_bookings=$this->db->get('tours_bookings')->num_rows();
$this->db->where('booking_visa.booking_date >=', $first_day_of_year);
$booking_visa=$this->db->get('booking_visa')->num_rows();
    $all_booking = $hotels_bookings+$flights_bookings+$tours_bookings+$booking_visa;
array_push($annual_report,array('total_booking'=>$all_booking));

//total_revenue
$this->db->select_sum('booking_amount_paid');
$this->db->from('hotels_bookings');
$this->db->where('booking_payment_status','paid');
$this->db->where('booking_date >=', $first_day_of_year);
$hotels_revenue=$this->db->get()->result();
$this->db->select_sum('booking_amount_paid');
$this->db->from('flights_bookings');
$this->db->where('booking_payment_status','paid');
$this->db->where('booking_date >=', $first_day_of_year);
$flights_revenue=$this->db->get()->result();
$this->db->select_sum('booking_amount_paid');
$this->db->from('tours_bookings');
$this->db->where('booking_payment_status','paid');
$this->db->where('booking_date >=', $first_day_of_year);
$tours_revenue=$this->db->get()->result();
$this->db->select_sum('booking_amount_paid');
$this->db->from('booking_visa');
$this->db->where('booking_payment_status','paid');
$this->db->where('booking_date >=', $first_day_of_year);
$visa_revenue=$this->db->get()->result();
$this->db->select_sum('booking_amount_paid');
$this->db->from('pt_booked_cars');
$this->db->where('booking_payment_status','paid');
$this->db->where('booking_date >=', $first_day_of_year);
$cars_revenue=$this->db->get()->result();
$total_revenue = $hotels_revenue[0]->booking_amount_paid+$flights_revenue[0]->booking_amount_paid+$tours_revenue[0]->booking_amount_paid+$visa_revenue[0]->booking_amount_paid+$cars_revenue[0]->booking_amount_paid;
array_push($annual_report,array('total_revenue'=>$total_revenue));

//all_paidBookings
$paidBookings_res = [];
$modules = ['hotels_bookings','flights_bookings','tours_bookings','booking_visa','pt_booked_cars'];
foreach ($modules as $key => $value) {
$this->db->select("COUNT(*) AS total");
$this->db->where("".$value.".booking_payment_status", 'paid');
$this->db->where("".$value.".booking_date >=", $first_day_of_year);
$paidBookings_counts = $this->db->get($value)->row()->total;
array_push($paidBookings_res,$paidBookings_counts);
}

$all_paidBookings = 0;
for ($i=0; $i < count($paidBookings_res); $i++) { 
    $all_paidBookings = $all_paidBookings + $paidBookings_res[$i];
}
array_push($annual_report,array('all_paidBookings'=>$all_paidBookings));

//all_unpaidBookings
$unpaidBookings_res = [];
$modules = ['hotels_bookings','flights_bookings','tours_bookings','booking_visa','pt_booked_cars'];
foreach ($modules as $key => $value) {
$this->db->select("COUNT(*) AS total");
$this->db->where("".$value.".booking_payment_status", 'unpaid');
$this->db->where("".$value.".booking_date >=", $first_day_of_year);
$unpaidBookings_counts = $this->db->get($value)->row()->total;
array_push($unpaidBookings_res,$unpaidBookings_counts);
}

$all_unpaidBookings = 0;
for ($i=0; $i < count($unpaidBookings_res); $i++) { 
    $all_unpaidBookings = $all_unpaidBookings + $unpaidBookings_res[$i];
}
array_push($annual_report,array('all_unpaidBookings'=>$all_unpaidBookings));

//all_pendingBookings
$pendingBookings_res = [];
foreach ($modules as $key => $value) {
$this->db->select("COUNT(*) AS total");
$this->db->where("".$value.".booking_status", 'pending');
$this->db->where("".$value.".booking_date >=", $first_day_of_year);
$pendingBookings_counts = $this->db->get($value)->row()->total;
array_push($pendingBookings_res,$pendingBookings_counts);
}

$all_pendingBookings = 0;
for ($i=0; $i < count($pendingBookings_res); $i++) {
    $all_pendingBookings = $all_pendingBookings + $pendingBookings_res[$i];
}
array_push($annual_report,array('all_pendingBookings'=>$all_pendingBookings));

//all_confirmedBookings
$confirmedBookings_res = [];
foreach ($modules as $key => $value) {
$this->db->select("COUNT(*) AS total");
$this->db->where("".$value.".booking_status", 'confirmed');
$this->db->where("".$value.".booking_date >=", $first_day_of_year);
$confirmedBookings_counts = $this->db->get($value)->row()->total;
array_push($confirmedBookings_res,$confirmedBookings_counts);
}

$all_confirmedBookings = 0;
for ($i=0; $i < count($confirmedBookings_res); $i++) {
    $all_confirmedBookings = $all_confirmedBookings + $confirmedBookings_res[$i];
}
array_push($annual_report,array('all_confirmedBookings'=>$all_confirmedBookings));

//all_cancelledBookings
$cancelledBookings_res = [];
foreach ($modules as $key => $value) {
$this->db->select("COUNT(*) AS total");
$this->db->where("".$value.".booking_status", 'cancelled');
$this->db->where("".$value.".booking_date >=", $first_day_of_year);
$cancelledBookings_counts = $this->db->get($value)->row()->total;
array_push($cancelledBookings_res,$cancelledBookings_counts);
}

$all_cancelledBookings = 0;
for ($i=0; $i < count($cancelledBookings_res); $i++) {
$all_cancelledBookings = $all_cancelledBookings + $cancelledBookings_res[$i];
}
array_push($annual_report,array('all_cancelledBookings'=>$all_cancelledBookings));

//all_refundedBookings
$refundedBookings_res = [];
foreach ($modules as $key => $value) {
$this->db->select("COUNT(*) AS total");
$this->db->where("".$value.".booking_payment_status", 'refunded');
$this->db->where("".$value.".booking_date >=", $first_day_of_year);
$refundedBookings_counts = $this->db->get($value)->row()->total;
array_push($refundedBookings_res,$refundedBookings_counts);
}

$all_refundedBookings = 0;
for ($i=0; $i < count($refundedBookings_res); $i++) {
$all_refundedBookings = $all_refundedBookings + $refundedBookings_res[$i];
}
array_push($annual_report,array('all_refundedBookings'=>$all_refundedBookings));



//all month bookings
$status_arr = ['bookings','confirmed','pending','cancelled','paid','unpaid','refunded'];
//jan bookings
$jan_from = strtotime(date('Y-m-d', strtotime('first day of jan this year')));
$jan_last  = strtotime(date('Y-m-d', strtotime('last day of jan this year')));
$jan_arr = [];
for ($m = $jan_from; $m <= $jan_last; $m += 86400) {
$jan_datearray[$m] = $m + 86400;}

foreach ($jan_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $jan_bookings = $this->db->get($value)->row()->total;

        if ($s == 'paid')
        {array_push($jan_arr,array('paid'=>$jan_bookings));}
        if ($s == 'unpaid') 
        {array_push($jan_arr,array('unpaid'=>$jan_bookings));}
        if ($s == 'cancelled') 
        {array_push($jan_arr,array('cancelled'=>$jan_bookings));}
        if ($s == 'confirmed') 
        {array_push($jan_arr,array('confirmed'=>$jan_bookings));}
        if ($s == 'pending') 
        {array_push($jan_arr,array('pending'=>$jan_bookings));}
        if ($s == 'refunded') 
        {array_push($jan_arr,array('refunded'=>$jan_bookings));}
        if ($s == 'bookings') 
        {array_push($jan_arr,array('bookings'=>$jan_bookings));}

}}}

$jan_paid = 0;
$jan_unpaid = 0;
$jan_cancelled = 0;
$jan_confirmed = 0;
$jan_pending = 0;
$jan_refunded = 0;
$jan_bookings = 0;
for ($i=0; $i < count($jan_arr); $i++) {
$jan_paid = $jan_paid + $jan_arr[$i]['paid'];
$jan_unpaid = $jan_unpaid + $jan_arr[$i]['unpaid'];
$jan_cancelled = $jan_cancelled + $jan_arr[$i]['cancelled'];
$jan_confirmed = $jan_confirmed + $jan_arr[$i]['confirmed'];
$jan_pending = $jan_pending + $jan_arr[$i]['pending'];
$jan_refunded = $jan_refunded + $jan_arr[$i]['refunded'];
$jan_bookings = $jan_bookings + $jan_arr[$i]['bookings'];
}
//end jan bookings

//feb bookings
$feb_from = strtotime(date('Y-m-d', strtotime('first day of feb this year')));
$feb_last  = strtotime(date('Y-m-d', strtotime('last day of feb this year')));
$feb_arr = [];
for ($m = $feb_from; $m <= $feb_last; $m += 86400) {
$feb_datearray[$m] = $m + 86400;}

foreach ($feb_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $feb_bookings = $this->db->get($value)->row()->total;


        if ($s == 'paid')
        {array_push($feb_arr,array('paid'=>$feb_bookings));}
        if ($s == 'unpaid') 
        {array_push($feb_arr,array('unpaid'=>$feb_bookings));}
        if ($s == 'cancelled') 
        {array_push($feb_arr,array('cancelled'=>$feb_bookings));}
        if ($s == 'confirmed') 
        {array_push($feb_arr,array('confirmed'=>$feb_bookings));}
        if ($s == 'pending') 
        {array_push($feb_arr,array('pending'=>$feb_bookings));}
        if ($s == 'refunded') 
        {array_push($feb_arr,array('refunded'=>$feb_bookings));}
        if ($s == 'bookings') 
        {array_push($feb_arr,array('bookings'=>$feb_bookings));}

}}}


$feb_paid = 0;
$feb_unpaid = 0;
$feb_cancelled = 0;
$feb_confirmed = 0;
$feb_pending = 0;
$feb_refunded = 0;
$feb_bookings = 0;
for ($i=0; $i < count($feb_arr); $i++) {
$feb_paid = $feb_paid + $feb_arr[$i]['paid'];
$feb_unpaid = $feb_unpaid + $feb_arr[$i]['unpaid'];
$feb_cancelled = $feb_cancelled + $feb_arr[$i]['cancelled'];
$feb_confirmed = $feb_confirmed + $feb_arr[$i]['confirmed'];
$feb_pending = $feb_pending + $feb_arr[$i]['pending'];
$feb_refunded = $feb_refunded + $feb_arr[$i]['refunded'];
$feb_bookings = $feb_bookings + $feb_arr[$i]['bookings'];
}
//end feb bookings


//mar bookings
$mar_from = strtotime(date('Y-m-d', strtotime('first day of mar this year')));
$mar_last  = strtotime(date('Y-m-d', strtotime('last day of mar this year')));
$mar_arr = [];
for ($m = $mar_from; $m <= $mar_last; $m += 86400) {
$mar_datearray[$m] = $m + 86400;}

foreach ($mar_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $mar_bookings = $this->db->get($value)->row()->total;

        if ($s == 'paid')
        {array_push($mar_arr,array('paid'=>$mar_bookings));}
        if ($s == 'unpaid') 
        {array_push($mar_arr,array('unpaid'=>$mar_bookings));}
        if ($s == 'cancelled') 
        {array_push($mar_arr,array('cancelled'=>$mar_bookings));}
        if ($s == 'confirmed') 
        {array_push($mar_arr,array('confirmed'=>$mar_bookings));}
        if ($s == 'pending') 
        {array_push($mar_arr,array('pending'=>$mar_bookings));}
        if ($s == 'refunded') 
        {array_push($mar_arr,array('refunded'=>$mar_bookings));}
        if ($s == 'bookings') 
        {array_push($mar_arr,array('bookings'=>$mar_bookings));}

}}}


$mar_paid = 0;
$mar_unpaid = 0;
$mar_cancelled = 0;
$mar_confirmed = 0;
$mar_pending = 0;
$mar_refunded = 0;
$mar_bookings = 0;
for ($i=0; $i < count($mar_arr); $i++) {
$mar_paid = $mar_paid + $mar_arr[$i]['paid'];
$mar_unpaid = $mar_unpaid + $mar_arr[$i]['unpaid'];
$mar_cancelled = $mar_cancelled + $mar_arr[$i]['cancelled'];
$mar_confirmed = $mar_confirmed + $mar_arr[$i]['confirmed'];
$mar_pending = $mar_pending + $mar_arr[$i]['pending'];
$mar_refunded = $mar_refunded + $mar_arr[$i]['refunded'];
$mar_bookings = $mar_bookings + $mar_arr[$i]['bookings'];
}
//end mar bookings


//apr bookings
$apr_from = strtotime(date('Y-m-d', strtotime('first day of apr this year')));
$apr_last  = strtotime(date('Y-m-d', strtotime('last day of apr this year')));
$apr_arr = [];
for ($m = $apr_from; $m <= $apr_last; $m += 86400) {
$apr_datearray[$m] = $m + 86400;}

foreach ($apr_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $apr_bookings = $this->db->get($value)->row()->total;

        if ($s == 'paid')
        {array_push($apr_arr,array('paid'=>$apr_bookings));}
        if ($s == 'unpaid') 
        {array_push($apr_arr,array('unpaid'=>$apr_bookings));}
        if ($s == 'cancelled') 
        {array_push($apr_arr,array('cancelled'=>$apr_bookings));}
        if ($s == 'confirmed') 
        {array_push($apr_arr,array('confirmed'=>$apr_bookings));}
        if ($s == 'pending') 
        {array_push($apr_arr,array('pending'=>$apr_bookings));}
        if ($s == 'refunded') 
        {array_push($apr_arr,array('refunded'=>$apr_bookings));}
        if ($s == 'bookings') 
        {array_push($apr_arr,array('bookings'=>$apr_bookings));}

}}}

$apr_paid = 0;
$apr_unpaid = 0;
$apr_cancelled = 0;
$apr_confirmed = 0;
$apr_pending = 0;
$apr_refunded = 0;
$apr_bookings = 0;
for ($i=0; $i < count($apr_arr); $i++) {
$apr_paid = $apr_paid + $apr_arr[$i]['paid'];
$apr_unpaid = $apr_unpaid + $apr_arr[$i]['unpaid'];
$apr_cancelled = $apr_cancelled + $apr_arr[$i]['cancelled'];
$apr_confirmed = $apr_confirmed + $apr_arr[$i]['confirmed'];
$apr_pending = $apr_pending + $apr_arr[$i]['pending'];
$apr_refunded = $apr_refunded + $apr_arr[$i]['refunded'];
$apr_bookings = $apr_bookings + $apr_arr[$i]['bookings'];
}
//end apr bookings

//may bookings
$may_from = strtotime(date('Y-m-d', strtotime('first day of may this year')));
$may_last  = strtotime(date('Y-m-d', strtotime('last day of may this year')));
$may_arr = [];
for ($m = $may_from; $m <= $may_last; $m += 86400) {
$may_datearray[$m] = $m + 86400;}

foreach ($may_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $may_bookings = $this->db->get($value)->row()->total;

        if ($s == 'paid')
        {array_push($may_arr,array('paid'=>$may_bookings));}
        if ($s == 'unpaid') 
        {array_push($may_arr,array('unpaid'=>$may_bookings));}
        if ($s == 'cancelled') 
        {array_push($may_arr,array('cancelled'=>$may_bookings));}
        if ($s == 'confirmed') 
        {array_push($may_arr,array('confirmed'=>$may_bookings));}
        if ($s == 'pending') 
        {array_push($may_arr,array('pending'=>$may_bookings));}
        if ($s == 'refunded') 
        {array_push($may_arr,array('refunded'=>$may_bookings));}
        if ($s == 'bookings') 
        {array_push($may_arr,array('bookings'=>$may_bookings));}

}}}

$may_paid = 0;
$may_unpaid = 0;
$may_cancelled = 0;
$may_confirmed = 0;
$may_pending = 0;
$may_refunded = 0;
$may_bookings = 0;
for ($i=0; $i < count($may_arr); $i++) {
$may_paid = $may_paid + $may_arr[$i]['paid'];
$may_unpaid = $may_unpaid + $may_arr[$i]['unpaid'];
$may_cancelled = $may_cancelled + $may_arr[$i]['cancelled'];
$may_confirmed = $may_confirmed + $may_arr[$i]['confirmed'];
$may_pending = $may_pending + $may_arr[$i]['pending'];
$may_refunded = $may_refunded + $may_arr[$i]['refunded'];
$may_bookings = $may_bookings + $may_arr[$i]['bookings'];
}
//end may bookings


//jun bookings
$jun_from = strtotime(date('Y-m-d', strtotime('first day of jun this year')));
$jun_last  = strtotime(date('Y-m-d', strtotime('last day of jun this year')));
$jun_arr = [];
for ($m = $jun_from; $m <= $jun_last; $m += 86400) {
$jun_datearray[$m] = $m + 86400;}

foreach ($jun_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $jun_bookings = $this->db->get($value)->row()->total;


        if ($s == 'paid')
        {array_push($jun_arr,array('paid'=>$jun_bookings));}
        if ($s == 'unpaid') 
        {array_push($jun_arr,array('unpaid'=>$jun_bookings));}
        if ($s == 'cancelled') 
        {array_push($jun_arr,array('cancelled'=>$jun_bookings));}
        if ($s == 'confirmed') 
        {array_push($jun_arr,array('confirmed'=>$jun_bookings));}
        if ($s == 'pending') 
        {array_push($jun_arr,array('pending'=>$jun_bookings));}
        if ($s == 'refunded') 
        {array_push($jun_arr,array('refunded'=>$jun_bookings));}
        if ($s == 'bookings') 
        {array_push($jun_arr,array('bookings'=>$jun_bookings));}

}}}

$jun_paid = 0;
$jun_unpaid = 0;
$jun_cancelled = 0;
$jun_confirmed = 0;
$jun_pending = 0;
$jun_refunded = 0;
$jun_bookings = 0;
for ($i=0; $i < count($jun_arr); $i++) {
$jun_paid = $jun_paid + $jun_arr[$i]['paid'];
$jun_unpaid = $jun_unpaid + $jun_arr[$i]['unpaid'];
$jun_cancelled = $jun_cancelled + $jun_arr[$i]['cancelled'];
$jun_confirmed = $jun_confirmed + $jun_arr[$i]['confirmed'];
$jun_pending = $jun_pending + $jun_arr[$i]['pending'];
$jun_refunded = $jun_refunded + $jun_arr[$i]['refunded'];
$jun_bookings = $jun_bookings + $jun_arr[$i]['bookings'];
}
//end jun bookings

//jul bookings
$jul_from = strtotime(date('Y-m-d', strtotime('first day of jul this year')));
$jul_last  = strtotime(date('Y-m-d', strtotime('last day of jul this year')));
$jul_arr = [];
for ($m = $jul_from; $m <= $jul_last; $m += 86400) {
$jul_datearray[$m] = $m + 86400;}

foreach ($jul_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $jul_bookings = $this->db->get($value)->row()->total;

        if ($s == 'paid')
        {array_push($jul_arr,array('paid'=>$jul_bookings));}
        if ($s == 'unpaid') 
        {array_push($jul_arr,array('unpaid'=>$jul_bookings));}
        if ($s == 'cancelled') 
        {array_push($jul_arr,array('cancelled'=>$jul_bookings));}
        if ($s == 'confirmed') 
        {array_push($jul_arr,array('confirmed'=>$jul_bookings));}
        if ($s == 'pending') 
        {array_push($jul_arr,array('pending'=>$jul_bookings));}
        if ($s == 'refunded') 
        {array_push($jul_arr,array('refunded'=>$jul_bookings));}
        if ($s == 'bookings') 
        {array_push($jul_arr,array('bookings'=>$jul_bookings));}

}}}

$jul_paid = 0;
$jul_unpaid = 0;
$jul_cancelled = 0;
$jul_confirmed = 0;
$jul_pending = 0;
$jul_refunded = 0;
$jul_bookings = 0;
for ($i=0; $i < count($jul_arr); $i++) {
$jul_paid = $jul_paid + $jul_arr[$i]['paid'];
$jul_unpaid = $jul_unpaid + $jul_arr[$i]['unpaid'];
$jul_cancelled = $jul_cancelled + $jul_arr[$i]['cancelled'];
$jul_confirmed = $jul_confirmed + $jul_arr[$i]['confirmed'];
$jul_pending = $jul_pending + $jul_arr[$i]['pending'];
$jul_refunded = $jul_refunded + $jul_arr[$i]['refunded'];
$jul_bookings = $jul_bookings + $jul_arr[$i]['bookings'];
}
//end jul bookings

//aug bookings
$aug_from = strtotime(date('Y-m-d', strtotime('first day of aug this year')));
$aug_last  = strtotime(date('Y-m-d', strtotime('last day of aug this year')));
$aug_arr = [];
for ($m = $aug_from; $m <= $aug_last; $m += 86400) {
$aug_datearray[$m] = $m + 86400;}

foreach ($aug_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $aug_bookings = $this->db->get($value)->row()->total;


        if ($s == 'paid')
        {array_push($aug_arr,array('paid'=>$aug_bookings));}
        if ($s == 'unpaid') 
        {array_push($aug_arr,array('unpaid'=>$aug_bookings));}
        if ($s == 'cancelled') 
        {array_push($aug_arr,array('cancelled'=>$aug_bookings));}
        if ($s == 'confirmed') 
        {array_push($aug_arr,array('confirmed'=>$aug_bookings));}
        if ($s == 'pending') 
        {array_push($aug_arr,array('pending'=>$aug_bookings));}
        if ($s == 'refunded') 
        {array_push($aug_arr,array('refunded'=>$aug_bookings));}
        if ($s == 'bookings') 
        {array_push($aug_arr,array('bookings'=>$aug_bookings));}

}}}

$aug_paid = 0;
$aug_unpaid = 0;
$aug_cancelled = 0;
$aug_confirmed = 0;
$aug_pending = 0;
$aug_refunded = 0;
$aug_bookings = 0;
for ($i=0; $i < count($aug_arr); $i++) {
$aug_paid = $aug_paid + $aug_arr[$i]['paid'];
$aug_unpaid = $aug_unpaid + $aug_arr[$i]['unpaid'];
$aug_cancelled = $aug_cancelled + $aug_arr[$i]['cancelled'];
$aug_confirmed = $aug_confirmed + $aug_arr[$i]['confirmed'];
$aug_pending = $aug_pending + $aug_arr[$i]['pending'];
$aug_refunded = $aug_refunded + $aug_arr[$i]['refunded'];
$aug_bookings = $aug_bookings + $aug_arr[$i]['bookings'];
}
//end aug bookings


//sep bookings
$sep_from = strtotime(date('Y-m-d', strtotime('first day of sep this year')));
$sep_last  = strtotime(date('Y-m-d', strtotime('last day of sep this year')));
$sep_arr = [];
for ($m = $sep_from; $m <= $sep_last; $m += 86400) {
$sep_datearray[$m] = $m + 86400;}

foreach ($sep_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $sep_bookings = $this->db->get($value)->row()->total;

        if ($s == 'paid')
        {array_push($sep_arr,array('paid'=>$sep_bookings));}
        if ($s == 'unpaid') 
        {array_push($sep_arr,array('unpaid'=>$sep_bookings));}
        if ($s == 'cancelled') 
        {array_push($sep_arr,array('cancelled'=>$sep_bookings));}
        if ($s == 'confirmed') 
        {array_push($sep_arr,array('confirmed'=>$sep_bookings));}
        if ($s == 'pending') 
        {array_push($sep_arr,array('pending'=>$sep_bookings));}
        if ($s == 'refunded') 
        {array_push($sep_arr,array('refunded'=>$sep_bookings));}
        if ($s == 'bookings') 
        {array_push($sep_arr,array('bookings'=>$sep_bookings));}

}}}

$sep_paid = 0;
$sep_unpaid = 0;
$sep_cancelled = 0;
$sep_confirmed = 0;
$sep_pending = 0;
$sep_refunded = 0;
$sep_bookings = 0;
for ($i=0; $i < count($sep_arr); $i++) {
$sep_paid = $sep_paid + $sep_arr[$i]['paid'];
$sep_unpaid = $sep_unpaid + $sep_arr[$i]['unpaid'];
$sep_cancelled = $sep_cancelled + $sep_arr[$i]['cancelled'];
$sep_confirmed = $sep_confirmed + $sep_arr[$i]['confirmed'];
$sep_pending = $sep_pending + $sep_arr[$i]['pending'];
$sep_refunded = $sep_refunded + $sep_arr[$i]['refunded'];
$sep_bookings = $sep_bookings + $sep_arr[$i]['bookings'];
}
//end sep bookings

//oct bookings
$oct_from = strtotime(date('Y-m-d', strtotime('first day of oct this year')));
$oct_last  = strtotime(date('Y-m-d', strtotime('last day of oct this year')));
$oct_arr = [];
for ($m = $oct_from; $m <= $oct_last; $m += 86400) {
$oct_datearray[$m] = $m + 86400;}

foreach ($oct_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $oct_bookings = $this->db->get($value)->row()->total;

        if ($s == 'paid')
        {array_push($oct_arr,array('paid'=>$oct_bookings));}
        if ($s == 'unpaid') 
        {array_push($oct_arr,array('unpaid'=>$oct_bookings));}
        if ($s == 'cancelled') 
        {array_push($oct_arr,array('cancelled'=>$oct_bookings));}
        if ($s == 'confirmed') 
        {array_push($oct_arr,array('confirmed'=>$oct_bookings));}
        if ($s == 'pending') 
        {array_push($oct_arr,array('pending'=>$oct_bookings));}
        if ($s == 'refunded') 
        {array_push($oct_arr,array('refunded'=>$oct_bookings));}
        if ($s == 'bookings') 
        {array_push($oct_arr,array('bookings'=>$oct_bookings));}

}}}

$oct_paid = 0;
$oct_unpaid = 0;
$oct_cancelled = 0;
$oct_confirmed = 0;
$oct_pending = 0;
$oct_refunded = 0;
$oct_bookings = 0;
for ($i=0; $i < count($oct_arr); $i++) {
$oct_paid = $oct_paid + $oct_arr[$i]['paid'];
$oct_unpaid = $oct_unpaid + $oct_arr[$i]['unpaid'];
$oct_cancelled = $oct_cancelled + $oct_arr[$i]['cancelled'];
$oct_confirmed = $oct_confirmed + $oct_arr[$i]['confirmed'];
$oct_pending = $oct_pending + $oct_arr[$i]['pending'];
$oct_refunded = $oct_refunded + $oct_arr[$i]['refunded'];
$oct_bookings = $oct_bookings + $oct_arr[$i]['bookings'];
}
//end oct bookings


//nov bookings
$nov_from = strtotime(date('Y-m-d', strtotime('first day of nov this year')));
$nov_last  = strtotime(date('Y-m-d', strtotime('last day of nov this year')));
$nov_arr = [];
for ($m = $nov_from; $m <= $nov_last; $m += 86400) {
$nov_datearray[$m] = $m + 86400;}

foreach ($nov_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $nov_bookings = $this->db->get($value)->row()->total;

        if ($s == 'paid')
        {array_push($nov_arr,array('paid'=>$nov_bookings));}
        if ($s == 'unpaid') 
        {array_push($nov_arr,array('unpaid'=>$nov_bookings));}
        if ($s == 'cancelled') 
        {array_push($nov_arr,array('cancelled'=>$nov_bookings));}
        if ($s == 'confirmed') 
        {array_push($nov_arr,array('confirmed'=>$nov_bookings));}
        if ($s == 'pending') 
        {array_push($nov_arr,array('pending'=>$nov_bookings));}
        if ($s == 'refunded') 
        {array_push($nov_arr,array('refunded'=>$nov_bookings));}
        if ($s == 'bookings') 
        {array_push($nov_arr,array('bookings'=>$nov_bookings));}

}}}

$nov_paid = 0;
$nov_unpaid = 0;
$nov_cancelled = 0;
$nov_confirmed = 0;
$nov_pending = 0;
$nov_refunded = 0;
$nov_bookings = 0;
for ($i=0; $i < count($nov_arr); $i++) {
$nov_paid = $nov_paid + $nov_arr[$i]['paid'];
$nov_unpaid = $nov_unpaid + $nov_arr[$i]['unpaid'];
$nov_cancelled = $nov_cancelled + $nov_arr[$i]['cancelled'];
$nov_confirmed = $nov_confirmed + $nov_arr[$i]['confirmed'];
$nov_pending = $nov_pending + $nov_arr[$i]['pending'];
$nov_refunded = $nov_refunded + $nov_arr[$i]['refunded'];
$nov_bookings = $nov_bookings + $nov_arr[$i]['bookings'];
}
//end nov bookings

//dec bookings
$dec_from = strtotime(date('Y-m-d', strtotime('first day of dec this year')));
$dec_last  = strtotime(date('Y-m-d', strtotime('last day of dec this year')));
$dec_arr = [];
for ($m = $dec_from; $m <= $dec_last; $m += 86400) {
$dec_datearray[$m] = $m + 86400;}

foreach ($dec_datearray as $start => $end) {
foreach ($modules as $key => $value) {
    foreach ($status_arr as $k => $s) {
        $this->db->select("COUNT(*) AS total");
        $this->db->where("".$value.".booking_date >=", $start);
        $this->db->where("".$value.".booking_date <=", $end);
        if($s != 'bookings' && $s == 'paid' || $s == 'unpaid' || $s == 'refunded')
        {$this->db->where("".$value.".booking_payment_status", $s);}
        if($s == 'cancelled' || $s == 'pending' || $s == 'confirmed')
        {$this->db->where("".$value.".booking_status", $s);}
        $dec_bookings = $this->db->get($value)->row()->total;


        if ($s == 'paid')
        {array_push($dec_arr,array('paid'=>$dec_bookings));}
        if ($s == 'unpaid') 
        {array_push($dec_arr,array('unpaid'=>$dec_bookings));}
        if ($s == 'cancelled') 
        {array_push($dec_arr,array('cancelled'=>$dec_bookings));}
        if ($s == 'confirmed') 
        {array_push($dec_arr,array('confirmed'=>$dec_bookings));}
        if ($s == 'pending') 
        {array_push($dec_arr,array('pending'=>$dec_bookings));}
        if ($s == 'refunded') 
        {array_push($dec_arr,array('refunded'=>$dec_bookings));}
        if ($s == 'bookings') 
        {array_push($dec_arr,array('bookings'=>$dec_bookings));}

}}}

$dec_paid = 0;
$dec_unpaid = 0;
$dec_cancelled = 0;
$dec_confirmed = 0;
$dec_pending = 0;
$dec_refunded = 0;
$dec_bookings = 0;
for ($i=0; $i < count($dec_arr); $i++) {
$dec_paid = $dec_paid + $dec_arr[$i]['paid'];
$dec_unpaid = $dec_unpaid + $dec_arr[$i]['unpaid'];
$dec_cancelled = $dec_cancelled + $dec_arr[$i]['cancelled'];
$dec_confirmed = $dec_confirmed + $dec_arr[$i]['confirmed'];
$dec_pending = $dec_pending + $dec_arr[$i]['pending'];
$dec_refunded = $dec_refunded + $dec_arr[$i]['refunded'];
$dec_bookings = $dec_bookings + $dec_arr[$i]['bookings'];
}
//end dec bookings

$month_arr = array(
'jan'=>array('bookings'=>$jan_bookings,'paid'=>$jan_paid,'confirmed'=>$jan_confirmed,'pending'=>$jan_pending,'unpaid'=>$jan_unpaid,'refunded'=>$jan_refunded,'cancelled'=>$jan_cancelled),
'feb'=>array('bookings'=>$feb_bookings,'paid'=>$feb_paid,'confirmed'=>$feb_confirmed,'pending'=>$feb_pending,'unpaid'=>$feb_unpaid,'refunded'=>$feb_refunded,'cancelled'=>$feb_cancelled),
'mar'=>array('bookings'=>$mar_bookings,'paid'=>$mar_paid,'confirmed'=>$mar_confirmed,'pending'=>$mar_pending,'unpaid'=>$mar_unpaid,'refunded'=>$mar_refunded,'cancelled'=>$mar_cancelled),
'apr'=>array('bookings'=>$apr_bookings,'paid'=>$apr_paid,'confirmed'=>$apr_confirmed,'pending'=>$apr_pending,'unpaid'=>$apr_unpaid,'refunded'=>$apr_refunded,'cancelled'=>$apr_cancelled),
'may'=>array('bookings'=>$may_bookings,'paid'=>$may_paid,'confirmed'=>$may_confirmed,'pending'=>$may_pending,'unpaid'=>$may_unpaid,'refunded'=>$may_refunded,'cancelled'=>$may_cancelled),
'jun'=>array('bookings'=>$jun_bookings,'paid'=>$jun_paid,'confirmed'=>$jun_confirmed,'pending'=>$jun_pending,'unpaid'=>$jun_unpaid,'refunded'=>$jun_refunded,'cancelled'=>$jun_cancelled),
'jul'=>array('bookings'=>$jul_bookings,'paid'=>$jul_paid,'confirmed'=>$jul_confirmed,'pending'=>$jul_pending,'unpaid'=>$jul_unpaid,'refunded'=>$jul_refunded,'cancelled'=>$jul_cancelled),
'aug'=>array('bookings'=>$aug_bookings,'paid'=>$aug_paid,'confirmed'=>$aug_confirmed,'pending'=>$aug_pending,'unpaid'=>$aug_unpaid,'refunded'=>$aug_refunded,'cancelled'=>$aug_cancelled),
'sep'=>array('bookings'=>$sep_bookings,'paid'=>$sep_paid,'confirmed'=>$sep_confirmed,'pending'=>$sep_pending,'unpaid'=>$sep_unpaid,'refunded'=>$sep_refunded,'cancelled'=>$sep_cancelled),
'oct'=>array('bookings'=>$oct_bookings,'paid'=>$oct_paid,'confirmed'=>$oct_confirmed,'pending'=>$oct_pending,'unpaid'=>$oct_unpaid,'refunded'=>$oct_refunded,'cancelled'=>$oct_cancelled),
'nov'=>array('bookings'=>$nov_bookings,'paid'=>$nov_paid,'confirmed'=>$nov_confirmed,'pending'=>$nov_pending,'unpaid'=>$nov_unpaid,'refunded'=>$nov_refunded,'cancelled'=>$nov_cancelled),
'dec'=>array('bookings'=>$dec_bookings,'paid'=>$dec_paid,'confirmed'=>$dec_confirmed,'pending'=>$dec_pending,'unpaid'=>$dec_unpaid,'refunded'=>$dec_refunded,'cancelled'=>$dec_cancelled)
);
array_push($annual_report,array('all_month'=>$month_arr));
// dd($annual_report);
return $annual_report;
}
/*end booking count reports*/


    function totalBookings()
    {
        return $this->db->get("pt_bookings")->num_rows();
    }

    function graphReport($type = null)
    {

        $datearray = array();

        $resultarray = array();

        $year = date("Y");

        $from = strtotime(date('Y-m-d', strtotime('-30 days')));

        $to = time();

        for ($m = $from; $m <= time() - 86400; $m += 86400) {

            $datearray[$m] = $m + 86400;

        }

        foreach ($datearray as $start => $end) {


            $this->db->select_sum('booking_amount_paid');

            if (!empty($type)) {

                $this->db->where('booking_type', $type);

            }

            $this->db->where('booking_date >=', $start);

            $this->db->where('booking_date <=', $end);

            $this->db->where('booking_status', 'paid');

            $res = $this->db->get('pt_bookings')->result();

            $resultarray['amounts'][] = round($res[0]->booking_amount_paid, 2);
            $resultarray['days'][] = date("d", $start);

        }


        return $resultarray;

    }

// Graph Report Expedia
    function graphReportExpedia()
    {

        $datearray = array();

        $resultarray = array();

        $year = date("Y");

        $from = strtotime(date('Y-m-d', strtotime('-30 days')));

        $to = time();

        for ($m = $from; $m <= time() - 86400; $m += 86400) {

            $datearray[$m] = $m + 86400;

        }

        foreach ($datearray as $start => $end) {


            $this->db->select_sum('book_total');


            $this->db->where('book_date >=', $start);

            $this->db->where('book_date <=', $end);


            $res = $this->db->get('pt_ean_booking')->result();

            $resultarray['amounts'][] = round($res[0]->book_total, 2);
            $resultarray['days'][] = date("d", $start);

        }


        return $resultarray;

    }

    /**
     * Travelport Flight Report For the Last 30 Days
     *
     * @return array
     */
    public function graphReportTravelport()
    {
        $dataAdapter = $this->db->query("
            SELECT SUM(total_price) AS total_price, DATE(createdAt) AS createdAt 
            FROM tport_reservation 
            WHERE DATE(createdAt) >= CURDATE() - INTERVAL 31 DAY AND DATE(createdAt) <= CURDATE()
            GROUP BY DATE(createdAt)
        ");
        $creates_at = array_column($dataAdapter->result_array(), 'createdAt');
        $total_prices = array_column($dataAdapter->result_array(), 'total_price');
        array_walk($total_prices, function (&$price) {
            $price = (double)$price;
        });

        $days_array = array();
        for ($i = 0; $i <= 31; $i++) {
            $days_array[] = date("Y-m-d", strtotime('-' . $i . ' days'));
        }
        sort($days_array);
        $dataset = array_combine($creates_at, $total_prices);
        $ret_array = array();
        foreach ($days_array as $day) {
            if (!isset($dataset[$day])) {
                $ret_array[$day] = 0;
            } else {
                $ret_array[$day] = $dataset[$day];
            }
        }

        return array_values($ret_array);
    }

    /**
     * Travelport Today Sale
     *
     * @return array
     */
    public function travelport_today_sale()
    {
        $today = date('Y-m-d');
        $this->db->select('COUNT(id) AS total_booking, SUM(total_price) AS total_price');
        $this->db->where('DATE(createdAt)', $today);
        $dataAdapter = $this->db->get('tport_reservation');

        return $dataAdapter->row();
    }

    /**
     * Travelport Last 30 Days Sale
     *
     * @return array
     */
    public function travelport_last_thirty_days_sale()
    {
        $last_thirty_days = date('Y-m-d', strtotime('-30 days'));
        $this->db->select('COUNT(id) AS total_booking, SUM(total_price) AS total_price');
        $this->db->where('DATE(createdAt) >=', $last_thirty_days);
        $dataAdapter = $this->db->get('tport_reservation');

        return $dataAdapter->row();
    }

    /**
     * Travelport Last 90 Days Sale
     *
     * @return array
     */
    public function travelport_last_ninghty_days_sale()
    {
        $last_ninghty_days = date('Y-m-d', strtotime('-90 days'));
        $this->db->select('COUNT(id) AS total_booking, SUM(total_price) AS total_price');
        $this->db->where('DATE(createdAt) >=', $last_ninghty_days);
        $dataAdapter = $this->db->get('tport_reservation');

        return $dataAdapter->row();
    }

    /**
     * Travelhope Flight Report For the Last 30 Days
     *
     * @return array
     */
    public function graphReportTravelhopeFlight()
    {
        $datearray = array();
        $resultarray = array();
        $from = strtotime(date('Y-m-d', strtotime('-30 days')));

        for ($m = $from; $m <= time() - 86400; $m += 86400)
        {
            $datearray[$m] = $m + 86400;
        }

        foreach ($datearray as $start => $end)
        {
            $this->db->select_sum('total');
            $this->db->where('DATE(created_at) >=', date('Y-m-d', $start));
            $this->db->where('DATE(created_at) <', date('Y-m-d', $end));
            $res = $this->db->get('travelhope_flights_bookings')->result();

            $resultarray['amounts'][] = round($res[0]->total, 2);
            $resultarray['days'][] = date("d", $start);
        }

        return $resultarray;
    }

    /**
     * Travelhope Hotel Report For the Last 30 Days
     *
     * @return array
     */
    public function graphReportTravelhopeHotel()
    {
        $datearray = array();
        $resultarray = array();
        $from = strtotime(date('Y-m-d', strtotime('-30 days')));

        for ($m = $from; $m <= time() - 86400; $m += 86400)
        {
            $datearray[$m] = $m + 86400;
        }

        foreach ($datearray as $start => $end)
        {
            $this->db->select_sum('price');
            $this->db->where('DATE(created_at) >=', date('Y-m-d', $start));
            $this->db->where('DATE(created_at) <', date('Y-m-d', $end));
            $res = $this->db->get('travelhope_hotels_bookings')->result();

            $resultarray['amounts'][] = round($res[0]->total, 2);
            $resultarray['days'][] = date("d", $start);
        }

        return $resultarray;
    }

//different durations bookings booking report Expedia
    function diffLastDurationExpedia($duration)
    {

        $info = new stdClass;
        $info->paidAmount = 0;
        $info->paidCount = 0;

            if ($duration > 0) {
                $first = strtotime(date('Y-m-d', strtotime('-' . $duration . ' days')));
            } else {
                $first = strtotime(date('Y-m-d'));
            }


            $last = time();


            $this->db->where('book_date >=', $first);

            $this->db->where('book_date <=', $last);


            $result = $this->db->get('pt_ean_booking')->result();

            if (!empty($result)) {

                foreach ($result as $res) {

                    $info->paidCount += 1;
                    $info->paidAmount += $res->book_total;


                }

            }

        $info->totalCount = $info->paidCount;
        $info->totalAmount = $info->paidAmount;


        return $info;


    }

//end different duration bookings expedia


}