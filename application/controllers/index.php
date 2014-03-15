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

        //authentication
        $this->load->library('login');
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
        $view_text['dropdown_projects'] = $this->projects->get_all();

        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('footer', $view_text);
    }

    function index() {
        $view_text['title'] = 'TOP';
        $view_text['projects'] = $this->projects->get_all();
        $view_text['users'] = $this->users->get_all();
        $this->_display('index', $view_text);
    }


//    function phpinfo() {
//        phpinfo();
//    }

}

?>
