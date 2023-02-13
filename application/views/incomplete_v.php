
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
                                <option value=''></option>
                                <option value='year_one'>1st Year</option>
                                <option value='year_two'>2nd Year</option>
                                <option value='year_three'>3rd Year</option>
                                <option value='year_four'>4th Year</option>
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
                            <label for="">Course</label>
                            <select class="form-control form-control-sm" id="selCourse">
                                <option value=''></option>
                                <option value='cs'>Computer Science</option>
                                <option value='it'>Information Technology</option>
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

                    <div class="col-md-3">
                        <button type="button" class="btn btn-sm btn-outline-danger" data-trigger="inc" >
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" data-trigger="notify-inc" >
                            <i class="far fa-envelope"></i> Notify
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="row">

<?php 
    if (sizeof($student_grades) > 0) {
        foreach($student_grades as $nStudentNo => $aDetails) { 
?>
        <div class="col-md-3 div-cards <?=$aDetails['classes']?>">
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-danger">
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="assets/images/student-image.png" alt="User Avatar">
                    </div>
                    <h3 class="widget-user-username"><?=$aDetails['name'];?></h3>
                    <h5 class="widget-user-desc"><?=$aDetails['course'];?></h5>
                    </div>
                    <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <label class="nav-link">
                                Student No: <span class="float-right text-bold"><?=$nStudentNo?></span>
                            </label>
                        </li>
                        <li class="nav-item">
                            <label class="nav-link">
                                Year: <span class="float-right text-bold"><?=$aDetails['year_level'];?></span>
                            </label>
                        </li>
                        <li class="nav-item">
                            <label class="nav-link">
                                Semester: <span class="float-right text-bold"><?=$aDetails['semester'];?></span>
                            </label>
                        </li>
                        <li class="nav-item">
                            <label class="nav-link">
                                Section: <span class="float-right text-bold"><?=$aDetails['section'];?></span>
                            </label>
                        </li>
                        <li class="nav-item">
                            <label class="nav-link">
                                GWA: <span class="float-right text-bold"><?=$aDetails['final_grade'];?></span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php } } else { echo "<h5 class='mt-4 mb-2'>No Record Found!!!</h5>"; } ?>
</div>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/js/classifications.js"></script>