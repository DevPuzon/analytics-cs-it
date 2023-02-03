<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

	private $aHtml = array();

    public function __construct() {
        parent::__construct();
    }

	public function save_user()
	{
		$aData =	$this->earistlib->JsonToArray(json_decode($this->input->post('data')));
		$aData['UserStatus'] =	'active';
		$aData['UserPword'] =	md5($aData['UserPword']);
		unset($aData['UserCword']);

		$eCheck	=	$this->earistlib->ExecQuery($aData, 'tblkp_users', 'search', array("UserUname" => $aData['UserUname']));

		if ($eCheck->num_rows() > 0) {

			echo "toastr.error('Username aleady exists.');";

		} else {

			if ($this->earistlib->ExecQuery($aData, 'tblkp_users', 'save', '') == true) {

				echo "
						$('input').val('');
						$('select').val('');
						toastr.success('User successfully added.');
						_fetchUser();
					";
			} else {
				echo "toastr.error('Failed to add user.');";
			}

		}
	}

	public function fetch_user() {

		$eFetchUsers	=	$this->earistlib->ExecQuery('', 'tblkp_users', 'fetch', '');
		$sHtml 			=	"<table class='table table-hover table-striped tbl-data'>
								<thead>
									<tr>
										<th> First Name </th>
										<th> Last Name </th>
										<th> Username </th>
										<th> Access Level </th>
										<th> Status </th>
										<th> Last Login </th>
										<th> Action </th>
									</tr>
								</thead>
								<tbody>
							";
		if ($eFetchUsers->num_rows() > 0) {
			$aUsers    =   $eFetchUsers->result_array();
			foreach ($aUsers as $key => $aValue) {
				if ($aValue['Status'] != "removed") {
					$sHtml  .= "<tr>
								<td> ".ucfirst(strtolower($aValue['Firstname']))." </td>
								<td> ".ucfirst(strtolower($aValue['Surname']))." </td>
								<td> ".$aValue['Username']." </td>
								<td> ".ACCESSTYPE[$aValue['AccessType']]." </td>
								<td> ".ucfirst(strtolower($aValue['Status']))." </td>
								<td> ".($aValue['LastLogin'] == null ? "-" : date("F d, Y", strtotime($aValue['LastLogin'])))." </td>
								<td> 
									<i class ='fa fa-edit text-green fa-btn' data-value='".$aValue['id']."' data-action='edit-user'></i> &nbsp;
									
								</td>
							</tr>";
							// <i class ='fa fa-trash text-red fa-btn' data-value='".$aValue['id']."' data-action='delete-user'></i> 
				}
			}
		} else {
			$sHtml 		.= "<tr>
								<td colspan='7'> No record found</td>
							</tr>";
		}

		$sHtml 		.= "</tbody></table>";

		echo "
				$('#divData').html(\"".trim(preg_replace('/\s\s+/', '', $sHtml))."\");
				$('.tbl-data').DataTable({
			      'paging': true,
			      'lengthChange': true,
			      'searching': true,
			      'ordering': true,
			      'info' : true,
			      'autoWidth': false,
			    });
			    _exec();
			";

	}
	
	public function edit_user() {
		$nId 		=	$this->input->post('data');
		$eUserInfo	=	$this->earistlib->ExecQuery('', 'tblkp_users', 'search', array("UniqueId" => $nId));
		$aUserInfo  =	$eUserInfo->result_array();
		
		$sScript 	=	"";
		foreach ($aUserInfo[0] as $sColKey => $sValue) {
			if ($this->datakeys->getValue($sColKey) != '') {
				if ($this->datakeys->getValue($sColKey) == "UserPword") {
					$sScript .= "$('[data-key=".$this->datakeys->getValue($sColKey)."]').val('".$sValue."');";
					$sScript .= "$('[data-key=UserCword').val('".$sValue."');";
				} else {
					$sScript .= "$('[data-key=".$this->datakeys->getValue($sColKey)."]').val('".$sValue."');";
				}
			}
		}

		$sStatus 	=	$aUserInfo[0]['Status'];
		$sColor 	=	$sStatus == "active" ? "text-green" : "text-red";
		$sReset 	=	$sStatus == "active" ? "disabled" : "";

		$sScript .= "
						
						$('[data-key=UserUname]').attr('disabled', true);
						$('[data-action=update-user]').show();
						$('[data-action=activate-user]').show();
						$('[data-action=remove-user]').show();
						$('[data-action=save-user]').hide();

						$('[data-action=activate-user]').addClass(' ".$sReset." ');

						$('.modal-title span').html('Update (<font class=\'".$sColor."\'>".ucfirst(strtolower($sStatus))."</font>)');
						$('#modalNewAccnt').modal('show');
		";

		echo $sScript;
	}

	public function update_user()
	{
		$nUid 	=	$this->input->post('uid');
		$aData 	=	$this->earistlib->JsonToArray(json_decode($this->input->post('data')));
		$aData['UserStatus'] =	'active';
		unset($aData['UserCword']);

		if ($this->earistlib->ExecQuery($aData, 'tblkp_users', 'update', array('UniqueId' => $nUid)) == true) {

			echo "
					$('input').val('');
					$('select').val('');
					toastr.success('User successfully updated.');
					$('#modalNewAccnt').modal('hide');

					_fetchUser();
				";
		} else {
			echo "toastr.error('Failed to update user.');";
		}

	}

	public function actrem_user()
	{
		$nUid 		=	$this->input->post('uid');
		$sStatus 	=	strtolower($this->input->post('action')) == "activate-user" ? "active" : "removed";
		$sMessage 	=	strtolower($this->input->post('action')) == "activate-user" ? "activated" : "removed";

		$aData 		=	array("UserStatus" => $sStatus);

		if ($this->earistlib->ExecQuery($aData, 'tblkp_users', 'update', array('UniqueId' => $nUid)) == true) {

			echo "
					$('input').val('');
					$('select').val('');
					toastr.success('User successfully ".$sMessage.".');
					$('#modalNewAccnt').modal('hide');

					_fetchUser();
				";
		} else {
			echo "toastr.error('Failed to update user.');";
		}

	}
}
