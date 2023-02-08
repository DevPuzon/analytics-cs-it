
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 

<script src="assets/plugins/chartjs.js/chartjs.js"></script> 
<div class="row">
	<div class="col-md-5" id="main-list">

		<div class="card">
			<div class="card-header">

				<div class="d-flex justify-content-between">
	                <h3 class="card-title"><i class="fa fa-list"></i> List</h3> 
	            </div>
	        </div>
	 		<div class="card-body">
	    		<div class="row">
					
					<div class="col-md-2">
						<div class="form-group">
							<label for="">Course</label>
							<select class="form-control form-control-sm" id="txtCourseType">
								<option value = ''>All</option> 
								<option value = 'cs'>CS</option> 
								<option value = 'it'>IT</option> 
							</select>
						</div>
					</div>

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


					<div class="col-md-12 mb-3">
						<div class="row">
							<div class="col-auto">
								<button type="button" class="btn btn-sm btn-outline-primary" data-trigger="filter" >
									<i class="fas fa-filter"></i> Filter
								</button>
							</div>
							<div class="col-auto">
								<button type="button" class="btn btn-sm btn-outline-primary" data-trigger="print" >
									<i class="fas fa-print"></i> Print
								</button>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" id="divData"></div>
	        	</div>
	        </div>
	    </div>
	</div>
	
	<div class="col-md-7"> 
		<div id="student_info">  
		</div>  
		<div id="accordion-dashboard-top-performer-students">  
		</div>  
		<div id="accordion-dashboard-students">  
		</div> 
 	</div>
</div> 
  

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/js/dashboard-students.js"></script>