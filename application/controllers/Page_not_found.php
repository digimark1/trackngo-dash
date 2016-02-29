<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of My404
 *
 * @author Hernando P
 */
class page_not_found extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $roles = $this->session->userdata('roles');
        $i = 0;
        if ($roles) {
            foreach ($roles as $role => $row) {
                $GLOBALS['roles'][$i] = $row['class'] . '/' . $row['function'];
                $i++;
            }
        }else{
            $GLOBALS['roles'][0]= site_url('/');
        }
    }

    public function index() {

//        $this->output->set_status_header('404');
//        $data['content'] = 'error_404'; // View name         
        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('page_not_found/index'); //loading in my template 
        $this->load->view('general/inc/footer_view');
    }

}
