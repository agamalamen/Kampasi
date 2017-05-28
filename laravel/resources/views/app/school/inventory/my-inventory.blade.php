@extends('layouts.school')
@section('title') Inventories @endsection
@section('app-header')
  <div class="school-header" style="margin-bottom: 10px; margin-top: -30px;">
    <h1 class="text-center" style="color: #fff; padding-top: 30px;font-family: Montserrat;">Your Inventory</h1>
    <p class="text-center" style="padding-bottom: 30px;">All the resources you need, in one place.</p>
  </div><!-- .school-header -->
@endsection
@section('app-content')
 
  <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventories', Auth::User()->school->username)}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to all inventories</a></p>

  <div class="row">
    <div class='col-md-8 col-md-offset-2'>
      <ul class="list-group" style="color: #333;">
        @foreach($user->items as $item)
          <li class="list-group-item">
            <a href="{{route('get.item', [Auth::User()->school->username, $item->inventory->name, $item->name])}}">{{$item->name}}</a>
            <p class="pull-right"><b>Return on:</b> {{$item->pivot->return_date}}</p>
          </li>
        @endforeach
      </ul>
    </div><!-- .col-md-9 -->

  </div><!-- .row -->
@endsection
