<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function logout() {
        $this->CI->session->sess_destroy();
        $view_text['result_text'] = '<div class="alert alert-success">Log out complete.</div>';
        $this->CI->load->view('login', $view_text);
    }

    //display login form
    function login() {
        $this->CI->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->CI->form_validation->set_rules('login', 'login', 'trim|required|htmlspecialchars|xss_clean');
        $this->CI->form_validation->set_rules('password', 'password', 'trim|required|htmlspecialchars|xss_clean');

        //authentication
        if ($this->CI->form_validation->run()) {
            $result = $this->_authenticate(set_value('login'), set_value('password'));
            if ($result) {
                $this->CI->session->set_userdata("logged_in", 'true');
                //Go to top page
                redirect(base_url() . 'index', 'refresh');
            } else {
                $view_text['result_text'] = '<div class="alert alert-danger">Invalid Login ID or Password.<br/>※You must be an admin account.</div>';
                $this->CI->load->view('login', $view_text);
            }
        } else {
            $view_text['result_text'] = validation_errors();
            $this->CI->load->view('login', $view_text);
        }
    }

    //check login status 
    function login_status_check($method = "") {
        if ($this->CI->session->userdata("logged_in")) {
            //User is logged in
        } else {
            if ($this->CI->uri->uri_string() != 'index/login') {
                redirect(base_url() . 'index/login', 'refresh');
            }
        }
    }

    function _authenticate($login, $password) {
        $this->CI->load->model('users_model', 'users');
        $user['login'] = $login;
        $row = $this->CI->users->get_row($user);

        if ($row) {
            if (sha1($row['salt'] . sha1($password)) == $row['hashed_password']) {
                if ($row['admin'] == 1) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}

?>