@php
  $search='';
  if(Request::has('search'))
  {
    $search=Request::get('search');
  }
@endphp

@extends('layouts.admin.main')
@section('title', config('params.appTitle') )
@section('main_contant')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="box-header">
            <div class="pull-right">
                <div class="pull-left">
                  {!! Form::open(['url' => 'admin/user','class'=>'form-horizontal','method'=>'GET']) !!}
                    <div class="new-search input-group">
                        <input type="text" name="search" class="form-control input-sm" value="{{ $search }}" placeholder="Search...">
                        <!--<a href="#"><span name="search" id="search-btn" class="btn-flat"><i class="fa fa-search"></i></span></a>-->
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-sm" type="submit" ><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                </div>&nbsp;
                <!-- <a href="#" class="btn btn-default2 btn-sm"><i class="fa fa-print"></i> Print</a> -->
                <a href="{{ URL::to('admin/user/create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
            </div>
            <h1 class="box-title">
                Users List
            </h1>
        </div>
        @if (Session::has('message'))
          {!! Session::get('message') !!}
        @endif
        <div class="box">
            <table class="table table-hover" id="example1">
                <thead>
                    <tr>
                        <th width="50px" class="text-center">#</th>
                        <th>Name</th>
                        <th >Email Address</th>
                        <th width="50px">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                  @if(count($users)>0)
                    @foreach($users as $v)
                      <tr>
                          <td class="text-center">{{$v->id}}</td>
                          <td>{{$v->name}}</td>
                          <td>{{$v->email}}</td>
                          {{--<td class="text-center">{{$v->masjids->count()}}</td>--}}
                          <td>
                              <div class="dropdown text-right">
                                  <a href="javascript:;" class="btn btn-default btn-default-white btn-sm btn-icon-only dropdown-toggle" data-toggle="dropdown">
                                  <i class="material-icons more_vert">more_vert</i>
                                  </a>
                                  <ul class="dropdown-menu pull-right">
                                      <li><a href="{{ URL::to('admin/user/'.$v->id.'/edit') }}">Edit</a></li>
                                      <li>
                                         {{ Form::open(array('url' => 'admin/user/' . $v->id)) }}
                                         {{ Form::hidden('_method', 'DELETE') }}
                                         <button type="submit" class="btn btn-block btn-submit" >Remove</button>
                                         {{ Form::close() }}
                                      </li>
                                  </ul>
                              </div>
                          </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="4">
                        No Result found
                      </td>
                    </tr>
                  @endif
                </tbody>
            </table>
        </div>
        {{ $users->links() }}

    </section>
    <!-- /.content -->
</div>
@endsection


@section('custom_scripts')
<script type="text/javascript">
$(".btn-submit").click(function(){
  a=confirm('Are you sure to delete record ?')
  if(!a)
  {
    return false;
  }
});
</script>
@endsection
