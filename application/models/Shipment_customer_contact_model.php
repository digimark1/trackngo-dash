<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class shipment_customer_contact_model extends CRUD_model {

    protected $_table = 'shipment_customer_contact';
    protected $_primary_key = 'idshipment_customer_contact';

    public function __construct() {
        parent::__construct();
    }

    public function get_contacts($id) {
        $this->db->select(''
                . ' ts_customer_contact_idts_customer_contact AS contact_id,'
                . ' ts_customer_contact.name AS name,'
                . ' ts_customer_contact.phone AS phone,'
                . ' ts_customer_contact.email AS email'
        );
        $this->db->from($this->_table);
        $this->db->join('ts_customer_contact', 'shipment_customer_contact.ts_customer_contact_idts_customer_contact = ts_customer_contact.idts_customer_contact');
        $this->db->join('shipment', 'shipment.idshipment = shipment_customer_contact.shipment_idshipment');

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
