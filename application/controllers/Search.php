<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of searches
 *
 * @author Nando
 */
class Search extends CI_Controller {

    public function get() {
//        $q = $this->db->get('search');
        $q = $this->db->query('SELECT * FROM search');
        print_r($q->result());
    }

    public function insert() {
        $customer['name'] = $_POST['name'];
        $customer['phone'] = $_POST['phone'];
        $customer['company'] = $_POST['company'];
        $customer['email'] = $_POST['email'];
        $customer['date'] = date("Y-m-d H:i:s");
        $this->db->insert('search', $customer);
    }
    
    public function index() {
        $this->load->view('search/index.php');
    }

}
