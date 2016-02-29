<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author nando_000
 */
class dashboard extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $user_id = $this->session->userdata('user_id');
        if(!$user_id){
            $this->logout();
        }
    }
    
    public function index(){
//        $this->load->view('dashboard/inc/header_view');
//        $this->load->view('dashboard/dashboard_view');
//        $this->load->view('dashboard/inc/footer_view');
        
        $this->_required_login();
        $data['class'] = $this->get_class_name();
        $data['user'] = $this->session->userdata('name');
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('dashboard/dashboard_view_1');
        $this->load->view('general/inc/footer_view');        
        
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect('/');
    }
}

?>
