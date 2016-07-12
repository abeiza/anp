	<script src="http://code.jquery.com/jquery-latest.min.js"
			type="text/javascript"></script>
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
				<h3 style="color:#808CA0;display:inline;"><i class="fa fa-user" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px;"></i>Profile Account</h3>
				<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url();?>index.php/application/req_realisasi/select_data/"><i class="fa fa-edit"></i> Budget Realisation (Modify)</a></div>
				<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Home <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Profile Account</span></div>
			</div>
			<div style="background-color:#fff;width:100%;float:left">
				<div style="padding:20px;float:left;">
				<h4>Data Account</h4>
				<?php echo $this->session->flashdata('update_result')?>
				<?php 
					$gaya = array("style"=>"width:450px;padding:20px;");
					echo form_open('application/master_user/update_account/',$gaya);
				?>
				<div style="width:100%;float:left;margin:3px 0px;">
					<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Your Email *</label>
					<input style="width:70%;background-color:#f5f5f5" class="input-text-login" name="id" type='hidden' value="<?php echo $id;?>" readonly/>
					<input style="width:70%;" class="input-text-login" name="email" type='text' value="<?php echo $email;?>"/>
					<div class="code" style="color:#FF6B6B;"><?php echo form_error('email'); ?></div>
				</div>
				<div style="width:100%;float:left;margin:3px 0px;">
					<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Your Name *</label>
					<input style="width:70%;" class="input-text-login" name="name" type='text' value="<?php echo $name;?>"/>
					<div class="code" style="color:#FF6B6B;"><?php echo form_error('name'); ?></div>
				</div>
				<div style="width:100%;float:left;margin:3px 0px;">
					<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Password Old *</label>
					<input style="width:70%;background-color:#f5f5f5" class="input-text-login" id="period_end" name="old" type='password' value="<?php echo $old;?>" readonly/>
					<div class="code" style="color:#FF6B6B;"><?php echo form_error('old'); ?></div>
				</div>
				<div style="width:100%;float:left;margin:3px 0px;">
					<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">New Password *</label>
					<input style="width:70%;" class="input-text-login" id="period_end" name="new" type='password'/>
					<div class="code" style="color:#FF6B6B;"><?php echo form_error('new'); ?></div>
				</div>
				<div style="width:100%;float:left;margin:3px 0px;">
					<label style="float:left;width:20%;font-size:14px;padding:5px 0px;color:#666;text-align:right;padding-right:10px;">Confirm Password *</label>
					<input style="width:70%;" class="input-text-login" id="period_end" name="confirm" type='password'/>
					<div class="code" style="color:#FF6B6B;"><?php echo form_error('confirm'); ?></div>
				</div>
				<div style="width:100%;float:right;">
						<button type="submit" class="btn default" style="float:right;margin-right:5%;" name="request"><i class="fa fa-send" style="margin-right:5px;"></i>Submit</button>
					</div>
				<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
			