@extends('layouts.school')
@section('title') Candidate page @endsection
@section('app-content')

  <div class="row">
    <div class="col-md-6">
      <ul style="color: #333">
        @foreach(Auth::User()->school->users as $user)
          @if($user->voted)
          <li>{{$user->name}}</li>
          @endif
        @endforeach
      </ul>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

@endsection
