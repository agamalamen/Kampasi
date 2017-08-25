@extends('layouts.school')
@section('title') Members @endsection
@section('app-content')
  <h1 class="text-center" style="color: #333; font-family: lato;">
  <span class="badge"><a style="color: white;" href="{{route('get.create.user.manually')}}">Create</a></span>
  {{Auth::User()->school->name}} members <span class="badge">{{$members->count()}}</span>
  </h1>
  <div class="row" style="color: #333; padding-top: 20px;">
    @foreach($members as $user)
      <div class="col-md-4">
        <div class="media well" style="background-color: #fff;">
          <a class="media-left" href="{{route('dashboard', $user->username)}}">
            <img class="media-object img-rounded" style="width: 50px; height: 50px;" src="{{route('get.avatar', $user->avatar)}}" alt="{{$user->name}}">
          </a>
          <div class="media-body">
            <h2 style="font-size: 16px;" class="media-heading"><a style="color: #333" href="{{route('dashboard', $user->username)}}">{{$user->name}}</a></h2>
            <?php
              $route = '#';
              $role = $user->role;
              if($user->role == 'student_life') {
                $role = 'Student life';
              } elseif($user->role == 'student') {
                if($user->hall) {
                  $role = $user->hall->name;
                  $route = route('get.members', [$user->hall->name]);
                } else {
                  $role = $user->role;
                }
              }
             ?>
            <a href="{{$route}}" class="username" style="padding-top: 5px;">{{$role}}</a>

          </div><!-- .media-body -->
        </div><!-- .media -->
      </div><!-- .col-md-4 -->
    @endforeach
  </div><!-- .row -->
@endsection
