<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('groups_users_model', 'groups_users');
    }

    //Generate user groups drop down 
    function generate_dropdown($group_id = "") {

        $result = $this->CI->groups_users->get_group();

        $drop_down_array = array();
        $drop_down_array[0] = 'All Groups';
        foreach ($result as $row):
            $drop_down_array[$row['group_id']] = $row['group_name'];
        endforeach;

        return form_dropdown('groups_users', $drop_down_array, $group_id, ' class="form-control user-group"');
    }
    
    //Generate get parameter for view file
    function generate_get_query() {
        
        $get_query="";
        
        if (is_numeric($this->CI->session->userdata("group_id"))):
            $get_query = '?group_id=' . $this->CI->session->userdata("group_id");
        endif;
        
        return $get_query;
    }
    
    //Get users in group specified in argument.
    function getusers_in_group($group_id="") {

        $users_in_group = $this->CI->groups_users->get_all(array('group_id' => $group_id));
        
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
        
        return $this->CI->users->get_all($user_where, $order_by);
    }

}

?>