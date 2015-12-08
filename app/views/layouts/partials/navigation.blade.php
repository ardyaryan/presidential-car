<div id="nav">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Presidential Car</a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="dashboard"><span class="glyphicon glyphicon-home"></span> Home</a></li>
        @if (!Session::get('logged'))
            <!--<li ><a href=""><span class="glyphicon glyphicon-user"></span> Log In</a></li>-->
        @endif
        @if (!Session::get('logged'))
            <li><a href="#" ><span class="glyphicon glyphicon-plus"></span> Sign Up</a></li>
        @endif
        <li><a href="newtrips"><span class="glyphicon glyphicon-th-list"></span> Enter Daily Trips</a></li>
        <li><a href="viewtrips"><span class="glyphicon glyphicon-zoom-in"></span> View Daily Trips</a></li>
        <li><a href="viewdrivers"><span class="glyphicon glyphicon-eye-open"></span> View Drivers</a></li>
        @if (Session::get('logged'))
            <li><a href="logout"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
        @endif


      </ul>
    </div>
  </div>
</nav>

</div>