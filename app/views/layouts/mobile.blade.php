<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Landing Page - Start Bootstrap Theme</title>

    {{ HTML::style('public/css/lib/bootstrap.min.css'); }}
    {{ HTML::style('public/css/lib/landing-page.css'); }}
    {{ HTML::style('public/font-awesome/css/font-awesome.min.css'); }}

    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
</head>

<body>

    @if (Session::get('role') == 'admin')
        @include('layouts.partials.adminNavigation')
    @else
        @include('layouts.partials.driverNavigation')
    @endif


    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Landing Page</h1>
                        <h3>A Template by Start Bootstrap</h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">

                            <li>
                                <a href="#" class="btn btn-default btn-lg">Send</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

        </div>


    </div>
    @yield('body')

    <!-- Footer -->
    @include('layouts.partials.footer')
    @show

    <script src="public/js/lib/jquery.js"></script>

    <script src="public/js/lib/bootstrap.min.js"></script>

</body>

</html>
