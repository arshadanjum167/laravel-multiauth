<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" />

  <title>@yield('title')</title>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('layouts.admin.main_css')
  @include('layouts.admin.scripts')
</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
  @include('layouts.admin.top_header')
  @include('layouts.admin.sidebar')

  <div class="content-wrapper">
  @yield('main_contant')
  </div>
  {{--@include('layouts.admin.top_header')--}}
</div>
</body>

@yield('custom_scripts')
</html>
