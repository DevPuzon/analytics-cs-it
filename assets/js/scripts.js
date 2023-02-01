
$(document).ready(function() {
	const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: true,
      timer: 2000,
    });

    $(function () {
        $('.modal').modal({
            show: false,
            keyboard: false,
            backdrop: 'static'
        });
    });

    $(".num-only").keypress(function (e) {

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

            return false;
        }
    });

    
});


function _checkFormFields(frmId="")
{
	var nCnt 	=	0;
	var nEmpty 	= 0;
	var aElements 	=	$(frmId).find("input, textarea, select");
	
	for (nCnt = 0; nCnt < aElements.length; nCnt++) {
		var sElement=	aElements[nCnt];
		var sValue 	=	$(sElement).val();
		var sData 	=	$(sElement).attr("data");

		if ($(sElement).is(":visible")) 
		{
			if (sData != 'exclude')
			{
				if (sData == "req") {
					if (sValue == "")
					{
						$(sElement).addClass(" has-error ");
						nEmpty++;
					}
					else
					{
						$(sElement).removeClass(" has-error ");
					}
				}
			}
		}
	}

	if (nEmpty > 0) {
		return false;
	}
	else {
		return true;
	}
}

function _collectFields(vFormId){

	var sJsonFields =	{};
	var nCnt 	=	0;
	var nEmpty 	= 0;
	var aElements 	=	$(vFormId).find("input:not(:checkbox):not(:radio), textarea, select");

	for (nCnt = 0; nCnt < aElements.length; nCnt++) {
		
		var sElement=	aElements[nCnt];

		var sDataKey 	=	$(sElement).attr('data-key');
		var sValue 		=	$(sElement).val();

		if ($(sElement).is(":visible") === true) {
			if (sDataKey) {
				sJsonFields[sDataKey] = sValue;
			}
		}
	}

	return JSON.stringify(sJsonFields);
}

function _collectJsonFields(vFormId){

	var sJsonFields =	{};
	var nCnt 	=	0;
	var nEmpty 	= 0;
	var aElements 	=	$(vFormId).find("input:not(:checkbox):not(:radio), textarea, select");

	for (nCnt = 0; nCnt < aElements.length; nCnt++) {
		
		var sElement=	aElements[nCnt];

		var sDataKey 	=	$(sElement).attr('data-jsonkey');
		var sValue 		=	$(sElement).val();

		if ($(sElement).is(":visible") === true) {
			if (sDataKey) {
				sJsonFields[sDataKey] = sValue;
			}
		}
	}

	return JSON.stringify(sJsonFields);
}

function _collectTickBoxes(sObjParent)
{
	var nCtr			=	0;
	var aTickBoxesRet 	=	{};
	var aTickBoxes 		=	$(sObjParent).find('input[type=checkbox], input[type=radio]');


	if (aTickBoxes.length > 0) {

		for (nCtr = 0; nCtr < aTickBoxes.length; nCtr++) {

			var vTickBox 	=	aTickBoxes[nCtr];
			var sJsonKey 	=	$(vTickBox).attr('data-jsonkey');

			
				aTickBoxesRet[sJsonKey] = $(vTickBox).prop('checked');
			
		}
	}

	return JSON.stringify(aTickBoxesRet);
}

function _clearFields() {

	var nCnt 	=	0;
	var nEmpty 	= 0;
	var aElements 	=	$('form').find("input, textarea, select");

	for (nCnt = 0; nCnt < aElements.length; nCnt++) {
		
		var sElement=	aElements[nCnt];

		$(sElement).removeClass(" has-error ");
		$(sElement).val('');
	}
}


function ajaxQuery(sUrl='', sData='', sLoadParent='') {
	
	$.ajax({
		url 		: sUrl,
		type 		: 'POST',
		data 		: sData,
		beforeSend	: function() {
			$("body").css({'pointer-events' : 'none'});
			if (sLoadParent != '') {
				$(sLoadParent).append('<div class="spinner-border spinner-border-sm text-primary" role="status"> <span class="sr-only">Loading...</span> </div>');
			}
		}, 
		success 	: function(result) {
			console.log(result);
			$("body").css({'pointer-events' : ''});
			if (sLoadParent != '') {
				$(sLoadParent).parent().find('.spinner-border').remove();
			}

			eval(result);
		},
		error 		: function(e) {
			console.log(e.responseText);
			$("body").css({'pointer-events' : ''});
			$(sLoadParent).parent().find('.spinner-border').remove();

			toastr.error('Failed to complete the process!');
		}
	});
}



function compAge(dob) { 
	
    var diff_ms = Date.now() - dob.getTime();
    var age_dt = new Date(diff_ms); 
  
    return Math.abs(age_dt.getUTCFullYear() - 1970);
}

function _confirm(sAction, sContent, sJsonData)
{
    $.confirm({
        title: 'System Notification',
        content: sContent,
        icon: 'fa fa-question-circle',
        type: 'orange',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Yes',
                btnClass: 'btn-green',
                action: function(){
                    _conTinue(sAction, sJsonData);
                }
            },
            moreButtons: {
                text: 'No',
                btnClass: 'btn-red',
                action: function(){
                    
                }
            },
        }
    });
}

function _refresh() {
	location.reload();
}