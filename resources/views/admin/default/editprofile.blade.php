{{-- @extends('layouts.app') --}}
@extends('layouts.admin.main')
@section('title', config('params.appTitle') )

@section('main_contant')
<?php
$image = asset('img/avatar.png');
if(isset($user->avatar) && $user->avatar!=null)
$image=$user->avatar;


?>
<section class="content-header">
    <h1>Edit Profile</h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard') }}" >Home</a></li>
      <li class="active">Edit Profile</li>
    </ol>
</section>

    <!-- Main content -->
    <section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <!--<h1 class="box-title">-->
            <!--    Edit Profile-->
            <!--</h1>-->
        </div>
        <div class="box-body">
        {{ Form::model($user,['route'=>['admin.editprofile'],'method' => 'POST',"enctype"=>"multipart/form-data" ,'class'=>'form-horizontal'])}}
        <form role="form" class="form-horizontal">
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
                                
                            <div class="form-group">
                                <label class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <div class="edit-profile">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class=" btn-file">
                                                <div class="thumbnail fileinput-new">
                                                    <img class="profile-user-img img-responsive img-circle no-margin" src="{{ $image}}" alt="User profile picture">
                                                    <!--<img src="../../dist/img/no-image.png" alt="" />-->
                                                </div>
                                                <div class="clearfix upload-photo">
                                                     <button type="submit" class="btn btn-primary">browse </button>
                                                </div>
                                                <input type="hidden" value="" name="..."><input type="file" name="image">
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            </div>
                                            <div class="text-center">
                                                <a href="javascript:;" class="remove fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
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

