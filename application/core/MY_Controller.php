<?php

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data['class'] = $this->get_class_name();
        $data['user'] = $this->session->userdata('name');
    }

    public function _required_login($class = null, $function = null) {

        if ($this->session->userdata('user_id') == FALSE) {
            $this->logout();
            $this->output->set_output(json_encode(['result' => 0, 'error' => 'You are not authorized']));
            return false;
        }

        if ($class && $function) {
            $roles = $this->session->userdata('roles');
            $sw = 0;
            foreach ($roles as $role => $row) {
                if (($row['class'] == $class) && ($row['function'] == $function)) {
                    $sw = 1;
                }
            }
            if (!$sw) {
                $this->not_auth($class);
                $this->output->set_output(json_encode(['result' => 0, 'error' => 'You are not authorized']));
                return false;
            }
        }       
        
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }

    public function not_auth($class) {
        $url = $class . '/unauth';
        redirect(site_url($url));
    }

    public function getMyPageTitle() {

        $title = '';
        $ci = &get_instance();

        $default_title = 'My Site'; // you can load it from a config file,and that is better option
        // get the view name
        $view = $this->uri->segment(2);
        // check if controller set a page tile
        /* If you want to set a page title for a particular page then always 
         * named that variable 'pageTitle' as $data['pageTitle'] = 'My page title | For this page'
         */

        global $pageTitle;

        if ($pageTitle) {// the controller sets the page title
            $title = $pageTitle;
        } elseif ($view !== '') {//you can include your view name in the page title,,and the view name is not blanks
            $title = $default_title . ' | ' . $view;
        }/**
         * You can write several else if , before or after this or
         * can change the total logic as you want
         */ else {
            $title = $default_title;
        }

        return $title;
    }

    public function get_class_name() {
        $ci = & get_instance();
        return $ci->router->fetch_class();
    }

    public function get_session_user_data() {
        $data['class'] = $this->get_class_name();
        $data['user_id'] = $this->session->userdata('user_id');
        $data['user'] = $this->session->userdata('name');
        $data['login'] = $this->session->userdata('login');
        $data['brother'] = $this->session->userdata('brother');
        $data['parent'] = $this->session->userdata('parent');
        $data['roles'] = $this->session->userdata('roles');
        return $data;
    }

}
