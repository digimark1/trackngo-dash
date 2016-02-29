<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class driver_model extends CRUD_model {

    protected $_table = 'ts_driver';
    protected $_primary_key = 'idts_driver';

    public function __construct() {
        parent::__construct();
    }

    public function get_driver($id = null) {
        $this->db->select('* ,'
                . ' ts_carrier.name AS carrier_name,'
                . ' ts_driver.name AS driver_name,'
                . ' ts_driver.last_name AS driver_last_name,'
                . ' ts_driver.phone AS driver_phone,'
                . ' ts_driver.email AS driver_email,'
                );
        $this->db->from($this->_table);
        $this->db->join('ts_carrier', 'ts_driver.ts_carrier_idts_carrier = ts_carrier.idts_carrier');

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
