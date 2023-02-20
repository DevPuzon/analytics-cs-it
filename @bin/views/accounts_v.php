<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12">

		<div class="card">
			<div class="card-header">

				<div class="d-flex justify-content-between">
	                <h3 class="card-title"><i class="fa fa-user"></i> Accounts</h3>

	                <div class="box-tools pull-right">
		 			 	<button class="btn btn-primary btn-sm btn-flat" title="New Account" data-action="new-user">
		 					<i class="fa fa-user-plus"></i> New
		 				</button>
		          	</div>

	            </div>
	        </div>
	 		<div class="card-body">
	    		<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="divData"></div>
	        	</div>
	        </div>

	    </div>
	</div>
</div>

<div id="modalNewAccnt" class="modal fade" role="dialog">
	<form name="frmMain" id="frmMain" class="form-horizontal">
    	<div class="modal-dialog modal-lg">
        	<div class="modal-content">
          		<div class="modal-header">

            		<h4 class="modal-title">User Account - <span></span></h4>
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">×</span>
		            </button>
          		</div>
          		<div class="modal-body">
            		<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="row">
						    	<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Title <i class="fa fa-asterisk"></i></label>
						    	<div class="form-group col-xs-3 col-sm-3 col-md-3 col-lg-3">
					        		<select class="form-control input-sm" data="req" data-key="UserTitle">
										<option value = ''></option>
										<option value = 'Mr.'>Mr.</option>
										<option value = 'Ms.'>Ms.</option>
									</select>
					      		</div>
					      	</div>
							<div class="row">
						    	<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">First Name <i class="fa fa-asterisk"></i></label>
						    	<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="Firstname" data="req" maxlength="35" data-key="UserFname">
					      		</div>
					      	</div>

					      	<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Last Name<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="Lastname" data="req" maxlength="35" data-key="UserLname">
					      		</div>
						    </div>

						    <div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Username<i class="fa fa-asterisk"></i></label>
						    	<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="Username" data="req" data-key="UserUname">
					      		</div>
					      	</div>

					      	<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Password <i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="password" class="form-control input-sm" placeholder="Password" data="req" data-key="UserPword">
					      		</div>
					      	</div>

					      	<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Confirm Password<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="password" class="form-control input-sm" placeholder="Confirm Password" data="req" data-key="UserCword">
					      		</div>
						    </div>

						     <div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Access Level<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<select name="txtAccess" id="txtAccess" class="form-control input-sm" data="req" data-key="UserLevel">
										<option value = ''></option>
										<?php
											foreach(ACCESSTYPE as $access => $type) {
										?>
												<option value = "<?=$access;?>"><?=$type;?></option>
										<?php
											}
										?>
									</select>
					      		</div>
					      	</div>
						</div>
					</div>
      			</div>

      			<div class="modal-footer justify-content-between">
      				<input type="hidden" data-key="UniqueId">
	              	<button type="button" class="btn btn-outline-primary" data-action="save-user">
	              		<i class="fa fa-save"></i> Save
	              	</button>

	              	<button type="button" class="btn btn-outline-primary" data-action="update-user">
	              		<i class="fa fa-save"></i> Update
	              	</button>

	              	<button type="button" class="btn btn-outline-success" data-action="activate-user">
	              		<i class="fa fa-undo"></i> Activate
	              	</button>

	              	<button type="button" class="btn btn-outline-danger" data-action="remove-user">
	              		<i class="fa fa-times"></i> Remove
	              	</button>

	              	

	            </div>

	    	</div>
	    </div>
	</form>
</div>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/js/accounts.js"></script>