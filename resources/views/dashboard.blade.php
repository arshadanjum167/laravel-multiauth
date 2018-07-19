{{-- @extends('layouts.app') --}}
@extends('layouts.admin.main')
@section('title', config('params.appTitle') )

@section('main_contant')
<section class="content-header">
        <h1>
          Dashboard
        </h1>
        <ol class="breadcrumb">
          <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
</section>
<!-- Document Expiry content -->
<section class="content">
      
    @if (Session::has('message'))
          {!! Session::get('message') !!}
        @endif
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <a href="{{ URL::to('admin/user') }}" class="">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Users</span>
          <span class="info-box-number">{{ $user_count}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      </a>
      <!-- /.info-box -->
    </div>
  </div>
</section>

@endsection

