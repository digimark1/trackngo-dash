<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class callcheck_model extends CRUD_model {

    protected $_table = 'ts_callcheck';
    protected $_primary_key = 'idts_callcheck';

    public function __construct() {
        parent::__construct();
    }

    public function get_chat($id, $date = null) {
        $this->db->select('ts_callcheck.comment AS comment,'
                . ' ts_callcheck.driver AS driver_sw ,'
                . ' ts_callcheck.notify_driver AS notify_driver ,'
                . ' ts_callcheck.city AS city ,'
                . ' ts_callcheck.state AS state ,'
                . ' ts_callcheck.country AS country ,'
                . ' ts_driver.name AS driver_name,'
                . ' ts_driver.last_name AS driver_last_name,'
                . ' user.name AS user_name,'
                . ' user.login AS user_login,'
                . ' ts_callcheck.date AS date');
        $this->db->from($this->_table);
        $this->db->join('ts_load', 'ts_load.idts_load = ts_callcheck.ts_load_idts_load');
        $this->db->join('user', 'user.iduser = ts_callcheck.user_iduser');
        $this->db->join('ts_driver', 'ts_driver.idts_driver = ts_load.ts_driver_idts_driver');

        /**
         * @uses $q = $this->db->get('user'); Muestra todos los usuarios
         * @uses element Description
         */
        if (is_numeric($id)) {
            $q = $this->db->where($this->_primary_key, $id);
        }

        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        if ($date) {
            $this->db->where('date >', $date);
        }

        $this->db->order_by('date', 'asc');


//        if($limit && $start) {
//            $this->db->limit($limit, $start);
//        }

        $q = $this->db->get();
        return $q->result_array();
    }

    public function get_chat_all($id) {
		$date = null;
        $this->db->select('ts_callcheck.comment AS comment,'
                . ' ts_callcheck.driver AS driver_sw ,'
                . ' ts_callcheck.notify_driver AS notify_driver ,'
                . ' ts_callcheck.city AS city ,'
                . ' ts_callcheck.state AS state ,'
                . ' ts_callcheck.country AS country ,'
				. ' ts_callcheck.idts_callcheck ,'
				. ' ts_callcheck.ts_load_idts_load ,'
                . ' ts_driver.name AS driver_name,'
                . ' ts_driver.last_name AS driver_last_name,'
                . ' user.name AS user_name,'
                . ' user.login AS user_login,'
                . ' ts_callcheck.date AS date');
        $this->db->from($this->_table);
        $this->db->join('ts_load', 'ts_load.idts_load = ts_callcheck.ts_load_idts_load');
        $this->db->join('user', 'user.iduser = ts_callcheck.user_iduser');
        $this->db->join('ts_driver', 'ts_driver.idts_driver = ts_load.ts_driver_idts_driver');
        /**
         * @uses $q = $this->db->get('user'); Muestra todos los usuarios
         * @uses element Description
         */
		/*foreach ($id as $key => $value) {
			$this->db->where($key, $value);
		}*/
		//$id = '[103,102,101,100,99,98,97,96,95,92,88]';
		$id2 = (array)json_decode($id);
		//foreach ($id2 as $value) {
		 //  $this->db->where_in('ts_load_idts_load', array('103','102','101','100','99','98','97','96','95','92','88'));
		 $this->db->where_in('ts_load_idts_load', $id2);
		//}
		 //$this->db->where('date >', $date);
        $this->db->order_by('date', 'desc');

        $q = $this->db->get();
        return $q->result_array();
    }

    public function get_notifications() {
        $this->db->select('ts_callcheck.comment AS comment,'
                . ' ts_callcheck.driver AS driver_sw ,'
                . ' ts_callcheck.notify_driver AS notify_driver ,'
                . ' ts_callcheck.city AS city ,'
                . ' ts_callcheck.state AS state ,'
                . ' ts_callcheck.country AS country ,'
                . ' ts_driver.name AS driver_name,'
                . ' ts_driver.last_name AS driver_last_name,'
                . ' user.name AS user_name,'
                . ' user.login AS user_login,'
                . ' ts_callcheck.date AS date');
        $this->db->from($this->_table);
        $this->db->join('ts_load', 'ts_load.idts_load = ts_callcheck.ts_load_idts_load');
        $this->db->join('user', 'user.iduser = ts_callcheck.user_iduser');
        $this->db->join('ts_driver', 'ts_driver.idts_driver = ts_load.ts_driver_idts_driver');


        $this->db->order_by('date', 'desc');
        $this->db->limit(10, 1);

//        if($limit && $start) {
//            $this->db->limit($limit, $start);
//        }

        $q = $this->db->get();
        return $q->result_array();
    }

}
