@extends('layouts.school')
@section('title') Candidate page @endsection
@section('app-content')

  <div class="row">
    <div class="col-md-4 text-center">
      <div class="panel panel-primary">
        <div class="panel-body">
          <img id="avatar" class="img-circle" style="margin-top: 10px; width: 80px; height: 80px;" src="{{route('get.avatar', $candidate->user->avatar)}}">
          <h3 style="font-family: Montserrat; font-size: 16px;"><a href="{{route('get.candidate', ['2017', $candidate->user->username])}}">{{$candidate->user->name}}</a></h3>
          <p style="font-weight: bold; font-style: italic; font-family: lato;">Running for: <span style="font-style: normal; font-weight: normal"> {{$candidate->position->name}}</span></p>
        </div><!-- .panel-body -->
      </div><!-- .panel-parimary -->
    </div><!-- .col-md-4 -->
    <div class="col-md-8">
      @if($candidate->user->id == Auth::User()->id)
      <form action="{{route('post.candidate.description', '2017')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <textarea name="description" id="description" class="form-control input-lg" placeholder="Project description">
            {!! $candidate->description !!}
          </textarea>
        </div>
        <button type="submit" style="margin-top: 5px;" class="btn btn-primary btn-block btn-lg">Update</button>
        {{ csrf_field() }}
      </form>

      @else
        <div class="panel panel-primary" style="min-height: 200px;">
          <div class="panel-body">
            @if($candidate->description == '')
              <p style="color: grey; font-style: italic;">This candidate have not published anything yet.</p>
            @else
              {!! $candidate->description !!}
            @endif
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->
      @endif
    </div><!-- .col-md-8 -->
  </div><!-- .row -->

<script src="{{URL::to('/src/js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script>
  tinymce.init({
    selector: '#description',
    theme: 'modern',
    plugins: [
      'advlist autolink lists link charmap preview hr anchor pagebreak',
      ' wordcount visualblocks visualchars',
      'insertdatetime nonbreaking save contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools toc'
    ],
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
    image_advtab: true,
    templates: [
      { title: 'Test template 1', content: 'Test 1' },
      { title: 'Test template 2', content: 'Test 2' }
    ],
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tinymce.com/css/codepen.min.css'
    ]
   });
</script>


@endsection
