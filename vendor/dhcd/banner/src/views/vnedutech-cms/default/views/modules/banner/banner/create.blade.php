@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-banner::language.titles.banner.create') }}@stop

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
                <form role="form" action="{{route('dhcd.banner.banner.add')}}" method="post" enctype="multipart/form-data" id="form-add-banner">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <label>{{trans('dhcd-banner::language.label.name') }} <span style="color: red">(*)</span></label>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="{{trans('dhcd-banner::language.placeholder.banner.name') }}">
                        </div>
                        <label>{{trans('dhcd-banner::language.label.desc') }}</label>
                        <div class="form-group">
                            <textarea name="desc" class="form-control" placeholder="{{trans('dhcd-banner::language.placeholder.banner.desc') }}"></textarea>
                        </div>
                        <label>{{trans('dhcd-banner::language.label.position') }}</label>
                        <div class="form-group">
                            <select class="form-control" id="position" name="position" required="">
                            @if(!empty($positions))
                            @foreach($positions as $position)
                                <option value="{{$position->banner_position_id}}">{{$position->name}} {{'  ( '.$position->width.'px  x '.$position->height.'px )' }} </option>
                            @endforeach
                            @endif
                            </select>
                        </div>
                        <label>{{trans('dhcd-banner::language.label.priority') }}</label>
                        <div class="form-group">
                            <input type="number" name="priority" min="0" class="form-control" placeholder="{{trans('dhcd-banner::language.placeholder.banner.priority') }}">
                        </div>
                        <div class="form-group col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('dhcd-banner::language.buttons.create') }}</button>
                                <a href="{!! route('dhcd.banner.banner.manage') !!}"
                                   class="btn btn-danger">{{ trans('dhcd-banner::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-6">
                        <label>{{trans('dhcd-banner::language.placeholder.banner.close_at') }}</label>
                         <div class="form-group">
                            {{-- <input type="button" class="form-control" name="close_at" id="close_at" placeholder="{{trans('dhcd-banner::language.placeholder.banner.close_at') }}"> --}}
                            <div class='input-group date'>
                                <input type='text' class="form-control" name="close_at" id="close_at" placeholder="{{trans('dhcd-banner::language.placeholder.banner.close_at') }}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <p style="color: red">Không chọn mặc định thời hạn là 30 ngày</p>
                        </div>
                        <label>{{trans('dhcd-banner::language.label.link') }}</label>
                        <div class="form-group">
                            <input type="text" name="link" class="form-control" placeholder="{{trans('dhcd-banner::language.placeholder.banner.link') }}">
                        </div>
                        <label>{{trans('dhcd-banner::language.label.image') }} <span style="color: red">(*)</span></label>
                        <div class="form-group">
                            <div class=" input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Chọn ảnh
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="image">
                            </div>
                        </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;">
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
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
            var domain = "/admin/laravel-filemanager/";
            $('#lfm').filemanager('image', {prefix: domain});
            $('#close_at').datetimepicker({
                format: 'DD-MM-YYYY',
                minDate: new Date()
            });
            $('#form-add-banner').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập tên banner'
                            },
                            stringLength: {
                                max: 150,
                                message: 'Tên không được quá dài'
                            }
                        }
                    },
                    image: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa chọn ảnh banner'
                            }
                        }
                    }
                }
            }); 
        })
    </script>
@stop
