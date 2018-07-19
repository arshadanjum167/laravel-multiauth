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
  @include('layouts.admin.scripts')
</head>

<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
        
         <!--Html::img('@web'.Yii::$app->params["applogoimg"]);-->
           <b>{{ config('params.appTitle') }}</b> 
        </div>

   @yield('content')

</div>
    
</body>

@yield('custom_scripts')
<script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
</html>
