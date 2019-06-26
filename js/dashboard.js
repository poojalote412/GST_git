(function($) {
  'use strict';
  $(function() {
    if ($('#circleProgress6').length) {
      var bar = new ProgressBar.Circle(circleProgress6, {
        color: '#001737',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 10,
        trailWidth: 10,
        easing: 'easeInOut',
        duration: 1400,
        text: {
          autoStyleContainer: false
        },
        from: {
          color: '#aaa',
          width: 10
        },
        to: {
          color: '#2617c9',
          width: 10
        },
        // Set default step function for all animate calls
        step: function(state, circle) {
          circle.path.setAttribute('stroke', state.color);
          circle.path.setAttribute('stroke-width', state.width);
  
          var value = '<p class="text-center mb-0">Score</p>' + Math.round(circle.value() * 100) + "%";
          if (value === 0) {
            circle.setText('');
          } else {
            circle.setText(value);
          }
  
        }
      });
  
      bar.text.style.fontSize = '1.875rem';
      bar.text.style.fontWeight = '700';
      bar.animate(.75); // Number from 0.0 to 1.0
    }
    if ($('#circleProgress7').length) {
      var bar = new ProgressBar.Circle(circleProgress7, {
        color: '#9c9fa6',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 10,
        trailWidth: 10,
        easing: 'easeInOut',
        trailColor: '#1f2130',
        duration: 1400,
        text: {
          autoStyleContainer: false
        },
        from: {
          color: '#aaa',
          width: 10
        },
        to: {
          color: '#2617c9',
          width: 10
        },
        // Set default step function for all animate calls
        step: function(state, circle) {
          circle.path.setAttribute('stroke', state.color);
          circle.path.setAttribute('stroke-width', state.width);
  
          var value = '<p class="text-center mb-0">Score</p>' + Math.round(circle.value() * 100) + "%";
          if (value === 0) {
            circle.setText('');
          } else {
            circle.setText(value);
          }
  
        }
      });
  
      bar.text.style.fontSize = '1.875rem';
      bar.text.style.fontWeight = '700';
      bar.animate(.75); // Number from 0.0 to 1.0
    }

  var eventData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
            label: 'Critical',
            data: [20, 35, 15, 45, 35, 40, 25, 44, 20, 30, 38, 15],
            backgroundColor: [
              'rgba(	255, 131, 0)'
            ],
            borderColor: [
                'rgba(	255, 131, 0)'
            ],
            backgroundColor: [
              'rgba(	255, 131, 0,.1)',
            ],
            borderWidth: 1,
            fill: true,
        },
        {
            label: 'Error',
            data: [30, 45, 25, 55, 45, 30, 35, 54, 30, 20, 48, 25],
            borderColor: [
                'rgba(242, 18, 38)',
            ],
            backgroundColor: [
              'rgba(242, 18, 38,.1)',
            ],
            borderWidth: 1,
            fill: true,
        },
        {
            label: 'Warning',
            data: [40, 55, 35, 65, 55, 40, 45, 64, 40, 30, 58, 35],
            borderColor: [
                'rgba(23, 23, 201)',
            ],
            backgroundColor: [
                'rgba(23, 23, 201,.1)',
            ],
            borderWidth: 1,
            fill: true,
        }
    ],
  };
  var eventOptions = {
      scales: {
          yAxes: [{
            display: false
          }],
          xAxes: [{
            display: false,
              position: 'bottom',
              gridLines: {
                drawBorder: false,
                display: true,
              },
              ticks: {
                display: false,
                beginAtZero: true,
                stepSize: 10
              }
          }],

      },
      legend: {
          display: false,
          labels: {
            boxWidth: 0,
          }
      },
      elements: {
          point: {
              radius: 0
          },
          line: {
            tension: .1,
          },
      },
      tooltips: {
          backgroundColor: 'rgba(2, 171, 254, 1)',
      }
  };
  
  if ($("#eventChart").length) {
    var lineChartCanvas = $("#eventChart").get(0).getContext("2d");
    var saleschart = new Chart(lineChartCanvas, {
        type: 'line',
        data: eventData,
        options: eventOptions
    });
  }

  var salesanalyticData = {
    labels: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"],
    datasets: [{
            label: 'Critical',
            data: [24, 23, 22, 24, 26, 23, 28],
            borderColor: [
                '#3022cb'
            ],
            borderWidth: 3,
            fill: false,
        },
        {
            label: 'Warning',
            data: [26, 27, 26, 22, 25, 26, 24],
            borderColor: [
                '#ff8300',
            ],
            borderWidth: 3,
            fill: false,
        },
        {
            label: 'Error',
            data: [25, 28, 24, 28, 29, 27, 25],
            borderColor: [
                '#f2125e',
            ],
            borderWidth: 3,
            fill: false,
        }
    ],
  };
  var salesanalyticOptions = {
      scales: {
          yAxes: [{
              display: true,
              gridLines: {
                drawBorder: false,
                display: true,
            },
              ticks: {
                display: false,
                beginAtZero: false,
                stepSize: 5
              }
          }],
          xAxes: [{
            display: true,
              position: 'bottom',
              gridLines: {
                  drawBorder: false,
                  display: false,
              },
              ticks: {
                display: true,
                beginAtZero: true,
                stepSize: 5
              }
          }],

      },
      legend: {
          display: false,
          labels: {
            boxWidth: 0,
          }
      },
      elements: {
          point: {
              radius: 0
          },
          line: {
            tension: .4,
        },
      },
      tooltips: {
          backgroundColor: 'rgba(2, 171, 254, 1)',
      }
  };
  
  if ($("#salesanalyticChart").length) {
    var lineChartCanvas = $("#salesanalyticChart").get(0).getContext("2d");
    var saleschart = new Chart(lineChartCanvas, {
        type: 'line',
        data: salesanalyticData,
        options: salesanalyticOptions
    });
  }
  var barChartStackedData = {
    labels: ["jan", "feb", "mar", "apr", "may", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: 'Safari',
      data: [10,20,15,30,20,10,20,15,30,20, 10,20,],
      backgroundColor: [
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
      ],
      borderColor: [
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
      ],
      borderWidth: 1,
      fill: false
    },
    {
      label: 'Chrome',
      data: [5,25,10,20,30,5,25,10,20,30,25,10],
      backgroundColor: [
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
      ],
      borderColor: [
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
        '#bfccda',
      ],
      borderWidth: 1,
      fill: false
    }]
  };
  var barChartStackedOptions = {
    scales: {
      xAxes: [{
        display: false,
        stacked: true,
        gridLines: {
          display: false //this will remove only the label
        },
      }],
      yAxes: [{
        stacked: true,
        display: false,
      }]
    },
    legend: {
      display: false,
      position: "bottom"
    },
    legendCallback: function(chart) {
      var text = [];
      text.push('<div class="row">');
      for (var i = 0; i < chart.data.datasets.length; i++) {
        text.push('<div class="col-sm-5 mr-3 ml-3 ml-sm-0 mr-sm-0 pr-md-0 mt-3"><div class="row align-items-center"><div class="col-2"><span class="legend-label" style="background-color:' + chart.data.datasets[i].backgroundColor[i] + '"></span></div><div class="col-9"><p class="text-dark m-0">' + chart.data.datasets[i].label + '</p></div></div>');
        text.push('</div>');
      }
      text.push('</div>');
      return text.join("");
    },
    elements: {
      point: {
        radius: 0
      }
    }

  };

  if ($("#barChartStacked").length) {
    var barChartCanvas = $("#barChartStacked").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartStackedData,
      options: barChartStackedOptions
    });
  }

  var barChartStackedDarkData = {
    labels: ["jan", "feb", "mar", "apr", "may", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: 'Safari',
      data: [10,20,15,30,20,10,20,15,30,20, 10,20,],
      backgroundColor: [
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
      ],
      borderColor: [
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
        '#2b80ff',
      ],
      borderWidth: 1,
      fill: false
    },
    {
      label: 'Chrome',
      data: [5,25,10,20,30,5,25,10,20,30,25,10],
      backgroundColor: [
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
      ],
      borderColor: [
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
        '#1f2130',
      ],
      borderWidth: 1,
      fill: false
    }]
  };
  var barChartStackedDarkOptions = {
    scales: {
      xAxes: [{
        display: false,
        stacked: true,
        gridLines: {
          display: false //this will remove only the label
        },
      }],
      yAxes: [{
        stacked: true,
        display: false,
      }]
    },
    legend: {
      display: false,
      position: "bottom"
    },
    legendCallback: function(chart) {
      var text = [];
      text.push('<div class="row">');
      for (var i = 0; i < chart.data.datasets.length; i++) {
        text.push('<div class="col-sm-5 mr-3 ml-3 ml-sm-0 mr-sm-0 pr-md-0 mt-3"><div class="row align-items-center"><div class="col-2"><span class="legend-label" style="background-color:' + chart.data.datasets[i].backgroundColor[i] + '"></span></div><div class="col-9"><p class="text-dark m-0">' + chart.data.datasets[i].label + '</p></div></div>');
        text.push('</div>');
      }
      text.push('</div>');
      return text.join("");
    },
    elements: {
      point: {
        radius: 0
      }
    }

  };

  if ($("#barChartStackedDark").length) {
    var barChartCanvas = $("#barChartStackedDark").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartStackedDarkData,
      options: barChartStackedDarkOptions
    });
  }


  if ($("#salesTopChart").length) {
    var graphGradient = document.getElementById("salesTopChart").getContext('2d');;
    var saleGradientBg = graphGradient.createLinearGradient(25, 0, 25, 110);
    saleGradientBg.addColorStop(0, 'rgba(242,18,94, 1)');
    saleGradientBg.addColorStop(1, 'rgba(255, 255, 255, 1)');
    var salesTopData = {
        labels: [
        "Feb 1",
        "Feb 2",
        "Feb 3",
        "Feb 4",
        "Feb 5",
        "Feb 6",
        "Feb 7",
        "Feb 8",
        "Feb 9",
        "Feb 10",
        "Feb 11",
        "Feb 12",
        "Feb 13",
        "Feb 14",
        "Feb 15",
        "Feb 16",
        "Feb 17",
        "Feb 18",
        "Feb 19",
        "Feb 20",
        "Feb 21",
        "Feb 22",
        "Feb 23",
        "Feb 24",
        "Feb 25",
        "Feb 26",
        "Feb 27",
        "Feb 28",
        "Mar 1",
        "Mar 2",
        "Mar 3",
        "Mar 4",
        "Mar 5",
        "Mar 6",
        "Mar 7",
        "Mar 8",
        "Mar 9",
        "Mar 10",
        ],
        datasets: [{
            label: '# of Votes',
            data: [80, 79, 78, 65, 77, 68, 63, 73, 58, 46, 60, 65, 74, 72, 63, 54, 55, 64, 34, 46, 34, 35, 24, 64, 34, 23, 13, 54, 27, 43, 34, 43, 64, 50, 43, 55, 39, 43],
            backgroundColor: saleGradientBg,
            borderColor: [
                'rgba(242,18,94)',
            ],
            borderWidth: 2,
            fill: true, 
        }]
    };

    var salesTopOptions = {
        scales: {
            yAxes: [{
              display: true,
                gridLines: {
                    display: true,
                    drawBorder: true,
                },
                ticks: {
                  display: false,
                  beginAtZero: true,
                }
            }],
            xAxes: [{
              display: true,
                gridLines: {
                    display: true,
                    drawBorder: false,
                },
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 4,
                    maxRotation: 360,
                    minRotation: 360,
                    padding: 10
                }
            }],
        },
        legend: {
            display: false
        },
        elements: {
          point: {
            radius: 0
        },
            line: {
                tension: 0.1,
            }
        },
        tooltips: {
            backgroundColor: 'rgba(31, 59, 179, 1)',
        }
    }
    var salesTop = new Chart(graphGradient, {
        type: 'line',
        data: salesTopData,
        options: salesTopOptions
    });
}
if ($("#flotChart").length) {
  var d1 = [
      [0,36.04],
      [1, 36],
      [2, 35],
      [3, 39],
      [4, 39],
      [5, 39],
      [6, 37],
      [7, 36],
      [8, 37],
      [9, 34],
      [10, 36],
      [11, 38],
      [12, 37],
      [13, 39],
      [14, 38],
      [15, 39],
      [16, 37],
      [17, 35],
      [18, 36],
      [19, 34],
      [20, 32],
      [21, 39],
      [22, 38],
      [23, 30],
      [24, 30],
      [24, 36],
      [26, 35],
      [29, 39],
      [30, 30],
      [31, 32],
      [32, 33],
      [33, 32],
      [34, 35],
      [35, 34],
      [36, 33],
      [37, 36],
      [38, 35],
      [39, 36],
      [40, 35],
      [41, 34],
      [42, 35],
      [43, 37],
      [44, 38],
      
  ];
  var d2 = [
      [0,12.68],
      [1, 12],
      [2, 15],
      [3, 19],
      [4, 19],
      [5, 19],
      [6, 17],
      [7, 16],
      [8, 17],
      [9, 14],
      [10, 16],
      [11, 18],
      [12, 17],
      [13, 19],
      [14, 18],
      [15, 19],
      [16, 17],
      [17, 15],
      [18, 16],
      [19, 14],
      [20, 10],
      [21, 8],
      [22, 11],
      [23, 9],
      [24, 7],
      [24, 4],
      [26, 3],
      [29, 6],
      [30, 5],
      [31, 7],
      [32, 8],
      [33, 9],
      [34, 12],
      [35, 10],
      [36, 13],
      [37, 11],
      [38, 15],
      [39, 14],
      [40, 12],
      [41, 15],
      [42, 17],
      [43, 15],
      [44, 16],
  ];

  var curvedLineOptions = {
      series: {
          curvedLines: {
              active: true,
          },
          shadowSize: 0,
          lines: {
              show: true,
              lineWidth: 2,
              fill: false
          },
      },
      
      grid: {
          borderWidth: 0,
          labelMargin: 0,
      },
      yaxis: {
          show: false,
          min: 0,
          max: 45,
          position: "left",
          ticks: [
              [0, '10'],
              [10, '14'],
              [20, '20'],
              [30, '25']
          ],
          tickColor: '#e9e6e6',
          tickLength: 1,
      },
      xaxis: {
          show: true,
          position: "bottom",
          ticks: [
              [0, '2'],
              [7, '4'],
              [14, '6'],
              [21, '8'],
              [28, '10'],
              [35, '12'],
              [41, '14'],
              [48, '18'],
              [56, '20'],
              [63, '22'],
              [70, '24'],
              [77, '26'],
              [84, '28']
          ],
          tickColor: '#e9e6e6',
      },
      legend: {
          noColumns: 4,
          container: $("#legendContainer"),
      }
  }
$.plot($("#flotChart"), [{
  data: d1,
  curvedLines: {
      apply: true ,
      tension: .02,
  },
  points: {
      show: false,
      fillColor: '#fff',
  },
  color: '#17c964',
  lines: {
      show: true, 
      fill: true,
      fillColor: "rgba(242, 250, 247, .5)"
  },
  label: 'This year',
  stack: true,
},
{
  data: d2,
  curvedLines: {
      apply: true 
  },
  points: {
    show: false,
    fillColor: 'rgba(223, 236, 238,.5)',
},
  color: '#2517c9',
  lines: {
    show: true, 
    fill: true,
    fillColor: 'rgba(223, 236, 238,.5)',
},
  label: 'Past year',
  stack: true,
}
], curvedLineOptions);
}
if ($("#flotChart-dark").length) {
  var d1 = [
      [0,36.04],
      [1, 36],
      [2, 35],
      [3, 39],
      [4, 39],
      [5, 39],
      [6, 37],
      [7, 36],
      [8, 37],
      [9, 34],
      [10, 36],
      [11, 38],
      [12, 37],
      [13, 39],
      [14, 38],
      [15, 39],
      [16, 37],
      [17, 35],
      [18, 36],
      [19, 34],
      [20, 32],
      [21, 39],
      [22, 38],
      [23, 30],
      [24, 30],
      [24, 36],
      [26, 35],
      [29, 39],
      [30, 30],
      [31, 32],
      [32, 33],
      [33, 32],
      [34, 35],
      [35, 34],
      [36, 33],
      [37, 36],
      [38, 35],
      [39, 36],
      [40, 35],
      [41, 34],
      [42, 35],
      [43, 37],
      [44, 38],
      
  ];
  var d2 = [
      [0,12.68],
      [1, 12],
      [2, 15],
      [3, 19],
      [4, 19],
      [5, 19],
      [6, 17],
      [7, 16],
      [8, 17],
      [9, 14],
      [10, 16],
      [11, 18],
      [12, 17],
      [13, 19],
      [14, 18],
      [15, 19],
      [16, 17],
      [17, 15],
      [18, 16],
      [19, 14],
      [20, 10],
      [21, 8],
      [22, 11],
      [23, 9],
      [24, 7],
      [24, 4],
      [26, 3],
      [29, 6],
      [30, 5],
      [31, 7],
      [32, 8],
      [33, 9],
      [34, 12],
      [35, 10],
      [36, 13],
      [37, 11],
      [38, 15],
      [39, 14],
      [40, 12],
      [41, 15],
      [42, 17],
      [43, 15],
      [44, 16],
  ];

  var curvedLineOptions = {
      series: {
          curvedLines: {
              active: true,
          },
          shadowSize: 0,
          lines: {
              show: true,
              lineWidth: 3,
              fill: false
          },
      },
      
      grid: {
          borderWidth: 0,
          labelMargin: 0,
      },
      yaxis: {
          show: false,
          min: 0,
          max: 45,
          position: "left",
          ticks: [
              [0, '10'],
              [10, '14'],
              [20, '20'],
              [30, '25']
          ],
          tickColor: '#e9e6e6',
          tickLength: 1,
      },
      xaxis: {
          show: true,
          position: "bottom",
          ticks: [
              [0, '2'],
              [7, '4'],
              [14, '6'],
              [21, '8'],
              [28, '10'],
              [35, '12'],
              [41, '14'],
              [48, '18'],
              [56, '20'],
              [63, '22'],
              [70, '24'],
              [77, '26'],
              [84, '28']
          ],
          tickColor: '#222222',
      },
      legend: {
          noColumns: 4,
          container: $("#legendContainer"),
      }
  }
$.plot($("#flotChart-dark"), [{
  data: d1,
  curvedLines: {
      apply: true ,
      tension: .02,
  },
  points: {
      show: false,
      fillColor: '#fff',
  },
  color: '#17c964',
  lines: {
      show: true, 
      fill: true,
      fillColor: "rgba(31, 33, 48)"
  },
  label: 'This year',
  stack: true,
},
{
  data: d2,
  curvedLines: {
      apply: true 
  },
  points: {
    show: false,
    fillColor: 'rgba(0, 0, 0,.5)',
},
  color: '#2517c9',
  lines: {
    show: true, 
    fill: true,
    fillColor: "rgba(31, 33, 48)",
},
  label: 'Past year',
  stack: true,
}
], curvedLineOptions);
}
  });
})(jQuery);