<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="askQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('post.question')}}" method="post">
        <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="questionTitle" id="questionTitle" placeholder="Question title">
            </div>
            <div class="form-group">
              <textarea style="resize: none;" class="form-control input-lg" name="questionDescription" id="questionDescription" placeholder="Description"></textarea>
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="questionTags" id="questionTags" placeholder="Tags. for ex: technology, Philosiphy">
            </div>

        </div>
        <div class="modal-footer">
          <input type="hidden" value="{{$classroom->id}}" name="classroom_id" id="classroom_id">
          <button style="border-radius: 0px;" type="submit" class="btn btn-primary btn-lg">Ask question</button>
          {{csrf_field()}}
        </div>
      </form>
    </div>
  </div>
</div>
