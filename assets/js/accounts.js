$(function()
{
	_fetchUser();
	$("button").on('click', function (e) {
		e.preventDefault();


		var sAction =	$(this).attr("data-action");
		var sForm 	=	$(this).closest('form');

		switch(sAction) {

			case 'new-user':
				$("input").val('');
				$("select").val('');
				$(".modal-title span").html("New");
				
				$("[data-action=update-user]").hide();
				$("[data-action=activate-user]").hide();
				$("[data-action=remove-user]").hide();
				$("[data-action=save-user]").show();

				$("#modalNewAccnt").modal('show');
			break;

			case 'save-user':

				_saveUser(sForm, $(this));

			break;

			case 'update-user':

				_updateUser(sForm, $(this));

			break;

			case 'activate-user':

				_actremUser('activate-user');

			break;

			case 'remove-user':

				_actremUser('remove-user');

			break;

		}

	});

	
});

function _saveUser(sForm, sButton)   {
	var sCheckForm 	=	_checkFormFields(sForm);
	if (sCheckForm == false) {
		toastr.error('Please complete the required fields.');
	} else {
		var sData 		=	_collectFields(sForm);
		var jsonData 	=	{'data' : sData};

		if ($("[data-key=UserPword]").val() != $("[data-key=UserCword]").val()) {

			toastr.error('Passwords did not matched.');

		} else {
			ajaxQuery('save-user', jsonData, sButton);
		}
	}
}

function _updateUser(sForm, sButton)   {
	var sCheckForm 	=	_checkFormFields(sForm);
	if (sCheckForm == false) {
		toastr.error('Please complete the required fields.');
	} else {
		var sData 		=	_collectFields(sForm);
		var jsonData 	=	{'data' : sData, 'uid' : $("[data-key=UniqueId]").val() };

		if ($("[data-key=UserPword]").val() != $("[data-key=UserCword]").val()) {

			toastr.error('Passwords did not matched.');

		} else {
			ajaxQuery('update-user', jsonData, sButton);
		}
	}
}

function _fetchUser()   {

	ajaxQuery('fetch-user', '', '');
}

function _editUser(nId)   {

	ajaxQuery('edit-user', {'data' : nId}, '');
}

function _actremUser(sAction){

	var jsonData 	=	{'uid' : $("[data-key=UniqueId]").val() , 'action' : sAction};

	ajaxQuery('actrem-user', jsonData, '');
}

function _exec() {
	$(".fa-btn").on('click', function (e) {

		e.preventDefault();

		var sAction =	$(this).attr("data-action");
		var vId 	=	$(this).attr('data-value');

		switch(sAction) {

			case 'edit-user':
				_editUser(vId);
			break;

			case 'delete-user':

				_saveUser(sForm, $(this));

			break;

		}

	});
}