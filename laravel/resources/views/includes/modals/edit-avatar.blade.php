<!-- Modal -->
<div id="editAvatar" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 10px 10px 10px 10px;">
      <div class="big_container" style="border-radius: 6px 6px 0px 0px;">
        <h1 style="text-align: center;">Edit avatar</h1>
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <form action="{{route('edit.avatar')}}" method="post" enctype="multipart/form-data">
                <input type="file" name="avatar" class="form-control" id="avatar">
            </div>
        </div>
      </div>
          <p style="text-align: center;"><button type="submit" class="btn btn-primary">Save</button></p>
          {{csrf_field()}}
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
