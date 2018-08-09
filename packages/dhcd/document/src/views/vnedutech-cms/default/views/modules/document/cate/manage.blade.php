@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-taggroup::language.titles.tag_group.manage') }}@stop

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
                    {{ trans('dhcd-taggroup::language.buttons.create') }}
                </h4>
                <div class="pull-right">                   
                    @if ($USER_LOGGED->canAccess('toolquiz.taggroup.create'))
                      <a href="{{ route('toolquiz.taggroup.create') }}" class="btn btn-sm btn-default"><span
                            class="glyphicon glyphicon-plus"></span> {{ trans('dhcd-taggroup::language.buttons.create') }}</a>
                    @endif        
                </div>
            </div>
            <br/>
            <div class="panel-body">
                
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box danger">
                    
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>                                                                            
                                        <th>{{ trans('dhcd-document::language.document_cate.table.name') }}</th>
                                        <th>{{ trans('dhcd-document::language.document_cate.table.alias') }}</th>
                                        <th>{{ trans('dhcd-document::language.document_cate.table.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>                                   
                                    @if(!empty($tagGroup))
                                        @foreach($tagGroup as $group)
                                        <tr>
                                            <td>{{ $group->name }}</td>
                                            <td>{{ $group->alias }}</td>
                                            <td>
                                               
                                                                                            
                                                @if ($USER_LOGGED->canAccess('toolquiz.taggroup.edit'))
                                                    <a href='{{route('toolquiz.taggroup.edit',['tag_group_id' => $group['tag_group_id']])}}'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="{{ trans('dhcd-taggroup::language.buttons.edit') }}"></i></a>
                                                @endif
                                                @if ($USER_LOGGED->canAccess('toolquiz.taggroup.delete'))
                                                    <a href='{{route('toolquiz.taggroup.delete',['document_id' => $doc['document_id']])}}' onclick="return confirm('Bạn có chắc chắn muốn xóa?')" ><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="{{ trans('dhcd-taggroup::language.buttons.delete') }}"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif                                                                        
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
<div class="modal fade" id="log" tabindex="-1" role="dialog" aria-labelledby="user_log_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
</div>
<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});
</script>
@stop
