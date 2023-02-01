function _createGraph(sGraph) {
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
  