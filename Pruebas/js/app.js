
$(document).ready(function(){

	var lastRSSIPlotMethod = "plotFromSelect";
	Chart.defaults.global.animation.duration = 0;


	loadMACSBetween();
	plotChannelsBar();
	macVendorTable();
	

	//Reploteo si cambia el device
	$("#deviceSelect").change(function() {
		loadMACSBetween();
		plotChannelsBar();
		macVendorTable();
		plotRSSILine();
	});

	$("#fecha_desde").change(function() {
		loadMACSBetween();
		plotChannelsBar();
		macVendorTable();
		plotRSSILine();

	});

	$("#fecha_hasta").change(function() {
		loadMACSBetween();
		plotChannelsBar();
		macVendorTable();
		plotRSSILine();

	});



	/*	
	$.ajax({
		
		url: "http://localhost:8088/boot/pruebas/data.php",
		method: "GET",
		success: function(data) {
			console.log(data);
			var rssi = [];

			for(var i in data) {
				rssi.push((-1)*Number(data[i].rssi));
				console.log(rssi[i]);

			}



			var ctx = $("#mycanvas");
			var myLineChart = new Chart(ctx, {
			  type: 'line',
			  data: {
			    labels: ["a","b","c"],
			    datasets: [{	

			      backgroundColor: "rgba(2,117,216,0.2)",
			      borderColor: "rgba(2,117,216,1)",

			      pointBackgroundColor: "rgba(2,117,216,1)",
			      pointBorderColor: "rgba(255,255,255,0.8)",

			      pointHoverBackgroundColor: "rgba(2,117,216,1)",

			      data:rssi,
			    }],
			  },
			  options: {

			  }
			});

		},
		error: function(data) {
			console.log("data");
			
		}
	});
*/
	$("#busqueda_MAC").keyup(function() {
		var valor=$("#busqueda_MAC").val();
		$("#livesearch").html("");
		$("#plot_button_from_search").hide();
		$("#plot_button").show();
		if (valor.length < 2 || valor=="")
		{
			$("#livesearch").html("");
		}
		else
		{
			$.ajax({
				url: 'getMACS.php',
				type: 'post',
				datatype: 'json',
				data: 	{
						'method':'searchMAC',
						'MAC':valor
						},
				success:  function (response) 
				{
					var cadena = "";
					var count = 1;
					cadena='<table class="table table-bordered""><tr">';
					myObj = JSON.parse(response);
					for (x in myObj) {
							cadena=cadena+"<td>"+(myObj[x].MAC)+"</td>";
							if((count % 5) == 0){
								cadena=cadena+"</tr><tr>";
							}
							count++;
					}
					cadena=cadena+"</tr></table>";

					$("#livesearch").html(cadena);
					$("#plot_button_from_search").show();
					$("#plot_button").hide();
					
				}	
			});
		}


	});




	function plotRSSILine()
	{	
		
		datas  =
		{
			'method': 'RSSIfromMAC',
			'fecha_desde':$("#fecha_desde").val(),
			'fecha_hasta':$("#fecha_hasta").val(),
			'device':$("#deviceSelect").val()
		};
	
		if (lastRSSIPlotMethod == "plotFromSelect")
		{
			datas.MAC=$("#macSelect").val();
		}
		else
		{
			datas.MAC=$("#busqueda_MAC").val();
		}

		

		$.ajax({
			url: 'getMACS.php',
			type: 'post',
			datatype: 'json',
			data: datas,
			success:  function (response) {
				//console.log(response);
				
				var time = []
				var rssi = [];				
				myObj = JSON.parse(response);
        		for (x in myObj) {
						time.push(myObj[x].time);
						rssi.push(100+Number(myObj[x].rssi));
				}

				var chartdata = 
				{
					type: 'line',
					data: {
						labels:time,
						datasets: [{
							data: rssi,
							label: "rssi+100",
							backgroundColor: "rgba(241, 0, 0, 1)",
							borderColor: "rgba(241, 0, 0, 1)",
							fill:false,
							
						}],
						/*
						datasets: [{
							label: "Sessions",
							lineTension: 0.3,
							backgroundColor: "rgba(2,117,216,0.2)",
							borderColor: "rgba(2,117,216,1)",
							pointRadius: 5,
							pointBackgroundColor: "rgba(2,117,216,1)",
							pointBorderColor: "rgba(255,255,255,0.8)",
							pointHoverRadius: 5,
							pointHoverBackgroundColor: "rgba(2,117,216,1)",
							pointHitRadius: 20,
							pointBorderWidth: 2,
							data: rssi,
						}],
						*/
					},
					options: {
						scales: {
							xAxes: [{
								time: {
									unit: 'date'
								},
								ticks: {
									maxTicksLimit: 1000
								}
							}]

						}
						/*
						scales: {
							xAxes: [{
								time: {
									unit: 'date'
								},
								gridLines: {
									display: false
								},
								ticks: {
									maxTicksLimit: 200
								}
							}],
							yAxes: [{
								ticks: {
									min: 0,
									max: 100,
									maxTicksLimit: 200
								},
								gridLines: {
									color: "rgba(0, 0, 0, .125)",
								}
							}],
						},
						legend: {
							display: false
						}
						*/
					}
				};

				var ctx = $('#plotrssi');
				//Esta linea es para que el grafico no muestre valores viejos. (una especie de lag)
				plotrssi && plotrssi.chart && plotrssi.chart.destroy();
				plotrssi = new Chart(ctx,chartdata);

			}
		});
		getMacLastChannel(datas.MAC);
		getMacVendor(datas.MAC);
		setTimeout(plotRSSILine, 3000);

	}

	$("#plot_button").click(function() 
	{
		lastRSSIPlotMethod="plotFromSelect";
		plotRSSILine();

	});

	$("#plot_button_from_search").click(function() 
	{
		lastRSSIPlotMethod="plotFromSearch";
		plotRSSILine();
	});


	function loadMACSBetween() {

		$.ajax({
			url: 'getMACS.php',
				type: 'post',
				datatype: 'json',
				data: {'method':'getNumberofMACS','device':$("#deviceSelect").val(),'fecha_desde':$("#fecha_desde").val(),'fecha_hasta':$("#fecha_hasta").val()},
				success:  function (response) {
					$('#macsTotales').text(response);
				}
		});

		$.ajax({
			url: 'getMACS.php',
				type: 'post',
				datatype: 'json',
				data: {'method':'getNumbersNews','device':$("#deviceSelect").val()},
				success:  function (response) {
					$('#novedades').text(response);
				}
		});

		setTimeout(loadMACSBetween, 3000); // you could choose not to continue on failure...
	}



});



function plotChannelsBar()
{
	$.ajax({
		url: 'getMACS.php',
		type: 'post',
		datatype: 'json',
		data: 	{
					'method':'getChannels',
					'device':$("#deviceSelect").val(),
					'fecha_desde':$("#fecha_desde").val(),
					'fecha_hasta':$("#fecha_hasta").val()
				},
		success:  function (response) {
			console.log(response);
			var channel = []
			var count = [];				
			myObj = JSON.parse(response);
			for (x in myObj) {
				channel.push(myObj[x].channel);
				count.push(Number(myObj[x].count));
			}

			var chartdata = 
			{
				type: 'bar',
				data: {
					labels:channel,
	
					datasets: [{
						data: count,
						label: "Paquetes",
						
					}],
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}],
					}
				}
			};

			var ctx = $('#plotchannels');
			//Esta linea es para que el grafico no muestre valores viejos. (una especie de lag)
			plotchannels && plotchannels.chart && plotchannels.chart.destroy();
			plotchannels = new Chart(ctx,chartdata);

		}
	});

	setTimeout(plotChannelsBar, 3000); // you could choose not to continue on failure...
}

function getMacVendor(_MAC)
{
	$.ajax({
		url: 'getMACS.php',
		type: 'post',
		datatype: 'json',
		data: 	{
					'method':'getVendorFromMAC',
					'device':$("#deviceSelect").val(),
					'MAC':_MAC
				},
		success:  function (response) {
						
			myObj = JSON.parse(response);
			var vendor=myObj[0].mac_vendor;
			var cadena = "<b>MAC vendor: </b>"+vendor;
			$("#macVendor").html(cadena);
		}
	});
}

function getMacLastChannel(_MAC)
{
	$.ajax({
		url: 'getMACS.php',
		type: 'post',
		datatype: 'json',
		data: 	{
					'method':'getlastChannelFromMAC',
					'device':$("#deviceSelect").val(),
					'MAC':_MAC
				},
		success:  function (response) {
			myObj = JSON.parse(response);
			var channel=myObj[0].channel;
			var cadena = "<b>Last Channel: </b>"+channel;
			$("#lastChannel").html(cadena);
		}
	});
}

function macVendorTable()
{
	$.ajax({
		url: 'getMACS.php',
		type: 'post',
		datatype: 'json',
		data: 	{
					'method':'getStatsVendors',
					'device':$("#deviceSelect").val(),
					'fecha_desde':$("#fecha_desde").val(),
					'fecha_hasta':$("#fecha_hasta").val()
				},
		success:  function (response) {
			console.log($("#deviceSelect").val());
	

			var cadena = "";
			cadena='<table class="table table-striped">';
			cadena=cadena+'<thead><tr><th>Vendor</th><th>Count</th></tr></thead>';
			cadena=cadena+'<tbody>'
			myObj = JSON.parse(response);
			for (x in myObj) {
					cadena=cadena+'<tr>'
					cadena=cadena+"<td>"+(myObj[x].mac_vendor)+"</td>";
					cadena=cadena+"<td>"+(myObj[x].count)+"</td>";
					cadena=cadena+'</tr>';
					
			}
			cadena=cadena+"</tbody></table>";

			$("#macVendorTable").html(cadena);

		}
	});
	setTimeout(macVendorTable, 6000); // you could choose not to continue on failure...
		
}

function plotChannelsPie()
{
	$.ajax({
		url: 'getMACS.php',
		type: 'post',
		datatype: 'json',
		data: {'method':'getChannels'},
		success:  function (response) {
			console.log(response);
			var channel = []
			var count = [];				
			myObj = JSON.parse(response);
			for (x in myObj) {
				channel.push(myObj[x].channel);
				count.push(Number(myObj[x].count));
			}

			var chartdata = 
			{
				type: 'pie',
				data: {
					labels:channel,
	
					datasets: [{
						data: count,
					}],
				}

			};

			var ctx = $('#plotchannels');
			//Esta linea es para que el grafico no muestre valores viejos. (una especie de lag)
			plotchannels && plotchannels.chart && plotchannels.chart.destroy();
			plotchannels = new Chart(ctx,chartdata);

		}
	});
		
}



/*
$(document).ready(function(){
	$("#macSelect").change(function(){
		alert("Valor seleccionado" + $(this).val());
		$.ajax({
			url: 'data.php',
			type:  'post',
			success:  function (response) {
				alert("Ejecutado");
				console.log(response);
			}
		});
	});

});
*/