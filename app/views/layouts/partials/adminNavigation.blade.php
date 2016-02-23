<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="{{URL::to('/');}}">Presidential Car - Admin</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                @if (Session::get('logged'))
                    <li><a href="{{URL::to('/admin/dashboard');}}"><span class="fa fa-home"></span> Dashboard</a></li>
                @endif
                @if (!Session::get('logged'))
                    <li><a href="#"><span class="fa fa-user-plus"></span> Add User</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="{{URL::to('/admin/viewtrips');}}"><span class="fa fa-table"></span> View Trips</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="{{URL::to('/admin/viewdrivers');}}"><span class="fa fa-users"></span> View Drivers</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="{{URL::to('/admin/viewclients');}}"><span class="fa fa-users"></span> View Clients</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="{{URL::to('/admin/viewcars');}}"><span class="fa fa-car"></span> View Cars</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="{{URL::to('/admin/viewpayments');}}"><span class="fa fa-usd"></span> Payments</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="{{URL::to('/admin/logout');}}"><span class="fa fa-sign-out"></span> Logout</a></li>
                @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
</nav>

</div>


