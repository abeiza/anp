			<style>
				.icon-lock{
					background-color:#FF6B6B;
					color:#fff;
					float:left;
					padding:5px;
					margin:3px;
					border-radius:3px;
				}
				
				.icon-unlock{
					background-color:#79bbaf;
					color:#fff;
					float:left;
					padding:5px;
					margin:3px;
					border-radius:3px;
				}
			</style>
			<style>
				form{
					display:inline;
				}
			</style>
			<div class="main">
				<div class="container">
					<div style="padding:20px 0px;">
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-bar-chart" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 10px;"></i>Report View of Realisation Budget</h3>
						<?php echo form_open('application/report_controller/report_real_excel'); ?>
						<input type="hidden" name="from_b" value="<?php echo $from;?>"/>
						<input type="hidden" name="to_b" value="<?php echo $to;?>"/>
						<div style="display:inline;"><button style="color:#808CA0;color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><i class="fa fa-file-excel-o"></i> Excel</button></div>
						<?php echo form_close(); ?>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:5px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_budget/grid_modify/';?>"><i class="fa fa-file-pdf-o"></i> PDF</a></div>
						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Home <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Realisation Budget</span></div>
					</div>
					<div id="body">
						<?php 
						$phpgrid->enable_edit("FORM","R"); 
						$data = null;
						$query2 = $this->db->query("select * from tbl_ANPKSP_TransANP, tbl_ANPKSP_MsProgram where tbl_ANPKSP_TransANP.ID_Program=tbl_ANPKSP_MsProgram.ID_Program order by Req_No desc");
						foreach($query2->result() as $req){
							if($req->Req_Status == 'Close'){
								$stat = '<div class="icon-lock"><i class="fa fa-lock" style="margin-right:5px"></i>'.$req->Req_Status.'</div>;';
							}else{
								$stat = '<div class="icon-unlock"><i class="fa fa-unlock-alt" style="margin-right:5px"></i>'.$req->Req_Status.'</div>;';
							}
							$data .= $req->Req_No.':'.$req->Req_No.' - '.$req->Sub_Program_Type.' | <div style="color:red">MAX. IDR '.$req->Total_Amount.'</div>'.$stat;
						}
						$phpgrid->set_caption("<i class='fa fa-bookmark' style='margin-right:5px;'></i>DATAGRID REAL BUDGET");
						
						
						$phpgrid->set_col_title("TransDate", "<i class='fa fa-calendar' style='margin-right:3px;'></i>Transaction Date");
						$phpgrid->set_col_title("Req_No", "Request No.");
						$phpgrid->set_col_title("Seq_No", "Seq No.");
						$phpgrid->set_col_title("Real_Price", "Real Price");
						$phpgrid->set_col_title("Real_Unit", "Qty");
						$phpgrid->set_col_title("Real_Amount", "Amount");
						$phpgrid->set_col_title("Req_Status", "Status");
						
						$phpgrid->set_query_filter("[TransDate] >= '".$from."' AND [TransDate] <= DATEADD(day, +1, '".$to."') AND Req_Status != 'Canceled'");
						
						$phpgrid->set_col_edittype("Req_No", "autocomplete", $data, false);
						$phpgrid->set_col_property("Req_No", array("editoptions"=>array("style"=>"width:95%;")));
						$phpgrid->set_dimension(1200, 400, false);									
						$phpgrid->set_col_hidden('Update_Version', false);
						$phpgrid->set_col_hidden('ObjectID', false);
						$phpgrid->set_col_hidden('CreatedBy', false);
						$phpgrid->set_col_hidden('CreatedDate', false);
						$phpgrid->set_col_hidden('UpdateBy', false);
						$phpgrid->set_col_hidden('UpdateDate', false);
						$phpgrid->set_col_width("Req_No", 300);
						$phpgrid->enable_search(true);
						
						
						$phpgrid->set_col_align('TransDate', 'center');
						$phpgrid->set_col_align('Real_Amount', 'right');
						$phpgrid->set_col_align('Real_Price', 'right');
						$phpgrid->set_col_align('Real_Unit', 'center');
						$phpgrid->set_col_align('Seq_No', 'center');

						$phpgrid->display();
						?>	
					</div>
				</div>
			</div>
			