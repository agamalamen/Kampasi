@if(Session::has('message'))
  <div class="row">
      @if(Session::has('dismiss'))
      <div class="col-md-4 col-md-offset-4 alert {{ Session::get('status') }} dismiss" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      @endif
      @if(!Session::has('dismiss'))
      <div class="col-md-4 col-md-offset-4 alert {{ Session::get('status') }}" role="alert">
      @endif
      {!! Session::get('message') !!}
    </div>
  </div>
@endif
