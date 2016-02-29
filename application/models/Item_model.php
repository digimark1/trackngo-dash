<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class Item_model extends CRUD_model {

    protected $_table = 'ts_item';
    protected $_primary_key = 'idts_item';

    public function __construct() {
        parent::__construct();
    }

    public function get_items_by_load_id($id) {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('ts_load_idts_load', $id);
        
        $q = $this->db->get();
        return $q->result_array();        
    }

}
