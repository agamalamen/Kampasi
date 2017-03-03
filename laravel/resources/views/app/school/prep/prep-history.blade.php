@extends('layouts.school')
@section('title') Prep history @endsection
@section('app-content')
  <div class="panel panel-primary">
    <div class="panel-body">
      <ul class="list-unstyled">
        @foreach(Auth::User()->school->preps as $prep)
            @foreach(Auth::User()->school->prepPlaces as $place)
              @if($prep->place == $place->id)
                <?php $prepPlace = $place->name; ?>
              @endif
            @endforeach
            @if($prep->user)
              <?php
                $prepDate = date("d, F, Y", strtotime($prep->date));
              ?>
              @if(!$prep->here)
                <li style="color: #e74c3c;"><a style="color: #c0392b;" href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a> signed up for prep in {{$prepPlace}} on {{$prepDate}} (Not here)</li>
                <hr>
              @elseif ($prep->late)
                <li style="color: #e67e22;"><a style="color: #d35400" href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a> signed up for prep in {{$prepPlace}} on {{$prepDate}} (Late)</li>
                <hr>
              @elseif($prep->here)
                <li><a href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a> signed up for prep in {{$prepPlace}} on {{$prepDate}}</li>
                <hr>
              @endif
            @endif
        @endforeach
      </ul>
    </div>
  </div><!-- .panel-default -->
@endsection
