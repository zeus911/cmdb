<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class user extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('sys/user_model','sys_user_model');
        $this->load->model('sys/user_group_model','sys_user_group_model');
    }
    function index(){
        $this->load->view('sys/user_list');
    }

    function get_list(){
        $truename = $this->input->post('truename');
        $condition = $this->sys_user_model;
        if (!empty($truename)) {
            $condition = $condition->where(array('truename'=>$truename,'user_name'=>$truename));
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

        $_check = $this->sys_user_model->count(array(
            'user_name'=>$this->input->post('user_name')
        ));
        if($_check==0){
            $_result = $this->sys_user_model->insert($_data);
            if ($_result) {
                $ot = array('code' => 0,
                    'message' => '操作成功!');
            } else {
                $ot = array('code' => 1001,
                    'message' => '操作失败!');
            }
        }else{
            $ot = array('code' => 1002 ,
            'message' => '账户号名已存在，不能重复！');

        }
        ajax_return($ot);
    }

    function edit(){
        $params = $this->input->post(NULL, TRUE);

        foreach ($params as $k => $v) {
            $_data[$k] = $v;
        }
        $_result = $this->sys_user_model->where('id',$_data['id'])->update($_data);
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
        $_arr = $this->input->post('id');
        $arr = explode(',', $_arr);
        $_result = $this->sys_user_model->where('id',$arr)->delete();
        if ($_result) {
            $ot = array('code' => 0,
                'message' => '操作成功!');
        } else {
            $ot = array('code' => 1001,
                'message' => '操作失败!');
        }
        ajax_return($ot);
    }

    function get_group(){
        $data = $this->sys_user_group_model->get_all();
        ajax_return($data);
    }

}

