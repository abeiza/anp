<?php if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	class Main extends CI_Controller{
		public function __construct(){
			parent::__construct();
		}
		
		public function index(){
			$cek = $this->session->userdata('login_code');
			if($cek){
				$this->load->view("apps/home_view");
			}else{
				$this->session->set_flashdata('login_result','Sorry Login dulu boss');
				Header('Location:'.base_url());
			}
		}
	}
/*End of file main.php*/
/*Location:../application/controller/application/main.php*/