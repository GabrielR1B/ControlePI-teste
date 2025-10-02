var chart1;
var chart2;
var chart3;
var chart4;
var chart5;
//Variáveis para o gráfico "misto"
var patentes;
var marcas;
var knowhows;
var softwares;
var categoriasAno;

// globally available
$(document).ready(function() {
	
	/*
    var options1 = {
	    chart: {
	        renderTo: 'grafico1',
	        defaultSeriesType: 'column',
					margin: [ 50, 50, 100, 80],
		      plotBackgroundColor: 'rgba(255, 255, 255, .9)',
		      plotShadow: true,
		      plotBorderWidth: 1,
					backgroundColor: '#FFFFFF',
					shadow: false,
					plotShadow: false
	    },
	    title: {
	        text: 'Número de patentes por ano'
	    },
	    xAxis: {
	        categories: [],
					labels: {
	          rotation: -45,
	          align: 'right',
	          style: {
	              font: 'normal 13px Verdana, sans-serif'
	          }
		       }
	    },
	    yAxis: {
	        title: {
	            text: 'Patentes Requeridas'
	        },
		      minorTickInterval: 'auto',
		      lineColor: '#000',
		      lineWidth: 1,
		      tickWidth: 1,
		      tickColor: '#000',
	    },
		 	plotOptions: {
		        series: {
		            shadow: false
		        }
		  },
	    legend: {
         enabled: false
      },
      
      // tooltip: {
      //    formatter: function() {
      //       return '<b>'+ this.x +'</b><br/>'+
      //           'Número de depósitos: '+ Highcharts.numberFormat(this.y,0);
      //    }
      // },

      	tooltip:false,
	    series: [{
				dataLabels: {
				            enabled: true,
				            rotation: 0,
										color: '#000',
				            x: -3,
				            y: -5,
				            formatter: function() {
				               return this.y;
				            },
				            style: {
				            	font: 'normal 10px Verdana, sans-serif',
				            }
				         }
			}]
	};

	$.ajax({
	    type: 'GET',
	    url: base_url + '/graficos/patentesPorAno',
	    dataType: 'json',
	    error: function(data) {
	      },
	    success: function(data) {
			var series = { data:[] };
			options1.series[0].name = 'patentes';
			options1.series[0].data = data.series;
			options1.xAxis.categories = data.categorias;
			chart1 = new Highcharts.Chart(options1);
			$('#grafico1 tspan:contains(High)').hide();
	    } //success
	});	//ajax
  */
	
	/////////////////
	
	var options2 = {
    chart: {
       renderTo: 'grafico2',
       plotBackgroundColor: null,
       plotBorderWidth: null,
       plotShadow: false
    },
    title: {
       text: 'Patentes por área'
    },
    // tooltip: {
    //    formatter: function() {
    //       return '<b>'+ this.point.name +'</b>: '+ this.y;
    //    }
    // },
    tooltip: false,

    exporting: {
              sourceWidth: 900,
              sourceHeight: 500
            },

    plotOptions: {
       pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
             enabled: true,
             color: '#000000',
             connectorColor: '#000000',
             formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ this.y;
             }
          }
       }
    },

     series: [{
       type: 'pie',
       name: 'Patentes por áreassss',
       data: []
    }]
	};

	$.ajax({
	    type: 'GET',
	    url: base_url + '/graficos/patentesPorArea',
	    dataType: 'json',
	    error: function(data) {
	      },
	    success: function(data) {
				options2.series[0].data = data.dados;
	      chart2 = new Highcharts.Chart(options2);
				$('#grafico2 tspan:contains(High)').hide();
	    } //success
	});	//ajax

	/////////////////
	
	var options3 = {
    chart: {
       renderTo: 'grafico3',
       plotBackgroundColor: null,
       plotBorderWidth: null,
       plotShadow: false
    },
    title: {
       text: 'Patentes por unidade'
    },
    // tooltip: {
    //    formatter: function() {
    //       return '<b>'+ this.point.name +'</b>: '+ this.y;
    //    }
    // },
    tooltip: false,

    plotOptions: {
       pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          events: {
              click: function(event) {
              	//window.location((event.point.config)[2]);
//              	var id = (event.point.config)[2]);
				//event.point.config)[2];
				var id = (event.point.config)[2];
              	window.location = "./graficoUnidade/";
              }
          },
          dataLabels: {
             enabled: true,
             color: '#000000',
             connectorColor: '#000000',
             formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ this.y;
             }
          }
       }
    },

    exporting: {
              sourceWidth: 900,
              sourceHeight: 500
            },

     series: [{
       type: 'pie',
       name: 'Patentes por unidade',
       data: []
    }]
	
	};

	$.ajax({
	    type: 'GET',
	    url: base_url + '/graficos/patentesPorUnidade',
	    dataType: 'json',
	    error: function(data) {
	      },
	    success: function(data) {
				options3.series[0].data = data.dados;
	      chart3 = new Highcharts.Chart(options3);
				$('#grafico3 tspan:contains(High)').hide();
	    } //success
	});	//ajax


////////////////


	var options4 = {
    chart: {
       renderTo: 'grafico4',
       plotBackgroundColor: null,
       plotBorderWidth: null,
       plotShadow: false
    },
    title: {
       text: 'Patentes por departamento'
    },
    // tooltip: {
    //    formatter: function() {
    //       return '<b>'+ this.point.name +'</b>: '+ this.y;
    //    }
    // },
    tooltip: false,

    exporting: {
              sourceWidth: 900,
              sourceHeight: 500
    },

    plotOptions: {
       pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          events: {
              click: function(event) {
              	//window.location((event.point.config)[2]);
//              	var id = (event.point.config)[2]);
				//event.point.config)[2];
				var id = (event.point.config)[2];
              	window.location = "./graficoUnidade/";
              }
          },
          dataLabels: {
             enabled: true,
             color: '#000000',
             connectorColor: '#000000',
             formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ this.y;
             }
          }
       }
    },

     series: [{
       type: 'pie',
       name: 'Patentes por departamento',
       data: []
    }]
	
	};

	$.ajax({
	    type: 'GET',
	    url: base_url + '/graficos/patentesPorDepartamento',
	    dataType: 'json',
	    error: function(data) {
	      },
	    success: function(data) {
				options4.series[0].data = data.dados;
	      chart4 = new Highcharts.Chart(options4);
				$('#grafico4 tspan:contains(High)').hide();
	    } //success
	});	//ajax

  ////////////////

  $(carregaGrafico(3));
  $("#numMin").keyup(function(){
    if ($(this).val() != '') {
      carregaGrafico($(this).val());
    }
  });

  ////////////////

  $.ajax({
        type: 'GET',
        async: false,
        url: base_url + '/graficos/patentesPorAno',
        dataType: 'json',
        error: function(data) {
          },
        success: function(data) {
          patentes = data.series;
          categoriasAno = data.categorias;
        } //success
    }); //ajax

  $('#grafico1').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Patentes por Ano'
            },
            xAxis: {
                categories: categoriasAno
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Número de Pedidos'
                },
                stackLabels: {
                    enabled: false,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                x: -340,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    color: 'orange',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                          if (this.y > 0) {
                            return this.y;
                          } else {
                            return '';
                          }
                        },
                        style: {
                          fontWeight:'bold'
                        },
                        y: -18,
                        verticalAlign: 'top',
                        crop: false,
                        overflow: 'none',
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
                    }
                }
            },
            exporting: {
              sourceWidth: 900,
              sourceHeight: 500
            },
            series: [{
                name: 'Patentes',
                data: patentes
            }]
        });

});

////////////////

    $.ajax({
        type: 'GET',
        async: false,
        url: base_url + '/graficos/marcasPorAno',
        dataType: 'json',
        error: function(data) {
          },
        success: function(data) {
          marcas = data.series;
        } //success
    }); //ajax

    $.ajax({
        type: 'GET',
        async: false,
        url: base_url + '/graficos/patentesPorAno',
        dataType: 'json',
        error: function(data) {
          },
        success: function(data) {
          patentes = data.series;
          categoriasAno = data.categorias;
        } //success
    }); //ajax

    $.ajax({
        type: 'GET',
        async: false,
        url: base_url + '/graficos/knowhowsPorAno',
        dataType: 'json',
        error: function(data) {
          },
        success: function(data) {
          knowhows = data.series;
        } //success
    }); //ajax

    $.ajax({
        type: 'GET',
        async: false,
        url: base_url + '/graficos/softwaresPorAno',
        dataType: 'json',
        error: function(data) {
          },
        success: function(data) {
          softwares = data.series;
        } //success
    }); //ajax

    $.ajax({
        type: 'GET',
        async: false,
        url: base_url + '/graficos/desenhosPorAno',
        dataType: 'json',
        error: function(data) {
          },
        success: function(data) {
          desenhos = data.series;
        } //success
    }); //ajax


function carregaGrafico(numMin) {

        $('#grafico6').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Propriedade Intelectual por Ano'
            },
            xAxis: {
                categories: categoriasAno
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Número de Pedidos'
                },
                stackLabels: {
                    enabled: false,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                verticalAlign: 'top',
                x: -295,
                y: 20,
                floating: true,
                layout: 'vertical',
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                          if (this.y >= numMin) {
                            return this.y;
                          } else {
                            return '';
                          }
                        },
                        style: {
                          fontWeight:'bold'
                        },
                        x: 18,
                        crop: false,
                        overflow: 'none',
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
                    }
                }
            },
            exporting: {
              sourceWidth: 900,
              sourceHeight: 500
            },
            series: [{
                name: 'Knowhow',
                data: knowhows,
                color: '#3299CC'
            }, {
                name: 'Softwares',
                data: softwares,
                color: '#426F42'
            }, {
                name: 'Desenhos Industriais',
                data: desenhos,
                color: '#6B238E'
            }, {
                name: 'Marcas',
                data: marcas,
                color: '#CC0000'
            }, {
                name: 'Patentes',
                data: patentes,
                color: 'orange'
            }]
        });
    }







	