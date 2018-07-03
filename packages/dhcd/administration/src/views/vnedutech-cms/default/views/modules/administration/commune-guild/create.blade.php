@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-administration::language.titles.commune_guild.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
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
                <form action="{{route('dhcd.administration.commune-guild.add')}}" method="post" id="form-add-country-district">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-8">
                        <label> Name</label>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="{{ trans('dhcd-administration::language.placeholder.commune_guild.name') }}">
                        </div>
                        <label>In Country Districty</label>
                        <select class="form-control select2" id="country_district" name="country_district">
                        @if(!empty($country_district))
                        @foreach($country_district as $c_d)
                            <option value="{{$c_d->code}}">{{$c_d->name_with_type}}</option>
                        @endforeach
                        @endif
                        </select>
                        <label> Type</label>
                        <div class="form-group">
                            <input type="radio" name="type"  value="phuong" checked="checked"> Phường
                            <input type="radio" name="type"  value="xa">  Xã
                            <input type="radio" name="type"  value="thi-tran">  Thị trấn
                        </div>
                        <label> Name with type</label>
                        <div class="form-group">
                            <input type="text" name="name_with_type" class="form-control" value="" placeholder="{{ trans('dhcd-administration::language.placeholder.commune_guild.name_with_type') }}">
                            <p>vd: Tỉnh Hà Tĩnh, Thành phố Hà Nội </p>
                        </div>
                        <label> Path</label>
                        <div class="form-group">
                            <input type="text" name="path" class="form-control" value="" placeholder="{{ trans('dhcd-administration::language.placeholder.commune_guild.path') }}">
                            <p>vd: Thanh Xuân,Hà Nội </p>
                        </div>
                        <label> Path with type</label>
                        <div class="form-group">
                            <input type="text" name="path_with_type" class="form-control" value="" placeholder="{{ trans('dhcd-administration::language.placeholder.commune_guild.path_with_type') }}">
                            <p>vd: Quận Thanh Xuân, Thành phố Hà Nội </p>
                        </div>
                        <label> Code</label>
                        <div class="form-group">
                            <input type="number" name="code" class="form-control" value="" placeholder="{{ trans('dhcd-administration::language.placeholder.commune_guild.code') }}">
                        </div>
                        <div class="form-group">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('dhcd-administration::language.buttons.create') }}</button>
                                <a href="{!! route('dhcd.administration.provine-city.create') !!}"
                                   class="btn btn-danger">{{ trans('dhcd-administration::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <!-- /.col-sm-4 -->
                    <div class="col-sm-4">
                        
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
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
            $('#country_district').select2({
                theme:"bootstrap",
                placeholder:"select a provine city"
            });
            $('#form-add-country-district').bootstrapValidator({
            feedbackIcons: {
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        }
                    }
                },
                name_with_type: {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        }
                    }
                },
                path: {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        }
                    }
                },
                path_with_type: {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        }
                    }
                },
                code: {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        }
                    }
                },

            }
        }); 
        })
    </script>
@stop
