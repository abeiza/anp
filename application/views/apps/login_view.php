<!DOCTYPE html>
<html>
	<head>
		<title>Login Form | KSP and NSP Application</title>
	</head>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<body>
		<div class="container-fluid" style="background-color:#ddd">
			<div style="width:450px;background-color:#f5f5f5;margin:auto;padding:0px 0px;box-shadow:0 0 12px rgba(0, 0, 0, 0.6)">
				<div style="background-color:#fff;">
					<div class="container" style="margin-top:0;padding:10px 0px;color:#808CA0">
						<h2>Login</h2>
						<span>Welcome to ANP/KSP System</span>
					</div>
				</div>
				<div class="container" style="float:left;">
					<?php echo $this->session->flashdata('login_result')?>
					<?php
						$attribute = array("style"=>"padding:20px 0px;float:left;");
						echo form_open('application/login/action_validation/',$attribute);
					?>
						<label style="float:left;width:50%;font-size:14px;padding:5px 0px;color:#666;">Username</label>
						<div style="float:left;width:50%;margin-top:10px;text-align:right;color:#FF6B6B !important"><?php echo form_error('email'); ?></div>
						<input class="input-text-login" type="text" name="email"/>
						<label style="float:left;width:50%;font-size:14px;padding:5px 0px;color:#666;">Password</label>
						<div style="float:left;width:50%;margin-top:10px;text-align:right;color:#FF6B6B !important"><?php echo form_error('password'); ?></div>
						<input class="input-text-login" type="password" name="password"/>
						<button class="btn default" style="border-radius:3px;margin-top:10px;float:left" type="submit"><i class="fa fa-send" style="margin-right:10px;"></i>Login</button>
						<div style="float:right;width:50%;text-align:right;color:#79bbaf;margin-left:-20px;margin-top:20px"><i class="fa fa-usb"></i>Develop by Evan Abeiza | 2016</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</body>
</html>