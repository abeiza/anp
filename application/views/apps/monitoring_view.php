			<script>
				function currencyFormat (num) {
					var c = parseFloat(num);
					var a = String(c);
					return " " + a.toString(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
				}
				
				function numberFormat (num) {
					var c = parseFloat(num);
					var a = String(c);
					return a.toString(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
				}
			</script>
			<div class="main">
				<div class="container">
					<div style="padding:20px 0px;">
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-desktop" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 12px;"></i>Monitoring Budget</h3>
						<button id="multi-delete" style="display:inline; color:rgb(128, 140, 160);padding:5px 15px;background-color:#fff;cursor:pointer;margin-left:20px;font-size:13px;border:1px solid #e1e1e1;border-radius:15px" ><i class="fa fa-hourglass-end" style="margin-right:5px;"></i>Force Close</button>
						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Home <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Monitoring Budget</span></div>
					</div>
					<div id="body">
						<?php 
							$phpgrid->set_caption("<i class='fa fa-desktop' style='margin-right:5px;'></i>BUDGET MONITORING");
							$phpgrid->enable_edit("FORM","R"); 
							//$phpgrid->set_dimension('800');
							$query1 = $this->db->query("select * from tbl_ANPKSP_Brand order by Brand desc");
							$data1 = null;
							foreach($query1->result() as $brand){
								$data1 .= $brand->ID_Brand.':'.$brand->ID_Brand.' - '.$brand->Brand.';';
							}
							$phpgrid->set_col_edittype("ID_Brand", "autocomplete", $data1, false);
							
							$data = null;
							$query2 = $this->db->query("select * from tbl_ANPKSP_MsProgram order by Sub_Request_Type desc");
							foreach($query2->result() as $program){
								$data .= $program->ID_Program.':'.$program->ID_Program.' - '.$program->Sub_Program_Type.';';
							}
							
							
							$phpgrid->set_col_width("Req_Date", 100);
							$phpgrid->set_col_width("Total_Unit", 50);
							$phpgrid->set_col_width("Total_Amount", 100);
							$phpgrid->set_col_width("Real_Amount", 110);
							$phpgrid->set_col_width("Period_Start", 100);
							$phpgrid->set_col_width("Period_End", 100);
							$phpgrid->set_col_width("Kode_Distributor", 110);
							
							
							$phpgrid->set_col_title("Req_Date", "<i class='fa fa-calendar' style='margin-right:3px;'></i>Transaction");
							$phpgrid->set_col_date("Req_Date", "Y-m-d", "m/d/Y", "m/d/yy");
							$phpgrid->set_col_title("Req_No", "Request No.");
							$phpgrid->set_col_title("ID_Brand", "<i class='fa fa-book' style='margin-right:3px;'></i>Brand");
							$phpgrid->set_col_title("Req_By", "<i class='fa fa-user' style='margin-right:3px;'></i>Request By");
							$phpgrid->set_col_title("Manage_By", "Manage By");
							$phpgrid->set_col_title("ID_Program", "<i class='fa fa-link' style='margin-right:3px;'></i>Program");
							$phpgrid->set_col_title("Period_Start", "<i class='fa fa-history' style='margin-right:3px;'></i>Period Start");
							$phpgrid->set_col_date("Period_Start", "Y-m-d", "m/d/Y", "m/d/yy");
							$phpgrid->set_col_title("Period_End", "<i class='fa fa-history' style='margin-right:3px;'></i>Period End");
							$phpgrid->set_col_date("Period_End", "Y-m-d", "m/d/Y", "m/d/yy");
							$phpgrid->set_col_title("Kode_Distributor", "Code Distributor");
							$phpgrid->set_col_title("Nama_Distributor", "Distributor Name");
							$phpgrid->set_col_title("Seq_No", "Seq No");
							//$phpgrid->set_col_title("Budget_Price", "Budget Price");
							$phpgrid->set_col_title("Total_Unit", "Qty");
							$phpgrid->set_col_currency("Total_Unit", "", "", ",", 2, "0.00");
							$phpgrid->set_col_title("Total_Amount", "Total Budget");
							$phpgrid->set_col_currency("Total_Amount", "", "", ",", 2, "0.00");
							//$phpgrid->set_col_title("Real_Price", "Real Price");
							//$phpgrid->set_col_title("Real_Unit", "Qty");
							$phpgrid->set_col_title("Real_Amount", "Total Realisation");
							$phpgrid->set_col_currency("Real_Amount", "", "", ",", 2, "0.00");
							$phpgrid->enable_search(true);
							$phpgrid->set_col_title("Req_Status", "Status");
						// calculated value to be displayed in the virtual column
// n1 stores column 1 value, n2 stores column 7 value..and so on.
$col_formatter = <<<COLFORMATTER
function(cellvalue, options, rowObject){
    var n1 = parseInt(rowObject[4],10),      
        n2 = parseInt(rowObject[5],10);
	if(isNaN(parseFloat(n2))){
		return currencyFormat(n1-0);
	}else{
		return currencyFormat(n1-n2);
	}
    
}
COLFORMATTER;
							
							$phpgrid->add_column('virtual', array('name'=>'virtual','index'=>'virtual','formatter'=>$col_formatter),'Remaining Budget');
							//$phpgrid->set_col_currency("Virtual", "IDR ", ".00", ",", 2, "0.00");
							
							
							$phpgrid->set_col_edittype("ID_Program", "autocomplete", $data, false);
							$phpgrid->set_col_readonly("ObjectID", false);
							//$phpgrid->set_col_property("ObjectID", array("formoptions"=>array("rowpos" => 1, "colpos" => 1)));
							$phpgrid->set_col_property("Req_No", array("formoptions"=>array("rowpos" => 2, "colpos" => 1)));
							$phpgrid->set_col_property("Req_Date", array("formoptions"=>array("rowpos" => 3, "colpos" => 1)));
							$phpgrid->set_col_property("ID_Brand", array("formoptions"=>array("rowpos" => 4, "colpos" => 1)));
							$phpgrid->set_col_property("ID_Brand", array("editoptions"=>array("style"=>"width:95%;")));
							$phpgrid->set_col_property("Req_By", array("formoptions"=>array("rowpos" => 5, "colpos" => 1)));
							$phpgrid->set_col_property("Manage_By", array("formoptions"=>array("rowpos" => 6, "colpos" => 1)));
							
							$phpgrid->set_col_property("ID_Program", array("formoptions"=>array("rowpos" => 2, "colpos" => 2)));
							$phpgrid->set_col_property("ID_Program", array("editoptions"=>array("style"=>"width:95%;")));
							$phpgrid->set_col_property("Period_Start", array("formoptions"=>array("rowpos" => 3, "colpos" => 2)));
							$phpgrid->set_col_property("Period_End", array("formoptions"=>array("rowpos" => 4, "colpos" => 2)));
							$phpgrid->set_col_property("Kode_Distributor", array("formoptions"=>array("rowpos" => 5, "colpos" => 2)));
							$phpgrid->set_col_property("Nama_Distributor", array("formoptions"=>array("rowpos" => 6, "colpos" => 2)));
							$phpgrid->set_col_property("Seq_No", array("formoptions"=>array("rowpos" => 7, "colpos" => 2)));
							$phpgrid->set_col_property("Purpose", array("formoptions"=>array("rowpos"=>8,"colpos"=>1)));
							$phpgrid->set_col_property("Purpose", array("editoptions"=>array("style"=>"width:95%;")));
							$phpgrid->set_col_property("Spec", array("formoptions"=>array("rowpos"=>9,"colpos"=>1)));
							$phpgrid->set_col_property("Spec", array("editoptions"=>array("style"=>"width:95%;")));
							
							$phpgrid->set_col_property("Budget_Price", array("formoptions"=>array("rowpos" => 10, "colpos" => 1)));
							//$phpgrid->set_col_property("Budget_Unit", array("formoptions"=>array("rowpos" => 11, "colpos" => 1)));
							//$phpgrid->set_col_property("Budget_Amount", array("formoptions"=>array("rowpos" => 12, "colpos" => 1)));
							
							$phpgrid->set_col_property("Real_Price", array("formoptions"=>array("rowpos" => 10, "colpos" => 2)));
							$phpgrid->set_col_property("Real_Unit", array("formoptions"=>array("rowpos" => 11, "colpos" => 2)));
							$phpgrid->set_col_property("Real_Amount", array("formoptions"=>array("rowpos" => 12, "colpos" => 2)));
							$phpgrid->set_dimension(1200, 400, false);
							//$phpgrid->set_dimension(500);
							//$phpgrid->set_col_hidden('Real_Amount');
							$phpgrid->set_col_hidden('Real_Unit');
							$phpgrid->set_col_hidden('Real_Price');
							$phpgrid->set_col_hidden('Spec');
							$phpgrid->set_col_hidden('Purpose');
							$phpgrid->set_col_hidden('Update_Version', false);
							$phpgrid->set_col_hidden('ObjectID', false);
							$phpgrid->set_col_hidden('CreatedBy', false);
							$phpgrid->set_col_hidden('CreatedDate', false);
							$phpgrid->set_col_hidden('UpdateBy', false);
							$phpgrid->set_col_hidden('UpdateDate', false);
							$phpgrid->set_form_dimension('700');
							
							$phpgrid->set_col_width("comments", 500);

	
							$phpgrid->set_multiselect(true);
							
							$phpgrid->display();
						?>	
					</div>
				</div>
			</div>
			<script>
				function ShowSelectedRows(){
				 if(confirm('Sure To Remove This Record?'))
				 {
					
				 }
				}
			</script>
			