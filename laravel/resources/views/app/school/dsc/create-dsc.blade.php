@extends('layouts.school')
@section('title') Create DSC @endsection
@section('app-content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <h2 style="color: #333; font-size: 30px;">Create DSC project</h2>
    <form action="{{route('post.create.dsc')}}" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <input name="title" type="text" class="form-control input-lg" placeholder="Project title">
      </div>
      <div class="form-group">
        <textarea name="description" id="description" class="form-control input-lg" placeholder="Project description">
        </textarea>
      </div>
      <div class="form-group">
        <input name="photo" type="file" class="form-control input-lg">
      </div>

      <a href="#" id="add-people" style="color: #27ae60; font-size: 20px;">Add more creators <span class="caret"></span></a>
      <div class="row" id="more-students" style="display:none;">
        <?php
          $i = 0;
          foreach(Auth::User()->school->users as $student) {
            if($student->id != Auth::User()->id)
            echo '
              <div class="col-md-4">
                <input type="checkbox" name="'. $i .'" value="'. $student->id .'">
                <a href="'. route('dashboard', $student->username) .'">'. $student->name .'</a>
              </div><!-- .col-md-4 -->
            ';
            $i++;
          }
        ?>
      </div><!-- .row more-students -->

      <button type="submit" style="margin-top: 5px;" class="btn btn-primary btn-block btn-lg">Create</button>
      {{ csrf_field() }}

    </form>
  </div><!-- .col-md-8 -->
</div><!-- .row -->
<script src="{{URL::to('/src/js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script>
tinymce.init({
  selector: '#description',
  theme: 'modern',
  plugins: [
    'advlist autolink lists link charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars',
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
