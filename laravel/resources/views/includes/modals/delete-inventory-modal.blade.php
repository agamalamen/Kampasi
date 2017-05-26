<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="deleteInventoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <form action="{{route('post.delete.inventory', [Auth::User()->school->username, $inventory->name])}}" method="post">
        <div class="modal-body">
            <p style="color: #333;">
              Please type the name of the inventory <b>({{$inventory->name}})</b> below in the box to confirm that you actually want to delete it.
            </p>
            <div class="form-group">
              <input type="text" class="form-control" name="name" id="name" placeholder="Inventory name" value="{{old('name')}}">
            </div>
        </div><!-- .modal-body -->
        <div class="modal-footer">
          <button style="border-radius: 0px;" type="submit" class="btn btn-primary">Delete</button>
          {{csrf_field()}}
        </div><!-- .modal-footer -->
      </form>
    </div>
  </div>
</div>
