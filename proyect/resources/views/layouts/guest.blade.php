<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="---" name="description" />
    <meta content="GreenDot" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->

    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    @vite([
        'resources/css/main.css',
        'resources/js/main.js'
    ])
</head>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages my-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">

                    @yield('content')

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script>

        $('select').on('change', function() {
            var selectedValues = [];
            $('select').each(function() {
                var thisValue = this.value;
                if (thisValue !== '')
                    selectedValues.push(thisValue);
            }).each(function() {
                $(this).find('option:not(:selected)').each(function() {
                    if ($.inArray(this.value, selectedValues) === -1) {
                        $(this).removeAttr('hidden');
                    } else {
                        if (this.value !== '')
                            $(this).attr('hidden', 'hidden');
                    }
                });
            });
        });
    </script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/form.js') }}"></script> -->
    @vite([
        'resources/js/migrating/form.js'
    ])

</body>

</html>
