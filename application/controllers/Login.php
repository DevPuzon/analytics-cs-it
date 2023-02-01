<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $aHtml = array();

    public function __construct() {
        parent::__construct();

		$this->load->library('generateqr');
    }

    public function check_login()
	{
		$sUsername 	=	$this->input->post('uname');
		$sPassword 	=	$this->input->post('pword');

		$aData 		=	array('UserUname' => $sUsername);

		$eCheck	=	$this->earistlib->ExecQuery($aData, 'tblkp_users', 'search', array("UserUname" => $aData['UserUname']));

		if ($eCheck->num_rows() > 0) {
			$aChecks = $eCheck->result_array();

			if ($aChecks[0]['Password'] == md5($sPassword)) {
				if ($aChecks[0]['AccessType'] != "student") {
					$this->session->set_userdata('uname', $sUsername);

					echo "window.location='".base_url()."';";
				} else {
					echo "toastr.error('Invalid username or password!');";
				}
			} else {
				echo "toastr.error('Invalid username or password!');";
			}

		} else {
			echo "toastr.error('Invalid username or password!');";
		}

	}

	public function upload_photo() {

		$sFileName 	=	date("Ymdhisu")."_Image.png";
		$sBlob = file_get_contents($_FILES['PersonelPhoto']['tmp_name']);

		file_put_contents("personel_photos/".$sFileName, $sBlob);

		$sReturn =	"
						$('.div-photo').css({'background-image': 'url(\'personel_photos/".$sFileName."\')'});
						$('#modalUpload').modal('hide');
						$('[data-key=PersonPhoto]').val('".$sFileName."');
					";
		echo $sReturn;
	}

	public function upload_image() {

		$sFileName 	=	date("Ymdhisu")."_Image.png";
		$aPhotoFile = $_FILES['photo'];

		
        $_FILES['upFile']['name']      = $aPhotoFile['name'];
        $_FILES['upFile']['type']      = $aPhotoFile['type'];
        $_FILES['upFile']['tmp_name']  = $aPhotoFile['tmp_name'];
        $_FILES['upFile']['error']     = $aPhotoFile['error'];
        $_FILES['upFile']['size']      = $aPhotoFile['size'];
        
        $sFileName      =   $aPhotoFile['name'];
        $aFileName      =   explode(".", $sFileName);

        $sNewFileName   =   date("Ymdhisu")."_Photo.png";
        
        $sResult =  json_decode($this->earistlib->Upload($sNewFileName, 'personel_photos'));
        
        if($sResult->return == true) {

            $sPhotoFileName     =   $sResult->filename;

            $sReturn =	"
						$('.img-upload').css({'background-image': 'url(\'personel_photos/".$sPhotoFileName."\')'});
						$('[data-key=PersonPhoto]').val('".$sPhotoFileName."');
					";
			echo $sReturn;

        } else {

            $sReturn =	"
            				toastr.error('Failed to upload photo!');
            			";
			echo $sReturn;

        }
	}

	public function portal_one() {

		$sQrCode =	$this->generateqr->generate_qrlink(REMOTEURL."registration");

		echo "
				<div style='height: 100%; width: 100%; overflow:hidden; '>

					<div style='width: 300px; margin: 0 auto; top: 15%; position: relative; text-align:center;'>
						<img src='assets/images/earist-logo-circle.png' style='margin-bottom: 25px;'>
						<h3>Scan to Register</h3>
						<img src='qrcodes/".$sQrCode."'>
					</div>
				</div>
			";
			
	}

	public function portal_two() {

		$sQrCode =	$this->generateqr->generate_qrlink(REMOTEURL."/registration_two");

		echo "
				<div style='height: 100%; width: 100%; overflow:hidden; '>

					<div style='width: 300px; margin: 0 auto; top: 15%; position: relative; text-align:center;'>
						<img src='assets/images/earist-logo-circle.png' style='margin-bottom: 25px;'>
						<h3>Scan to Register</h3>
						<img src='qrcodes/".$sQrCode."'>
					</div>
				</div>
			";
			
	}
}
