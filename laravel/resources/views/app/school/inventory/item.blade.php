@extends('layouts.school')
@section('title') {{$item->name}} @endsection
@section('app-content')

  <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventory', [Auth::User()->school->username, $item->inventory->name])}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to {{$item->inventory->name}}</a></p>

  <div class="row">
    <div class="col-md-6">
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

    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-body">
          <form action="{{route('post.lend.item', [Auth::User()->school->username, $item->inventory->name, $item->name])}}" method="post">
            <select data-live-search="true" name="user" class="selectpicker">
              @foreach(Auth::User()->school->users as $user)
                <option value={{$user->id}}>{{$user->name}}</option>
              @endforeach
            </select>
            <input name="received_date" type="date" class="form-control input-sm" style="margin-bottom: 5px;" value="{{ old('received_date') }}">
            <input name="return_date" type="date" class="form-control input-sm" style="margin-bottom: 5px;" value="{{ old('received_date') }}">
            <button type="submit" class="pull-right btn btn-primary">Lend</button>
            {{ csrf_field() }}
          </form>
        </div><!-- .panel-body -->
      </div><!-- .panel -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->
@endsection
