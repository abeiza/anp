<link href="<?php echo base_url(); ?>assets/css/jquery.ui.datepicker.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.ui.theme.css" />

<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.ui.datepicker.js"></script>
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/smoothness/jquery-ui.css" />
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.ui.core.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.ui.widget.js"></script>
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
<script>
$(function() {
	$("#TglTrans").datepicker({dateFormat: 'yy-mm-dd'});
	
	$(function(){
		var textbox3 = $("#req_id").val();
		//textbox3.value=result1.id;
		$.ajax({
			url:"<?php echo base_url();?>index.php/application/req_budget/get_items_grid/",
			cache:false,
			data:"id="+textbox3,
			type: "POST",
			dataType: 'json',
			success:function(result){
				//$("#table-grid option").remove();
				//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
				
				
				$.each(result, function(i, data){
				$('#grid-table tbody').append("<tr><td>"+data.Seq_No+"</td><td>"+data.Purpose+"</td><td>"+data.spec+"</td><td>"+currencyFormat(data.Budget_Price)+"</td><td>"+numberFormat(data.Budget_Unit)+"</td><td>"+currencyFormat(data.Budget_Amount)+"</td></tr>");
				});
				
				
				$.ajax({
					url:"<?php echo base_url();?>index.php/application/req_budget/get_total/",
					cache:false,
					data:"id="+textbox3,
					type: "POST",
					dataType: 'json',
					success:function(result){
						//$("#table-grid option").remove();
						//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
						
							document.getElementById('total_unit').value = 0;
							document.getElementById('total_amount').value = 0;
							document.getElementById('budget').value = 0;
						$.each(result, function(i, data){
							document.getElementById('total_unit').value = numberFormat(data.a);
							document.getElementById('total_amount').value = currencyFormat(data.b);
							document.getElementById('budget').value = data.b;
						});
					}
				});
			}
		});
	});				
});
</script>	
<div class="main">
	<div class="container">
		<div style="padding:20px 0px;">
			<h3 style="color:#808CA0;display:inline;"><i class="fa fa-pencil" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 12px;"></i>Edit Budget Realisation #<?php echo $this->uri->segment(4);?></h3>
			<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_realisasi/grid_modify/'.$this->uri->segment(4);?>"><i class="fa fa-undo"></i> Back to Realisation Data</a></div>
			<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Realisation Budget <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Select a Budget<i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Data Realisation <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Edit Realisation Budget</span></div>
		</div>
		<style>
			.info{
				display: none;
			}
			
			.info.show{
				display: block !important;
			}
			
			.code{
				font-size:14px;
				margin-top:7px;
				margin-left:10px;
				float:left;
			}
			
			table{
				margin:20px 0px;
			}
			
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
		<div style="width:100%;background-color:#fff;padding:10px 10px;float:left;">
			<?php echo form_open('application/req_realisasi/update_realisation/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
				<div style="width:100%;background:#fff;float:left;">
					<div class="click" style="width:100%;background-color:#f5f5f5;border-radius:3px;float:left;cursor:pointer">
						<div style="padding:20px;float:left;">
							<h3 style="width:100%;float:left;"><i class="fa fa-angle-double-down" style="font-size:18px;margin-right:5px;"></i>Detail Information</h3>
							<span>Request Budget No. <?php echo $this->uri->segment(4);?></span>
						</div>
					</div>
					<div class="info" style="padding:20px;float:left;">
					<?php 
						foreach($query_budget->result() as $db){
					?>
					<div style="width:50%;float:left;">
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">ObjectID </div>
							<input type="text" id="req_id"style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;" value='<?php echo $db->ObjectID;?>' readonly/>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Request No </div>
							<input type="text" style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;" value='<?php echo $db->Req_No;?>'/>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Request Date </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Req_Date;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Brand </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->ID_Brand.' - '.$db->Brand;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Request By </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Req_By;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Manage By </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Manage_By;?></div>
						</div>
					</div>
					<div style="width:50%;float:left;">
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Program </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->ID_Program.' - '.$db->Sub_Program_Type;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Request Type </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Request_Type;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Program Type </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Program_Type;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Period Start </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Period_Start;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Period End </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Period_End;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Distributor Code </div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Kode_Distributor;?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:20%;float:left;">Distributor Name</div>
							<div style="width:60%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Nama_Distributor;?></div>
						</div>
					</div>
						<div style="width:100%;float:left;margin:3px 0px;">
							<table id="grid-table" style="border:1px solid #e1e1e1;border-collapse:collapse;width:100%;">
								<thead>
									<tr style="font-weight:bold;">
										<td>Seq No.</td>
										<td>Purpose</td>
										<td>Specification</td>
										<td>Price</td>
										<td>Qty</td>
										<td>Amount</td>
									</tr>
								</thead>
								<tbody>
									<!--<tr>
										<td>Request No</td>
										<td>Purpose</td>
										<td>Specification</td>
										<td>Price</td>
										<td>Qty</td>
										<td>Amount</td>
										<td style="border-right:transparent;width:25px;"><a style="float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" class="edit" id="1"><i class="fa fa-pencil"></i></a></td>
										<td style="border-left:transparent;width:25px;"><a style="float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" class="delete" id="1"><i class="fa fa-trash"></i></a></td>
									</tr>
									<tr>
										<td>Request No</td>
										<td>Purpose</td>
										<td>Specification</td>
										<td>Price</td>
										<td>Qty</td>
										<td>Amount</td>
										<td style="border-right:transparent;width:25px;"><a style="float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" class="edit" id="1"><i class="fa fa-pencil"></i></a></td>
										<td style="border-left:transparent;width:25px;"><a style="float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" class="delete" id="1"><i class="fa fa-trash"></i></a></td>
									</tr>
									<tr>
										<td>Request No</td>
										<td>Purpose</td>
										<td>Specification</td>
										<td>Price</td>
										<td>Qty</td>
										<td>Amount</td>
										<td style="border-right:transparent;width:25px;"><a style="float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" class="edit" id="1"><i class="fa fa-pencil"></i></a></td>
										<td style="border-left:transparent;width:25px;"><a style="float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;" class="delete" id="1"><i class="fa fa-trash"></i></a></td>
									</tr>-->
								</tbody>
							</table>
						</div>
						
						<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Total Unit </div>
							<input style="width:30%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;" readonly type="text" name="budget_unit" id="total_unit"/>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Total Amount </div>
							<input style="width:30%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;" readonly type="text" name="budget_amount" id="total_amount"/>
							<input style="width:30%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;" readonly type="hidden" name="budget" id="budget"/>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Realisation Amount</div>
							<input id="real" style="width:30%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;" readonly value="<?php if($db->Real_Amount == ''){echo '0';}else{echo 'IDR '. number_format($db->Real_Amount,0, '.',',');}?>"/>
							<input id="real1" type="hidden" style="width:30%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;" readonly value="<?php if($db->Real_Amount == ''){echo '0';}else{echo $db->Real_Amount;}?>"/>
						</div><div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Request Status</div>
							<div style="width:30%;float:left;border:1px solid #fff;background-color:#f5f5f5;padding:5px;margin:2px;border-radius:3px;"><?php echo $db->Req_Status;?></div>
						</div>
					<?php
						}
					?>
					</div>
				</div>
				<div style="width:100%;background:#fff;float:left;">
					<div style="padding:20px;float:left;cursor:pointer">
						<div style="width:100%;float:left;">
							<h3 style="width:100%;float:left;"><i class="fa fa-edit" style="font-size:18px;margin-right:5px;"></i>Form Realisation</h3>
							<?php echo $this->session->flashdata('update_result');?>
						</div>
					</div>
					<div style="padding:20px;float:left;">
						<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Transaction Date* </div>	
							<input class="input-text-login" style="width:30%;margin:2px 0px;background-color:#f5f5f5" type="text" name="TglTrans" id="TglTrans" value="<?php echo $TglTrans;?>" readonly/>
							<div class="code" style="color:#FF6B6B;"><?php echo form_error('TglTrans'); ?></div>
						</div>
						<!--<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Seq No. </div>	
							<input class="input-text-login" style="width:70%;margin:2px 0px;" type="text" name="Seq_No" value="<?php //echo $Seq_No;?>"/>
						</div>-->
						<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Real Price* </div>	
							<input type="number" class="input-text-login" style="width:30%;margin:2px 0px;text-align:right" type="text" name="Real_Price" id="price" onchange="findTotal();bugetOver();" value="<?php echo $Real_Price;?>"/>
							<div class="code" style="color:#FF6B6B;"><?php echo form_error('Real_Price'); ?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Unit* </div>	
							<input type="number" class="input-text-login" style="width:30%;margin:2px 0px;text-align:right" name="Real_Unit" id="unit" onchange="findTotal();bugetOver();" value="<?php echo $Real_Unit;?>"/>
							<div class="code" style="color:#FF6B6B;"><?php echo form_error('Real_Unit'); ?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">Amount* </div>	
							<input type="number" class="input-text-login" style="width:30%;margin:2px 0px;text-align:right;background-color:#e5e5e5" id="total" name="Real_Amount" readonly value="<?php echo $Real_Amount;?>"/>
							<input type="hidden" class="input-text-login" style="width:30%;margin:2px 0px;text-align:right;background-color:#e5e5e5" type="text" id="total1" readonly value="<?php echo $Real_Amount;?>"/>
							<div id="sta" class="code"></div>
							<div class="code" style="color:#FF6B6B;"><?php echo form_error('Real_Amount'); ?></div>
						</div>
						<div style="width:100%;float:left;">
							<div style="width:10%;float:left;">&nbsp;</div>	
							<button type="submit" class="btn default" style="margin-right:5%;" name="realisasi"><i class="fa fa-pencil" style="margin-right:5px"></i>Update</button>
						</div>
					</div>
				</div>
			<?php echo form_close();?>
		</div>
	<script>
	var acc = document.getElementsByClassName("click");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].onclick = function(){
			this.classList.toggle("active");
			this.nextElementSibling.classList.toggle("show");
	  }
	}
	</script>
	<script type="text/javascript">
		function findTotal(){
			if(document.getElementById("price").value == ''){
				var price1 = 0;
			}else{
				var price1 = document.getElementById("price").value;
			}
			
			if(document.getElementById("unit").value == ''){
				var unit1 = 0;
			}else{
				var unit1 = document.getElementById("unit").value;
			}
			
			var hasil = parseInt(price1) * parseInt(unit1);
			document.getElementById("total").value = hasil;
		}
		
		function bugetOver(){
			if(document.getElementById("budget").value < parseInt(document.getElementById("real1").value)-parseInt(document.getElementById("total1").value)+parseInt(document.getElementById("total").value)){
				$("#sta").empty();
				$("#sta").append("<div class='code' style='color:#FF6B6B;'><i class='fa fa-ban' style='margin-right:5px;'></i>Insufficient Funds</div>");
			}else{
				$("#sta").empty();
				$("#sta").append("<div class='code' style='color:#79bbaf;'><i class='fa fa-check' style='margin-right:5px;'></i>Funds have available</div>");
			}
		}
	</script>
	</div>
</div>