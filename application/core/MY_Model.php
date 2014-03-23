<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model {

    private $table;

    public function __construct() {
        parent::__construct();

        $this->set_table();
    }

    private function set_table() {
        $this->table = preg_replace('/_[a-z0-9]+$/', '', strtolower(get_class($this)));
    }

    public function get_table() {
        return $this->table;
    }

    public function get_all($where = array(), $order_by = '', $limit = 0, $offset = 0, $or_where=array(), $where_in=array()) {
        if (count($where) > 0)
            $this->db->where($where);
        if (count($or_where) > 0)
            $this->db->or_where($or_where);

        if (count($where_in) > 0)
            $this->db->where_in($where_in['in_colomn'], $where_in['in_colomn_array']);

        if (!empty($order_by))
            $this->db->order_by($order_by);

        if (is_int($limit) && $limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get($this->get_table());

//        echo $this->db->last_query();
        return $query->result_array();
        
    }

    public function get_all_cnt($where = array(), $order_by = '', $limit = 0, $offset = 0) {
        if (count($where) > 0)
            $this->db->where($where);

        if (!empty($order_by))
            $this->db->order_by($order_by);

        if (is_int($limit) && $limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get($this->get_table());

        return $query->num_rows();
    }

    public function get_count($where = array(), $like = array()) {
        if (is_array($where) && count($where) > 0){
            $this->db->where($where);
        }

        if (is_array($like) && count($like) > 0) {
            foreach ($like as $key => $val) {
                if (!is_array($val))
                    $this->db->like($key, $val);
                else
                    foreach ($val as $myval)
                        $this->db->like($key, $myval);
            }
        }

        return $this->db->count_all_results($this->get_table());
    }
    
    function get_sum($sum='', $where = array()) {
        if (count($where) > 0)
            $this->db->where($where);
        if ($sum != "")
            $this->db->select_sum($sum);

        $query = $this->db->get($this->get_table());

        return $query->result_array();
    }


    public function get_row($where = array(), $order_by = '') {

        if (count($where) > 0)
            $this->db->where($where);
        if (!empty($order_by))
            $this->db->order_by($order_by);

        $this->db->limit(1);

        $query = $this->db->get($this->get_table());

        $result = $query->result_array();
        return (count($result) == 1) ? $result[0] : FALSE;
    }

    public function like($where = array(), $like = array(), $order_by = '', $limit = 0, $offset = 0) {
        if (is_array($where) && count($where) > 0)
            $this->db->where($where);

        if (is_array($like) && count($like) > 0) {
            foreach ($like as $key => $val) {
                if (!is_array($val))
                    $this->db->like($key, $val);
                else
                    foreach ($val as $myval)
                        $this->db->like($key, $myval);
            }
        }

        if (!empty($order_by))
            $this->db->order_by($order_by);

        if (is_int($limit) && $limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get($this->get_table());

        return $query->result_array();
    }

}