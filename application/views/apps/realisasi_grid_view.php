			<script src="http://code.jquery.com/jquery-latest.min.js"
			type="text/javascript"></script>
			<div class="main">
				<div class="container">
					<div style="padding:20px 0px;">
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-usd" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 14px;"></i>Data Realisation From No.Request <?php echo $this->uri->segment(4);?></h3>
						<?php echo $this->session->flashdata('delete_result');?>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_realisasi/select_data/'?>"><i class="fa fa-undo"></i> Back to select budget List</a></div>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:5px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_realisasi/add_realisation/'.$this->uri->segment(4);?>"><i class="fa fa-plus"></i> Add New Realisation</a></div>
						
						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Realisation Budget <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Select a Budget<i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Data Realisation</span></div>
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
								<tr>
									<!--<td>ObjectID</td>-->
									<td>TransDate</td>
									<td>Request No</td>
									<td>Seq No</td>
									<td>Real Price</td>
									<td>Real Unit</td>
									<td>Real Amount</td>
									<td>Reqest Status</td>
									<td colspan="2" style="text-align:center;">Action</td>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach($real->result() as $db){
								?>
								<tr>
									<!--<td><?php //echo $db->ObjectID;?></td>-->
									<td><?php echo $db->TransDate;?></td>
									<td><?php echo $db->Req_No;?></td>
									<td><?php echo $db->Seq_No;?></td>
									<td><?php echo 'IDR '.number_format($db->Real_Price,2,'.',',');?></td>
									<td><?php echo number_format($db->Real_Unit,0,'.',',');?></td>
									<td><?php echo 'IDR '.number_format($db->Real_Amount,2,'.',',');?></td>
									<td><?php echo $db->Req_Status;?></td>
									<td style="border-right:transparent;text-align:center;"><a style="text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" href="<?php echo base_url();?>index.php/application/Req_Realisasi/update_request/<?php echo $db->Req_No;?>/<?php echo $db->ObjectID;?>"><i class="fa fa-pencil"></i></a></td>
									<td style="border-right:transparent;text-align:center;"><a style="text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" href="javascript:delete_id('<?php echo $db->Req_No; ?>','<?php echo $db->ObjectID; ?>')"><i class="fa fa-trash"></i></a></td>
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
			/*	function delete_id(id)
				{
					 if(confirm('Sure To Remove This Record ?'))
					 {
						window.location.href='<?php echo base_url();?>index.php/application/Req_Realisasi/delete_action/'+id;
					 }
				}*/
			</script>