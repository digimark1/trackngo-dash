<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class location_request_model extends CRUD_model {

    protected $_table = 'request';
    protected $_primary_key = 'request_load';

    public function __construct() {
        parent::__construct();
    }

    public function get_shipment($id = null) {
        $this->db->select('*');
        $this->db->from($this->_table);
        //$this->db->join('ts_customer', 'ts_customer.idts_customer = shipment.ts_customer_idts_customer');

        if (is_numeric($id)) {
            $q = $this->db->where($this->_primary_key, $id);
        }

        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        $q = $this->db->get();
        return $q->result_array();
    }
    
    public function get_max_request_number ($reques_load) {
        $this->db->select ('*');
        $this->db->from($this->_table);
        $this->db->where('request_load', $reques_load);

        $q = $this->db->get();
        return $q->result_array();
        
    }

}
