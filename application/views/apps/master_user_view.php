			<div class="main">
				<div class="container">
					<div style="padding:20px 0px;">
						<h3 style="color:#808CA0;display:inline;"><i class="fa fa-users" style="margin-right:5px;font-size:14px; border:1px solid #808CA0;border-radius:100px;padding:10px;"></i>Master User</h3>						<div style="display:inline; float:right;color:#808CA0;padding:5px 15px;margin-left:20px;font-size:14px;"><span><i class="fa fa-at" style="margin-right:2px;font-size:12px;"></i>Home <i style="font-size:12px;padding:0px 10px;" class="fa fa-angle-double-right"></i>Master User</span></div>
					</div>
					<div id="body">
					<?php 
						$phpgrid->enable_edit("FORM","CRU");
						$phpgrid->set_caption("<i class='fa fa-users' style='margin-right:5px;'></i>DATAGRID USERS");
						$phpgrid->set_dimension(1200);			
						$phpgrid->display();
					?>	
					</div>
				</div>
			</div>
			