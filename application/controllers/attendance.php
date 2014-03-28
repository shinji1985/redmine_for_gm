<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attendance extends MY_Controller {

    function __construct() {
        parent::__construct();

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
        $view_text['dropdown_projects'] = $this->projects->get_all();
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

        if ($view_text['project']):
            $users = $this->group->getusers_in_group($this->session->userdata("group_id"));
            $i = 0;
            foreach ($users as $user_row):
                $view_text['users'][$i] = $user_row;

                $issues_order_by = 'issues.start_date ASC';

                for ($k = 1; $k <= $view_text['date']['max_days']; $k++):
                    $k_day = sprintf("%02d", $k);
                    $where = "issues.start_date = '{$view_text['date']['year_month']}-{$k_day}' AND issues.project_id = '{$view_text['project']['id']}' AND issues.assigned_to_id = '{$user_row['id']}'";

                    $issues_result = $this->issues->get_issues_for_attendance($where, $issues_order_by);
                    $view_text['users'][$i]['issues'][$k] = $issues_result;

                endfor;
                $i++;
            endforeach;

            //Get issues assigned to nobody
            $view_text['issues_noassigned'] = $this->_getissues_no_assigned($view_text['project']['id'], $view_text['date']['year_month']);

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

        $days = array();
        $week = array();
        $user_attend = array();
        for ($u_cnt = 0; $u_cnt < count($view_text['users']); $u_cnt++):
            $user_attend[$u_cnt]=array();
        endfor;

        for ($day = 1; $day <= $view_text['date']['max_days']; $day++):
            $time = mktime(0, 0, 0, $view_text['date']['month'], $day, $view_text['date']['year']);

            $weekday = date("D", $time);

            foreach ($view_text['users'] as $row):
                echo $day . '<br/>';
                
                foreach ($row['issues'][$day] as $hour_row):
                    echo $hour_row['estimated_hours'];
                endforeach;
                echo '<br/>';
            endforeach;

            switch ($weekday):
                case 'Sat';
                    $days[] = '<th class="cell_center info">' . $day . '</th>';
                    $week[] = '<td class="cell_center info"><small>' . date("D", $time) . '</small></td>';
                    break;
                case 'Sun';
                    $days[] = '<th class="cell_center danger">' . $day . '</th>';
                    $week[] = '<td class="cell_center danger"><small>' . date("D", $time) . '</small></td>';
                    break;
                default :
                    $days[] = '<th class="cell_center">' . $day . '</th>';
                    $week[] = '<td class="cell_center"><small>' . date("D", $time) . '</small></td>';
                    break;
            endswitch;
        endfor;

        $this->table->add_row($days);
        $this->table->add_row($week);

//        $this->table->add_row('Fred', 'Blue', 'Small');
//        $this->table->add_row('Mary', 'Red', 'Large');
//        $this->table->add_row('John', 'Green', 'Medium');

        $view_text['date_table'] = $this->table->generate();

        return $view_text;
    }

    //Get issues assigned nobody
    function _getissues_no_assigned($project_id = "", $date = "") {
        //remove issues except this month
        $where = "issues.start_date LIKE '{$date}%' AND issues.project_id = '{$project_id}' AND issues.assigned_to_id IS NULL";
        $issues_order_by = 'issues.start_date ASC';

        return $this->issues->get_issues_for_attendance($where, $issues_order_by);
    }

    //Get issues not estimated
    function _getissues_not_estimated($project_id = "", $date = "") {
        //remove issues except this month
        $where = "issues.start_date LIKE '{$date}%' AND issues.project_id = '{$project_id}'";
        $issues_order_by = 'issues.start_date ASC';

        return $this->issues->get_issues_for_attendance($where, $issues_order_by);
    }

}

?>
