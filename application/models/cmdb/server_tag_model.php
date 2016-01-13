<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Server_tag_model extends MY_Model{
    public $table = 'server_tag';
    public $primary_key = 'id';

    function __construct(){
        parent::__construct();
        $this->return_as = 'array';
    }
}