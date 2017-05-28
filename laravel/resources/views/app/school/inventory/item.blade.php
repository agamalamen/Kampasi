@extends('layouts.school')
@section('title') {{$item->name}} @endsection
@section('app-content')
  
  <?php
    $authorized = 0;
    foreach($item->inventory->users as $user) {
      if(Auth::User()->id == $user->id) {
        $authorized = 1;
        break;
      }
    }
  ?>

  <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventory', [Auth::User()->school->username, $item->inventory->name])}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to {{$item->inventory->name}}</a></p>

  <div class="row">
    <div class="col-md-6">
      <p class="card-title">Item details</p>
      <div class="panel panel-primary">
        <div class="panel-body">
          <ul class="list-unstyled">
            <li>Name: {{$item->name}}</li>
            <li>Stock: {{$item->stock}}</li>
            <li>Cost: {{$item->cost}}</li>
            @foreach($item->itemAttributes as $attribute)
            <li>{{$attribute->inventoryAttribute->name}} : {{$attribute->value}}</li>
            @endforeach
          </ul>
        </div><!-- .panel-body -->
      </div><!-- .panel -->
    </div><!-- .col-md-6 -->

    @if($authorized)
      <div class="col-md-6">
        <p class="card-title">Assign item</p>
        <div class="panel panel-primary">
          <div class="panel-body">
            <form action="{{route('post.lend.item', [Auth::User()->school->username, $item->inventory->name, $item->name])}}" method="post">
              <p>Assign to</p>
              <select data-live-search="true" name="user" class="selectpicker">
                @foreach(Auth::User()->school->users as $user)
                  <option value={{$user->id}}>{{$user->name}}</option>
                @endforeach
              </select>
              <p style="padding-top: 10px;">Return date</p>
              <input name="return_date" type="date" class="form-control input-sm" value="{{ old('received_date') }}" style="margin-bottom: 15px; height: 35px; -webkit-box-shadow: none !important;-moz-box-shadow: none !important;box-shadow: none !important;">
              <button type="submit" class="pull-right btn btn-primary">Lend</button>
              {{ csrf_field() }}
            </form>
          </div><!-- .panel-body -->
        </div><!-- .panel -->
      </div><!-- .col-md-6 -->
    @endif
  </div><!-- .row -->
@endsection
