@extends('layouts.school')
@section('title') Create user manually @endsection
@section('app-content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <h2 style="color: #333; font-size: 30px;">Create a new user</h2>
    <form action="{{route('post.create.user.manually')}}" method="post" enctype="multipart/form-data">

      <div class="form-group">
        <input name="name" type="text" class="form-control input-lg" placeholder="Name">
      </div>

      <div class="form-group">
        <input name="username" type="text" class="form-control input-lg" placeholder="Username">
      </div>

      <div class="form-group">
        <input name="email" type="email" class="form-control input-lg" placeholder="Email">
      </div>

      <div class="form-group">
        <select name="role" class="form-control input-lg" placeholder="Role">
        <option value="student">Student</option>
        <option value="staffulty">Staffulty</option>
        <option value="alumni">Alumni</option>
        </select>
      </div>


      <button type="submit" style="margin-top: 5px;" class="btn btn-primary btn-block btn-lg">Create</button>
      {{ csrf_field() }}

    </form>
  </div><!-- .col-md-8 -->
</div><!-- .row -->

@endsection
