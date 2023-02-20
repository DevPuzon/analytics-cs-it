<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Students extends CI_Controller {

		private $aHtml = array();

	    public function __construct() {
	        parent::__construct();
	        $this->load->library('generateqr');
	    }


	    public function fetch_students() {
			$sCourse = $this->input->post('course');
			$sYear = $this->input->post('year_level');
			$sSem = $this->input->post('semester');
			$sSec = $this->input->post('section');
			$sStatus = $this->input->post('status');
			$sAcademic_year = $this->input->post('academic_year');

			$qQuery = "SELECT * FROM `tbl_students` WHERE `deletedby` is null";

			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSec != "" ? " AND `section` = '".$sSec."'" : "";
			$qQuery .= $sStatus != "" ? " AND `status` = '".$sStatus."'" : "";
			$qQuery .= $sAcademic_year != "" ? " AND `academic_year` = '".$sAcademic_year."'" : "";
			
	    	$eFetchStudents	=	$this->earistlib->ExecQuery('', 'tbl_students', $qQuery, '');
			
			$sHtml 			=	"<table class='table table-hover table-striped tbl-data'>
									<thead>
										<tr>
											<th> Student No. </th>
											<th> Last Name </th>
											<th> Middle Name. </th>
											<th> First Name </th>
											<th> Section </th>
											<th> Year Level </th>
											<th> Semester </th>
											<th> Status </th>
											<th> Action </th>
										</tr>
									</thead>
									<tbody>
								";
			if ($eFetchStudents->num_rows() > 0) {

				$aStudents    =   $eFetchStudents->result_array();
				
				foreach ($aStudents as $key => $aValue) {

					$sHtml 		.= "<tr>
									<td> ".$aValue['student_no']." </td>
									<td> ".$aValue['last_name']." </td>
									<td> ".$aValue['middle_name']." </td>
									<td> ".$aValue['first_name']." </td>
									<td> ".$aValue['section']." </td>
									<td> ".YEARLEVEL[$aValue['year_level']]." </td>
									<td> ".( $aValue['semester'] == "sem_one" ? "First Semester" : "Second Semester") ." </td>
									<td> ".($aValue['status'] != "" ? STUDENTSTAT[$aValue['status']] : "-")." </td>
									
									<td> 
										<div class='btn-group'>
											<button type='button' class='btn btn-sm btn-outline-primary' title='Edit Information' onclick=_edit('".$aValue['id']."');><i class='fas fa-edit'></i></button>
											<button type='button' class='btn btn-sm btn-outline-success' title='Modify Grade' onclick=_addgrade('".$aValue['id']."');><i class='fas fa-user-edit'></i></button>
											<button type='button' class='btn btn-sm btn-outline-danger' title='Delete Student' onclick=_delete('".$aValue['id']."');><i class='fas fa-user-times'></i></button>
										</div>
									</td>
								</tr>";
							
						
				}


			} else {
				$sHtml 		.= "<tr>
									<td colspan='8'> No record found</td>
								</tr>";
			}

			$sHtml 		.= "</tbody></table>";

			echo "
					$('#divData').html(\"".trim(preg_replace('/\s\s+/', '', $sHtml))."\");
					sTabledata = $('.tbl-data').DataTable({
				      'paging': true,
				      'lengthChange': true,
				      'searching': true,
				      'ordering': true,
				      'info' : true,
				      'autoWidth': false,
				    });
				    
				";
				// _exec();
	    }
 
	    public function fetch_students_dashboard() {
			$sCourse = $this->input->post('course');
			$sYear = $this->input->post('year_level');
			$sSem = $this->input->post('semester');
			$sSec = $this->input->post('section');
			$sStatus = $this->input->post('status');
			$sAcademic_year = $this->input->post('academic_year');

			$qQuery = "SELECT * FROM `tbl_students` WHERE `deletedby` is null";

			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSec != "" ? " AND `section` = '".$sSec."'" : "";
			$qQuery .= $sStatus != "" ? " AND `status` = '".$sStatus."'" : ""; 
			$qQuery .= $sAcademic_year != "" ? " AND `academic_year` = '".$sAcademic_year."'" : ""; 
			// echo $qQuery;
	    	$eFetchStudents	=	$this->earistlib->ExecQuery('', 'tbl_students', $qQuery, '');
			
			$sHtml 			=	"<table class='table table-hover table-striped tbl-data'>
									<thead>
										<tr> 
											<th> Student No. </th>
											<th> Name </th> 
											<th> GWA </th> 
										</tr>
									</thead>
									<tbody>
								";
			if ($eFetchStudents->num_rows() > 0) {

				$aStudents    =   $eFetchStudents->result_array();
				$i =1;
				foreach ($aStudents as $key => $aValue) {
					$sGwa = $this->earistlib->overAllGwa($aValue['student_no']);
					// if(str_contains($sGwa,"Not Qualified")){continue;}
					
					// $isFailed =false;
					// if(str_contains($sGwa,"Is Failed")){
					// 	$sGwa = explode("Is Failed / ",$sGwa)[1]; 
					// 	$isFailed = true;
					// }
					if(str_contains($sGwa,"Not Qualified")){
						$sGwa = explode("Not Qualified / ",$sGwa)[1]; 
					} 
					if(str_contains($sGwa,"Is Failed")){
						$sGwa = explode("Is Failed / ",$sGwa)[1];  
					}
					$sHtml 		.= "<tr style=' cursor: pointer; '
									onclick=_studentAnalytics('".$aValue['id']."')>
								 
									<td> ".$aValue['student_no']." </td>
									<td> ".$aValue['first_name']." ".$aValue['last_name']." </td>  
									<td> ".$sGwa." </td>  
								</tr>"; 
								$i++;
				}


			} else {
				$sHtml 		.= "<tr>
									<td colspan='8'> No record found</td>
								</tr>";
			}

			$sHtml 		.= "</tbody></table>";

			echo "
					$('#divData').html(\"".trim(preg_replace('/\s\s+/', '', $sHtml))."\");
					sTabledata = $('.tbl-data').DataTable({
				      'paging': true,
				      'lengthChange': true,
				      'searching': true,
				      'ordering': true,
				      'info' : true,
				      'autoWidth': false 
				    });
				    
				";
				// _exec();
	    } 
		

		// GET STUDENT TOP PERFORMER
	    public function fetch_top_performer_students_dashboard() {
			$sCourse = $this->input->post('course');
			$sYear = $this->input->post('year_level');
			$sSem = $this->input->post('semester');
			$sSec = $this->input->post('section');
			$sStatus = $this->input->post('status');
			$sAcademic_year = $this->input->post('academic_year');

			

			$qQuery = "SELECT * FROM `tbl_students` WHERE `deletedby` is null";

			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSec != "" ? " AND `section` = '".$sSec."'" : "";
			$qQuery .= $sStatus != "" ? " AND `status` = '".$sStatus."'" : ""; 
			$qQuery .= $sAcademic_year != "" ? " AND `academic_year` = '".$sAcademic_year."'" : ""; 
			// $qQuery .= " GROUP BY gr.`student_no`";   

	    	$eFetchStudents	=	$this->earistlib->ExecQuery('', 'tbl_students', $qQuery, '');
			
			$sHtml 			=	"<table class='table table-hover table-striped tbl-data'>
									<thead>
										<tr>
											<th> # </th>
											<th> Student No. </th>
											<th> Name </th> 
											<th> GWA </th> 
										</tr>
									</thead>
									<tbody>
								";
			if ($eFetchStudents->num_rows() > 0) {

				$aStudents    =   $eFetchStudents->result_array();
				$i =1;
				$pastGwa = 0;
				foreach ($aStudents as $key => $aValue) {
					$sGwa = $this->earistlib->overAllGwa($aValue['student_no']);
					if(str_contains($sGwa,"Not Qualified") || 
					   str_contains($sGwa,"Is Failed")){continue;}  
					if(!(is_numeric($sGwa) && $sGwa > 0 && $sGwa < 3)){continue;} 
					
					$sHtml 		.= "<tr style=' cursor: pointer; '
									onclick=_studentAnalytics('".$aValue['id']."')>
									<td> ".$i." </td>  
									<td> ".$aValue['student_no']." </td>
									<td> ".$aValue['first_name']." ".$aValue['last_name']." </td>  
									<td> ".$sGwa." </td>  
								</tr>";  
					// if($sGwa != $pastGwa){
					// 	$i++;
					// 	$pastGwa = $sGwa;
					// }else{ 
					// 	$pastGwa = $sGwa;
					// }
					$i++;
				}


			} else {
				$sHtml 		.= "<tr>
									<td colspan='8'> No record found</td>
								</tr>";
			}

			$sHtml 		.= "</tbody></table>";

			echo "
					$('#divData').html(\"".trim(preg_replace('/\s\s+/', '', $sHtml))."\");
					sTabledata = $('.tbl-data').DataTable({
				      'paging': true,
				      'lengthChange': true,
				      'searching': true,
				      'ordering': true,
				      'info' : true,
				      'autoWidth': false,
					  order: [[3, 'asc']],
				    });
				    
				";
				// _exec();
	    }    

		public function passed_failed_students(){ 
			$sCourse = $this->input->post('course');
			$sYear = $this->input->post('year_level');
			$sSem = $this->input->post('semester');
			$sSec = $this->input->post('section');
			$sStatus = $this->input->post('status'); 
			
			$qQuery = "SELECT * FROM `tbl_students` WHERE `deletedby` is null"; 
			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSec != "" ? " AND `section` = '".$sSec."'" : "";
			$qQuery .= $sStatus != "" ? " AND `status` = '".$sStatus."'" : ""; 
		 
	    	$eFetchStudents	=	$this->earistlib->ExecQuery('', 'tbl_students', $qQuery, '');
			 
			if ($eFetchStudents->num_rows() > 0) { 
				$aStudents    =   $eFetchStudents->result_array();
				$i =1;
				$noInc = 0;
				$noPassed = 0;
				$noFailed = 0;
				foreach ($aStudents as $key => $aValue) {
					$sGwa = $this->earistlib->overAllGwa($aValue['student_no']); 
					if(str_contains($sGwa,"Not Qualified")){
						$sGwa = explode("Not Qualified / ",$sGwa)[1]; 
					}
					$isFailed =false;
					if(str_contains($sGwa,"Is Failed")){
						$sGwa = explode("Is Failed / ",$sGwa)[1]; 
						$isFailed = true;
					} 
					if(str_contains($sGwa,"INC")){
						// INC
						$noInc++;
					}else if($isFailed){
						// Failed
						$noFailed++;
					}else if(is_numeric($sGwa) && $sGwa > 0 && $sGwa <= 3){
						// Passed
						$noPassed++;
					} 
					$i++;
				}  
				echo json_encode(
					array (
						"passed"=>$noPassed,
						"failed"=>$noFailed,
						"inc"=>$noInc,
					)
				);
			} else {
				echo json_encode(
					array (
						"passed"=>0,
						"failed"=>0,
						"inc"=>0,
					)
				);
			}
		}
		
	    public function fetch_failed_students_dashboard() {
			$sCourse = $this->input->post('course');
			$sYear = $this->input->post('year_level');
			$sSem = $this->input->post('semester');
			$sSec = $this->input->post('section');
			$sStatus = $this->input->post('status');
			$sAcademic_year = $this->input->post('academic_year');

			

			$qQuery = "SELECT * FROM `tbl_students` WHERE `deletedby` is null";

			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSec != "" ? " AND `section` = '".$sSec."'" : "";
			$qQuery .= $sStatus != "" ? " AND `status` = '".$sStatus."'" : ""; 
			$qQuery .= $sAcademic_year != "" ? " AND `academic_year` = '".$sAcademic_year."'" : ""; 

	    	$eFetchStudents	=	$this->earistlib->ExecQuery('', 'tbl_students', $qQuery, '');
			
			$sHtml 			=	"<table class='table table-hover table-striped tbl-data'>
									<thead>
										<tr>
											<th> # </th>
											<th> Student No. </th>
											<th> Name </th> 
											<th> GWA </th> 
										</tr>
									</thead>
									<tbody>
								";
			if ($eFetchStudents->num_rows() > 0) {

				$aStudents    =   $eFetchStudents->result_array();
				$i =1;
				foreach ($aStudents as $key => $aValue) {
					$sGwa = $this->earistlib->overAllGwa($aValue['student_no']); 
					if(str_contains($sGwa,"Not Qualified")){
						$sGwa = explode("Not Qualified / ",$sGwa)[1]; 
					}
					$isFailed =false;
					if(str_contains($sGwa,"Is Failed")){
						$sGwa = explode("Is Failed / ",$sGwa)[1]; 
						$isFailed = true;
					}
					// if(is_numeric($sGwa) && $sGwa > 3){
					if($isFailed){
						$sHtml 	.= "<tr style=' cursor: pointer; '
										onclick=_studentAnalytics('".$aValue['id']."')>
										<td> ".$i." </td>  
										<td> ".$aValue['student_no']." </td>
										<td> ".$aValue['first_name']." ".$aValue['last_name']." </td>  
										<td> ".$sGwa." </td>  
									</tr>"; 
					}

					$i++;
				}


			} else {
				$sHtml 		.= "<tr>
									<td colspan='8'> No record found</td>
								</tr>";
			}

			$sHtml 		.= "</tbody></table>";

			echo "
					$('#divData').html(\"".trim(preg_replace('/\s\s+/', '', $sHtml))."\");
					sTabledata = $('.tbl-data').DataTable({
				      'paging': true,
				      'lengthChange': true,
				      'searching': true,
				      'ordering': true,
				      'info' : true,
				      'autoWidth': false,
					  order: [[3, 'asc']],
				    });
				    
				";
				// _exec();
	    }

	    public function fetch_inc_students_dashboard() {
			$sCourse = $this->input->post('course');
			$sYear = $this->input->post('year_level');
			$sSem = $this->input->post('semester');
			$sSec = $this->input->post('section');
			$sStatus = $this->input->post('status');
			$sAcademic_year = $this->input->post('academic_year');

			

			$qQuery = "SELECT * FROM `tbl_students` WHERE `deletedby` is null";

			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSec != "" ? " AND `section` = '".$sSec."'" : "";
			$qQuery .= $sStatus != "" ? " AND `status` = '".$sStatus."'" : ""; 
			$qQuery .= $sAcademic_year != "" ? " AND `academic_year` = '".$sAcademic_year."'" : ""; 

	    	$eFetchStudents	=	$this->earistlib->ExecQuery('', 'tbl_students', $qQuery, '');
			
			$sHtml 			=	"<table class='table table-hover table-striped tbl-data'>
									<thead>
										<tr>
											<th> # </th>
											<th> Student No. </th>
											<th> Name </th> 
											<th> GWA </th> 
										</tr>
									</thead>
									<tbody>
								";
			if ($eFetchStudents->num_rows() > 0) {

				$aStudents    =   $eFetchStudents->result_array();
				$i =1;
				foreach ($aStudents as $key => $aValue) {
					$sGwa = $this->earistlib->overAllGwa($aValue['student_no']); 
					if(str_contains($sGwa,"INC")){
						$sHtml 	.= "<tr style=' cursor: pointer; '
										onclick=_studentAnalytics('".$aValue['id']."')>
										<td> ".$i." </td>  
										<td> ".$aValue['student_no']." </td>
										<td> ".$aValue['first_name']." ".$aValue['last_name']." </td>  
										<td> ".$sGwa." </td>  
									</tr>"; 
					} 

					$i++;
				}


			} else {
				$sHtml 		.= "<tr>
									<td colspan='8'> No record found</td>
								</tr>";
			}

			$sHtml 		.= "</tbody></table>";

			echo "
					$('#divData').html(\"".trim(preg_replace('/\s\s+/', '', $sHtml))."\");
					sTabledata = $('.tbl-data').DataTable({
				      'paging': true,
				      'lengthChange': true,
				      'searching': true,
				      'ordering': true,
				      'info' : true,
				      'autoWidth': false,
					  order: [[3, 'asc']],
				    });
				    
				";
				// _exec();
	    }
		
		
		
	    public function fetch_subjects_dashboard() {
			$sCourse = $this->input->post('course');
			$sYear = $this->input->post('year_level');
			$sSem = $this->input->post('semester'); 
 
			$sHtml 			=	"<table class='table table-hover table-striped tbl-data'>
									<thead>
										<tr>
											<th> Code </th>
											<th> Name </th> 
										</tr>
									</thead>
									<tbody>
								";
			$returns = [];
			foreach(SUBJECTS as $courseKey => $courses){ 
				foreach($courses as $yearLevelKey => $yearLevels){ 
					foreach($yearLevels as $semesterKey => $semesters){
						foreach($semesters as $subjectKey => $subjects){  
							$isFilter = false; 
							
							if(($sCourse != null && $sCourse == $courseKey) &&
							($sYear != null && $sYear == $yearLevelKey ) &&
							($sSem != null && $sSem == $semesterKey) ||  ($sCourse == null)){
								$isFilter = true;
							}
							else{ 
								$isFilter = false; 
							} 
							if($sCourse == null && $sYear == null && $sSem == null){
								$isFilter = true;
							}
							if($isFilter){ 
								$returns[str_replace(' ',"*+^",$courseKey."||".$yearLevelKey."||".$semesterKey."||".$subjectKey."||".$subjects[0])] = 
								array(
									"course"=>$courseKey,
									"year_level"=>$yearLevelKey,
									"semester"=>$semesterKey,
									"subject_code"=>$subjectKey, 
									"subject_name"=>$subjects[0]
								);
							}
						}
					}
				}
			}
			// echo json_encode($returns);


			foreach ($returns as $key => $aVal) { 
				$sHtml 		.= "<tr style=' cursor: pointer; '
								onclick=_subjectAnalytics('".$key."')>
								<td> ".$aVal['subject_code']." </td>
								<td> ".$aVal['subject_name']." </td>  
							</tr>"; 
			}
				
			$sHtml 		.= "</tbody></table>";
			$sHtml =str_replace('"',"",$sHtml);
			echo "
					$('#divData').html(\"".trim(preg_replace('/\s\s+/', '', $sHtml))."\");
					sTabledata = $('.tbl-data').DataTable({
				      'paging': true,
				      'lengthChange': true,
				      'searching': true,
				      'ordering': true,
				      'info' : true,
				      'autoWidth': false,
				    });
				    
				"; 
	    } 

	    public function save_student() {

	    	$aData 		=	$this->earistlib->JsonToArray(json_decode($this->input->post('data'))); 

			$aData['Course'] 	=	$this->input->post('course');
	    	$aData['EntryDate'] =	date("Y-m-d H:i:s");
	    	$aData['EntryBy'] 	=	$this->session->userdata('uname');
			
			$aUserData = [
				'UserFname' => $aData['FirstName'],
				'UserLname' => $aData['LastName'],
				'UserEmail' => $aData['Email'],
				'UserUname' => $aData['StudentNo'], 
				'UserPword' => md5($aData['StudentNo']),
				'UserLevel' => 'student',
				'UserStatus'=> 'active'
			];

	    	$eCheck	=	$this->earistlib->ExecQuery($aData, 'tbl_students', 'search', array("StudentNo" => $aData['StudentNo']));
	    	if ($eCheck->num_rows() > 0) {
	    		echo "toastr.error('Student Number  aleady exists.');";

	    	} else {
	    		if ($this->earistlib->ExecQuery($aData, 'tbl_students', 'save', '') == true) {

					$this->earistlib->ExecQuery($aUserData, 'tblkp_users', 'save', '');

	    				echo "
	    						$('input').val('');
								F$('hidden').val('');
								$('select').val('');
								toastr.success('Student successfully added.');
								_fetchStudents('".$aData['Course']."');
	    					";
	    			} else {
						echo "toastr.error('Failed to add personel.');";
					}
	    	}
	    }


		public function add_yrser(){ 
            $nUniqueId 	    =	$this->input->post('id');
	    	$aData 		=	$this->earistlib->JsonToArray(json_decode($this->input->post('data'))); 
			
			$res = $this->earistlib->ExecQuery(
				array(
					"StudentId" => $nUniqueId,
					"YearLevel" => $aData['year_level'],
					"Semester" => $aData['semester'],
					"Section" => $aData['section'],
					"AcademicYear" => $aData['academicYear']
				)
				, 'tbl_course_enroll', 'save', '');
				 
			if ($res == true) { 
				echo "
						toastr.success('Successfully added!');
						_refresh();
					";
			} else {
				echo "toastr.error('Failed to add.');";
			}
		}

		public function delete_yrser(){  
	    	$aData 		=	$this->earistlib->JsonToArray(json_decode($this->input->post('data'))); 
			 
            $this->db->delete('tbl_grades', [
                'student_no' => $aData['student_no'],
                'course' => $aData['course'],
                'year_level' => $aData['year_level'],
                'semester' => $aData['semester'],
                'section' => $aData['section'],
            ]);

			$res = $this->db->delete('tbl_course_enroll', [  
				'year_level' => $aData['year_level'],
				'semester' => $aData['semester'],
				'section' => $aData['section'],
			]); 


			if ($res == true) { 
				echo "
						toastr.success('Successfully deleted!'); 
						_refresh();
					";
			} else {
				echo "toastr.error('Failed to delete.');";
			}
		}

		public function edit_student() {
			$nId 		=	$this->input->post('data');
			$eUserInfo	=	$this->earistlib->ExecQuery('', 'tbl_students', 'search', array("UniqueId" => $nId));
			$aUserInfo  =	$eUserInfo->result_array();

			$sScript 	=	"";
			foreach ($aUserInfo[0] as $sColKey => $sValue) {
				if ($this->datakeys->getValue($sColKey) != '') {
					$sScript .= "$('[data-key=".$this->datakeys->getValue($sColKey)."]').val('".$sValue."');";
				}
			}

			$sScript .= "
				$('.modal-title span').html('Edit');
				$('#modalNewStudent').modal('show');
			";

			echo $sScript;

		}

    	public function update_student() {

    		$aData 	=	$this->earistlib->JsonToArray(json_decode($this->input->post('data')));
    		$nUniqueId =	$this->input->post('id');

	    	$aData['ModifiedDate'] =	date("Y-m-d H:i:s");
	    	$aData['ModifiedBy'] 	=	$this->session->userdata('uname');
	    	
	    	$eCheck	=	$this->earistlib->ExecQuery($aData, 'tbl_students', 'search', array("StudentNo" => $aData['StudentNo']));
	    	if ($eCheck->num_rows() > 0) {

	    		$aStudent    =   $eCheck->result_array();

	    		if ($nUniqueId != $aStudent[0]['id']) {
	    			echo "toastr.error('Student Number aleady exists.');";
	    		} else {
	    			$bCont 	=	true;
	    		}

	    	} else {
	    		$bCont 	=	true;
	    	}

	    	if ($bCont == true) {
	    		$eQuery =	$this->earistlib->ExecQuery($aData, 'tbl_students', 'update', array('UniqueId' => $nUniqueId));

	    		if ($eQuery == true) {
    				echo "
							toastr.success('Student successfully modified.');
							$('#modalNewStudent').modal('hide');
							_fetchStudents('".$aStudent[0]['course']."');
    					";
    			} else {
					echo "toastr.error('Failed to modify student.');";
				}

	    	}
	    }

		public function delete_student() {
			$nUniqueId =	$this->input->post('data');
			$sCourse = $this->input->post('course') == "it" ? $this->input->post('course') : "cs";

			$aData['DeletedDate'] = date("Y-m-d H:i:s");
			$aData['DeletedBy'] = $this->session->userdata('uname');

			$eQuery =	$this->earistlib->ExecQuery($aData, 'tbl_students', 'update', array('UniqueId' => $nUniqueId));
			if ($eQuery == true) {
				echo "
						toastr.success('Student successfully removed.');
						_fetchStudents('".$sCourse."');
					";
			} else {
				echo "toastr.error('Failed to remove student.');";
			}
		}

		public function get_student_info($nUniqueId) {
			$aInfo	=	$this->earistlib->ExecQuery($aData, 'tbl_students', 'search', ['UniqueId' => $nUniqueId]);
			return $aInfo;
		}


		public function extract_students() {
			$aSort = ['student_no', 'last_name', 'middle_name', 'first_name', 'section', 'year_level', 'semester',  'status'];

			$sCourse = $this->input->post('course');
			$sYear = $this->input->post('year_level');
			$sSem = $this->input->post('semester');
			$sSec = $this->input->post('section');
			$sStatus = $this->input->post('status');
			$sSortBy = $aSort[$this->input->post('sortid')];
			$sSort = strtoupper($this->input->post('sorttype'));

	    	echo "window.open('".$this->earistlib->GenPDF($sCourse, $sYear, $sSem, $sSec, $sStatus, $sSortBy, $sSort)."')";
	    }

		public function getStudentAnalytics (){  
			$nUniqueId =	$this->input->post('id', TRUE); 
			if (isset($nUniqueId)) {
				$data = ["avg_grade_timeline_analytics"=>[],"academic_analytics"=>[]];
				$aStudentInfo 			=	$this->earistlib->StudentInfo($nUniqueId);
				$student_no = $aStudentInfo['student_no'];
				$course =	$aStudentInfo['course'];

				$enrolledCourses	=	$this->earistlib->availableYearSemester($aStudentInfo['course'],$nUniqueId)[1];
				
				foreach($enrolledCourses as $enrolledCourse){
					$year_level = $enrolledCourse["year_level_coded"];
					$semester =  $enrolledCourse["semester_coded"];
					$gradePerCourse = $this->earistlib->getGradePerCourse($student_no,$course,$year_level,$semester );
					 
					$data["academic_analytics"][$enrolledCourse["year_level_coded"].$enrolledCourse["semester_coded"]]=
					array(
						"year_level"=>$enrolledCourse["year_level"], 
						"semester"=>$enrolledCourse["semester"],
						"section"=>$enrolledCourse["section"],
						"gwa"=>$gradePerCourse[0],
						"data"=>$gradePerCourse[1]
					);
					// array_push(
					// 	$data["academic_analytics"],  
					// 	[$enrolledCourse["year_level_coded"].$enrolledCourse["semester_coded"]=>
					// 	array(
					// 		"year_level"=>$enrolledCourse["year_level"], 
					// 		"semester"=>$enrolledCourse["semester"],
					// 		"section"=>$enrolledCourse["section"],
					// 		"gwa"=>$gradePerCourse[0],
					// 		"data"=>$gradePerCourse[1]
					// 	)]
					// );
				}
				foreach($enrolledCourses as $enrolledCourse){
					$year_level = $enrolledCourse["year_level_coded"];
					$semester =  $enrolledCourse["semester_coded"];
					$query = 'SELECT *,AVG(`mid_grade`) as midAvg, AVG(`final_grade`) as finalAvg 
					FROM `tbl_grades` as gr 
					WHERE `student_no` = "'.$student_no.'" 
					AND `year_level` = "'.$year_level.'" 
					and `semester` = "'.$semester.'";';
					$fetchAvgs	=	$this->earistlib->ExecQuery('', 'tbl_grades', $query, '');
				
					if ($fetchAvgs->num_rows() > 0) {
						$fetchAvgs    =   $fetchAvgs->result_array();
						foreach ($fetchAvgs as $key => $fetchAvg) { 
							array_push(
								$data["avg_grade_timeline_analytics"], 
								array( 
									"year_level"=>$this->earistlib->getYearSemStr($fetchAvg["year_level"]), 
									"semester"=>$this->earistlib->getYearSemStr($fetchAvg["semester"]),
									"section"=>$fetchAvg["section"], 
									"mid_avg"=>floatval(number_format($fetchAvg["midAvg"],2)),
									"final_avg"=>floatval(number_format($fetchAvg["finalAvg"],2))
								)
							);
						}
					}
				}
				echo json_encode(array(
									"success"=>true,
									"data"=>$data,
								));
			}else{
				echo json_encode(array("success"=>false));
			}
		}

		public function getStudentInfoHTML(){ 
			$nUniqueId =	$this->input->post('id', TRUE); 
			$html = "";
			if (isset($nUniqueId)) {
				$data = ["avg_grade_timeline_analytics"=>[],"academic_analytics"=>[]];
				$info 			=	$this->earistlib->StudentInfo($nUniqueId); 
				$this->aHtml['info'] 	=	$info ;
				$html = $this->load->view("student_info_v", $this->aHtml, TRUE);
			} 
			
			echo json_encode(array("html"=>$html));
		}
		
		public function getTopPerformerStudentAnalytics (){  
			$nUniqueId =	$this->input->post('id', TRUE); 
			if (isset($nUniqueId)) {
				$data = ["avg_grade_timeline_analytics"=>[]];
				$aStudentInfo 			=	$this->earistlib->StudentInfo($nUniqueId);
				$student_no = $aStudentInfo['student_no'];
				$course =	$aStudentInfo['course'];

				$enrolledCourses	=	$this->earistlib->availableYearSemester($aStudentInfo['course'],$nUniqueId)[1];
				
				foreach($enrolledCourses as $enrolledCourse){
					$year_level = $enrolledCourse["year_level_coded"];
					$semester =  $enrolledCourse["semester_coded"];
					$query = 'SELECT *,AVG(`mid_grade`) as midAvg, AVG(`final_grade`) as finalAvg 
					FROM `tbl_grades` as gr 
					WHERE `student_no` = "'.$student_no.'" 
					AND `year_level` = "'.$year_level.'" 
					and `semester` = "'.$semester.'";';
					$fetchAvgs	=	$this->earistlib->ExecQuery('', 'tbl_grades', $query, '');
				
					if ($fetchAvgs->num_rows() > 0) {
						$fetchAvgs    =   $fetchAvgs->result_array();
						foreach ($fetchAvgs as $key => $fetchAvg) { 
							array_push(
								$data["avg_grade_timeline_analytics"], 
								array( 
									"year_level"=>$this->earistlib->getYearSemStr($fetchAvg["year_level"]), 
									"semester"=>$this->earistlib->getYearSemStr($fetchAvg["semester"]),
									"section"=>$fetchAvg["section"], 
									"mid_avg"=>floatval(number_format($fetchAvg["midAvg"],2)),
									"final_avg"=>floatval(number_format($fetchAvg["finalAvg"],2))
								)
							);
						}
					}
				}


				echo json_encode(array(
									"success"=>true,
									"data"=>$data,
								));
			}else{
				echo json_encode(array("success"=>false));
			}
		}



		

		function capitalizeEachWord($str) {
			$words = explode(" ", $str);
			$capitalizedWords = array_map("ucfirst", $words);
			return implode(" ", $capitalizedWords);
		}

		public function getSubjectAnalytics (){  
			$course =	$this->input->post('course', TRUE); 
			$year_level =	$this->input->post('year_level', TRUE); 
			$semester =	$this->input->post('semester', TRUE); 
			$subject_code =	$this->input->post('subject_code', TRUE);   
			if (isset($course) && isset($year_level) && isset($semester)) {  

				$qQuery = "SELECT *,AVG(mid_grade) as avgMid,AVG(final_grade) as avgFinal FROM `tbl_grades`WHERE "; 
				$qQuery .= $course != "" ? " `course` = '".$course."'" : "";
				$qQuery .= $year_level != "" ? " AND `year_level` = '".$year_level."'" : "";
				$qQuery .= $semester != "" ? " AND `semester` = '".$semester."'" : ""; 
				$qQuery .= $subject_code != "" ? " AND `subject_code` = '".$subject_code."'" : ""; 
				$fetchAvg	=	$this->earistlib->ExecQuery('', 'tbl_grades', $qQuery, '')->result_array();
				
				
				$qQuery = "SELECT * FROM `tbl_grades` as gr left join `tbl_students` as st on st.student_no = gr.student_no WHERE "; 
				$qQuery .= $course != "" ? " gr.`course` = '".$course."'" : "";
				$qQuery .= $year_level != "" ? " AND gr.`year_level` = '".$year_level."'" : "";
				$qQuery .= $semester != "" ? " AND gr.`semester` = '".$semester."'" : ""; 
				$qQuery .= $subject_code != "" ? " AND gr.`subject_code` = '".$subject_code."'" : ""; 
				$eFetchStGrades	=	$this->earistlib->ExecQuery('', 'tbl_grades', $qQuery, '')->result_array();
				
				$midGrades = [];
				$finalGrades = [];
				if(isset($eFetchStGrades)){
					foreach($eFetchStGrades as $grade){
						array_push($midGrades,array("full_name"=>$this->capitalizeEachWord($grade["first_name"]." ".$grade["middle_name"]),
						"grade"=>$grade["mid_grade"],"student_no"=>$grade["student_no"]));
						array_push($finalGrades,array("full_name"=>$this->capitalizeEachWord($grade["first_name"]." ".$grade["middle_name"]),
						"grade"=>$grade["final_grade"],"student_no"=>$grade["student_no"]));
					}
				}
				usort($midGrades, function ($a, $b) {
					return $b['grade'] <=> $a['grade'];
				}); 
				usort($finalGrades, function ($a, $b) {
					return $b['grade'] <=> $a['grade'];
				}); 
				echo json_encode(array(
									"success"=>true,
									"average_grade"=>isset($fetchAvg) ? $fetchAvg[0]:[],
									"student_grades"=>array("midGrades"=>$midGrades,"finalGrades"=>$finalGrades),
								));
			}else{
				echo json_encode(array("success"=>false));
			}
		} 
	}

?>