<?php if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');

	class Report_Controller extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$cek = $this->session->userdata('login_code');
			if(empty($cek)){
				Header('Location:'.base_url());
			}else{
				$this->load->view('global/header_view');
				$this->load->view('apps/report_select');
				$this->load->view('global/footer_view');
			}
		}
		
		function filter_data(){
			$this->form_validation->set_rules('from','start period','required');
			$this->form_validation->set_rules('to','end period','required');
			$this->form_validation->set_rules('type','report type','required');
			if($this->form_validation->run() == false){
				$this->index();
			}else{
				$data['from'] = $this->input->post('from');
				$data['to'] = $this->input->post('to');
				$type = $this->input->post('type');					
				if($type == 'budget'){
					$this->load->library('ci_phpgrid');
					$data['phpgrid'] = $this->ci_phpgrid->budget();
					
					
					$this->load->view('global/header_view');
					$this->load->view('apps/report_budget_view',$data);
					$this->load->view('global/footer_view');
				}else if($type == 'real'){
					$this->load->library('ci_phpgrid');
					$data['phpgrid'] = $this->ci_phpgrid->realisasi();
					
					$this->load->view('global/header_view');
					$this->load->view('apps/report_real_view',$data);
					$this->load->view('global/footer_view');
				}
			}
		}
		
		function report_budget_excel(){
			//load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load
            $this->load->library("Excel/PHPExcel");
			$from = $this->input->post('from_b');
			$to = $this->input->post('to_b');
            //membuat objek PHPExcel
            $objPHPExcel = new PHPExcel();
 
            //set Sheet yang akan diolah 
            $objPHPExcel->setActiveSheetIndex(0);
			//$objPHPExcel->mergeCells("A1:S1");
			/*$header = 'a4:s4';
			$objPHPExcel->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
			$style = array(
				'font' => array('bold' => true,),
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
				);
			$objPHPExcel->getStyle($header)->applyFromArray($style);*/
			$objPHPExcel->setActiveSheetIndex(0)
                    //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
                    //Hello merupakan isinya
                                        ->setCellValue('A1', 'DATAGRID ALL REQUEST BUDGET')
                                        ->setCellValue('A2', '')
                                        ->setCellValue('A3', 'period '.$from.' to '.$to)
                                        ->setCellValue('A4', 'Request ID.')
										->setCellValue('B4', 'Request No.')
										->setCellValue('C4', 'Req_Date')
										->setCellValue('D4', 'Brand ID')
										->setCellValue('E4', 'Brand')
										->setCellValue('F4', 'Request By')
										->setCellValue('G4', 'Manage By')
										->setCellValue('H4', 'Program ID')
										->setCellValue('I4', 'Request_Type')
										->setCellValue('J4', 'Sub_Request_Type')
										->setCellValue('K4', 'Program_Type')
										->setCellValue('L4', 'Sub Program Type')
										->setCellValue('M4', 'Start Period')
										->setCellValue('N4', 'End Period')
										->setCellValue('O4', 'Distributor Code')
										->setCellValue('P4', 'Distributor Name')
										//->setCellValue('P4', 'Seq No')
										//->setCellValue('Q4', 'Purpose')
										//->setCellValue('R4', 'Spec')
										//->setCellValue('S4', 'Budget Price')
										->setCellValue('Q4', 'Qty')
										->setCellValue('R4', 'Budget Amount')
										->setCellValue('S4', 'Budget Realisasi')
										->setCellValue('T4', 'Budget Remaining')
										->setCellValue('U4', 'Budget Remaining Presentation')
										->setCellValue('V4', 'Status');
                    //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
                    //Hello merupakan isinya
			$query1 = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_Brand, tbl_ANPKSP_MsProgram WHERE tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program and tbl_ANPKSP_TransANP.ID_Brand=tbl_ANPKSP_Brand.ID_Brand and tbl_ANPKSP_TransANP.Req_Date >= '".$from."' and tbl_ANPKSP_TransANP.Req_Date <= DATEADD(day, +1, '".$to."') order by tbl_ANPKSP_TransANP.Req_Date desc");
			$i = 5;

			foreach($query1->result() as $final){
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$i, $final->ObjectID)
							->setCellValue('B'.$i, $final->Req_No)
							->setCellValue('C'.$i, $final->Req_Date)
							->setCellValue('D'.$i, $final->ID_Brand)
							->setCellValue('E'.$i, $final->Brand)
							->setCellValue('F'.$i, $final->Req_By)
							->setCellValue('G'.$i, $final->Manage_By)
							->setCellValue('H'.$i, $final->ID_Program)
							->setCellValue('I'.$i, $final->Request_Type)
							->setCellValue('J'.$i, $final->Sub_Request_Type)
							->setCellValue('K'.$i, $final->Program_Type)
							->setCellValue('L'.$i, $final->Sub_Program_Type)
							->setCellValue('M'.$i, $final->Period_Start)
							->setCellValue('N'.$i, $final->Period_End)
							->setCellValue('O'.$i, $final->Kode_Distributor)
							->setCellValue('P'.$i, $final->Nama_Distributor)
							//->setCellValue('P'.$i, $final->Seq_No)
							//->setCellValue('Q'.$i, $final->Purpose)
							//->setCellValue('R'.$i, $final->Spec)
							//->setCellValue('S'.$i, $final->Budget_Price)
							->setCellValue('Q'.$i, $final->Total_Unit)
							->setCellValue('R'.$i, $final->Total_Amount)
							->setCellValue('S'.$i, $final->Real_Amount)
							->setCellValue('T'.$i, $hasil = $final->Total_Amount-$final->Real_Amount)
							->setCellValue('U'.$i, $hasil2 = 100-($final->Real_Amount/$final->Total_Amount*100).'%')
							->setCellValue('V'.$i, $final->Req_Status);
				$i++;
			}
			
            //set title pada sheet (me rename nama sheet)
            $objPHPExcel->getActiveSheet()->setTitle('Report Req Budget');
 
            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
            //sesuaikan headernya 
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="req_budget"'.date('YMdHis').'".xls"');
            //unduh file
			$objWriter->save("php://output");
            //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
            // Folder Documentation dan Example
            // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
			
		}
		
		function report_real_excel(){
			//load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load
            $this->load->library("Excel/PHPExcel");
			$from = $this->input->post('from_b');
			$to = $this->input->post('to_b');
            //membuat objek PHPExcel
            $objPHPExcel = new PHPExcel();
 
            //set Sheet yang akan diolah 
            $objPHPExcel->setActiveSheetIndex(0);
			//$objPHPExcel->mergeCells("A1:S1");
			/*$header = 'a4:s4';
			$objPHPExcel->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
			$style = array(
				'font' => array('bold' => true,),
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
				);
			$objPHPExcel->getStyle($header)->applyFromArray($style);*/
			$objPHPExcel->setActiveSheetIndex(0)
                    //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
                    //Hello merupakan isinya
                                        ->setCellValue('A1', 'DATAGRID REAL BUDGET')
                                        ->setCellValue('A2', 'ANP | KSP')
                                        ->setCellValue('A3', 'period '.$from.' to '.$to)
                                        ->setCellValue('A4', 'TransDate')
										->setCellValue('B4', 'Req_No')
										->setCellValue('C4', 'Seq_No')
										->setCellValue('D4', 'Real_Price')
										->setCellValue('E4', 'Real_Unit')
										->setCellValue('F4', 'Real_Amount')
										->setCellValue('G4', 'Req_Status');
                    //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
                    //Hello merupakan isinya
			$query1 = $this->db->query("select * from tbl_ANPKSP_RealisasiANP WHERE TransDate >= '".$from."' and TransDate <= DATEADD(day, +1, '".$to."') order by TransDate desc");
			$i = 5;

			foreach($query1->result() as $final){
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$i, $final->TransDate)
							->setCellValue('B'.$i, $final->Req_No)
							->setCellValue('C'.$i, $final->Seq_No)
							->setCellValue('D'.$i, $final->Real_Price)
							->setCellValue('E'.$i, $final->Real_Unit)
							->setCellValue('F'.$i, $final->Real_Amount)
							->setCellValue('G'.$i, $final->Req_Status);
				$i++;
			}
			
            //set title pada sheet (me rename nama sheet)
            $objPHPExcel->getActiveSheet()->setTitle('Data Realisasi Budget');
 
            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
            //sesuaikan headernya 
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="datarealisation"'.date('YMdHis').'".xls"');
            //unduh file
			$objWriter->save("php://output");
            //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
            // Folder Documentation dan Example
            // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
			
		}
	}

/*End of file report_controller.php*/
/*Location:.application/controllers/application/report_controller.php*/