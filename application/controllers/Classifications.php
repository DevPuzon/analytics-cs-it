<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Classifications extends CI_Controller {

		private $aHtml = array();

	    public function __construct() {
	        parent::__construct();
	        $this->load->library('generateqr');
	    }

		public function print() {

	    	$sType 	=	$this->input->post('type');
            $sYear 	=	$this->input->post('year');
            $sSem 	=	$this->input->post('sem');
            $sCourse=	$this->input->post('course');
			$sSection=	$this->input->post('section');

            // print_r($this->earistlib->GenClassifications($sType, $sYear, $sSem, $sCourse));
	    	echo "window.open('".$this->earistlib->GenClassifications($sType, $sYear, $sSem, $sCourse, $sSection)."')";
	    }

        public function send() {

	    	$sType 	=	$this->input->post('type');
            $sYear 	=	$this->input->post('year');
            $sSem 	=	$this->input->post('sem');
            $sCourse=	$this->input->post('course');
			$sSection=	$this->input->post('section');

            print_r($this->earistlib->sendEmail($sType, $sYear, $sSem, $sCourse, $sSection));
	    	// echo "window.open('".$this->earistlib->GenClassifications($sType, $sYear, $sSem, $sCourse)."')";
	    }

	}

?>