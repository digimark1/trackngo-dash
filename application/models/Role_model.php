<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class Role_model extends CRUD_model {

    protected $_table = 'role';
    protected $_primary_key = 'idrole';

    public function __construct() {
        parent::__construct();
    }

}
