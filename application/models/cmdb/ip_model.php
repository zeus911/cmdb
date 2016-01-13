<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ip_model extends MY_Model{
    public $table = 'ip';
    public $primary_key = 'id';

    function __construct(){
        parent::__construct();
        $this->return_as = 'array';
    }

}