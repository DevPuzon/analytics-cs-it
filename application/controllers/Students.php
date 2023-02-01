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

			$qQuery = "SELECT * FROM `tbl_students` WHERE `deletedby` is null";

			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSec != "" ? " AND `section` = '".$sSec."'" : "";
			$qQuery .= $sStatus != "" ? " AND `status` = '".$sStatus."'" : "";

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
								$('hidden').val('');
								$('select').val('');
								toastr.success('Student successfully added.');
								_fetchStudents('".$aData['Course']."');
	    					";
	    			} else {
						echo "toastr.error('Failed to add personel.');";
					}
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

	}

?>