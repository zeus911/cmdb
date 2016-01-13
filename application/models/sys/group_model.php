<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends MY_Model{
    public $table = 'sys_group';
    public $primary_key = 'id';

    function __construct(){
        parent::__construct();
        $this->return_as = 'array';
    }
}