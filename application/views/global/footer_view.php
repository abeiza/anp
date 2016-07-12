			<div class="footer">
				<div class="container">
					<span style="font-size:14px;color:#808CA0"><i class="fa fa-usb"></i>Develop by <a style="color:#808CA0;font-weight:bold;text-decoration:none;" href="http://www.abeiza.com">Evan Abeiza</a> @2016 | IT Dept, GOC</span>
				</div>
			</div>
			<script src="<?php echo base_url();?>assets/js/jquery-confirm.min.js"></script>
			<script>
				$('#logout').confirm({
					title: '<span style="color:#FF6B6B;"><i class="fa fa-sign-out" style="margin-right:5px;"></i>Confirmation</span>',
					content: 'Are you sure? Do you want to sign out from ANP&KSP System?',
					confirm: function(){
						window.location.replace("<?php echo base_url();?>index.php/application/login/action_logout");
					},
					cancel: function(){
						$.alert('Canceled!');
					}
				});
				
				function delete_id(id, id2)
				{
					$.confirm({
						title: '<span style="color:#FF6B6B;"><i class="fa fa-exclamation" style="margin-right:5px;"></i>Confirmation</span>',
						content: 'Are you sure to remove this record?',
						confirm: function(){
							window.location.href='<?php echo base_url();?>index.php/application/Req_Realisasi/delete_action/'+id+'/'+id2;
						},
						cancel: function(){
							$.alert('Canceled!');
						}
					});
				}
				
				function delete_budget_id(id)
				{
					$.confirm({
						title: '<span style="color:#FF6B6B;"><i class="fa fa-exclamation" style="margin-right:5px;"></i>Confirmation</span>',
						content: 'Are you sure to remove this record?',
						confirm: function(){
							window.location.href='<?php echo base_url();?>index.php/application/Req_Budget/delete_request/'+id;
						},
						cancel: function(){
							$.alert('Canceled!');
						}
					});
				}
				
				function add_realisasi(budget,real)
				{
					if(budget < real){
						$.confirm({
							title: '<span style="color:#FF6B6B;"><i class="fa fa-exclamation" style="margin-right:5px;"></i>Confirmation</span>',
							content: 'The budget is Insufficient Funds, Are you sure to use this budget?',
							confirm: function(){
								window.location.href='<?php echo base_url();?>index.php/application/Req_Budget/delete_request/'+id;
							},
							cancel: function(){
								$.alert('Canceled!');
							}
						});
					}
				}
				
				$('#multi-delete').confirm({
					title: '<span style="color:#FF6B6B;"><i class="fa fa-exclamation" style="margin-right:5px;"></i>Confirmation</span>',
					content: 'Are you sure? Do you want to closed this request?',
					confirm: function(){
						var rows = getSelRows();
						var self = this;
						if (rows == "") {
							alert("no rows selected");
							return;
						} else { 
							$.ajax({
							  url: '<?php echo base_url();?>index.php/application/monitor_controller/force_close',
							  data: {selectedRows: rows},
							  type: 'POST',
							  dataType: 'JSON',
							  cache: false,
							  success : function(response_array){
											if(response_array.status == 'success'){
												$.alert("Data Selected was force closed!");
											}else if(response_array.status == 'error'){
												$.alert("Error on query!");
											}
											self.close()
										  },
							  error: function() {
										  $.alert("There was an error. Try again please!");
										}
							  //error: onFailRegistered
							});
							return false;//alert(rows + ' row Ids were posted to a remote URL via $.ajax');
						}
					},
					cancel: function(){
						$.alert('Canceled!');
					}
				});
			</script>
		</div>
	</body>
</html>