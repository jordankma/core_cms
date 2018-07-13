@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-document::language.titles.document_type.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>{{ $title }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                          data-color="#000"></i>
                {{ trans('adtech-core::labels.home') }}
            </a>
        </li>
        <li class="active"><a href="#">{{ $title }}</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left" style="padding-top: 5px;">
                    {{ trans('dhcd-document::language.document_type.table.title') }}
                </h4>
                <div class="pull-right">
                    <a href="{{ route('dhcd.document.type.add') }}" class="btn btn-sm btn-default"><span
                            class="glyphicon glyphicon-plus"></span> {{ trans('dhcd-document::language.buttons.create') }}</a>
                </div>
            </div>
            <br/>
            <div class="panel-body">
                <!-- errors --> 
                 @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">                   
                        <ul>                       
                            <li> {{session('success')}}</li>                       
                        </ul>
                    </div>
                @endif
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box danger">
                    
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('dhcd-document::language.document_type.table.icon') }}</th>
                                        <th>{{ trans('dhcd-document::language.document_type.table.name') }}</th>                                        
                                        <th>{{ trans('dhcd-document::language.document_type.table.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>                                    
                                    @foreach($types as $key => $type)
                                    <tr>
                                        <td>{{$key = $key +1 }}</td>
                                        <td><img width="50px" src="{{$type['icon']}}" ></td>
                                        <td>{{$type['name']}}</td>                                        
                                        <td>
                                            <a href='{{route('dhcd.document.type.edit',['document_type_id' => $type['document_type_id']])}}'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="{{ trans('dhcd-document::language.document_type.table.edit') }}"></i></a>
                                            <a href='{{route('dhcd.document.type.delete',['document_type_id' => $type['document_type_id']])}}' ><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="{{ trans('dhcd-document::language.document_type.table.delete') }}"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach                                                                        
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- END BORDERED TABLE PORTLET-->
                </div>
            </div>
        </div>
    </div>
</div>    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>     
<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});
</script>
@stop
