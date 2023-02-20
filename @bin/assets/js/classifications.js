$(document).ready(function() {

    $("select").on('change', function() {
        var aClass  = [];
        var aSelects = $("select");

        $(".div-cards").hide();

        $.each(aSelects, function(i, sel) {
            var sValue = $(sel).val();
            if (sValue.trim() != "") {
                aClass.push("div-" + sValue);
            }
        });
        var sClass = "";
        if (aClass.length > 0) {
            for(var i = 0; i < aClass.length; i++) {
                sClass += "."+aClass[i];
            }
            $(sClass).show();
        } else {
            $(".div-cards").show();
        }
    });

    $("button").on('click', function (e) {
		
		e.preventDefault();
		var sAction =	$(this).attr("data-trigger");
		var sForm 	=	$(this).closest('form');
        var sYear   = $("#selYear").val();
        var sSem    = $("#selSem").val();
        var sCourse = $("#selCourse").val();
        var sSection = $("#selSection").val();

        switch(sAction) {
            case 'performers':
            case 'failed':
            case 'inc':
                var jsonData =	{'type' : sAction, 'year' : sYear, 'sem' : sSem, 'course' : sCourse, 'section': sSection };
                ajaxQuery('print-classifications', jsonData, $(this));
            break;

            case 'notify-top':
            case 'notify-failed':
            case 'notify-inc':
                var jsonData =	{'type' : sAction, 'year' : sYear, 'sem' : sSem, 'course' : sCourse, 'section': sSection };
                ajaxQuery('send-notif', jsonData, $(this));
            break;
        }
        
    });
});