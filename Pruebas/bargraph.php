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

        <style>
            /* Note: Try to remove the following lines to see the effect of CSS positioning */
            .affix {
                top: 0;
                width: 100%;
                z-index: 9999 !important;
            }

            .affix + .container-fluid {
                padding-top: 70px;
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

        <nav class="navbar navbar-default" data-spy="affix">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand">Wifi Scanner</a>
                </div>
                <div class="row">

                    <div class="col-xs" style="margin-top: 17px;margin-right:10px;">
                        <label >Desde:</label>
                    </div>
                    <div class="col-xs" style="margin-top: 10px;margin-right:10px;">
                        <input class="form-control" type="datetime-local" id="fecha_desde">

                    </div>

                    <div class="col-xs" style="margin-top: 17px;margin-right:10px;">
                        <label >Hasta:</label>
                    </div>
                    <div class="col-xs" style="margin-top: 10px;margin-right:10px;">
                        <input class="form-control" type="datetime-local" id="fecha_hasta">

                    </div>

                    <div class="col-xs" style="margin-top: 17px;margin-right:10px;">
                        <label for="sel1">Device</label>
                    </div>
                    <div class="col-xs" style="margin-top: 10px;margin-right:10px;">
                        <select
                            style="height:35px; "
                            class="form-control"
                            name="deviceSelect"
                            id="deviceSelect">
                            <option value="1">ESP32</option>
                            <option value="2">ESP8266</option>
                            <option value="%">All</option>

                        </select>
                    </div>

                </div>
            </div>
        </nav>

        <div class="container">

            <hr>

            <!-- PLOTEO DE MAC-->
            <div class="panel panel-default" style="margin-top: 80px;">
                <div class="panel-heading">
                    <b>Ploteo de MAC</b>
                </div>
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

                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <button
                                type="button"
                                class="btn btn-success btn-lg"
                                style="margin-top: 20px;margin-bottom: 20px;"
                                id="plot_button">Plot</button>
                            <button
                                style="margin-top: 20px;margin-bottom: 20px;display: none;"
                                type="button"
                                class="btn btn-success btn-lg"
                                id="plot_button_from_search">Plot búsqueda</button>
                        </div>
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm">
                                    <div style="margin-top: 25px;" id="macVendor"></div>
                                </div>
                                <div class="col-sm">
                                    <div style="margin-top: 25px;" id="lastChannel"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="livesearch"></div>
                    <br>
                    <div id="chart-container">
                        <canvas id="plotrssi"></canvas>
                    </div>
                </div>
            </div>
            <!-- FIN PLOTEO DE MAC-->

            <!-- PANEL DE CONTROL-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Indicadores</b>
                </div>
                <div class="panel-body">
                    <div style="margin-top: 40px;" class="row">
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white bg-primary o-hidden ">
                                <p>
                                    <b>Nro MACS</b>
                                    (últimos 5 min)
                                </p>
                                <h2 id="macsTotales" align='center'></h2>

                            </div>

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
            <!-- FIN PANEL DE CONTROL-->

            <!-- CANALES WIFI-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Canales WiFi</b>
                </div>
                <div class="panel-body">
                    <div id="chart-container">
                        <canvas id="plotchannels"></canvas>
                    </div>
                </div>
            </div>
            <!-- FIN CANALES WIFI-->

            <!-- MAC VENDORS-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>MAC Vendors</b>
                </div>
                <div class="panel-body">
                    <div id="macVendorTable"></div>
                </div>
            </div>
            <!-- FIN MAC VENDORS-->

            <!-- ENTORNO-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Análisis Entorno</b>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm">
                            <button
                                type="button"
                                class="btn btn-success btn-lg"
                                style="margin-top: 20px;margin-bottom: 20px;"
                                id="congelar">Congelar Entorno</button>

                            <button
                                type="button"
                                class="btn btn-success btn-lg"
                                style="margin-top: 20px;margin-bottom: 20px;"
                                id="agregarEntorno">Agregar entorno</button>

                            <img
                                style="margin-left: 10px;display:none;"
                                id="imgLoading"
                                src="./loading.gif"
                                width='54'
                                height='54'/>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                style="margin-top: 20px;margin-bottom: 20px;"
                                id="monitorear">Monitorear</button>

                        </div>

                        <div class="col-sm">
                            <div style="margin-top: 28px;" id="cantMACCongeladas"></div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                        <label for="pwd">Dias a graficar</label>
                        <input type="text" class="form-control" id="minAtras" value=0>
                        </div>
                    </div>
                    <!-- PANEL DE CONTROL-->

                    <div style="margin-top: 40px;" class="row">
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white bg-primary o-hidden ">
                                <p>
                                    <b>Nro MACS</b>
                                    (nuevas)
                                </p>
                                <h2 id="nroMacsNotFreeze" align='center'></h2>

                            </div>

                        </div>
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white bg-warning o-hidden ">
                                <p>
                                    <b>Novedades</b>
                                </p>
                                <h2 id="novedades" align='center'></h2>
                            </div>
                        </div>

                    </div>

                    <!-- FIN PANEL DE CONTROL-->
                    <div id="multiGraph">
                        <div/>

                    </div>
                    <!-- FIN ENTORNO-->

                </div>

                <!-- javascript -->
                <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="https://momentjs.com/downloads/moment.min.js"></script>
                <script
                    language="JavaScript"
                    type="text/javascript"
                    src="../vendor/jquery/jquery.min.js"></script>
                <script
                    language="JavaScript"
                    type="text/javascript"
                    src="../vendor/chart.js/Chart.min.js"></script>
                <script language="JavaScript" type="text/javascript" src="js/app.js"></script>
                <script
                    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <link
                    rel="stylesheet"
                    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

            </body>
        </html>