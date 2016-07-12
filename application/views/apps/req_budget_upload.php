			<script src="http://code.jquery.com/jquery-latest.min.js"
			type="text/javascript"></script>
			<div class="main">
				<div class="container">
					<div style="padding:20px 0px;">
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-upload" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px 12px;"></i>Request Budget (Upload)</h3>
						<div style="display:inline; color:#666;padding:5px 15px;background-color:#fff;margin-left:20px;font-size:14px;border:1px solid #e1e1e1;border-radius:15px"><a style="color:#808CA0;text-decoration:none;" href="<?php echo base_url().'index.php/application/req_realisasi/'?>"><i class="fa fa-undo"></i> Back to Budget List</a></div>
						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Request Budget <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Budget Upload</span></div>
					</div>
					<style>
						.foo {
							display: block;
							position: relative;
							color:#666;
							padding:5px 15px;
							background-color:#e1e1e1;
							//margin-left:20px;
							font-size:14px;
							//border:1px solid #e1e1e1;
							border-radius:15px;
							text-align:center;
							margin:auto;
							outline:none;
							transition:0.5s all ease-out;
							cursor:pointer;
						}
						.foo:hover:after {
							background: #E8EBF0;
							color:#808CA0;
							transition:0.5s all ease-in;
						}
						.foo:after {
							transition: 200ms all ease;
							background-color:#fff;
							color:#e1e1e1;
							font-size: 14px;
							text-align: center;
							position: absolute;
							border:1px solid #e1e1e1;
							top: 0;
							left: 0;
							width: 100%;
							height: 100%;
							display: block;
							content: 'Upload';
							line-height: 30px;
							border-radius: 15px;
						}
					</style>
					<div style="border:1px dashed #bcbcbc;height:300px;margin-bottom:50px;display: -webkit-flex; /* Safari */
							-webkit-align-items: center; /* Safari 7.0+ */
							display: flex;
							align-items: center;text-align:center;">
							
						<?php 
							$attribute = array("style"=>"margin:auto;");
							echo form_open_multipart('application/req_budget/proses_upload',$attribute);
						?>
							<h2 style="font-weight:normal;color:#808CA0;margin-bottom:20px;">Select File to Upload Data</h2>
							<input type="file" class="foo" onchange="this.form.submit()" name="excel">
						<?php echo form_close();?>
					</div>
				</div>
			</div>