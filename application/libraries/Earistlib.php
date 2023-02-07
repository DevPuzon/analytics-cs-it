<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH.'third_party/fpdf/fpdf.php';
include APPPATH.'third_party/phpmailer/class.phpmailer.php';

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


	class PDF extends FPDF
	{
		// Page header
		function Header()
		{
			// Logo
			
			$this->Image('assets/images/earist-logo-circle.png',60,6,25);
			// Arial bold 15
			
			// Move to the right
			$this->Cell(80);
			$this->SetFont('Arial','',10);
			$this->Cell(100,5,'Republic of the Philippines',0,1,'C');

			$this->Cell(80);
			$this->SetFont('Arial','',10);
			$this->Cell(100,5,'EULOGIO "AMANG" RODRIGUEZ',0,1,'C');
			$this->Cell(80);
			$this->Cell(100,5,'INSTITUTE SCIENCE AND TECHNOLOGY',0,1,'C');

			$this->Cell(80);
			$this->SetFont('Arial','',10);
			$this->Cell(100,5,'Nagtahan, Sampaloc, Manila',0,1,'C');

			$this->Cell(80);
			$this->SetFont('Arial','',10);
			$this->Cell(100,5,'COLLEGE OF ARTS AND SCIENCES',0,1,'C');
			// Line break

			$this->Image('assets/images/cas-logo.png',200,6,25);
			$this->Ln(5);
		}

		// Page footer
		// function Footer()
		// {
		// 	// Position at 1.5 cm from bottom
		// 	$this->SetY(-15);
		// 	// Arial italic 8
		// 	$this->SetFont('Arial','I',8);
		// 	// Page number
		// 	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		// }
	}

	class Earistlib {

		public function __construct() {

            
		}

		public function JsonToArray($aJsonData) {

			$aJsonArray	=	$aJsonData;
			foreach ($aJsonArray as $sDataKey => $value)
			{
				$aReturn[$sDataKey] = $value;
			}
			return $aReturn;
		}

		public function ExecQuery($aDataCols, $sTable, $sAction, $sWhere) {
			$CI =& get_instance();

			$qQuery =	$this->createQuery($aDataCols, $sTable, $sAction, $sWhere);
			return $CI->db->query($qQuery);
		}

		private function createQuery($aDataCols, $sTable, $sAction, $sWhere) {
			$CI =& get_instance();
			$qQuery =	"";
			switch ($sAction) {
				case 'save':
						

					$sCols 	=	"";
					$sVals 	=	"";

					foreach ($aDataCols as $sDataKey => $sValue) {

						$sCols 	.=	"`".$CI->datakeys->getKey($sDataKey)."`,";
						$sVals 	.=	"'".addslashes($sValue)."',";
					}

					$sCols 	=	substr($sCols, 0, -1);
					$sVals 	=	substr($sVals, 0, -1);

					$qQuery =	"INSERT INTO ".$sTable." (".$sCols.") VALUES (".$sVals.");";
				break;

				case 'update':
						

					$sCols 	=	"";
					$sWher 	=	"";

					foreach ($aDataCols as $sDataKey => $sValue) {

						$sCols 	.=	"`".$CI->datakeys->getKey($sDataKey)."` = '".addslashes($sValue)."',";
					}

					foreach ($sWhere as $sDataKey => $sValue) {

						$sWher 	.=	"`".$CI->datakeys->getKey($sDataKey)."` = '".addslashes($sValue)."'";
					}

					$sCols 	=	substr($sCols, 0, -1);

					$qQuery =	"UPDATE ".$sTable." SET ".$sCols." WHERE ".$sWher.";";

				break;

				case 'search':

					$sCols 	=	"";
					$sVals 	=	"";

					foreach ($sWhere as $sDataKey => $sValue) {

						$sCols 	.=	"`".$CI->datakeys->getKey($sDataKey)."` = '".addslashes($sValue)."'";
					}

					$qQuery =	"SELECT * FROM ".$sTable." WHERE ".$sCols;

				break;

				case 'fetch':

					$qQuery =	"SELECT * FROM ".$sTable;

				break;
				
				
				default:
					$qQuery =	$sAction;
					break;
			}

			return $qQuery;
		}

		public function Upload($sFileName, $sPath) {

	    	$CI =& get_instance();
	    	
	        $config = array (
	        	'file_name' 	=> $sFileName,
	            'upload_path'   => $sPath."/",
	            'allowed_types' => 'png|jpeg|jpg',
	            'overwrite'     => TRUE,
	        );
	        

	        $CI->load->library('upload', $config);
        	$CI->upload->initialize($config);
        	
        	if ($CI->upload->do_upload('upFile'))
        	{

        		return json_encode(array("return" => true, "filename" => $sFileName));
        	}
        	else 
        	{
        		echo $CI->upload->display_errors();
        		// return json_encode(array("return" => false));
        	}
	    }

	    public function Dropdowns($sType, $sDataKey, $sSelected) {

	    	$eFetchDropdowns	=	$this->ExecQuery('', 'tblkp_dropdowns', 'fetch', '');

			$aDropdownsRes 		=	$eFetchDropdowns->result_array();
			
			$aDropdownData 		=	array();

			foreach ($aDropdownsRes as $nKey => $aData) {

				if ($sType == $aDropdownsRes[$nKey]['dropdown_type']) {

					if ($aDropdownsRes[$nKey]['isdeleted'] != 'Y') {

						$aDropdownData[$aDropdownsRes[$nKey]['dropdown_type']][$aDropdownsRes[$nKey]['id']] =	$aDropdownsRes[$nKey]['dropdown_value'];

					}
				}

			}

			$sSelect 	=  "";

			foreach ($aDropdownData as $sType => $aValues) {

				$sSelect 	=	"<select class='form-control' data-key='".$sDataKey."' data='req'>
											<option value=''></option>
										";

				foreach ($aValues as $nId => $sValue) {

					$vSelected 	=	$nId == $sSelected ? " selected" : "";
					$sSelect 	.= "<option value='".$nId."' ".$vSelected.">".$sValue."</option>";

				}

				$sSelect 	.=	"</select>";
			}

			return $sSelect;
	    }

	    public function GetDropDownValue($nId) {

	    	$eDropDown	=	$this->ExecQuery('', 'tblkp_dropdowns', 'search', array("UniqueId" => $nId));
	    	$aDropDown 	=	$eDropDown->result_array();
			return $aDropDown[0]['dropdown_value'];
	    }

	    public function StudentInfo($nIdno) {

	    	$eInfo	=	 $this->ExecQuery('', 'tbl_students', 'search', array("UniqueId" => $nIdno));
	    	$aInfo 	=	 $eInfo->result_array();
			
	    	return $aInfo[0];

	    }

	    public function StudentCourseEnrollInfos($nIdno) {

	    	$eInfo	=	 $this->ExecQuery('', 'tbl_course_enroll', 'search', array("StudentId" => $nIdno));
	    	$aInfo 	=	 $eInfo->result_array();

	    	return $aInfo;

	    }


		public function StudentInfoByNo($nIdno) {

	    	$eInfo	=	 $this->ExecQuery('', 'tbl_students', 'search', array("StudentNo" => $nIdno));
	    	$aInfo 	=	 $eInfo->result_array();

	    	return $aInfo[0];

	    }

		public function Grades($sStudentNo) {

			if ($sStudentNo != "") {

				$eGrades	=	 $this->ExecQuery('', 'tbl_grades', 'search', array("StudentNo" => $sStudentNo)); 
				$aGrades 	=	 $eGrades->result_array();

				return $aGrades;
			} else {
				$eGrades	=	 $this->ExecQuery('', 'tbl_grades', 'fetch', ''); 
				$aGrades 	=	 $eGrades->result_array();

				$aStudentGrades = [];
				foreach($aGrades as $nKey => $aGradeDetails) {
					$aStudentGrades[$aGradeDetails['student_no']][$aGradeDetails['year_level']][$aGradeDetails['semester']][$aGradeDetails['section']][$aGradeDetails['subject_code']] = $aGradeDetails['mid_grade']."|".$aGradeDetails['final_grade'];
				}

				return $aStudentGrades;
			}

	    }

		public function convertGrade($grade){
			$grade = floatval($floatval);
			if($grade == 1 ){
				return 100;
			}else if ($grade  >= 1.25 && $grade < 1 ){
				return 96;
			} else if ($grade  >= 1.5 && $grade < 1.25 ){
				return 93;
			} else if ($grade  >= 1.75 && $grade < 1.5 ){
				return 90;
			} else if ($grade  >= 2 && $grade < 1.75 ){
				return 87;
			} else if ($grade  >= 2.25 && $grade < 2 ){
				return 84;
			} else if ($grade  >= 2.5 && $grade < 2.25 ){
				return 81;
			} else if ($grade  >= 2.75 && $grade < 2.5 ){
				return 78;
			} else if ($grade  >= 3 && $grade < 2.75 ){
				return 75;
			} else if ($grade  >= 5 && $grade < 3 ){
				return 72;
			} else{
				return 0;
			}
		}
		
		public function CustomGrades($sStudentNo,$year_level,$semester) { 
			
			$qQuery = "SELECT * FROM `tbl_grades` WHERE `student_no` = '".$sStudentNo."'"; 
			$qQuery .= $year_level != "" ? " AND `year_level` = '".$year_level."'" : "";
			$qQuery .= $semester != "" ? " AND `semester` = '".$semester."'" : "";  
			
			$qGrades	=	$this->ExecQuery('', 'tbl_grades', $qQuery, '');

			// $qGrades	=	 $this->ExecQuery('', 'tbl_grades', 'search', array("StudentNo" => $sStudentNo,"YearLevel" => $year_level,"Semester" => $semester)); 
			$aGrades 	=	 $qGrades->result_array(); 
			return $aGrades;
	    }

	    public function GenPDF($sCourse, $sYear, $sSem, $sSec, $sStatus, $sSortBy, $sSort) {

			$qQuery = "SELECT * FROM `tbl_students` WHERE `deletedby` is null";

			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSec != "" ? " AND `section` = '".$sSec."'" : "";
			$qQuery .= $sStatus != "" ? " AND `status` = '".$sStatus."'" : "";

			$qQuery .= " ORDER BY `".$sSortBy."` ".$sSort.""; 
			
			$eFetchStudents	=	$this->ExecQuery('', 'tbl_students', $qQuery, '');
			
			
			if ($sCourse == "cs") {
				$sHeader = "Computer Science Students";
				$sFileName  =  "Computer_Science_Students.pdf";
			} else {
				$sHeader = "Information Technology Students";
				$sFileName  = "Information_Technology_Students.pdf";
			}
	    	
	    	$pdf = new PDF();
            $pdf->AddPage('L');
			
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(260,10,$sHeader, 0, 0, 'C');

			$pdf->SetFont('Arial','B',10);
            $pdf->Ln(10);
			$pdf->Cell(25);
            $pdf->Cell(25,5,"Student No.", 1, 0, 'C');
            $pdf->Cell(35,5,"Last Name", 1, 0, 'C');
			$pdf->Cell(35,5,"First Name", 1, 0, 'C');
            $pdf->Cell(15,5,"M.I.", 1, 0, 'C');
			$pdf->Cell(25,5,"Year Level", 1, 0, 'C');
			$pdf->Cell(15,5,"Section", 1, 0, 'C');
			$pdf->Cell(30,5,"Semester", 1, 0, 'C');
			$pdf->Cell(25,5,"Status", 1, 0, 'C');
			$pdf->Cell(15,5,"GWA", 1, 1, 'C');
			
            $aStudents    =   $eFetchStudents->result_array();

			$pdf->SetFont('Arial','',9);
			
    		foreach ($aStudents as $key => $aValue) {
				$pdf->Cell(25);	
				$pdf->Cell(25,5, $aValue['student_no'], 1, 0, 'L');
				$pdf->Cell(35,5, ucwords(strtolower(trim($aValue['last_name']))), 1, 0, 'L');
				$pdf->Cell(35,5, ucwords(strtolower(trim($aValue['first_name']))), 1, 0, 'L');
				$pdf->Cell(15,5, ucwords(strtolower($aValue['middle_name'][0])), 1, 0, 'C');
				$pdf->Cell(25,5, YEARLEVEL[$aValue['year_level']], 1, 0, 'L');
				$pdf->Cell(15,5, $aValue['section'],1, 0, 'L');
				$pdf->Cell(30,5, ( $aValue['semester'] == "sem_one" ? "First Semester" : "Second Semester") ,1, 0, 'L');
				$pdf->Cell(25,5, ($aValue['status'] != '' ? STUDENTSTAT[$aValue['status']] : '-'), 1, 0, 'L');
				$pdf->Cell(15,5,$this->getGWA($aValue['id']), 1, 1, 'C');
			}
			
			$pdf->Output('F', 'reports/'.$sFileName, true);

            return base_url()."reports/". $sFileName;

	    }

		public function GenGrades($nId) {
			
			$aStudentInfo 	=	$this->StudentInfo($nId);

			$nStudenNo 	= $aStudentInfo['student_no'];
			$nYearLevel = $aStudentInfo['year_level'];
			$sSemester 	= $aStudentInfo['semester'];
			$sSection 	= $aStudentInfo['section'];
			$sCourse 	= $aStudentInfo['course'];
			$sStat 		= $aStudentInfo['status'];

			$grades = $this->Grades($nStudenNo);

			$sFileName  = "Grade_Report_".$nStudenNo.".pdf";

			$sCrs = $sCourse == "cs" ? "Bachelor of Science in Computer Science" : "Bachelor of Science in Information Technology";

	    	$pdf = new PDF();
            $pdf->AddPage('L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(275,10,"Grade Report", 0, 0, 'C');

            $pdf->Ln(10);
			$pdf->Cell(25,5,"Student No:", 1, 0, 'L');
			$pdf->Cell(60,5,$nStudenNo, 1, 0, 'L');
            $pdf->Cell(25,5,"Name:", 1, 0, 'L');
            $pdf->Cell(80,5,ucwords(strtolower($aStudentInfo['last_name']).", ".$aStudentInfo['first_name'].", ".$aStudentInfo['middle_name'][0]."."), 1, 1, ' L');
			$pdf->Cell(25,5,"Yr - Sec.:", 1, 0, 'L');
			$pdf->Cell(60,5,YEARLEVEL[$nYearLevel]." - ".$sSection ." (".STUDENTSTAT[$sStat].")", 1, 0, 'L');
            $pdf->Cell(25,5,"Course:", 1, 0, 'L');
			$pdf->Cell(80,5,$sCrs, 1, 1, ' L');

			$pdf->Ln(10);
            $pdf->Cell(30,5,"Code", 1, 0, 'C');
            $pdf->Cell(70,5,"Subject", 1, 0, 'C');
            $pdf->Cell(20,5,"Units", 1, 0, 'C');
            $pdf->Cell(25,5,"Mid Term", 1, 0, 'C');
			$pdf->Cell(25,5,"Final Term", 1, 0, 'C');
			$pdf->Cell(70,5,"Final Grade", 1, 0, 'C');
			$pdf->Cell(35,5,"Remarks", 1, 1, 'C');

			$pdf->Cell(30,5,"", 1, 0, 'C');
            $pdf->Cell(70,5,"", 1, 0, 'C');
            $pdf->Cell(20,5,"", 1, 0, 'C');
            $pdf->Cell(25,5,"", 1, 0, 'C');
			$pdf->Cell(25,5,"", 1, 0, 'C');
			$pdf->Cell(35,5,"Grade Range", 1, 0, 'C');
			$pdf->Cell(35,5,"Grade Point", 1, 0, 'C');
			$pdf->Cell(35,5,"", 1, 1, 'C');

			$pdf->SetFont('Arial','',10);

            $aGWA = [];
			$aGrades = [];

			if (sizeof($grades) > 0) {
				foreach($grades as $nKey => $aGradeDetails) {
					$aGrades[$aGradeDetails['course']][$aGradeDetails['year_level']][$aGradeDetails['semester']][$aGradeDetails['subject_code']] = $aGradeDetails['mid_grade']."|".$aGradeDetails['final_grade'];
				}
			}

			$aSubjects  = SUBJECTS[$sCourse][$nYearLevel][$sSemester];

			foreach($aSubjects as $sSubCode => $aDetails) {
				$sSubject 	= $aDetails[0];
				$nHrsLec 	= $aDetails[1];
				$nHrsLab 	= $aDetails[2];
				$nUnitsLec 	= $aDetails[3] != '' ? $aDetails[3] : '-';
				$nUnitsLab 	= $aDetails[4] != '' ? $aDetails[4] : '-';
				$nTotalUnits= $aDetails[5]; 

				$aMidFinGrades = isset($aGrades[$sCourse][$nYearLevel][$sSemester][$sSubCode]) ? explode("|", $aGrades[$sCourse][$nYearLevel][$sSemester][$sSubCode]) : [0,0];

				$sMidGrade = $aMidFinGrades > 0 ? $aMidFinGrades[0] : '';
				$sFinalGrade = $aMidFinGrades > 0 ? $aMidFinGrades[1] : '';

				if ($sMidGrade > 0 && $sFinalGrade > 0) {
					$fGradeAve = ($sMidGrade + $sFinalGrade) / 2;
					$aGradeDet = gradeRangePoint($fGradeAve);

					$sGradexUnits = ( ($aGradeDet[1] > 0 ) ? ( $aGradeDet[1] * $nUnitsLec ) : 0);
					if (isset($aGWA['grd'])) {
						$aGWA['grd'] += $sGradexUnits;
						$aGWA['unt'] += $nUnitsLec;
					} else {
						$aGWA['grd'] = $sGradexUnits;
						$aGWA['unt'] = $nUnitsLec;
					}

				} else {
					$aGradeDet = gradeRangePoint("");
					$aGWA['grd'] = 0;
					$aGWA['unt'] = 0;
				}

				$pdf->Cell(30,5,$sSubCode, 1, 0, 'L');
				$pdf->Cell(70,5,$sSubject, 1, 0, 'L');
				$pdf->Cell(20,5,$nUnitsLec, 1, 0, 'C');
				$pdf->Cell(25,5,$sMidGrade, 1, 0, 'C');
				$pdf->Cell(25,5,$sFinalGrade, 1, 0, 'C');
				$pdf->Cell(35,5,$aGradeDet[0], 1, 0, 'C');
				$pdf->Cell(35,5,$aGradeDet[1], 1, 0, 'C');
				$pdf->Cell(35,5,$aGradeDet[2], 1, 1, 'C');

			}
			$pdf->Cell(275,5,( $aGWA['grd'] > 0 ? number_format($aGWA['grd'] / $aGWA['unt'], 2) : '' ), 1, 1, 'R');

			$pdf->Output('F', 'reports/'.$sFileName, true);

            return base_url()."reports/". $sFileName;

	    }

		public function GenClassifications($sType, $sYear, $sSem, $sCourse, $sSection) {
			
			if ($sType == "performers") {
				$sHeader = "Top Performers";
				$sGwa = "top";
				$sFileName = "Top_Performers.pdf";
			} else if ($sType == "failed") {
				$sHeader = "Failed Students";
				$sGwa = "failed";
				$sFileName = "Failed_Students.pdf";
			} else if ($sType == "inc") {
				$sHeader = "Incomplete Students";
				$sGwa = "inc";
				$sFileName = "Incomplete_Students.pdf";
			} else if ($sType == "dropped") {
				$sHeader = "Dropped Students";
				$sGwa = "drp";
				$sFileName = "Dropped_Students.pdf";
			}

			$aParams = [];
			if ($sYear != "") {
				$aParams['year_level'] = $sYear;
			}

			if ($sSem != "") {
				$aParams['semester'] = $sSem;
			}

			if ($sCourse != "") {
				$aParams['course'] = $sCourse;
			}

			$aStudentGrades 		= 	[];
			// $aGrades 				=	$this->Grades('');

			$qQuery = "SELECT * FROM `tbl_grades` WHERE `deletedby` is null";

			$qQuery .= $sCourse != "" ? " AND `course` = '".$sCourse."'" : "";
			$qQuery .= $sYear != "" ? " AND `year_level` = '".$sYear."'" : "";
			$qQuery .= $sSem != "" ? " AND `semester` = '".$sSem."'" : "";
			$qQuery .= $sSection != "" ? " AND `section` = '".$sSection."'" : "";
			
			$qGrades	=	$this->ExecQuery('', 'tbl_grades', $qQuery, '');
			$eGrades 	=	$qGrades->result_array();

			$aGrades 	=	[];
			foreach($eGrades as $nKey => $aGradeDets) {
				$aGrades[$aGradeDets['student_no']][$aGradeDets['year_level']][$aGradeDets['semester']][$aGradeDets['section']][$aGradeDets['subject_code']] = $aGradeDets['mid_grade']."|".$aGradeDets['final_grade'];
			}

			foreach($aGrades as $nStudenNo => $aGradeDetails) {
				$aStudentInfo 	=	$this->StudentInfoByNo($nStudenNo);
				if ($aStudentInfo['deletedby'] == "") {
					$sName 		= ucwords(strtolower($aStudentInfo['last_name'].", ".$aStudentInfo['first_name']." ".$aStudentInfo['middle_name'][0]."."));

					$nYearLevel = $aStudentInfo['year_level'];
					$sSemester 	= $aStudentInfo['semester'];
					$sSection 	= $aStudentInfo['section'];
					$sCourse 	= $aStudentInfo['course'];
					
					$aGrades = $aGradeDetails[$nYearLevel][$sSemester][$sSection];
					$nTotalUnits = 0;
					$nTotalAve = 0;

					$nIncCntr = 0;

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
					
					if ($this->gradesClass($fGwa) == $sGwa) {
						$aStudentGrades[$nStudenNo] = [
							'name' => $sName,
							'year_level' => YEARLEVEL[$nYearLevel],
							'semester' => $sSemester  == "sem_one" ? "First Semester" : "Second Semester",
							'section' => $sSection,
							'course' => $sCourse  == "cs" ? "Computer Science" : "Information Technology",
							'final_grade' => ($fGwa == "inc" ? "-" : $fGwa),

						];
					}
				}
			}

			$pdf = new PDF();
            $pdf->AddPage('L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(260,10,$sHeader, 0, 0, 'C');

			$pdf->Ln(10);
			$pdf->Cell(20);
            $pdf->Cell(30,5,"Student No.", 1, 0, 'C');
            $pdf->Cell(70,5,"Name", 1, 0, 'C');
            $pdf->Cell(70,5,"Course", 1, 0, 'C');
            $pdf->Cell(40,5,"Year & Section", 1, 0, 'C');
			$pdf->Cell(25,5,"GWA", 1, 1, 'C');

			$pdf->SetFont('Arial','',10);
			foreach($aStudentGrades as $nStudenNo => $aDetails) {
				$pdf->Cell(20);
				$pdf->Cell(30,5,$nStudenNo, 1, 0, 'L');
            	$pdf->Cell(70,5,$aDetails['name'], 1, 0, 'L');
            	$pdf->Cell(70,5,$aDetails['course'], 1, 0, 'L');
            	$pdf->Cell(40,5,$aDetails['year_level']." - ".$aDetails['section'], 1, 0, 'L');
				$pdf->Cell(25,5,$aDetails['final_grade'], 1, 1, 'C');
			}

			$pdf->Output('F', 'reports/'.$sFileName, true);

            return base_url()."reports/". $sFileName;

		}

	    public function GenXLS($dFrom, $dTo) {

	    	$oExcelClass 	= 	new Spreadsheet();

	    	$sFileName  =  'reports/Activity_Reports_'.$dFrom."-".$dTo.'.xlsx';

        	$writer     =  new Xlsx($oExcelClass);

        	$oExcelClass->getActiveSheet()->setCellValue('A1',"Name");
        	$oExcelClass->getActiveSheet()->setCellValue('B1',"Type");
        	$oExcelClass->getActiveSheet()->setCellValue('C1',"Id No.");
        	$oExcelClass->getActiveSheet()->setCellValue('D1',"Temperature");
        	$oExcelClass->getActiveSheet()->setCellValue('E1',"Date Time");
            
            $eFetchAct	=	$this->ExecQuery('', 'tbl_assessment', "SELECT * FROM tbl_assessment WHERE EntryDate BETWEEN '".$dFrom." 00:00:00' AND '".$dTo." 23:23:59' ORDER BY EntryDate ASC", '');

	    	$aActivities 	=	$eFetchAct->result_array();

	    	$nCol =	 2;

    		foreach ($aActivities as $key => $aParam) {

	            $sTickAns 	=	0;
				$sInputsAns	=	0;
				
				$vIdno 		=	$aParam['Idno'];
				$vTemp 		=	$aParam['Temperature'];
				$dActDate	=	date("Y-m-d H:i", strtotime($aParam['EntryDate']));
				$aTickboxes	=	$aParam['Tickboxes'] != '' ? json_decode($aParam['Tickboxes']) : '';
				$aInputs	=	$aParam['Inputs'] != '' ? json_decode($aParam['Inputs']) : '';

				$eGetInfo	=	$this->ExecQuery('', 'tbl_personel', 'search', array('PersonCode' => $vIdno));
				$aInfo 		=	$eGetInfo->result_array();

				

				foreach ($aInfo as $key => $aValue)
				{

	    			$oExcelClass->getActiveSheet()->setCellValue('A'.$nCol, ucwords(strtolower($aValue['Lastname']." ".$aValue['Firstname']).", ".strtoupper($aValue['Middlename'][0])));
		            $oExcelClass->getActiveSheet()->setCellValue('B'.$nCol, ucfirst($aValue['Type']));
		            $oExcelClass->getActiveSheet()->setCellValue('C'.$nCol, $aValue['Idno']);
		            $oExcelClass->getActiveSheet()->setCellValue('D'.$nCol, $vTemp);
		            $oExcelClass->getActiveSheet()->setCellValue('E'.$nCol, $dActDate);

		        	$nCol++;

		        }
		    }
            
        	$writer->save($sFileName);

         	return $sFileName;
	    }

	    public function GetQrCode($vIdno, $sImage) {

	    	$pdf = new FPDF('P','mm',array(102,82));
            $pdf->AddPage('');

            $pdf->Image($sImage,8,5,-85);
            $pdf->SetFont('Arial','',16);

            $pdf->SetXY(8, 70);
            $pdf->Cell(63,10, $vIdno, 1,0,'C');

            $pdf->Output('F', 'qrcodes_pdf/'.$vIdno."_qrcode.pdf", true);



            return base_url()."qrcodes_pdf/".$vIdno."_qrcode.pdf";

	    }

		//Grading System
		public function dropSubjects($sCourse) {
			$aYearLevel = [];
			$aSubjects = [];

			foreach(SUBJECTS[$sCourse] as $sYearLevel => $aSemSubs) {

				$aYearLevel[$sYearLevel] = YEARLEVEL[$sYearLevel];

				foreach($aSemSubs as $sSemNo => $aSubDetails) {

					foreach($aSubDetails as $nSubCode => $aDetails) {
						$sSubject 	= $aDetails[0];
						$nHrsLec 	= $aDetails[1];
						$nHrsLab 	= $aDetails[2];
						$nUnitsLec 	= $aDetails[3];
						$nUnitsLab 	= $aDetails[4];
						$nTotalUnits= $aDetails[5];

						$aSubjects[$sYearLevel][$sSemNo][$nSubCode] = $sSubject;
					}
				}
			}
			return [$aYearLevel, $aSubjects];
		}

		function Search($value, $array)
		{
			return (array_search($value, $array));
		}

		function getYearSemStr($sYearLevel){ 
			if(str_contains($sYearLevel, '1') || str_contains($sYearLevel, 'one')){
				return 'First';
			}
			if(str_contains($sYearLevel, '2')|| str_contains($sYearLevel, 'two')){
				return 'Second';
			}
			if(str_contains($sYearLevel, '3')){
				return 'Third';
			}
			if(str_contains($sYearLevel, '4')){
				return 'Fourth';
			}
			return "sds";
		}

		function findObjectInArray($array, $valueToFind) {
			foreach ($array as $object) {
			  foreach ($object as $property => $value) {
				if ($value == $valueToFind) {
				  return $object;
				}
			  }
			}
			return null;
		}

		public function availableYearSemester($sCourse,$nUniqueId){ 
			$aStudentInfo 			=	$this->StudentInfo($nUniqueId); 
			$studentCourseEnrollInfos 			=	$this->StudentCourseEnrollInfos($nUniqueId);
			$enrolledCourses = [array("id"=>$aStudentInfo['year_level'].$aStudentInfo['semester'],
			"section"=>$aStudentInfo['section'])];
			
			// echo "2".var_dump($studentCourseEnrollInfos);
			foreach($studentCourseEnrollInfos as $data){
				array_push($enrolledCourses,array(
					"id"=>$data['id'],
					"el_id"=>$data['year_level'].$data['semester'],
					"section"=>$data['section']));
			} 
			$courseEnrolled = [];
			$availables = []; 
			foreach(SUBJECTS[$sCourse] as $sYearLevel => $aSemSubs) { 
				
				foreach($aSemSubs as $sSemNo => $aSubDetails) { 
					$eCourse = $this->findObjectInArray($enrolledCourses,$sYearLevel.$sSemNo);
					if(!$eCourse){  
						$availables[$sYearLevel.$sSemNo] = array(
							"year_level"=>$this->getYearSemStr($sYearLevel),
							"semester"=>$this->getYearSemStr($sSemNo),
							"year_level_coded"=>$sYearLevel,
							"semester_coded"=>$sSemNo
						);
					}else{ 
						$courseEnrolled[$sYearLevel.$sSemNo] = array(
							"id"=>$eCourse["id"],
							"year_level"=>$this->getYearSemStr($sYearLevel),
							"semester"=>$this->getYearSemStr($sSemNo),
							"section"=>$eCourse["section"],
							"year_level_coded"=>$sYearLevel,
							"semester_coded"=>$sSemNo
						);
					}
				}
			}
			return [$availables,$courseEnrolled];
		}

		public function gradesClass($fGWA) {
			if($fGWA >= 1 && $fGWA <= 1.75) {
				return "top";
			} else if ($fGWA >= 1.76 && $fGWA <= 3){
				return "passed";
			} else if ($fGWA >= 3.1 && $fGWA <= 5){
				return "failed"; 
			} else {
				return "inc";
			}
		}

		public function cntStudents() {
			$eInfo	=	$this->ExecQuery('', 'tbl_students', 'fetch', '');
			$aInfo 	= 	$eInfo->result_array();

			$aCounts =	[];
			foreach($aInfo as $nKey => $aDetails) {
				if ($aDetails['deletedby'] == null) {
					if (isset($aCounts[$aDetails['course']])) {
						$aCounts[$aDetails['course']] += 1; 
					} else {
						$aCounts[$aDetails['course']] = 1;
					}
				}
			}
			return $aCounts; 
		}

		public function graphGrades() {
			$aGraphGrades = [];
			$aGrades 	=	$this->Grades('');
			
			foreach($aGrades as $nStudenNo => $aGradeDetails) {

				$aStudentInfo 	=	$this->StudentInfoByNo($nStudenNo);

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

				if ($this->gradesClass($fGwa) != "failed" && $this->gradesClass($fGwa) != "inc" && $aStudentInfo['deletedby'] == "") {
					$aGraphGrades['passed'][$sCourse][$sSemester][YEARLEVELTXT[$nYearLevel]][] = $nStudenNo;
				} else if ($this->gradesClass($fGwa) == "failed" && $aStudentInfo['deletedby'] == "") {
					$aGraphGrades['failed'][$sCourse][$sSemester][YEARLEVELTXT[$nYearLevel]][] = $nStudenNo;
				} else {
					$aGraphGrades['inc'][$sCourse][$sSemester][YEARLEVELTXT[$nYearLevel]][] = $nStudenNo;
				}
			}

			$aPassedCs = [];
			$aPassedIt = [];
			$aFailedCs = [];
			$aFailedIt = [];
			if (isset($aGraphGrades['passed']['cs'])) {
				foreach($aGraphGrades['passed']['cs'] as $sSem => $aDetails) {

					foreach(YEARLEVEL as $sYear => $sLevel) {
						$aPassedCs[$sSem][YEARLEVELTXT[$sYear]] = isset($aDetails[YEARLEVELTXT[$sYear]]) ? sizeof($aDetails[YEARLEVELTXT[$sYear]]) : 0;
					}
				}
			}

			if (isset($aGraphGrades['passed']['it'])) {
				foreach($aGraphGrades['passed']['it'] as $sSem => $aDetails) {

					foreach(YEARLEVEL as $sYear => $sLevel) {
						$aPassedIt[$sSem][YEARLEVELTXT[$sYear]] = isset($aDetails[YEARLEVELTXT[$sYear]]) ? sizeof($aDetails[YEARLEVELTXT[$sYear]]) : 0;
					}
				}
			}

			if (isset($aGraphGrades['failed']['cs'])) {
				foreach($aGraphGrades['failed']['cs'] as $sSem => $aDetails) {

					foreach(YEARLEVEL as $sYear => $sLevel) {
						$aFailedCs[$sSem][YEARLEVELTXT[$sYear]] = isset($aDetails[YEARLEVELTXT[$sYear]]) ? sizeof($aDetails[YEARLEVELTXT[$sYear]]) : 0;
					}
				}
			}

			if (isset($aGraphGrades['failed']['it'])) {
				foreach($aGraphGrades['failed']['it'] as $sSem => $aDetails) {

					foreach(YEARLEVEL as $sYear => $sLevel) {
						$aFailedIt[$sSem][YEARLEVELTXT[$sYear]] = isset($aDetails[YEARLEVELTXT[$sYear]]) ? sizeof($aDetails[YEARLEVELTXT[$sYear]]) : 0;
					}
				}
			}

			return ['passedcs' => $aPassedCs, 'failedcs' => $aFailedCs, 'passedit' => $aPassedIt, 'failedit' => $aFailedIt];
		}

		public function sendEmail($sType, $sYear, $sSem, $sCourse) {
			$CI =& get_instance();
	
			$mail = new PHPMailer();

			

			$aParams = [];
			if ($sYear != "") {
				$aParams['year_level'] = $sYear;
			}

			if ($sSem != "") {
				$aParams['semester'] = $sSem;
			}

			if ($sCourse != "") {
				$aParams['course'] = $sCourse;
			}

			$aStudentGrades 		= 	[];
			$aGrades 				=	$this->Grades('');

			$mail->IsSMTP();
			$mail->SMTPAuth 	= true;
			$mail->SMTPDebug  = 1;  
			$mail->SMTPAuth   = TRUE;
			$mail->SMTPSecure = "tls";
			$mail->Port       = 587;
			$mail->Host       = "smtp.gmail.com";
			$mail->Username   = "earistgradingsystem@gmail.com";
			$mail->Password   = "uxgofmiwzgqkntbt";
			$mail->SetFrom("earistgradingsystem@gmail.com", "EARIST Grading System");

			foreach($aGrades as $nStudenNo => $aGradeDetails) {
				$aStudentInfo 	=	$this->StudentInfoByNo($nStudenNo);
				$sName 		= ucwords(strtolower($aStudentInfo['last_name'].", ".$aStudentInfo['first_name']." ".$aStudentInfo['middle_name'][0]."."));

				if ($sType == "notify-top") {
					$sHeader = "Top Performers";
					$sGwa = "top";
					$sContent= "Congratulations for your outstanding academic performance, you are one of the top performer in this semester. Your exceptional grades and achievements are a testament to your abilities and character.<br /><br />Please click the <a href='http://localhost:8080/earist_grading_student/certificate?idno=".$nStudenNo."'>here</a> to get your certificate.</a>";
				} else if ($sType == "notify-failed") {
					$sHeader = "Failed Students";
					$sGwa = "failed";
					$sContent= "I am writing to inform you that your recent academic performance has been unsatisfactory and you are unable to complete all of the subject requirements, and as a result, you have been given an 'Incomplete' (INC) on one or more for your subjects.
					<br /><br />
					Please do comply with your respective professor in order to know what requirements are needed to submit to replace the INC grade. ";
				} else if ($sType == "notify-inc") {
					$sHeader = "Incomplete Students";
					$sGwa = "inc";
					$sContent= "I am writing this letter to inform you that you gained a failing grade in one or more of your subjects. It appears that you have been struggling in your coursework and have not met the expected standards for passing the class.";
				} else if ($sType == "notify-dropped") {
					$sHeader = "Dropped Students";
					$sGwa = "drp";
					$sContent= "Dear Students<br /><br />Thank you for choosing our school, please come back and continue.";
				}

				$sEmail 	= $aStudentInfo['email'];
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
				
				// if ($this->gradesClass($fGwa) == $sGwa) {
				// 	if (sizeof($aParams) <= 0) { 
				// 		$aStudentGrades[$nStudenNo] = [
				// 			'name' => $sName,
				// 			'year_level' => YEARLEVEL[$nYearLevel],
				// 			'semester' => $sSemester  == "sem_one" ? "First Semester" : "Second Semester",
				// 			'section' => $sSection,
				// 			'course' => $sCourse  == "cs" ? "Computer Science" : "Information Technology",
				// 			'final_grade' => $fGwa,
				// 			'email' => $sEmail,
				// 		];
				// 	} else {
				// 		// if ( 
				// 		// 	( isset($aParams['year_level']) && $aParams['year_level'] == $nYearLevel) &&
				// 		// 	( isset($aParams['semester']) && $aParams['semester'] == $sSemester) &&
				// 		// 	( isset($aParams['course']) && $aParams['course'] == $sCourse)
				// 		// ) {
							
				// 			$aStudentGrades[$nStudenNo] = [
				// 				'name' => $sName,
				// 				'year_level' => YEARLEVEL[$nYearLevel],
				// 				'semester' => $sSemester  == "sem_one" ? "First Semester" : "Second Semester",
				// 				'section' => $sSection,
				// 				'course' => $sCourse  == "cs" ? "Computer Science" : "Information Technology",
				// 				'final_grade' => $fGwa,
				// 				'email' => $sEmail
				// 			];
				// 		// } else {
				// 		// 	echo $nYearLevel."\n";
							
				// 		// }
				// 	}
				// }

				if ($this->gradesClass($fGwa) == $sGwa) {

					$mail->AddAddress($sEmail);
					$mail->AddCC("earistgradingsystem@gmail.com", "cc-email");
			
					$mail->Subject = "EARIST | ".$sHeader;
					$mail->Body = nl2br($sContent.'
										
										This is an auto-generated email, please do not reply. <br /> <br />
										Kind Regards, <br />
										EARIST Grading System');			
					$mail->IsHTML(true);

					if(!$mail->Send()) {
						echo "Error while sending Email.";
					} else {
						echo "Email sent successfully";
					}
				}
			};
			
			
			
			
			// foreach($aStudentGrades as $nStudenNo => $aDetails) {
			// 	$mail->AddAddress($aDetails['email']);
			// }

			// $mail->AddCC("jesthonymorales@gmail.com", "cc-email");
	
			// $mail->Subject = "EARIST | ".$sHeader;
			// $mail->Body = nl2br($sContent.'
								
			// 					This is an auto-generated email, please do not reply. <br /> <br />
			// 					Kind Regards, <br />
			// 					EARIST Grading System');			
			// $mail->IsHTML(true);

			// if(!$mail->Send()) {
			// 	echo "Error while sending Email.";
			// } else {
			// 	echo "Email sent successfully";
			// }
		}

		public function getGWA($nId) {
			$aStudentInfo 	=	$this->StudentInfo($nId);

			$nStudenNo 	= $aStudentInfo['student_no'];
			$nYearLevel = $aStudentInfo['year_level'];
			$sSemester 	= $aStudentInfo['semester'];
			$sSection 	= $aStudentInfo['section'];
			$sCourse 	= $aStudentInfo['course'];
			$sStat 		= $aStudentInfo['status'];

			$grades = $this->Grades($nStudenNo);
			$aGWA = [];
			$aGrades = [];

			if (sizeof($grades) > 0) {
				foreach($grades as $nKey => $aGradeDetails) {
					$aGrades[$aGradeDetails['course']][$aGradeDetails['year_level']][$aGradeDetails['semester']][$aGradeDetails['subject_code']] = $aGradeDetails['mid_grade']."|".$aGradeDetails['final_grade'];
				}
			}

			$aSubjects  = SUBJECTS[$sCourse][$nYearLevel][$sSemester];

			foreach($aSubjects as $sSubCode => $aDetails) {
				$sSubject 	= $aDetails[0];
				$nHrsLec 	= $aDetails[1];
				$nHrsLab 	= $aDetails[2];
				$nUnitsLec 	= $aDetails[3] != '' ? $aDetails[3] : '-';
				$nUnitsLab 	= $aDetails[4] != '' ? $aDetails[4] : '-';
				$nTotalUnits= $aDetails[5]; 

				$aMidFinGrades = isset($aGrades[$sCourse][$nYearLevel][$sSemester][$sSubCode]) ? explode("|", $aGrades[$sCourse][$nYearLevel][$sSemester][$sSubCode]) : [0,0];

				$sMidGrade = $aMidFinGrades > 0 ? $aMidFinGrades[0] : '';
				$sFinalGrade = $aMidFinGrades > 0 ? $aMidFinGrades[1] : '';

				if ($sMidGrade > 0 && $sFinalGrade > 0) {
					$fGradeAve = ($sMidGrade + $sFinalGrade) / 2;
					$aGradeDet = gradeRangePoint($fGradeAve);
					$nUnitsLec  = (int)$nUnitsLec;

					$sGradexUnits = ( ((int)$aGradeDet[1] > 0 ) ? ( (int)$aGradeDet[1] * $nUnitsLec ) : 0);
					if (isset($aGWA['grd'])) {
						$aGWA['grd'] += $sGradexUnits;
						$aGWA['unt'] += $nUnitsLec;
					} else {
						$aGWA['grd'] = $sGradexUnits;
						$aGWA['unt'] = $nUnitsLec;
					}

				} else {
					$aGradeDet = gradeRangePoint("");
					$aGWA['grd'] = 0;
					$aGWA['unt'] = 0;
				}
			}

			return $aGWA['grd'] > 0 ? number_format($aGWA['grd'] / $aGWA['unt'], 2) : '';
		}

		public function getGWAv1($nId) {
			$aStudentInfo 	=	$this->StudentInfo($nId);

			$nStudenNo 	= $aStudentInfo['student_no'];
			$nYearLevel = $aStudentInfo['year_level'];
			$sSemester 	= $aStudentInfo['semester'];
			$sSection 	= $aStudentInfo['section'];
			$sCourse 	= $aStudentInfo['course'];
			$sStat 		= $aStudentInfo['status'];

			$grades = $this->Grades($nStudenNo);
			$aGWA = [];
			$aGWAList = [];
			$aGrades = [];

			if (sizeof($grades) > 0) {
				foreach($grades as $nKey => $aGradeDetails) {
					$aGrades[$aGradeDetails['course']][$aGradeDetails['year_level']][$aGradeDetails['semester']][$aGradeDetails['subject_code']] = $aGradeDetails['mid_grade']."|".$aGradeDetails['final_grade'];
				}
			}

			$aSubjects  = SUBJECTS[$sCourse][$nYearLevel][$sSemester];

			foreach($aSubjects as $sSubCode => $aDetails) {
				$sSubject 	= $aDetails[0];
				$nHrsLec 	= $aDetails[1];
				$nHrsLab 	= $aDetails[2];
				$nUnitsLec 	= $aDetails[3] != '' ? $aDetails[3] : '-';
				$nUnitsLab 	= $aDetails[4] != '' ? $aDetails[4] : '-';
				$nTotalUnits= $aDetails[5]; 

				$aMidFinGrades = isset($aGrades[$sCourse][$nYearLevel][$sSemester][$sSubCode]) ? explode("|", $aGrades[$sCourse][$nYearLevel][$sSemester][$sSubCode]) : [0,0];

				$sMidGrade = $aMidFinGrades > 0 ? $aMidFinGrades[0] : '';
				$sFinalGrade = $aMidFinGrades > 0 ? $aMidFinGrades[1] : '';

				if ($sMidGrade > 0 && $sFinalGrade > 0) {
					$fGradeAve = ($sMidGrade + $sFinalGrade) / 2;
					$aGradeDet = gradeRangePoint($fGradeAve);
					$nUnitsLec  = (int)$nUnitsLec;
					
					$sGradexUnits = ( ((int)$aGradeDet[1] > 0 ) ? ( (int)$aGradeDet[1] * $nUnitsLec ) : 0);
					if (isset($aGWA['grd'])) {
						$aGWA['grd'] += $sGradexUnits;
						$aGWA['unt'] += $nUnitsLec;
					} else {
						$aGWA['grd'] = $sGradexUnits;
						$aGWA['unt'] = $nUnitsLec;
					}

				} else {
					$aGradeDet = gradeRangePoint("");
					$aGWA['grd'] = 0;
					$aGWA['unt'] = 0;
				}
			}

			return $aGWA['grd'] > 0 ? floatval(number_format($aGWA['grd'] / $aGWA['unt'], 2)) : 0;
		}
		
		public function getGradePerCourse($student_no,$course,$year_level,$semester){ 
			$aGWA = [];
			$aGrades = [];
			$data = [];
			$grades =	$this->Grades($student_no); 
			if(isset($year_level) && isset($semester)){
				$grades 				=	$this->CustomGrades($student_no,$year_level,$semester); 
			} 
			
			if (sizeof($grades) > 0) {
				foreach($grades as $nKey => $aGradeDetails) {
					$aGrades[$aGradeDetails['course']][$aGradeDetails['year_level']][$aGradeDetails['semester']][$aGradeDetails['subject_code']] = $aGradeDetails['mid_grade']."|".$aGradeDetails['final_grade'];
				}
			}

			$aSubjects  = SUBJECTS[$course][$year_level][$semester]; 

			foreach($aSubjects as $sSubCode => $aDetails) {
				$sSubject 	= $aDetails[0];
				$nHrsLec 	= $aDetails[1];
				$nHrsLab 	= $aDetails[2];
				$nUnitsLec 	= $aDetails[3] != '' ? $aDetails[3] : '-';
				$nUnitsLab 	= $aDetails[4] != '' ? $aDetails[4] : '-';
				$nTotalUnits= $aDetails[5]; 
				
				$aMidFinGrades = isset($aGrades[$course][$year_level][$semester][$sSubCode]) ? explode("|", $aGrades[$course][$year_level][$semester][$sSubCode]) : [0,0];

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
				$data[$sSubCode] = array(
					"subject_code"=>$sSubCode,
					"subject"=>$sSubject,
					"mid"=>$sMidGrade,
					"finals"=>$sFinalGrade,
					"grade_point"=>$aGradeDet[1],
				);
			}
			$gwa = floatval(( $aGWA['grd'] > 0 ? number_format($aGWA['grd'] / $aGWA['unt'], 2) : 0 ));
			// $gwaFloat = floatval(( $aGWA['grd'] > 0 ? number_format($aGWA['grd'] / $aGWA['unt'], 2) : 0 ));
			return [$gwa,$data];
		} 

		public function overAllGwa($student_no){
			$query = "SELECT * FROM`tbl_grades` as gr left join `tbl_students` as st 
			on st.student_no = gr.student_no WHERE gr.`student_no` = '$student_no' 
			GROUP BY gr.`year_level`,gr.`semester`,gr.`section`";
			$gwaList = []; 
			$fetch	=	$this->ExecQuery('', 'tbl_grades', $query, '');
			
			$ifZeroGwa = 0;
			if ($fetch->num_rows() > 0) {  
				$fetch    =   $fetch->result_array();
				foreach ($fetch as $key => $aValue) { 
					$gwa = $this->getGradePerCourse($student_no,
					$aValue["course"],
					$aValue["year_level"],
					$aValue["semester"] )[0];
					if(!$gwa){
						$ifZeroGwa = 1;
					}else{ 
						array_push($gwaList,$gwa);
					}
				}
				echo $student_no."==".json_encode($gwaList)."<br>"
				return $ifZeroGwa == 1 ? 0 : $ifZeroGwa.array_sum($gwaList)/sizeof($gwaList);
			} else {
				return 0;
			} 
		}
	}


	function gradeRangePoint($fGrade) {
		if ($fGrade != "") {
			if ($fGrade == "inc") {
				return ['-', '-', 'INC'];
			} else if ($fGrade > 96 && $fGrade <= 100) {
				return ['97-100', '1.0', 'PASSED'];
			} else if ($fGrade > 93 && $fGrade <= 96) {
				return ['92-96', '1.25', 'PASSED'];
			} else if ($fGrade > 90 && $fGrade <= 93) {
				return ['91-93', '1.5', 'PASSED'];
			} else if ($fGrade > 87 && $fGrade <= 90) {
				return ['88-90', '1.75', 'PASSED'];
			} else if ($fGrade > 84 && $fGrade <= 87) {
				return ['85-87', '2.0', 'PASSED'];
			} else if ($fGrade > 81 && $fGrade <= 84) {
				return ['82-84', '2.25', 'PASSED'];
			} else if ($fGrade > 78 && $fGrade <= 81) {
				return ['79-81', '2.5', 'PASSED'];
			} else if ($fGrade > 75 && $fGrade <= 78) {
				return ['76-78', '2.75', 'PASSED'];
			} else if ($fGrade > 72 && $fGrade <= 75) {
				return ['73-75', '3.0', 'PASSED'];
			} else if ($fGrade <= 72) {
				return ['<= 72', '5.0', 'FAILED'];
			} else {
				return ['-', '-', '-'];
			}
		} else {
			return ['-', '-', '-'];
		}
	
	}

?>