<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="google-signin-client_id" content="1055456694095-1qdqdaq1irr5jbb0jqfli19tlij2l2lm.apps.googleusercontent.com">

    @yield('meta')

    <link rel="icon" href="{{ URL::to('favicon.ico') }}" type="image/ico">
    <title>@yield('title')</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Bootstrap CSS -->
    <link href="{{ URL::to('src/css/bootstrap.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style type="text/css" media="print">
      .no-print {display: none; }
    </style>
  </head>
  <body>

    @yield('content')

    <!-- font-awesome -->
    <link rel="stylesheet" href="{{ URL::to('src/font-awesome/css/font-awesome.min.css') }}">


    <!-- Google analytics -->
    @include('includes.google-analytics')

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ URL::to('src/js/app-jquery.js') }}"></script>
    <script src="{{ URL::to('src/js/animation-jquery.js') }}"></script>
    <script src="{{ URL::to('src/js/ajax-validation.js') }}"></script>
    <!-- Bootstrap Javascript -->
    <script src="{{ URL::to('src/js/bootstrap.js') }}"></script>
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
  </body>
</html>
