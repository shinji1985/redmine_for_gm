<?php

class Groups_users_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function get_group($where = array(), $order_by = "", $limit = 0, $offset = 0) {
        
        $this->db->select('users.lastname  AS group_name, 
            groups_users.group_id AS group_id');

        $this->db->join('users', 'groups_users.group_id = users.id', 'left');
        
        if (count($where) > 0)
            $this->db->where($where);

        if (!empty($order_by))
            $this->db->order_by($order_by);

        if (is_int($limit) && $limit > 0)
            $this->db->limit($limit, $offset);
        
        $this->db->group_by("group_id"); 
        
        $query = $this->db->get($this->get_table());

//        echo $this->db->last_query();
        return $query->result_array();
    }

}

?>
