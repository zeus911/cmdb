<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Segment_ip_pool_model extends MY_Model{
    public $table = 'segment_ip_pool';
    public $primary_key = 'id';

    function __construct(){
        parent::__construct();
        $this->return_as = 'array';
    }
}