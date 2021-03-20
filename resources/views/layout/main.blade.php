<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageName }} | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-light fixed-top bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    </nav>

    <section class="container-fluid pt-4 pb-5">
        @yield('content')
    </section>

    <footer class="page-footer font-small bg-dark text-white pt-4">
        <div class="container-fluid text-center text-md-left">
            <div class="row">
                <div class="col-md-6 mt-md-0 mt-3">
                    <h5 class="text-uppercase">{{ config('app.name') }}</h5>
                    <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta et laborum commodi consectetur? Molestias excepturi neque, accusamus amet nulla illum enim. Id earum reiciendis at possimus repudiandae aspernatur rem consectetur.</p>
                </div>

                <div class="col-md-3 mb-md-0 mb-3">
                    <!-- <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul> -->
                </div>

                <div class="col-md-3 mb-md-0 mb-3">
                    <!-- <h5>Follow us on</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://instagram.com" target="_blank"><i class="fa fa-instagram"></i> Instagram</a></li>
                        <li><a href="https://twitter.com" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></li>
                        <li><a href="https://facebook.com" target="_blank"><i class="fa fa-facebook-square"></i> Facebook</a></li>
                        <li><a href="https://youtube.com" target="_blank"><i class="fa fa-youtube-play"></i> Youtube</a></li>
                    </ul> -->
                </div>
            </div>
        </div>

        <div class="footer-copyright text-center py-3">
            <small>Copyright &copy; {{ date("Y") }} {{ config('app.name') }}</small>
        </div>
    </footer>
</body>
</html>
