@extends('layouts.school')
@section('title') {{$inventory->name}} settings @endsection
@section('app-content')
  @include('includes.modals.add-item-modal')
  @include('includes.modals.add-inventory-attribute-modal')
  @include('includes.modals.add-inventory-owner-modal')
  @include('includes.modals.delete-inventory-modal')

  <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventory', [Auth::User()->school->username, $inventory->name])}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to {{$inventory->name}}</a></p>

  
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-body">
        <p class="card-title">Inventory name</p>
          <form action="{{route('post.update.inventory.name', [Auth::User()->school->username, $inventory->name])}}" method="post">
            <div class="input-group">
              <input type="text" class="form-control" name="name" placeholder="Inventory name" value="{{$inventory->name}}">
              <span class="input-group-btn">
              <button class="btn btn-default" type="submit">Update</button>
              {{csrf_field()}}
              </span>
            </div><!-- /input-group -->
          </form>

          <p class="card-title">Owners</p>
          <ul class="list-unstyled">
          @foreach($inventory->users as $user)
            <li><a href="{{route('dashboard', [$user->username])}}">{{$user->name}}</a> <a href="{{route('get.remove.inventory.owner', [Auth::User()->school->username, $inventory->name, $user->id])}}" style="padding-left: 20px; color: red;">Remove</a></li>
          @endforeach
          </ul>

          <hr>
          <a href="#" data-toggle="modal" data-target="#deleteInventoryModal" style="color: red;">Delete inventory</a>
        </div><!-- .panel-body -->
      </div><!-- .panel -->
    </div><!-- .col-md-9 -->
  </div><!-- .row -->
@endsection
