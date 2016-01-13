<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Module extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('sys/module_model','sys_module_model');
    }

    function index(){
        $list = $this->sys_module_model->where(array('module_type'=>'module'))->order_by('module_order','asc')->get();
        for($i=0;$i<count($list);$i++){
            $page = $this->sys_module_model->order_by('module_order','asc')->where(array('module_parent_id'=>$list[$i]['id']))->get();
            for($j=0;$j<count($page);$j++){
                $action = $this->sys_module_model->order_by('module_order','asc')->where(array('module_parent_id'=>$page[$j]['id']))->get();
                $page[$j]['children'] = $action;
            }
            $list[$i]['children'] = $page;
        }
        $data['list'] = $list;
        $this->load->view('sys/module_list',$data);
    }

    function add(){
        $_module_type = $this->input->get_post('module_type');
        $_module_parent_id = $this->input->get_post('module_parent_id');
        $data['module_type'] = $_module_type;
        $data['parent_id'] = $_module_parent_id;
        if(IS_POST){
            $_data['module_name'] = $_POST['module_name'];
            $_data['module_resource'] = $_POST['module_resource'];
            $_data['module_icon'] = $_POST['module_icon'];
            $_data['module_type'] = $_module_type;
            $_data['module_parent_id'] = $_module_parent_id;
            $_result = $this->sys_module_model->insert($_data);
            if ($_result) {
                $ot = array('code' => 0 ,
                    'message' => '操作成功!');
            } else {
                $ot = array('code' => 1001,
                    'message' => '操作失败!');
            }
            ajax_return($ot);
        }else{
            $this->load->view('sys/module_add',$data);
        }
    }

    function edit()
    {
        $_id = $this->input->get_post('id');
        $_module_type = $this->input->get_post('module_type');
        $_module_parent_id = $this->input->get_post('module_parent_id');
        $data['module_type'] = $_module_type;
        $data['parent_id'] = $_module_parent_id;
        if(IS_POST){
            $_data['module_name'] = $_POST['module_name'];
            $_data['module_resource'] = $_POST['module_resource'];
            $_data['module_icon'] = $_POST['module_icon'];
            $_result = $this->sys_module_model->where('id',$_id)->updae($_data);
            if ($_result) {
                $ot = array('code' => 0 ,
                    'message' => '操作成功!');
            } else {
                $ot = array('code' => 1001,
                    'message' => '操作失败!');
            }
            ajax_return($ot);
        }else{
            $data['entity'] = $this->sys_module_model->get($_id);
            $this->load->view('sys/module_edit',$data);
        }
    }

    function delete()
    {
        $_id = $this->input->get('id');
        echo $this->sys_module_model->delete($_id);
        $ot = array('code' => 0 ,
            'message' => '操作成功!');
        ajax_return($ot);
    }

    function sort(){
        $_idlist = $this->input->get_post('module');

        $_ids_module = explode('|',$_idlist);
        $_idlist = $this->input->get_post('page');
        $_ids_page = explode('|',$_idlist);
        $_ids = array_merge($_ids_module,$_ids_page);

        for ($i=0; $i<count($_ids); $i++)
        {
            $this->sys_module_model->where('id',$_ids[$i])->update(array('module_order'=>$i));
        }
        echo STATUS_SUCCESS;
    }

}

