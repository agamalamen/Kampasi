@extends('layouts.school')
@section('title') {{$dsc->title}} @endsection
@section('app-content')
    <div class="row">
      <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar"
        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{$dsc->progress}}%">
          {{$dsc->progress}}%
          @if ($dsc->progress == 100)
            Completed
          @else
            In progress
          @endif
        </div><!-- .progress-bar -->
      </div><!-- .progress-->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-header">
            <img src="{{route('get.dsc.photo', $dsc->photo)}}" style="height: 40%; width: 100%">
          </div><!-- .panel-header -->
          <div class="panel-body">
            <h2 style="padding: 0px; margin: 0px; display:inline;">{{$dsc->title}}</h2>

            @if(Auth::User())
              @if($dsc->endorsement(Auth::User()->id) == '')
                <a class="pull-right" href="{{route('get.dsc.endorse', $dsc->id)}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$dsc->endorsements->count()}} Votes</p></a>
              @else
                <b><a class="pull-right" href="{{route('get.dsc.endorse', $dsc->id)}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$dsc->endorsements->count()}} Voted</p></a></b>
              @endif
            @else
              <a class="pull-right" href="{{route('get.dsc.endorse', $dsc->id)}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$dsc->endorsements->count()}} Votes</p></a>
            @endif

            <p style="padding-top: 5px;">{!! $dsc->description !!}</p>
          </div><!-- .panel-body -->
        </div><!-- .panel-default -->

        @if(Auth::User())
          @if($dsc->user_id == Auth::User()->id)
            <form class="form-inline" action="{{route('update.dsc.progress', $dsc->id)}}" method="post">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="progress" placeholder="Progress">
                  <div class="input-group-addon" style="border: 0px; font-size: 20px;"><b>%</b></div>
                </div>
              </div>
              <button type="submit" class="btn btn-lg btn-primary">Update progress</button>
              {{csrf_field()}}
            </form>
          @endif
        @endif

        <div class="panel panel-default">
          <div class="panel-header">
            <p style="padding: 10px; font-family: lato; font-weight: bold;">Share the coolness with the world</p>
          </div><!-- .panel-header -->
          <div class="panel-body">
            <div class="row text-center">
              <div class="col-xs-3">
                <a href="http://www.facebook.com/sharer.php?u={{route('get.dsc.project', $dsc->id)}}" target="_blank">
                   <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
               </a>
              </div><!-- .col-xs-3 -->
              <div class="col-xs-3">
                <a href="https://twitter.com/share?url={{route('get.dsc.project', $dsc->id)}}&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" target="_blank">
                    <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
                </a>
              </div><!-- .col-xs-3 -->
              <div class="col-xs-3">
                <a href="https://plus.google.com/share?url={{route('get.dsc.project', $dsc->id)}}" target="_blank">
                    <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />
                </a>
              </div><!-- .col-xs-3 -->
              <div class="col-xs-3">
                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{route('get.dsc.project', $dsc->id)}}" target="_blank">
                    <img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" />
                </a>
              </div><!-- .col-xs-3 -->
            </div><!-- .row -->
          </div><!-- .panel-body -->
        </div><!-- .panel-default -->
      </div><!-- .col-md-6 -->

      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row text-center">
              @foreach($dsc->creators as $creator)
              <div class="col-xs-3 text-center">
                <img class="img-circle" style="width: 75px; height: 75px;" src="{{route('get.avatar', $creator->user->avatar)}}">
                <p style="padding-top:3px;"><a href="{{route('dashboard', $creator->user->username)}}">
                  <?php
                    $name = explode(" ", $creator->user->name);
                   ?>
                  {{$name[0]}}
                </a></p>
              </div><!-- .col-xs -->
              @endforeach
            </div><!-- .row -->
          </div><!-- .panel-body -->
        </div><!-- .panel-default -->
        <h3 style="color: #333; font-family: lato;" class="text-center">Updates</h3>
        @if(Auth::User())
          @if(Auth::User()->id == $dsc->user_id)
            <div class="panel panel-default">
              <div class="panel-body">
                <form action="{{route('post.dsc.update', $dsc->id)}}" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <textarea name="content" class="form-control input-lg" placeholder="Your update goes here..."></textarea>
                  </div>
                  <div class="form-group">
                    <input name="photo" type="file" class="form-control input-lg">
                  </div>
                  <div class="form-group">
                    <input type="text" name="video" class="form-control input-lg" placeholder="Youtube video URL">
                  </div><!-- .form-group -->
                  <button type="submit" class="btn btn-primary btn-block btn-lg">Post</button>
                  {{ csrf_field() }}
                </form>
              </div><!-- .panel-body -->
            </div><!-- .panel-default -->
          @endif
        @endif
        @foreach($dsc->updates as $update)
          <div class="panel panel-default">
            @if($update->photo != 'no photo')
              <div class="panel-header">
                <img style="width: 100%; height: 50%" src="{{route('get.dsc.update.photo', $update->photo)}}" />
              </div><!-- .panel-header -->
            @endif
            @if($update->video != 'no video')
              <div class="panel-header">
                <?php
                  $width = '100%';
                  $height = '50%';
                ?>
                <iframe id="ytplayer" type="text/html" width="<?php echo $width ?>" height="<?php echo $height ?>"
                src="https://www.youtube.com/embed/<?php echo $update->video ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
                frameborder="0" allowfullscreen></iframe>
              </div><!-- .panel-header -->
            @endif
            <div class="panel-body">
              <p style="margin: 0px;">{{$update->content}}</p>
            </div><!-- .panel-body -->
          </div><!-- .panel-default -->
        @endforeach
      </div><!-- .col-md-6 -->
    </div><!-- .row -->
@endsection
