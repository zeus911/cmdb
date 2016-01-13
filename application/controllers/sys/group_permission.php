<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class group_permission extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/group_permission_model','group_permission_model');
        $this->load->model('sys/module_model','module_model');
    }
    public function config(){
        $_group_id = $this->input->get('sys_group_id');
        $data['permission'] = $this->module_model->get_permission($_group_id);
        $data['group_id'] = $_group_id;
        $this->load->view('sys/group_permission',$data);
    }

   function change(){
        $_group_id = $this->input->get('group_id');
        $_module_id = $this->input->get('module_id');
        $_flag = $this->input->get('flag');

        switch($_flag){
           case 1:
               $_data = array('user_group_id'=>$_group_id,'sys_module_id'=>$_module_id);
               $this->group_permission_model->insert($_data);
               break;
           default:
               $_data =array('user_group_id'=>$_group_id,'sys_module_id'=>$_module_id);
               $this->group_permission_model->delete($_data);
               break;
        }
        $ot = array('code' => 0 ,
           'message' => '操作成功!');
        ajax_return($ot);
    }

}

