			<script src="http://code.jquery.com/jquery-latest.min.js"
			type="text/javascript"></script>
			<div class="main">
				<div class="container">
					<div style="padding:20px 0px;">
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-plus" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 12px;"></i>Add Request Budget</h3>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_budget/grid_modify/'?>"><i class="fa fa-undo"></i> Back to grid</a></div>
						<?php echo $this->session->flashdata('update_result');?>
						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Request Budget <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Grid Requested Budget<i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Add Request Budget</span></div>
					</div>
					<div style="width:100%;">
						<?php echo form_open(); ?>
							<div style="width:50%;float:left;">
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Request No</label>
									<input style="width:100%;float:left;" type="text" name="req_no" />
								</div>
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Brand</label>
									<input style="width:100%;float:left;" type="text" name="ID_Brand" />
								</div>
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Request By</label>
									<input style="width:100%;float:left;" type="text" name="req_by" />
								</div>
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Manage By</label>
									<input style="width:100%;float:left;" type="text" name="manage_by" />
								</div>
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Program</label>
									<input style="width:100%;float:left;" type="text" name="ID_Program" />
								</div>
							</div>
							<div style="width:50%;float:left;">
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Period Start</label>
									<input style="width:100%;float:left;" type="text" name="period_start" />
								</div>
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Period End</label>
									<input style="width:100%;float:left;" type="text" name="period_end" />
								</div>
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Distributor Code</label>
									<input style="width:100%;float:left;" type="text" name="kode_distributor" />
								</div>
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Distriutor Name</label>
									<input style="width:100%;float:left;" type="text" name="nama_distributor" />
								</div>
								<div style="width:100%;float:left;">
									<label style="width:100%;float:left;">Seq No</label>
									<input style="width:100%;float:left;" type="text" name="seq_no" />
								</div>
							</div>
							<div style="width:100%;float:left;">
								<label style="width:100%;float:left;">Perpose</label>
								<textarea style="width:100%;float:left;" name="purpose"></textarea>
							</div>
							<div style="width:100%;float:left;">
								<label style="width:100%;float:left;">Specification</label>
								<textarea style="width:100%;float:left;" name="spec"></textarea>
							</div>
							<div style="width:50%;float:right;">
								<div style="width:100%;float:left;text-align:right;">
									<label style="width:100%;float:left;">Price</label>
									<input style="width:50%;float:right;" type="text" name="budget_price" />
								</div>
								<div style="width:100%;float:left;text-align:right;">
									<label style="width:100%;float:left;">Unit</label>
									<input style="width:50%;float:right;" type="text" name="budget_unit" />
								</div>
								<div style="width:100%;float:left;text-align:right;">
									<label style="width:100%;float:left;">Amount</label>
									<input style="width:50%;float:right;" type="text" name="budget_amount" />
								</div>
								<div style="width:100%;float:left;text-align:right;">
									<button type="submit" name="request">Process</button>
								</div>
							</div>
								
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>