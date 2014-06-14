<?php

class Members_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function get_projects($where = array()) {

        if (count($where) > 0)
            $this->db->where($where);

        $this->db->group_by("project_id"); 
        
        $query = $this->db->get($this->get_table());

        return $query->result_array();
    }

}

?>
