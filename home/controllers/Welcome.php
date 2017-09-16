<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('welcome_model');
		$this->load->helper('help_helper');
		//

	}


	public function index()
	{
		//获取bnner
		$data['banner'] = $this->welcome_model->select('jy_banner','');

		//获取合作伙伴
		$data['parnter'] = $this->welcome_model->select('jy_parnter','');

		$data['system'] = $this->welcome_model->select_info('jy_system','id','1','');

		//获取新闻
		$news_cate = $this->welcome_model->select_limit('jy_category','type','2','','3');
		foreach($news_cate as $k=>$v){
			if($k > '2'){
				breack;
			}else{
				$news_cate[$k]['news'] = $this->welcome_model->select_limit('jy_news','cate_id',$v['cate_id'],'create_time','5');
			}
		}

		$data['news'] = $news_cate;

		$this->load->view('index.html',$data);
		$this->load->view('footer.html');
	}

	//关于我们
	function about(){
		$data['system'] = $this->welcome_model->select_info('jy_system','id','1','');

		$this->load->view('about.html',$data);
		$this->load->view('footer.html');
	}

	//解决方案
	function program(){
		$data['system'] = $this->welcome_model->select_info('jy_system','id','1','');

		$this->load->view('program.html',$data);
		$this->load->view('footer.html');
	}


	//新闻详情
	function news_content(){
		$id = intval($this->uri->segment(3));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			$data['system'] = $this->welcome_model->select_info('jy_system','id','1','');

			$data['news'] = $this->welcome_model->select_info('jy_news','news_id',$id);

			//获取新闻
			$news_cate = $this->welcome_model->select_limit('jy_category','type','2','','2');
			foreach($news_cate as $k=>$v){
				if($k > '2'){
					breack;
				}else{
					$news_cate[$k]['news'] = $this->welcome_model->select_limit('jy_news','cate_id',$v['cate_id'],'create_time','5');
				}
			}


			$data['cates'] = $news_cate;
			$this->load->view('articleDetails.html',$data);
			$this->load->view('footer.html');
		}
	}

	//购买云主机
	function CSlist(){

		// $time = time();
		// $region = "gz";

		// $key = urlencode(Qcloud_Hmac($time,$region));
		//ZdgEsUAmIrWff9j%2FqV1LecMuIyI%3D
		//ZdgEsUAmIrWff9j%2FqV1LecMuIyI%3D

		// $secretKey = 'Gu5t9xGARNpq86cd98joQYCN3Cozk1qA';
		// $srcStr = 'cvm.api.qcloud.com/v2/index.php?Action=DescribeInstances&Nonce=11886&Region=gz&SecretId=AKIDz8krbsJ5yKBZQpn74WFkmLPx3gnPhESA&SignatureMethod=HmacSHA256&Timestamp=1465185768&instanceIds.0=ins-09dx96dg&limit=20&offset=0';
		// $signStr = base64_encode(hash_hmac('sha256', $srcStr, $secretKey, true));
		// echo $signStr;
		//获取实例
// 		$url = "https://cvm.api.qcloud.com/v2/index.php?Nonce=11886&Region=gz&Timestamp=".$time."&Action=DescribeRegions&SecretId=".SECRETID."&Version=2017-03-12&Signature=".$key;

// // //
// $a = json_decode(file_get_contents($url),true);
// var_dump($a);

// 		exit;
		//j8eP6UmoSPhT5j86kl4V8LHVfCM=
		//1qN5lKUd7a1UXMgr/UupoVhuYTZ9r4D63ipxHP+Ia/4=

		//密钥

		//获取配置

		//地域

		//公网宽带

		//时长

	


		$data['system'] = $this->welcome_model->select_info('jy_system','id','1','');

		$this->load->view('cloudServer/productList.html',$data);
		$this->load->view('footer.html');
	}

	// idc
	function idcFun(){
		$data['system'] = $this->welcome_model->select_info('jy_system','id','1','');

		$this->load->view('product/idcService.html',$data);
		$this->load->view('footer.html');
	}
	/*安全增值服务*/
	function safetyFun(){
		$data['system'] = $this->welcome_model->select_info('jy_system','id','1','');

		$this->load->view('product/safety.html',$data);
		$this->load->view('footer.html');
	}



	//解决方案


}
