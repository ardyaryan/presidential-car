<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    {{ HTML::style('public/css/lib/bootstrap.min.css'); }}
    {{ HTML::style('public/css/lib/landing-page.css'); }}
    {{ HTML::style('public/font-awesome/css/font-awesome.min.css'); }}
    {{ HTML::style('public/css/style.css'); }}
    {{ HTML::style('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'); }}
    {{ HTML::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.css'); }}
    {{ HTML::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'); }}
    {{ HTML::style('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css'); }}
    {{ HTML::style('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css'); }}
    {{ HTML::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.css'); }}
    {{ HTML::style('http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'); }}

    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
</head>

<body>

    @if (Session::get('role') == 'admin')
        @include('layouts.partials.adminNavigation')
    @elseif (Session::get('role') == 'driver')
        @include('layouts.partials.driverNavigation')
    @else
        @include('layouts.partials.navigation')
    @endif
    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        @yield('body')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.partials.footer')
    @show
    @section('footer')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.js"></script>
    @show

</body>

</html>
