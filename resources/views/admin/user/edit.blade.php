@extends('layouts.admin.main')

@section('title', config('params.appTitle') )


@section('main_contant')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header hide">
        <h1 class="heading">Edit User</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box-header">
            <h1 class="box-title">Edit User</h1>
        </div>
        {{ Form::model($user,['route'=>['user.update', $user->id],'method' => 'PUT','class'=>'form-horizontal'])}}

        <form role="form" class="form-horizontal">
            <div class="box clearfix">
                <h4></h4>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label  for="name" class="control-label col-sm-3">User Name <em>*</em></label>
                                <div class="col-sm-9">
                                    {{ Form::text('name',null,['class'=>'form-control','id'=>'name']) }}
                                    @if ($errors->first('name'))
                                      <span for="name" class="help-block">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <label  for="halka_name" class="control-label col-sm-3">Email Address <em>*</em></label>
                                <div class="col-sm-9">
                                    {{ Form::text('email',null,['class'=>'form-control','id'=>'email']) }}
                                    @if ($errors->first('email'))
                                      <span for="email" class="help-block">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <a href="{{ URL::to('admin/user')}}" class="btn btn-link btn-default-white">Cancel</a>
                                    <button type="submit" class="btn btn-primary load-button">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </section>
    <!-- /.content -->
</div>
@endsection
