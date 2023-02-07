<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modules extends CI_Controller {

	private $aHtml = array();

    public function __construct() {
        parent::__construct();
    }

    public function login() {
		if ($this->session->userdata('uname') != "") {
			$aGraph 	=	$this->earistlib->graphGrades();
			
			$this->aHtml['title'] 	=	"Dashboard";
			$this->aHtml['counts']	=	$this->earistlib->cntStudents();
			$this->aHtml['graph'] 	=	json_encode($aGraph);
			
			$aViewData =   array("module" => $this->load->view("home_v", $this->aHtml, TRUE));
			$this->load->view('main_v', $aViewData);

		} else {
			$this->aHtml['title'] =	"Login";
			$this->load->view('login_v');
		}
	}

	public function dashboard() {

		// $aGraph 	=	$this->earistlib->graphGrades();
		
		$this->aHtml['title'] 	=	"Dashboard";
		$this->aHtml['counts']	=	$this->earistlib->cntStudents();
		// $this->aHtml['graph'] 	=	json_encode($aGraph);
		
		$aViewData =   array("module" => $this->load->view("home_v", $this->aHtml, TRUE));
		$this->load->view('main_v', $aViewData);

	}

	public function comscie() {
		$this->aHtml['title'] 		=	"Computer Science Students";
		$this->aHtml['yearlevels'] 	=	$this->earistlib->dropSubjects('cs')[0];
		$aViewData              =   array("module" => $this->load->view("comscie_v", $this->aHtml, TRUE));

		$this->load->view('main_v', $aViewData);
	}

	public function dashboardStudents() {
		$this->aHtml['title'] 		=	"Students Analytics";
		$yearLevels = $this->earistlib->dropSubjects('it')[0]; 
		$yearLevels = array_merge($yearLevels, $this->earistlib->dropSubjects('cs')[0]);

		$this->aHtml['yearlevels'] 	=	$yearLevels;
		$aViewData              =   array("module" => $this->load->view("dashboard_students_v", $this->aHtml, TRUE)); 
		$this->load->view('main_v', $aViewData);
	}
	
	public function dashboardTopPerformerStudents() {
		$this->aHtml['title'] 		=	"Top Performer Students Analytics";
		$yearLevels = $this->earistlib->dropSubjects('it')[0]; 
		$yearLevels = array_merge($yearLevels, $this->earistlib->dropSubjects('cs')[0]);

		$this->aHtml['yearlevels'] 	=	$yearLevels;
		$aViewData              =   array("module" => $this->load->view("dashboard_top_performer_students_v", $this->aHtml, TRUE)); 
		$this->load->view('main_v', $aViewData);
	} 
	
	public function dashboardSubjects() {
		$this->aHtml['title'] 		=	"Top Performer Students Analytics";
		$yearLevels = $this->earistlib->dropSubjects('it')[0]; 
		$yearLevels = array_merge($yearLevels, $this->earistlib->dropSubjects('cs')[0]);

		$this->aHtml['yearlevels'] 	=	$yearLevels;
		$aViewData              =   array("module" => $this->load->view("dashboard_subject_v", $this->aHtml, TRUE)); 
		$this->load->view('main_v', $aViewData);
	}

	public function it() {
		$this->aHtml['title'] 	=	"Information Technology Students";
		$this->aHtml['yearlevels'] 	=	$this->earistlib->dropSubjects('it')[0];
		$aViewData              =   array("module" => $this->load->view("it_v", $this->aHtml, TRUE));

		$this->load->view('main_v', $aViewData);
	}

	public function grade_entry() {
		$nUniqueId =	$this->input->get('id', TRUE);
		$year_level =	$this->input->get('year_level', TRUE);
		$semester =	$this->input->get('semester', TRUE);
		if (isset($nUniqueId)) {
			$aStudentInfo 			=	$this->earistlib->StudentInfo($nUniqueId);
			$aGrades 				=	$this->earistlib->Grades($aStudentInfo['student_no']); 
			if(isset($year_level) && isset($semester)){
				$aGrades 				=	$this->earistlib->CustomGrades($aStudentInfo['student_no'],$year_level,$semester); 
			} 
			$this->aHtml['title'] 		=	"Grade Entry";
			$this->aHtml['yearlevels'] 	=	$this->earistlib->dropSubjects($aStudentInfo['course'])[0];
			$this->aHtml['subjects'] 	=	$this->earistlib->dropSubjects($aStudentInfo['course'])[1];
			$this->aHtml['availableYearSemester'] 	=	$this->earistlib->availableYearSemester($aStudentInfo['course'],$nUniqueId)[0];
			$this->aHtml['enrolledCourses'] 	=	$this->earistlib->availableYearSemester($aStudentInfo['course'],$nUniqueId)[1];
			$this->aHtml['info'] 		=	$aStudentInfo;
			$this->aHtml['grades'] 		=	$aGrades;

			$aViewData              =   array("module" => $this->load->view("grade_entry_v", $this->aHtml, TRUE));

			$this->load->view('main_v', $aViewData);
		}
	}

	public function performer() {
		$this->aHtml['title'] 	=	"Top Performers";
		$aStudentGrades 		= 	[];
		$aGrades 				=	$this->earistlib->Grades('');

		foreach($aGrades as $nStudenNo => $aGradeDetails) {
			$aStudentInfo 	=	$this->earistlib->StudentInfoByNo($nStudenNo);

			if ($aStudentInfo['deletedby'] == "") {
				$sName 		= ucwords(strtolower($aStudentInfo['last_name'].", ".$aStudentInfo['first_name']." ".$aStudentInfo['middle_name'][0]."."));
				$nYearLevel = $aStudentInfo['year_level'];
				$sSemester 	= $aStudentInfo['semester'];
				$sSection 	= $aStudentInfo['section'];
				$sCourse 	= $aStudentInfo['course'];
				
				$aGrades = $aGradeDetails[$nYearLevel][$sSemester][$sSection];
				$nTotalUnits = 0;
				$nTotalAve = 0;

				foreach($aGrades as $sSubCode => $sMidFinGrade) {

					$aSubjects  = SUBJECTS[$sCourse][$nYearLevel][$sSemester];

					$nUnits = $aSubjects[$sSubCode][3];

					$aMidFinGrades = explode("|", $sMidFinGrade);
					$fPointGrd = ($aMidFinGrades[0] + $aMidFinGrades[1]) / 2;

					$aGradePoint = gradeRangePoint($fPointGrd);
					$aAveUnits = (float) $aGradePoint[1] * $nUnits;

					$nTotalUnits += $nUnits;
					$nTotalAve += $aAveUnits;	
				}
				
				$fGwa = number_format($nTotalAve / $nTotalUnits, 2);
				
				if ($this->earistlib->gradesClass($fGwa) == "top") {
					$aStudentGrades[$nStudenNo] = [
						'name' => $sName,
						'year_level' => YEARLEVEL[$nYearLevel],
						'semester' => $sSemester  == "sem_one" ? "First Semester" : "Second Semester",
						'section' => $sSection,
						'course' => $sCourse  == "cs" ? "Computer Science" : "Information Technology",
						'final_grade' => $fGwa,
						'classes' => " div-{$nYearLevel} div-{$sSemester} div-{$sCourse} div-{$sSection}"
					];
				}
			}
		}
		
		$this->aHtml['student_grades'] 	=	$aStudentGrades;
		$aViewData =   array("module" => $this->load->view("performer_v", $this->aHtml, TRUE));

		$this->load->view('main_v', $aViewData);
	}


	public function failed() {
		$this->aHtml['title'] 	=	"Failed Students";
		$aViewData              =   array("module" => $this->load->view("failed_v", $this->aHtml, TRUE));

		$aStudentGrades 		= 	[];
		$aGrades 				=	$this->earistlib->Grades('');

		foreach($aGrades as $nStudenNo => $aGradeDetails) {
			$aStudentInfo 	=	$this->earistlib->StudentInfoByNo($nStudenNo);
			$sName 		= ucwords(strtolower($aStudentInfo['last_name'].", ".$aStudentInfo['first_name']." ".$aStudentInfo['middle_name'][0]."."));
			$nYearLevel = $aStudentInfo['year_level'];
			$sSemester 	= $aStudentInfo['semester'];
			$sSection 	= $aStudentInfo['section'];
			$sCourse 	= $aStudentInfo['course'];
			
			$aGrades = $aGradeDetails[$nYearLevel][$sSemester][$sSection];
			$nTotalUnits = 0;
			$nTotalAve = 0;

			foreach($aGrades as $sSubCode => $sMidFinGrade) {

				$aSubjects  = SUBJECTS[$sCourse][$nYearLevel][$sSemester];

				$nUnits = $aSubjects[$sSubCode][3];

				$aMidFinGrades = explode("|", $sMidFinGrade);
				$fPointGrd = ($aMidFinGrades[0] + $aMidFinGrades[1]) / 2;

				$aGradePoint = gradeRangePoint($fPointGrd);
				$aAveUnits = (float) $aGradePoint[1] * $nUnits;

				$nTotalUnits += $nUnits;
				$nTotalAve += $aAveUnits;	
			}
			

			// $fGwa = number_format(array_sum($aGWA) / sizeof($aGWA), 2);
			$fGwa = number_format($nTotalAve / $nTotalUnits, 2);
			
			if ($this->earistlib->gradesClass($fGwa) == "failed") {
				$aStudentGrades[$nStudenNo] = [
					'name' => $sName,
					'year_level' => YEARLEVEL[$nYearLevel],
					'semester' => $sSemester  == "sem_one" ? "First Semester" : "Second Semester",
					'section' => $sSection,
					'course' => $sCourse  == "cs" ? "Computer Science" : "Information Technology",
					'final_grade' => $fGwa,
					'classes' => " div-{$nYearLevel} div-{$sSemester} div-{$sCourse} div-{$sSection}"
				];
			}
		}
		
		$this->aHtml['student_grades'] 	=	$aStudentGrades;
		$aViewData =   array("module" => $this->load->view("failed_v", $this->aHtml, TRUE));

		$this->load->view('main_v', $aViewData);
	}


	public function incomplete() {
		$this->aHtml['title'] 	=	"Incomplete";
		$aViewData              =   array("module" => $this->load->view("failed_v", $this->aHtml, TRUE));

		$aStudentGrades 		= 	[];
		$aGrades 				=	$this->earistlib->Grades('');

		foreach($aGrades as $nStudenNo => $aGradeDetails) {
			$aStudentInfo 	=	$this->earistlib->StudentInfoByNo($nStudenNo);
			$sName 		= ucwords(strtolower($aStudentInfo['last_name'].", ".$aStudentInfo['first_name']." ".$aStudentInfo['middle_name'][0]."."));
			$nYearLevel = $aStudentInfo['year_level'];
			$sSemester 	= $aStudentInfo['semester'];
			$sSection 	= $aStudentInfo['section'];
			$sCourse 	= $aStudentInfo['course'];
			
			$aGrades = $aGradeDetails[$nYearLevel][$sSemester][$sSection];
			$nTotalUnits = 0;
			$nTotalAve = 0;

			$nIncCntr = 0;
			if ($aStudentInfo['status'] == "reg") {

				foreach($aGrades as $sSubCode => $sMidFinGrade) {

					$aSubjects  = SUBJECTS[$sCourse][$nYearLevel][$sSemester];

					$nUnits = $aSubjects[$sSubCode][3];

					$aMidFinGrades = explode("|", $sMidFinGrade);
					if ($aMidFinGrades[0] > 0 && $aMidFinGrades[1] <= 0) {

						$nIncCntr++;
					} else {
						$fPointGrd = ($aMidFinGrades[0] + $aMidFinGrades[1]) / 2;

						$aGradePoint = gradeRangePoint($fPointGrd);
						$aAveUnits = (float) $aGradePoint[1] * $nUnits;

						$nTotalUnits += $nUnits;
						$nTotalAve += $aAveUnits;
					}
				}
				
				$fGwa = $nIncCntr > 0 ? "inc" : number_format($nTotalAve / $nTotalUnits, 2);
				
				if ($this->earistlib->gradesClass($fGwa) == "inc") {
					$aStudentGrades[$nStudenNo] = [
						'name' => $sName,
						'year_level' => YEARLEVEL[$nYearLevel],
						'semester' => $sSemester  == "sem_one" ? "First Semester" : "Second Semester",
						'section' => $sSection,
						'course' => $sCourse  == "cs" ? "Computer Science" : "Information Technology",
						'final_grade' => "Incomplete",
						'classes' => " div-{$nYearLevel} div-{$sSemester} div-{$sCourse} div-{$sSection}"
					];
				}
			}
		}
		
		$this->aHtml['student_grades'] 	=	$aStudentGrades;
		$aViewData =   array("module" => $this->load->view("incomplete_v", $this->aHtml, TRUE));

		$this->load->view('main_v', $aViewData);
	}

	

	public function accounts() {
		$this->aHtml['title'] 	=	"User Accounts";
		$aViewData              =   array("module" => $this->load->view("accounts_v", $this->aHtml, TRUE));

		$this->load->view('main_v', $aViewData);
	}

	public function students() {
		$this->aHtml['title'] 	=	"Student Accounts";
		$aViewData              =   array("module" => $this->load->view("students_v", $this->aHtml, TRUE));

		$this->load->view('main_v', $aViewData);
	}

	public function logout() {
		$this->session->set_userdata('uname', '');
		redirect(base_url());
	}	
}
