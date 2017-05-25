<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('post.item', [Auth::User()->school->username, $inventory->name, $inventory->id])}}" method="post">
        <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="name" id="name" placeholder="Name" value="{{old('name')}}">
            </div>
            <?php
              $i = 0;
              $x = 1;
              foreach($inventory->attributes as $attribute) {
                echo '<div class="form-group">';
                echo '<input type="text" class="form-control input-lg" name="'. $i .'" placeholder="'. $attribute->name .'">';
                echo '<input type="hidden" class="form-control input-lg" name="'. $x .'" value="'. $attribute->id .'">';
                echo '</div>';
                $i+= 2;
                $x = $i + 1;
              }
            ?>
            <div class="form-group">
              <input type="number" class="form-control input-lg" name="stock" placeholder="stock" value="{{old('stock')}}">
            </div>
            <div class="form-group">
            </div>
            <input type="number" class="form-control input-lg" name="cost" placeholder="cost" value="{{old('cost')}}">
        </div><!-- .modal-body -->
        <div class="modal-footer">
          <button style="border-radius: 0px;" type="submit" class="btn btn-primary btn-lg">Add Item</button>
          {{csrf_field()}}
        </div><!-- .modal-footer -->
      </form>
    </div>
  </div>
</div>
