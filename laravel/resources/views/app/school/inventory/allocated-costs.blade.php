@extends('layouts.school')
@section('title') Inventories @endsection
@section('app-header')
  <div class="school-header" style="margin-bottom: 10px; margin-top: -30px;">
    <h1 class="text-center" style="color: #fff; padding-top: 30px;font-family: Montserrat;">{{$user->name}}'s allocated costs</h1>
    <p class="text-center" style="padding-bottom: 30px;">All the resources you need, in one place.</p>
    <form style="margin-bottom: 40px;">
      <input type="text" id="search-members-input" style="font-size: 18px; font-family: arial; border: 0px; height: 50px;" placeholder="Find a new book, sport kit, science equipment..." class="form-control" autofocus>
    </form>
  </div><!-- .school-header -->
@endsection
@section('app-content')
  @include('includes.modals.create-inventory-modal')
  <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventories', Auth::User()->school->username)}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to all inventories</a></p>

  <div class="row">
    <div class='col-md-8 col-md-offset-2'>
      <select onchange="location = this.value;" data-live-search="true" name="user" class="selectpicker">
        <option>{{$user->name}}</option>
        @foreach(Auth::User()->school->users as $selectUser)
          <option value={{route('get.user.allocated.costs', [Auth::User()->school->username, $selectUser->username])}}>{{$selectUser->name}}</option>
        @endforeach
      </select>
      <ul class="list-group" style="color: #333; margin-top: 10px;">
        @foreach($user->allocatedCosts as $cost)
          <li class="list-group-item">
            <p style="display: inline; font-size: 18px;"><b>R{{$cost->item->cost}}</b></p>
            <a style="display: inline;" class="pull-right" href="{{route('get.item', [Auth::User()->school->username, $cost->item->inventory->name, $cost->item->name])}}">{{$cost->item->name}}</a>
            <form action="{{route('post.item.paid', Auth::User()->school->username)}}" method="post">
              <input type="hidden" name="item" value={{$cost->item->id}}>
              <input type="hidden" name="user" value={{$user->id}}>
              <button type="submit" class="btn btn-sm">Paid</button>
              {{csrf_field()}}
            </form>
          </li>
        @endforeach
        <?php
          $total = 0;
          foreach($user->allocatedCosts as $cost) {
            $total += $cost->item->cost;
          }
         ?>
        <li class="list-group-item" style="font-size: 18px; font-weight: bold;">
          Total: R{{$total}}
          <form class="pull-right" action="{{route('post.all.items.paid', Auth::User()->school->username)}}" method="post">
            <input type="hidden" name="user" value={{$user->id}}>
            <button type="submit" class="btn btn-sm">All paid</button>
            {{csrf_field()}}
          </form>
        </li>
      </ul>
    </div><!-- .col-md-9 -->

  </div><!-- .row -->
@endsection
