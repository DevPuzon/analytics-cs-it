
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 

<script src="assets/plugins/chartjs.js/chartjs.js"></script> 
<div class="row">
	<div class="col-md-5">

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

					<div class="col-md-1">
					<button type="button" class="btn btn-sm btn-outline-primary" data-trigger="filter" style="height:80% !important; width: 60px;">
						<i class="fas fa-filter"></i> Filter
					</button>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" id="divData"></div>
	        	</div>
	        </div>
	    </div>
	</div>
	
	<div class="col-md-7"> 
		<div id="accordion-dashboard-subjects">  
		</div>  
 	</div>
</div> 
  

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/js/dashboard-subjects.js"></script>