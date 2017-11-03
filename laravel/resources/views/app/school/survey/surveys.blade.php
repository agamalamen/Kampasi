@extends('layouts.school')
@section('title') Surveys @endsection
@section('app-content')

<p id="hello" style="color: #333;">hello</p>

<div id="surveyContainer"></div>

<script type="text/javascript">
	var survey = new Survey.Model(surveyJSON);
$("#surveyContainer").Survey({
    model:survey,
    onComplete:sendDataToServer
});
	
</script>

<script src="{{ URL::to('src/js/survey-jquery.js') }}"></script>

@endsection
