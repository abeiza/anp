<?php if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');

class Login extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$cek = $this->session->userdata('login_code');
		if($cek){
			Header('Location:'.base_url().'index.php/application/req_realisasi/');
		}else{
			$this->load->view('apps/login_view');
		}
	}
	
	public function action_validation(){
		$this->form_validation->set_rules('email','email','required');
		$this->form_validation->set_rules('password','password','required');
		if($this->form_validation->run() == false){
			$this->index();
		}else{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$validation = $this->ksp_model->validation_login($email,$password);
			if($validation->num_rows() == 0){
				$this->session->set_flashdata('login_result',"<div><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Sorry, Your data is Invalid, Please Try Again!</div>");
				Header('Location:'.base_url());
			}else{
				foreach($validation->result() as $login){
					$login_data['id_u'] = $login->ObjectID;
					$login_data['email'] = $login->email;
					$login_data['nama'] = $login->nama;
					$login_data['password'] = $login->password;
					$login_data['login_code'] = 'sukses_login';
					$this->session->set_userdata($login_data);
				}
				
				Header('Location:'.base_url().'index.php/application/req_realisasi/');
			}
		}
	}
	
	public function action_logout(){
		$this->session->sess_destroy();
		$cek = $this->session->userdata('login_code');
		if($cek){
			Header('Location:'.base_url().'index.php/application/main/');
		}else{
			Header('Location:'.base_url());
		}
	}
}

/*End of file login.php*/
/*Location:../controllers/application/login.php*/