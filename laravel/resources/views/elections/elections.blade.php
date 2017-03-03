@extends('layouts.app')
@section('title') ALA elections @endsection

<div style="background-color: white; color: #27ae60; height: 5%; text-align: center;">
  <a id="alaelections" href="{{route('get.elections', ['ala'])}}" style="color: #27ae60"><h1 id="alaelections2016" style="margin-top: 0px; padding-top: 5px; padding-bottom: 5px; font-family: lato; font-size: 20px;">ALA <b>Elections</b> of 2016</h1></a>

</div>

<style>
  #alaelections:hover {
    text-decoration: none;
  }

  #alaelections2016:hover {
    color: #2ecc71;
  }
  i {
    color: #95a5a6;
    padding-right: 10px;
    padding-left: 10px;
  }

  i:hover {
    color: #bdc3c7;
  }

</style>

<div class="container">
  <div class="row" style="padding-top: 8%;">
    @foreach($ITreps as $ITrep)
    <div class="col-md-3" style="padding-top: 3%;">
      <div class="panel">
        <div class="panel-header text-center">
          <img src=<?php echo URL::to('src/img/elections/' . $ITrep->id . '.jpg') ?> class="img-circle" style="margin-top: -30px; width: 150px; height: 150px;">
        </div><!-- .panel-heading -->
        <div class="panel-body">
          <h2 style="text-transform: uppercase; font-weight: bold; text-align: center;">{{$ITrep->name}}</h2>
          <h3 style="color: #333; font-size: 20px; margin-top: -5px; text-align: center;">{{$ITrep->position}}</h3>
          <p style="color: #333; padding-top: 5px; text-align: left; text-align: center;">{{$ITrep->summary}}</p>
          <div style="padding-top: 10px;">
          @if(Auth::User())
            @if($ITrep->endorsement(Auth::User()->id) == '')
              <a href="{{route('endorse', ['ala', $ITrep->id])}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$ITrep->endorsements->count()}} Endorse</p></a>
            @else
              <b><a href="{{route('endorse', ['ala', $ITrep->id])}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$ITrep->endorsements->count()}} Endorsed</p></a></b>
            @endif
          @else
          <a href="{{route('endorse', ['ala', 0])}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$ITrep->endorsements->count()}} Endorse</p></a>
          @endif
          <a class="pull-right" href="{{ route('get.election', ['ala', $ITrep->username])}}">Read more <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
          </div>
        </div><!-- .panel-body -->
        <div class="panel-footer">
          <ul class="list-inline text-center">
            <li><a href="{{$ITrep->facebook}}" target="_blank"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a></li>
            <li><a href="{{$ITrep->twitter}}" target="_blank"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a></li>
            <li><a href="{{$ITrep->linkedin}}" target="_blank"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a></li>
          </ul>
        </div><!-- .panel-footer -->
      </div><!-- .panel -->
    </div><!-- .col-md-3 -->
    @endforeach
  </div><!-- .row -->
</div><!-- .container -->

<footer style="margin-top: 5%">
  <p class="text-center">Powered by Ahmed Gamal</p>
</footer>
