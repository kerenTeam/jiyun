<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Public_Controller.php');


class Welcome extends Public_Controller {

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


	//后台首页
	public function index()
	{
		$data['page'] = "content.html";
		$data['menu'] = 'index';
		$this->load->view('index.html',$data);
	}

	//管理员列表
	function user_list(){
			//条数

		$config['per_page'] = 10;

		//获取页码

		$current_page=intval($this->uri->segment(3));//index.php 后数第4个/

		//var_dump($current_page);

			//配置

		$config['base_url'] = site_url('/Welcome/user_list');

		//分页配置

		$config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';

		$config['full_tag_close'] = '</ul>';

		$config['first_tag_open'] = '<li>';

		$config['first_tag_close'] = '</li>';

		$config['prev_tag_open'] = '<li>';

		$config['prev_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li>';

		$config['next_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="am-active"><a>';

		$config['cur_tag_close'] = '</a></li>';

		$config['last_tag_open'] = '<li>';

		$config['last_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li>';

		$config['num_tag_close'] = '</li>';

		$config['first_link']= '首页';

		$config['next_link']= '»';

		$config['prev_link']= '«';

		$config['last_link']= '末页';
		$config['num_links'] = 4;
    	
		$total = count($this->public_model->select('jy_admin_user',''));
   		$config['total_rows'] = $total;
 
		$this->load->library('pagination');//加载ci pagination类
		$listpage =  $this->public_model->select_page('jy_admin_user',$current_page,$config['per_page'],'');
		$this->pagination->initialize($config);

		$data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

		$data['page'] = 'adminList.html';
		$data['menu'] = 'user_list';
		$this->load->view('index.html',$data);
	}

	//新增管理员账户
	function add_adminuser(){
		if($_POST){
			$data['username'] = trim($this->input->post('username'));
			$data['password'] = md5(trim($this->input->post('password')));
			if($this->public_model->insert('jy_admin_user',$data)){
				//日志


				echo "<script>alert('新增成功！');window.location.href='".site_url('Welcome/user_list')."';</script>";exit;
			}else{
				echo "<script>alert('新增失败！');window.location.href='".site_url('Welcome/user_list')."';</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}


	//编辑管理员账户
	function edit_adminuser(){
		if($_POST){
			$data['username'] = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			if(!empty($password)){
				$data['password'] = md5($password);
			}
			$id = $this->input->post('user_id');
			if($this->public_model->updata('jy_admin_user','user_id',$id,$data)){
				echo "<script>alert('修改成功！');window.location.href='".site_url('Welcome/user_list')."';</script>";exit;
			}else{
				echo "<script>alert('修改失败！');window.location.href='".site_url('Welcome/user_list')."';</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}


	//banner 管理
	function bannerList(){
		//获取banner
		$data['banners'] = $this->public_model->select('jy_banner','create_time');


		$data['page'] = 'banneradmin.html';
		$data['menu'] = 'bannerList';
		$this->load->view('index.html',$data);
	}

	//新增banner
	function add_banner(){
		if($_POST){
			if(!empty($_FILES['img']['name'])){

                    $config['upload_path']      = 'upload/banner/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/bannerList')."'</script>";exit;
                    }else{
                        $data['banner_pic'] = 'upload/banner/'.$this->upload->data('file_name');
                    }
            }

			$data['banner_url'] = $this->input->post('url'); 

			if($this->public_model->insert('jy_banner',$data)){
				echo "<script>alert('新增成功！');window.location.href='".site_url('Welcome/bannerList')."'</script>";exit;
			}else{
				echo "<script>alert('新增失败！');window.location.href='".site_url('Welcome/bannerList')."'</script>";exit;
			}

		}else{
			$this->load->view('404.html');
		}
	}

	//编辑banner
	function edit_banner(){
		if($_POST){
			if(!empty($_FILES['img']['name'])){

                    $config['upload_path']      = 'upload/banner/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/bannerList')."'</script>";exit;
                    }else{
                        $data['banner_pic'] = 'upload/banner/'.$this->upload->data('file_name');
                    }
            }
			$data['banner_url'] = $this->input->post('url'); 
			$id = $this->input->post('banner_id');
			if($this->public_model->updata('jy_banner','banner_id',$id,$data)){
				echo "<script>alert('编辑成功！');window.location.href='".site_url('Welcome/bannerList')."'</script>";exit;

			}else{
				echo "<script>alert('编辑失败！');window.location.href='".site_url('Welcome/bannerList')."'</script>";exit;

			}
		}else{
			$this->load->view('404.html');
		}
	}

	//删除banner
	function del_banner(){
		$id = intval($this->uri->segment(3));
		if($id == 0){
			$this->load->view('404.html');
		}else{
			if($this->public_model->delete("jy_banner",'banner_id',$id)){
				echo "<script>alert('删除成功！');window.location.href='".site_url('Welcome/bannerList')."'</script>";exit;
			}else{
				echo "<script>alert('删除失败！');window.location.href='".site_url('Welcome/bannerList')."'</script>";exit;
			}
		}
	}

	//咨询新闻
	function news(){
		$config['per_page'] = 10;

		//获取页码

		$current_page=intval($this->uri->segment(3));//index.php 后数第4个/

		//var_dump($current_page);

			//配置

		$config['base_url'] = site_url('/Welcome/news');

		//分页配置

		$config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';

		$config['full_tag_close'] = '</ul>';

		$config['first_tag_open'] = '<li>';

		$config['first_tag_close'] = '</li>';

		$config['prev_tag_open'] = '<li>';

		$config['prev_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li>';

		$config['next_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="am-active"><a>';

		$config['cur_tag_close'] = '</a></li>';

		$config['last_tag_open'] = '<li>';

		$config['last_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li>';

		$config['num_tag_close'] = '</li>';

		$config['first_link']= '首页';

		$config['next_link']= '»';

		$config['prev_link']= '«';

		$config['last_link']= '末页';
		$config['num_links'] = 4;
    	
		$total = count($this->public_model->select('jy_news',''));
   		$config['total_rows'] = $total;
 
		$this->load->library('pagination');//加载ci pagination类
		$listpage =  $this->public_model->select_page('jy_news',$current_page,$config['per_page'],'');
		$this->pagination->initialize($config);

		$cates = $this->public_model->select_where('jy_category','type','2','');

		$data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'cates'=>$cates);

		

		$data['page'] = 'newsAdmin.html';
		$data['menu'] = 'news';
		$this->load->view('index.html',$data);
	}

	//新增咨询新闻
	function add_news(){
		if($_POST){

			$data['title'] = $this->input->post('title');	
			$data['cate_id'] = $this->input->post('cate_id');	
			$data['content'] = $this->input->post('editer');	
			if(!empty($_FILES['img']['name'])){

                    $config['upload_path']      = 'upload/news/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/news')."'</script>";exit;
                    }else{
                        $data['thumb'] = 'upload/news/'.$this->upload->data('file_name');
                    }
            }
			if($this->public_model->insert('jy_news',$data)){
				echo "<script>alert('新增成功！');window.location.href='".site_url('Welcome/news')."'</script>";exit;

			}else{
				echo "<script>alert('新增失败！');window.location.href='".site_url('Welcome/news')."'</script>";exit;
			}



		}else{
			$this->load->view('404.html');
		}
	}

	//编辑新闻咨询
	function edit_news_info(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			$data['cates'] = $this->public_model->select_where('jy_category','type','2','');
			$data['news'] = $this->public_model->select_info('jy_news','news_id',$id);
			$data['page'] = 'newsInfo.html';
			$data['menu'] = 'news';
			$this->load->view('index.html',$data);
		}
	}


	//编辑新闻操作
	function edit_news(){
		if($_POST){
	
			$data['title'] = $this->input->post('title');	
			$data['cate_id'] = $this->input->post('cate_id');	
			$data['content'] = $this->input->post('editer');
			$id = $this->input->post('news_id');	
			if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'upload/news/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/news')."'</script>";exit;
                    }else{
                        $data['thumb'] = 'upload/news/'.$this->upload->data('file_name');
                    }
            }
			if($this->public_model->updata('jy_news','news_id',$id,$data)){
				echo "<script>alert('编辑成功！');window.location.href='".site_url('Welcome/news')."'</script>";exit;
			}else{
				echo "<script>alert('编辑失败！');window.location.href='".site_url('Welcome/news')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}


	//删除新闻咨询
	function del_news(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			//获取要删除的新闻
			$news = $this->public_model->select_info('jy_news','news_id',$id);
			if(!empty($news)){
				
				if($this->public_model->delete('jy_news','news_id',$id)){
					@unlink($news['thumb']);
					echo "<script>alert('删除成功!');window.location.href='".site_url('Welcome/news')."'</script>";exit;
				}else{
					echo "<script>alert('删除失败!');window.location.href='".site_url('Welcome/news')."'</script>";exit;
				}
			}
		}
	}


	//产品
	function produc(){
		
		$config['per_page'] = 10;

		//获取页码

		$current_page=intval($this->uri->segment(3));//index.php 后数第4个/

		//配置

		$config['base_url'] = site_url('/Welcome/produc');

		//分页配置

		$config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';

		$config['full_tag_close'] = '</ul>';

		$config['first_tag_open'] = '<li>';

		$config['first_tag_close'] = '</li>';

		$config['prev_tag_open'] = '<li>';

		$config['prev_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li>';

		$config['next_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="am-active"><a>';

		$config['cur_tag_close'] = '</a></li>';

		$config['last_tag_open'] = '<li>';

		$config['last_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li>';

		$config['num_tag_close'] = '</li>';

		$config['first_link']= '首页';

		$config['next_link']= '»';

		$config['prev_link']= '«';

		$config['last_link']= '末页';
		$config['num_links'] = 4;
    	
		$total = count($this->public_model->select('jy_product',''));
   		$config['total_rows'] = $total;
 
		$this->load->library('pagination');//加载ci pagination类
		$listpage =  $this->public_model->select_page('jy_product',$current_page,$config['per_page'],'create_time');
		$this->pagination->initialize($config);
		$cates = $this->public_model->select_where('jy_category','type','1','');

		$data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'cates'=>$cates);
		//分类
		

		$data['page'] = 'producAdmin.html';
		$data['menu'] = 'produc';
		$this->load->view('index.html',$data);
	}

	//新增产品
	function add_priduc(){
		if($_POST){
		
			$data['title'] = $this->input->post('title');	
			$data['info'] = $this->input->post('info');	
			$data['cate_id'] = $this->input->post('cate_id');	
			$data['price'] = $this->input->post('price');	
			$data['content'] = $this->input->post('editer');
			if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'upload/product/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
                    }else{
                        $data['thumb'] = 'upload/product/'.$this->upload->data('file_name');
                    }
            }
			if($this->public_model->insert('jy_product',$data)){
				echo "<script>alert('新增成功！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
			}else{
				echo "<script>alert('新增失败！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}


	//编辑产品
	function edit_priductinfo(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			$data['cates'] = $this->public_model->select_where('jy_category','type','1','');


			$data['product'] = $this->public_model->select_info('jy_product','id',$id);
			$data['page'] = 'productInfo.html';
			$data['menu'] = 'produc';
			$this->load->view('index.html',$data);
		}
	}

	//编辑操作
	function eidt_product(){
		if($_POST){
			$data['title'] = $this->input->post('title');	
			$data['info'] = $this->input->post('info');	
			$data['cate_id'] = $this->input->post('cate_id');	
			$data['price'] = $this->input->post('price');	
			$data['content'] = $this->input->post('editer');
			$id = $this->input->post('id');
			if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'upload/product/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
                    }else{
                        $data['thumb'] = 'upload/product/'.$this->upload->data('file_name');
                    }
            }
			if($this->public_model->updata('jy_product','id',$id,$data)){
				echo "<script>alert('编辑成功！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
			}else{
				echo "<script>alert('编辑失败！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}


	//修改产品状态
	function edit_productState(){
		$id = intval($this->uri->segment('3'));
		$state = intval($this->uri->segment('4'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			$data['state'] = $state;
			if($this->public_model->updata('jy_product','id',$id,$data)){
				echo "<script>alert('操作成功！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
			}
			
		}
	}

	//删除产品
	function del_porduct(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			$pro = $this->public_model->select_info('jy_product','id',$id);
			if($this->public_model->delete('jy_product','id',$id)){
				@unlink($pro['thumb']);
				echo "<script>alert('操作成功！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('Welcome/produc')."'</script>";exit;
			}
			
		}
	}


	//上传图片
	function upload(){
		// file_put_contents('text.log', var_export(array_values($_FILES),TRUE)."\r\n",FILE_APPEND);
		foreach(array_values($_FILES) as $k=>$val){
			$img['img'.$k+1] = $val;
		//	file_put_contents('text.log', var_export($img['img'.$k+1]['name'],TRUE)."\r\n",FILE_APPEND);
			if(!empty($img['img'.$k+1]['name'])){
					$type = substr($img['img'.$k+1]['name'], strrpos($img['img'.$k+1]['name'], ".")+1);
					$path = "upload/editer/" . date('Y-m-d_His').$k.'.'.$type;
					file_put_contents('text.log', $type,FILE_APPEND);
                  if(move_uploaded_file($img['img'.$k+1]["tmp_name"],$path )){
					// file_put_contents('text.log', '1',FILE_APPEND);
					$data['data'][$k] = $path;
					$data['error'] = '0';
				  } else{
						$data['error'] = '1';
						$data['data']= '';
				  }
            }
		}
		echo json_encode($data);
	}


	//分类界面
	function cates(){
		$cates = $this->public_model->select('jy_category','');
		$data['cates'] = subtree($cates);

		//获取顶级分类
		$data['cate'] = $this->public_model->select_where('jy_category','pid','0','');

		$data['page'] = 'typeAdmin.html';
		$data['menu'] = 'cates';
		$this->load->view('index.html',$data);
	}

	//新增分类
	function add_cates(){
		if($_POST){
			$data['cate_name'] = $this->input->post('catename');
			$data['type'] = $this->input->post('type');
			$data['pid'] = $this->input->post('pid');
			$data['info'] = $this->input->post('info');

			if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'upload/banner/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/cates')."'</script>";exit;
                    }else{
                        $data['icon'] = 'upload/banner/'.$this->upload->data('file_name');
                    }
            }


			if($this->public_model->insert('jy_category',$data)){
				echo "<script>alert('新增成功！');window.location.href='".site_url('Welcome/cates')."'</script>";exit;
			}else{
				echo "<script>alert('新增失败！');window.location.href='".site_url('Welcome/cates')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}

	//编辑分类
	function edit_cates(){
		if($_POST){
			$data['cate_name'] = $this->input->post('catename');
			$data['type'] = $this->input->post('type');
			$data['pid'] = $this->input->post('pid');
			$id = $this->input->post('cate_id');
			$data['info'] = $this->input->post('info');

			if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'upload/banner/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/cates')."'</script>";exit;
                    }else{
                        $data['icon'] = 'upload/banner/'.$this->upload->data('file_name');
                    }
            }


			if($this->public_model->updata('jy_category','cate_id',$id,$data)){
				echo "<script>alert('编辑成功！');window.location.href='".site_url('Welcome/cates')."'</script>";exit;
			}else{
				echo "<script>alert('编辑失败！');window.location.href='".site_url('Welcome/cates')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}

	//删除分类
	function del_cates(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			if($this->public_model->delete('jy_category','cate_id',$id)){
				echo "<script>alert('删除成功！');window.location.href='".site_url('Welcome/cates')."'</script>";exit;
			}else{
				echo "<script>alert('删除失败！');window.location.href='".site_url('Welcome/cates')."'</script>";exit;
			}
		}
	}

	//合作伙伴
	function parnter(){
		$config['per_page'] = 10;

		//获取页码

		$current_page=intval($this->uri->segment(3));//index.php 后数第4个/

		//配置

		$config['base_url'] = site_url('/Welcome/produc');

		//分页配置

		$config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';

		$config['full_tag_close'] = '</ul>';

		$config['first_tag_open'] = '<li>';

		$config['first_tag_close'] = '</li>';

		$config['prev_tag_open'] = '<li>';

		$config['prev_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li>';

		$config['next_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="am-active"><a>';

		$config['cur_tag_close'] = '</a></li>';

		$config['last_tag_open'] = '<li>';

		$config['last_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li>';

		$config['num_tag_close'] = '</li>';

		$config['first_link']= '首页';

		$config['next_link']= '»';

		$config['prev_link']= '«';

		$config['last_link']= '末页';
		$config['num_links'] = 4;
    	
		$total = count($this->public_model->select('jy_parnter',''));
   		$config['total_rows'] = $total;
 
		$this->load->library('pagination');//加载ci pagination类
		$listpage =  $this->public_model->select_page('jy_parnter',$current_page,$config['per_page'],'create_time');
		$this->pagination->initialize($config);

		$data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());
		//分类
		
		$data['page'] = 'parnterAdmin.html';
		$data['menu'] = 'parnter';
		$this->load->view('index.html',$data);
	}

	//新增合作伙伴
	function add_parnter(){
		if($_POST){
			$data['name'] = $this->input->post('name');	
			$data['url'] = $this->input->post('url');	
			if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'upload/parnter/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/parnter')."'</script>";exit;
                    }else{
                        $data['logo'] = 'upload/parnter/'.$this->upload->data('file_name');
                    }
            }
			if($this->public_model->insert('jy_parnter',$data)){
				echo "<script>alert('新增成功！');window.location.href='".site_url('Welcome/parnter')."'</script>";exit;
			}else{
				echo "<script>alert('新增失败！');window.location.href='".site_url('Welcome/parnter')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}

	//编辑合作伙伴
	function edit_parnter(){
		if($_POST){
			$data['name'] = $this->input->post('name');	
			$data['url'] = $this->input->post('url');	
			$id = $this->input->post('id');	
			if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'upload/parnter/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/parnter')."'</script>";exit;
                    }else{
                        $data['logo'] = 'upload/parnter/'.$this->upload->data('file_name');
                    }
            }
			if($this->public_model->updata('jy_parnter','id',$id,$data)){
				echo "<script>alert('新增成功！');window.location.href='".site_url('Welcome/parnter')."'</script>";exit;
			}else{
				echo "<script>alert('新增失败！');window.location.href='".site_url('Welcome/parnter')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}

	//删除合作伙伴
	function del_parnter(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			if($this->public_model->delete('jy_parnter','id',$id)){
				echo "<script>alert('删除成功！');window.location.href='".site_url('Welcome/parnter')."'</script>";exit;
			}else{
				echo "<script>alert('删除失败！');window.location.href='".site_url('Welcome/parnter')."'</script>";exit;
			}
		}
	}


	//系统设置
	function systemSet(){
		$data['system'] = $this->public_model->select_info('jy_system','id','1','');
	
		$data['page'] = 'systemSet.html';
		$data['menu'] = 'systemSet';
		$this->load->view('index.html',$data);
	}

	//修改系统设置
	function edit_system(){
		if($_POST){
			$data['seotitle'] = $this->input->post('seotitle');	
			$data['keywords'] = $this->input->post('keywords');	
			$data['record'] = $this->input->post('record');	
			if(!empty($_FILES['logo']['name'])){
                    $config['upload_path']      = 'upload/banner/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('logo')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/systemSet')."'</script>";exit;
                    }else{
                        $data['logo'] = 'upload/banner/'.$this->upload->data('file_name');
                    }
            }
			if(!empty($_FILES['code']['name'])){
                    $config['upload_path']      = 'upload/banner/';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg|webp';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('code')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('Welcome/systemSet')."'</script>";exit;
                    }else{
                        $data['code'] = 'upload/banner/'.$this->upload->data('file_name');
                    }
            }
			if($this->public_model->updata('jy_system','id','1',$data)){
				echo "<script>alert('编辑成功！');window.location.href='".site_url('Welcome/systemSet')."'</script>";exit;
			}else{
				echo "<script>alert('编辑失败！');window.location.href='".site_url('Welcome/systemSet')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}

	}




}
