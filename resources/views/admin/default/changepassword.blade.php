{{-- @extends('layouts.app') --}}
@extends('layouts.admin.main')
@section('title', config('params.appTitle') )

@section('main_contant')
<section class="content-header">
    <h1>Change Password</h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard') }}" >Home</a></li>
      <li class="active">Change Password</li>
    </ol>
</section>

    <!-- Main content -->
    <section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <!--<h1 class="box-title">-->
            <!--    Change Password-->
            <!--</h1>-->
        </div>
        <div class="box-body">
        {!! Form::open(['url' => 'admin/changepassword','method'=>'POST','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}
        <form role="form" class="form-horizontal">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id}}">
            
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group field-password has-success">
                                <label  for="name" class="control-label col-sm-3">Password <em>*</em></label>
                                <div class="col-sm-9">
                                    {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Password']) }}
                                    @if ($errors->first('password'))
                                      <span for="password" class="help-block">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group field-password_confirmation has-success">
                                <label  for="name" class="control-label col-sm-3">Confirm Password<em>*</em></label>
                                <div class="col-sm-9">
                                    
                                    {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Confirm Password']) }}
                                    @if ($errors->first('password_confirmation'))
                                      <span for="password_confirmation" class="help-block">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer ">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" class="btn btn-primary load-button">Update</button>
                                    <a href="{{ URL::to('admin/dashboard')}}" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    </section>

@endsection

