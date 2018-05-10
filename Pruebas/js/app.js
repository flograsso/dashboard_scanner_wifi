
$(document).ready(function(){

	var lastRSSIPlotMethod = "plotFromSelect";
	var monitoreando = false;
	Chart.defaults.global.animation.duration = 0;


	loadMACSBetween();
	plotChannelsBar();
	macVendorTable();
	

	//Reploteo si cambia el device
	$("#deviceSelect").change(function() {
		loadMACSBetween();
		plotChannelsBar();
		macVendorTable();
		plotFromSelectBox();
	});

	$("#fecha_desde").change(function() {
		loadMACSBetween();
		plotChannelsBar();
		macVendorTable();
		plotFromSelectBox();

	});

	$("#fecha_hasta").change(function() {
		loadMACSBetween();
		plotChannelsBar();
		macVendorTable();
		plotFromSelectBox();

	});





function checkNewsNotFreeze()
{

}

function freezeEnviroment()
{
	$.ajax({
		url: 'getMACS.php',
		type: 'post',
		datatype: 'json',
		data: 	{
					'method':'congelarEntorno'
				},
		beforeSend: function () {
			$('#imgLoading').show();
			$('#monitorear').hide();
		},
		complete: function () {
			$("#imgLoading").hide();
			$('#monitorear').show();
		},
		success:  function (response) {
			var cadena = "<b>Cantidad de MACs Congeladas: </b>"+response;
			$("#cantMACCongeladas").html(cadena);
			
		
		}
	});
}

function addEnviroment()
{
	$.ajax({
		url: 'getMACS.php',
		type: 'post',
		datatype: 'json',
		data: 	{
					'method':'agregarEntorno'
				},
		beforeSend: function () {
			$('#imgLoading').show();
		},
		complete: function () {
			$("#imgLoading").hide();
		},
		success:  function (response) {
				
			myObj = JSON.parse(response);
			var cadena = "<b>MACs Agregadas: </b>"+myObj.agregados+"<b> MACs Repetidas: </b>"+myObj.repetidos;
			$("#cantMACCongeladas").html(cadena);
		
		}
		
	});
}

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

	function plotFromSelectBox()
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

		var plotrssi;
		plotRSSILine("plotrssi",datas,plotrssi);
		getMacLastChannel(datas.MAC);
		getMacVendor(datas.MAC);
		setTimeout(plotFromSelectBox, 3000);
    

	}


	function plotRSSILine(_plotId,_datas,_graphObject)
	{	
		$.ajax({
			url: 'getMACS.php',
			type: 'post',
			datatype: 'json',
			data: _datas,
			success:  function (response) {
				
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
					data: 
					{
						labels:time,
						datasets: 
							[{
							data: rssi,
							label: "rssi+100",
							backgroundColor: "rgba(241, 0, 0, 1)",
							borderColor: "rgba(241, 0, 0, 1)",
							fill:false,
							
						}],
					},
					options: {
						scales: {
							xAxes: [{
								type: 'time',
								
								
				
							}]	

						}
					}
				};

				var ctx = $('#'+_plotId);
				//Esta linea es para que el grafico no muestre valores viejos. (una especie de lag)
				_graphObject && _graphObject.chart && _graphObject.chart.destroy();
				_graphObject = new Chart(ctx,chartdata);

			}
		});


	}

	$("#monitorear").click(function() 
	{
		$("#monitorear").attr("disabled", true);
		monitoreando=true;

		$.ajax({
			url: 'getMACS.php',
				type: 'post',
				datatype: 'json',
				data: {'method':'checkNewsNotFreeze'},
				success:  function (response) {
					myObj = JSON.parse(response);
					var i = 0;

					datas  =
					{
						'method': 'RSSIfromMAC',
						'fecha_desde':$("#fecha_desde").val(),
						'fecha_hasta':$("#fecha_hasta").val(),
						'device':$("#deviceSelect").val()
					};

					for (x in myObj) {
						datas.MAC=myObj[x].MAC;
						$("#fila1").append('<div  class="col-sm"> <div id="chart-container"><canvas id="plotrssi'+i+'"></canvas></div></div>');
						plotRSSILine("plotrssi"+i,datas);
						i++;
					}
					
				
					
					
				
			
	
				}
		});



	});

	$("#congelar").click(function() 
	{
		freezeEnviroment();

	});

	$("#agregarEntorno").click(function() 
	{
		addEnviroment();

	});

	$("#plot_button").click(function() 
	{
		lastRSSIPlotMethod="plotFromSelect";
		plotFromSelectBox();

	});

	$("#plot_button_from_search").click(function() 
	{
		lastRSSIPlotMethod="plotFromSearch";
		plotFromSelectBox();
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