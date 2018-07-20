@extends('admin.layouts.login')

@section('main_contant')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-md-offset-3">
            <div class="panel panel-default"  style="margin-top:15%">
                <div class="panel-heading">

                  <h3 style="margin: 5px 0px;"><i class="fa fa-sign-in"></i> Sign In</h3>
                </div>
                <div class="panel-body">
                  @if (Session::has('message'))
                    {!! Session::get('message') !!}
                  @endif

                  {!! Form::open(['url' => 'admin/login','method'=>'POST','class'=>'form-horizontal']) !!}
                  
                    <div class="form-group">
                      <label for="email_id" class="col-sm-3 control-label">Email Id</label>
                      <div class="col-sm-8">
                        {{ Form::text('email_id',null,['class'=>'form-control','id'=>'email_id','placeholder'=>'Email id']) }}
                        @if ($errors->first('email_id'))
                          <span for="email_id" class="help-block">{{ $errors->first('email_id') }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="password" class="col-sm-3 control-label">Password</label>
                      <div class="col-sm-8">
                        {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Password']) }}
                        @if ($errors->first('password'))
                          <span for="password" class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-2">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                      </div>
                    </div>
                  {!! Form::close() !!}
                </div>
                <div class="panel-footer">
                  <div class="row">
                    <div class="col-sm-12">

                  <p class="pull-left">
                    <a href="{{ route('forgot_password') }}">Forgot Password ?</a>

                  </p>
                  <p class="pull-right">
                    Sign in with
                     <a href="{{ route('facebook_login') }}">Facebook</a> or
                     <a href="{{ route('google_login') }}">Google</a>
                  </p>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <!-- <script src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US&adInstanceId=dcb5751b-ecb1-4c02-bc7d-9238e975c4dd"></script> -->
    </div>
</div>
@endsection
