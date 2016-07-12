<?php if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	class Req_Realisasi extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->library('ci_phpgrid');
				$data['phpgrid'] = $this->ci_phpgrid->realisasi();
				
				$this->load->view('global/header_view',$data);
				$this->load->view('apps/realisasi_view',$data);
				$this->load->view('global/footer_view',$data);
			}
		}
		
		function upload_data(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->view('global/header_view');
				$this->load->view('apps/realisasi_upload');
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
	 
				  $this->excel_reader->setOutputEncoding('230787');
				  $file = $upload_data['full_path'];
				  $this->excel_reader->read($file);
				  error_reporting(E_ALL ^ E_NOTICE);
				  
				  $data = $this->excel_reader->sheets[0];
				  $warning = 0;
				  $dataexcel = Array();
				  for ($i = 2; $i <= $data['numRows']; $i++) {
					if ($data['cells'][$i][2] == '')
					   break;
					   $dataexcel[$i - 2]['TransDate'] = $data['cells'][$i][1];
					   $dataexcel[$i - 2]['Req_No'] = $data['cells'][$i][2];
					   $cek_req = $this->db->query("select * from tbl_ANPKSP_TransANP where Req_No='".$data['cells'][$i][2]."'");
					   if($cek_req->num_rows() < 1){
						  // break;
						   $warning++;
						   echo "<script>alert('Sorry No. Request is invalid, Please check your data upload ".$data['cells'][$i][2]."');</script>";
						   echo "<script>window.location = '".base_url()."/index.php/application/req_realisasi/upload_data/';</script>";
					   }
					   $dataexcel[$i - 2]['Real_Price'] = $data['cells'][$i][3];
					   $dataexcel[$i - 2]['Real_Unit'] = $data['cells'][$i][4];
					   $dataexcel[$i - 2]['Real_Amount'] = $data['cells'][$i][5];
				  }
				  if($warning == 0){
					$this->load->model('ksp_model');
					$notif = $this->ksp_model->loaddata($dataexcel);  
					
					echo "<script>alert('".$notif."');</script>";
					echo "<script>window.location = '".base_url()."/index.php/application/req_realisasi/upload_data/';</script>";
				  }
				  
				 
				  $file = $upload_data['file_name'];
				  $path = './temp_upload/' . $file;
				  unlink($path);
				  
				  }
				}else{
					echo "<script>alert('Sorry, The Format File must be Excel 2003 (.xls)');</script>";
					echo "<script>window.location = '".base_url()."/index.php/application/req_realisasi/upload_data/';</script>";
				}
			//$this->session->set_flashdata('upload_result','');
			//Header('Location:'.base_url().'index.php/dashboard/dashboard_c/result/'.$tgl.'/'.$kode.'/'.$bulan.'/'.$tahun);
			}
		}
		
		function select_data(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$page = $this->uri->segment(5);
				$limit = 4;
				if(!$page){
					$offset = 0;
				}else{
					$offset = $page;
				}
				//$real = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE()");
				$real = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled'");
				//$data['real'] = $real->num_rows();
				$config['total_rows'] = $real->num_rows();
				$config['base_url'] = base_url()."index.php/application/req_realisasi/select_data/index/";
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

				$config['cur_tag_open'] = "<li><span style='color:#fff;background-color:#808CA0; padding: 3px 10px;'>";
				$config['cur_tag_close'] = "</span></li>";
				
				$config['num_tag_open'] = "<li>";
				$config['num_tag_close'] = "</li>";
				
				$config['num_links'] = 2;
				
				$this->pagination->initialize($config);
				$data['paging'] = $this->pagination->create_links();
		
				//$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status!='Close' and Req_Status!='Canceled' and Period_Start <= GETDATE() and Period_End >= GETDATE()) tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE() and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status!='Close' and Req_Status!='Canceled') tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				
				$this->load->view('global/header_view',$data);
				$this->load->view('apps/realisasi_select_view',$data);
				$this->load->view('global/footer_view',$data);
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
				//$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status='".$s2."'");
				$real = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Req_Status='".$s2."'"); //and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE()");
			}else if($s2 == 'none' and $s4 != 'none'){
				//$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%'");
				$real = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%'");// and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE()");
			}else if($s4 == 'none' and $s2 == 'none'){
				$real = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled'");// and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE()");
			}else{
				//$budget = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%' and tbl_ANPKSP_TransANP.Req_Status='".$s2."'");
				$real = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%' and tbl_ANPKSP_TransANP.Req_Status='".$s2."'");// and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE()");
			}
			
			$config['total_rows'] = $real->num_rows();
			$config['base_url'] = base_url()."index.php/application/req_realisasi/search_result/status/".$s2."/search/".$s4;
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

			$config['cur_tag_open'] = "<li><span style='color:#fff;background-color:#808CA0; padding: 3px 10px;'>";
			$config['cur_tag_close'] = "</span></li>";
			
			$config['num_tag_open'] = "<li>";
			$config['num_tag_close'] = "</li>";
			
			$config['num_links'] = 2;
			
			$this->pagination->initialize($config);
			$data['paging'] = $this->pagination->create_links();
			
			
			if($s4 == 'none' and $s2 != 'none'){
				//$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status='".$s2."') tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status='".$s2."' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				//$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status='".$s2."' and Req_Status!='Close' and Req_Status!='Canceled' and Period_Start <= GETDATE() and Period_End >= GETDATE()) tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status='".$s2."' and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE() and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status='".$s2."' and Req_Status!='Close' and Req_Status!='Canceled') tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status='".$s2."' and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				}else if($s2 == 'none' and $s4 != 'none'){
				//$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_No like '%".$s4."%') tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				//$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_No like '%".$s4."%' and Req_Status!='Close' and Req_Status!='Canceled' and Period_Start <= GETDATE() and Period_End >= GETDATE()) tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE() and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_No like '%".$s4."%' and Req_Status!='Close' and Req_Status!='Canceled') tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
			}else if($s4 == 'none' and $s2 == 'none'){
				//$data['budget'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP) tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				//$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status!='Close' and Req_Status!='Canceled' and Period_Start <= GETDATE() and Period_End >= GETDATE()) tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE() and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status!='Close' and Req_Status!='Canceled') tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
			}else{
				//$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status='".$s2."' and Req_No like '%".$s4."%'and Req_Status!='Close' and Req_Status!='Canceled' and Period_Start <= GETDATE() and Period_End >= GETDATE()) tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.Req_Status='".$s2."' and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%'and tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.Period_Start <= GETDATE() and tbl_ANPKSP_TransANP.Period_End >= GETDATE() and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
				$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_TransANP where Req_Status='".$s2."' and Req_No like '%".$s4."%'and Req_Status!='Close' and Req_Status!='Canceled') tbl_ANPKSP_TransANP , tbl_ANPKSP_Brand , tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.Req_Status='".$s2."' and tbl_ANPKSP_TransANP.Req_No like '%".$s4."%'and tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_Status!='Close' and tbl_ANPKSP_TransANP.Req_Status!='Canceled' and tbl_ANPKSP_TransANP.rownum > ".$offset." AND tbl_ANPKSP_TransANP.rownum <= ".$hasil = $offset + $limit);
			}
		
			//$data['num'] = $budget->num_rows();
			$this->load->view('global/header_view');
			$this->load->view('apps/realisasi_select_view',$data);
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
					redirect('application/req_realisasi/search_result/'.$str);
			}
		}
		
		function grid_modify($id){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$id = $this->uri->segment(4);
				$page = $this->uri->segment(5);
				$limit = 5;
				if(!$page){
					$offset = 0;
				}else{
					$offset = $page;
				}
				$real = $this->db->query("select * from tbl_ANPKSP_RealisasiANP where Req_No='".$id."' and Req_Status!='Canceled'");
				
				$config['total_rows'] = $real->num_rows();
				$config['base_url'] = base_url()."index.php/application/req_realisasi/grid_modify/".$id."/";
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

				$config['cur_tag_open'] = "<li><span style='color:#fff;background-color:#808CA0; padding: 3px 10px;'>";
				$config['cur_tag_close'] = "</span></li>";
				
				$config['num_tag_open'] = "<li>";
				$config['num_tag_close'] = "</li>";
				
				$config['num_links'] = 2;
				
				$this->pagination->initialize($config);
				$data['paging'] = $this->pagination->create_links();
				
				$data['real'] = $this->db->query("select * from (select row_number() over (order by ObjectID asc) as rownum, * from tbl_ANPKSP_RealisasiANP where Req_No='".$id."' and Req_Status!='Canceled') tbl_ANPKSP_RealisasiANP where Req_No='".$id."' and rownum > ".$offset." AND rownum <= ".$hasil = $offset + $limit);
				
				$this->load->view('global/header_view');
				$this->load->view('apps/realisasi_grid_view',$data);
				$this->load->view('global/footer_view');
			}
		}

		function add_realisation($id){
			$id = $this->uri->segment(4);
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$data['query_budget'] = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram WHERE tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No='".$id."'");
				
				$this->load->view('global/header_view');
				$this->load->view('apps/realisasi_add',$data);
				$this->load->view('global/footer_view');
			}
		}
		
		function add_action($id){
			$id = $this->uri->segment(4);
			$this->form_validation->set_rules('TglTrans','Transaction Date','required');
			$this->form_validation->set_rules('Real_Price','Real Price','required');
			$this->form_validation->set_rules('Real_Unit','Real Unit','required');
			$this->form_validation->set_rules('Real_Amount','Real Amount','required');
			if($this->form_validation->run() == false){
				$this->add_realisation($id);
			}else{
				$data['TransDate'] = $this->input->post('TglTrans');
				$data['Req_No'] = $id;
				//$data['Seq_No'] = $this->input->post('Seq_No');
				$data['Real_Price'] = $this->input->post('Real_Price');
				$data['Real_Unit'] = $this->input->post('Real_Unit');
				$data['Real_Amount'] = $this->input->post('Real_Amount');
				
				$data['CreatedBy'] = $this->session->userdata('nama');
				$data['CreatedDate'] = date("Y-m-d H:i:s");
				
				$qu = $this->db->query("select Total_Amount, Real_Amount from tbl_ANPKSP_TransANP where Req_No='".$id."'");
				foreach($qu->result() as $bu){
					if($bu->Total_Amount < $bu->Real_Amount+$this->input->post('Real_Amount')){
						echo "
						<script>
							//var r = confirm('This Amount budget not enough, Are you sure?');
							//if (r == true) {
								
							//}
							alert('This Amount budget not enough, Are you sure?');
						</script>";
						$insert = $this->ksp_model->insert_data('tbl_ANPKSP_RealisasiANP',$data);
						
						if(!$insert){
							$this->session->set_flashdata('add_result',"<div style='display:inline;'><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Insert data was failed!</div>");
							Header('Location:'.base_url().'index.php/application/req_realisasi/add_realisation/'.$id);
						}else{
							$this->session->set_flashdata('add_result',"<div style='display:inline;'><i class='fa fa-check-circle' style='margin-right:3px;color:#1d9d74'></i> Inserted data successfully!</div>");
							Header('Location:'.base_url().'index.php/application/req_realisasi/add_realisation/'.$id);
						}
					}else{
						$insert = $this->ksp_model->insert_data('tbl_ANPKSP_RealisasiANP',$data);
						
						if(!$insert){
							$this->session->set_flashdata('add_result',"<div style='display:inline;'><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Insert data was failed!</div>");
							Header('Location:'.base_url().'index.php/application/req_realisasi/add_realisation/'.$id);
						}else{
							$this->session->set_flashdata('add_result',"<div style='display:inline;'><i class='fa fa-check-circle' style='margin-right:3px;color:#1d9d74'></i> Inserted data successfully!</div>");
							Header('Location:'.base_url().'index.php/application/req_realisasi/add_realisation/'.$id);
						}
					}
				}
			}
		}
		
		function update_realisation($id,$id2){
			$id = $this->uri->segment(4);
			$id2 = $this->uri->segment(5);
			$this->form_validation->set_rules('TglTrans','Transaction Date','required');
			$this->form_validation->set_rules('Real_Price','Real Price','required');
			$this->form_validation->set_rules('Real_Unit','Real Unit','required');
			$this->form_validation->set_rules('Real_Amount','Real Amount','required');
			if($this->form_validation->run() == false){
				$this->update_request($id,$id2);
			}else{
				$data['TransDate'] = $this->input->post('TglTrans');
				$data['Req_No'] = $id;
				//$data['Seq_No'] = $this->input->post('Seq_No');
				$data['Real_Price'] = $this->input->post('Real_Price');
				$data['Real_Unit'] = $this->input->post('Real_Unit');
				$data['Real_Amount'] = $this->input->post('Real_Amount');
				
				$data['UpdateBy'] = $this->session->userdata('nama');
				$data['UpdateDate'] = date("Y-m-d H:i:s");
				
				$update = $this->ksp_model->update_data('tbl_ANPKSP_RealisasiANP','ObjectID',$id2,$data);
				if(!$update){
					$this->session->set_flashdata('update_result',"<div style='display:inline;'><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Update data was failed!</div>");
					Header('Location:'.base_url().'index.php/application/Req_Realisasi/update_request/'.$id.'/'.$id2);
				}else{
					$this->session->set_flashdata('update_result',"<div style='display:inline;'><i class='fa fa-check-circle' style='margin-right:3px;color:#1d9d74'></i> Update data successfully!</div>");
					Header('Location:'.base_url().'index.php/application/Req_Realisasi/update_request/'.$id.'/'.$id2);
				}
			}
		}
		
		function update_request($id,$id2){
			$id = $this->uri->segment(4);
			$id2 = $this->uri->segment(5);
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$data['query_budget'] = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram WHERE tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.Req_No='".$id."'");
				
				$query_real = $this->db->query("select * from tbl_ANPKSP_RealisasiANP WHERE ObjectID='".$id2."'");
				foreach($query_real->result() as $db){
					$data['TglTrans'] = $db->TransDate;
					$data['Seq_No'] = $db->Seq_No;
					$data['Real_Price'] = $db->Real_Price;
					$data['Real_Unit'] = $db->Real_Unit;
					$data['Real_Amount'] = $db->Real_Amount;
				}
				$this->load->view('global/header_view');
				$this->load->view('apps/realisasi_edit',$data);
				$this->load->view('global/footer_view');
			}
		}
		
		function delete_action($id, $id2){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$id = $this->uri->segment(4);
				$id2 = $this->uri->segment(5);
				$query = $this->db->query("update tbl_ANPKSP_RealisasiANP set Req_Status='Canceled', UpdateBy='".$this->session->userdata('nama')."' where ObjectID='".$id2."'");
				if($query){
					$this->session->set_flashdata('delete_result',"<div style='display:inline;'><i class='fa fa-check-circle' style='margin-right:3px;color:#1d9d74'></i> The record was deleted!</div>");
					Header('Location:'.base_url().'index.php/application/req_realisasi/grid_modify/'.$id);
				}else{
					$this->session->set_flashdata('delete_result',"<div style='display:inline;'><i class='fa fa-exclamation-circle' style='margin-right:3px;color:#FF6B6B'></i> Delete process was failed!</div>");
					Header('Location:'.base_url().'index.php/application/req_realisasi/grid_modify/'.$id);
				}
			}
		}
	}
/*End of file master_user.php*/
/*Location:../application/master_user.php*/