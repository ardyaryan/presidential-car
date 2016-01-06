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
                <a class="navbar-brand topnav" href="{{URL::to('/');}}">Presidential Car - {{(Session::get('lid') == 2) ? 'Chauffeur' : 'Driver'}}</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                @if (Session::get('logged'))
                    <li><a href="newtrip"><span class="fa fa-car"></span>{{(Session::get('lid') == 2) ? ' Nouveau Voyage' : ' New Trip'}}</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="mytrips"><span class="fa fa-table"></span>{{(Session::get('lid') == 2) ? ' Mes Voyages' : ' My Trips'}}</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="myfueltank"><span class="fa fa-battery-half"></span>{{(Session::get('lid') == 2) ? ' L\'essence' : ' My Fuel Tank'}}</a></li>
                @endif
                @if (Session::get('logged'))
                    <li><a href="logout"><span class="fa fa-sign-out"></span>{{(Session::get('lid') == 2) ? ' Se Déconnecter' : ' Sign Out'}}</a></li>
                @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
</nav>

</div>