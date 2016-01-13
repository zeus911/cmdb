<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Room_model extends MY_Model{
    public $table = 'room';
    public $primary_key = 'id';

    function __construct(){
        parent::__construct();
        $this->return_as = 'array';
    }
}