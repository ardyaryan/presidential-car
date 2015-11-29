<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    {{ HTML::script('js/'); }} <!-- including js -->
    {{ HTML::style('css/style.css'); }} <!-- including css -->
</head>

<body class="oneColFixCtr">

<div id="container">
    <div id="mainContent">
        <h1> Laravel Test Page</h1>
        <p>This is from inside Wrapper View</p><br/>
        @if(isset($data))
            The URI Param : {{ $data }}
            {{'<br/><br/><a href="http://localhost/laravel/administrator/"><-- Back</a>'}}

        @else
            {{'<a href="http://localhost/laravel/administrator/Read">Click to see how a Parameter is passed</a>'}}
            {{'<br/><br/><br/><br/><br/>Or go back to <a href="/laravel/">Laravel Home</a>'}}
        @endif
        <br/>
        {{'<br/>How to use a <a href="http://localhost/laravel/template">Template</a>'}}
        {{'<br/>Register here <a href="http://localhost/laravel/signup">Signup</a>'}}
        {{'<br/>Browse all the records <a href="http://localhost/laravel/browse">Browse</a>'}}
    </div>
</div>
</body>
</html>
