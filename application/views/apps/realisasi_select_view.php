			<script src="http://code.jquery.com/jquery-latest.min.js"
			type="text/javascript"></script>
			<div class="main">
				<div class="container">
					<div style="padding:20px 0px;">
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-usd" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 14px;"></i>Select a Budget</h3>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_realisasi/'?>"><i class="fa fa-undo"></i> Back to Realisation List</a></div>
						<div style="display:inline; color:#666;padding:5px 15px;margin-left:5px;font-size:14px;">
							<?php 
								$style=array('style'=>'display:inline;');
								echo form_open('application/req_realisasi/grid_modify_filter/',$style);
							?>
								<select style="padding:3px;border:transparent;border-radius:3px;background-color:transparent;color:#666;outline:none;" name="status">
									<option disabled> -- Choose Status -- </option>
									<option value="">All Status</option>
									<option value="Requested">Requested</option>
									<option value="Partially Settled">Partially Settled</option>
									<option value="Canceled">Cancel</option>
									<!--<option value="Close">Closed</option>-->
								</select>
								<input type="text" name="search" style="width:120px;outline:none;padding:3px;border:1px solid #e1e1e1;border-radius:3px;"/>
								<button type="submit" style="display:inline; color:#808CA0;padding:3px 15px;background-color:#fff;margin-left:5px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><i class="fa fa-filter"></i> Filter</button>
							<?php echo form_close();?>
						</div>
						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Realisation Budget <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Select a Budget</span></div>
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
									<td>Request No</td>
									<td>Request Date</td>
									<td>Brand</td>
									<td>Request By</td>
									<td>Program</td>
									<td>Period Start</td>
									<td>Period End</td>
									<td>Distributor Name</td>
									<td>Total Qty</td>
									<td>Total Budget Amount</td>
									<td>Fund Status</td>
									<td>Request Status</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach($real->result() as $db){
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
									<td><?php echo 'IDR '.number_format($db->Total_Amount,2,'.',',');?></td>
									<td style="text-align:center"><?php 
										$hasil = 100 - ($db->Real_Amount/$db->Total_Amount*100);
										$hasil2 = $db->Total_Amount - $db->Real_Amount;
										if($db->Total_Amount < $db->Real_Amount){
											echo "<div style='color:#FF6B6B;padding:5px;border-radius:3px;'><i class='fa fa-battery-0'></i><br/>".number_format($hasil,2,',','.')."% <br/> IDR ".number_format($hasil2,2,',','.')." <br/>Over<br/>Insufficient Budget</div>";
										}else if($db->Total_Amount == $db->Real_Amount){
											echo "<div style='color:#FFBA00;padding:5px;border-radius:3px;'><i class='fa fa-battery-0'></i><br/>".number_format($hasil,2,',','.')."% <br/> IDR ".number_format($hasil2,2,',','.')." <br/>Free Space Budget <br/>Budget have been Used full</div>";
										}else if($db->Total_Amount/2 < $db->Real_Amount){
											echo "<div style='color:#B7C1D3;padding:5px;border-radius:3px;'><i class='fa fa-battery-1'></i><br/>".number_format($hasil,2,',','.')."% <br/> IDR ".number_format($hasil2,2,',','.')." <br/>Free Space Budget <br/>Budget have Available</div>";
										}else if($db->Total_Amount/2 == $db->Real_Amount){
											echo "<div style='color:#B7C1D3;padding:5px;border-radius:3px;'><i class='fa fa-battery-2'></i><br/>".number_format($hasil,2,',','.')."% <br/> IDR ".number_format($hasil2,2,',','.')." <br/>Free Space Budget <br/>Budget have Available</div>";
										}else if($db->Total_Amount/2 > $db->Real_Amount and $db->Real_Amount != 0){
											echo "<div style='color:#B7C1D3;padding:5px;border-radius:3px;'><i class='fa fa-battery-3'></i><br/>".number_format($hasil,2,',','.')."% <br/> IDR ".number_format($hasil2,2,',','.')." <br/>Free Space Budget <br/>Budget have Available</div>";
										}else if($db->Real_Amount == 0 or $db->Real_Amount == '' or $db->Real_Amount == null){
											echo "<div style='color:#B7C1D3;padding:5px;border-radius:3px;'><i class='fa fa-battery-4'></i><br/>".number_format($hasil,2,',','.')."% <br/> IDR ".number_format($hasil2,2,',','.')." <br/>Free Space Budget <br/>Budget have Available</div>";
										}?></td>
									<td><?php echo $db->Req_Status;?></td>
									<td>
										<a style="padding:5px 8px;color:#808CA0;font-size:14px;border-radius:100%;text-align:center" href="<?php echo base_url();?>index.php/application/req_realisasi/grid_modify/<?php echo $db->Req_No;?>">
											<div style="text-align:center;">
												<i style="font-size:28px;width:100%;float:left;" class="fa fa-check-circle-o"></i>
												<div style="text-align:center;width:100%;float:left;">Select</div>
											</div>
										</a>
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
			