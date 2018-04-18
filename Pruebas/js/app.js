$(document).ready(function(){
	$.ajax({
		url: 'getMACS.php',
			type: 'post',
			datatype: 'json',
			data: {'method':'getNumberofMACS'},
			success:  function (response) {
				$('#macsTotales').text(response);
			}
	});
	loadMACSBetween();
	


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


	$("#plot_button").click(function() {
		$.ajax({
			url: 'getMACS.php',
			type: 'post',
			datatype: 'json',
			data: {'method':'RSSIfromMAC','MAC':$("#macSelect").val(),'fecha_desde':$("#fecha_desde").val(),'fecha_hasta':$("#fecha_hasta").val()},
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
							label: "(-1)*rssi",
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
			
	});

	function loadMACSBetween() {

		$.ajax({
			url: 'getMACS.php',
				type: 'post',
				datatype: 'json',
				data: {'method':'getNumbersNews'},
				success:  function (response) {
					$('#novedades').text(response);
				}
		});
		$.ajax({
			url: 'getMACS.php',
				type: 'post',
				datatype: 'json',
				data: {'method':'getNumberofMACS'},
				success:  function (response) {
					$('#macsTotales').text(response);
				}
		});

		setTimeout(loadMACSBetween, 3000); // you could choose not to continue on failure...
	}

});



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