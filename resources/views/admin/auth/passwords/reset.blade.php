{{--@extends('admin.layouts.login')--}}
@extends('layouts.app')

{{--@section('main_contant')--}}
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-md-offset-3">
            <div class="panel panel-default"  style="margin-top:15%">
                <div class="panel-heading">

                  <h3 style="margin: 5px 0px;">Reset Password</h3>
                </div>
                <div class="panel-body">
                  @if (Session::has('message'))
                    {!! Session::get('message') !!}
                  @endif

                  {!! Form::open(['url' => 'admin/password/reset','method'=>'POST','class'=>'form-horizontal']) !!}
                  <input type="hidden" name="token" value="{{$token}}">
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
                      <label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>
                      <div class="col-sm-8">
                        {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Confirm Password']) }}
                        @if ($errors->first('password_confirmation'))
                          <span for="password_confirmation" class="help-block">{{ $errors->first('password_confirmation') }}</span>
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
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
