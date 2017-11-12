@extends('layouts.school')
@section('title') Candidate page @endsection
@section('app-content')

  <div class="row">
    <div class="col-md-6">
      <ul style="color: #333">
        @foreach($users as $user)
          <li>{{$user->name}}</li>
        @endforeach
      </ul>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

@endsection
