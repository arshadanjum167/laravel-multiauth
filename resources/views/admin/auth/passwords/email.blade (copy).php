{{--@extends('admin.layouts.login')--}}
@extends('layouts.app')
{{--@section('main_contant')--}}
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-md-offset-3">
            <div class="panel panel-default"  style="margin-top:15%">
                <div class="panel-heading">

                  <h3 style="margin: 5px 0px;">Forgot Password</h3>
                </div>
                <div class="panel-body">
                  @if (Session::has('message'))
                    {!! Session::get('message') !!}
                  @endif
                  

                  {!! Form::open(['url' => 'admin/password/email','method'=>'POST','class'=>'form-horizontal']) !!}
                    {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  {!! Form::close() !!}
                </div>
                <div class="panel-footer">
                  <div class="row">
                    <div class="col-sm-12">

                  <p class="pull-left">
                    <a href="{{ URL::to('admin/login') }}">Sign In</a>

                  </p>
                  {{--<p class="pull-right">
                    Sign in with
                     <a href="{{ route('facebook_login') }}">Facebook</a> or
                     <a href="{{ route('google_login') }}">Google</a>
                  </p>--}}
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
