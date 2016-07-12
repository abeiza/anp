<?php if(!defined("BASEPATH"))exit("No Direct Script Access Allowed");
	class Ksp_Model extends CI_Model{
		public function __construct(){
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
		}
		
		function loaddata($dataarray) {
			$success = 0;
			$failed = 0;
			for ($i = 0; $i < count($dataarray); $i++) {
				echo $data['TransDate'] = substr($dataarray[$i]['TransDate'],6,4).'-'.substr($dataarray[$i]['TransDate'],3,2).'-'.substr($dataarray[$i]['TransDate'],0,2);
				echo "<br/>";
				echo $data['Req_No'] = $dataarray[$i]['Req_No'];
				echo "<br/>";
				echo $data['Seq_No'] = NULL;
				echo "<br/>";
				echo $data['Real_Price'] = $dataarray[$i]['Real_Price'];
				echo "<br/>";
				echo $data['Real_Unit'] = $dataarray[$i]['Real_Unit'];;
				echo "<br/>";
				echo $data['Real_Amount'] = $dataarray[$i]['Real_Amount'];
				echo "<br/>";
				echo $data['CreatedBy'] = $this->session->userdata('nama');
				echo "<br/>";
				echo "<br/>";
				$action = $this->db->insert("tbl_ANPKSP_RealisasiANP", $data);
				if($action){
					$success++;
				}else{
					$failed++;
				}
			}
			$notif = "Success ".$success." from ".count($dataarray)." Data"; 
			return $notif;
		}
		
		function code(){
			$query = $this->db->query("select TOP 1 ObjectID from tbl_ANPKSP_TransANP ORDER BY ObjectID desc");
			if($query->num_rows() == 0){
				$kode = 'REQ-0000000001';
				
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
				$kode = 'REQ-'.$auto.$result_number;
				
			}
			return $kode;
		}
		
		function loaddata_req($dataarray) {
			$success = 0;
			$failed = 0;
			for ($i = 0; $i < count($dataarray); $i++) {
				
					echo $data['ObjectID'] = $this->code();
					echo "<br/>";
					echo $data['Req_No'] = $dataarray[$i]['Req_No'];
					echo "<br/>";
					echo $data['Req_Date'] = date('Y-m-d h:i:s');
					echo "<br/>";
					echo $data['ID_Brand'] = $dataarray[$i]['ID_Brand'];
					echo "<br/>";
					echo $data['Req_By'] = $dataarray[$i]['Req_By'];
					echo "<br/>";
					echo $data['Manage_By'] = $dataarray[$i]['Manage_By'];
					echo "<br/>";
					echo $data['ID_Program'] = $dataarray[$i]['ID_Program'];
					echo "<br/>";
					IF($dataarray[$i]['Period_Start'] == '-'){
						echo $data['Period_Start'] = NULL;
						echo "<br/>";
					}ELSE{
						echo $data['Period_Start'] = substr($dataarray[$i]['Period_Start'],6,4).'-'.substr($dataarray[$i]['Period_Start'],3,2).'-'.substr($dataarray[$i]['Period_Start'],0,2);
						echo "<br/>";
					}
					
					IF($dataarray[$i]['Period_End'] == '-'){
						echo $data['Period_End'] = NULL;
						echo "<br/>";
					}ELSE{
						echo $data['Period_End'] = substr($dataarray[$i]['Period_End'],6,4).'-'.substr($dataarray[$i]['Period_End'],3,2).'-'.substr($dataarray[$i]['Period_End'],0,2);
						echo "<br/>";
					}
					echo $data['Kode_Distributor'] = NULL;
					echo "<br/>";
					echo $data['Nama_Distributor'] = NULL;
					echo "<br/>";
					echo $data['Total_Unit'] = $dataarray[$i]['Budget_Unit'];
					echo "<br/>";
					echo $data['Total_Amount'] = $dataarray[$i]['Budget_Amount'];
					echo "<br/>";
					echo $data['Real_Price'] = 0;
					echo "<br/>";
					echo $data['Real_Unit'] = 0;
					echo "<br/>";
					echo $data['Real_Amount'] = 0;
					echo "<br/>";
					echo $data['CreatedBy'] = $this->session->userdata('nama');
					echo "<br/>";
					echo "<br/>";
					//echo "<br/>";
					/*$action = $this->db->query("INSERT INTO tbl_ANPKSP_TH (ObjectID, Req_No, Req_Date, ID_Brand, 
					Req_By, Manage_By, ID_Program, Period_Start, Period_End, Kode_Distributor, Nama_Distributor,
					Total_Unit, Total_Amount, Real_Price, Real_Unit, Real_Amount, CreatedBy) VALUES 
					('".$data['ObjectID']."', '".$dataarray[$i]['Req_No']."', ".date('Y-m-d h:i:s').", ".$dataarray[$i]['ID_Brand'].", 
					'".$dataarray[$i]['Req_By']."', '".$dataarray[$i]['Manage_By']."', ".$dataarray[$i]['ID_Program'].", ".$data['Period_Start']."  00:00:00,
					".$data['Period_End']." 00:00:00 , NULL, NULL, ".$dataarray[$i]['Budget_Unit'].", ".$dataarray[$i]['Budget_Amount'].", 0, 0, 0, '".$this->session->userdata('nama')."')");
					*/
					$action = $this->db->insert("tbl_ANPKSP_TransANP", $data);
					
					echo $data1['Reff_ObjectID'] = $data['ObjectID'];
					echo "<br/>";
					echo $data1['Seq_No'] = 1;
					echo "<br/>";
					echo $data1['Purpose'] = $dataarray[$i]['Purpose'];
					echo "<br/>";
					echo $data1['spec'] = $dataarray[$i]['spec'];
					echo "<br/>";
					echo $data1['Budget_Price'] = $dataarray[$i]['Budget_Price'];
					echo "<br/>";
					echo $data1['Budget_Unit'] = $dataarray[$i]['Budget_Unit'];
					echo "<br/>";
					echo $data1['Budget_Amount'] = $dataarray[$i]['Budget_Amount'];
					echo "<br/>";
					echo "<br/>";
					echo "<br/>";
					echo "<br/>";
					echo "<br/>";
					
					$action1 = $this->db->insert("tbl_ANPKSP_TransANP_Detail", $data1);
				if($action and $action1){
					$success++;
				}else{
					$failed++;
				}
			}
			$notif = "Success ".$success." from ".count($dataarray); 
			return $notif;
		}
		
		public function validation_login($email, $password){
			$query_validasi_login = $this->db->query("select * from tbl_ANPKSP_MsUser where email='".$email."' and password='".$password."'");
			return $query_validasi_login;
		}
		
		public function insert_data($table, $data){
			//$this->load->database('default',FALSE,TRUE);
			return $this->db->insert($table,$data);
		}
		
		function update_data($table, $pk, $id, $data){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->where($pk,$id);
			return $this->db->update($table,$data);
		}
		
		public function list_data($offset)
		{
			$perpage = 10;
			if($offset == 1){
				$first = 1;
				$last  = $perpage;
			}else{
				$first = ($offset - 1) * $perpage + 1;
				$last  = $first + ($perpage -1);
			}
			$sql = 'WITH CTE AS (SELECT  a.*,ROW_NUMBER() OVER (ORDER BY a.KdDokter DESC) as RowNumber FROM dokter a)
				SELECT * FROM CTE WHERE RowNumber BETWEEN '.$first.' AND '.$last.'';
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function jumlah_data()
		{
			$this->db->select('count(KdDokter) as total');
			$this->db->from('dokter');
			return $this->db->get()->row()->total;
		}
	}
/*End of file ksp_model.php*/
/*Location:..models/ksp_model.php*/