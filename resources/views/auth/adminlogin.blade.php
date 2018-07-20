@extends('layouts.admin.before_login')

@section('content')
<!-- /.login-logo -->
  <div class="login-box-body">
    <h3 class="text-center">Login</h3>
                @if (Session::has('message'))
                    {!! Session::get('message') !!}
                  @endif
                    <form id="login-form" class="form-signin" method="POST" action="{{ route('adminlogin') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} field-loginformadmin-email has-feedback">
                            <!--<label for="email" class="col-md-4 control-label">E-Mail Address</label>-->

                            <!--<div class="col-md-6">-->
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus >
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            <!--</div>-->
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} field-loginformadmin-password has-feedback">
                            <!--<label for="password" class="col-md-4 control-label">Password</label>-->

                            <!--<div class="col-md-6">-->
                                <input id="password" type="password" class="form-control" name="password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            <!--</div>-->
                        </div>

                        <div class="row">
                            <div class="col-xs-6 ">
                                <div class="checkbox icheck no-margin">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        
                            <div class="col-xs-6 text-right">
                                <a href="{{ route('forgot_password') }}"> I Forgot My Password</a>
                            </div>
                        </div>
                            <div class="social-auth-links">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                            </div>
                            
                        
                                
                    </form>
                </div>
            
    <script>
 $(".checkbox").addClass("icheck");
 $(".form-group").addClass("has-feedback");
 $(document).ready(function(){
$(".alert").fadeOut(2000);
});
</script>
@endsection

