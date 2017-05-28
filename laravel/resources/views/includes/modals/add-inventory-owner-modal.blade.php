<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="addInvnetoryOwnerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('post.inventory.owner', [Auth::User()->school->username])}}" method="post">
        <div class="modal-body">
            <div class="form-group">
              <select name="user" class="form-control input-lg">
                @foreach(Auth::User()->school->users as $user)
                  <option value={{$user->id}}>{{$user->name}}</option>
                @endforeach
              </select>
              <input type="hidden" name="inventory" value="{{$inventory->id}}">
            </div>
        </div><!-- .modal-body -->
        <div class="modal-footer">
          <button style="border-radius: 0px;" type="submit" class="btn btn-primary btn-lg">Add owner</button>
          {{csrf_field()}}
        </div><!-- .modal-footer -->
      </form>
    </div>
  </div>
</div>
