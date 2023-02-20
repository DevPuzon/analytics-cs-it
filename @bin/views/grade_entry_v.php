<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

$year_level = $info['year_level'];
$semester = $info['semester'];
if(isset($_GET['year_level']) && isset($_GET['semester'])){
    $year_level = $_GET['year_level'];
    $semester =  $_GET['semester'];
}
?>
<div class="row">
	<div class="col-md-12">

		<div class="card">
			<div class="card-header">
                <input type="hidden" data-key="UniqueId" value="<?=$info['id'];?>">
                <input type="hidden" data-key="UniqueStudentNo" value="<?=$info['student_no'];?>">
                <input type="hidden" data-key="Course" value="<?=$info['course'];?>">
				<div class="d-flex justify-content-between">
	                <h3 class="card-title"><i class="fa fa-user-edit"></i> Student Information</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
	            </div>
	        </div>
	 		<div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <dl>
                            <dt>Student No</dt>
                            <dd><?=$info['student_no'];?></dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl>
                            <dt>Course</dt>
                            <dd> <?php echo $info['course'] == "cs" ? "Computer Science" : "Information Technology"?></dd>
                        </dl>
                    </div>

                    <div class="col-md-3">
                        <dl>
                            <dt>Year & Section</dt>
                            <dd>  <?=YEARLEVEL[$year_level];?> / <?=$info['section'];?></dd>
                        </dl>
                    </div>

                    <div class="col-md-3">
                        <dl>
                            <dt>Status</dt>
                            <dd> <?=($info['status'] != "" ? STUDENTSTAT[$info['status']] : "-");?> </dd>
                        </dl>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <dl>
                            <dt>Name</dt>
                            <dd> <?php echo ucwords(strtolower($info['last_name'].", ".$info['first_name']." ".$info['middle_name']));?></dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl>
                            <dt>Academic Year</dt>
                            <dd> <?=$info['academic_year'];?></dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl>
                            <dt>Email</dt>
                            <dd> <?=$info['email'];?></dd>
                        </dl>
                    </div>
                </div>
	        </div> 
	    </div>
	</div>
</div>

<div class="row mb-4 mt-4">
    <div class="col-md-12 mb-3">
        <button type="button" class=" btn btn-sm btn-outline-primary" data-trigger="add-academic">
            <i class="fas fa-plus"></i> Add Academic
        </button>
    </div>    
    <?php
    foreach($enrolledCourses as $course){ 
        $isActive = false;
        if($course['year_level_coded'].$course['semester_coded'] == $year_level.$semester){
            $isActive = true;
        }

        echo "<div class='col-md-3 col-sm-12' style=' position: relative; '> 
        <button type='button' class='btn btn-danger btn-sm' style=' position: absolute; right: 5%; top: 22%; z-index: 100; '
        onclick=\"deleteCourseEnroll('".$course['id']."','".$course['year_level_coded']."','".$course['semester_coded']."','".$course['section']."')\"
        ><i class='fa fa-trash'></i></button>
        <a href=\"".base_url()."grade-entry?id=".$info['id']."&year_level=".$course['year_level_coded']."&semester=".$course['semester_coded']."&section=".$course['section']."&academicYear=".$course['academic_year']."\"
        style='text-decoration:none;color: #000;'>
            <div class='card ".($isActive ? 'bg-primary':'')."'> 
                <div class='card-body' onclick='location'>
                    ".$course['year_level']." Year - ".$course['semester']." Semester - ". $course['section']."
                </div>  
            </div>
        </a>
    </div>";
    }
    ?>

</div>

<div class="row">
	<div class="col-md-12">
        <div class="card">
            <div class="card-header">

                <div class="d-flex justify-content-between">
                    <h3 class="card-title"><i class="fa fa-edit"></i> Student Grades</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-trigger="save-grades">
                            <i class="fas fa-save"></i> Save
                        </button>

                        <button type="button" class="btn btn-sm btn-outline-danger" data-trigger="print-grades">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th> CODE </th>
                        <th> SUBJECT </th>
                        <th> UNITS </th>
                        <th> MIDTERM </th>
                        <th> FINAL TERM </th>
                        <th colspan="2" class="text-center"> FINAL GRADE </th>
                        <th> REMARKS </th>
                    </tr>
                    <tr>
                        <th> &nbsp; </th>
                        <th> &nbsp; </th>
                        <th> &nbsp; </th>
                        <th> &nbsp; </th>
                        <th> &nbsp; </th>
                        <th class="text-center"> Grade Range </th>
                        <th class="text-center"> Grade Point </th>
                        <th> &nbsp; </th>
                    </tr>

                    <?php
                        $aGWA = [];
                        $aGrades = [];

                        if (sizeof($grades) > 0) {
                            foreach($grades as $nKey => $aGradeDetails) {
                                $aGrades[$aGradeDetails['course']][$aGradeDetails['year_level']][$aGradeDetails['semester']][$aGradeDetails['subject_code']] = $aGradeDetails['mid_grade']."|".$aGradeDetails['final_grade'];
                            }
                        }

                        $aSubjects  = SUBJECTS[$info['course']][$year_level][$semester]; 

                        foreach($aSubjects as $sSubCode => $aDetails) {
                            $sSubject 	= $aDetails[0];
                            $nHrsLec 	= $aDetails[1];
                            $nHrsLab 	= $aDetails[2];
                            $nUnitsLec 	= $aDetails[3] != '' ? $aDetails[3] : '-';
                            $nUnitsLab 	= $aDetails[4] != '' ? $aDetails[4] : '-';
                            $nTotalUnits= $aDetails[5]; 
                            
                            $aMidFinGrades = isset($aGrades[$info['course']][$year_level][$semester][$sSubCode]) ? explode("|", $aGrades[$info['course']][$year_level][$semester][$sSubCode]) : [0,0];

                            $sMidGrade = $aMidFinGrades > 0 ? $aMidFinGrades[0] : '';
                            $sFinalGrade = $aMidFinGrades > 0 ? $aMidFinGrades[1] : '';

                            if ($sMidGrade > 0 && $sFinalGrade > 0) {
                                $fGradeAve = ($sMidGrade + $sFinalGrade) / 2;
                                $aGradeDet = gradeRangePoint($fGradeAve);
                                $aGradeDet[1]= (int)$aGradeDet[1];
                                $nUnitsLec= (int)$nUnitsLec;

                                $sGradexUnits = ( ($aGradeDet[1] > 0 ) ? ($aGradeDet[1] * $nUnitsLec ) : 0);
                                if (isset($aGWA['grd'])) {
                                    $aGWA['grd'] += $sGradexUnits;
                                    $aGWA['unt'] += $nUnitsLec;
                                } else {
                                    $aGWA['grd'] = $sGradexUnits;
                                    $aGWA['unt'] = $nUnitsLec;
                                }

                            } else if($sMidGrade > 0 && $sFinalGrade <= 0) {
                                $aGradeDet = gradeRangePoint("inc");
                            } else {
                                $aGradeDet = gradeRangePoint("");
                                $aGWA['grd'] = 0;
                                $aGWA['unt'] = 0;
                            }
                            // print_r($aGradeDet);
                    ?>
                            <tr>
                                <td><?=$sSubCode;?></td>
                                <td><?=$sSubject;?></td>
                                <td><abbr class="abbr-units float-right"><?=$nUnitsLec;?></abbr></td>
                                <td>
                                    <input type="number" class="form-control form-control-sm mid-input" data-key="<?=$sSubCode;?>_mid" maxlength="5" min="1" max="100" value="<?=$sMidGrade?>">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm fin-input" data-key="<?=$sSubCode;?>_fin" maxlength="5" min="1" max="100" value="<?=$sFinalGrade?>">
                                </td>
                                <td><abbr class="abbr-grade-range float-right"> <?=$aGradeDet[0];?> </abbr></td>
                                <td><abbr class="abbr-grade-point float-right"> <?=$aGradeDet[1];?> </abbr></td>
                                <td><abbr class="abbr-remarks float-right"> <?=$aGradeDet[2];?> </abbr></td>
                            </tr>
                    <?php
                        }
                    ?>

                    <tr>
                        <td colspan="8">
                            <h4 class="float-right"><?=( $aGWA['grd'] > 0 ? number_format($aGWA['grd'] / $aGWA['unt'], 2) : '' );?>&nbsp;</h4>
                        </td>
                    </tr>

                </table>

            </div>
        </div>
    </div>
</div> 


<div id="modalNewYrSr" class="modal fade" role="dialog">
	<form name="frmMain" id="frmMain" class="form-horizontal">
    	<div class="modal-dialog modal-lg">
        	<div class="modal-content">
          		<div class="modal-header">

            		<h4 class="modal-title">Add Course</h4>
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">×</span>
		            </button>
          		</div>
          		<div class="modal-body">
            		<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                            <div class="row">
                                <label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Year and semester<i class="fa fa-asterisk"></i></label>
                                <div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <select class="form-control input-sm" data="req" data-key="Academic_year_and_semester">
                                        <option value = ''></option>
                                        <?php
                                            foreach($availableYearSemester as $yearSem) {
                                        ?>
                                                <option value = "<?=$yearSem['year_level_coded'].",".$yearSem['semester_coded'];?>"><?=$yearSem['year_level']." Year, ".$yearSem['semester']." Semester";?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>  
                            <div class="row">
                                <label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Academic Year<i class="fa fa-asterisk"></i></label>
                                <div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <select class="form-control input-sm" data="req" data-key="AcademicYear"> 
										<option value = '2020-2021' checked>2020-2021</option> 
										<option value = '2021-2022'>2021-2022</option> 
										<option value = '2022-2023'>2022-2023</option> 
										<option value = '2023-2024'>2023-2024</option> 
										<option value = '2024-2025'>2024-2025</option> 
										<option value = '2025-2026'>2025-2026</option> 
										<option value = '2026-2027'>2026-2027</option> 
                                    </select>
                                </div>
                            </div>  
							<div class="row">
					      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3">Section<i class="fa fa-asterisk"></i></label>
								<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9">
					        		<input type="text" class="form-control input-sm" placeholder="Section" data="req" maxlength="35" data-key="Section">
					      		</div>
						    </div>
						</div>
					</div>
      			</div>

      			<div class="modal-footer justify-content-between"> 
	              	<button type="button" class="btn btn-outline-primary" data-trigger="add-yrsem">
	              		<i class="fa fa-save"></i> Add
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
<script src="assets/js/grades.js"></script>