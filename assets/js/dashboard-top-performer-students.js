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
				$("#accordion-dashboard-top-performer-students").html("");
				$("#accordion-dashboard-students").html("");
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


async function _studentAnalytics(id){
	$("#accordion-dashboard-top-performer-students").html("");
	$("#accordion-dashboard-students").html("");
	var jsonData 	=	 {'id':id};    
	var res = await ajaxQuery('get_student_info', jsonData, ''); 
	res = res.split(/(\r\n|\n|\r)/gm);
	var dataRes = JSON.parse(res.splice(2,res.length).join(""));  
	console.log(dataRes);
	$('#student_info').html(`${dataRes.html}`); 
	var res = await ajaxQuery('student_analytics', jsonData, '');
	console.log(res);
	res = res.split(/(\r\n|\n|\r)/gm);
	var dataRes = JSON.parse(res.splice(2,res.length).join("")).data;  
	
	calcTopPerformer(dataRes);
	let academic_analytics = dataRes.academic_analytics;
	for(let academicKey of Object.keys(academic_analytics)){
		let academic = academic_analytics[academicKey]; 
		var ctxID,title,labels=[],mid=[],finals=[];
		ctxID = makeid(3);
		title = `${academic.year_level} Year - ${academic.semester} Semester - ${academic.section}`;
		for(let subjKey of Object.keys(academic.data)){
			let subj = academic.data[subjKey];
			labels.push(subj.subject_code);
			mid.push(subj.mid);
			finals.push(subj.finals); 
		}
		generateBreakDownChart(ctxID,title+" Analytics",labels,mid,finals); 
	} 
}

function generateBreakDownChart(ctxID,title,labels,mid,finals){ 
	if(labels.length==0){return;}
	$("#accordion-dashboard-students").append(` 
		<div class="card">
			<div class="card-header" id="${ctxID}head">
				<h5 class="mb-0">
					<button class="btn btn-link" data-toggle="collapse" data-target="#${ctxID}collapse" aria-expanded="true" aria-controls="${ctxID}collapse">
					${title}
					</button>
				</h5>
			</div>

			<div id="${ctxID}collapse" class="collapse show" aria-labelledby="${ctxID}head" data-parent="#accordion-dashboard-students">
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
					data: mid,
					//backgroundColor: getRandomColors()
				},
				{
					label: 'Final',
					// data:  [11,12,13], 
					data:finals,
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

function calcTopPerformer(dataRes){
	var title,labels=[],mid=[],finals=[],midFinalAvgs=[]; 
	title = `Student Performer`;
	for(let avg of dataRes.avg_grade_timeline_analytics){
		labels.push(`${avg.year_level} Year - ${avg.semester} Semester`);
		midFinalAvgs.push((avg.mid_avg+avg.final_avg)/2); 
		mid.push(avg.mid_avg);
		finals.push(avg.final_avg); 
	} 
	generateTopPerformerBreakDownChart(makeid(),title+" Analytics",labels,mid,finals,midFinalAvgs); 
}

function generateTopPerformerBreakDownChart(ctxID,title,labels,mid,finals,midFinalAvgs){ 
	if(labels.length==0){return;}
	$("#accordion-dashboard-top-performer-students").append(` 
		<div class="card">
			<div class="card-header" id="${ctxID}head">
				<h5 class="mb-0">
					<button class="btn btn-link" data-toggle="collapse" data-target="#${ctxID}collapse" aria-expanded="true" aria-controls="${ctxID}collapse">
					${title}
					</button>
				</h5>
			</div>

			<div id="${ctxID}collapse" class="collapse show" aria-labelledby="${ctxID}head" data-parent="#accordion-dashboard-top-performer-students">
				<div class="card-body"> 
					<canvas id="${ctxID}"></canvas>
				</div>
			</div>
		</div> 
	`)

	const ctx = document.getElementById(ctxID);  
	new Chart(ctx, { 
		type: 'line',
		data: {
			labels: labels,
			datasets: [{
			  type: 'bar',
			  label: 'Mid Term Grade Average',
			//   //backgroundColor: getRandomColors(),
			  data: mid
			}, {
			  type: 'bar',
			  label: 'Final Grade Average',
			//   //backgroundColor: getRandomColors(),
			  data: finals
			}, {
			  type: 'line',
			  label: 'Mid And Final Grade Average',
			//   backgroundColor: getRandomColors(), 
			  fill: false,
			  data: midFinalAvgs
			}]
		  },
		options: {
		  plugins: {
			title: {
			  text: title,
			  display: true
			}
		  },
		//   scales: {
		// 	x: {
		// 	  type: 'time',
		// 	  display: true,
		// 	  offset: true,
		// 	  time: {
		// 		unit: 'day'
		// 	  }
		// 	},
		//   },
		// scales: {
		// 	x: {
		// 	  type: 'time',
		
		// 	  // add this: 
		// 	  adapters: { 
		// 		date: {
		// 		  locale: enUS, 
		// 		},
		// 	  }, 
		// 	}
		//   },
		}, 
	}); 
}

function totalGWAPerYearSemester(ctxID){
	let title = "Overall GWA Per Year And Semester";
	const ctx = document.getElementById(ctxID);  
	new Chart(ctx, { 
		type: 'bar',
		data: {
			labels: labels,
			datasets: [
			  {
				label: 'Dataset 1',
				data: Utils.numbers(NUMBER_CFG),
				//backgroundColor: getRandomColors()
			  },
			  {
				label: 'Dataset 2',
				data: Utils.numbers(NUMBER_CFG),
				//backgroundColor: getRandomColors()
			  }
			]
		  },
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
			  text: 'Chart.js Horizontal Bar Chart'
			}
		  }
		},
	}); 
}

function getRandomColors(){
  let array =['F06292',
			  'FFA4C1',
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

function _fetchStudents()   {

	var jsonData 	=	 {'year_level': $("#selYear").val(), 
	'semester': $("#selSem").val(), 'status' : $("#selStatus").val(), 
	'course' : $("#txtCourseType").val(), 
	'section': $("#selSection").val() , 
	'academic_year': $("#AcademicYear").val()};
	ajaxQuery('fetch-top-performer-students-dashboard', jsonData, '');
	
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