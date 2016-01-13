<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Device_model extends MY_Model{
    public $table = 'device';
    public $primary_key = 'assets_id';

    function __construct(){
        parent::__construct();
        $this->return_as = 'array';
    }

}