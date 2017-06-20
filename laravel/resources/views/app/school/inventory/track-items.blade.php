@extends('layouts.school')
@section('title') Inventories @endsection
@section('app-header')
  <div class="school-header" style="margin-bottom: 10px; margin-top: -30px;">
    <h1 class="text-center" style="color: #fff; padding-top: 30px;font-family: Montserrat;">Items tracker</h1>
    <p class="text-center" style="padding-bottom: 30px;">All the resources you need, in one place.</p>
  </div><!-- .school-header -->
@endsection
@section('app-content')
  @include('includes.modals.create-inventory-modal')
  <div class="row">
    <div class="col-md-3">
      <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventories', Auth::User()->school->username)}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to all inventories</a></p>
    </div><!-- .col-md-3 -->
    <div class='col-md-9'>
      <select onchange="location = this.value;" data-live-search="true" name="user" class="selectpicker">
        @if($filterItem)
        <option value={{route('get.track.items', [Auth::User()->school->username, $filterItem->id])}}>{{$filterItem->name}}</option>
        @endif
        <option value={{route('get.track.items', [Auth::User()->school->username, 'all'])}}>All</option>
        @foreach(Auth::User()->school->items as $item)
          <option value={{route('get.track.items', [Auth::User()->school->username, $item->id])}}>{{$item->name}}</option>
        @endforeach
      </select>
      <ul class="list-group" style="color: #333; margin-top: 10px;">
        @foreach(Auth::User()->school->users as $user)
          @foreach($user->items as $item)
            @if($filterItem == '')
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
            @elseif($item->id == $filterItem->id)
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
            @endif
          @endforeach
        @endforeach
      </ul>
    </div><!-- .col-md-9 -->

  </div><!-- .row -->
@endsection
