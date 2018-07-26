@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-document::language.titles.document.create') }}@stop

{{-- page styles --}}
@section('header_styles')
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/css/app.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css"/>  
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
<style>
    .control-label{
        text-align: left !important;
    }
    
    .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover{
        background-color: #cccccc;
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
            <a href="{{route('dhcd.document.doc.manage')}}">
                <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('adtech-core::labels.home') }}
            </a>
        </li>
        <li class="active"><a href="{{route('dhcd.document.doc.add')}}">{{ $title }}</a></li>
    </ol>
</section>
<!--section ends-->
<section class="content paddingleft_right15">
    <!--main content-->
    <div class="row">

        <div class="the-box no-border">                
            <form data-toggle="validator" role="form" id="form-add-document" class="form-horizontal" action="{{route('dhcd.document.doc.create')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type='hidden' id='type_control' name='type_control' value="">
                <input type='hidden' id='mutil' name='mutil' value="remove">
                <fieldset>
                    <!-- Name input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">{{trans('dhcd-document::language.document.form.name')}}</label>
                        <div class=" col-md-6 ">
                            <input id="name" name="name" value="{{old('name')}}" type="text" placeholder="{{trans('dhcd-document::language.placeholder.document.name')}}" class="form-control">                                
                        </div>
                    </div>                                               

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="document_cate_id">{{trans('dhcd-document::language.document.form.document_cate_id')}}</label>
                        <div class="col-md-6">
                            <select id="document_cate_id" multiple="multiple" class="form-control" name="document_cate_id[]">
                                @if(!empty($cates))
                                {{$cateObj->showCategories($cates)}}
                                @endif
                            </select>
                        </div>     
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="desc">{{trans('dhcd-document::language.document.form.desc')}}</label>
                        <div class=" col-md-6 ">
                            <textarea id="desc" name="descript" class="form-control" rows="5">{{old('descript')}} </textarea>                               
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('dhcd-document::language.document.form.document_type_id')}}</label>
                        <div class="col-md-6">
                            @foreach($types as $i => $type)
                            
                            <label class="radio-inline radio radio-primary">
                                <input class='choice-type' {{$i == 0 ? 'checked' : ''}} id="type_{{$type['document_type_id']}}" type="radio" name="document_type_id" value="{{$type['document_type_id']}}" data-types='{{$type['extentions']}}'>
                                <label style="padding: 0px 10px 0px 5px;" for="type_{{$type['document_type_id']}}">{{$type['name']}}</label>
                            </label>
                            @endforeach             
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">{{trans('dhcd-document::language.document.form.file')}}</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                
                            </div>
                            <div id="icon_file" style="margin-top:15px;max-height:100px;">
                                
                            <div>                           
                        </div>
                    </div>
                    
                        </div>
                    </div>
                    <div class="form-group " id="list-item" >
                        <label class="col-md-2 control-label">{{trans('dhcd-document::language.document.form.file')}}</label>
                        <div class="col-md-10" >
                            <table class="table table-striped table-bordered table-list" style='font-size: 12px;'>
                                <thead>
                                <th>File</th>
                                <th>Tên</th>
                                <th>Ảnh đại diện</th>
                                <th>Action</th>
                                </thead>
                                <tbody id="list-file">


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Form actions -->
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            @if ($USER_LOGGED->canAccess('dhcd.document.doc.add'))                                    
                            <button type="submit" class="btn btn-responsive btn-primary btn-sm text-button add-doc">{{ trans('dhcd-document::language.buttons.create') }}</button>
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
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>                        
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" type="text/javascript"></script>

<script src="{{ asset('/vendor/laravel-filemanager/js/lfm2.js') }}" type="text/javascript" ></script>
<!--end of page js-->
<script>
$(function () {
    $("[name='permission_locked']").bootstrapSwitch();
});
var domain = "/admin/laravel-filemanager/";
$('#lfm').filemanager2('application', {prefix: domain});
$(document).ready(function () {

    
    $("#document_cate_id").multiselect({
        enableFiltering: true,
        includeSelectAllOption: true,
        buttonWidth: '367px',
        maxHeight: 600,
        dropUp: false,
        nonSelectedText: 'Chọn danh mục'
    });
    
    
      
    $("#form-add-document").bootstrapValidator({
        excluded: ':disabled',
        fields: {

            name: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa nhập tên tài liệu'
                    }
                }

            },

            document_type_id: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa chọn kiểu tài liệu'
                    }
                }
            },
            'document_cate_id[]': {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa chọn danh mục tài liệu'
                    }
                }
            },
            descript: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa chọn kiểu tài liệu'
                    }
                }

            }
        }
    });
});
function setData(data) {
    $("#list-item").css('display', 'block');
    $("#type_control").val(data.type_file);
    var html = '';
    html += '<tr class="/files/' + data.title + '">';    
    html += '<td>';
    if(data.type_file ==='img')
    {
        html += '<img src="' + data.src + '" width="75px">'
    }else{
        html += '<i class="fa fa-file fa-5x"></i>';
    }
    html +='</td>';
    html += '<td>' + data.title + '</td>';
    
    if(data.type_file ==='img')
    {
         html += '<td><input type="radio" name="setAvatar"  value="/files/'+data.title+'"></td>';
    }
    else{
        html += '<td></td>';
    }
    html += '<td><a href="javascrip::void(0,0)"  class="btn btn-danger del-media" >';
    html += '<span style="margin:0px;" class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
    html += '</a></td>'
    html += '<input type="hidden" name="file_names[]"  value="/files/' + data.title + '">';
    html += '<input type="hidden" name="file_types[]"  value="' + data.type + '">';
    html += '</tr>';
    if ($("tr").hasClass('/files/'+data.title)) {
        
    } else
    {         
         $("#list-file").append(html);
    }       
}
function reSetData() {
    $("#icon_file").html('<i class="fa fa-file fa-5x"></i>');
    $("#list-item").css('display', 'none');   
    $("#icon_file").append('');
    
   
}
$('body').on('click', '.del-media', function () {
        $(this).parent().parent().remove();
});
$('body').on('change','.choice-type',function(){
    $("#list-file").html('');
});
;
</script>
@stop