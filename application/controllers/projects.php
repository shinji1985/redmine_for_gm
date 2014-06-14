<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *
 *
 */

class Projects extends MY_Controller {

    function __construct() {
        parent::__construct();

        //library
        $this->load->library('group');
        $this->load->library('login');

        //authentication
        $this->login->login_status_check('');

        //load models
        $this->load->model('projects_model', 'projects');
        $this->load->model('issues_model', 'issues');
    }

    function _display($name, $view_text) {
        //project list for header
        $view_text['dropdown_projects'] = $this->group->generate_projects_in_thegroup($this->session->userdata("group_id"));
        //users group dropdown
        $view_text['dropdown_groups'] = $this->group->generate_dropdown($this->session->userdata("group_id"));
        //users group get query
        $view_text['group_get_query'] = $this->group->generate_get_query();
        //flexible gantt flag
        $view_text['flexible'] = TRUE;


        $this->load->view('header', $view_text);
        $this->load->view($name, $view_text);
        $this->load->view('footer', $view_text);
    }

    function index($identifier = "") {
        if ($identifier) {
            //Show project detail


            $where['identifier'] = $identifier;
            $view_text['project'] = $this->projects->get_row($where);

            $parent_where['project_id'] = $view_text['project']['id'];
            $parent_where['parent_id'] = NULL;
            $view_text['issues'] = $this->issues->get_issues_for_project($parent_where);
            $result_cnt = count($view_text['issues']);

            $all_where['project_id'] = $view_text['project']['id'];
            $allcnt = $this->issues->get_all_cnt($all_where);



            $i = 0;
            foreach ($view_text['issues'] as $row):

                $issues_where['project_id'] = $view_text['project']['id'];
                $issues_where['parent_id'] = $row['id'];
                $view_text['issues'][$i]['child'] = $this->issues->get_issues_for_project($issues_where);
                $k = 0;
                foreach ($view_text['issues'][$i]['child'] as $row2):
                    $issues_where['project_id'] = $view_text['project']['id'];
                    $issues_where['parent_id'] = $row2['id'];
                    $view_text['issues'][$i]['child'][$k]['child'] = $this->issues->get_issues_for_project($issues_where);
                    $z = 0;
                    foreach ($view_text['issues'][$i]['child'][$k]['child'] as $row3):
                        $issues_where['project_id'] = $view_text['project']['id'];
                        $issues_where['parent_id'] = $row3['id'];
                        $view_text['issues'][$i]['child'][$k]['child'][$z]['child'] = $this->issues->get_issues_for_project($issues_where);


                        $z++;
                    endforeach;

                    $k++;
                endforeach;
                $i++;
            endforeach;


            if ($view_text['project']) {
                $view_text['title'] = $view_text['project']['name'];
                $this->_display('projects_detail', $view_text);
            } else {
                show_404('page');
            }
        } else {
            show_404('page');
        }
    }

}

?>
