<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Modules/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['logout'] 		= 'Modules/logout';
$route['accounts']		= 'Modules/accounts';
$route['dashboard']		= 'Modules/dashboard';
$route['comscie']		= 'Modules/comscie';
$route['dashboard-students']		= 'Modules/dashboardStudents';
$route['dashboard-subjects']		= 'Modules/dashboardSubjects'; 
$route['it']		    = 'Modules/it';
$route['grade-entry']	= 'Modules/grade_entry';
$route['performer']		= 'Modules/performer';
$route['failed']	    = 'Modules/failed';
$route['incomplete']    = 'Modules/incomplete';
$route['dropped']       = 'Modules/dropped';
$route['students']      = 'Modules/students';


$route['save-user'] 	= 'Accounts/save_user';
$route['fetch-user'] 	= 'Accounts/fetch_user';
$route['edit-user'] 	= 'Accounts/edit_user';
$route['update-user'] 	= 'Accounts/update_user';
$route['actrem-user'] 	= 'Accounts/actrem_user';


$route['check-login'] 	= 'Login/check_login';
$route['upload-photo'] 	= 'Login/upload_photo';
$route['upload-image'] 	= 'Login/upload_image';

$route['portal_one'] 	= 'Login/portal_one';
$route['portal_two'] 	= 'Login/portal_two';

$route['fetch-students']	= 'Students/fetch_students';
$route['fetch-students-dashboard']	= 'Students/fetch_students_dashboard';
$route['fetch-subjects-dashboard']	= 'Students/fetch_subjects_dashboard';
$route['student_analytics']	= 'Students/getStudentAnalytics';
$route['subject_analytics']	= 'Students/getSubjectAnalytics';


$route['save-student']		= 'Students/save_student';
$route['add-yrsem']		= 'Students/add_yrser';
$route['edit-student']		= 'Students/edit_student';
$route['update-student']	= 'Students/update_student';
$route['delete-student']	= 'Students/delete_student';
$route['extract-students']	= 'Students/extract_students';

$route['save-grades']		= 'Grades/save_grades';
$route['print-grades']		= 'Grades/print_grades';

$route['print-classifications']		= 'Classifications/print';
$route['send-notif']		= 'Classifications/send';

$route['generateqr']	= 'Generateqr';

