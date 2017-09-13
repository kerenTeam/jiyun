<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Qcloud extends CI_Controller{

	//
    function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Shanghai");

        $this->load->helper('help_helper');
    }

	function index(){
		$time = time();

		$region = 'ap-guangzhou';




		$a = Qcloud_Hmac($time,$region);
		var_dump($a);

		// $this->load->library('Qclodu');



		// $config = array('SecretId'       => 'AKIDc6PZYWfM0Tr480mDY6VljeQ9j9NO70cZ',
		//                 'SecretKey'      => 'OchFiz32qUwBEkJhvxoT9kFYfmkcOyVr',
		//                 'RequestMethod'  => 'GET',
		//                 'DefaultRegion'  => 'cd');

		// $cvm = QcloudApi::load(QcloudApi::MODULE_CVM, $config);

		// $package = array('offset' => 0, 'limit' => 3, 'SignatureMethod' =>'HmacSHA256');

		// $a = $cvm->DescribeInstances($package);
		// // $a = $cvm->generateUrl('DescribeInstances', $package);

		// if ($a === false) {
		//     $error = $cvm->getError();
		//     echo "Error code:" . $error->getCode() . ".\n";
		//     echo "message:" . $error->getMessage() . ".\n";
		//     echo "ext:" . var_export($error->getExt(), true) . ".\n";
		// } else {
		//     var_dump($a);
		// }

	
	}


}