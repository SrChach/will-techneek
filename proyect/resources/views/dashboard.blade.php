@extends('layouts.app')
@section('content')
    @foreach ($listaWins['wins'] as $win)
        <div class="{{ $listaWins['estilo'] }}">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4"> {{ $win['titulo'] }} </h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <i style="font-size: 70px;" class="{{ $win['icon'] }}"></i>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal text-dark" data-plugin="counterup"> {{ $win['conteo'] }} </h2>
                            <a href="" class="text-muted mb-1">Ver mas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    @endforeach
    <!--------------------------------------Dashboard Administrador----------------------------->
    <div class="row">
        <div class="d-flex col-12 align-items-center mb-2">
            <img src="assets/images/users/user-8.jpg" alt="image" class="img-fluid rounded-circle img-thumbnail me-3" width="120"> <h1>Hola [nombre de usuario admin]</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Alumnos</h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <!--VS mes anterior Dejarlo hasta el final -->
                            <div style="display:inline;width:70px;height:70px;"><canvas width="70" height="70"></canvas><input data-plugin="knob" data-width="70" data-height="70" data-fgcolor="#f05050 " data-bgcolor="#F9B9B9" value="58"  data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly" style="width: 39px; height: 23px; position: absolute; vertical-align: middle; margin-top: 23px; margin-left: -54px; border: 0px; background: none; font: bold 14px Arial; text-align: center; color: rgb(240, 80, 80); padding: 0px; appearance: none;"></div>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal pt-2 mb-1"> 256 </h2>
                            <p class="text-muted mb-1">Totales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Clases impartidas</h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <!--VS mes anterior Dejarlo hasta el final -->
                            <div style="display:inline;width:70px;height:70px;"><canvas width="70" height="70"></canvas><input data-plugin="knob" data-width="70" data-height="70" data-fgcolor="#f05050 " data-bgcolor="#F9B9B9" value="58"  data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly" style="width: 39px; height: 23px; position: absolute; vertical-align: middle; margin-top: 23px; margin-left: -54px; border: 0px; background: none; font: bold 14px Arial; text-align: center; color: rgb(240, 80, 80); padding: 0px; appearance: none;"></div>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal pt-2 mb-1"> 256 </h2>
                            <p class="text-muted mb-1">Totales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Clases programadas</h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <!--VS mes anterior Dejarlo hasta el final -->
                            <div style="display:inline;width:70px;height:70px;"><canvas width="70" height="70"></canvas><input data-plugin="knob" data-width="70" data-height="70" data-fgcolor="#f05050 " data-bgcolor="#F9B9B9" value="58"  data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly" style="width: 39px; height: 23px; position: absolute; vertical-align: middle; margin-top: 23px; margin-left: -54px; border: 0px; background: none; font: bold 14px Arial; text-align: center; color: rgb(240, 80, 80); padding: 0px; appearance: none;"></div>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal pt-2 mb-1"> 256 </h2>
                            <p class="text-muted mb-1">Totales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <h4 class="header-title mt-0 mb-4">Profesores</h4>
                    <div class="text-center">
                        <h2 class="fw-normal text-pink" data-plugin="counterup">5894</h2>
                        <h5>Profesores</h5>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">

        <!-- Últimas clases -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">    
                    <h4 class="header-title mt-0 mb-3"><i class="mdi mdi-notification-clear-all me-1"></i> Últimas clases programadas</h4> <!-- Últimos 5 ID's-->

                    <ul class="list-group mb-0 user-list">
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-primary"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 24, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-success"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Project Discussion</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 25, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-pink"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 26, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-muted"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Project Discussion</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 27, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-danger"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 28, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>                   
        </div>

        <!-- Materias con más clases -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mt-0 mb-4">Materias con más clases</h4>  <!--el top 6-->

                    <h5 class="mt-0">iMacs <span class="text-primary float-end">80%</span></h5>
                    <div class="progress progress-bar-alt-primary progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-primary progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-danger -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iBooks <span class="text-pink float-end">50%</span></h5>
                    <div class="progress progress-bar-alt-pink progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-pink progress-animated wow animated animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-pink -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 5s <span class="text-info float-end">70%</span></h5>
                    <div class="progress progress-bar-alt-info progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-info progress-animated wow animated animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 6 <span class="text-warning float-end">65%</span></h5>
                    <div class="progress progress-bar-alt-warning progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-warning progress-animated wow animated animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-warning -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 4 <span class="text-danger float-end">65%</span></h5>
                    <div class="progress progress-bar-alt-danger progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-danger progress-animated wow animated animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-warning -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 6s <span class="text-success float-end">40%</span></h5>
                    <div class="progress progress-bar-alt-success progress-sm mt-0">
                        <div class="progress-bar bg-success progress-animated wow animated animated" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-success -->
                    </div><!-- /.progress .no-rounded -->


                </div>
            </div>
        </div>

        <!-- Profesores con más clases -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mt-0 mb-4">Profesores con más clases</h4>  <!--el top 6-->

                    <h5 class="mt-0">iMacs <span class="text-primary float-end">80%</span></h5>
                    <div class="progress progress-bar-alt-primary progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-primary progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-danger -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iBooks <span class="text-pink float-end">50%</span></h5>
                    <div class="progress progress-bar-alt-pink progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-pink progress-animated wow animated animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-pink -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 5s <span class="text-info float-end">70%</span></h5>
                    <div class="progress progress-bar-alt-info progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-info progress-animated wow animated animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 6 <span class="text-warning float-end">65%</span></h5>
                    <div class="progress progress-bar-alt-warning progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-warning progress-animated wow animated animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-warning -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 4 <span class="text-danger float-end">65%</span></h5>
                    <div class="progress progress-bar-alt-danger progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-danger progress-animated wow animated animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-warning -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 6s <span class="text-success float-end">40%</span></h5>
                    <div class="progress progress-bar-alt-success progress-sm mt-0">
                        <div class="progress-bar bg-success progress-animated wow animated animated" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-success -->
                    </div><!-- /.progress .no-rounded -->
                </div>
            </div>
        </div>

        <!-- Alumnos con más clases -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mt-0 mb-4">Alumnos con más clases</h4>  <!--el top 6-->

                    <h5 class="mt-0">iMacs <span class="text-primary float-end">80%</span></h5>
                    <div class="progress progress-bar-alt-primary progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-primary progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-danger -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iBooks <span class="text-pink float-end">50%</span></h5>
                    <div class="progress progress-bar-alt-pink progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-pink progress-animated wow animated animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-pink -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 5s <span class="text-info float-end">70%</span></h5>
                    <div class="progress progress-bar-alt-info progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-info progress-animated wow animated animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 6 <span class="text-warning float-end">65%</span></h5>
                    <div class="progress progress-bar-alt-warning progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-warning progress-animated wow animated animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-warning -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 4 <span class="text-danger float-end">65%</span></h5>
                    <div class="progress progress-bar-alt-danger progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-danger progress-animated wow animated animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-warning -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 6s <span class="text-success float-end">40%</span></h5>
                    <div class="progress progress-bar-alt-success progress-sm mt-0">
                        <div class="progress-bar bg-success progress-animated wow animated animated" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-success -->
                    </div><!-- /.progress .no-rounded -->
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <!--Gráfica-->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0">Clases registradas los últimos 8 días</h4>
                    <div id="morris-bar-example" dir="ltr" style="height: 280px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);" class="morris-chart"><svg height="280" version="1.1" width="474" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.328125px; top: -0.796875px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.3.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="32.53125" y="241" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#adb5bd" d="M45.03125,241.5H449" stroke-opacity="0.1" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.53125" y="187" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">25</tspan></text><path fill="none" stroke="#adb5bd" d="M45.03125,187.5H449" stroke-opacity="0.1" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.53125" y="133" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan></text><path fill="none" stroke="#adb5bd" d="M45.03125,133.5H449" stroke-opacity="0.1" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.53125" y="79" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan></text><path fill="none" stroke="#adb5bd" d="M45.03125,79.5H449" stroke-opacity="0.1" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.53125" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan></text><path fill="none" stroke="#adb5bd" d="M45.03125,25.5H449" stroke-opacity="0.1" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="415.3359375" y="253.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2015</tspan></text><text x="348.0078125" y="253.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2014</tspan></text><text x="280.6796875" y="253.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan></text><text x="213.3515625" y="253.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan></text><text x="146.0234375" y="253.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2011</tspan></text><text x="78.6953125" y="253.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2010</tspan></text><rect x="71.9625" y="79" width="13.465625000000001" height="162" rx="0" ry="0" fill="#188ae2" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="139.290625" y="150.28" width="13.465625000000001" height="90.72" rx="0" ry="0" fill="#188ae2" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="206.61875" y="79" width="13.465625000000001" height="162" rx="0" ry="0" fill="#188ae2" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="273.946875" y="158.92" width="13.465625000000001" height="82.08000000000001" rx="0" ry="0" fill="#188ae2" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="341.275" y="199.95999999999998" width="13.465625000000001" height="41.04000000000002" rx="0" ry="0" fill="#188ae2" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="408.603125" y="40.119999999999976" width="13.465625000000001" height="200.88000000000002" rx="0" ry="0" fill="#188ae2" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect></svg><div class="morris-hover morris-default-style" style="left: 32px; top: 108px; display: none;"><div class="morris-hover-row-label">2010</div><div class="morris-hover-point" style="color: #188ae2">Statistics:   75
                    </div>
                    </div>
                    </div>
                
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        
    </div>


    <!-------------------------------------- Dashboard Profesor ----------------------------->

    <div class="row">
        <div class="d-flex col-12 align-items-center mb-2">
            <img src="assets/images/users/user-8.jpg" alt="image" class="img-fluid rounded-circle img-thumbnail me-3" width="120"> <h1>Hola [nombre de usuario profesor]</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="mdi mdi-alert-circle-outline me-2"></i>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Tu clase está por empezar</strong> Atención. En 30 minutos comenzará tu siguiente clase. Prepara todo.
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <h4 class="header-title mt-0 mb-4">Clases programadas para hoy</h4>
                    <div class="text-center">
                        <h2 class="fw-normal text-pink" data-plugin="counterup">5894</h2>
                        <h5>Clases</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Clases impartidas</h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <!--VS mes anterior Dejarlo hasta el final -->
                            <div style="display:inline;width:70px;height:70px;"><canvas width="70" height="70"></canvas><input data-plugin="knob" data-width="70" data-height="70" data-fgcolor="#f05050 " data-bgcolor="#F9B9B9" value="58"  data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly" style="width: 39px; height: 23px; position: absolute; vertical-align: middle; margin-top: 23px; margin-left: -54px; border: 0px; background: none; font: bold 14px Arial; text-align: center; color: rgb(240, 80, 80); padding: 0px; appearance: none;"></div>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal pt-2 mb-1"> 256 </h2>
                            <p class="text-muted mb-1">Totales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Clases Programadas</h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <!--VS mes anterior Dejarlo hasta el final -->
                            <div style="display:inline;width:70px;height:70px;"><canvas width="70" height="70"></canvas><input data-plugin="knob" data-width="70" data-height="70" data-fgcolor="#f05050 " data-bgcolor="#F9B9B9" value="58"  data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly" style="width: 39px; height: 23px; position: absolute; vertical-align: middle; margin-top: 23px; margin-left: -54px; border: 0px; background: none; font: bold 14px Arial; text-align: center; color: rgb(240, 80, 80); padding: 0px; appearance: none;"></div>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal pt-2 mb-1"> 256 </h2>
                            <p class="text-muted mb-1">Totales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <h4 class="header-title mt-0 mb-4">Alumnos inscritos</h4>
                    <div class="text-center">
                        <h2 class="fw-normal text-pink" data-plugin="counterup">5894</h2>
                        <h5>Alumnos</h5>
                    </div>
                </div>
            </div>
        </div>

    </div>

<div class="row">
        <!-- siguientes clases -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">    
                    <h4 class="header-title mt-0 mb-3"><i class="mdi mdi-notification-clear-all me-1"></i> Siguientes clases</h4> <!--las siguientes 6 clases -->

                    <ul class="list-group mb-0 user-list">
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-primary"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 24, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-success"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Project Discussion</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 25, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-pink"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 26, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-muted"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Project Discussion</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 27, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-danger"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 28, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>                   
        </div>

        <!-- Alumnos con más clases -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mt-0 mb-4">Alumnos con más clases</h4>  <!--el top 6-->

                    <h5 class="mt-0">iMacs <span class="text-primary float-end">80%</span></h5>
                    <div class="progress progress-bar-alt-primary progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-primary progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-danger -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iBooks <span class="text-pink float-end">50%</span></h5>
                    <div class="progress progress-bar-alt-pink progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-pink progress-animated wow animated animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-pink -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 5s <span class="text-info float-end">70%</span></h5>
                    <div class="progress progress-bar-alt-info progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-info progress-animated wow animated animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 6 <span class="text-warning float-end">65%</span></h5>
                    <div class="progress progress-bar-alt-warning progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-warning progress-animated wow animated animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-warning -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 4 <span class="text-danger float-end">65%</span></h5>
                    <div class="progress progress-bar-alt-danger progress-sm mt-0 mb-3">
                        <div class="progress-bar bg-danger progress-animated wow animated animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-warning -->
                    </div><!-- /.progress .no-rounded -->

                    <h5 class="mt-0">iPhone 6s <span class="text-success float-end">40%</span></h5>
                    <div class="progress progress-bar-alt-success progress-sm mt-0">
                        <div class="progress-bar bg-success progress-animated wow animated animated" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-success -->
                    </div><!-- /.progress .no-rounded -->
                </div>
            </div>
        </div>

        <!-- Calendarios -->
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Horario</h4> 
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    
</div>



    <!-------------------------------------- Dashboard Alumno  ----------------------------->

    <div class="row">
        <div class="d-flex col-12 align-items-center mb-2">
            <img src="assets/images/users/user-8.jpg" alt="image" class="img-fluid rounded-circle img-thumbnail me-3" width="120"> <h1>Hola [nombre de usuario alumno]</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="mdi mdi-alert-circle-outline me-2"></i>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Tu clase está por empezar</strong> Atención. En 30 minutos comenzará tu siguiente clase. Prepara todo.
            </div>
        </div>
    </div>

<div class="row">
        <!-- Calendarios -->
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Horario</h4> 
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <!-- Clases programadas -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">    
                    <h4 class="header-title mt-0 mb-3"><i class="mdi mdi-notification-clear-all me-1"></i> Clases programadas</h4> <!--las siguientes 6 clases -->

                    <ul class="list-group mb-0 user-list">
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-primary"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 24, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-success"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Project Discussion</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 25, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-pink"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 26, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-muted"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Project Discussion</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 27, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-start me-3">
                                    <i class="mdi mdi-circle text-danger"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 28, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>                   
        </div>

        <!-- Tus profesores -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Mis profesores</h4>

                    <ul class="list-group mb-0 user-list">
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-start me-2">
                                    <img src="assets/images/users/user-2.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">Michael Zenaty</h5>
                                    <p class="desc text-muted mb-0 font-12">CEO</p>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-start me-2">
                                    <img src="assets/images/users/user-3.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">James Neon</h5>
                                    <p class="desc text-muted mb-0 font-12">Web Designer</p>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-start me-2">
                                    <img src="assets/images/users/user-5.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">John Smith</h5>
                                    <p class="desc text-muted mb-0 font-12">Web Developer</p>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-start me-2">
                                    <img src="assets/images/users/user-6.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">Michael Zenaty</h5>
                                    <p class="desc text-muted mb-0 font-12">Programmer</p>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-start me-2">
                                    <img src="assets/images/users/user-1.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">Mat Helme</h5>
                                    <p class="desc text-muted mb-0 font-12">Manager</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    
</div>




@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay',
                },
                locale: 'es',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
                    'Nov', 'Dic'
                ],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                events: [{ // this object will be "parsed" into an Event Object
                    title: 'evento prueba', // a property!
                    start: '2023-09-25', // a property!
                    end: '2023-09-27' // a property! ** see important note below about 'end' **
                }],

                customButtons: {
                    prev: {
                        text: 'Prev',
                        click: function() {
                            console.log(date.month());
                            // do the original command
                            calendar.prev();
                        }
                    },
                    next: {
                        text: 'Next',
                        click: function() {
                            // do the original command
                            calendar.next();
                        }
                    },
                }
                //-----Fin Evento Click   
            });
            calendar.render();
        });
    </script>
@endsection
