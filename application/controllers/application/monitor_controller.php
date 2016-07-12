<?php if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	class Monitor_Controller extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->library('ci_phpgrid');
				$data['phpgrid'] = $this->ci_phpgrid->monitoring();
				
				$this->load->view('global/header_view',$data);
				$this->load->view('apps/monitoring_view',$data);
				$this->load->view('global/footer_view',$data);
			}
		}
		
		function force_close(){
			$data = $_POST['selectedRows'];

			foreach($data as $d){
				 //echo $d.'<br>';
				 $data1['Req_Status'] = 'Close';
				 $query = $this->ksp_model->update_data('tbl_ANPKSP_TransANP','ObjectID',$d,$data1);
			}
			 
			 
			 $response_array['status'] = 'success'; 
			 
			 header('Content-type: application/json');
			 echo json_encode($response_array);
		}
	}
/*End of file monitor_controller.php*/
/*Location:.application/controllers/application/monitor_controller.php*/