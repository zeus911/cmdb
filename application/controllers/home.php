<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{

    function index(){
        $this->load->model('sys/module_model','sys_module_model');
        $current_user = get_login();
        $data['menu'] = $this->sys_module_model->getMenu($current_user['sys_group_id']);
        redirect('');
    }

    public function login(){
        if (!empty($_POST)) {
            $_username = $this->input->post("user_name");
            $_password = $this->input->post("password");
            $this->load->model("sys/user_model",'sys_user_model');
            $this->load->library('ldap');
            $ldap_res = $this->ldap->bind($_username,$_password);
            $_admin = $this->sys_user_model->where(array("user_name" => $_username))->get();
            if($ldap_res == 1){
                if(empty($_admin)){
                    $this->sys_user_model->insert(array('user_name'=>$_username));
                    set_login($_admin);
                }
                $ot = array('code' => 0,
                    'message' => '登录成功!');
            }else{
                $ot = array('code' => 1002,
                    'message' => '账号或密码错误!');
            }
            ajax_return($ot);
        } else {
            if(is_login()){
                redirect(site_url('home/index'));
            }else{
                $this->load->view('login');
            }
        }
    }

    function logout(){
        logout();
        $login = site_url("home/login");
        header("Location: $login");

    }
}
