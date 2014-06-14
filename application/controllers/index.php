<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *
 *
 */

class Index extends MY_Controller {

    function __construct() {
        parent::__construct();

        //library
        $this->load->library('group');
        $this->load->library('login');

        //authentication
        $this->login->login_status_check('index');


        //load models
        $this->load->model('projects_model', 'projects');
        $this->load->model('users_model', 'users');
    }

    function login() {
        $this->login->login();
    }

    function logout() {
        $this->login->logout();
    }

    function _display($name, $view_text) {
        //project list for header
        $view_text['dropdown_projects'] = $this->group->generate_projects_in_thegroup($this->session->userdata("group_id"));
        //users group dropdown
        $view_text['dropdown_groups'] = $this->group->generate_dropdown($this->session->userdata("group_id"));
        //users group get query
        $view_text['group_get_query'] = $this->group->generate_get_query();


        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('footer', $view_text);
    }

    function index() {
        $view_text['title'] = 'Dash Board';
        $view_text['projects'] = $this->projects->get_all();
        $view_text['users'] = $this->users->get_all();
        $this->_display('index', $view_text);
    }

//    function phpinfo() {
//        phpinfo();
//    }
}

?>
