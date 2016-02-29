<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class carrier_model extends CRUD_model {
    
    protected $_table = 'ts_carrier';
    protected $_primary_key = 'idts_carrier';    

    public function __construct() {
        parent::__construct();
    }
    
    

}
