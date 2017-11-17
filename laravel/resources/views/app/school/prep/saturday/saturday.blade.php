@extends('layouts.school')
@section('title') Saturday B @endsection
@section('app-content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{ URL::to('src/js/survey-jquery.js') }}"></script>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
          <div class="panel-body">
            <h1 style="font-family: lato; font-weight: bold;">Sat, 18 November 2017</h1>
            <form action="{{route('post.prep')}}" method="post" style="margin-top: 20px;">
              <div class="form-group">
                <label style="color: #333;">Which activity will you be practicing?</label>
                <select id="activity" name="activity" type="text" class="form-control input-lg">
                    <option value="0">-- Choose activity --</option>
                    <option value="pp">Personal Planning</option>
                    <option value="ps">Personal study</option>
                    <option value="pt">Peer tutoring</option>
                    <option value="fooo">Faculty one-on-one</option>
                    <option value="gw">Group work</option>
                </select>

                <label style="color: #333; margin-top: 15px;">Where will you be spending this time?</label>
                <select id="location" name="location" type="text" class="form-control input-lg">
                    <option value="#">-- Choose activity first --</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary btn-block btn-lg">Signup for Saturday B</button>
              {{ csrf_field() }}
            </form>
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->

        <p class="card-title">Day schedule</p>
        <div class="panel panel-primary">
          <div class="panel-body">
            <ul class="list-unstyled" style="font-family: lato;">
              <li>7.45 – 9.00am: Breakfast</li>
              <li>Early – 9.30am: Rise & Shine (Wellness activities)</li>
              <li>9.45 – 10.30am: Dean’s Talk</li>
              <li>10.30 – 12.30pm: Personal Time/Study Period: Assignment catch-up/Peer-tutoring & study
			         support/Office hours/Personal reading & study</li>
			        <li>12.30 – 1.15pm: Lunch</li>
			        <li>1.15 – 5.00pm: Residential life programming</li>
            </ul>

            <style>
            	ul li {
            		padding-top: 10px;
            	}
            </style>
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->
	</div><!-- col-md-6 -->
</div><!-- .row -->

@endsection