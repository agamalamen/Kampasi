@extends('layouts.school')
@section('title') Candidate page @endsection
@section('app-content')

  <div class="row">
    <div class="col-md-6">
      <ul style="color: #333">
        @foreach(Auth::User()->school->users as $user)
          @if($user->voted)
            @foreach(Auth::User()->school->users as $other_user)
              @if($other_user->voted)
                @if($other_user->id != $user->id)
                  @if($user->name == $other_user->name)
                    <li>{{$user->name}} , {{$other_user->name}}</li>
                  @endif
                @endif
              @endif
            @endforeach
          @endif
        @endforeach
      </ul>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

@endsection
