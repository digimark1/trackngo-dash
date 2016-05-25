<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class load_model extends CRUD_model {

    protected $_table = 'ts_load';
    protected $_primary_key = 'idts_load';

    public function __construct() {
        parent::__construct();
    }

	public function get_load_by_id($where = null){
			$this->db->select('*');
			$this->db->from($this->_table);
			$q = $this->db->where($this->_primary_key, $where);
			$q = $this->db->get();
            return $q->result_array();
		}
		
    public function get_load_view($where = null, $where_in = null, $sw = null, $order_by = null, $order = null, $limit = null, $start = null) {
        $this->db->select('* ,'
                . ' ts_driver.name AS driver_name,'
                . ' ts_driver.last_name AS driver_last_name,'
                . ' ts_driver.full_name AS driver_full_name,'
                . ' ts_driver.email AS driver_email,'
                . ' ts_driver.lat AS driver_latitud,'
                . ' ts_driver.lng AS driver_longitud,'
                . ' ts_driver.apns_number AS driver_apns_number,'
                . ' ts_driver.phone AS driver_phone,'
                . ' ts_driver.app_id AS driver_app_id,'
                . ' ts_carrier.name AS carrier_name,');
        $this->db->from($this->_table);
        $this->db->join('ts_driver', 'ts_load.ts_driver_idts_driver = ts_driver.idts_driver');
        $this->db->join('ts_carrier', 'ts_load.ts_carrier_idts_carrier = ts_carrier.idts_carrier');

        /**
         * @uses $q = $this->db->get('user'); Muestra todos los usuarios
         * @uses element Description
         */
        if ($sw) {
            $this->db->where('sw', $sw);
        }

        if (is_numeric($where)) {
            $q = $this->db->where($this->_primary_key, $where);
        }

        if (is_array($where)) {
            $this->db->group_start();
            foreach ($where as $key => $value) {
                if ($key == 'load_number' || $key == 'load_number') {
                    $this->db->or_where($key, $value);
                } else {
                    $this->db->or_like($key, $value);
                }
            }
            $this->db->group_end();
        }

        if ($where_in) {
            $this->db->where_in('user_iduser', $where_in);
        }

        if ($order_by && $order) {
            $this->db->order_by($order_by, $order);
        }

        if ($limit) {
            if (!$start) {
                $start = 0;
            }
            $this->db->limit($limit, $start);
        }

        $q = $this->db->get();
        return $q->result_array();
    }
	
	
	    public function get_load_view_app($where = null, $where_in = null, $sw = null, $order_by = null, $order = null, $limit = null, $start = null) {
        $this->db->select('* ,'
                . ' ts_driver.name AS driver_name,'
                . ' ts_driver.last_name AS driver_last_name,'
                . ' ts_driver.full_name AS driver_full_name,'
                . ' ts_driver.email AS driver_email,'
                . ' ts_driver.lat AS driver_latitud,'
                . ' ts_driver.lng AS driver_longitud,'
                . ' ts_driver.apns_number AS driver_apns_number,'
                . ' ts_driver.phone AS driver_phone,'
                . ' ts_driver.app_id AS driver_app_id,'
                . ' ts_carrier.name AS carrier_name,');
        $this->db->from($this->_table);
        $this->db->join('ts_driver', 'ts_load.ts_driver_idts_driver = ts_driver.idts_driver');
        $this->db->join('ts_carrier', 'ts_load.ts_carrier_idts_carrier = ts_carrier.idts_carrier');

        /**
         * @uses $q = $this->db->get('user'); Muestra todos los usuarios
         * @uses element Description
         */
        if ($sw) {
            $this->db->where('sw', $sw);
        }

        if (is_numeric($where)) {
            $q = $this->db->where($this->_primary_key, $where);
        }

        if (is_array($where)) {
            $this->db->group_start();
            foreach ($where as $key => $value) {
                    $this->db->or_where($key, $value);
            }
            $this->db->group_end();
        }

        if ($where_in) {
            $this->db->where_in('user_iduser', $where_in);
        }

        if ($order_by && $order) {
            $this->db->order_by($order_by, $order);
        }

        if ($limit) {
            if (!$start) {
                $start = 0;
            }
            $this->db->limit($limit, $start);
        }

        $q = $this->db->get();
        return $q->result_array();
    }
	    public function get_load_view_all($where = null, $where_in = null, $sw = null, $order_by = null, $order = null, $start = null) {
        $this->db->select('* ,'
                . ' ts_driver.name AS driver_name,'
                . ' ts_driver.last_name AS driver_last_name,'
                . ' ts_driver.full_name AS driver_full_name,'
                . ' ts_driver.email AS driver_email,'
                . ' ts_driver.lat AS driver_latitud,'
                . ' ts_driver.lng AS driver_longitud,'
                . ' ts_driver.apns_number AS driver_apns_number,'
                . ' ts_driver.phone AS driver_phone,'
                . ' ts_driver.app_id AS driver_app_id,'
                . ' ts_carrier.name AS carrier_name,');
        $this->db->from($this->_table);
        $this->db->join('ts_driver', 'ts_load.ts_driver_idts_driver = ts_driver.idts_driver');
        $this->db->join('ts_carrier', 'ts_load.ts_carrier_idts_carrier = ts_carrier.idts_carrier');

        /**
         * @uses $q = $this->db->get('user'); Muestra todos los usuarios
         * @uses element Description
         */
        if ($sw) {
            $this->db->where('sw', $sw);
        }

        if (is_numeric($where)) {
            $q = $this->db->where($this->_primary_key, $where);
        }

        if (is_array($where)) {
            $this->db->group_start();
            foreach ($where as $key => $value) {
                if ($key == 'load_number' || $key == 'load_number') {
                    $this->db->or_where($key, $value);
                } else {
                    $this->db->or_like($key, $value);
                }
            }
            $this->db->group_end();
        }

        if ($where_in) {
            $this->db->where_in('user_iduser', $where_in);
        }

        if ($order_by && $order) {
            $this->db->order_by($order_by, $order);
        }

        //if ($limit) {
            if (!$start) {
                $start = 0;
            }
            $this->db->limit($start);
      //  }

        $q = $this->db->get();
        return $q->result_array();
    }

//---------- --------------//
	    public function get_load_view_lite($where = null, $where_in = null, $sw = null, $order_by = null, $order = null, $start = null) {
        $this->db->select('* ,'
                . ' ts_driver.name AS driver_name,'
                . ' ts_driver.last_name AS driver_last_name,'
                . ' ts_driver.full_name AS driver_full_name,'
                . ' ts_driver.email AS driver_email,'
                . ' ts_driver.lat AS driver_latitud,'
                . ' ts_driver.lng AS driver_longitud,'
                . ' ts_driver.apns_number AS driver_apns_number,'
                . ' ts_driver.phone AS driver_phone,'
                . ' ts_driver.app_id AS driver_app_id,'
                . ' ts_carrier.name AS carrier_name,');
        $this->db->from($this->_table);
        $this->db->join('ts_driver', 'ts_load.ts_driver_idts_driver = ts_driver.idts_driver');
        $this->db->join('ts_carrier', 'ts_load.ts_carrier_idts_carrier = ts_carrier.idts_carrier');

        /**
         * @uses $q = $this->db->get('user'); Muestra todos los usuarios
         * @uses element Description
         */
        if ($sw) {
            $this->db->where('sw', $sw);
        }

        if (is_numeric($where)) {
            $q = $this->db->where($this->_primary_key, $where);
        }

        if (is_array($where)) {
            $this->db->group_start();
            foreach ($where as $key => $value) {
                if ($key == 'load_number' || $key == 'load_number') {
                    $this->db->or_where($key, $value);
                } else {
                    $this->db->or_like($key, $value);
                }
            }
            $this->db->group_end();
        }

        if ($where_in) {
            $this->db->where_in('user_iduser', $where_in);
        }

        if ($order_by && $order) {
            $this->db->order_by($order_by, $order);
        }

        //if ($limit) {
            if (!$start) {
                $start = 0;
            }
            $this->db->limit($start);
      //  }

        $q = $this->db->get();
        return $q->result_array();
    }

}
