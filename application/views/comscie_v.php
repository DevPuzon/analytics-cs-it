<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<input type="hidden" id="txtCourseType" value="cs">
<div class="row">
	<div class="col-md-12">

		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
	                <h3 class="card-title"><i class="fa fa-filter"></i> Filter</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                    </div>
	            </div>
	        </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Year Level</label>
                            <select class="form-control form-control-sm" id="selYear">
								<option value = ''></option>
								<?php
									foreach(YEARLEVEL as $level => $year) {
								?>
										<option value = "<?=$level;?>"><?=$year;?></option>
								<?php
									}
								?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Semester</label>
                            <select class="form-control form-control-sm" id="selSem">
                                <option value=''></option>
                                <option value='sem_one'>1st Semester</option>
                                <option value='sem_two'>2nd Semester</option>
                            </select>
                        </div>
                    </div>


					<div class="col-md-2">
                        <div class="form-group">
                            <label for="">Section</label>
                            <select class="form-control form-control-sm" id="selSection">
                                <option value=''></option>
                                <option value='A'>A</option>
                                <option value='B'>B</option>
								<option value='C'>C</option>
								<option value='D'>D</option>
								<option value='E'>E</option>	
                            </select>
                        </div>
                    </div>

					
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Status</label>
                            
							<select class="form-control form-control-sm" data="req" id="selStatus">
								<option value = ''></option>
								<?php
									foreach(STUDENTSTAT as $stat => $status) {
								?>
										<option value = "<?=$stat;?>"><?=$status;?></option>
								<?php
									}
								?>
							</select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-trigger="filter" style="height:80% !important; width: 60px;">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
	<div class="col-md-12">

		<div class="card">
			<div class="card-header">

				<div class="d-flex justify-content-between">
	                <h3 class="card-title"><i class="fa fa-list"></i> List</h3>
					<div class="pull-right box-tools">
						<button type="button" class="btn btn-sm btn-outline-primary" data-trigger="add-comscie">
							<i class="fa fa-user-plus"></i> Add Student
						</button>
						<button type="button" class="btn btn-sm btn-outline-danger" data-trigger="print-cs">
							<i class="fa fa-print"></i> Print
						</button>
					</div>
	            </div>
	        </div>
	 		<div class="card-body">
	    		<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" id="divData"></div>
	        	</div>
	        </div>
	    </div>
	</div>
</div>

<div id="modalNewStudent" class="modal fade" role="dialog">
	<form name="frmMain" id="frmMain" class="form-horizontal">
    	<div class="modal-dialog modal-lg">
        	<div class="modal-content">
          		<div class="modal-header">

            		<h4 class="modal-title">Student - <span></span></h4>
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">×</span>
		            </button>
          		</div>
          		<div class="modal-body">
            		<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">ID. No.<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="ID Number" data="req" maxlength="35" data-key="StudentNo">
					      		</div>
						    </div>
							<div class="row">
						    	<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">First Name <i class="fa fa-asterisk"></i></label>
						    	<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="Firstname" data="req" maxlength="35" data-key="FirstName">
					      		</div>
					      	</div>

							  <div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Middle Name<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="Middle Name" data="req" maxlength="35" data-key="MiddleName">
					      		</div>
						    </div>

					      	<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Last Name<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="Lastname" data="req" maxlength="35" data-key="LastName">
					      		</div>
						    </div>

							

							<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Year Level<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
									<select class="form-control input-sm" data="req" data-key="YearLevel">
										<option value = ''></option>
										<?php
											foreach($yearlevels as $level => $year) {
										?>
												<option value = "<?=$level;?>"><?=$year;?></option>
										<?php
											}
										?>
									</select>
					      		</div>
						    </div>

							<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Status<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
									<select class="form-control input-sm" data="req" data-key="Status">
										<option value = ''></option>
										<?php
											foreach(STUDENTSTAT as $stat => $status) {
										?>
												<option value = "<?=$stat;?>"><?=$status;?></option>
										<?php
											}
										?>
									</select>
					      		</div>
						    </div>

							<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Semester<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-3 col-sm-3 col-md-3 col-lg-3">
									<select class="form-control input-sm" data="req" data-key="Semester">
										<option value = ''></option>
										<option value = 'sem_one'>First</option>
										<option value = 'sem_two'>Second</option>
									</select>
					      		</div>

					      		<label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2 float-right">Section<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-4 col-sm-4 col-md-4 col-lg-4">
					        		<input type="text" class="form-control input-sm" placeholder="Section" data="req" maxlength="35" data-key="Section">
					      		</div>
						    </div>

						

							<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Email<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="Email Address" data="req" maxlength="35" data-key="Email">
					      		</div>
						    </div>


							
					      	
						</div>
					</div>
      			</div>

      			<div class="modal-footer justify-content-between">
      				<input type="hidden" data-key="UniqueId">
	              	<button type="button" class="btn btn-outline-primary" data-trigger="save-cs">
	              		<i class="fa fa-save"></i> Save
	              	</button>
					
					  <button type="button" class="btn btn-outline-danger" data-trigger="cancel">
	              		<i class="fa fa-undo"></i> Cancel
	              	</button>

	            </div>

	    	</div>
	    </div>
	</form>
</div>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/js/students.js"></script>