@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-document::language.titles.doucment_cate.edit') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <style>
        .control-label{
            text-align: left !important;
        }
    </style>
@stop
<!--end of page css-->

@php

@endphp

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('dhcd.document.cate.manage')}}">
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
                
                <form class="form-horizontal" action="{{route('dhcd.document.cate.update',['document_cate_id' => $cate->document_cate_id])}}" method="post" enctype="multipart/form-data" id='form-edit'>
                    {{ csrf_field() }}
                    <fieldset>
                        <!-- Name input-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">{{ trans('dhcd-document::language.document_cate.form.name') }}</label>
                            <div class=" col-md-6 ">
                                <input id="name" name="name" type="text" value="{{old('name',isset($cate) ? $cate->name : '' )}}" placeholder="{{ trans('dhcd-document::language.placeholder.document_cate.name') }}" class="form-control">
                                
                            </div>
                        </div>                                               
                        <!-- Message body -->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="parent_id">{{ trans('dhcd-document::language.document_cate.form.parent_id') }}</label>
                            <div class="col-md-6"> 
                                <select name="parent_id" class="form-control" >
                                    <option value="0">Root</option>
                                    @if(!empty($cates))
                                        {{$objCate->showCategories($cates,$cate->parent_id)}}
                                    @endif
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">{{ trans('dhcd-document::language.document_cate.form.icon_current') }}</label>
                            <div class="col-md-6">
                                @if($cate->icon)
                                    <img src="{{$cate->icon}}" width="75px">
                                @else
                                    <label class="control-label" for="name">{{ trans('dhcd-document::language.document_cate.form.icon_empty') }}</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">{{ trans('dhcd-document::language.document_cate.form.icon_new') }}</label>
                            <div class="col-md-6">
                                 <div class="input-group">
                                    <span class="input-group-btn">
                                      <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                      </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="icon">
                                 </div>
                                 <img id="holder" style="margin-top:15px;max-height:100px;">
                            </div>
                        </div>
                        <!-- Form actions -->
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                @if ($USER_LOGGED->canAccess('dhcd.document.cate.edit'))                                    
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">{{ trans('dhcd-document::language.buttons.save') }}</button>
                                @endif
                                
                            </div>
                        </div>
                    </fieldset>
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
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        });
        var domain = "/admin/laravel-filemanager/";
        $('#lfm').filemanager('image', {prefix: domain});
        
        $("#form-edit").bootstrapValidator({
                excluded: ':disabled',
                fields: {

                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập tên danh mục'
                            }
                        }
                        
                    }                                                                           
                }
            });
        
    </script>
@stop
