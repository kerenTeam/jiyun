<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// 登陆控制器
class Login extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('member_model');
    }
    //登陆
    function login_up(){
        if($_POST){
            $name = trim($this->input->post('name'));
            $password = trim($this->input->post('password'));

            if(empty($name || empty($password))){
                $error['error'] = "用户名或密码不能为空！";
                $this->load->view('login.html',$error);
            }else{
                $user = $this->member_model->userinfo('username',$name);
                if(!empty($user)){
                    if($user['password'] != md5($password)){
                        $error['error'] = "密码错误!请重新登陆！";
                        $this->load->view('login.html',$error);
                    }else{    
                        $this->session->set_userdata('users',$user);
                        redirect('Welcome/index');
                    }
                }else{
                    $error['error'] = "该用户不存在，请重新登陆！";
                    $this->load->view('login.html',$error);
                }
            }
        }else{

            $this->load->view('login.html');
        }
    }
    //退出登录
    function login_out(){
        unset($_SESSION['users']);
        redirect('login/login_up');

    }



}









