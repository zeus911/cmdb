<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Segment_model extends MY_Model{
    public $table = 'segment';
    public $primary_key = 'segment_id';

    function __construct(){
        parent::__construct();
        $this->return_as = 'array';
    }
}