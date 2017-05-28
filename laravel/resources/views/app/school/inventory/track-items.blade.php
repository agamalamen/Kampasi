@extends('layouts.school')
@section('title') Inventories @endsection
@section('app-header')
  <div class="school-header" style="margin-bottom: 10px; margin-top: -30px;">
    <h1 class="text-center" style="color: #fff; padding-top: 30px;font-family: Montserrat;">Items tracker</h1>
    <p class="text-center" style="padding-bottom: 30px;">All the resources you need, in one place.</p>
    <form style="margin-bottom: 40px;">
      <input type="text" id="search-members-input" style="font-size: 18px; font-family: arial; border: 0px; height: 50px;" placeholder="Find a new book, sport kit, science equipment..." class="form-control" autofocus>
    </form>
  </div><!-- .school-header -->
@endsection
@section('app-content')
  @include('includes.modals.create-inventory-modal')

  <div class="row">
    <div class="col-md-3">
      <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventories', Auth::User()->school->username)}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to all inventories</a></p>
    </div><!-- .col-md-3 -->
    <div class='col-md-9'>
      <ul class="list-group" style="color: #333;">
        @foreach(Auth::User()->school->users as $user)
          @foreach($user->items as $item)
            <li class="list-group-item">
              <a href="{{route('get.item', [Auth::User()->school->username, $item->inventory->name, $item->name])}}">{{$item->name}}</a>
              <p class="pull-right">{{$user->name}}</p>
              <p style="padding-top: 10px;"><b>Return date:</b> {{$item->pivot->return_date}}</p>
              <form style="display: inline;" action="{{route('post.item.returned', Auth::User()->school->username)}}" method="post">
                <input type="hidden" name="item" value={{$item->id}}>
                <input type="hidden" name="user" value={{$user->id}}>
                <button type="submit" class="btn btn-sm">Item returned</button>
                {{csrf_field()}}
              </form>
              <form style="display: inline;" action="{{route('post.item.missing', Auth::User()->school->username)}}" method="post">
                <input type="hidden" name="item" value={{$item->id}}>
                <input type="hidden" name="user" value={{$user->id}}>
                <button type="submit" class="btn btn-sm">Item missing</button>
                {{csrf_field()}}
              </form>
            </li>
          @endforeach
        @endforeach
      </ul>
    </div><!-- .col-md-9 -->

  </div><!-- .row -->
@endsection
