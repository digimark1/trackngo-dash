<?php

class CRUD_model extends CI_Model {

    protected $_table = null;
    protected $_primary_key = null;

    public function __construct() {
        parent::__construct();
    }

    public function get($id = null, $order_by = null, $order = null, $limit = null, $start = null) {
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

        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }

        if ($limit) {
            if (!$start) {
                $start = 0;
            }
            $this->db->limit($limit, $start);
        }

        $q = $this->db->get($this->_table);
        return $q->result_array();
    }

    /**
     * @param array $data Description
     * @uses $result = $this->user_model->insert(['login' => 'Jethro']) Description
     */
    public function insert($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    public function insertBatch($data) {
        $this->db->insert_batch($this->_table, $data);
        return $this->db->insert_id();
    }

    /**
     * @uses $result = $this->user_model->update($data, 3);
     * @param type $data
     * @param type $user_id
     * @return type
     */
    public function update($new_data, $where) {

        if (is_numeric($where)) {
            $this->db->where($this->_primary_key, $where);
        } elseif (is_array($where)) {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        } else {
            die('You must pass a SECOND parameter to the UPDATE() method.');
        }

        $this->db->update($this->_table, $new_data);
        return $this->db->affected_rows();
    }

    /**
     * @uses $result = $this->user_model->update($data, 3);
     * @param type $data
     * @param type $user_id
     * @return type
     */
    public function multiUpdate($new_data, $where_in) {

        if ($where_in) {
            $this->db->where_in($this->_primary_key, $where_in);
        } else {
            die('You must pass a SECOND parameter to the UPDATE() method.');
        }

        $this->db->update($this->_primary_key, $new_data);
        return $this->db->affected_rows();
    }

    /**
     * @uses $this->user_model->delete(2);
     * @usage this->user_model->delete(array('name' => 'Markus'));
     * @return type
     */
    public function delete($id = null) {
        if (is_numeric($id)) {
            $this->db->where($this->_primary_key, $id);
        } elseif (is_array($id)) {
            foreach ($id as $key => $value) {
                $this->db->where($key, $value);
            }
        } else {
            die('You must pass a parameter to the DELETE() method.');
        }
        $this->db->delete($this->_table);
        return $this->db->affected_rows();
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function insertUpdate($data, $id = false) {
        if (!$id) {
            die('You must pass a parameter to the insertUpdate() method.');
        }
        $this->db->select($this->_primary_key);
        $this->db->where($this->_primary_key, $id);
        $q = $this->db->get($this->_table);
        $result = $q->num_rows();

        if ($result == 0) {
            return $this->insert($data);
        }
        return $this->update($data, $id);
    }

    public function auto_complete($field, $value, $pos) {
        /**
         * @uses $q = $this->db->get('user'); Muestra todos los usuarios
         * @uses element Description
         */
        $this->db->like($field, $value, $pos);

        $q = $this->db->get($this->_table);
        return $q->result_array();
    }

}
