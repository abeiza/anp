<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">jquery-confirm.min
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-confirm.min.css">
	</head>
	<body style="background-color:#f5f5f5">
		<div class="container-fluid-main">
			<div class="header">
				<div class="container">
					<div style="float:left;"><h1 style="color:#808CA0;padding-top:5px;">ANP & KSP</h1></div>
					
					<div style="float:left;margin:0px 20px;">
						<div style="float:left; background-color:#B7C1D3; color:#fff;padding:10px 13px;margin:7px 5px;border:1px solid #fff; border-radius:100px;"><a href="<?php echo base_url();?>index.php/application/master_user/profile_account/" style="color:#fff;"><i class="fa fa-user"></i></a></div>
						<div style="float:left; background-color:#B7C1D3; color:#fff;padding:10px 12px;margin:7px 5px;border:1px solid #fff; border-radius:100px;"><a id="logout" style="color:#fff;"><i class="fa fa-sign-out"></i></a></div>
					</div>
					
					<div style="float:left;margin:0px 20px;padding:20px 13px;color:#808CA0;font-weight:bold;">
						<span><i class="fa fa-info-circle" style="margin-right:5px;"></i>Welcome Back to ANP & KSP System, <u style="font-weight:normal;">Mr/Mrs. <?php echo $this->session->userdata('nama');?></u></span>
					</div>
					
					<div style="float:right;margin:0px 20px;">
						<div style="float:left;background-color:#B7C1D3; color:#fff;padding:10px 13px;margin:7px 5px;border:1px solid #fff; border-radius:100px;"><a href="#" style="color:#fff;"><i class="fa fa-gear"></i></a></div>
						<div style="float:left;background-color:#B7C1D3; color:#fff;padding:10px 12px;margin:7px 5px;border:1px solid #fff; border-radius:100px;"><a href="#" style="color:#fff;"><i class="fa fa-envelope"></i></a></div>
					</div>
				</div>
			</div>
			<div class="menu" style="border-bottom:1px solid #e1e1e1">
				<div class="container" style="margin-top:5px; margin-bottom:15px; padding:20px 0px;">
					<nav style="float:left;">
						<ul>
							<li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>Home</a></li>
							<li><a href="<?php echo base_url();?>index.php/application/master_brand"><i class="fa fa-book"></i>Master Brand</a></li>
							<li><a href="<?php echo base_url();?>index.php/application/master_program"><i class="fa fa-link"></i>Master Program</a></li>
							<li><a href="<?php echo base_url();?>index.php/application/req_budget"><i class="fa fa-bookmark"></i>Request Budget</a></li>
							<li><a href="<?php echo base_url();?>index.php/application/req_realisasi/"><i class="fa fa-usd"></i>Realisation Budget</a></li>
							<li><a href="<?php echo base_url();?>index.php/application/monitor_controller"><i class="fa fa-desktop"></i>Monitoring Budget</a></li>
							<li><a href="<?php echo base_url();?>index.php/application/report_controller/"><i class="fa fa-bar-chart"></i>Report</a></li>
						</ul>
					</nav>
					
					<div style="float:right;margin:0px 20px;margin-top:-5px;padding:0px 13px;color:#fff;font-weight:bold;">
						<i class="fa fa-search" style="color:#808CA0;font-size:14px;margin-right:5px;"></i><input style="padding:3px 10px;background-color:rgba(255, 255, 255, 0.4);border:1px solid transparent;border-radius:3px;" type="text" />
					</div>
				</div>
			</div>
