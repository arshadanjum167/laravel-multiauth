@extends('layouts.admin.main')

@section('title', config('params.appTitle') )


@section('main_contant')
<section class="content-header">
    <h1>Create User</h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard') }}" >Home</a></li>
      <li><a href="{{ URL::to('admin/user') }}" >Users</a></li>
      <li class="active">Create</li>
    </ol>
</section>

    <!-- Main content -->
    <section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <!--<h1 class="box-title">Add New User</h1>-->
        </div>
        <div class="box-body">
        {!! Form::open(['url' => 'admin/user','method'=>'POST','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}
        <form role="form" class="form-horizontal">

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
                                <label  for="name" class="control-label col-sm-3">Email Address <em>*</em></label>
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
                <div class="box-footer ">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" class="btn btn-primary load-button">Create</button>
                                    <a href="{{ URL::to('admin/user')}}" class="btn btn-default">Cancel</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        {!! Form::close() !!}
        
    </div>
    </section>

@endsection
