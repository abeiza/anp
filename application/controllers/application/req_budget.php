<?php if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	class Req_Budget extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->library('ci_phpgrid');
				$data['phpgrid'] = $this->ci_phpgrid->budget();
				
				$this->load->view('global/header_view',$data);
				$this->load->view('apps/req_budget_no_modify_view',$data);
				$this->load->view('global/footer_view',$data);
			}
		}
		
		function upload_data(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->view('global/header_view');
				$this->load->view('apps/req_budget_upload');
				$this->load->view('global/footer_view');	
			}
		}
		
		function proses_upload(){
		//	$test =  $_FILES['upload']['name'];
		//	echo $test;
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$test = $_FILES['excel']['name'];
				if(substr($test,-3) == 'xls'){
				$config['upload_path'] = './temp_upload/';
				$config['allowed_types'] = '*';
				$config['max_size'] = '10000';
				$this->load->library('upload', $config);
	 
				if(!$this->upload->do_upload('excel')){
					echo $this->upload->display_errors(); die();
				}else{
				  $upload_data = $this->upload->data();
	 
				  $this->load->library('Excel_reader');
	 
				  //$this->excel_reader->setOutputEncoding('230787');
				  $file = $upload_data['full_path'];
				  $this->excel_reader->read($file);
				  error_reporting(E_ALL ^ E_NOTICE);
				  
				  $data = $this->excel_reader->sheets[0];
				  $warning = 0;
				  $dataexcel = Array();
				  for ($i = 2; $i <= $data['numRows']; $i++) {
					if ($data['cells'][$i][2] == '')
					   break;
					   $dataexcel[$i - 2]['Req_No'] = $data['cells'][$i][1];
					   $dataexcel[$i - 2]['Req_Date'] = $data['cells'][$i][2];
					   $dataexcel[$i - 2]['Purpose'] = $data['cells'][$i][3];
					   $dataexcel[$i - 2]['spec'] = $data['cells'][$i][4];
					   $dataexcel[$i - 2]['Manage_By'] = $data['cells'][$i][5];
					   $dataexcel[$i - 2]['Period_Start'] = $data['cells'][$i][6];
					   $dataexcel[$i - 2]['Period_End'] = $data['cells'][$i][7];
					   $dataexcel[$i - 2]['Req_By'] = $data['cells'][$i][8];
					   $dataexcel[$i - 2]['ID_Program'] = $data['cells'][$i][9];
					   $dataexcel[$i - 2]['ID_Brand'] = $data['cells'][$i][10];
					   $dataexcel[$i - 2]['Budget_Unit'] = $data['cells'][$i][11];
					   $dataexcel[$i - 2]['Budget_Price'] = $data['cells'][$i][12];
					   $dataexcel[$i - 2]['Budget_Amount'] = $data['cells'][$i][13];
					   /*$cek_req = $this->db->query("select * from tbl_ANPKSP_TransANP where Req_No='".$data['cells'][$i][2]."'");
					   if($cek_req->num_rows() < 1){
						  // break;
						   $warning++;
						   echo "<script>alert('Sorry No. Request is invalid, Please check your data upload');</script>";
						   echo "<script>window.location = '".base_url()."/index.php/application/req_realisasi/upload_data/';</script>";
					   }*/
				  }
				  if($warning == 0){
					$this->load->model('ksp_model');
					$notif = $this->ksp_model->loaddata_req($dataexcel);  
					
					echo "<script>alert('".$notif."');</script>";
					echo "<script>window.location = '".base_url()."index.php/application/req_budget/upload_data/';</script>";
				  }
				  
				 
				  $file = $upload_data['file_name'];
				  $path = './temp_upload/' . $file;
				  unlink($path);
				  
				  }
				}else{
					echo "<script>alert('Sorry, The Format File must be Excel 2003 (.xls)');</script>";
					echo "<script>window.location = '".base_url()."index.php/application/req_realisasi/upload_data/';</script>";
				}
			//$this->session->set_flashdata('upload_result','');
			//Header('Location:'.base_url().'index.php/dashboard/dashboard_c/result/'.$tgl.'/'.$kode.'/'.$bulan.'/'.$tahun);
			}
		}
		
		function add_request(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->library('ci_phpgrid');
				$data['phpgrid'] = $this->ci_phpgrid->add_item();
				
				$this->load->view('global/header_view');
				$this->load->view('apps/req_budget_add',$data);
				$this->load->view('global/footer_view');
			}
		}
		
		function search_result(){
			$result = $this->uri->segment_array(); 
			$s1 = $result[4];
			$s2 = urldecode($result[5]);
			$s3 = $result[6];
			$s4 = urldecode($result[7]);
			
			
			
			$page = $this->uri->segment(8);
			$limit = 5;
			if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			}
			
			if($s4 == 'none' and $s2 != 'none'){
				$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status='".$s2."'");
			}else if($s2 == 'none' and $s4 != 'none'){
				$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%'");
			}else if($s4 == 'none' and $s2 == 'none'){
				$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program");
			}else{
				$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%' and tbl_ANPKSP_TransANP.Req_Status='".$s2."'");
			}
			
			$config['total_rows'] = $budget->num_rows();
			$config['base_url'] = base_url()."index.php/application/Req_Budget/search_result/status/".$s2."/search/".$s4;
			$config['per_page'] = $limit;
			$config['uri_segment'] = 8;
			$config['full_tag_open'] = "<div class='pagination'><ul>";
			$config['full_tag_close'] = "</ul></div>";
			
			$config['next_link'] = "Next &gt;";
			$config['next_tag_open'] = "<li>";
			$config['next_tag_close'] = "</li>";
			
			$config['prev_link'] = "&lt; Prev";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tag_close'] = "</li>";
			
			$config['first_link'] = "<span class='paging-arrow'>&laquo; First</span>";
			$config['first_tag_open'] = "<li>";
			$config['first_tag_close'] = "</li>";
			
			$config['last_link'] = "<span class='paging-arrow'>Last &raquo;</span>";
			$config['last_tag_open'] = "<li>";
			$config['last_tag_close'] = "</li>";

			$config['cur_tag_open'] = "<li><span style='color:#fff;background-color:#808CA0; padding: 5px 10px;'>";
			$config['cur_tag_close'] = "</span></li>";
			
			$config['num_tag_open'] = "<li>";
			$config['num_tag_close'] = "</li>";
			
			$config['num_links'] = 2;
			
			$this->pagination->initialize($config);
			$data['paging'] = $this->pagination->create_links();
			
			if($s4 == 'none' and $s2 != 'none'){
				$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status='".$s2."') tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status='".$s2."' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
			}else if($s2 == 'none' and $s4 != 'none'){
				$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_No like '%".$s4."%') tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
			}else if($s4 == 'none' and $s2 == 'none'){
				$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP) tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
			}else{
				$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_No like '%".$s4."%' and Req_Status='".$s2."') tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%' and tbl_ANPKSP_TransANP.Req_Status='".$s2."' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
			}
		
			//$data['num'] = '-'.$s2.'- and -'.$s4.'-';
			$this->load->view('global/header_view');
			$this->load->view('apps/req_budget_view',$data);
			$this->load->view('global/footer_view');
		}
		
		function grid_modify_filter($str){	
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				if($this->input->post('status')){
					$status = $this->input->post('status');
				}else{
					$status = 'none';
				}
				
				if($this->input->post('search')){
					$search = $this->input->post('search');
				}else{
					$search = 'none';
				}
				
				
				$array = array('status' => $status, 'search' => $search);
				$str = $this->uri->assoc_to_uri($array);
				//if($search == '/'){
					redirect('application/req_budget/search_result/'.$str);
				//}else{
				//	redirect('req_budget/search_result/'.$str);
				//}
				/*$page = $this->uri->segment(5);
				$limit = 3;
				if(!$page){
					$offset = 0;
				}else{
					$offset = $page;
				}
				
				if($search == ''){
					$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status='".$filter."'");
				}else if($filter == ''){
					$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$search."%'");
				}else if($search == '' and $filter == ''){
					$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program");
				}else{
					$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$search."%' and tbl_ANPKSP_TransANP.Req_Status='".$filter."'");
				}
				
				$config['total_rows'] = $budget->num_rows();
				$config['base_url'] = base_url()."index.php/application/Req_Budget/grid_modify_filter/index/";
				$config['per_page'] = $limit;
				$config['uri_segment'] = 5;
				$config['full_tag_open'] = "<div class='pagination'><ul>";
				$config['full_tag_close'] = "</ul></div>";
				
				$config['next_link'] = "Next &gt;";
				$config['next_tag_open'] = "<li>";
				$config['next_tag_close'] = "</li>";
				
				$config['prev_link'] = "&lt; Prev";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tag_close'] = "</li>";
				
				$config['first_link'] = "<span class='paging-arrow'>&laquo; First</span>";
				$config['first_tag_open'] = "<li>";
				$config['first_tag_close'] = "</li>";
				
				$config['last_link'] = "<span class='paging-arrow'>Last &raquo;</span>";
				$config['last_tag_open'] = "<li>";
				$config['last_tag_close'] = "</li>";

				$config['cur_tag_open'] = "<li><span style='color:#fff;background-color:#808CA0; padding: 5px 10px;'>";
				$config['cur_tag_close'] = "</span></li>";
				
				$config['num_tag_open'] = "<li>";
				$config['num_tag_close'] = "</li>";
				
				$config['num_links'] = 2;
				
				$this->pagination->initialize($config);
				$data['paging'] = $this->pagination->create_links();
				
				if($search == ''){
					$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status='".$filter."') tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status='".$filter."' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				}else if($filter == ''){
					$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP) tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$search."%' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				}else if($search == '' and $filter == ''){
					$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP) tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				}else{
					$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP) tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$search."%' and tbl_ANPKSP_TransANP.Req_Status='".$filter."' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				}
			
				$data['num'] = $budget->num_rows();
				$this->load->view('global/header_view');
				$this->load->view('apps/req_budget_view',$data);
				$this->load->view('global/footer_view');*/
			}
		}
		
		function action_add(){
			$this->form_validation->set_rules('req_no','Request No','required');
			$this->form_validation->set_rules('brand','Brand','required');
			$this->form_validation->set_rules('program','Program','required');
			$this->form_validation->set_rules('period_start','Period Start','required');
			$this->form_validation->set_rules('period_end','Period End','required');
			$this->form_validation->set_rules('kode','Distributor','required');
			$this->form_validation->set_rules('budget_unit','Budget Unit','required');
			$this->form_validation->set_rules('budget_amount','Budget Amount','required');
			if($this->form_validation->run() == false){
				$this->add_request();
			}else{
				$data['ObjectID'] = $this->input->post('req_id');
				$data['Req_No'] = $this->input->post('req_no');
				$data['Req_Date'] = date("Y-m-d H:i:s");
				$data['ID_Brand'] = $this->input->post('brand');
				$data['Req_By'] = $this->input->post('req_by');
				$data['Manage_By'] = $this->input->post('manage_by');
				$data['ID_Program'] = $this->input->post('program');
				$data['Period_Start'] = $this->input->post('period_start');
				$data['Period_End'] = $this->input->post('period_end');
				$data['Kode_Distributor'] = $this->input->post('kode');
				$query = $this->db->query("select CustomerName from View_ADI_Qlik_SalesOrg where CustomerID='".$this->input->post('kode')."'");
				foreach($query->result() as $db){
					$data['Nama_Distributor'] = $db->CustomerName;
				}
				$data['Total_Unit'] = $this->input->post('budget_unit');
				$data['Total_Amount'] = $this->input->post('budget_amount');
				$data['Real_Price'] = '0';
				$data['Real_Unit'] = '0';
				$data['Real_Amount'] = '0';
				$data['CreatedBy'] = $this->session->userdata('nama');
				$data['CreatedDate'] = date("Y-m-d H:i:s");
				//$data['Update_Version'] = $this->input->post();
				//$data['Req_Status'] = $this->input->post();
				
				$insert = $this->ksp_model->insert_data('tbl_ANPKSP_TransANP',$data);
				if(!$insert){
					$this->session->set_flashdata('add_result',"<div style='display:inline;'><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Insert data was failed!</div>");
					Header('Location:'.base_url().'index.php/application/req_budget/add_request/');
				}else{
					$this->session->set_flashdata('add_result',"<div style='display:inline;'><i class='fa fa-check-circle' style='margin-right:3px;color:#1d9d74'></i> Inserted data successfully!</div>");
					Header('Location:'.base_url().'index.php/application/req_budget/add_request/');
				}
			}
		} 
		
		function update_request($id){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$id = $this->uri->segment(4);
				
				$request = $this->db->query("Select * from tbl_ANPKSP_TransANP where ObjectID='".$id."'");
				foreach($request->result() as $db){
					$data['Req_ID'] = $db->ObjectID;
					$data['Req_No'] = $db->Req_No;
					$data['ID_Brand'] = $db->ID_Brand;
					$data['Req_By'] = $db->Req_By;
					$data['Manage_By'] = $db->Manage_By;
					$data['ID_Program'] = $db->ID_Program;
					$data['Period_Start'] = $db->Period_Start;
					$data['Period_End'] = $db->Period_End;
					$data['Kode_Distributor'] = $db->Kode_Distributor;
					//$data['Nama_Distributor'] = $db->Nama_Distributor;
					//$data['Seq_No'] = $db->Seq_No;
					//$data['Purpose'] = $db->Purpose;
					//$data['Spec'] = $db->Spec;
					//$data['Budget_Price'] = $db->Budget_Price;
					//$data['Budget_Unit'] = $db->Budget_Unit;
					//$data['Budget_Amount'] = $db->Budget_Amount;
				}
				$this->load->view('global/header_view');
				$this->load->view('apps/req_budget_edit',$data);
				$this->load->view('global/footer_view');
			}
		}
		
		function action_edit($id){
			$this->form_validation->set_rules('req_no','Request No','required');
			$this->form_validation->set_rules('brand','Brand','required');
			$this->form_validation->set_rules('program','Program','required');
			$this->form_validation->set_rules('period_start','Period Start','required');
			$this->form_validation->set_rules('period_end','Period End','required');
			$this->form_validation->set_rules('kode','Distributor','required');
			$this->form_validation->set_rules('budget_unit','Budget Unit','required');
			$this->form_validation->set_rules('budget_amount','Budget Amount','required');
			if($this->form_validation->run() == false){
				$this->update_request($this->uri->segment(4));
			}else{
				$id = $this->uri->segment(4);
				//$data['Req_Date'] = date("Y-m-d H:i:s");
				$data['Req_No'] = $this->input->post('req_no');
				$data['Req_Date'] = date("Y-m-d H:i:s");
				$data['ID_Brand'] = $this->input->post('brand');
				$data['Req_By'] = $this->input->post('req_by');
				$data['Manage_By'] = $this->input->post('manage_by');
				$data['ID_Program'] = $this->input->post('program');
				$data['Period_Start'] = $this->input->post('period_start');
				$data['Period_End'] = $this->input->post('period_end');
				$data['Kode_Distributor'] = $this->input->post('kode');
				$query = $this->db->query("select CustomerName from View_ADI_Qlik_SalesOrg where CustomerID='".$this->input->post('kode')."'");
				foreach($query->result() as $db){
					$data['Nama_Distributor'] = $db->CustomerName;
				}
				$data['Total_Unit'] = $this->input->post('budget_unit');
				$data['Total_Amount'] = $this->input->post('budget_amount');
				
				//$data['Real_Price'] = $this->input->post();
				//$data['Real_Unit'] = $this->input->post();
				//$data['Real_Amount'] = $this->input->post();
				$data['UpdateBy'] = $this->session->userdata('nama');
				$data['UpdateDate'] = date("Y-m-d H:i:s");
				//$data['Update_Version'] = $this->input->post();
				//$data['Req_Status'] = $this->input->post();
				
				$update = $this->ksp_model->update_data('tbl_ANPKSP_TransANP', 'ObjectID', $id, $data);
				if(!$update){
					$this->session->set_flashdata('update_result',"<div style='display:inline;'><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Update data was failed!</div>");
					Header('Location:'.base_url().'index.php/application/Req_Budget/update_request/'.$id);
				}else{
					$this->session->set_flashdata('update_result',"<div style='display:inline;'><i class='fa fa-check-circle' style='margin-right:3px;color:#1d9d74'></i> Update data successfully!</div>");
					Header('Location:'.base_url().'index.php/application/Req_Budget/update_request/'.$id);
				}
			}
		} 
		
		function delete_request($id){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$id = $this->uri->segment(4);
				$query = $this->db->query("update tbl_ANPKSP_TransANP set Req_Status='Canceled', UpdateBy='".$this->session->userdata('nama')."' where ObjectID='".$id."'");
				if($query){
					$this->session->set_flashdata('delete_result',"<div style='display:inline;'><i class='fa fa-check-circle' style='margin-right:3px;color:#1d9d74'></i> The record was deleted!</div>");
					Header('Location:'.base_url().'index.php/application/req_budget/grid_modify/');
				}else{
					$this->session->set_flashdata('delete_result',"<div style='display:inline;'><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Delete process was failed!</div>");
					Header('Location:'.base_url().'index.php/application/req_budget/grid_modify/');
				}
			}
		}
		
		function grid_modify(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$page = $this->uri->segment(5);
				$limit = 5;
				if(!$page){
					$offset = 0;
				}else{
					$offset = $page;
				}
				$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program");
				
				$config['total_rows'] = $budget->num_rows();
				$config['base_url'] = base_url()."index.php/application/Req_Budget/grid_modify/index/";
				$config['per_page'] = $limit;
				$config['uri_segment'] = 5;
				$config['full_tag_open'] = "<div class='pagination'><ul>";
				$config['full_tag_close'] = "</ul></div>";
				
				$config['next_link'] = "Next &gt;";
				$config['next_tag_open'] = "<li>";
				$config['next_tag_close'] = "</li>";
				
				$config['prev_link'] = "&lt; Prev";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tag_close'] = "</li>";
				
				$config['first_link'] = "<span class='paging-arrow'>&laquo; First</span>";
				$config['first_tag_open'] = "<li>";
				$config['first_tag_close'] = "</li>";
				
				$config['last_link'] = "<span class='paging-arrow'>Last &raquo;</span>";
				$config['last_tag_open'] = "<li>";
				$config['last_tag_close'] = "</li>";

				$config['cur_tag_open'] = "<li><span style='color:#fff;background-color:#808CA0; padding: 5px 10px;'>";
				$config['cur_tag_close'] = "</span></li>";
				
				$config['num_tag_open'] = "<li>";
				$config['num_tag_close'] = "</li>";
				
				$config['num_links'] = 2;
				
				$this->pagination->initialize($config);
				$data['paging'] = $this->pagination->create_links();
				
				$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP) tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				
				$this->load->view('global/header_view');
				$this->load->view('apps/req_budget_view',$data);
				$this->load->view('global/footer_view');
			}
		}
		
		function get_outlet(){
			$query = $this->db->query("select DISTINCT CustomerID, CustomerName from View_ADI_Qlik_SalesOrg order by CustomerID");
			$data = array();
			foreach($query->result() as $db){
				$data[] = $db; 
			}
			echo json_encode($data);
		}
		
		function get_validation(){
			$id = $this->input->get('id');
			$query = $this->db->query("select * from tbl_ANPKSP_TransANP where Req_No='".$id."' order by Req_No");
				if($id == ''){
					$data = array(
						'status' => 'this field is required',
						'color' => 'FF6B6B'
					);
					echo json_encode($data);
				}else if($query->num_rows() == 0){
					$data = array(
						'status' => 'available',
						'color' => 'FFE78D'
					);
					echo json_encode($data);
				}else{
					$data = array(
						'status' => 'not available',
						'color' => 'FF6B6B'
					);
					echo json_encode($data);
				}
		}
		
		function insert_item(){
			$data['Reff_ObjectID'] = $this->input->post('object');
			$data['Purpose'] = $this->input->post('purpose');
			$data['Spec'] = $this->input->post('spec');
			$data['Budget_Price'] = $this->input->post('price');
			$data['Budget_Unit'] = $this->input->post('qty');
			$data['Budget_Amount'] = $this->input->post('amount');
			$select = $this->db->query("select Top 1 Seq_No from tbl_ANPKSP_TransANP_Detail where Reff_ObjectID='".$this->input->post('object')."' order by Seq_No desc");
			if($select->num_rows() == 0){
				$data['Seq_No'] = 1;
			}else{
				foreach($select->result() as $db){
					$data['Seq_No'] = (int)$db->Seq_No + 1;
				}
			}
			
			$query = $this->ksp_model->insert_data('tbl_ANPKSP_TransANP_Detail',$data);
			if($query){
				$data = array(
					'status' => 'this field is required',
					'color' => 'FF6B6B'
				);
				echo json_encode($data);
			}else{
				$data = array(
					'status' => 'this field is required',
					'color' => 'FF6B6B'
				);
				echo json_encode($data);
			}
		}
		
		function update_item(){
			$seq = $this->input->post('seq');
			$Reff_ObjectID = $this->input->post('object');
			$Purpose = $this->input->post('purpose');
			$Spec = $this->input->post('spec');
			$Budget_Price = $this->input->post('price');
			$Budget_Unit = $this->input->post('qty');
			$Budget_Amount = $this->input->post('amount');
			
			$query = $this->db->query("update tbl_ANPKSP_TransANP_Detail set Purpose='".$Purpose."', spec='".$Spec."', Budget_Price='".$Budget_Price."', Budget_Unit='".$Budget_Unit."', Budget_Amount='".$Budget_Amount."' where Seq_No='".$seq."' and Reff_ObjectID='".$Reff_ObjectID."'");
			if($query){
				$data = array(
					'status' => 'this field is required',
					'color' => 'FF6B6B'
				);
				echo json_encode($data);
			}else{
				$data = array(
					'status' => 'this field is required',
					'color' => 'FF6B6B'
				);
				echo json_encode($data);
			}
		}
		
		function update_total_header(){
			$ObjectID = $this->input->post('object');
			$Total_Unit = $this->input->post('qty');
			$Total_Amount = $this->input->post('amount');
			
			$query = $this->db->query("update tbl_ANPKSP_TransANP set UpdateBy='".$this->session->userdata('nama')."', Total_Unit='".$Total_Unit."', Total_Amount='".$Total_Amount."' where ObjectID='".$ObjectID."'");
			if($query){
				$data = array(
					'status' => 'this field is required',
					'color' => 'FF6B6B'
				);
				echo json_encode($data);
			}else{
				$data = array(
					'status' => 'this field is required',
					'color' => 'FF6B6B'
				);
				echo json_encode($data);
			}
		}
		
		function generate_id(){
			$query = $this->db->query("select TOP 1 ObjectID from tbl_ANPKSP_TransANP ORDER BY ObjectID desc");
			if($query->num_rows() == 0){
				$data = array('id'=>'REQ-0000000001');
			}else{
				foreach($query->result() as $db){
					$last_id = $db->ObjectID;
				}
				$id_unique = substr($last_id,0,4);
				$auto_number = (int)substr($last_id,4);
				$result_number = $auto_number+1;
				$total_number = strlen(substr($last_id,4));
				$count_number = $total_number - strlen($result_number);
				$auto = '';
				for($i=1;$i<=$count_number;$i++){
					$auto = $auto.'0';
				}
				$data = array('id'=>'REQ-'.$auto.$result_number);
			}
			echo json_encode($data);
		}
		
		function get_items_grid(){
			$id = $this->input->post("id");
			$queryGrid = $this->db->query("select * from tbl_ANPKSP_TransANP_Detail where Reff_ObjectID='".$id."' order by Seq_No asc");
			$data1 = array();
			foreach($queryGrid->result() as $grid){
				$data1[] = $grid; 
			}
			echo json_encode($data1);
		}
		
		function get_total(){
			$id = $this->input->post("id");
			$query = $this->db->query("select sum(Budget_Unit) as a, sum(Budget_Amount) as b from tbl_ANPKSP_TransANP_Detail where Reff_ObjectID='".$id."'");
			$data = array();
			foreach($query->result() as $db){
				$data[] = $db; 
			}
			echo json_encode($data);
		}
		
		function edit_data_item(){
			$id = $this->input->post("id");
			$kode = $this->input->post("kode");
			$query = $this->db->query("select * from tbl_ANPKSP_TransANP_Detail where Reff_ObjectID='".$kode."' and Seq_No='".$id."'");
			$data = array();
			foreach($query->result() as $db){
				$data[] = $db; 
			}
			echo json_encode($data);
		}
		
		function delete_data_item(){
			$id = $this->input->post("id");
			$kode = $this->input->post("kode");
			
			$query = $this->db->query("delete from tbl_ANPKSP_TransANP_Detail where Seq_No='".$id."' and Reff_ObjectID='".$kode."'");
			if($query){
				$data = array(
					'status' => 'this field is required',
					'color' => 'FF6B6B'
				);
				echo json_encode($data);
			}else{
				$data = array(
					'status' => 'this field is required',
					'color' => 'FF6B6B'
				);
				echo json_encode($data);
			}
		}
	}
/*End of file master_user.php*/
/*Location:../application/master_user.php*/