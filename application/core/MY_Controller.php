<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct($language = "") {
        parent::__construct();
        $this->load->database();
        $this->db->query('SET NAMES utf8');
//       $this->output->enable_profiler(TRUE);
    }

}

?>