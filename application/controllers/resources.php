<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resources extends MY_Controller {

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
        $this->load->model('groups_users_model', 'groups_users');
    }

    function _display($name, $view_text) {
        //project list for header
        $view_text['dropdown_projects'] = $this->projects->get_all();
        //users group dropdown
        $view_text['dropdown_groups'] = $this->group->generate_dropdown($this->session->userdata("group_id"));
        //users group get query
        $view_text['group_get_query'] = $this->group->generate_get_query();

        $view_text['page_description'] = 'Click on the bar, if you want to see in Redmine.';
        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('footer', $view_text);
    }
    

    //Resources every projects
    function index() {

        $users = $this->_getusers_in_group();

        $i = 0;
        $monthago = date('Y-m-d', strtotime('-1 month'));
        foreach ($users as $user_row):
            //remove status "Resolved Closed Rejected"
            $where = "issues.start_date > '{$monthago}' AND issues.assigned_to_id ='{$user_row['id']}' AND issues.status_id !='3' AND issues.status_id !='5' AND issues.status_id != '6'";

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
                $view_text['users'][$i]['issues'][0]['project_name'] = OPEN;
                $view_text['users'][$i]['issues'][0]['customClass'] = OPEN_CLASS;
                $view_text['users'][$i]['issues'][0]['identifier'] = '';
                $view_text['users'][$i]['issues'][0]['start_date'] = date('Y-m-d', time());
                $view_text['users'][$i]['issues'][0]['due_date'] = date('Y-m-d', strtotime('+1 hour'));

            endif;
            $i++;
        endforeach;

        //min and max date every projects



        $view_text['title'] = 'Resources';
        $this->_display('resources_p', $view_text);
    }

    //resources every issues
    function issues() {

        $users = $this->_getusers_in_group();

        $i = 0;
        $monthago = date('Y-m-d', strtotime('-1 month'));
        foreach ($users as $user_row):
            //remove status "Resolved Closed Rejected"
            $where = "issues.start_date > '{$monthago}' AND issues.assigned_to_id ='{$user_row['id']}' AND issues.status_id !='3' AND issues.status_id !='5' AND issues.status_id != '6'";

            $issues_order_by = 'issues.project_id ASC';
            $view_text['users'][$i] = $user_row;
            $issues_result = $this->issues->get_all_with_projects($where, $issues_order_by);

            if (count($issues_result) > 0):
                $project_identifier = '';
                $k = 0;
                foreach ($issues_result as $issues_row):
                    if ($issues_row['due_date'] == NULL):
                        $issues_row['due_date'] = $issues_row['start_date'];
                    endif;
                    $view_text['users'][$i]['issues'][$k]['subject'] = $issues_row['subject'];
                    $view_text['users'][$i]['issues'][$k]['customClass'] = 'ganttGreen';
                    $view_text['users'][$i]['issues'][$k]['flg'] = 'issue';
                    $view_text['users'][$i]['issues'][$k]['identifier'] = $issues_row['identifier'];
                    $view_text['users'][$i]['issues'][$k]['id'] = $issues_row['id'];
                    $view_text['users'][$i]['issues'][$k]['project_name'] = $issues_row['project_name'];
                    $view_text['users'][$i]['issues'][$k]['estimated_hours'] = $issues_row['estimated_hours'];
                    $view_text['users'][$i]['issues'][$k]['issue_status'] = $issues_row['issue_status'];
                    $view_text['users'][$i]['issues'][$k]['done_ratio'] = $issues_row['done_ratio'];
                    $view_text['users'][$i]['issues'][$k]['estimated_hours'] = $issues_row['estimated_hours'];
                    $view_text['users'][$i]['issues'][$k]['start_date'] = $issues_row['start_date'];
                    $view_text['users'][$i]['issues'][$k]['due_date'] = $issues_row['due_date'];
                    $k++;
                endforeach;
            else:
                $view_text['users'][$i]['issues'][0]['subject'] = OPEN;
                $view_text['users'][$i]['issues'][0]['customClass'] = OPEN_CLASS;
                $view_text['users'][$i]['issues'][0]['identifier'] = '';
                $view_text['users'][$i]['issues'][0]['flg'] = 'open';
                $view_text['users'][$i]['issues'][0]['id'] = '';
                $view_text['users'][$i]['issues'][0]['project_name'] = '';
                $view_text['users'][$i]['issues'][0]['estimated_hours'] = '';
                $view_text['users'][$i]['issues'][0]['issue_status'] = '';
                $view_text['users'][$i]['issues'][0]['done_ratio'] = '';
                $view_text['users'][$i]['issues'][0]['estimated_hours'] = '';
                $view_text['users'][$i]['issues'][0]['start_date'] = date('Y-m-d', time());
                $view_text['users'][$i]['issues'][0]['due_date'] = date('Y-m-d', strtotime('+1 hour'));

            endif;
            $i++;
        endforeach;

        $view_text['title'] = 'Resources';
        $this->_display('resources_i', $view_text);
    }
    
    
    //Get users in group specified in session.
    function _getusers_in_group() {
        
        $users_in_group = $this->groups_users->get_all(array('group_id' => $this->session->userdata("group_id")));
        $user_where = "login != '' ";

        if ($users_in_group):
            $i = 0;
            foreach ($users_in_group as $row):
                if ($i == 0):
                    $user_where = $user_where . "AND (id = '" . $row['user_id'] . "' ";
                else:
                    $user_where = $user_where . "OR id = '" . $row['user_id'] . "' ";
                endif;
                $i++;
            endforeach;
            $user_where = $user_where . ')';
        endif;

        $order_by = 'users.id ASC';
        return $this->users->get_all($user_where, $order_by);
    }
}

?>
