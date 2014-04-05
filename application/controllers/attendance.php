<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attendance extends MY_Controller {

    private $holidays;

    function __construct() {
        parent::__construct();

        //init
        $this->holidays = unserialize(ATTENDANCE_HOLIDAYS);

        //library
        $this->load->library('group');
        $this->load->library('login');

        //authentication
        $this->login->login_status_check('');

        //load models
        $this->load->model('projects_model', 'projects');
        $this->load->model('issues_model', 'issues');
        $this->load->model('users_model', 'users');
    }

    function _display($name, $view_text) {

        $view_text['title'] = 'Attendance';
        $view_text['page_description'] = 'This page is for Attendance Management.';

        //project list for header
        $view_text['dropdown_projects'] = $this->group->generate_group_project_list($this->session->userdata("group_id"));
        //users group dropdown
        $view_text['dropdown_groups'] = $this->group->generate_dropdown($this->session->userdata("group_id"));
        //users group get query
        $view_text['group_get_query'] = $this->group->generate_get_query();


        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('footer', $view_text);
    }

    function index($year = '', $month = '') {
        $view_text = array();

        //Date calculation
        $view_text['date'] = $this->_calc_date($year, $month);

        //Check whether there is the project for attendance management or not
        $where['identifier'] = ATTENDANCE_PRJ_IDENTIFIER;
        $view_text['project'] = $this->projects->get_row($where);

        //Configure Check
        if ($view_text['project'] && count($this->holidays) > 0 && ATTENDANCE_WEEKDAY_WORKTIME != '' && ATTENDANCE_PAID_HOLIDAY_TRACKER_ID != ''):
            $users = $this->group->getusers_in_group($this->session->userdata("group_id"));
            $i = 0;
            foreach ($users as $user_row):
                $view_text['users'][$i] = $user_row;

                $issues_order_by = 'issues.start_date ASC';

                for ($k = 1; $k <= $view_text['date']['max_days']; $k++):
                    $k_day = sprintf("%02d", $k);
                    $where = "issues.start_date = '{$view_text['date']['year_month']}-{$k_day}' AND issues.project_id = '{$view_text['project']['id']}' AND issues.assigned_to_id = '{$user_row['id']}' AND issues.status_id !='6'";

                    $issues_result = $this->issues->get_issues_for_attendance($where, $issues_order_by);

                    $view_text['users'][$i]['issues'][$k] = $issues_result;

                endfor;
                $i++;
            endforeach;

            //Get issues assigned to nobody
            $view_text['issues_noassigned'] = $this->_getissues_no_assigned($view_text['project']['id'], $view_text['date']['year_month']);

            //Get holiday applications 
            $view_text['holiday_applications'] = $this->_getpaid_holiday_application($view_text['project']['id']);


            //Generate attendance table
            $view_text = $this->_generate_table($view_text);

            $this->_display('attendance/index', $view_text);

        else:
            $this->_display('attendance/error', $view_text);
        endif;
    }

    //Calculate the date specified with get parameter.
    function _calc_date($year = '', $month = '') {
        $date['year'] = (int) $year;
        $date['month'] = (int) $month;

        $date['month_dropdown'] = array(
            '1' => 'Jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec'
        );

        if ($year == "" || $month == ""):

            $date['year'] = date("Y");
            $date['month'] = date("m");
            $date['month_en'] = date("M");
            $date['max_days'] = cal_days_in_month(CAL_GREGORIAN, $date['month'], $date['year']);
            $zero_month = sprintf("%02d", $date['month']);
            $date['year_month'] = "{$date['year']}-{$zero_month}";

        else:

            if (checkdate($month, 1, $date['year'])):
                $date['max_days'] = cal_days_in_month(CAL_GREGORIAN, $date['month'], $date['year']);
                $zero_month = sprintf("%02d", $date['month']);
                $date['year_month'] = "{$date['year']}-{$zero_month}";
                $date['month_en'] = date("M", strtotime($date['year_month'] . '-01'));
            else:
                $date['year'] = date("Y");
                $date['month'] = date("m");
                $date['month_en'] = date("M");
                $date['max_days'] = cal_days_in_month(CAL_GREGORIAN, $date['month'], $date['year']);
                $zero_month = sprintf("%02d", $date['month']);
                $date['year_month'] = "{$date['year']}-{$zero_month}";
            endif;

        endif;

        return $date;
    }

    function _generate_table($view_text = array()) {
        $this->load->library('table');
        //Init
        $days = array();
        $week = array();
        $user_attend = array();
        $max_weekday_woking = 0;

        for ($u_cnt = 0; $u_cnt < count($view_text['users']); $u_cnt++):
            $user_attend[$u_cnt] = array();
            $holiday_woking[$u_cnt] = 0;
            $over_woking[$u_cnt] = 0;
            $weekday_woking[$u_cnt] = 0;
            $sunday_woking[$u_cnt] = 0;
            $saturday_woking[$u_cnt] = 0;
            $paidholiday_woking[$u_cnt] = 0;
        endfor;
        if (isset($this->holidays[$this->session->userdata("group_id")])):
            $holidays_array = $this->holidays[$this->session->userdata("group_id")];
        else:
            $holidays_array = $this->holidays[0];
        endif;
        $tmpl = array(
            'table_open' => '<table class="table table-bordered">',
            'heading_row_start' => '<tr>',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '',
            'cell_end' => '',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '',
            'cell_alt_end' => '',
            'table_close' => '</table>'
        );

        $this->table->set_template($tmpl);



        for ($day = 1; $day <= $view_text['date']['max_days']; $day++):
            $time = mktime(0, 0, 0, $view_text['date']['month'], $day, $view_text['date']['year']);

            //Set weekday name
            $weekday = date("D", $time);

            //Check holiday
            $zero_day = sprintf("%02d", $day);
            $the_date = "{$view_text['date']['year_month']}-{$zero_day}";
            if (in_array($the_date, $holidays_array)):
                $weekday = 'Hol';
            endif;
            //Set color in accordance with the day type
            switch ($weekday):
                case 'Hol';
                    $set_color = 'danger';
                    break;
                case 'Sat';
                    $set_color = 'info';
                    break;
                case 'Sun';
                    $set_color = 'danger';
                    break;
                default :
                    $max_weekday_woking = $max_weekday_woking + ATTENDANCE_WEEKDAY_WORKTIME;
                    $set_color = '';
                    break;
            endswitch;


            $days[] = "<th class='cell_center {$set_color}'>{$day}</th>";
            $week[] = "<td class='cell_center {$set_color}'><small>{$weekday}</small></td>";

            for ($u_cnt = 0; $u_cnt < count($view_text['users']); $u_cnt++):

                $set_color_u = $set_color;
                $work_time = '';
                $set_url = '';
                $description = '';
                $mult_issues = 0;
                $admin_flg = 1;
                $paidholiday_flg = 0;

                //Add up the worktime on the day
                foreach ($view_text['users'][$u_cnt]['issues'][$day] as $row):


                    $mult_issues++;

                    if (!empty($row['estimated_hours'])):
                        $work_time = $work_time + (float) $row['estimated_hours'];
                    else:
                        $work_time = $work_time + 0;
                    endif;
                    $description = $description . $row['description'];

                    //If the issue status is not closed, set admin_flg to false.
                    if ($row['status_id'] != 5):
                        $admin_flg = 0;
                    endif;

                    //If the issue tracker_id is Paid holiday, set paidholiday_flg
                    if ($row['tracker_id'] == ATTENDANCE_PAID_HOLIDAY_TRACKER_ID):
                        $paidholiday_flg = 1;
                    endif;

                    $set_url = REDMINE_URL . 'issues/' . $row['id'];
                endforeach;

                //Calc working time 
                switch ($weekday):
                    case 'Hol';
                        $holiday_woking[$u_cnt] = $holiday_woking[$u_cnt] + (float) $work_time;
                        break;
                    case 'Sat';
                        $saturday_woking[$u_cnt] = $saturday_woking[$u_cnt] + (float) $work_time;
                        break;
                    case 'Sun';
                        $sunday_woking[$u_cnt] = $sunday_woking[$u_cnt] + (float) $work_time;
                        break;
                    default :
                        $tmp_work = (float) $work_time;
                        if ($tmp_work <= ATTENDANCE_WEEKDAY_WORKTIME):
                            $weekday_woking[$u_cnt] = $weekday_woking[$u_cnt] + $tmp_work;
                            $over_woking[$u_cnt] = $over_woking[$u_cnt] + 0;
                        else:
                            $weekday_woking[$u_cnt] = $weekday_woking[$u_cnt] + ATTENDANCE_WEEKDAY_WORKTIME;
                            $over_woking[$u_cnt] = $over_woking[$u_cnt] + ($tmp_work - ATTENDANCE_WEEKDAY_WORKTIME);
                        endif;

                        if ($paidholiday_flg == 1):
                            $paidholiday_woking[$u_cnt] = $paidholiday_woking[$u_cnt] + $work_time / ATTENDANCE_WEEKDAY_WORKTIME;
                        endif;

                        break;
                endswitch;

                if (is_float($work_time)):
                    //Set popover
                    if ($description != ""):
                        $data_content = nl2br($description);
                    else:
                        $data_content = 'none';
                    endif;
                    //If the status is Closed, set admin flg.
                    if ($admin_flg == 1):
                        $set_color_u = "success";
                    endif;

                    if ($paidholiday_flg == 1 && $admin_flg == 1):
                        $set_color_u = "warning";
                    endif;

                    //If the worktime consists of 2 issues, set the text as follows.
                    if ($mult_issues > 1):
                        $data_content = $data_content . '<br/>This worktime consists of 2 issues. Check Redmine.';
                    endif;


                    $popover_data = "rel='popover' data-content='{$data_content}'";

                    //Set td
                    $user_attend[$u_cnt][] = "<td class='cell_center {$set_color_u}'><small><a href='{$set_url}' target='_blank' {$popover_data}>{$work_time}</a></small></td>";
                else :
                    //Set height for no working day
                    $user_attend[$u_cnt][] = "<td class='cell_center {$set_color_u}'><small><span style='display:inline-block;'></span></small></td>";
                endif;
            endfor;

        endfor;
        $days[] = "<th class='cell_center'>Weekday</th>";
        $days[] = "<th class='cell_center'>Overtime</th>";
        $days[] = "<th class='cell_center'>Saturday</th>";
        $days[] = "<th class='cell_center'>Sunday</th>";
        $days[] = "<th class='cell_center'>Holiday</th>";
        $days[] = "<th class='cell_center'>PaidHoliday</th>";
        $week[] = "<td class='cell_center'><small><span style='display:inline-block;'></span></small></td>";
        $week[] = "<td class='cell_center'><small><span style='display:inline-block;'></span></small></td>";
        $week[] = "<td class='cell_center'><small><span style='display:inline-block;'></span></small></td>";
        $week[] = "<td class='cell_center'><small><span style='display:inline-block;'></span></small></td>";
        $week[] = "<td class='cell_center'><small><span style='display:inline-block;'></span></small></td>";
        $week[] = "<td class='cell_center'><small><span style='display:inline-block;'></span></small></td>";

        $this->table->add_row($days);
        $this->table->add_row($week);

        for ($u_cnt = 0; $u_cnt < count($view_text['users']); $u_cnt++):
            $user_attend[$u_cnt][] = "<td class='cell_center'><small>{$weekday_woking[$u_cnt]}/{$max_weekday_woking}</small></td>";
            $user_attend[$u_cnt][] = "<td class='cell_center'><small>{$over_woking[$u_cnt]}</small></td>";
            $user_attend[$u_cnt][] = "<td class='cell_center'><small>{$saturday_woking[$u_cnt]}</small></td>";
            $user_attend[$u_cnt][] = "<td class='cell_center'><small>{$sunday_woking[$u_cnt]}</small></td>";
            $user_attend[$u_cnt][] = "<td class='cell_center'><small>{$holiday_woking[$u_cnt]}</small></td>";
            $user_attend[$u_cnt][] = "<td class='cell_center'><small>{$paidholiday_woking[$u_cnt]} day</small></td>";
            $this->table->add_row($user_attend[$u_cnt]);
        endfor;
        $this->table->add_row($week);
        $this->table->add_row($days);


        $view_text['date_table'] = $this->table->generate();

        return $view_text;
    }

    //Get issues assigned nobody
    function _getissues_no_assigned($project_id = "", $date = "") {
        //remove issues except this month
        $where = "issues.start_date LIKE '{$date}%' AND issues.project_id = '{$project_id}' AND issues.assigned_to_id IS NULL AND issues.status_id !='6'";
        $issues_order_by = 'issues.start_date ASC';

        return $this->issues->get_issues_for_attendance($where, $issues_order_by);
    }

    //Get Paid Holiday application
    function _getpaid_holiday_application($project_id = "") {
        //remove issues except this month
        $where = "issues.project_id = '{$project_id}' AND issues.tracker_id = '" . ATTENDANCE_PAID_HOLIDAY_TRACKER_ID . "' AND issues.status_id ='1'";
        $issues_order_by = 'issues.start_date ASC';

        return $this->issues->get_issues_for_attendance($where, $issues_order_by);
    }

}

?>
