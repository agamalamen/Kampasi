<!DOCTYPE html>
<html>
<head>
	<title>Vue</title>
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ URL::to('src/js/vue.min.js') }}"></script>
    <script src="{{ URL::to('src/js/survey-jquery.js') }}"></script>

	<div id="app">
		<p>@{{ message }}</p>
	</div><!-- app -->


</body>
</html>