			<script src="http://code.jquery.com/jquery-latest.min.js"
			type="text/javascript"></script>
			<link href="<?php echo base_url(); ?>assets/css/jquery.ui.datepicker.css" rel="stylesheet">
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.ui.theme.css" />
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
			<!--<script src="<?php //echo base_url(); ?>assets/js/jquery.js"></script>-->
			<!--<script src="<?php //echo base_url(); ?>assets/js/jquery.ui.datepicker.js"></script>
			<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">-->
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/smoothness/jquery-ui.css" />
			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
			<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
			<!--<script src="<?php //echo base_url();?>assets/js/jquery.ui.core.js"></script>
			<script src="<?php //echo base_url();?>assets/js/jquery.ui.widget.js"></script>-->
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
				
				function grid_item(data1){
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/get_items_grid/",
						cache:false,
						data:"id="+data1,
						type: "POST",
						dataType: 'json',
						success:function(result){
							//$("#table-grid option").remove();
							//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
							
							
							$.each(result, function(i, data){
							$('#grid-table tbody').append("<tr><td>"+data.Seq_No+"</td><td>"+data.Purpose+"</td><td>"+data.spec+"</td><td>"+currencyFormat(data.Budget_Price)+"</td><td>"+numberFormat(data.Budget_Unit)+"</td><td>"+currencyFormat(data.Budget_Amount)+"</td><td style='border-right:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' onclick='edit_data($(this))' class='edit_item' id='"+data.Seq_No+"'><i class='fa fa-pencil'></i></a></td><td style='border-left:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' id='"+data.Seq_No+"' class='delete_item' onclick='delete_data($(this))'><i class='fa fa-trash'></i></a></td></tr>");
							});
						}
					});
				}
				
				function total_data(data){
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/get_total/",
						cache:false,
						data:"id="+data,
						type: "POST",
						dataType: 'json',
						success:function(result){
							//$("#table-grid option").remove();
							//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
							
								document.getElementById('total_unit').value = 0;
								document.getElementById('total_amount').value = 0;
								document.getElementById('total_unit1').value = 0;
								document.getElementById('total_amount1').value = 0;
							$.each(result, function(i, data){
								document.getElementById('total_unit').value = data.a;
								document.getElementById('total_amount').value = data.b;
								document.getElementById('total_unit1').value = numberFormat(data.a);
								document.getElementById('total_amount1').value = currencyFormat(data.b);
							});
						}
					});
				}
			</script>
			<script>
				$(function() {
					/*$("body").bind("ajaxComplete", function(e, xhr, settings){
						var textbox3 = document.getElementById('req_id');
						total_data(textbox3.value);
						grid_item(textbox3.value);
					});*/
					
					$( "#period_start" ).datepicker({
						defaultDate: "+1w",
						changeMonth: true,
						numberOfMonths: 3,
						onClose: function( selectedDate ) {
							$( "#period_end" ).datepicker( "option", "minDate", selectedDate );
						}
					});
					
					$( "#period_end" ).datepicker({
						defaultDate: "+1w",
						changeMonth: true,
						numberOfMonths: 3,
						onClose: function( selectedDate ) {
							$( "#period_start" ).datepicker( "option", "maxDate", selectedDate );
						}
					});
				
				$(function(){
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/get_outlet/",
						cache:false,
						dataType: 'json',
						success:function(result){
							//alert(result);
							$("#kode option").remove();
							$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
							$.each(result, function(i, data){
							$('#kode').append("<option value='"+data.CustomerID+"'>"+data.CustomerID+" - "+data.CustomerName+"</option>");
							});
						}
					});
				});
				
				$(function(){
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/generate_id/",
						cache:false,
						dataType: 'json',
						success:function(result1){
							//alert(result);
							var textbox3 = document.getElementById('req_id');
							textbox3.value=result1.id;
							
							grid_item(result1.id);
							total_data(result1.id);
							
							/*$.ajax({
								url:"<?php echo base_url();?>index.php/application/req_budget/get_items_grid/",
								cache:false,
								data:"id="+result1.id,
								type: "POST",
								dataType: 'json',
								success:function(result){
									//$("#table-grid option").remove();
									//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
									
									
									$.each(result, function(i, data){
									$('#grid-table tbody').append("<tr><td>"+data.Seq_No+"</td><td>"+data.Purpose+"</td><td>"+data.spec+"</td><td>"+currencyFormat(data.Budget_Price)+"</td><td>"+numberFormat(data.Budget_Unit)+"</td><td>"+currencyFormat(data.Budget_Amount)+"</td><td style='border-right:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' onclick='edit_data($(this))' class='edit_item' id='"+data.Seq_No+"'><i class='fa fa-pencil'></i></a></td><td style='border-left:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' id='"+data.Seq_No+"' class='delete_item' onclick='delete_data($(this))'><i class='fa fa-trash'></i></a></td></tr>");
									});
									
									
									/*$.ajax({
										url:"<?php echo base_url();?>index.php/application/req_budget/get_total/",
										cache:false,
										data:"id="+result1.id,
										type: "POST",
										dataType: 'json',
										success:function(result){
											//$("#table-grid option").remove();
											//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
											
												document.getElementById('total_unit').value = 0;
												document.getElementById('total_amount').value = 0;
												document.getElementById('total_unit1').value = 0;
												document.getElementById('total_amount1').value = 0;
											$.each(result, function(i, data){
												document.getElementById('total_unit').value = data.a;
												document.getElementById('total_amount').value = data.b;
												document.getElementById('total_unit1').value = numberFormat(data.a);
												document.getElementById('total_amount1').value = currencyFormat(data.b);
											});
										}
									});
								}
							});
						*/}
					});
				});
				
				$("#req_no").change(function(){
					id=$("#req_no").val();
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/get_validation/",
						data:"id="+id,
						cache:false,
						dataType: 'json',
						success:function(data){
							$('#stat').html(data.status).fadeIn('slow', function() {
								$('#stat').css({'color': '#' + data.color});
								
								var html = document.getElementById("stat").innerHTML;
								//alert(html);
								if(html == 'available'){
									$('#item').css({'pointer-events': 'auto'});
								}else{
									$('#item').css({'pointer-events': 'none'});
								}
							});
						}
					});
				});
				
				$("#insert_item").click(function(){
					document.getElementById('seq').value = '';
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/insert_item/",
						data:{
							object:$("#req_id").val(),
							purpose:$("#purpose").val(),
							spec:$("#spec").val(),
							price:$("#price").val(),
							qty:$("#qty").val(),
							amount:$("#amount").val()
						},
						cache:false,
						type: "POST",
						dataType: 'json',
						success:function(data){
							$.ajax({
								url:"<?php echo base_url();?>index.php/application/req_budget/get_items_grid/",
								cache:false,
								data:"id="+$("#req_id").val(),
								type: "POST",
								dataType: 'json',
								success:function(result){
									document.getElementById('purpose').value = '';
									document.getElementById('spec').value = '';
									document.getElementById('price').value = '';
									document.getElementById('qty').value = '';
									document.getElementById('amount').value = '';
									$("#grid-table tbody tr").remove();
									//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
									
									
									$.each(result, function(i, data){
									$('#grid-table tbody').append("<tr><td>"+data.Seq_No+"</td><td>"+data.Purpose+"</td><td>"+data.spec+"</td><td>"+currencyFormat(data.Budget_Price)+"</td><td>"+numberFormat(data.Budget_Unit)+"</td><td>"+currencyFormat(data.Budget_Amount)+"</td><td style='border-right:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' onclick='edit_data($(this))' class='edit_item' id='"+data.Seq_No+"'><i class='fa fa-pencil'></i></a></td><td style='border-left:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' id='"+data.Seq_No+"' class='delete_item' onclick='delete_data($(this))'><i class='fa fa-trash'></i></a></td></tr>");
									});
									
									$.ajax({
										url:"<?php echo base_url();?>index.php/application/req_budget/get_total/",
										cache:false,
										data:"id="+$("#req_id").val(),
										type: "POST",
										dataType: 'json',
										success:function(result){
											//$("#table-grid option").remove();
											//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
											
												document.getElementById('total_unit').value = 0;
												document.getElementById('total_amount').value = 0;
												document.getElementById('total_unit1').value = 0;
												document.getElementById('total_amount1').value = 0;
											$.each(result, function(i, data){
												document.getElementById('total_unit').value = data.a;
												document.getElementById('total_amount').value = data.b;
												document.getElementById('total_unit1').value = numberFormat(data.a);
												document.getElementById('total_amount1').value = currencyFormat(data.b);
											});
										}
									});
								}
							});
							/*$('#stat-item').html(data.status).fadeIn('slow', function() {
								$('#stat-item').css({'color': '#' + data.color});
								
								var html = document.getElementById("stat").innerHTML;
								//alert(html);
								if(html == 'available'){
									$('#item').css({'pointer-events': 'auto'});
								}else{
									$('#item').css({'pointer-events': 'none'});
								}
							});*/
						}
					});
				});
				
				$("#clean_item").click(function(){
					document.getElementById('seq').value = '';
					document.getElementById('purpose').value = '';
					document.getElementById('spec').value = '';
					document.getElementById('price').value = '';
					document.getElementById('qty').value = '';
					document.getElementById('amount').value = '';
				});
				
				$("#update_item").click(function(){
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/update_item/",
						data:{
							object:$("#req_id").val(),
							seq:$("#seq").val(),
							purpose:$("#purpose").val(),
							spec:$("#spec").val(),
							price:$("#price").val(),
							qty:$("#qty").val(),
							amount:$("#amount").val()
						},
						cache:false,
						type: "POST",
						dataType: 'json',
						success:function(data){
							$.ajax({
								url:"<?php echo base_url();?>index.php/application/req_budget/get_items_grid/",
								cache:false,
								data:"id="+$("#req_id").val(),
								type: "POST",
								dataType: 'json',
								success:function(result){
									document.getElementById('seq').value = '';
									document.getElementById('purpose').value = '';
									document.getElementById('spec').value = '';
									document.getElementById('price').value = '';
									document.getElementById('qty').value = '';
									document.getElementById('amount').value = '';
									$("#grid-table tbody tr").remove();
									//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
									
									
									$.each(result, function(i, data){
									$('#grid-table tbody').append("<tr><td>"+data.Seq_No+"</td><td>"+data.Purpose+"</td><td>"+data.spec+"</td><td>"+currencyFormat(data.Budget_Price)+"</td><td>"+numberFormat(data.Budget_Unit)+"</td><td>"+currencyFormat(data.Budget_Amount)+"</td><td style='border-right:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' onclick='edit_data($(this))' class='edit_item' id='"+data.Seq_No+"'><i class='fa fa-pencil'></i></a></td><td style='border-left:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' id='"+data.Seq_No+"' class='delete_item' onclick='delete_data($(this))'><i class='fa fa-trash'></i></a></td></tr>");
									});
									
									$.ajax({
										url:"<?php echo base_url();?>index.php/application/req_budget/get_total/",
										cache:false,
										data:"id="+$("#req_id").val(),
										type: "POST",
										dataType: 'json',
										success:function(result){
											//$("#table-grid option").remove();
											//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
											
												document.getElementById('total_unit').value = 0;
												document.getElementById('total_amount').value = 0;
												document.getElementById('total_unit1').value = 0;
												document.getElementById('total_amount1').value = 0;
											$.each(result, function(i, data){
												document.getElementById('total_unit').value = data.a;
												document.getElementById('total_amount').value = data.b;
												document.getElementById('total_unit1').value = numberFormat(data.a);
												document.getElementById('total_amount1').value = currencyFormat(data.b);
											});
										}
									});
								}
							});
							/*$('#stat-item').html(data.status).fadeIn('slow', function() {
								$('#stat-item').css({'color': '#' + data.color});
								
								var html = document.getElementById("stat").innerHTML;
								//alert(html);
								if(html == 'available'){
									$('#item').css({'pointer-events': 'auto'});
								}else{
									$('#item').css({'pointer-events': 'none'});
								}
							});*/
						}
					});
				});
			});
			</script>
			<script>
				function edit_data(e){
					var element = e.attr('id');
					//alert(element);
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/edit_data_item/",
						cache:false,
						data:{
							id:element,
							kode:$("#req_id").val()
						},
						type: "POST",
						dataType: 'json',
						success:function(result){
							//$("#table-grid option").remove();
							//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
								document.getElementById('seq').value = '';
								document.getElementById('purpose').value = '';
								document.getElementById('spec').value = '';
								document.getElementById('price').value = '';
								document.getElementById('qty').value = '';
								document.getElementById('amount').value = '';
							$.each(result, function(i, data){
								//document.getElementById('total_unit').value = data.Seq_No;
								document.getElementById('seq').value = data.Seq_No;
								document.getElementById('purpose').value = data.Purpose;
								document.getElementById('spec').value = data.spec;
								document.getElementById('price').value = data.Budget_Price;
								document.getElementById('qty').value = data.Budget_Unit;
								document.getElementById('amount').value = data.Budget_Amount;
							});
						}
					});
				}
				
				function delete_data(e){
					var element = e.attr('id');
					//alert(element);
					$.ajax({
						url:"<?php echo base_url();?>index.php/application/req_budget/delete_data_item/",
						cache:false,
						data:{
							id:element,
							kode:$("#req_id").val()
						},
						type: "POST",
						dataType: 'json',
						success:function(result){
							$.ajax({
								url:"<?php echo base_url();?>index.php/application/req_budget/get_items_grid/",
								cache:false,
								data:"id="+$("#req_id").val(),
								type: "POST",
								dataType: 'json',
								success:function(result){
									document.getElementById('purpose').value = '';
									document.getElementById('spec').value = '';
									document.getElementById('price').value = '';
									document.getElementById('qty').value = '';
									document.getElementById('amount').value = '';
									$("#grid-table tbody tr").remove();
									//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
									
									
									$.each(result, function(i, data){
									$('#grid-table tbody').append("<tr><td>"+data.Seq_No+"</td><td>"+data.Purpose+"</td><td>"+data.spec+"</td><td>"+currencyFormat(data.Budget_Price)+"</td><td>"+numberFormat(data.Budget_Unit)+"</td><td>"+currencyFormat(data.Budget_Amount)+"</td><td style='border-right:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' onclick='edit_data($(this))' class='edit_item' id='"+data.Seq_No+"'><i class='fa fa-pencil'></i></a></td><td style='border-left:transparent;width:25px;'><a style='float:left;text-decoration:none;color:#fff;font-size:14px;padding:5px 8px;background-color:#808CA0;border-radius:100%;' id='"+data.Seq_No+"' class='delete_item' onclick='delete_data($(this))'><i class='fa fa-trash'></i></a></td></tr>");
									});
									
									$.ajax({
										url:"<?php echo base_url();?>index.php/application/req_budget/get_total/",
										cache:false,
										data:"id="+$("#req_id").val(),
										type: "POST",
										dataType: 'json',
										success:function(result){
											//$("#table-grid option").remove();
											//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
											
												document.getElementById('total_unit').value = 0;
												document.getElementById('total_amount').value = 0;
												document.getElementById('total_unit1').value = 0;
												document.getElementById('total_amount1').value = 0;
											$.each(result, function(i, data){
												document.getElementById('total_unit').value = data.a;
												document.getElementById('total_amount').value = data.b;
												document.getElementById('total_unit1').value = numberFormat(data.a);
												document.getElementById('total_amount1').value = currencyFormat(data.b);
											});
										}
									});
								}
							});
							//$("#table-grid option").remove();
							//$("#kode").append('<option value="" selected disabled> -- Select Distributor -- </option>');
							
							/*	document.getElementById('purpose').value = '';
								document.getElementById('spec').value = '';
								document.getElementById('price').value = '';
								document.getElementById('qty').value = '';
								document.getElementById('amount').value = '';
							$.each(result, function(i, data){
								//document.getElementById('total_unit').value = data.Seq_No;
								document.getElementById('purpose').value = data.Purpose;
								document.getElementById('spec').value = data.spec;
								document.getElementById('price').value = data.Budget_Price;
								document.getElementById('qty').value = data.Budget_Unit;
								document.getElementById('amount').value = data.Budget_Amount;
							});*/
						}
					});
				}
			</script>
			
			<div class="main">
				<div class="container">
					<div style="padding:20px 0px;">
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-plus" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 12px;"></i>Add Request Budget</h3>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_budget/grid_modify/'?>"><i class="fa fa-undo"></i> Back to Budget Modify List</a></div>
						<?php echo $this->session->flashdata('add_result')?>
						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Request Budget <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Grid Requested Budget<i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Add Request Budget</span></div>
					</div>
					<div style="background-color:#fff;padding:50px 20px;float:left;">
						<?php 
							$attribute = array("style"=>"width:100%;float:left;");
							echo form_open('application/req_budget/action_add/',$attribute); 
						?>	
							<h3 style="margin:20px;">Form Add Request</h3>
							<div style="width:50%;float:left;">
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Request No *</label>
									<input class="input-text-login" style="width:50%" type="hidden" name="req_id" id="req_id"/>
									<input class="input-text-login" style="width:50%" type="text" name="req_no" id="req_no"/>
									<div id="stat" style="float:left;margin:10px;"></div>
								</div>
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Brand *</label>
									<?php $query_brand = $this->db->query("select * from tbl_ANPKSP_Brand order by Brand");?>
									<select class="input-text-login" style="width:70%" name="brand">
										<option value="" disabled selected> --Select Brand--</option>
										<?php foreach($query_brand->result() as $brand){
											echo "<option value='".$brand->ID_Brand."'>".$brand->Brand."</option>";
										}?>
									</select>
								</div>
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Request By</label>
									<input class="input-text-login" style="width:70%" type="text" name="req_by" />
								</div>
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Manage By</label>
									<input class="input-text-login" style="width:70%" type="text" name="manage_by" />
								</div>
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Program *</label>
									<?php $query_program = $this->db->query("select * from tbl_ANPKSP_MsProgram order by Sub_Program_Type");?>
									<select class="input-text-login" style="width:70%" name="program">
										<option value="" disabled selected> --Select Program--</option>
										<?php foreach($query_program->result() as $program){
											echo "<option value='".$program->ID_Program."'>".$program->Sub_Program_Type."</option>";
										}?>
									</select>
								</div>
							</div>
							<div style="width:50%;float:left;">
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Period Start *</label>
									<input class="input-text-login" style="width:70%;background-color:#f5f5f5;" type="text" name="period_start" id="period_start" readonly/>
								</div>
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Period End *</label>
									<input class="input-text-login" style="width:70%;background-color:#f5f5f5;" type="text" name="period_end" id="period_end" readonly/>
								</div>
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Distributor Code</label>
									<select id="kode" name="kode" class="input-text-login" style="width:70%">
										<option value="" selected disabled> -- Select Distributor -- </option>
									</select>
								</div>
							</div>
							<div id="item" style="width:100%;float:left;">
							<div style="padding:20px;border-top:1px solid #eee;border-bottom:1px solid #eee;float:left;margin:20px 0px;">
								<div style="width:100%;float:left;">
									<div style="width:22.5%;float:left;margin:3px 0px;margin-right:20px;">
										<label style="float:left;width:100%;font-size:14px;padding:5px 0px;color:#666;padding-right:10px;">Purpose</label>
										<textarea class="input-text-login" style="width:95%;height:100px" name="purpose" id="purpose"></textarea>
										<input class="input-text-login" style="width:95%;" type="hidden" name="seq" id="seq"/>
									</div>
									<div style="width:22.5%;float:left;margin:3px 0px;margin-right:15px;">
										<label style="float:left;width:100%;font-size:14px;padding:5px 0px;color:#666;padding-right:10px;">Spec</label>
										<textarea class="input-text-login" style="width:95%;height:100px;" name="spec" id="spec"></textarea>
									</div>
									<div style="width:12%;float:left;margin:3px 0px;margin-right:20px;">
										<label style="float:left;width:100%;font-size:14px;padding:5px 0px;color:#666;padding-right:10px;">Price *</label>
										<input class="input-text-login" style="width:95%;" type="text" name="price" id="price" onchange="findTotal()"/>
									</div>
									<div style="width:3%;float:left;margin:3px 0px;margin-right:28px;">
										<label style="float:left;width:100%;font-size:14px;padding:5px 0px;color:#666;padding-right:10px;">Qty *</label>
										<input class="input-text-login" style="width:95%;" type="text" name="qty" id="qty" onchange="findTotal()"/>
									</div>
									<div style="width:15%;float:left;margin:3px 0px;margin-right:20px;">
										<label style="float:left;width:100%;font-size:14px;padding:5px 0px;color:#666;padding-right:10px;">Amount *</label>
										<input class="input-text-login" style="width:95%;background-color:#f5f5f5;" type="text" name="amount" id="amount" readonly/>
									</div>
									<div style="width:10%;float:left;margin:3px 0px;margin-right:20px;">
										<a id="insert_item" style="float:left;margin-top:30px;text-decoration:none;color:#808CA0;font-size:14px;padding:5px 8px;margin-right:1px;background-color:transparent;border-radius:100%;">
											<div class="tooltip"><i class="fa fa-plus"></i>
											  <span class="tooltiptext">Add Data</span>
											</div>
										</a>
										<a id="update_item" style="float:left;margin-top:30px;text-decoration:none;color:#808CA0;font-size:14px;padding:5px 7px;margin-left:1px;background-color:transparent;border-radius:100%;">
											<div class="tooltip"><i class="fa fa-edit"></i>
											  <span class="tooltiptext">Update Data</span>
											</div>
										</a>
										<a id="clean_item" style="float:left;margin-top:30px;text-decoration:none;color:#808CA0;font-size:14px;padding:5px 7px;margin-left:1px;background-color:transparent;border-radius:100%;">
											<div class="tooltip"><i class="fa fa-ban"></i>
											  <span class="tooltiptext">Clean</span>
											</div>
										</a>
									</div>
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
											<td colspan="2" style="text-align:center;">Action</td>
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
							</div>
							</div>
							<div style="width:50%;float:right;">
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Total Unit *</label>
									<input class="input-text-login" style="width:70%;text-align:right;background-color:#f5f5f5" type="hidden" name="budget_unit" id="total_unit" readonly/>
									<input class="input-text-login" style="width:70%;text-align:right;background-color:#f5f5f5" type="text" name="budget_unit1" id="total_unit1" readonly/>
								</div>
								<div style="width:100%;float:left;margin:3px 0px;">
									<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Total Amount *</label>
									<input class="input-text-login" style="width:70%;text-align:right;background-color:#f5f5f5" type="hidden" name="budget_amount" id="total_amount" readonly/>
									<input class="input-text-login" style="width:70%;text-align:right;background-color:#f5f5f5" type="text" name="budget_amount1" id="total_amount1" readonly/>
								</div>
								<div style="width:100%;float:right;">
									<button type="submit" class="btn default" style="float:right;margin-right:5%;" name="request"><i class="fa fa-check" style="margin-right:5px;"></i>Process</button>
								</div>
							</div>
							<div style="width:50%;float:right;">
								<div style="padding-left:20px;color:#FF6B6B !important"><h6><i class="fa fa-info-circle"></i> Field yang bertanda * harus diisi.</h6></div>
							</div>
							<div style="width:50%;float:right;">
								<div style="padding-left:23%;padding-top:20px;font-size:14px;color:#FF6B6B !important"><?php echo validation_errors();?></div>
							</div>
								
						<?php echo form_close(); ?>
						<script type="text/javascript">
							function findTotal(){
								if(document.getElementById("price").value == ''){
									var price1 = 0;
								}else{
									var price1 = document.getElementById("price").value;
								}
								
								if(document.getElementById("qty").value == ''){
									var unit1 = 0;
								}else{
									var unit1 = document.getElementById("qty").value;
								}
								
								var hasil = parseInt(price1) * parseInt(unit1);
								document.getElementById("amount").value = hasil;
							}
						</script>
					</div>
				</div>
			</div>