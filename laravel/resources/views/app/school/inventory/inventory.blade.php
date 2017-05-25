@extends('layouts.school')
@section('title') {{$inventory->name}} @endsection
@section('app-content')
  @include('includes.modals.add-item-modal')
  @include('includes.modals.add-inventory-attribute-modal')
  @include('includes.modals.add-inventory-owner-modal')

  <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventories', Auth::User()->school->username)}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to all inventories</a></p>

  <div class="panel panel-primary">
    <div class="panel-body">
      <form id="search-items-form" style="margin-bottom: 0px;">
        <input type="text" id="search-items-input" style="margin-bottom: 0px; border-radius: 3px;" placeholder="Search for items..." class="form-control" >
      </form>
      <script>
      var searchItemsRoute = "{{route('get.search.inventory', [Auth::User()->school->username, $inventory->name])}}";
      var itemsLoading = "{{URL::to('src/img/loading/rolling.gif')}}";
      </script>
    </div><!-- .panel-body -->
  </div><!-- .panel -->

  <div id="style-1">

  </div><!-- .style-1 -->

  <div class="row">
    <div class="col-md-3">
      <div class="panel panel-primary" style="border: 0px;">
        <div class="panel-header">
          <img src="{{URL::to('src/img/resources/'. $inventory->color .'.png')}}" style="height: 25%; width: 100%">
        </div><!-- .panel-header -->
        <div class="panel-body">
          <p class="card-title" style="padding-left: 0px; font-style: normal;"><a href="{{route('get.inventory', [Auth::User()->school->username, $inventory->name])}}">{{$inventory->name}}</a></p>
          <ul class="list-unstyled list-inline">
            @if($inventory->users->count() == 0)
              <li style="color: grey; font-style: italic;">No owners were added. <a href="#" data-toggle="modal" data-target="#addInvnetoryOwnerModal">Add owner</a></li>
            @endif
            @if($inventory->users->count() > 3)
              @foreach($inventory->recentUsers as $user)
                <li><a href="{{route('dashboard', $user->username)}}"><img  alt="{{$user->name}}" id="avatar" class="img-circle" style="width: 50px; height: 50px;" src="{{route('get.avatar', $user->avatar)}}"></a></li>
              @endforeach
                <li><span class="badge">+{{$inventory->users->count() - 3}}</span></li>
            @else
              @foreach($inventory->users as $user)
              <li><a href="{{route('dashboard', $user->username)}}"><img id="avatar" class="img-circle" style="width: 50px; height: 50px;" src="{{route('get.avatar', $user->avatar)}}"></a></li>
              @endforeach
            @endif
          </ul>
          <hr>
          <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> {{$inventory->items->count()}}
          <p class="pull-right"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{$inventory->views}}</p>
        </div><!-- .panel-body -->
      </div><!-- .panel -->

      <p class="card-title" style="padding-left: 0px;">Actions</p>
      <ul class="list-unstyled">
        <li><a href="#" data-toggle="modal" style="margin-bottom: 20px;" data-target="#addItemModal">Add item</a></li>
        <li><a href="#" data-toggle="modal" style="margin-bottom: 20px;" data-target="#addInvnetoryOwnerModal">Add owner</a></li>
      </ul>
      <p class="card-title" style="padding-left: 0px;">Attributes</p>
      <ul class="list-unstyled" style="color: #333;">
        @if($inventory->attributes->count() == 0)
        <p style="color: grey; font-style: italic;">No attributes were added.</p>
        @endif
        @foreach($inventory->attributes as $attribute)
        <li>{{$attribute->name}}</li>
        @endforeach
        <li><a href="#" data-toggle="modal" style="margin-bottom: 20px;" data-target="#addInventoryAttributeModal">Add attributes</a></li>
      </ul>
    </div><!-- .col-md-3 -->
    <div class="col-md-9">
      @if($items->count() == 0)
        <p style="color: grey; font-style: italic;" class="text-center">No items were added. <a href="#" data-toggle="modal" data-target="#addItemModal">Add item</a></p>
      @endif
      @foreach(array_chunk($items->getCollection()->all(), 2) as $row)
        <div class="row">
          @foreach($row as $item)
            <div class="col-md-6">
              <div class="panel panel-primary" style="border-radius: 5px;">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-3">
                      <img class="img-rounded img-responsive" style="width: 50px; height: 50px;" src="{{URL::to('src/img/tools/dsc.png')}}">
                    </div><!-- .col-md-4 -->
                    <div class="col-md-8">
                      <a href="{{route('get.item', [Auth::User()->school->username, $inventory->name, $item->name])}}">{{$item->name}}</a>
                      <p>In stock: {{$item->stock}}</p>
                    </div><!-- .col-md-8 -->
                  </div><!-- .row -->
                  <div class="dropdown pull-right">
                    <a href="#" style="color: #333;" id="itemSettingsMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="itemSettingsMenu">
                      <li><a href="{{route('delete.item', [Auth::User()->school->username, $item->id])}}">Delete item</a></li>
                      <li><a href="{{route('get.edit.item', [Auth::User()->school->username, $item->inventory->name, $item->name])}}">Edit item</a></li>
                    </ul>
                  </div><!-- .drop-down -->
                </div><!-- .panel-body -->
              </div><!-- .panel -->
            </div><!-- .col-md-6 -->
          @endforeach
        </div><!-- .row -->
      @endforeach
      {{$items->links()}}
    </div><!-- .col-md-9 -->
  </div><!-- .row -->
@endsection
