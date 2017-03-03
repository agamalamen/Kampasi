@extends('layouts.school')
@section('title') Do something cool! @endsection
@section('app-content')
  <h1 class="text-center" style="color: #333; font-family: lato; margin: 0px; padding-bottom: 20px;">Do Something Cool <a href="{{route('get.create.dsc')}}" class="badge">Create</a></h1>
  <div class="text-center" style="padding-bottom: 20px; font-size: 24px; font-weight: bold;">
    <a href="{{route('get.dsc')}}"><span class="badge">{{$school->dscs->count()}}</span> Projects</a>
    <span style="color: #333; padding-left: 30px;"><span class="badge">{{$updates->count()}}</span>  Updates</span>
  </div><!-- .links -->
  <div class="row" style="color: #333">
    @foreach($updates as $update)
      @if($update->dsc)
      <div class="col-md-4">
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
            <a href="#">{{$update->dsc->title}}</a>
            <p style="margin: 0px;">{{$update->content}}</p>
          </div><!-- .panel-body -->
        </div><!-- .panel-default -->
      </div><!-- .col-md-4 -->
      @endif
    @endforeach
  </div><!-- .row -->

@endsection
