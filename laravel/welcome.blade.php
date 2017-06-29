
@extends('layouts.app')

@section('meta')
  <meta name="description" content="Enhancing your campus experience.">
  <meta name="keywords" content="Education,Campus,African Leadership Academy, Elearning">
@endsection

@section('title') Kampasi • All your school in one place, online! @endsection

@section('content')
  <style>
    .home-container {
      background-image: url({{URL::to('src/img/home/honeydew.jpg')}});
      padding-top: 0px;
    }
  </style>

  <div class="home-container">
    <nav class="navbar navbar-default">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Kampasi</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="btn btn-primary" style="padding-right: 15px; padding-left: 15px; padding-top: 5px; padding-bottom: 5px; background-color: #44C6AC; font-weight: bold; opacity: 1; border: 0px; font-family: lato;">Get started</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
      <div class="row">
        <style>
          #introductionary-panel {
            background-image: url({{URL::to('src/img/home/desk.jpg')}});
            background-repeat:no-repeat;
            background-size:cover;
          }
        </style>
        <div class="col-md-8 text-center" id="introductionary-panel" style="border-radius: 5px; background-color: #44C6AC; height: 390px;">
          <i class="material-icons" style="font-size: 30px; padding-top: 100px;">explore</i>
          <h1 style="font-size: 32px; font-family: lato;">Enhancing your campus experience</h1>
          <p>This Card serves to confirm that the above named student has completed<br> the clearance procedures for exiting the Academy.</p>
          <a href="#" class="btn btn-primary" style="color: #44C6AC; margin-top: 10px; padding-right: 50px; text-transform: uppercase; letter-spacing: 1px; padding-left: 50px; padding-top: 10px; padding-bottom: 10px; background-color: white; font-weight: 600; font-size: 16px;">Login</a>
        </div><!-- .col-md-8 -->
        <div class="col-md-4" style="color: #333;">
          <div class="home-side-panel" style="border-radius: 5px; height: 123px; margin-bottom: 10px; background-color: #fff">
            <div class="row">
              <div class="col-md-4">
                <img src="{{URL::to('src/img/home/residential.png')}}" class="img-responsive center-block" style="height: 75px; width: 75px; margin-top: 20px;">
              </div><!-- .col-md-4 -->
              <div class="col-md-8">
                <h2 style="font-family: lato; font-size: 18px; font-style: italic; padding-top: 25px;" class="text-center"><a href="#" style="color: #44C6AC; font-weight: 400;">Residential</a></h2>
              </div><!-- .col-md-8 -->
            </div><!-- .row -->
        </div><!-- .col-md-4 -->
        <div class="home-side-panel" style="border-radius: 5px; height: 123px; margin-bottom: 10px; background-color: #fff">
            <div class="row">
              <div class="col-md-4">
                <img src="{{URL::to('src/img/home/extracurricals.png')}}" class="img-responsive center-block" style="height: 75px; width: 75px; margin-top: 20px;">
              </div><!-- .col-md-4 -->
              <div class="col-md-8">
                <h2 style="font-family: lato; font-size: 18px; font-style: italic; padding-top: 25px;" class="text-center"><a href="#" style="color: #44C6AC; font-weight: 400;">Extracurricurals</a></h2>
              </div><!-- .col-md-8 -->
            </div><!-- .row -->
        </div><!-- .col-md-4 -->
        <div class="home-side-panel" style="border-radius: 5px; height: 123px; margin-bottom: 10px; background-color: #fff">
            <div class="row">
              <div class="col-md-4">
                <img src="{{URL::to('src/img/home/academics.png')}}" class="img-responsive center-block" style="height: 75px; width: 75px; margin-top: 20px;">
              </div><!-- .col-md-4 -->
              <div class="col-md-8">
                <h2 style="font-family: lato; font-size: 18px; font-style: italic; padding-top: 25px;" class="text-center"><a href="#" style="color: #44C6AC; font-weight: 400;">Academics</a></h2>
              </div><!-- .col-md-8 -->
            </div><!-- .row -->
        </div><!-- .col-md-4 -->
      </div><!-- .row -->
    </div><!-- .container -->



  </div><!-- .homer-container -->

@endsection
