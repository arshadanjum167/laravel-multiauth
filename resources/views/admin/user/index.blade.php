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


<section class="content-header">
    <h1>Users</h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard') }}" >Home</a></li>
      <li class="active"><a href="{{ URL::to('admin/user') }}" >Users</a></li>
    </ol>
  </section>


    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
        
            <div class="box-header with-border">
                @if (Session::has('message'))
              {!! Session::get('message') !!}
            @endif
            <a href="{{ URL::to('admin/user/create') }}" class="btn btn-primary pull-right"> Add New User</a>
            <h3 class="box-title">
                Users List
            </h3>
        </div>
        <div class="box-body">
        {!! Form::open(['url' => 'admin/user','class'=>'form-horizontal','method'=>'GET']) !!}
        <div class="input-group filter-bottom-margin" style="width: 250px;">
                                        <input type="text" class="form-control pull-right" value="{{ $search }}" placeholder="Search" autofocus="" name="search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit" value="Search"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
            
        {!! Form::close() !!}
        <div class="clearfix"></div>
        <div class="table-responsive ">
            <table class="table table-hover table table-bordered table-striped" id="example1">
                <thead>
                    <tr>
                        <th width="50px" class="text-center">#</th>
                        <th>Name</th>
                        <th >Email Address</th>
                        <th >Action</th>
                        <!--<th width="50px">&nbsp;</th>-->
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
                          <div class="buttons-set">
                          {{ Form::open(array('url' => 'admin/user/' . $v->id)) }}
                                <a href="{{ URL::to('admin/user/'.$v->id.'/edit') }}" class="btn btn-default btn-sm btn-icon-only">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                
                                <!--<a href="javascript:void(0);" class="btn btn-default btn-sm btn-icon-only">-->
                                <!--    <i class="fa fa-trash"></i>-->
                                <!--</a>-->
                            
                                         
                                         {{ Form::hidden('_method', 'DELETE') }}
                                         <button type="submit" class="btn btn-default btn-sm btn-icon-only btn-submit" > <i class="fa fa-trash"></i></button>
                                         {{ Form::close() }}
                                    
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
                    
        {{--<div class="box-footer pagination-table pull-right">--}}
        <div class="box-footer text-right">
            {{ $users->links() }}
            </div>
        
         </div>   

    </section>
    <!-- /.content -->

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
//for delete signle user
function del(id,field)
{
 var a=confirm("Are you sure want to delete this data?");
    if (a) {
            var id1 = id;
            var field1 =field;
            $.ajax({type: "GET",
            url: "{{ URL::to('admin/user/') }}",
            data: { id: id1,field :field1},
            success:function(result){
            $.pjax.reload({container: '#w1-pjax', timeout: 2000});
            setTimeout(function(){
                    reloadcheckbox();
            },2001);
        }});
	}
}
</script>
@endsection
