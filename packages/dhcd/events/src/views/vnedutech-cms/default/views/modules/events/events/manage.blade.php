@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-events::language.titles.events.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap4.css') }}" />
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
    <div class="panel panel-primary ">
        
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <i class="livicon" data-name="users" data-size="16"
                                                         data-loop="true" data-c="#fff" data-hc="white"></i>
                        {{ $title }}
                    </h4>
                    <div class="pull-right">
                        <a href="{{ route('dhcd.events.events.create') }}" class="btn btn-sm btn-default" data-toggle="modal" ><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('dhcd-events::language.buttons.create') }}</a>
                    </div>
                </div>
            </div>
            <br/>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('dhcd-events::language.table.stt') }}</th>
                                <th>{{ trans('dhcd-events::language.table.events.name') }}</th>
                                <th>{{ trans('dhcd-events::language.table.events.date') }}</th>
                                <th style="width: 120px">{{ trans('dhcd-events::language.table.content') }}</th>
                                <th style="width: 120px">{{ trans('dhcd-events::language.table.detail') }}</th>
                                <th >{{ trans('dhcd-events::language.table.status') }}</th>
                                <th>{{ trans('dhcd-events::language.table.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div> 
    <!-- row-->    </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap4.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.responsive.js') }}" ></script>

        <script>
        $(function () {
            var table = $('#table').DataTable({
                responsive:true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('dhcd.events.events.data') }}',
                columns: [
                    { data: 'rownum', name: 'rownum' },
                    { data: 'name', name: 'name' , },
                    { data: 'date', name:'date'},
                    { data: 'content', name: 'content'},
                    { data: 'event_detail', name: 'event_detail'},
                    { data: 'status' , name:'status'},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
                ]
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });
        });

    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="log" tabindex="-1" role="dialog" aria-labelledby="user_log_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="event_detail" tabindex="-1" role="dialog" aria-labelledby="user_log_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
            </div>
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
