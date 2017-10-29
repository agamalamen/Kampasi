@extends('layouts.school')
@section('title') Off campus @endsection
@section('app-content')
      <p style="color: #333;"> <a href="#" style="color: #27ae60;" id="filter-results">See more <span class="caret"></span></a> <span class="pull-right">Showing {{count($requests)}} off campus requests</span></p>
      <div id="statuses" class="row" style="display: none;">
        @if (Auth::User()->role != 'student')
        <div class="col-sm-2">
          <ul class="list-unstyled">
            <li style="color: #333;"><b>Filter by status</b></li>
            <li><a href="{{route('off.campus', ['all'])}}">All</a><li>
            <li><a href="{{route('off.campus', ['accepted'])}}">Accepted</a><li>
            <li><a href="{{route('off.campus', ['departed'])}}">Departed</a><li>
            <li><a href="{{route('off.campus', ['arrived'])}}">Arrived</a><li>
          </ul>
        </div><!-- .col-md-4 -->
        <div class="col-sm-4">
          <ul class="list-unstyled">
            <li style="color: #333;"><b>Filter by time</b></li>
            <li><a href="{{route('off.campus', ['all'])}}">All</a><li>
            <li><a href="{{route('off.campus', ['departing_today'])}}">Departing today</a><li>
            <li><a href="{{route('off.campus', ['returning_today'])}}">Returning today</a><li>
            <li><a href="{{route('off.campus', ['created_today'])}}">Created today</a><li>
          </ul>
        </div><!-- .col-md-4 -->
        @endif
        <div class="col-sm-4">
          <ul class="list-unstyled">
            <li style="color: #333;"><b>Available chaperones</b></li>
            @foreach(Auth::User()->school->availableChaperones as $available)
              @if($available->date == date('Y-m-d'))
                <li style="color: #333;"><a href="{{route('dashboard', $available->user->username)}}">{{$available->user->name}}</a></li>
              @endif
            @endforeach
            </ul>
        </div><!-- .col-md-4 -->
      </div><!-- .statuses  .row -->
    <table class="table" style="color:#333; font-family: lato;">
      <tr>
        <th class="visible-lg visible-md">#</th>
        <th>Name</th>
        <th class="visible-lg visible-md">Phone phone</th>
        <th>Place</th>
        <th class="visible-lg visible-md">Departure time</th>
        <th class="visible-lg visible-md">Return time</th>
        <th class="visible-lg visible-md">Status</th>
        <th>Tracking</th>
      </tr>
      @if (Auth::User()->role != 'student')
        @foreach($requests as $request)
          @if($request->user)
          <tr>
            <td class="visible-lg visible-md">{{$request->id}}</td>
            <td>{{$request->user->name}}</td>
            <td class="visible-lg visible-md">{{$request->user->phone}}</td>
            <td>{{$request->place}}</td>
            <td class="visible-lg visible-md">{{$request->departure_time}}</td>
            <td class="visible-lg visible-md">{{$request->arriving_time}}</td>
            <td class="visible-lg visible-md">
              @if($request->arrived)
                Arrived
              @elseif($request->departed)
                Departed

              @elseif($request->driver_approval == 'accepted' && $request->student_life_approval == 'accepted' && $request->security_approval == 'accepted')
                Accepted
              @elseif($request->driver_approval == 'declined' || $request->student_life_approval == 'declined' || $request->security_approval == 'declined')
                Declined
              @elseif($request->driver_approval == 'waiting' && $request->student_life_approval == 'waiting' && $request->security_approval == 'waiting')
                Hold
              @else
                In progress
              @endif
            </td>
            <td><a href="{{route('get.off.campus.request', $request->id)}}">See details</a></td>
          </tr>
          @endif
        @endforeach
      @else
          @foreach(Auth::User()->offCampusRequests as $request)
            <tr>
              <td class="visible-lg visible-md">{{$request->id}}</td>
              <td>{{$request->user->name}}</td>
              <td class="visible-lg visible-md">{{$request->user->phone}}</td>
              <td>{{$request->place}}</td>
              <td class="visible-lg visible-md">{{$request->departure_time}}</td>
              <td class="visible-lg visible-md">{{$request->arriving_time}}</td>
              <td class="visible-lg visible-md">
                @if($request->driver_approval == 'accepted' && $request->student_life_approval == 'accepted' && $request->security_approval == 'accepted')
                  Accepted
                @elseif($request->driver_approval == 'Declined' || $request->student_life_approval == 'declined' || $request->security_approval == 'declined')
                  Declined
                @elseif($request->driver_approval == 'waiting' && $request->student_life_approval == 'waiting' && $request->security_approval == 'waiting')
                  Hold
                @else
                  In progress
                @endif
              </td>
              <td><a href="{{route('get.off.campus.request', $request->id)}}">See details</a></td>
            </tr>
          @endforeach
        @endif
    </table>
    @if (Auth::User()->offCampusRequests == '[]' && Auth::User()->role == 'student')
      <p style="color:#333" class="text-center">You have nothing to show</p>
    @endif
  <!-- Trigger the modal with a button -->

  @if(Auth::User()->role == 'student')
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" style="margin-bottom: 20px;" data-target="#offCampusRequestModal">Request off-campus</button>
  @else
    <form action="{{route('post.available.chaperones')}}" method="post">
      <button type="submit" class="btn btn-primary btn-lg">Add yourself as available chaperones for today</button>
      {{csrf_field()}}
    </form>
  @endif

  @include('includes.modals.off-campus-request')

@endsection
