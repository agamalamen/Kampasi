@extends('layouts.school')
@section('title') Prep signup @endsection
@section('app-content')

  <ul class="list-unstyled" style="color: #333;">
    @foreach($masterpieces as $masterpiece)
      <li>
        {{$masterpiece->user->name}}
        {{$masterpiece->file}}
        <a href="{{URL::to('src/masterpieces/' . $masterpiece->file)}}" target="_blank">Download file</a>
      </li>
    @endforeach
  </ul>

@endsection
