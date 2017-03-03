@extends('layouts.school')
@section('title') Notifications @endsection
@section('app-content')
  <div class="panel panel-default">
    <div class="panel-body">
      <ul class="list-unstyled">
        @foreach(Auth::User()->allNotifications as $notification)
          @if($notification->seen)
            <li style="color: #333; font-size: 12px; padding: 10 30 10 30px; opacity: 0.5">
              <a style="padding:0px;" href="{{$notification->route}}">{{$notification->message}}</a>
            </li>
          @else
            <li style="color: #333; font-size: 12px; padding: 10 30 10 30px;">
              <form action="{{route('proccess.notification')}}" method="post">
                <input type="hidden" name="route" value="{{$notification->route}}">
                <input type="hidden" name="notification_id" value="{{$notification->id}}">
                <button type="submit" style="padding:0px; border:0px; background-color: #fff; color: #27ae60"><i class="fa fa-circle-o" aria-hidden="true" style="color: #e74c3c;"></i> {{$notification->message}}</button>
                {{csrf_field()}}
              </form>
            </li>
          @endif
        @endforeach
      </ul>
      @if(Auth::User()->allNotifications == '[]')
        <p style="color:#333">You have no notifications to show</p>
      @endif
    </div>
  </div><!-- .panel-default -->
@endsection
