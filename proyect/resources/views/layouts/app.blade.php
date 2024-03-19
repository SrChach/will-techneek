<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Administrador Sistema </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(function(OneSignal) {
            OneSignal.init({
                appId: "17b508e3-8416-45da-bebe-d4667162cf7a",
                safari_web_id: "web.onesignal.auto.00e855ed-5f66-45b8-ad03-54b1e142944e",
                notifyButton: {
                    enable: true,
                },
            });

            function pushSubscriptionChangeListener(event) {
                console.log(event);

                if (event.current.id) {
                    //añadir el algoritmo para que agrege a base de datos el id y con ello crear un algoritmo de envio de notificaciones
                    //con one OneSignal

                    let idOneSignal = event.current.id;
                    let suscripcionEstado = event.current.optedIn;
                    let tokenOneSignal = event.current.token;

                    let datos = {
                        idOneSignal: idOneSignal,
                        suscripcionEstado: suscripcionEstado,
                        tokenOneSignal: tokenOneSignal,
                    }

                    //agregar ajax
                    console.log(`The push subscription has received a token!`);
                    $.ajax({
                        type: "POST",
                        url: "https://techneektutor.com/sistema/onesignal/save/data",
                        datatype: "json",
                        data: datos,
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(error) {
                            console.log(error);
                        },
                    });
                }
            }

            OneSignal.User.PushSubscription.addEventListener("change", pushSubscriptionChangeListener);

        });
    </script>
    <?php
    
    $identifier = '9';
    $ONESIGNAL_REST_API_KEY = 'MGEyOWRmYmItMzM1ZS00NzE1LWExNjktNjI2MWI5Mjg5N2Qz';
    $hash = hash_hmac('sha256', $identifier, $ONESIGNAL_REST_API_KEY);
    
    ?>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

    <!-- Plugin     css -->
    <link href="{{ asset('assets/libs/fullcalendar/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/chartist/chartist.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />


    <!--<script src="https://ippsonline.com/adm/PushNotifications/2/js/push.min.js"></script>-->
    
    
    <script type="text/javascript">
	function googleTranslateElementInit() {
		new google.translate.TranslateElement({pageLanguage: 'es', includedLanguages: 'ca,eu,gl,en,fr,it,pt,de', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true}, 'google_translate_element');
			}
	</script>
	
	<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</head>

<!-- body start -->

<body class="loading" data-layout-color="dark" data-layout-mode="default" data-layout-size="fluid"
    data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="dark" data-leftbar-size='default'
    data-sidebar-user='true'>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-end mb-0">

                <li class="dropdown d-inline-block d-lg-none">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="fe-search noti-icon"></i>
                    </a>
                    <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                        <form class="p-3">
                            <input type="text" class="form-control" placeholder="Search ..."
                                aria-label="Recipient's username">
                        </form>
                    </div>
                </li>

                @php
                    $user = Auth::user();
                @endphp
                <!-- notificaciones -->
                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        
                        <i class="fe-bell noti-icon"></i>
                        <span class="badge bg-danger rounded-circle noti-icon-badge"> {{ count($user->unreadNotifications) }} </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                Notificaciones
                            </h5>
                        </div>

                        <div class="noti-scroll" data-simplebar>

                            @foreach ($user->unreadNotifications as $notification)
                                <!-- item-->
                                <a href="{{ $notification->data['url'] }}" class="dropdown-item notify-item">
                                    <div class="notify-icon {{ $notification->data['color'] }}">
                                        {!! $notification->data['icon'] !!}
                                    </div>
                                    <p class="notify-details">
                                        {{ $notification->data['mensaje'] }}
                                        <small class="text-muted">Ver detalles</small>
                                    </p>
                                </a>
                                @php
                                    $notification->markAsRead();
                                @endphp
                            @endforeach
                        </div>

                        <!-- All-->


                    </div>
                </li>
                <!-- end notificaciones -->

                <!-- banner de perfil -->
                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ Auth::user()->foto }}" alt="user-image" class="rounded-circle">
                        <!-- foto del administrador pendiente -->
                        <span class="pro-user-name ms-1"> {{ Auth::user()->nombre }} <i
                                class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Bienvenido</h6>
                        </div>
                        <!-- item-->
                        <a href="{{ route('perfil.index') }}" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>Mi cuenta</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <!-- item-->
                        <form method="POST" action=" {{ route('logout') }} ">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </button>
                        </form>

                    </div>
                </li>
                
                <!--<li class="dropdown notification-list">
                    <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                        <i class="fe-settings noti-icon"></i>
                    </a>
                </li>-->
                <li class="dropdown notification-list topbar-dropdown">
                	<br>
                	<div id="google_translate_element" class="google"></div>
                </li>
                <!-- end banner de perfil -->
            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="#" class="logo logo-light text-center">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="40">
                        <!-- pendiente de cambiar logo -->
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="40">
                        <!-- pendiente de cambiar logo -->
                    </span>
                </a>
                <!-- definir el modo oscuro o no -->
                <a href="#" class="logo logo-dark text-center">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/techneek_white.svg') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/techneek_black.svg') }}" alt="" height="40">
                    </span>
                </a>
            </div>




            <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
                <li>
                    <button class="button-menu-mobile disable-btn waves-effect" id="mostrarMenu">
                        <i class="fe-menu"></i>
                    </button>

                </li>

            </ul>

            <div class="clearfix"></div>

        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu" id="abrirMenu">

            <div class="h-100" data-simplebar>

                <!-- User box -->
                <div class="user-box text-center" >

                    <img src="{{ Auth::user()->foto }}" alt="user-img" title="Mat Helme"
                        class="rounded-circle img-thumbnail avatar-md">
                    <div class="dropdown">
                        <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block"
                            data-bs-toggle="dropdown" aria-expanded="false"> {{ Auth::user()->nombre }} <i
                                class="fe-chevron-down"></i></a>
                        <div class="dropdown-menu user-pro-dropdown">

                            <!-- item-->
                            <a href="{{ route('perfil.index') }}" class="dropdown-item notify-item">
                                <i class="fe-user me-1"></i>
                                <span>Mi perfil</span>
                            </a>

                            <!-- item-->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item notify-item">
                                    <i class="fe-log-out me-1"></i>
                                    <span>Cerrar sesión</span>
                                </button>
                            </form>

                        </div>
                    </div>

                    @switch(Auth::user()->idRol)
                        @case(2)
                            <p class="text-muted left-user-info"> <i class="mdi mdi-teach"></i> Profesor </p>
                        @break

                        @case(3)
                            <p class="text-muted left-user-info"> <i class="fas fa-graduation-cap"></i> Alumno </p>
                        @break

                        @default
                    @endswitch

                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul id="side-menu">

                        @for ($i = 0; $i < sizeof($navs); $i++)
                            @if (Auth::user()->idRol == $navs[$i]['idRol'])
                                <li>
                                    <a href="{{ $navs[$i]['ruta'] }}">
                                        <i class="{{ $navs[$i]['icon'] }}"></i>
                                        <span> {{ $navs[$i]['titulo'] }} </span>
                                    </a>
                                </li>
                            @endif
                        @endfor




                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            @switch(Auth::user()->idStatus)
                                @case(2)
                                    <div class="alert alert-warning" role="alert">
                                        <i class="mdi mdi-alert-outline me-2"></i>
                                        <a href="" class="text-warning">Por favor <strong>verifica tus
                                                datos</strong></a>
                                    </div>
                                @break

                                @case(3)
                                    <div class="alert alert-warning" role="alert">
                                        <i class="mdi mdi-alert-outline me-2"></i>
                                        <a href="" class="text-warning">Por favor <strong>verifica tu
                                                correo.</strong></a>
                                    </div>
                                @break

                                @default
                            @endswitch
                        </div>
                    </div>
                    <div class="row">
                        @yield('content')
                    </div>
                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> &copy; Tech Neek. Todos los derechos redervados -
                            <span style="font-size: .7em; opacity: .8;">Hecho con 💚 por <a
                                    href="https://greendot.digital" target="_blank">GreenDot</a></span>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-sm-block">
                                <a href="javascript:void(0);">Sobre nosotros</a>
                                <a href="javascript:void(0);">Ayúda</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    
    
    
    <div class="right-bar">

            <div data-simplebar class="h-100">

                <div class="rightbar-title">
                    <a href="javascript:void(0);" class="right-bar-toggle float-end">
                        <i class="mdi mdi-close"></i>
                    </a>
                    <h4 class="font-16 m-0 text-white">Theme Customizer</h4>
                </div>
        
                <!-- Tab panes -->
                <div class="tab-content pt-0">  

                    <div class="tab-pane active" id="settings-tab" role="tabpanel">

                        <div class="p-3">
                            <div class="alert alert-warning" role="alert">
                                <strong>Customize </strong> the overall color scheme, Layout, etc.
                            </div>

                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Color Scheme</h6>
                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="layout-color" value="light"
                                    id="light-mode-check" checked />
                                <label class="form-check-label" for="light-mode-check">Light Mode</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="layout-color" value="dark"
                                    id="dark-mode-check" />
                                <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                            </div>

                            <!-- Width -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Width</h6>
                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="layout-size" value="fluid" id="fluid" checked />
                                <label class="form-check-label" for="fluid-check">Fluid</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="layout-size" value="boxed" id="boxed" />
                                <label class="form-check-label" for="boxed-check">Boxed</label>
                            </div>

                            <!-- Menu positions -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Menus (Leftsidebar and Topbar) Positon</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-position" value="fixed" id="fixed-check"
                                    checked />
                                <label class="form-check-label" for="fixed-check">Fixed</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-position" value="scrollable"
                                    id="scrollable-check" />
                                <label class="form-check-label" for="scrollable-check">Scrollable</label>
                            </div>

                            <!-- Left Sidebar-->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Color</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-color" value="light" id="light" />
                                <label class="form-check-label" for="light-check">Light</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-color" value="dark" id="dark" checked/>
                                <label class="form-check-label" for="dark-check">Dark</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-color" value="brand" id="brand" />
                                <label class="form-check-label" for="brand-check">Brand</label>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input" name="leftbar-color" value="gradient" id="gradient" />
                                <label class="form-check-label" for="gradient-check">Gradient</label>
                            </div>

                            <!-- size -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Size</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-size" value="default"
                                    id="default-size-check" checked />
                                <label class="form-check-label" for="default-size-check">Default</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-size" value="condensed"
                                    id="condensed-check" />
                                <label class="form-check-label" for="condensed-check">Condensed <small>(Extra Small size)</small></label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-size" value="compact"
                                    id="compact-check" />
                                <label class="form-check-label" for="compact-check">Compact <small>(Small size)</small></label>
                            </div>

                            <!-- User info -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Sidebar User Info</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="sidebar-user" value="true" id="sidebaruser-check" />
                                <label class="form-check-label" for="sidebaruser-check">Enable</label>
                            </div>


                            <!-- Topbar -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Topbar</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="topbar-color" value="dark" id="darktopbar-check"
                                    checked />
                                <label class="form-check-label" for="darktopbar-check">Dark</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="topbar-color" value="light" id="lighttopbar-check" />
                                <label class="form-check-label" for="lighttopbar-check">Light</label>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
                                <a href="https://1.envato.market/admintoadmin" class="btn btn-danger mt-3" target="_blank"><i class="mdi mdi-basket me-1"></i> Purchase Now</a>
                            </div>

                        </div>

                    </div>
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
    
    <!-- END wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- knob plugin -->
    <script src="{{ asset('assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>

    <!--Morris Chart-->
    <!--<script src="assets/libs/morris/morris.min.js"></script>-->
    <script src="{{ asset('assets/libs/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/libs/mohithg-switchery/switchery.min.js') }}"></script>

    <!-- Dashboar init js-->
    <!--<script src="assets/js/pages/dashboard.init.js"></script>-->

    <!-- plugin js -->
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/fullcalendar/main.min.js') }}"></script>

    <!-- Calendar init -->
    <!--<script src="assets/js/pages/calendar.init.js"></script>-->

    <!-- third party js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <!-- Datatables init -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- chartist init -->
    <script src="{{ asset('assets/libs/chartist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js') }}"></script>

    <!-- File init -->
    <script src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-fileuploads.init.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <!-- App js-->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/form.js') }}"></script>
    
    
    
              
                       
             
                         
		<script>
        $('#mostrarMenu').click(function(){
            $('#abrirMenu').show(1000);
        });
        </script>

    @yield('scripts')

</body>

</html>
