<?php

/**
 * Description of user_model
 *
 * @author Hernando Peña <hpena@leanstaffing.com>
 */
class shipment_document extends CRUD_model {
    
    protected $_table = 'shipment_doc';
    protected $_primary_key = 'idshipment_doc';    

    public function __construct() {
        parent::__construct();
    }
    
    

}
