<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('groups_users_model', 'groups_users');
    }

    //generate user groups drop down 
    function generate_dropdown($group_id = "") {

        $result = $this->CI->groups_users->get_group();

        $drop_down_array = array();
        $drop_down_array[0] = 'All Groups';
        foreach ($result as $row):
            $drop_down_array[$row['group_id']] = $row['group_name'];
        endforeach;

        return form_dropdown('groups_users', $drop_down_array, $group_id, ' class="form-control user-group"');
    }

    function generate_get_query() {
        
        $get_query="";
        
        if (is_numeric($this->CI->session->userdata("group_id"))):
            $get_query = '?group_id=' . $this->CI->session->userdata("group_id");
        endif;
        
        return $get_query;
    }

}

?>