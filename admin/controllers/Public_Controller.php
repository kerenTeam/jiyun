<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 公用控制器 */
class Public_Controller extends CI_Controller
{
    function __construct() {
        parent::__construct();
        //var_dump($_SESSION);
        date_default_timezone_set("Asia/Shanghai");

        $this->load->model('public_model');
        $this->load->helper('help_helper');
        if(!isset($_SESSION['users'])){
			echo "<script>alert('您还没有登陆！');window.location.href='".site_url('/Login/login_up')."';</script>";
			exit;
		}



    }


}













?>