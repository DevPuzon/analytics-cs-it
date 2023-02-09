function _createGraph(sGraph) {
  return;
var { passedcs } = {...sGraph};
var { failedcs } = {...sGraph};
var { passedit } = {...sGraph};
var { failedit } = {...sGraph};

    'use strict'
  
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }
  
    var mode      = 'index'
    var intersect = true

  
    var $visitorsChart = $('#passing-chart-cs')
    var visitorsChart  = new Chart($visitorsChart, {
      data   : {
        labels  : ['1st Year', '2nd Year', '3rd Year', '4th Year'],
        datasets: [{
          type                : 'line',
          data                : [passedcs.sem_one.year_one, passedcs.sem_one.year_two, passedcs.sem_one.year_three, passedcs.sem_one.year_four],
          backgroundColor     : 'transparent',
          borderColor         : '#28a745',
          pointBorderColor    : '#28a745',
          pointBackgroundColor: '#28a745',
          fill                : false
        },
        {
          type                : 'line',
          data                : [passedcs?.sem_two?.year_one, passedcs?.sem_two?.year_two, passedcs?.sem_two?.year_three, passedcs?.sem_two?.year_four],
          backgroundColor     : 'tansparent',
          borderColor         : '#20c997',
          pointBorderColor    : '#20c997',
          pointBackgroundColor: '#20c997',
          fill                : false
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero : true,
            //   suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    });

    var $visitorsChart = $('#passing-chart-it')
    var visitorsChart  = new Chart($visitorsChart, {
      data   : {
        labels  : ['1st Year', '2nd Year', '3rd Year', '4th Year'],
        datasets: [{
          type                : 'line',
          data                : [passedit?.sem_one?.year_one, passedit?.sem_on?.year_two, passedit?.sem_one?.year_three, passedit?.sem_one?.year_four],
          backgroundColor     : 'transparent',
          borderColor         : '#28a745',
          pointBorderColor    : '#28a745',
          pointBackgroundColor: '#28a745',
          fill                : false
        },
        {
          type                : 'line',
          data                : [passedit?.sem_two?.year_one, passedit?.sem_two?.year_two, passedit?.sem_two?.year_three, passedit?.sem_two?.year_four],
          backgroundColor     : 'tansparent',
          borderColor         : '#20c997',
          pointBorderColor    : '#20c997',
          pointBackgroundColor: '#20c997',
          fill                : false
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero : true,
            //   suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    });

    var $visitorsChart = $('#failing-chart-cs')
    var visitorsChart  = new Chart($visitorsChart, {
      data   : {
        labels  : ['1st Year', '2nd Year', '3rd Year', '4th Year'],
        datasets: [{
          type                : 'line',
          data                : [failedcs?.sem_one?.year_one, failedcs?.sem_one?.year_two, failedcs?.sem_one?.year_three, failedcs?.sem_one?.year_four],
          backgroundColor     : 'transparent',
          borderColor         : '#dc3545',
          pointBorderColor    : '#dc3545',
          pointBackgroundColor: '#dc3545',
          fill                : false
        },
        {
          type                : 'line',
          data                : [failedcs?.sem_two?.year_one, failedcs?.sem_two?.year_two, failedcs?.sem_two?.year_three, failedcs?.sem_two?.year_four],
          backgroundColor     : 'tansparent',
          borderColor         : '#e83e8c',
          pointBorderColor    : '#e83e8c',
          pointBackgroundColor: '#e83e8c',
          fill                : false
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero : true,
            //   suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    });

    var $visitorsChart = $('#passing-chart-it')
    var visitorsChart  = new Chart($visitorsChart, {
      data   : {
        labels  : ['1st Year', '2nd Year', '3rd Year', '4th Year'],
        datasets: [{
          type                : 'line',
          data                : [passedit?.sem_one?.year_one, passedit?.sem_on?.year_two, passedit?.sem_one?.year_three, passedit?.sem_one?.year_four],
          backgroundColor     : 'transparent',
          borderColor         : '#28a745',
          pointBorderColor    : '#28a745',
          pointBackgroundColor: '#28a745',
          fill                : false
        },
        {
          type                : 'line',
          data                : [passedit?.sem_two?.year_one, passedit?.sem_two?.year_two, passedit?.sem_two?.year_three, passedit?.sem_two?.year_four],
          backgroundColor     : 'tansparent',
          borderColor         : '#20c997',
          pointBorderColor    : '#20c997',
          pointBackgroundColor: '#20c997',
          fill                : false
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero : true,
            //   suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    });

    var $visitorsChart = $('#failing-chart-it')
    var visitorsChart  = new Chart($visitorsChart, {
      data   : {
        labels  : ['1st Year', '2nd Year', '3rd Year', '4th Year'],
        datasets: [{
          type                : 'line',
          data                : [failedit?.sem_one?.year_one, failedit?.sem_one?.year_two, failedit?.sem_one?.year_three, failedit?.sem_one?.year_four],
          backgroundColor     : 'transparent',
          borderColor         : '#dc3545',
          pointBorderColor    : '#dc3545',
          pointBackgroundColor: '#dc3545',
          fill                : false
        },
        {
          type                : 'line',
          data                : [failedit?.sem_two?.year_one, failedit?.sem_two?.year_two, failedit?.sem_two?.year_three, failedit?.sem_two?.year_four],
          backgroundColor     : 'tansparent',
          borderColor         : '#e83e8c',
          pointBorderColor    : '#e83e8c',
          pointBackgroundColor: '#e83e8c',
          fill                : false
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero : true,
            //   suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    });
  }
  


$(document).ready(function() { 

  totalNumberStudenstPerCourse();
  
  // Number of studens passed and failed
  passedFailedStudentsQuery("","Students GWA Analytics"); 
  // Number of studens in cs passed and failed
  passedFailedStudentsQuery("cs","CS Students GWA Analytics");
  // Number of studens in it passed and failed
  passedFailedStudentsQuery("it","IT Students GWA Analytics");



  async function passedFailedStudentsQuery(course="",title){
    var jsonData 	=	 {'course' : course }; 
    var res = await ajaxQuery('passed_failed_students', jsonData, ''); 
    res = res.split(/(\r\n|\n|\r)/gm);
    var dataRes = JSON.parse(res.splice(2,res.length).join(""));  
    var passed = parseFloat(dataRes.passed);
    var failed = parseFloat(dataRes.failed);
    var inc = parseFloat(dataRes.inc);
    generatePieChart(makeid(),title,["Passed","Failed","INC"],"GWA",[passed,failed,inc]);
  } 

  function totalNumberStudenstPerCourse(){ 
    var noCs = $("[data-key=NoCs]").val(); 
    var noIt = $("[data-key=NoIt]").val();
    generatePieChart(makeid(),"No. Of Students Analytics",["CS","IT"],"No. Of Students",[parseFloat(noCs),parseFloat(noIt)]);
  }


  function generatePieChart(ctxID,title,labels,label,datasets){
    console.log(ctxID,title,labels,label,datasets)  
    $("#home-dashboard").append(` 
      <div class="col-lg-3 col-sm-12 col-md-6">
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
      </div> 
    `)  
	const ctx = document.getElementById(ctxID);  
  const sum = datasets.reduce((partialSum, a) => partialSum + a, 0); 

  
	new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [
          {
            label: label,
            data: datasets,
            backgroundColor:getRandomColorsArr()
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          labels:{
            render:(args)=>{
              return `${args.label} : ${args.value} (${((100/sum)*args.value).toFixed(0)}%)`;
            }
          },
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: title
          }
        }
      },
    }); 

  }

});

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



function getRandomColorsArr(){
  // let arr =[];
  // for(let i = 0 ; i<20;i++){
  //   arr.push(getRandomColors());
  // }
  // return arr;
  return [
    "#059BFF",
    "#FF416A",
    "#22CFCF",
    "#FFC337",
    "#FF9021", 
  ]
}

function getRandomColors(){
  let array =['#F06292',
			  '#FFA4C1',
			  '#9575CD',
			  '#4FC3F7',
			  '#4DD0E1',
			  '#4DB6AC',
			  '#DCE775',
			  '#FFD54F',
			  '#D81B60',
			  '#8E24AA',
			  '#5E35B1',
			  '#3949AB',
			  '#039BE5',
			  '#00ACC1',
			  '#43A047',
			  '#7CB342',
			  '#FFB300',
			  '#FB8C00',
			  '#FBC02D',
			  '#FFA000',
			  '#059CFF',
			  '#82CDFF',
			  '#FF4069',
			  '#FFA0B4'
		  ] 
      // return array;
  return array[Math.floor(Math.random() * array.length)];
}