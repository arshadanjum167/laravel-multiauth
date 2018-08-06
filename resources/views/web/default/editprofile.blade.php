{{-- @extends('layouts.app') --}}
@extends('layouts.app')
@section('title', config('params.appTitle') )

@section('content')
<?php
$image = asset('img/avatar.png');
if(isset($user->avatar) && $user->avatar!=null)
$image=$user->avatar;


?>
<section class="content-header">
    <h1>Edit Profile</h1>
</section>

    <!-- Main content -->
    <section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <!--<h1 class="box-title">-->
            <!--    Edit Profile-->
            <!--</h1>-->
        </div>
            {{ Form::model($user,['route'=>['editprofile'],'method' => 'POST',"enctype"=>"multipart/form-data" ,'class'=>'form-horizontal'])}}
        <div class="box-body">
        <!--<form role="form" class="form-horizontal">-->
                <input type="hidden" name="user_id" value="{{ Auth::user()->id}}">
            
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group field-user_name has-success">
                                <label  for="name" class="control-label col-sm-3">User Name <em>*</em></label>
                                <div class="col-sm-9">
                                    {{ Form::text('name',null,['class'=>'form-control','id'=>'name']) }}
                                    @if ($errors->first('name'))
                                      <span for="name" class="help-block">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group field-email has-success">
                                <label  for="halka_name" class="control-label col-sm-3">Email Address <em>*</em></label>
                                <div class="col-sm-9">
                                    {{ Form::text('email',null,['class'=>'form-control','id'=>'email']) }}
                                    @if ($errors->first('email'))
                                      <span for="email" class="help-block">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
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
                                    <a href="{{ URL::to('/home')}}" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
    </section>

@endsection

