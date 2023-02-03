<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


define('ACCESSTYPE', array('student' => 'Student', 'prof' => 'Professor', '2' => 'Administrator'));

define('REMOTEURL', 'http://192.168.0.100:8080/');

define('YEARLEVEL', [
    '1st_year' => 'First Year',
    '2nd_year' => 'Second Year',
    '3rd_year' => 'Third Year',
    '4th_year' => 'Fourth Year',
]);

define('YEARLEVELTXT', [
    '1st_year' => 'year_one',
    '2nd_year' => 'year_two',
    '3rd_year' => 'year_three',
    '4th_year' => 'year_four',
]);

define('STUDENTSTAT', [
    'reg' => 'Regular',
    'irr' => 'Irregular',
    'drp' => 'Dropped',
]);

/*Subjects*/
define('SUBJECTS', [
    'cs' => [
        '1st_year' => [
            'sem_one' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEMATHMW' => ['Mathematics in the Modern World', '3', '', '3', '', '3'],
                'GESCIETS' => ['Science, Technology & Society', '3', '', '3', '', '3'],
                'GELIFEWR' => ['The Life and Works of Rizal', '3', '', '3', '', '3'],
                'GEARTAPP' => ['Art Appreciation', '3', '', '3', '', '3'],
                'GEKOMFIL' => ['Kontekstwalisadong Komunikasyon sa Filipino', '3', '', '3', '', '3'],
                'NTROCOMP' => ['Introduction to Computing', '3', '', '3', '', '3'],
                'FPROGLEC' => ['Computer Programming 1 (Fundamentals of Programming) (Lecture)', '2', '', '2', '', '2'],
                'FPROGLAB' => ['Computer Programming 1 (Fundamentals of Programming) (Laboratory)', '', '3', '1', '1', '1'],
                'GEPEMOVE' => ['Movement Enhancement', '2', '', '2', '', '2'],
                'NSTPROG1' => ['National Service Training Program 1', '3', '', '3', '','3'],
            ],
            'sem_two' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEFILDIS' => ["Filipino sa Iba't-Ibang Disiplina", '3', '', '3', '', '3'],
                'GEPANIPI' => ['Panitikan sa Pilipinas / Philippine Literature', '3', '', '3', '', '3'],
                'GEPURPCO' => ['Purposive Communication', '3', '', '3', '', '3'],
                'IPROGLEC' => ['Computer Programming 2 (Intermediate Programming) (Lecture)', '2', '', '2', '', '2'],
                'IPROGLAB' => ['Computer Programming 2 (Intermediate Programming) (Laboratory)', '', '3', '', '1', '1'],
                'DISSTRU1' => ['Discrete Structure 1', '3', '', '3', '', '3'],
                'DBMGTLEC' => ['Database Management System (Lecture)', '2', '', '2', '', '2'],
                'DBMGTLAB' => ['Database Management System (Laboratory)', '', '3', '', '1', '1'],
                'GEPEFITE' => ['Fitness Exercise', '2', '', '2', '', '2'],
                'NSTPROG2' => ['National Service Training Program 2', '3', '', '3', '','3'],
            ]
        ],

        '2nd_year' => [
            'sem_one' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEELECCP' => ['Communicative Proficiency in Business Correspondence and Research Writing', '3', '', '3', '', '3'],
                'DISSTRU2' => ['Discrete Structure 2', '3', '', '3', '', '3'],
                'OOPRGLEC' => ['Object Oriented Programming (Lecture)', '2', '', '2', '', '2'],
                'OOPRGLAB' => ['Object Oriented Programming (Laboratory)', '', '3', '3', '1', '1'],
                'DIGDELEC' => ['Digital Logic Design (Lecture)', '2', '', '2', '', '2'],
                'DIGDELAB' => ['Digital Logic Design (Laboratory)', '', '3', '3', '1', '1'],
                'DSALGLEC' => ['Data Structures and Algorithm (Lecture)', '2', '', '2', '', '2'],
                'DSALGLAB' => ['Data Structures and Algorithm (Laboratory)', '', '3', '3', '1', '1'],
                'PHYCSLEC' => ['Physics for Computer Scientists (Lecture)', '2', '', '2', '', '2'],
                'PHYCSLAB' => ['Physics for Computer Scientists (Laboratory)', '', '3', '3', '1','1'],
                'GEPEHEF1' => ['Physical Activity Towards Health and Fitness 1', '2', '', '2', '', '2'],
            ],
            'sem_two' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'MICROBOT' => ["Microprocessor & Intro. To Robotics", '', '3', '', '1', '1'],
                'NETCOMMS' => ['Networks and Communications', '2', '3', '2', '1', '3'],
                'INFOMGMT' => ['Information Management', '2', '3', '2', '1', '3'],
                'PROGLLEC' => ['Programming Language (Lecture)', '2', '', '2', '', '2'],
                'PROGLLAB' => ['Programming Language (Laboratory)', '', '3', '', '1', '1'],
                'GPXVCLEC' => ['CS Elective 1 (Graphics and Visual Computing) (Lecture)', '2', '', '2', '', '2'],
                'GPXVCLAB' => ['CS Elective 1 (Graphics and Visual Computing) (Laboratory)', '', '3', '', '1', '1'],
                'CALCULUS' => ['Calculus for CS Students', '3', '', '3', '', '3'],
                'GEPEHEF2' => ['Physical Activity Towards Health and Fitness 2', '2', '', '2', '', '2'],
            ]
        ],

        '3rd_year' => [
            'sem_one' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'APDEVLEC' => ['Application Development and Emerging Technology (Lecture)', '2', '', '2', '', '2'],
                'APDEVLAB' => ['Application Development and Emerging Technology (Laboratory)', '', '3', '3', '1', '1'],
                'ALGCMPLX' => ['Algorithm and Complexity', '3', '', '3', '', '3'],
                'SOFTENG1' => ['Software Engineering 1', '2', '3', '2', '1', '3'],
                'ARCHIORG' => ['Architecture and Organization', '3', '', '3', '', '3'],
                'HUCOMINT' => ['Human Computer Interaction', '1', '', '1', '', '1'],
                'OPERSYST' => ['Operating System', '2', '3', '2', '1', '3'],
                'INTELSYS' => ['CS Elective 2 (Intelligent Systems)', '3', '', '3', '', '3'],
            ],
            'sem_two' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEELECDS' => ["Practical Data Science", '3', '', '3', '', '3'],
                'SOFTENG2' => ['Software Engineering 2 (Lecture)', '2', '', '2', '', '2'],
                'SOFENGLA' => ['Software Engineering 2 (Laboratory)', '', '3', '', '1', '1'],
                'MOSIMLEC' => ['Modeling and Simulation (Lecture)', '2', '', '2', '', '2'],
                'MOSIMLAB' => ['Modeling and Simulation (Laboratory)', '', '3', '', '1', '1'],
                'CSTHESI1' => ['Thesis 1', '3', '', '3', '', '3'],
                'MOBAPLEC' => ['Mobile Application Development (iOS & Android) (Lecture)', '2', '', '2', '', '2'],
                'MOBAPLAB' => ['Mobile Application Development (iOS & Android) (Laboratory)', '', '3', '', '1', '1'],
                'PARACOMP' => ['CS Elective 3 (Parallel and Distributed Computing)', '3', '', '3', '', '3'],
            ]
        ],

        '4th_year' => [
            'sem_one' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEUNDETS' => ['Understanding the Self', '3', '', '3', '', '3'],
                'GECONTWO' => ['The Contemporary World', '3', '', '3', '', '3'],
                'GEELECES' => ['Environmental Science', '3', '', '3', '', '3'],
                'INFOASEC' => ['Information Assurance and Security', '2', '', '2', '', '2'],
                'AUTOMATA' => ['Automata Theory and Formal Language', '3', '', '3', '', '3'],
                'SSUPPRAC' => ['Social and Professional Issues', '3', '', '3', '3', '3'],
                'CSTHESI2' => ['Thesis 2 (Lecture)', '2', '', '2', '', '2'],
                'CSTHESL2' => ['Thesis 2 (Laboratory)', '', '3', '1', '', '1'],
            ],
            'sem_two' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEETHICS' => ["Ethics", '3', '', '3', '', '3'],
                'GEREADPH' => ['Readings in Philippine History', '3', '', '3', '', '3'],
                'INDOBSFT' => ['Industry Observation & Field Trips', '3', '', '3', '', '3'],
                'CSINTERN' => ['"Practicum / Internship"', '6', '', '6', '', '6'],
            ]
        ]
    ],
    'it' => [
        '1st_year' => [
            'sem_one' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEARTAPP' => ['Art  Appreciation', '', '', '3', '0', '3'],
                'FPROGLAB' => ['Computer Programming 1 (Fundamentals of Programming) (Laboratory)', '', '', '3', '3', '3'],
                'FPROGLEC' => ['Computer Programming 1 (Fundamentals of Programming) (Lecture)', '', '', '2', '0', '2'],
                'INTCOMLB' => ['Introduction to Computing (Laboratory)', '', '', '3', '3', '3'],
                'INTCOMLC' => ['Introduction to Computing (Lecture)', '', '', '2', '0', '2'],
                'GEKOMFIL' => ['Kontekstwalisadong Komunikasyon sa Filipino', '', '', '3', '0', '3'],
                'GEPEMOVE' => ['Movement Enhancement', '', '', '2', '0', '2'],
                'NSTPROG1' => ['National Service Training Program 1', '', '', '3', '','3'],
                'GEPURPCO' => ['Purposive Communication', '', '', '3', '0', '3'],
                'GEREADPH' => ['Readings in Philippine History', '', '', '3', '0', '3'],
                'GEUNDETS' => ['Understanding the Self', '', '', '3', '0', '3'],                
            ],
            'sem_two' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEFILDIS' => ["Filipino sa Iba't-Ibang Disiplina", '3', '', '3', '', '3'],
                'GEPANIPI' => ['Panitikan sa Pilipinas / Philippine Literature', '3', '', '3', '', '3'],
                'GEPURPCO' => ['Purposive Communication', '3', '', '3', '', '3'],
                'IPROGLEC' => ['Computer Programming 2 (Intermediate Programming) (Lecture)', '2', '', '2', '', '2'],
                'IPROGLAB' => ['Computer Programming 2 (Intermediate Programming) (Laboratory)', '', '3', '', '1', '1'],
                'DISSTRU1' => ['Discrete Structure 1', '3', '', '3', '', '3'],
                'DBMGTLEC' => ['Database Management System (Lecture)', '2', '', '2', '', '2'],
                'DBMGTLAB' => ['Database Management System (Laboratory)', '', '3', '', '1', '1'],
                'GEPEFITE' => ['Fitness Exercise', '2', '', '2', '', '2'],
                'NSTPROG2' => ['National Service Training Program 2', '3', '', '3', '','3'],
            ]
        ],

        '2nd_year' => [
            'sem_one' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'BUSANALY' => ['Business Analytics', '', '', '3', '0', '3'],
                'DSALGLAB' => ['Data Structures & Algorithm (Lab)2', '', '', '0', '3', '1'],
                'DSALGLEC' => ['Data Structures & Algorithm (Lec)', '', '', '2', '0', '2'],
                'GEETHICS' => ['Ethic', '', '', '3', '0', '3'],
                'INFMGTLB' => ['Information Management (Lab)', '', '', '3', '', '1'],
                'INFMGTLC' => ['Information Management (Lec)', '', '', '2', '0', '2'],
                'GEPEHEF1' => ['Physical Activity Towards Health & Fitness 1', '', '', '2', '0', '2'],
                'PTECHLAB' => ['Platform Technologies (Lab)', '', '', '0', '3', '1'],
                'PTECHLEC' => ['Platform Technologies (Lec)', '', '', '2', '0', '2'],
                'WEBDVLB1' => ['Web Development 1 (Lab)', '', '', '0', '3','1'],
                'WEBDVLC1' => ['Web Development 1 (Lec)', '', '', '2', '0', '2'],
            ],
            'sem_two' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'MICROBOT' => ["Microprocessor & Intro. To Robotics", '', '3', '', '1', '1'],
                'NETCOMMS' => ['Networks and Communications', '2', '3', '2', '1', '3'],
                'INFOMGMT' => ['Information Management', '2', '3', '2', '1', '3'],
                'PROGLLEC' => ['Programming Language (Lecture)', '2', '', '2', '', '2'],
                'PROGLLAB' => ['Programming Language (Laboratory)', '', '3', '', '1', '1'],
                'GPXVCLEC' => ['CS Elective 1 (Graphics and Visual Computing) (Lecture)', '2', '', '2', '', '2'],
                'GPXVCLAB' => ['CS Elective 1 (Graphics and Visual Computing) (Laboratory)', '', '3', '', '1', '1'],
                'CALCULUS' => ['Calculus for CS Students', '3', '', '3', '', '3'],
                'GEPEHEF2' => ['Physical Activity Towards Health and Fitness 2', '2', '', '2', '', '2'],
            ]
        ],

        '3rd_year' => [
            'sem_one' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'APDEVLAB' => ['Application Development & Emerging Technology (Lab)', '', '', '0', '3', '1'],
                'APDEVLAB' => ['Application Development & Emerging Technology (Lec)', '', '', '2', '0', '2'],
                'IAASLAB1' => ['Information Assurance and Security 1 (Lab)', '', '', '0', '3', '1'],
                'IAASLEC1' => ['Information Assurance and Security 1 (Lec)', '', '', '2', '0', '2'],
                'IPATLAB1' => ['Integrative Programming & Technologies 1 (Lab)', '', '', '2', '3', '2'],
                'IPATLEC1' => ['Integrative Programming & Technologies 1 (Lec)', '', '', '0', '0', '1'],
                'MMDIALAB' => ['Multimedia (Lab)', '', '', '0', '2', '2'],
                'MMDIALEC' => ['Multimedia (Lec)', '', '', '1', '0', '1'],
                'GEELECDS' => ['Practical Data Science', '', '', '3', '0', '3'],
                'WEBDVLB3' => ['Wed Development 3 (Lab)', '', '', '0', '3', '1'],
                'WEBDVLC3' => ['Wed Development 3 (Lec)', '', '', '2', '0', '2'],
            ],
            'sem_two' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEELECDS' => ["Practical Data Science", '3', '', '3', '', '3'],
                'SOFTENG2' => ['Software Engineering 2 (Lecture)', '2', '', '2', '', '2'],
                'SOFENGLA' => ['Software Engineering 2 (Laboratory)', '', '3', '', '1', '1'],
                'MOSIMLEC' => ['Modeling and Simulation (Lecture)', '2', '', '2', '', '2'],
                'MOSIMLAB' => ['Modeling and Simulation (Laboratory)', '', '3', '', '1', '1'],
                'CSTHESI1' => ['Thesis 1', '3', '', '3', '', '3'],
                'MOBAPLEC' => ['Mobile Application Development (iOS & Android) (Lecture)', '2', '', '2', '', '2'],
                'MOBAPLAB' => ['Mobile Application Development (iOS & Android) (Laboratory)', '', '3', '', '1', '1'],
                'PARACOMP' => ['CS Elective 3 (Parallel and Distributed Computing)', '3', '', '3', '', '3'],
            ]
        ],

        '4th_year' => [
            'sem_one' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'ITTHESL2' => ['Capstone Projects and Research 2 (Lab)', '', '', '0', '3', '1'],
                'ITTHESL2' => ['Capstone Projects and Research 2 (Lec)', '', '', '2', '0', '2'],
                'GEFILDIS' => ["Filipino sa Iba't-ibang Disiplina", '', '', '3', '0', '3'],
                'QUANMETH' => ['Quantitative Methods (including Modeling and Simulation', '', '', '3', '0', '3'],
                'SPISSUES' => ['Social and Professional Issues', '', '', '3', '0', '3'],
                'SYSADMLB' => ['Systems Administration and Maintenance (Lab)', '', '', '0', '3', '1'],
                'SYSADMLC' => ['Systems Administration and Maintenance (Lec)', '', '', '2', '0', '2'],
                'SYSARLB2' => ['Systems Integration and Architecture 2 (Lab)', '', '', '0', '3', '1'],
                'SYSARCH' => ['Systems Integration and Architecture 2 (Lec)', '', '', '2', '0', '2'],
            ],
            'sem_two' => [
                //subject, hrs lec, hrs lab, units lec, units lab, total units, 
                'GEETHICS' => ["Ethics", '3', '', '3', '', '3'],
                'GEREADPH' => ['Readings in Philippine History', '3', '', '3', '', '3'],
                'INDOBSFT' => ['Industry Observation & Field Trips', '3', '', '3', '', '3'],
                'CSINTERN' => ['"Practicum / Internship"', '6', '', '6', '', '6'],
            ]
        ]
    ]
]);