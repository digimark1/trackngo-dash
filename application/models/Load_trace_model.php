<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class load_trace_model extends CRUD_model {
    
    protected $_table = 'ts_load_trace';
    protected $_primary_key = 'idts_load_trace';    

    public function __construct() {
        parent::__construct();
    }
    
    

}
