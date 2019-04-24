//Maiores Vendedores
$(document).ready(function () {
	var dataurl = "diretorio/maioresvendedores.json";
	$.ajax({
        url: dataurl,
        type: "GET",
        dataType: "json",
        success: function(retorno){
            var options = {
                series: {
                    pie: {
                        innerRadius: 0.5,
                        show: true
                    }
                },
                legend: {
                    show: false
                },
                colors: ['#FA5833', '#2FABE9', '#78CD51']};
            data = retorno ;
            $.plot("#donutchart", data, options);
        },
        error: function(request, status, erro) {
            alert("Problema ocorrido: " + status + "\nDescição: " + erro);
            
            //header do conteudo requisitado para confirmação de setagem correta
            alert("Informações da requisição: \n" + request.getAllResponseHeaders());

            $("h2").html("O servidor não conseguiu processar o pedido");
        }    
	});
});

//Melhores Clientes
$(document).ready(function () {
	//var dataurl = "../diretorio/melhoresclientes.json";
	var dataurl = "config/alexandre.json";
	$.ajax({
        url: dataurl,
        type: "GET",
        dataType: "json",
        success: function(retorno){
            var options = {
                series: {
                    pie: {
                        innerRadius: 0.5,
                        show: true
                    }
                },
                legend: {
                    show: false
                },
                colors: ['#FA5833', '#2FABE9', '#78CD51']};
            data = retorno ;
            $.plot("#outrochart", data, options);
        },
        error: function(request, status, erro) {
            alert("Problema ocorrido: " + status + "\nDescição: " + erro);
            
            //header do conteudo requisitado para confirmação de setagem correta
            alert("Informações da requisição: \n" + request.getAllResponseHeaders());

            $("h2").html("O servidor não conseguiu processar o pedido");
        }    
	});
});

//Vendas mensais
$(document).ready(function () {
	var dataurl = "diretorio/vendasmensais.json";
	$.ajax({
        url: dataurl,
        type: "GET",
        dataType: "json",
        success: function(retorno){
            var options = {
             series: {
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			}};
            data = retorno ;
            $.plot("#barrachart", [data], options);
        },
        error: function(request, status, erro) {
            alert("Problema ocorrido: " + status + "\nDescição: " + erro);
            
            //header do conteudo requisitado para confirmação de setagem correta
            alert("Informações da requisição: \n" + request.getAllResponseHeaders());
            $("h2").html("O servidor não conseguiu processar o pedido");
        }    
	});
});

//Previsto x Realizado
$(document).ready(function () {
	var dataurl = "diretorio/previstorealizado.json";
	$.ajax({
        url: dataurl,
        type: "GET",
        dataType: "json",
        success: function(retorno){
            var options = {
                    series: {
				        lines: {
                            show: true,
                        },
                        points:{show:true}
                    },
                    legend:{
                         position: "ne",
                    },
                };
            var data = retorno;
            $.plot("#chart1", data, options);
        },
        error: function(request, status, erro) {
            alert("Problema ocorrido: " + status + "\nDescição: " + erro);
            
            //header do conteudo requisitado para confirmação de setagem correta
            alert("Informações da requisição: \n" + request.getAllResponseHeaders());

            $("h2").html("O servidor não conseguiu processar o pedido");
        }    
	});
});

//Previsto x Realizado com acompanhamento
$(document).ready(function () {
	var dataurl = "diretorio/lixo.json";
	$.ajax({
        url: dataurl,
        type: "GET",
        dataType: "json",
        success: function(retorno){
            var options = {
                    series: {
				        lines: {
                            show: true,
                        },
                        points:{show:true}
                    },
                    legend:{
                         position: "ne",
                    },
                    crosshair: {
                        mode: "x"
                    },
                    grid: {
                        hoverable: true,
                        autoHighlight: false
			        },
                    yaxis: {
				        min: 0,
				        max: 30
			         }
                };
            var data = retorno;
            
            plot = $.plot("#chart2", data, options);
            
            var legends = $("#chart2 .legendLabel");

            legends.each(function () {
            // fix the widths so they don't jump around
            $(this).css('width', $(this).width());
        });

            var updateLegendTimeout = null;
            var latestPosition = null;

            function updateLegend() {

            updateLegendTimeout = null;

			var pos = latestPosition;

			var axes = plot.getAxes();
			if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max ||
				pos.y < axes.yaxis.min || pos.y > axes.yaxis.max) {
				
                return;
			}

			var i, j, dataset = plot.getData();
			for (i = 0; i < dataset.length; ++i) {

				var series = dataset[i];

				for (j = 0; j < series.data.length; ++j) {
					if (series.data[j][0] > pos.x) {
						break;
					}
				}

                var y,
					p1 = series.data[j - 1],
					p2 = series.data[j];

				if (p1 == null) {
					y = p2[1];
				} else if (p2 == null) {
					y = p1[1];
				} else {
					y = p1[1] + (p2[1] - p1[1]) * (pos.x - p1[0]) / (p2[0] - p1[0]);
				}

				legends.eq(i).text(series.label.replace(/=.*/, "= " + y.toFixed(0)));
			}
		}
            
            $("#chart2").bind("plothover",  function (event, pos, item) {
			latestPosition = pos;
			if (!updateLegendTimeout) {
				updateLegendTimeout = setTimeout(updateLegend, 50);
			}
		});
        },
        error: function(request, status, erro) {
            alert("Problema ocorrido: " + status + "\nDescição: " + erro);
            
            //header do conteudo requisitado para confirmação de setagem correta
            alert("Informações da requisição: \n" + request.getAllResponseHeaders());

            $("h2").html("O servidor não conseguiu processar o pedido");
        }    
	});
});

//Previsto x Realizado com interacao
$(document).ready(function () {
	var dataurl = "diretorio/lixo.json";
	$.ajax({
        url: dataurl,
        type: "GET",
        dataType: "json",
        success: function(retorno){
            var options = {
                    series: {
				        lines: {show: true},
                        points:{show:true}
                    },
                    legend:{position: "nw"},
                    grid: {
                        hoverable: true,
                        clickable: true
                    },
                    yaxis: {
                        min: 0,
                        max: 35
                    }
                };
            var data = retorno;

            var plot = $.plot("#chart3", data, options);

    		$("<div id='tooltip'></div>").css({
			position: "absolute",
			display: "none",
			border: "1px solid #fdd",
			padding: "2px",
			"background-color": "#fee",                
			opacity: 0.80
		}).appendTo("body");

            $("#chart3").bind("plothover", function (event, pos, item) {

                var str = "(" + pos.x.toFixed(2) + ", " + pos.y.toFixed(2) + ")";
                $("#hoverdata").text(str);

                if (item) {
                    var x = item.datapoint[0].toFixed(0),
						y = item.datapoint[1].toFixed(0);

                    $("#tooltip").html(item.series.label + y)
                        .css({top: item.pageY+5, left: item.pageX+5})
						.fadeIn(200);
                }
		});

            $("#chart3").bind("plotclick", function (event, pos, item) {
                if (item) {
                    $("#clickdata").text(" - click point " + item.dataIndex + " in " + item.series.label);
                    plot.highlight(item.series, item.datapoint);
                }
            });
    
        },
        error: function(request, status, erro) {
            alert("Problema ocorrido: " + status + "\nDescição: " + erro);
            
            //header do conteudo requisitado para confirmação de setagem correta
            alert("Informações da requisição: \n" + request.getAllResponseHeaders());

            $("h2").html("O servidor não conseguiu processar o pedido");
        }    
	});
});