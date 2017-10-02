@extends('layouts.school')
@section('title') {{$user->name}} @endsection
@section('app-content')

<div class="row">
  <div class="col-md-4">
    <div class="panel panel-primary profile-gadget" style="border:0px;">
      <div id="avatar-contianer" class="panel-heading text-center" style="border: 0px; border-radius: 0px;">
        @if($user->source == 'google')
        <img id="avatar" class="img-circle" style="margin-bottom: -50px; margin-top: 70px; width: 80px; height: 80px;" src="{{URL::to($user->avatar)}}">
        @else
          <img id="avatar" class="img-circle" style="margin-bottom: -50px; margin-top: 70px; width: 80px; height: 80px;" src="{{route('get.avatar', $user->avatar)}}">
        @endif
        <script>
          avatar = "{{route('get.avatar', $user->avatar)}}";
        </script>
      </div> <!-- .panel-heading -->
      <div class="panel-body text-center">
        <h3 style="padding-top: 7px; font-family: lato; margin-bottom: 0px;">{{$user->name}}</h3>
        <a href="#" class="username"><?php echo '@'; ?>{{$user->username}}</a>
        <p>{{$user->bio}}</p>
        @if(Auth::User() == $user)
          @include('includes.modals.edit-avatar')
          @include('includes.modals.edit-bio')
          <a href="#" id="edit-bio" class="hidden" data-toggle="modal" data-target="#editBio">Edit bio</a> . <a href="#" data-toggle="modal" data-target="#editAvatar" id="edit-avatar" class="hidden">Edit avatar</a>
        @endif

      </div> <!-- .panel-body -->
    </div> <!-- .panel-default -->

    <div class="panel panel-primary">
      <div class="panel-body">
        <h3 style="font-family:lato;">About</h3>
        <ul class="list-unstyled">
          <li>{{$user->role}}</li>
          <li>{{$user->email}}</li>
          @if($user->school)
          <li>{{$user->school->name}}</li>
          @else
          <li>Not enrolled in a school. <a href="#">Join</a></li>
          @endif
          <li>{{$user->phone}}</li>
          @if($user->hall)
          <li>{{$user->hall->name}}</li>
          @endif
        </ul>
      </div> <!-- .panel-body -->
    </div> <!-- .panel-default -->


  </div> <!-- .col-md-4 -->

  @if($user->id == Auth::User()->id)
  <div class="col-md-8">
    <!--<div class="panel panel-default">
      <div class="panel-body">
        <form action="#" method="post">
          <div class="form-group">
            <input class="form-control input-lg" value="{{$user->name}}">
          </div>
          <div class="form-group">
            <input class="form-control input-lg" value="{{$user->email}}">
          </div>
          <input class="btn btn-primary btn-lg pull-right" style="font-family: lato;" type="submit" value="Update" >
          {{csrf_field()}}
        </form>
      </div>
    </div> -->

    <p class="card-title">Update email</p>
    <div class="panel panel-primary">
      <div class="panel-body">
        <form action="{{route('post.update.email')}}" method="post">
          <div class="form-group">
            <input type="email" class="form-control input-lg" placeholder="Email"
            value="{{$user->email}}" name="email">
          </div><!-- .form-group -->
          <div class="form-group">
            <input type="password" class="form-control input-lg" placeholder="Enter your password to confirm" name="password">
          </div><!-- .form-group -->
          <input class="btn btn-primary btn-lg pull-right" style="font-family: lato;" type="submit" value="Update email" >
          {{csrf_field()}}
        </form>
      </div><!-- .panel-body -->
    </div><!-- .panel-default -->

    <p class="card-title">Update password</p>
    <div class="panel panel-primary">
      <div class="panel-body">
        <form action="{{route('change.password')}}" method="post">
          <div class="form-group">
            <input type="password" class="form-control input-lg" placeholder="Old password" name="old_password">
          </div><!-- .form-group -->
          <div class="form-group">
            <input type="password" class="form-control input-lg" placeholder="New password" name="new_password">
          </div><!-- .form-group -->
          <div class="form-group">
            <input type="password" class="form-control input-lg" placeholder="Confirm new password" name="confirm_new_password">
          </div><!-- .form-group -->
          <input class="btn btn-primary btn-lg pull-right" style="font-family: lato;" type="submit" value="Change password" >
          {{csrf_field()}}
        </form>
      </div><!-- .panel-body -->
    </div><!-- .panel-default -->
  </div> <!-- .col-md-8 -->
  @endif

</div><!-- .row -->

@endsection
