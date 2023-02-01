$(document).ready(function() {
	$("button").on('click', function (e) {
		
		e.preventDefault();
		var sAction =	$(this).attr("data-trigger");
		var sForm 	=	$(this).closest('form');

		switch(sAction) {
            case 'add-academic': 
				$("#modalNewYrSr").modal('show');
            break;
            case 'cancel':
				$("#modalNewYrSr").modal('hide');
            break;
			case 'save-grades':
                var nError = 0;
                var aGrades = {};
                var nUniqueId = $("[data-key=UniqueId]").val();
                var aInput    = $("input[type=number]");

                $.each(aInput, function(i, input) {
                    if ($(input).val() != "") {
                        if (parseInt($(input).val()) <= 100) {
                            aGrades[$(this).attr('data-key')] = $(input).val();
                        } else {
                            nError++;
                        }
                    } else {
                        aGrades[$(this).attr('data-key')] = $(input).val();
                    }
                });

                if (nError > 0) {
                    toastr.error('Grades more than 100 is not Allowed');
                } else {
                    var jsonData =	{ 'data' : JSON.stringify(aGrades), 'id' : nUniqueId };
                    ajaxQuery('save-grades', jsonData, $(this));
                }
			break;

            case 'print-grades':
                var nUniqueId = $("[data-key=UniqueId]").val();

                var jsonData =	{ 'id' : nUniqueId };
                ajaxQuery('print-grades', jsonData, $(this));
            break;
        }

	});

    $("input[type='number']").on('click', function () {
        $(this).select();
    });

    $("[type=number]").on('keyup', function() {
        var sParentTr   =   $(this).closest("tr")[0];
        var nUnit = parseInt( $( ($(sParentTr).find('.abbr-units'))[0] ).text() );
        var fMid = parseFloat( $( ($(sParentTr).find('.mid-input'))[0] ).val() );
        var fFin = parseFloat( $( ($(sParentTr).find('.fin-input'))[0] ).val() );

        if (fMid != '' && fFin != '') {
            var fGradeAve = (fMid + fFin) / 2;
            var aGradeDet = grade_range_point(fGradeAve);
        } else {
            var aGradeDet = grade_range_point("inc");
        }

        $( ($(sParentTr).find('.abbr-grade-range'))[0] ).text(aGradeDet[0]);
        $( ($(sParentTr).find('.abbr-grade-point'))[0] ).text(aGradeDet[1]);
        $( ($(sParentTr).find('.abbr-remarks'))[0] ).text(aGradeDet[2]);
    });
});

function grade_range_point(fGrade) {

    if (fGrade == "inc") {
        return ['-', '-', 'INC'];
    } else if (fGrade > 96 && fGrade <= 100) {
        return ['97-100', '1.0', 'PASSED'];
    } else if (fGrade > 93 && fGrade <= 96) {
        return ['92-96', '1.25', 'PASSED'];
    } else if (fGrade > 90 && fGrade <= 93) {
        return ['91-93', '1.5', 'PASSED'];
    } else if (fGrade > 87 && fGrade <= 90) {
        return ['88-90', '1.75', 'PASSED'];
    } else if (fGrade > 84 && fGrade <= 87) {
        return ['85-87', '2.0', 'PASSED'];
    } else if (fGrade > 81 && fGrade <= 84) {
        return ['82-84', '2.25', 'PASSED'];
    } else if (fGrade > 78 && fGrade <= 81) {
        return ['79-81', '2.5', 'PASSED'];
    } else if (fGrade > 75 && fGrade <= 78) {
        return ['76-78', '2.75', 'PASSED'];
    } else if (fGrade > 72 && fGrade <= 75) {
        return ['73-75', '3.0', 'PASSED'];
    } else if (fGrade <= 72) {
        return ['<= 72', '5.0', 'FAILED'];
    } else {
        return ['-', '-', '-'];
    }

}