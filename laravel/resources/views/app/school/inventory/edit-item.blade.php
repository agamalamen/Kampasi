@extends('layouts.school')
@section('title') {{$item->name}} @endsection
@section('app-content')

  <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.inventory', [Auth::User()->school->username, $item->inventory->name])}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to {{$item->inventory->name}}</a></p>

  <div class="row">
    <div class="col-md-6">
      <form action="{{route('post.edit.item', [Auth::User()->school->username, $inventory->name, $item->name])}}" method="post">
        <div class="form-group">
          <span style="color: #333; font-weight: bold;">Name</span>
          <input type="text" class="form-control input-lg" value="{{$item->name}}" name="name" id="name" placeholder="Name" value="{{old('name')}}">
        </div>
        <?php
          /*$i = 0;
          $x = 1;
          foreach($inventory->attributes as $attribute) {
            $value = "";
            foreach($item->itemAttributes as $itemAttribute)
            {
              if($itemAttribute->inventory_attribute_id == $attribute->id) {
                $value = $itemAttribute->value;
                break;
              } else {
                $value="";
              }
            }
            echo '<div class="form-group">';
            echo '<span style="color: #333; font-weight: bold;">' . $attribute->name . '</span>';
            echo '<input type="text" class="form-control input-lg" name="'. $i .'" placeholder="'. $attribute->name .'" value="'. $value .'">';
            echo '<input type="hidden" class="form-control input-lg" name="'. $x .'" value="'. $attribute->id .'">';
            echo '</div>';
            $i+= 2;
            $x = $i + 1;
          }*/
        ?>
        <div class="form-group">
          <span style="color: #333; font-weight: bold;">Stock</span>
          <input type="number" class="form-control input-lg" value="{{$item->stock}}" name="stock" placeholder="stock" value="{{old('stock')}}">
        </div>
        <div class="form-group">
          <span style="color: #333; font-weight: bold;">Cost</span>
          <input type="number" class="form-control input-lg" value="{{$item->cost}}" name="cost" placeholder="cost" value="{{old('cost')}}">
        </div>
        <button style="border-radius: 0px;" type="submit" class="btn btn-primary btn-lg">Update</button>
        {{csrf_field()}}
      </form>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->
@endsection
