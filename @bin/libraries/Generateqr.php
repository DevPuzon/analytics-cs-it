<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

		include APPPATH .'third_party/phpqrcode/qrlib.php';
		class Generateqr {	
			
			public function __construct() {
				
		    } 

		    public function generate_qrcode($sCode)
		    {
				$path 		= 'qrcodes/'; 
				$sFileName 	= $sCode."_qrcode.png";	

				$file = $path.$sFileName; 
				  
				// $ecc stores error correction capability('L') 
				$ecc = 'L'; 
				$pixel_Size = 10; 
				$frame_Size = 10; 
				  
				// Generates QR Code and Stores it in directory given 
				QRcode::png($sCode, $file, $ecc, $pixel_Size, 0); 

				return $sFileName;
		    }

		    public function generate_qrlink($sLink)
		    {
				$path 		= 'qrcodes/'; 
				$sFileName 	= "link_qrcode_".date("YmdHisu").".png";	

				$file = $path.$sFileName; 
				  
				// $ecc stores error correction capability('L') 
				$ecc = 'L'; 
				$pixel_Size = 10; 
				$frame_Size = 10; 
				  
				// Generates QR Code and Stores it in directory given 
				QRcode::png($sLink, $file, $ecc, $pixel_Size, 0); 

				return $sFileName;
		    }
		}

?>

