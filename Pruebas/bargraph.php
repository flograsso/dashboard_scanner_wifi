<html>
    <head>
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <title>ChartJS - BarGraph</title>
        <style type="text/css">
            #chart-container {
                width: auto;
                height: auto;
            }
        </style>
        <!-- Bootstrap core CSS-->
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link
            href="../vendor/font-awesome/css/font-awesome.min.css"
            rel="stylesheet"
            type="text/css">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm">

                    <label for="sel1">MAC</label>
                    <?php
							include("../selectBox.php");
						?>
                </div>
                <div class="col-sm">
                    <label >Desde:</label>
                    <input class="form-control" type="datetime-local" id="fecha_desde">
                </div>
                <div class="col-sm">
                    <label >Hasta:</label>
                    <input class="form-control" type="datetime-local" id="fecha_hasta">
                </div>

            </div>
            <br>
            <button type="button" class="btn btn-default" id="plot_button">Plot</button>

            <div id="chart-container">
                <canvas id="plotrssi"></canvas>
            </div>

        </div>

        <!-- Separacion entre grafico y controles -->
        <br><br><br>
        <!-- Separacion entre grafico y controles -->
        
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-primary o-hidden ">
                    <p>
                        <b>MACS Totales</b>
                    </p>
                    <h2 id="macsTotales" align='center'></h2>

                </div>
                <label >Hasta:</label>
                <input class="form-control" type="datetime-local" id="fecha_hasta">
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden ">
                    <p>
                        <b>Novedades</b>
                    </p>
                    <h2 id="novedades" align='center'></h2>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-shopping-cart"></i>
                        </div>
                        <div class="mr-5">123 New Orders!</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="#">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-support"></i>
                        </div>
                        <div class="mr-5">13 New Tickets!</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="#">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- javascript -->
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script
            language="JavaScript"
            type="text/javascript"
            src="../vendor/jquery/jquery.min.js"></script>
        <script
            language="JavaScript"
            type="text/javascript"
            src="../vendor/chart.js/Chart.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/app.js"></script>

    </div>
</body>
</html>