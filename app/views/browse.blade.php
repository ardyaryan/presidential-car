@extends('layouts.main')
@section('title')
This is my Laravel Template
@stop

@section('body')
<div id="container">
    <div id="mainContent">
        <h1> All Users:</h1>
        <p> This is being loaded from browse.blade.php</p>
        <table cellpadding="8">
            <thead style="background-color: #868686;">
                <td>Name</td>
                <td>Email</td>
                <td>Description</td>
                <td>Created On</td>
                <td>Updated On</td>
            </thead>
            <tbody style="background-color: #ffffff;color:black;">
            @foreach($users as $user)
                <tr>
                    <td>{{$user['name']}}</td>
                    <td>{{$user['email']}}</td>
                    <td>{{$user['description']}}</td>
                    <td>{{$user['created_at']}}</td>
                    <td>{{$user['updated_at']}}</td>
                    <td style="background-color:#ef7c61;"><a href="administrator/deleteuser/{{$user['id']}}">delete</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{'<br/><br/><a href="http://localhost/laravel/administrator/"><-- Back</a>'}}
    </div>
</div>
@stop
