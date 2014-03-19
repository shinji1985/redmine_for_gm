<?php

class Issues_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_all_with_projects($where = array(), $order_by = "", $limit = 0, $offset = 0) {

        $this->db->select('issues.id, issues.subject, issues.description, issues.due_date, issues.start_date, issues.done_ratio, issues.estimated_hours, issues.assigned_to_id, issues.status_id,
            projects.name  AS project_name, projects.identifier, 
            issue_statuses.name AS issue_status');



        $this->db->join('projects', 'issues.project_id = projects.id', 'left');
        $this->db->join('issue_statuses', 'issues.status_id = issue_statuses.id', 'left');

        if (count($where) > 0)
            $this->db->where($where);

        if (!empty($order_by))
            $this->db->order_by($order_by);

        if (is_int($limit) && $limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get($this->get_table());

//        echo $this->db->last_query();
        return $query->result_array();
    }


}

?>
