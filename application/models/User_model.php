<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class User_model extends CRUD_model {

    protected $_table = 'user';
    protected $_primary_key = 'iduser';

    public function __construct() {
        parent::__construct();
    }

    public function get_user($id = null) {
        if (is_numeric($id)) {
            $q = $this->db->where($this->_primary_key, $id);
        }

        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->select('*,'
                . '(SELECT login FROM user WHERE iduser = u.user_iduser) AS parent');
        $this->db->from($this->_table . ' u');
        $q = $this->db->get();
        return $q->result_array();
    }

}
