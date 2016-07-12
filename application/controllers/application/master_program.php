<?php if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	class Master_Program extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->library('ci_phpgrid');
				$data['phpgrid'] = $this->ci_phpgrid->master_program();
				
				$this->load->view('global/header_view',$data);
				$this->load->view('apps/master_program_view',$data);
				$this->load->view('global/footer_view',$data);
			}
		}
	}
/*End of file master_program.php*/
/*Location:../application/master_program.php*/