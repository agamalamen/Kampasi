<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="createInventoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('post.inventory', Auth::User()->school->username)}}" method="post">
        <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="name" id="name" placeholder="What is the name of this inventory?" value="{{old('name')}}">
            </div>
        </div><!-- .modal-body -->
        <div class="modal-footer">
          <button style="border-radius: 0px;" type="submit" class="btn btn-primary btn-lg">Create inventory</button>
          {{csrf_field()}}
        </div><!-- .modal-footer -->
      </form>
    </div>
  </div>
</div>
