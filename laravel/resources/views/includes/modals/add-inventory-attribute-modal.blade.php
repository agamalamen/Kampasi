<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="addInventoryAttributeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('post.inventory.attribute', [Auth::User()->school->username, $inventory->name, $inventory->id])}}" method="post">
        <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="name" id="name" placeholder="What is the name of this attribute?" value="{{old('name')}}">
            </div>
        </div><!-- .modal-body -->
        <div class="modal-footer">
          <button style="border-radius: 0px;" type="submit" class="btn btn-primary btn-lg">Add attribute</button>
          {{csrf_field()}}
        </div><!-- .modal-footer -->
      </form>
    </div>
  </div>
</div>
