<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_group extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('sys/user_group_model','sys_user_group_model');
    }

    function index(){
        $this->load->view('sys/user_group');
    }

    function get_list(){
        $group_name = $this->input->post('group_name');
        $condition = $this->sys_user_group_mode;
        if (!empty($group_name)) {
            $condition = $condition->where('group_name',$group_name);
        }

        $sort = $this->input->post('sort');
        if (!empty($sort)) {
            $order = explode('.', $sort);
            $condition = $condition->order_by($order[0],$order[1]);
        }

        $page_size = $this->input->post('page');
        $limit = $this->input->post('limit');

        $start = 0;
        if($limit != -1){
            $start = ($page_size - 1) * $limit;
        }
        $data['items'] = $condition->limit($limit,$start)->get();
        $data['totalCount'] = $condition->count();
        ajax_return($data);
    }

    function add(){
        $params = $this->input->post(NULL, TRUE);

        foreach ($params as $k => $v) {
            $_data[$k] = $v;
        }
	    unset($_data['id']);
        $_result = $this->sys_user_group_model->insert( $_data);
        if ($_result) {
            $ot = array('code' => 0,
                'message' => '操作成功!');
        } else {
            $ot = array('code' => 1001,
                'message' => '操作失败!');
        }
        ajax_return($ot);
    }

    function edit(){
        $params = $this->input->post(NULL, TRUE);

        foreach ($params as $k => $v) {
            $_data[$k] = $v;
        }
        $_result = $this->sys_user_group_model->where('id',$_data['id'])->update($_data);
        if ($_result) {
            $ot = array('code' => 0,
                'message' => '操作成功!');
        } else {
            $ot = array('code' => 1001,
                'message' => '操作失败!');
        }
        ajax_return($ot);
    }

    function delete(){
        $id = $this->input->post('id');
        $_result = $this->sys_user_group_model->delete($id);
        if ($_result) {
            $ot = array('code' => 0,
                'message' => '操作成功!');
        } else {
            $ot = array('code' => 1001,
                'message' => '操作失败!');
        }
        ajax_return($ot);
    }

}

