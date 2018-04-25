<html>
    <head>
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <title>WiFi Scanner</title>
        <style type="text/css">
            #chart-container {
                width: auto;
                height: auto;
            }
            .table td.fit,
            .table th.fit {
                white-space: nowrap;
                width: 1%;
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
            <h1>
                Wifi Scanner
            </h1>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading"><b>Ploteo de MAC</b></div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-sm">

                            <label for="sel1">MAC</label>
                            <?php
							        include("../selectBox.php");
                    ?>
                            <label style="margin-top: 10px;" for="busqueda_MAC">Búsqueda de MAC:</label>
                            <input type="busqueda_MAC" class="form-control" id="busqueda_MAC">

                        </div>
                        <div class="col-sm">
                            <label >Desde:</label>
                            <input class="form-control" type="datetime-local" id="fecha_desde">
                            <button
                                style="margin-top: 40px;display: none;"
                                type="button"
                                class="btn btn-default"
                                id="plot_button_from_search">Plot búsqueda</button>


                        </div>

                        <div class="col-sm">
                            <label >Hasta:</label>
                            <input class="form-control" type="datetime-local" id="fecha_hasta">
                            
                            <label style="margin-top:10px;" for="sel1">Device</label>
                            <select style= "height:35px; " class="form-control" name="deviceSelect" id="deviceSelect">
                                <option value="1">ESP32</option>
                                <option value="2">ESP8266</option>
                                <option value="%">All</option>

                            </select>

                        </div>

                    </div>
                    <br>
                    <div id="livesearch"></div>
                    <br>
                    <button type="button" class="btn btn-default" id="plot_button">Plot</button>
                    <hr>
                    <div id="chart-container">
                        <canvas id="plotrssi"></canvas>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><b>Indicadores</b></div>
                <div class="panel-body">
                    <div style="margin-top: 40px;" class="row">
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
                            <div class="card text-white bg-success o-hidden">
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
                            <div class="card text-white bg-danger o-hidden ">
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
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><b>Canales WiFi</b></div>
                <div class="panel-body">
                    <div id="chart-container">
                        <canvas id="plotchannels"></canvas>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><b>MAC Vendors</b></div>
                <div class="panel-body">
                    <div id="macVendorTable"> </div>
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
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    </body>
</html>