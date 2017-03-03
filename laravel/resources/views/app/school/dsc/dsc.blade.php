@extends('layouts.school')
@section('title') Do something cool! @endsection
@section('app-content')
<h1 class="text-center" style="color: #333; font-family: lato; margin: 0px; padding-bottom: 20px;">Do Something Cool <a href="{{route('get.create.dsc')}}" class="badge">Create</a></h1>
<div class="text-center" style="padding-bottom: 20px; font-size: 24px; font-weight: bold;">
  <span style="color: #333; padding-right: 30px;"><span class="badge">{{$school->dscs->count()}}</span> Projects</span>
  <a href="{{route('get.dsc.updates')}}"><span class="badge">{{$updates->count()}}</span> Updates</a>
</div><!-- .links -->
<div class="row">
  @foreach($school->dscs as $dsc)
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-header">
          <img src="{{route('get.dsc.photo', $dsc->photo)}}" style="height: 40%; width: 100%">
        </div><!-- .panel-header -->
        <div class="panel-body">
          <?php
            if (strlen($dsc->title) > 40) {
              $dsc_title = substr($dsc->title, 0, 40) . '...';
            } else {
              $dsc_title = $dsc->title;
            }
           ?>
          <h2 style="padding: 0px; margin: 0px;"><a href="{{route('get.dsc.project', $dsc->id)}}">{{$dsc_title}}</a></h2>
          <div class="progress" style="margin-top: 10px;">
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
          <ul style="margin-left: 8px;" class="list-inline list-unstyled">
            @foreach($dsc->threeCreators as $creator)
            @if($creator->user)
              <li style="text-center; margin-left: -10px;">
                <a href="{{route('dashboard', $creator->user->username)}}"><img class="img-circle" style="width: 50px; height: 50px;" src="{{route('get.avatar', $creator->user->avatar)}}"></a>
              </li>
            @endif
            @endforeach
            @if ($dsc->creators->count() > 3)
              <li style="margin-left: 10px;"><span class="badge">+{{$dsc->creators->count() - 3}} more</span></li>
            @endif
          </ul>

          @if (Auth::User())
            @if($dsc->endorsement(Auth::User()->id) == '')
              <a href="{{route('get.dsc.endorse', $dsc->id)}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$dsc->endorsements->count()}} Votes</p></a>
            @else
              <b><a href="{{route('get.dsc.endorse', $dsc->id)}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$dsc->endorsements->count()}} Voted</p></a></b>
            @endif
          @else
            <a href="{{route('get.dsc.endorse', $dsc->id)}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$dsc->endorsements->count()}} Votes</p></a>
          @endif
          <a class="pull-right" href="{{route('get.dsc.project', $dsc->id)}}">Know more <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
        </div><!-- .panel-body -->
      </div><!-- .panel-default -->
    </div><!-- .col-md-6 -->
  @endforeach
</div><!-- .row -->
@endsection
