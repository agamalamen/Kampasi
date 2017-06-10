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
      <p class="card-title" style="padding-left: 0px;"><a href="{{route('get.inventories.settings', [Auth::User()->school->username])}}">Settings</a></p>
      <p class="card-title" style="padding-left: 0px;">Actions</p>
          <ul class="list-unstyled">
            @if(Auth::User()->authority)
              @if(Auth::User()->authority->create_inventory)
                <li><a href="#" data-toggle="modal" style="margin-bottom: 20px;" data-target="#createInventoryModal">Create inventory</a></li>
              @endif
            @endif
            @if(Auth::User()->authority->track_items)
              <li><a href="{{route('get.track.items', Auth::User()->school->username)}}">Track items</a></li>
            @endif
          </ul>
      <p class="card-title" style="padding-left: 0px;">Your invenvtory</p>
          <ul class="list-unstyled" style="color: #333;">
            @if(Auth::User()->items->count() == 0)
              <li>No items.</li>
            @endif
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
          @if(Auth::User()->authority->create_inventory)
            <a href="#" data-toggle="modal" style="margin-bottom: 20px;" data-target="#createInventoryModal">Create inventory</a>
          @endif
        </p>
      @endif
      @foreach(Auth::User()->school->inventories as $inventory)
        <div class="col-md-6">
          <div class="panel panel-primary" style="border: 0px; border-radius: 5px;">
            <div class="panel-header" style="height: 170px;" style="background-image: url('{{URL::to("src/img/resources/green.png")}}')">

            <style>
              .panel-header {
                background-image: url('{{URL::to('src/img/resources/green.png')}}');
              }
            </style>

              <p style="position: absolute; padding-left: 15px; font-size: 24px; top:40%; font-family: timeburner; font-weight: bold;"><a style= "color: white;"href="{{route('get.inventory', [Auth::User()->school->username, $inventory->name])}}">{{$inventory->name}}</a></p>
              <!--<img src="{{URL::to('src/img/resources/'. $inventory->color .'.png')}}" style="height: 25%; width: 100%">-->
            </div><!-- .panel-header -->
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
              <li style="color: grey; font-style: italic;">Recent:</li>
              @if($inventory->recentItems->count() == 0)
                <li>No items were added.</li>
              @endif
              @foreach($inventory->recentItems as $item)
                <?php
                  if (strlen($item->name) > 15) {
                            $item_name = substr($item->name, 0, 15) . '...';
                          } else {
                            $item_name = $item->name;
                          }
                  ?>
                <li><a href="{{route('get.item', [Auth::User()->school->username, $inventory->name, $item->name])}}">{{$item_name}}</a></li>
              @endforeach
              </ul>
              <!--<div class="form-group">
                <input id="search-single-inventory-input" style="border-radius: 5px; -webkit-box-shadow: none !important;-moz-box-shadow: none !important;box-shadow: none !important;" type="text" class="form-control" placeholder="Search for items in {{$inventory->name}}">
              </div>--><!-- .form-group -->
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
