@extends('layouts.school')
@section('title') Off campus list @endsection
@section('app-content')

  <div class="row" style="color: #333;">
    <div class="col-md-8 col-md-offset-2 text-center">
      <form class="form-inline" action="{{route('get.off.campus.list')}}" method="get">
        <div class="form-group">
          <label for="labelForFrom">From</label>
          <input type="date" class="form-control" id="from" name="from">
        </div>
        <div class="form-group">
          <label for="labelForTo">To</label>
          <input type="date" class="form-control" id="to" name="to">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div><!-- .col-md-8 -->
  </div><!-- .row -->

@endsection
