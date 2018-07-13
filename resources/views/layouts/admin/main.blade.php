<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" />

  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('layouts.admin.css')
</head>

<body class="sidebar-mini skin-black">

<div class="wrapper">
  @include('layouts.admin.top_header')

  @yield('main_contant')

</div>
</body>
@include('layouts.admin.scripts')
@yield('custom_scripts')
</html>
