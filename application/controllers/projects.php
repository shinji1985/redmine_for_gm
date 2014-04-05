<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *
 *
 */

class Projects extends MY_Controller {

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
    }

    function _display($name, $view_text) {
        //project list for header
        $view_text['dropdown_projects'] = $this->group->generate_group_project_list($this->session->userdata("group_id"));
        //users group get query
        $view_text['group_get_query']=$this->group->generate_get_query();


        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('footer', $view_text);
    }

    function index($identifier = "") {
        if ($identifier) {
            //Show project detail
            $where['identifier'] = $identifier;
            $view_text['project'] = $this->projects->get_row($where);

            $issues_where['project_id'] = $view_text['project']['id'];
            $view_text['issues'] = $this->issues->get_all($issues_where);

            if ($view_text['project']) {
                $view_text['title'] = $view_text['project']['name'];
                $this->_display('projects_detail', $view_text);
            } else {
                show_404('page');
            }
        } else {
            //Show projects
            $view_text['title'] = 'Projects';
            $this->_display('projects', $view_text);
        }
    }

    function phpinfo() {
        phpinfo();
    }

}

?>
