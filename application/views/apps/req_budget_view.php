			<script src="http://code.jquery.com/jquery-latest.min.js"
			type="text/javascript"></script>
			<script>
				function currencyFormat (num) {
					var c = parseFloat(num);
					var a = String(c);
					return "IDR " + a.toString(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
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
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-bookmark" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 12px;"></i>Requested Budget</h3>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_budget/'?>"><i class="fa fa-undo"></i> Back to Budget List</a></div>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:5px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_budget/add_request/'?>"><i class="fa fa-plus"></i> Add New Request</a></div>
						<div style="display:inline; color:#666;padding:5px 15px;margin-left:5px;font-size:14px;">
							<?php 
								$style=array('style'=>'display:inline;');
								echo form_open('application/req_budget/grid_modify_filter/',$style);
							?>
								<select style="padding:3px;border:transparent;border-radius:3px;background-color:transparent;color:#666;outline:none;" name="status">
									<option disabled> -- Choose Status -- </option>
									<option value="">All Status</option>
									<option value="Requested">Requested</option>
									<option value="Partially Settled">Partially Settled</option>
									<option value="Canceled">Cancel</option>
									<option value="Close">Closed</option>
								</select>
								<input type="text" name="search" style="width:120px;outline:none;padding:3px;border:1px solid #e1e1e1;border-radius:3px;"/>
								<button type="submit" style="display:inline; color:#808CA0;padding:3px 15px;background-color:#fff;margin-left:5px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><i class="fa fa-filter"></i> Filter</button>
							<?php echo form_close();?>
						</div>
						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Request Budget <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Grid Requested Budget</span></div>
						<?php echo $this->session->flashdata('delete_result');?>
					</div>
					<style>
						table thead tr td, table tbody tr td{
							border:1px solid #e1e1e1;
							padding:10px 5px;
						}
						table thead tr td{
							background-color:#B7C1D3;
							color:#fff;
						}
						table tbody tr td{
							background-color:#fff;
						}
					</style>
					<div id="body">
						<table style="border:1px solid #e1e1e1;border-collapse:collapse;width:100%;">
							<thead>
								<tr style="font-weight:bold;">
									<td>Request No</td>
									<td>Request Date</td>
									<td>Brand</td>
									<td>Request By</td>
									<td>Program</td>
									<td>Period Start</td>
									<td>Period End</td>
									<td>Distributor Name</td>
									<td>Total Unit</td>
									<td>Total Amount</td>
									<td>Request Status</td>
									<td colspan="2" style="text-align:center;">Action</td>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach($budget->result() as $db){
								?>
								<tr>
									<td><?php echo $db->Req_No;?></td>
									<td><?php echo $db->Req_Date;?></td>
									<td><?php echo $db->Brand;?></td>
									<td><?php echo $db->Req_By;?></td>
									<td><?php echo $db->Sub_Program_Type;?></td>
									<td><?php echo $db->Period_Start;?></td>
									<td><?php echo $db->Period_End;?></td>
									<td><?php echo $db->Nama_Distributor;?></td>
									<td><?php echo number_format($db->Total_Unit,0,'.',',');?></td>
									<td><?php echo 'IDR'.number_format($db->Total_Amount,2,'.',',');?></td>
									<td><?php echo $db->Req_Status;?></td>
									<td style="border-right:transparent;">
										<?php if($db->Req_Status == 'Requested'){?>
										<a style="float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" href="<?php echo base_url();?>index.php/application/Req_Budget/update_request/<?php echo $db->ObjectID;?>">
											<i class="fa fa-pencil"></i>
										</a>
										<?php }else{
											
										}?>
									</td>
									<td style="border-left:transparent;">
										<?php if($db->Req_Status == 'Requested'){?>
										<a style="float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" href="javascript:delete_budget_id('<?php echo $db->ObjectID; ?>')" >
											<i class="fa fa-trash"></i>
										</a>
										<?php }else{
											
										}?>
									</td>
								</tr>
								<?php 
									}
								?>
							</tbody>
						</table>
						<?php echo $paging;?>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				/*function delete_id(id)
				{
					 if(confirm('Sure To Remove This Record ?'))
					 {
						window.location.href='<?php echo base_url();?>index.php/application/Req_Budget/delete_request/'+id;
					 }
				}*/
			</script>
			