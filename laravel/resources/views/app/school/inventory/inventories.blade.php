@extends('layouts.school')
@section('title') Inventories @endsection
@section('app-header')
  <div class="school-header" style="margin-bottom: 10px; margin-top: -30px;">
    <h1 class="text-center" style="color: #fff; padding-top: 30px;font-family: lato; font-size: 42px; font-weigt: bold;">ALA inventory</h1>
    <p class="text-center" style="padding-bottom: 30px;">All the resources you need, in one place.</p>
    <form style="margin-bottom: 40px;">
      <div class="input-group stylish-input-group">
        <span class="input-group-addon">
          <button type="submit">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
        <input type="text" id="search-inventory-input" style="font-size: 18px; font-family: arial; border: 0px; height: 50px;" placeholder="Find a new book, sport kit, science equipment..." class="form-control">
      </div><!-- stylish input group -->
    </form>

    <script>
      var searchInventoryRoute = "{{route('get.search.inventory', [Auth::User()->school->username])}}";
      var itemsLoading = "{{URL::to('src/img/loading/rolling.gif')}}";
    </script>

    <style>
    .stylish-input-group .input-group-addon{
    background: white !important;
    }
    .stylish-input-group .form-control{
    	border-right:0;
    }
    .stylish-input-group button{
        border:0;
        border-radius: 0px;
        background:transparent;
    }
    </style>
  </div><!-- .school-header -->
@endsection
@section('app-content')
  @include('includes.modals.create-inventory-modal')
  <div class="row">
    <div class="col-md-3">
      <p class="card-title" style="padding-left: 0px;">Actions</p>
          <ul class="list-unstyled">
            @if(Auth::User()->authority)
              @if(Auth::User()->authority->create_inventory)
                <li><a href="#" data-toggle="modal" style="margin-bottom: 20px;" data-target="#createInventoryModal">Create inventory</a></li>
              @endif
            @endif
            <li><a href="{{route('get.track.items', Auth::User()->school->username)}}">Track items</a></li>
          </ul>
      <p class="card-title" style="padding-left: 0px;">Your invenvtory</p>
          <ul class="list-unstyled" style="color: #333;">
            @foreach(Auth::User()->items as $item)
            <li>{{$item->name}}</li>
            @endforeach
            <li><a href="{{route('get.user.inventory', [Auth::User()->school->username, Auth::User()->username])}}">See all</a></li>
          </ul>

      <p class="card-title" style="padding-left: 0px;">Allocated costs</p>
      <ul style="color: #333; padding-left: 0px;">
        @foreach(Auth::User()->allocatedCosts as $cost)
        <li>R{{$cost->item->cost}} - {{$cost->item->name}}</li>
        @endforeach
        <?php
          $total = 0;
          foreach(Auth::User()->allocatedCosts as $cost) {
            $total += $cost->item->cost;
          }
         ?>
        <li>Total: R{{$total}}</li>
        <li style="list-style: none;"><a href="{{route('get.user.allocated.costs', [Auth::User()->school->username, Auth::User()->username])}}">See all</a></li>
      </ul>

    </div><!-- .col-md-3 -->

    <div class="col-md-9" id="inventories">
      @if(Auth::User()->school->inventories->count() == 0)
        <p class="text-center" style="color: grey; font-style: italic;">
          No inventories were found. 
          <a href="#" data-toggle="modal" style="margin-bottom: 20px;" data-target="#createInventoryModal">Create inventory</a>
        </p>
      @endif
      @foreach(Auth::User()->school->inventories as $inventory)
        <div class="col-md-6">
          <div class="panel panel-primary" style="border: 0px; border-radius: 5px;">
            <div class="panel-header">
              <img src="{{URL::to('src/img/resources/'. $inventory->color .'.png')}}" style="height: 25%; width: 100%">
            </div><!-- .panel-header -->
            <div class="panel-body">
              <p class="card-title" style="padding-left: 0px; font-style: normal;"><a href="{{route('get.inventory', [Auth::User()->school->username, $inventory->name])}}">{{$inventory->name}}</a></p>
              <hr>
              <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> {{$inventory->items->count()}}
              <p class="pull-right"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{$inventory->views}}</p>
            </div><!-- .panel-body -->
          </div><!-- .panel -->
        </div><!-- .col-md-6 -->
      @endforeach
    </div><!-- .col-md-9 -->
  </div><!-- .row -->
@endsection
