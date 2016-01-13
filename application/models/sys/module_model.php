<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Module_model extends MY_Model{
    public $table = 'sys_module';
    public $primary_key = 'id';

    function __construct(){
        parent::__construct();
        $this->return_as = 'array';
    }

    public function get_menu($group_id){
        $_modules = $this->db->select('*')->from($this->table)->where('module_type','module')->order_by('module_order','asc')->get()->result_array();

        for($i=0;$i<count($_modules);$i++){
            $_modules[$i]['page'] = $this->db->select(array($this->table.'.*'))->from($this->table)->join('sys_group_permission', 'sys_group_permission.sys_module_id = '.$this->table.'.id and user_group_id=\''.$group_id.'\'', 'inner')
                ->where(array('module_type'=>'page','module_parent_id'=>$_modules[$i]['id']))->order_by('module_order','asc')->get()->result_array();
        }
        return $_modules;
    }

    public function get_module_id($group_id){

        $_modules = $this->db->select('*')->from($this->table)->where('module_type','module')->order_by('module_order','asc')->get()->result_array();

        for($i=0;$i<count($_modules);$i++){
            $_modules[$i]['page'] = $this->db->select(array($this->table.'.*'))->from($this->table)->join('sys_group_permission', 'sys_group_permission.sys_module_id = '.$this->table.'.id and user_group_id=\''.$group_id.'\'', 'inner')
                ->where(array('module_type'=>'page','module_parent_id'=>$_modules[$i]['id']))->order_by('module_order','asc')->get()->result_array();
        }

        return $_modules;
    }

    public function get_permission($group_id){
        $_modules = $this->db->select('*')->from($this->table)->where('module_type','module')->order_by('module_order','asc')->get()->result_array();

        for($i=0;$i<count($_modules);$i++){
            $page = $this->db->select(array($this->table.'.*','ifnull(sys_group_permission.id,0) p'))->from($this->table)->join('sys_group_permission', 'sys_group_permission.sys_module_id = '.$this->table.'.id and user_group_id=\''.$group_id.'\'', 'left')
                ->where(array('module_type'=>'page','module_parent_id'=>$_modules[$i]['id']))->order_by('module_order','asc')->get()->result_array();
            for($j=0;$j<count($page);$j++){
                $action = $this->db->select(array($this->table.'.*','ifnull(sys_group_permission.id,0) p'))->from($this->table)->join('sys_group_permission', 'sys_group_permission.sys_module_id = '.$this->table.'.id and user_group_id=\''.$group_id.'\'', 'left')
                    ->where(array('module_type'=>'action','module_parent_id'=>$page[$j]['id']))->order_by('module_order','asc')->get()->result_array();
                $page[$j]['action'] = $action;
            }
            $_modules[$i]['page'] = $page;
        }
        return $_modules;
    }
}