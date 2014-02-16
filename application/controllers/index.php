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

        //認証チェック
        $this->load->library('login');
        $this->login->login_status_check('index');

    }

    function login() {
        $this->login->login();
    }

    function logout() {
        $this->login->logout();
    }

    function _display($name, $view_text) {
        //ページ判定

        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('footer', $view_text);
    }

    function index() {
        $view_text['title'] = 'TOP';
        $this->_display('index', $view_text);
    }


    function phpinfo() {
        phpinfo();
    }

}

?>
