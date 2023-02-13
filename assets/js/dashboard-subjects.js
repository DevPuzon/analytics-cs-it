var sTabledata = "";
$(document).ready(function() {
	_fetchSubjects();
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
			 

			case 'print-cs':
				var order = sTabledata.order();
				var jsonData 	=	{'course' : 'cs', 'year_level': $("#selYear").val(), 'semester': $("#selSem").val(), 'status' : $("#selStatus").val(), '_fetchSubjects': $("#sel_fetchSubjects").val(), 'sortid' : order[0][0], 'sorttype': order[0][1] };
				
				ajaxQuery('extract-students', jsonData, $(this));
			break;

			case 'print-it':
				var order = sTabledata.order();
				var jsonData 	=	{'course' : 'cs', 'year_level': $("#selYear").val(), 'semester': $("#selSem").val(), 'status' : $("#selStatus").val(), 'section': $("#selSection").val(), 'sortid' : order[0][0], 'sorttype': order[0][1] };

				ajaxQuery('extract-students', jsonData, $(this));
			break;

			case 'filter':
				_fetchSubjects();
				
				$(`#grade-mid-dashboard-subjects`).html("");
				$(`#grade-final-dashboard-subjects`).html("");
				$("#accordion-dashboard-subjects").html(""); 
			break;
			
			case 'print': 
				$("#main-list").hide();
				setTimeout(()=>{ 	
					print(); 
					$("#main-list").show();
				},1000);  
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


async function _subjectAnalytics(id){
	id = id.split("||");
	var jsonData 	=	 {'course':id[0],'year_level':id[1],'semester':id[2],'subject_code':id[3]}; 
	var res = await ajaxQuery('subject_analytics', jsonData, '');
	console.log(res);
	res = res.split(/(\r\n|\n|\r)/gm);
	let dataRes = JSON.parse(res.splice(2,res.length).join("")); 
	let average_grade= dataRes.average_grade;
	let student_grades= dataRes.student_grades;
	$("#accordion-dashboard-subjects").html(""); 
	generateBreakDownChart(makeid(),"Total Average Grade Of Students",[id[4].replaceAll("*+^"," ")],
	parseFloat(average_grade.avgMid).toFixed(2),
	parseFloat(average_grade.avgFinal).toFixed(2));

	generateLeaderboardTable(makeid(),"Mid Term - Student Grade List","mid",student_grades.midGrades);
	generateLeaderboardTable(makeid(),"Final Term - Student Grade List","final",student_grades.finalGrades);
	 
}

async function generateLeaderboardTable(ctxID,title,season,student_grades){
	// await new Promise((resolve)=>{setTimeout(()=>{resolve()},1000)});
	$(`#grade-${season}-dashboard-subjects`).html("");
	let retStr=`<div class="card">
	<div class="card-header" id="${ctxID}head">
		<h5 class="mb-0">
			<button class="btn btn-link" data-toggle="collapse" data-target="#${ctxID}collapse" aria-expanded="true" aria-controls="${ctxID}collapse">
			${title}
			</button>
		</h5>
	</div>

	<div id="${ctxID}collapse" class="collapse show" aria-labelledby="${ctxID}head" data-parent="#accordion-dashboard-subjects">
		<div class="card-body">  `;
		
	retStr+=`<table class='table table-hover table-striped ${season}-tbl-data'>
	<thead>
	<tr>
		<th> Student No. </th>
		<th> Name </th>
		<th> Grade </th>
	</tr>
	</thead>
	<tbody>
	`;
	student_grades.forEach((els)=>{
		retStr += `<tr style=' cursor: pointer; '  >
			<td> ${els.student_no} </td>
			<td> ${els.full_name} </td>
			<td> ${els.grade} </td>
		</tr>`;
	})
	retStr+=`</tbody>
			</table></div>
			</div>
		</div> `;
console.log(retStr,`#grade-${season}-dashboard-subjects`);
	$(`#grade-${season}-dashboard-subjects`).html(retStr);
	$(`.${season}-tbl-data`).DataTable({
		'paging': true,
		'lengthChange': true,
		'searching': true, 
		'info' : true,
		'autoWidth': false,
	});
}

function generateBreakDownChart(ctxID,title,labels,mid,finals){ 
	console.log(`generateBreakDownChart`,ctxID,title,labels,mid,finals); 
	$("#accordion-dashboard-subjects").append(` 
		<div class="card">
			<div class="card-header" id="${ctxID}head">
				<h5 class="mb-0">
					<button class="btn btn-link" data-toggle="collapse" data-target="#${ctxID}collapse" aria-expanded="true" aria-controls="${ctxID}collapse">
					${title}
					</button>
				</h5>
			</div>

			<div id="${ctxID}collapse" class="collapse show" aria-labelledby="${ctxID}head" data-parent="#accordion-dashboard-subjects">
				<div class="card-body"> 
					<canvas id="${ctxID}"></canvas>
				</div>
			</div>
		</div> 
	`) 
	const ctx = document.getElementById(ctxID);  
	new Chart(ctx, { 
	  type: 'bar',
	  data: 
		  {
			//   labels: ['Subj1','Subj2','Subj3'],
			labels:labels,
			datasets: [
				{
					label: 'Mid',
					// data: [1,2,3], 
					data: [mid],
					//backgroundColor: getRandomColors()
				},
				{
					label: 'Final',
					// data:  [11,12,13], 
					data:[finals],
					//backgroundColor: getRandomColors()
				}
			]
		  }
	  ,
	  options: {
		  indexAxis: 'y', 
		  elements: {
		  bar: {
			  borderWidth: 2,
		  }
		  },
		  responsive: true,
		  plugins: {
		  legend: {
			  position: 'right',
		  },
		  title: {
			  display: true,
			  text:title
		  }
		  }
	  },
	}); 
} 
function getRandomColors(){
  let array =['F06292',
			  'BA68C8',
			  '9575CD',
			  '4FC3F7',
			  '4DD0E1',
			  '4DB6AC',
			  'DCE775',
			  'FFD54F',
			  'D81B60',
			  '8E24AA',
			  '5E35B1',
			  '3949AB',
			  '039BE5',
			  '00ACC1',
			  '43A047',
			  '7CB342',
			  'FFB300',
			  'FB8C00',
			  'FBC02D',
			  'FFA000',
			  '059CFF',
			  '82CDFF',
			  'FF4069',
			  'FFA0B4'
		  ] 
  return "#"+array[Math.floor(Math.random() * array.length)];
}
function makeid(length=3) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
}

function _conTinue(sAction, sObjData) {
    var nUniqueId 	=   sObjData.UniqueId;
	var sCourse 	=   sObjData.Course;
    ajaxQuery('delete-student', {'data' : nUniqueId, 'course' : sCourse}, '');
}

function _fetchSubjects()   {

	var jsonData 	=	 {
		'year_level': $("#selYear").val() || null, 
		'semester': $("#selSem").val() || null,  
		'course' : $("#txtCourseType").val()   || null,  
		'academic_year' : $("#AcademicYear").val()   || null
	}; 
	ajaxQuery('fetch-subjects-dashboard', jsonData, '');
	
	initialClickRow();
}

function initialClickRow (){ 
	setTimeout(() => { 
		var rows = document.querySelectorAll("tr");
			rows.forEach(row => {
			row.addEventListener("click", function() {
				rows.forEach(r => {
				r.style.background = "";
				r.style.color = "";
				}); 
				this.style.setProperty('color', 'white', 'important');
				this.style.setProperty('background', '#007BFF', 'important');
			});
		});
		
		setTimeout(() => { 
			var table = document.getElementsByTagName("table")[0]; 
			var rows = table.querySelectorAll("tr");
			var i = 0 ;
			rows.forEach(row => { 
				i++;
				if(i==2){row.click();} 
			}); 
		}, 500);
	}, 1000);
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