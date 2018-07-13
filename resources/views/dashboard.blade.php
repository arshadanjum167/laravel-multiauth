{{-- @extends('layouts.app') --}}
@extends('layouts.admin.main')
@section('title', config('params.appTitle') )

@section('main_contant')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header hide">
        <h1 class="heading clearfix">
            Dashboard
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box-header">
            <h1 class="box-title">
                Dashboard
            </h1>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
              <a href="{{ URL::to('admin/user') }}" class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Users</span>
                  <span class="info-box-number">{{ $user_count}}</span>
                </div>
                <!-- /.info-box-content -->
              </a>
              <!-- /.info-box -->
            </div>
            
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

