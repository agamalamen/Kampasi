<!-- Modal -->
<div id="editBio" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 10px 10px 10px 10px;">
      <div class="big_container" style="border-radius: 6px 6px 0px 0px;">
        <h1 style="text-align: center;">Edit bio</h1>
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <form action="{{route('edit.bio')}}" method="post">
                <textarea class="form-control" id="bio" name="bio" placeholder="Type your bio here..."></textarea>
            </div>
        </div>
      </div>
          <p style="text-align: center;"><button type="submit" class="btn btn-primary">Save</button></p>
          {{csrf_field()}}
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
