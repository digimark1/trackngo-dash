<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class customer_contact_model extends CRUD_model {
    
    protected $_table = 'ts_customer_contact';
    protected $_primary_key = 'idts_customer_contact';    

    public function __construct() {
        parent::__construct();
    }
    
    

}
