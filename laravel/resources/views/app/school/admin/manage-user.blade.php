@extends('layouts.school')
@section('title') Manage user ({{$user->name}}) @endsection
@section('app-content')

<div class="row">
  <div class="col-md-6">
    <form action="{{route('post.update.user', $user->username)}}" method="post" enctype="multipart/form-data">

      <div class="form-group">
        <input name="name" type="text" class="form-control input-md" placeholder="Name" value="{{$user->name}}">
      </div>

      <div class="form-group">
        <input name="username" type="text" class="form-control input-md" placeholder="Username" value="{{$user->username}}">
      </div>

      <div class="form-group">
        <input name="email" type="email" class="form-control input-md" placeholder="Email" value="{{$user->email}}">
      </div>

      <div class="form-group">
        <select name="role" class="form-control input-md" placeholder="Role">
        <option value="{{$user->role}}">{{$user->role}}</option>
        <option value="student">Student</option>
        <option value="staffulty">Staffulty</option>
        <option value="alumni">Alumni</option>
        </select>
      </div>

      <div class="form-group">
        <input name="phone" type="number" class="form-control input-md" placeholder="Phone number" value="{{$user->phone}}">
      </div>

      @if($user->role == 'student')
        <div class="form-group">
          <select name="hall" class="form-control input-md" placeholder="Hall">
          @foreach(Auth::User()->school->halls as $hall)
            <option value="{{$hall->id}}">{{$hall->name}}</option>
          @endforeach
          </select>
        </div>
      @endif

      <div class="form-group">
        <input name="room" type="text" class="form-control input-md" placeholder="Room" value="{{$user->room}}">
      </div>

      <button type="submit" style="margin-top: 5px;" class="btn btn-primary btn-block btn-md">Update</button>
      {{ csrf_field() }}

    </form>
  </div><!-- .col-md-6 -->

  <div class="col-md-6">
  <a href="{{route('delete.account', $user->id)}}" class="pull-right" style="color: red;">Delete account</a>
  </div><!-- .col-md-6 -->
</div><!-- .row -->

@endsection
