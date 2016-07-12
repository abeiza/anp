	<script src="http://code.jquery.com/jquery-latest.min.js"
			type="text/javascript"></script>
	<link href="<?php echo base_url(); ?>assets/css/jquery.ui.datepicker.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.ui.theme.css" />

	<!--<script src="<?php //echo base_url(); ?>assets/js/jquery.js"></script>-->
	<!--<script src="<?php //echo base_url(); ?>assets/js/jquery.ui.datepicker.js"></script>
	<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/smoothness/jquery-ui.css" />
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script>
	$(function() {
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
	});
	</script>
	<style>
	.code{
		font-size:14px;
		margin-top:7px;
		margin-left:23%;
		float:left;
	}
	</style>
	<div class="main">
		<div class="container">
			<div style="padding:20px 0px;">
				<h3 style="color:#808CA0;display:inline;"><i class="fa fa-bar-chart" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 10px;"></i>Report Module</h3>
				<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url();?>index.php/application/req_realisasi/select_data/"><i class="fa fa-edit"></i> Budget Realisation (Modify)</a></div>
				<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Home <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Report Module</span></div>
			</div>
			<div style="background-color:#fff;width:100%;float:left">
				<div style="padding:20px;float:left;">
				<h4>Select Report</h4>
				<?php 
					$gaya = array("style"=>"width:450px;padding:20px;");
					echo form_open('application/report_controller/filter_data/',$gaya);
				?>
				<div style="width:100%;float:left;margin:3px 0px;">
					<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">From *</label>
					<input style="width:70%;background-color:#f5f5f5" class="input-text-login" id="period_start" name="from" type='text' readonly/>
					<div class="code" style="color:#FF6B6B;"><?php echo form_error('from'); ?></div>
				</div>
				<div style="width:100%;float:left;margin:3px 0px;">
					<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">To *</label>
					<input style="width:70%;background-color:#f5f5f5" class="input-text-login" id="period_end" name="to" type='text'/>
					<div class="code" style="color:#FF6B6B;"><?php echo form_error('to'); ?></div>
				</div>
				<div style="width:100%;float:left;margin:3px 0px;">
					<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Report Type *</label>
					<select style="width:70%" class="input-text-login" name="type"> 
						<option value="" selected disabled> -- Report Type -- </option>
						<option value="budget">All Request</option>
						<option value="real">All Realisation</option>
					</select>
					<div class="code" style="color:#FF6B6B;"><?php echo form_error('type'); ?></div>
					<div style="width:100%;float:right;">
						<button type="submit" class="btn default" style="float:right;margin-right:5%;" name="request"><i class="fa fa-filter" style="margin-right:5px;"></i>Filter</button>
					</div>
				</div>
				<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
			