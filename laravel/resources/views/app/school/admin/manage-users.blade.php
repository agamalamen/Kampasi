@extends('layouts.school')
@section('title') Manage users @endsection
@section('app-content')

<div class="row">
<table class="table" style="color:#333; font-family: lato;">
      <tr class="tr-header">
        <th class="visible-lg visible-md">#</th>
        <th>Name</th>
        <th>Role</th>
        <th class="visible-lg visible-md">Hall</th>
        <th class="visible-lg visible-md">Room</th>
        <th>Phone</th>
        <th>Tracking</th>
      </tr>
      @foreach(Auth::User()->school->users as $user)
        <tr>
        <th>{{$user->id}}</th>
        <th><a href="{{route('dashboard', $user->username)}}" target="_blank">
        @if(strlen($user->name) > 15)
            {{substr($user->name, 0, 15) . '...'}}
        @else
            {{$user->name}}
        @endif
        </a></th>
        <th>{{$user->role}}</th>
        @if($user->hall)
            <th>{{$user->hall->name}}</th>
        @else
            <th>None</th>
        @endif
        @if($user->room)
            <th>{{$user->room}}</th>
        @else
            <th>None</th>
        @endif
        <th>{{$user->phone}}</th>
        <th><a href="{{route('get.manage.user', $user->username)}}">Manage user</a></th>
        </tr>
      @endforeach
</table>

<style>
        th {
            font-weight: normal;
        }

        .tr-header th {
            font-weight: bold;
        }
</style>
</div><!-- .row -->

@endsection
