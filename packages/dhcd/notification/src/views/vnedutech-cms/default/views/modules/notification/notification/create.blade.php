@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-notification::language.titles.notification.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
@stop
<!--end of page css-->


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                <!-- errors -->
                <form action="{{route('dhcd.notification.notification.add')}}" method="post" id="form-add-notification">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-5">
                        <label>{{trans('dhcd-notification::language.label.name')}} <span style="color: red">(*)</span></label>
                        <div class="form-group">
                            <input type="text" required id="name" name="name" class="form-control" placeholder="{{trans('dhcd-notification::language.placeholder.notification.name_here')}}">
                            <p id="alias" style="color: red"></p>
                        </div>
                        <label>{{trans('dhcd-notification::language.label.content')}}</label>
                        <div class="form-group">
                            <textarea required id="content" name="content" class="form-control" placeholder=""></textarea>
                        </div>
                        <label>{{trans('dhcd-notification::language.label.time_sent')}}</label>
                         <div class="form-group">
                            <div class='input-group date' id='time_sent'>
                                <input type='text' class="form-control" name="time_sent"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <p style="color: red">Mặc định không chọn là gửi luôn</p>
                        </div>
                        
                        <div class="form-group col-xs-12">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{trans('dhcd-notification::language.buttons.create')}}</button>
                                <a href="{!! route('dhcd.notification.notification.manage') !!}"
                                   class="btn btn-danger">{{ trans('dhcd-notification::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <label>{{trans('dhcd-notification::language.label.type_sent')}}</label>
                        <div class="form-group">
                            <input type="radio" id="sent-all" name="type_sent" value="1"checked="checked">
                            <label for="sent-all">{{trans('dhcd-notification::language.placeholder.notification.sent_all')}}    </label> <br>
                            <input type="radio" id="sent-single" name="type_sent" value="2">
                            <label for="sent-single">{{trans('dhcd-notification::language.placeholder.notification.sent_single')}}</label>
                            <div id="area-sent-single">
                                <input type="text" id="searchProduct" name="keyword" class="typeahead form-control" placeholder="Nhập tên người cần thêm" required="">
                                <ul class="list-group" id="list_member_sent" style="height: 200px;overflow: auto;">

                                </ul>
                            </div>
                        </div>    
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                </form>
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/typeahead/js/bloodhound.min.js') }}"></script><script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/typeahead/js/typeahead.bundle.min.js') }}"></script>
    <!--end of page js-->
    <script>
        $(document).ready(function() {
            $('#time_sent').datetimepicker({
                format: 'DD-MM-YYYY',
                minDate: new Date()
            });
        });
        $("input.typeahead").keyup(function(){
            // delay(function(){
                var keyword = $('.typeahead').val();
                var url = '/admin/dhcd/notification/notification/search/member/?keyword='+keyword;
                $.get(url, function(data){
                    var i,text = '';
                    var obj_data = JSON.parse(data);
                    if(obj_data.length>0){
                        for (i in obj_data) {
                            text += '<li class="list-group-item"><input type="checkbox" name="list_member_sent[]" value="'+obj_data[i].member_id+'">'+obj_data[i].name+'</li>';
                        }
                        $('#list_member_sent').html('');
                        $('#list_member_sent').append(text);
                    }
                    else{
                        $('#list_member_sent').html('<span class="red"> Không tìm thấy người dùng thỏa mãn </span>');        
                    }
                });
            // }, 500 );
        });
        $('#form-add-notification').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập tên'
                            },
                            stringLength: {
                                max: 250,
                                message: 'Tên không được quá dài'
                            }
                        }
                    },
                }
            });
    </script>
@stop
