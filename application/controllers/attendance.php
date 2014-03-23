<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attendance extends MY_Controller {

    private $past_period;
    private $open;
    private $open_class;

    function __construct() {
        parent::__construct();

        //init
        $this->past_period = date('Y-m-d', strtotime('-1 month'));
        $this->open = ' ';
        $this->open_class = 'ganttOpen';

        //library
        $this->load->library('group');
        $this->load->library('login');

        //authentication
        $this->login->login_status_check('');

        //load models
        $this->load->model('projects_model', 'projects');
        $this->load->model('issues_model', 'issues');
        $this->load->model('users_model', 'users');
        $this->load->model('groups_users_model', 'groups_users');
    }

    function _display($name, $view_text) {

        $view_text['title'] = 'Resources';
        $view_text['page_description'] = 'Click on the bar, if you want to see in Redmine.';

        //project list for header
        $view_text['dropdown_projects'] = $this->projects->get_all();
        //users group dropdown
        $view_text['dropdown_groups'] = $this->group->generate_dropdown($this->session->userdata("group_id"));
        //users group get query
        $view_text['group_get_query'] = $this->group->generate_get_query();


        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('resources/issues_nobody', $view_text);
        $this->load->view('footer', $view_text);
    }

    //Resources every projects
    function index() {
        $view_text = array();

        $users = $this->_getusers_in_group();


        $i = 0;
        foreach ($users as $user_row):



            $where = $this->_remove_issues($user_row['id']);

            $issues_order_by = 'issues.project_id ASC';
            $view_text['users'][$i] = $user_row;
            $issues_result = $this->issues->get_all_with_projects($where, $issues_order_by);


            if (count($issues_result) > 0):
                $project_identifier = '';
                $k = 0;
                $z = 0;
                foreach ($issues_result as $issues_row):
                    if ($issues_row['due_date'] == NULL):
                        $issues_row['due_date'] = $issues_row['start_date'];
                    endif;

                    if ($k == 0 && $z == 0):
                        $project_identifier = $issues_row['identifier'];
                        $view_text['users'][$i]['issues'][$z]['project_name'] = $issues_row['project_name'];
                        $view_text['users'][$i]['issues'][$z]['customClass'] = 'ganttGreen';
                        $view_text['users'][$i]['issues'][$z]['identifier'] = $issues_row['identifier'];
                        $view_text['users'][$i]['issues'][$z]['start_date'] = $issues_row['start_date'];
                        $view_text['users'][$i]['issues'][$z]['due_date'] = $issues_row['due_date'];
                    else:
                        if ($project_identifier != $issues_row['identifier']):
                            $z++;
                            $project_identifier = $issues_row['identifier'];

                            $view_text['users'][$i]['issues'][$z]['project_name'] = $issues_row['project_name'];
                            $view_text['users'][$i]['issues'][$z]['customClass'] = 'ganttGreen';
                            $view_text['users'][$i]['issues'][$z]['identifier'] = $issues_row['identifier'];
                            $view_text['users'][$i]['issues'][$z]['start_date'] = $issues_row['start_date'];
                            $view_text['users'][$i]['issues'][$z]['due_date'] = $issues_row['due_date'];
                        else:
                            if ($view_text['users'][$i]['issues'][$z]['start_date'] > $issues_row['start_date']):
                                $view_text['users'][$i]['issues'][$z]['start_date'] = $issues_row['start_date'];
                            endif;
                            if ($view_text['users'][$i]['issues'][$z]['due_date'] < $issues_row['due_date']):
                                $view_text['users'][$i]['issues'][$z]['due_date'] = $issues_row['due_date'];
                            endif;
                        endif;
                    endif;
                    $k++;

                endforeach;
            else:
                $view_text['users'][$i]['issues'][0]['project_name'] = $this->open;
                $view_text['users'][$i]['issues'][0]['customClass'] = $this->open_class;
                $view_text['users'][$i]['issues'][0]['identifier'] = '';
                $view_text['users'][$i]['issues'][0]['start_date'] = date('Y-m-d', time());
                $view_text['users'][$i]['issues'][0]['due_date'] = date('Y-m-d', strtotime('+1 hour'));

            endif;
            $i++;
        endforeach;

        $view_text['issues_noassigned'] = $this->_getissues_no_assigned();

        $this->_display('resources/resources_p', $view_text);
    }


}

?>
