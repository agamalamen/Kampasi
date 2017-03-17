@extends('layouts.school')
@section('title') Manage external chaperones @endsection
@section('app-content')
  <div class="row" style="color: #333;">
    @if(Auth::User()->role != 'student')
      <div class="col-md-6">
        <h2 style="font-size: 24px;">External chaperones list</h2>
        <ul class="list-unstyled">
        @foreach(Auth::User()->school->externalChaperones as $chaperone)
          <li>
            <h3 style="font-size: 18px; margin-bottom: -1px;">{{$chaperone->name}}
              @if($chaperone->approved)
                <span style="font-size: 12px; color: #27ae60;">Approved</span>
              @else
                @if(Auth::User()->role == 'student_life')
                  <a style="font-size: 12px;" href="{{route('get.approve.external.chaperone', $chaperone->id)}}">(Approve)</a>
                @else
                <span style="font-size: 12px; color: grey">Not approved</span>
                @endif
              @endif
            </h3>
            <p style="margin-bottom: -2px; color: grey; font-style: italic;">{{$chaperone->phone}}</p>
            <p style="margin-bottom: -2px; color: grey; font-style: italic;">{{$chaperone->email}}</p>
            <p style="color: grey; font-style: italic;">Submited by: <a href="{{route('dashboard', $chaperone->user->username)}}">{{$chaperone->user->name}}</a></p>
          </li>
        @endforeach
        </ul>
      </div><!-- .col-md-6 -->

    @elseif(Auth::User()->role == 'student')
      <div class="col-md-6">
        <h2 style="font-size: 24px;">External chaperones list</h2>
        <ul class="list-unstyled">
        @foreach(Auth::User()->externalChaperones as $chaperone)
          <li>
            <h3 style="font-size: 18px; margin-bottom: -1px;">{{$chaperone->name}}
              @if($chaperone->approved)
                <span style="font-size: 12px; color: #27ae60;">Approved</span>
              @else
                @if(Auth::User()->role == 'student_life')
                  <a style="font-size: 12px;" href="{{route('get.approve.external.chaperone', $chaperone->id)}}">(Approve)</a>
                @endif
              @endif
            </h3>
            <p style="margin-bottom: -2px; color: grey; font-style: italic;">{{$chaperone->phone}}</p>
            <p style="color: grey; font-style: italic;">{{$chaperone->email}}</p>
          </li>
        @endforeach
        </ul>
      </div><!-- .col-md-6 -->
      <div class="col-md-6">
        Add chaperone
        <form id="post-feedback" action="{{route('post.external.chaperone')}}" method="post">
          <input name="name" type="text" class="form-control input-sm" placeholder="Name*" style="margin-bottom: 5px;" value="{{ old('name') }}">
          <input name="phone" type="number" class="form-control input-sm" placeholder="Phone*" style="margin-bottom: 5px;" value="{{ old('phone') }}">
          <input name="email" type="email" class="form-control input-sm" placeholder="Email*" style="margin-bottom: 5px;" value="{{ old('email') }}">
          <button id="post-feedback-button" type="submit" class="pull-right btn btn-primary">Submit</button>
          {{ csrf_field() }}
        </form>
      </div><!-- .col-md-6 -->
    @endif
  </div><!-- .row -->
@endsection
