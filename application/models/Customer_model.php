<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class customer_model extends CRUD_model {
    
    protected $_table = 'ts_customer';
    protected $_primary_key = 'idts_customer';    

    public function __construct() {
        parent::__construct();
    }
    
    

}
