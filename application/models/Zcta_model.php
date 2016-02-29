<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class zcta_model extends CRUD_model {
    
    protected $_table = 'zcta';
    protected $_primary_key = 'zip';    

    public function __construct() {
        parent::__construct();
    }
    

}
