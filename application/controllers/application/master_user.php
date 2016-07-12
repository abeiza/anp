<?php if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	class Master_User extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->library('ci_phpgrid');
				$data['phpgrid'] = $this->ci_phpgrid->master_user();
				
				$this->load->view('global/header_view',$data);
				$this->load->view('apps/master_user_view',$data);
				$this->load->view('global/footer_view',$data);
			}
		}
		
		function profile_account(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$user = $this->db->query("select * from tbl_ANPKSP_MsUser where ObjectID='".$this->session->userdata('id_u')."'");
				foreach($user->result() as $db){
					$data['id'] = $db->ObjectID;
					$data['name'] = $db->nama;
					$data['email'] = $db->email;
					$data['old'] = $db->password;
				}
				
				$this->load->view('global/header_view');
				$this->load->view('apps/profile_view',$data);
				$this->load->view('global/footer_view');
			}
		}
		
		function update_account(){
			$this->form_validation->set_rules('id','id user','required');
			$this->form_validation->set_rules('name','your name','required');
			$this->form_validation->set_rules('email','your email','required');
			$this->form_validation->set_rules('old','old password','required');
			$this->form_validation->set_rules('new','new password','matches[confirm]');
			$this->form_validation->set_rules('confirm','confirm password','matches[new]');
			if($this->form_validation->run() == false){
				$this->profile_account();
			}else{
				$id = $this->input->post('id');
				
				$data['nama'] = $this->input->post('name');
				$data['email'] = $this->input->post('email');
				if($this->input->post('new')){
					$data['password'] = $this->input->post('new');
				}else{
					$data['password'] = $this->input->post('old');
				}
				
				$update = $this->ksp_model->update_data('tbl_ANPKSP_MsUser','ObjectID',$id,$data);
				if(!$update){
					$this->session->set_flashdata('update_result',"<div style='display:inline;'><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Update data was failed!</div>");
					Header('Location:'.base_url().'index.php/application/master_user/profile_account/');
				}else{
					$this->session->set_flashdata('update_result',"<div style='display:inline;'><i class='fa fa-check-circle' style='margin-right:3px;color:#1d9d74'></i> Update data successfully!</div>");
					Header('Location:'.base_url().'index.php/application/master_user/profile_account/');
				}
			}
		}
	}
/*End of file master_user.php*/
/*Location:../application/master_user.php*/