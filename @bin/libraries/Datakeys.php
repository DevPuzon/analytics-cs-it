<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Datakeys {

		private $aDatakeys 	= array(
			"UniqueId" 		=> 'id',
			"UserTitle" 	=> 'Title',
		    "UserFname" 	=> 'Firstname',
		    "UserLname" 	=> 'Surname',
		    "UserUname" 	=> 'Username',
		    "UserPword" 	=> 'Password',
			"UserEmail" 	=> 'EmailAddress',
		    "UserStatus" 	=> 'Status',
		    "UserLevel" 	=> 'AccessType',

			"StudentNo"		=> 'student_no',
			"StudentId"		=> 'student_id',
			"FirstName"		=> 'first_name',
			"MiddleName"	=> 'middle_name',
			"LastName"		=> 'last_name',
			"AcademicYear"		=> 'academic_year',
			"YearLevel"		=> 'year_level',
			"Semester"		=> 'semester',
			"Section" 		=> 'section',
			"Course" 		=> 'course',
			"Email" 		=> 'email',
			"Status" 		=> 'status',

			"EntryBy"		=> 'entryby',
			"EntryDate" 	=> 'entrydate',
			"ModifiedBy"	=> 'modifiedby',
			"ModifiedDate"	=> 'modifieddate',
			"DeletedBy"		=> 'deletedby',
			"DeletedDate"	=> 'deleteddate',		    
		);

		public function getKey($sDataKey) {

			return $this->aDatakeys[$sDataKey];
		}

		public function getValue($sValue) {

			return array_search($sValue, $this->aDatakeys);
		}
	}

?>