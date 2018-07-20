{{--@extends('admin.layouts.login')--}}
{{--@extends('layouts.app')--}}
@extends('layouts.admin.before_login')

{{--@section('main_contant')--}}
@section('content')
<div class="login-box-body">
                  <h3 class="text-center">Reset Password</h3>
                
                  @if (Session::has('message'))
                    {!! Session::get('message') !!}
                  @endif

                  {!! Form::open(['url' => 'admin/password/reset','method'=>'POST','class'=>'login-form']) !!}
                  <input type="hidden" name="token" value="{{$token}}">
                    <div class="form-group field-password has-feedback">
                      <!--<label for="password" class="col-sm-3 control-label">Password</label>-->
                      <!--<div class="col-sm-8">-->
                        {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Password']) }}
                        @if ($errors->first('password'))
                          <span for="password" class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                      <!--</div>-->
                    </div>
                    <div class="form-group field-password_confirmation has-feedback">
                      <!--<label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>-->
                      <!--<div class="col-sm-8">-->
                        {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Confirm Password']) }}
                        @if ($errors->first('password_confirmation'))
                          <span for="password_confirmation" class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                      <!--</div>-->
                    </div>
                    <div class="social-auth-links">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                  </div>
                  {!! Form::close() !!}
                </div>
                
            
@endsection
