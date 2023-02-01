<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Grades extends CI_Controller {

		private $aHtml = array();

	    public function __construct() {
	        parent::__construct();
	    }

        public function save_grades() {
            $nUniqueId 	    =	$this->input->post('id');
            $aData 		    =	$this->earistlib->JsonToArray(json_decode($this->input->post('data')));

            $aStudentInfo   =	$this->earistlib->StudentInfo($nUniqueId);
            $sStudentNo     =   $aStudentInfo['student_no'];
            $sCourse        =   $aStudentInfo['course'];
            $nYear          =   $aStudentInfo['year_level'];
            $sSemester      =   $aStudentInfo['semester'];
            $sSection       =   $aStudentInfo['section'];            
            
            $this->db->delete('tbl_grades', [
                'student_no' => $sStudentNo,
                'course' => $sCourse,
                'year_level' => $nYear,
                'semester' => $sSemester,
                'section' => $sSection,
            ]);

            $aSubData = [];
            foreach($aData as $sSubCode => $fGrade) {
                $aSubCode = explode("_", $sSubCode);

                $aSubData[$aSubCode[0]][$aSubCode[1]] = $fGrade;

            }

            $aBatchData     =   [];
            foreach($aSubData as $sSubCode => $aGradeDet) {
                $aBatchData[] = [
                        'student_no' => $sStudentNo,
                        'year_level' => $nYear,
                        'semester' => $sSemester,
                        'course' => $sCourse,
                        'section' => $sSection,
                        'subject_code' => $sSubCode,
                        'mid_grade' => $aGradeDet['mid'],
                        'final_grade' => $aGradeDet['fin'],
                ];
            }

            $eGrades = $this->db->insert_batch('tbl_grades', $aBatchData);
            if ($eGrades == true) {
                echo "
                        toastr.success('Grades successfully saved!');
                        _refresh();
                    ";
            } else {
                echo "toastr.error('Failed to save grades.');";
            }
        }

        public function print_grades() {
			$nUniqueId 	  =	$this->input->post('id');
            // print_r($this->earistlib->GenGrades($nUniqueId));
            echo "window.open('".$this->earistlib->GenGrades($nUniqueId)."')";
		}
    }
    
?>
