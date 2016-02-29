<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class shipment_model extends CRUD_model {

    protected $_table = 'shipment';
    protected $_primary_key = 'idshipment';

    public function __construct() {
        parent::__construct();
    }

    public function get_shipment($id = null) {
        $this->db->select('shipment.* ,'
                . ' ts_customer.name AS customer_name,'
        );
        $this->db->from($this->_table);
        $this->db->join('ts_customer', 'ts_customer.idts_customer = shipment.ts_customer_idts_customer');

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

}
