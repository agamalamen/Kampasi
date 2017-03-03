@extends('layouts.school')
@section('title') Classrooms - {{$school->name}} @endsection
@section('app-header') @include('includes.school-header') @endsection
@section('app-list') @include('includes.school-list') @endsection
@section('app-content')
  <div class="row">
    @foreach($school->classrooms as $classroom)
    <div class="col-md-4">
      <div class="default panel-default">
        <div class="panel-body" style="border: 1px solid #ddd; border-radius: 3px;">
          <h2 style="margin: 0px;">{{$classroom->name}}<h2>
          <ul class="list-inline">
            <li><img class="img-circle" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"</li>
            <li><img class="img-circle" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"</li>
            <li><img class="img-circle" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"</li>
            <li><img class="img-circle" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"</li>
            <li><img class="img-circle" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"</li>
          </ul>
          @if(Auth::User()->classrooms->find($classroom->id))
          <a class="btn btn-primary btn-block btn-lg" style="border-radius: 3px;" href="{{route('get.classroom', [$school->username, $classroom->username])}}">Go to classroom</a>
          @else
          <a class="btn btn-default btn-block btn-lg" style="border-radius: 3px;" href="#">Ask to join</a>
          @endif
        </div><!-- .panel-body -->
      </div><!-- .panel-default -->
    </div><!-- .col-md-4 -->
    @endforeach
  </div><!-- .row -->
@endsection
