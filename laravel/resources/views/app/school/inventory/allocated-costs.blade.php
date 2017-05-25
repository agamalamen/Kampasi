@extends('layouts.school')
@section('title') Inventories @endsection
@section('app-header')
  <div class="school-header" style="margin-bottom: 10px; margin-top: -30px;">
    <h1 class="text-center" style="color: #fff; padding-top: 30px;font-family: Montserrat;">Your allocated costs</h1>
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
      <p class="card-title" style="padding-left: 0px;">Actions</p>
      <ul class="list-unstyled">
        <li><a href="#" data-toggle="modal" style="margin-bottom: 20px;" data-target="#createInventoryModal">Create inventory</a></li>
      </ul>
    </div><!-- .col-md-3 -->
    <div class='col-md-9'>
      <ul class="list-group" style="color: #333;">
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
