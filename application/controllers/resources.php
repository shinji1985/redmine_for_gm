<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resources extends MY_Controller {

    function __construct() {
        parent::__construct();

        //authentication
        $this->load->library('login');
        $this->login->login_status_check('');

        //load models
        $this->load->model('projects_model', 'projects');
        $this->load->model('issues_model', 'issues');
        $this->load->model('users_model', 'users');
    }

    function _display($name, $view_text) {
        //project list for header
        $view_text['dropdown_projects'] = $this->projects->get_all();

        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('footer', $view_text);
    }

    function index($identifier = "") {

        //projects users issues 
        $where = array();


        $order_by = 'users.login ASC';
        $users = $this->users->get_all(array('login !=' => ''), $order_by);

        $i = 0;
        foreach ($users as $user_row):
            //remove status Resolved Closed Rejected
            $where = "issues.assigned_to_id ='{$user_row['id']}' AND issues.status_id !='3' AND issues.status_id !='5' AND issues.status_id != '6'";

            $issues_order_by = 'issues.project_id ASC';
            $view_text['users'][$i] = $user_row;
            $view_text['users'][$i]['issues'] = $this->issues->get_all_with_projects($where, $issues_order_by);
            $i++;
        endforeach;

        $view_text['title'] = 'RESOURCES';
        $this->_display('resources', $view_text);
    }

}

?>
