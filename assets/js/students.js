var sTabledata = "";
$(document).ready(function() {
	_fetchStudents();
	$("button").on('click', function (e) {
		
		e.preventDefault();

		var sAction =	$(this).attr("data-trigger");
		var sForm 	=	$(this).closest('form');
		switch(sAction) {

			case 'add-comscie':
				_clearFields();
				$(".modal-title span").html("New");
				$("#modalNewStudent").modal('show');
			break;

			case 'add-it':
				_clearFields();
				$(".modal-title span").html("New");
				$("#modalNewStudent").modal('show');
			break;
			
			case 'save-cs':
				var sCheckForm 	=	_checkFormFields(sForm);

				if (sCheckForm == false) {
					
					toastr.error('Please complete the required fields.');

				} else {
					if ($("[data-key=UniqueId]").val() == "") {
						var sData 		=	_collectFields(sForm);
						var jsonData 	=	{'data' : sData, 'course' : 'cs'};
						ajaxQuery('save-student', jsonData, $(this));
					} else {
						var sData 		=	_collectFields(sForm);
						var jsonData 	=	{'data' : sData, 'id' : $("[data-key=UniqueId]").val()};
						
						ajaxQuery('update-student', jsonData, $(this));
					}
				}

			break;


			case 'save-it':
				var sCheckForm 	=	_checkFormFields(sForm);

				if (sCheckForm == false) {
					
					toastr.error('Please complete the required fields.');

				} else {
					if ($("[data-key=UniqueId]").val() == "") {
						var sData 		=	_collectFields(sForm);
						var jsonData 	=	{'data' : sData, 'course' : 'it'};
						ajaxQuery('save-student', jsonData, $(this));
					} else {
						var sData 		=	_collectFields(sForm);
						var jsonData 	=	{'data' : sData, 'id' : $("[data-key=UniqueId]").val()};
						
						ajaxQuery('update-student', jsonData, $(this));
					}
				}
			

			break;

			case 'print-cs':
				var order = sTabledata.order();
				var jsonData 	=	{'course' : 'cs', 'year_level': $("#selYear").val(), 'semester': $("#selSem").val(), 'status' : $("#selStatus").val(), 'section': $("#selSection").val(), 'sortid' : order[0][0], 'sorttype': order[0][1] };
				
				ajaxQuery('extract-students', jsonData, $(this));
			break;

			case 'print-it':
				var order = sTabledata.order();
				var jsonData 	=	{'course' : 'cs', 'year_level': $("#selYear").val(), 'semester': $("#selSem").val(), 'status' : $("#selStatus").val(), 'section': $("#selSection").val(), 'sortid' : order[0][0], 'sorttype': order[0][1] };

				ajaxQuery('extract-students', jsonData, $(this));
			break;

			case 'filter':
				_fetchStudents();
			break;
			
			case 'cancel':
				$('input').val('');
				$('hidden').val('');
				$('select').val('');
				$("#modalNewStudent").modal('hide');
			break;

		}

	});

	_execWidgets();
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


function _edit(nId) {
	ajaxQuery('edit-student', {'data' : nId}, '');
}

function _addgrade(nId) {
	window.location ='grade-entry?id=' + nId;
}

function _delete(nId) {
	var aUrl = (window.location.href).split("/");
	
	_confirm('delete', "Are you sure you want to REMOVE this student? Please be advised that this action cannot be undone!", {'UniqueId': nId, 'Course' : aUrl[aUrl.length - 1]});
}

function _conTinue(sAction, sObjData) {
    var nUniqueId 	=   sObjData.UniqueId;
	var sCourse 	=   sObjData.Course;
    ajaxQuery('delete-student', {'data' : nUniqueId, 'course' : sCourse}, '');
}

function _fetchStudents(sCourse)   {

	var jsonData 	=	 {'year_level': $("#selYear").val(), 'semester': $("#selSem").val(), 'status' : $("#selStatus").val(), 'course' : $("#txtCourseType").val(), 'section': $("#selSection").val() };

	ajaxQuery('fetch-students', jsonData, '');
}

function _execWidgets() {
	$("[data-key=YearLevelSearch]").on('change', function() {

        var aTextVal    =   $(this).find("option");

        for (var n = 0; n < aTextVal.length; n++)
        {
            if ($(aTextVal[n]).is(":selected")) {
                var sTextDis = $(aTextVal[n]).text();
				var sTextVal = $(aTextVal[n]).val();

				if (sTextVal != "") {

            		$("div.dataTables_wrapper div.dataTables_filter input").val(sTextVal);
            		sTabledata.columns( 5 ).search( sTextDis ).draw();
				} else {
					_refresh();
				}
            }
        }        
    });
}