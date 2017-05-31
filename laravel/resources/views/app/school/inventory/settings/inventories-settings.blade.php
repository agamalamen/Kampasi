@extends('layouts.school')
@section('title') Inventory settings @endsection
@section('app-content')

  <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventories', Auth::User()->school->username)}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to all inventories</a></p>
  
  <div class="row">
  	<div class="col-md-4">
  		<div class="panel panel-primary">
  			<div class="panel-body">
  				<p class="card-title">Add inventory admin</p>
  				<form action="{{route('post.inventory.admin', Auth::User()->school->username)}}" method="post">
		            <div class="form-group">
		              <select name="user" data-live-search="true" class="selectpicker">
		                @foreach(Auth::User()->school->users as $user)
		                  <option value={{$user->id}}>{{$user->name}}</option>
		                @endforeach
		              </select>
		            </div>
		          <button type="submit" class="btn btn-primary">Add admin</button>
		          {{csrf_field()}}
		      </form>
  			</div><!-- .panel-body -->
  		</div><!-- .panel -->
  	</div><!-- .col-md-4 -->
    <div class="col-md-8">
      <div class="panel panel-primary">
        <div class="panel-body">
        

          <p class="card-title">Inventory admins</p>
          <ul class="list-unstyled">
          	@foreach(Auth::User()->school->users as $user)
          		@if($user->authority->inventory)
          			<li>
          				<a href="{{route('dashboard', [$user->username])}}">{{$user->name}}</a>
          				<ul class="list-inline" style="padding-top: 10px;">
          					@if($user->authority->create_inventory)
          						<li style="color: #27ae60"><i class="fa fa-check-circle" aria-hidden="true"></i> Create inventory</li>
          					@else
          						<li style="color: grey"><i class="fa fa-times-circle" aria-hidden="true"></i> Create inventory</li>
          					@endif
          					@if($user->authority->create_inventory)
          						<li style="color: #27ae60"><i class="fa fa-check-circle" aria-hidden="true"></i> Add inventory owner</li>
          					@else
          						<li style="color: grey"><i class="fa fa-times-circle" aria-hidden="true"></i> Add inventory owner</li>
          					@endif
          					@if($user->authority->create_inventory)
          						<li style="color: #27ae60"><i class="fa fa-check-circle" aria-hidden="true"></i> Track items</li>
          					@else
          						<li style="color: grey"><i class="fa fa-times-circle" aria-hidden="true"></i> Track items</li>
          					@endif
          				</ul>
          			</li>
          			<hr>
          		@endif
          	@endforeach
          </ul>
        </div><!-- .panel-body -->
      </div><!-- .panel -->
    </div><!-- .col-md-9 -->
  </div><!-- .row -->
@endsection
