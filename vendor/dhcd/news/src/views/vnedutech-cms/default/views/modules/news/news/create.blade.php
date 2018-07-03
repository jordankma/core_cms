@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-news::language.titles.news.add') }} @stop
{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}">
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/ckeditor/js/ckeditor.js') }}" type="text/javascript"></script>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/news/css/news/add.css') }}" rel="stylesheet" type="text/css"/>
@stop
<!--end of page css-->

    <style type="text/css">
        .multiselect-container .active a{
            background-color: #fff !important;
        }
    </style>
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
                <form role="form" action="{{route("dhcd.news.news.add")}}" method="post" enctype="multipart/form-data" id="form-add-news">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            @if(count($errors))
                                @foreach($errors -> all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.title')}} {{'(*)'}}</label>
                                <input type="text" required name="title" class="form-control" placeholder="{{trans('dhcd-news::language.form.title_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.desc')}}</label><br>
                                <textarea rows="5" cols="101" name="desc" class="form-control" placeholder="{{trans('dhcd-news::language.form.desc_placeholder')}}"></textarea>
                            </div>
                            <div class="form-group" >
                                <label>{{trans('dhcd-news::language.form.text.content')}} {{'(*)'}}</label><br>
                                <div class='box-body pad form-group'>
                                    <textarea name="content" id="ckeditor" placeholder="{{trans('dhcd-news::language.form.content_placeholder')}}"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-sm-8 -->
                        <!-- /.col-sm-4 -->
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.cat')}}</label><br>
                                <select id="cate" class="form-control" name="news_cat[]" required multiple="multiple">
                                    @if(!empty($list_news_cat))
                                    @foreach($list_news_cat as $news_cat)
                                        <option value="{{$news_cat->news_cat_id}}">{{$news_cat->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.tag')}}</label><br>
                                <input type="text" name="news_tag[]" value="" class="form-control" data-role="tagsinput" placeholder="{{trans('dhcd-news::language.form.tags_placeholder')}}">
                            </div>
                            <label>{{trans('dhcd-news::language.form.text.image')}}</label>
                            <div class="input-group">
                               <span class="input-group-btn">
                                 <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                   <i class="fa fa-picture-o"></i> Choose
                                 </a>
                               </span>
                               <input id="thumbnail" class="form-control" type="text" name="filepath">
                             </div>
                             <img id="holder" style="margin-top:15px;max-height:100px;">
                            <div class="form-group">
                                <input type="radio" id="hot" name="is_hot" value="1">
                                <label for="normal">{{trans('dhcd-news::language.form.text.news_hot')}}    </label> <br>
                                <input type="radio" id="normal" name="is_hot" value="2" checked="checked">
                                <label>    {{trans('dhcd-news::language.form.text.news_normal')}}</label>
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.priority')}}</label>
                                <input class="form-control" type="number" name="priority" value="" placeholder="{{trans('dhcd-news::language.form.priority_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.key_seo')}}</label> <br>
                                <input type="text" name="key_word_seo[]" class="form-control" data-role="tagsinput" placeholder="{{trans('dhcd-news::language.form.seo_key_word_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.desc_seo')}}</label>
                                <textarea rows="5" cols="101" name="desc_seo" class="form-control" placeholder="{{trans('dhcd-news::language.form.desc_seo_placeholder')}}"></textarea>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">{{trans('dhcd-news::language.buttons.create')}}</button>
                            <a href="" class="btn btn-danger">{{trans('dhcd-news::language.buttons.discard')}}</a>
                        </div>
                        <!-- /.col-sm-4 -->
                    </div>
                    <!-- /.row -->
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/dhcd/news/js/news/add.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script>
      var options = {
        filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token='
      };
        CKEDITOR.replace('ckeditor',options);
        var domain = "/admin/laravel-filemanager/";
        $('#lfm').filemanager('image', {prefix: domain});
    </script>
    <script type="text/javascript">
        $('#form-add-news').bootstrapValidator({
            feedbackIcons: {
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'Bạn chưa nhập tiêu đề'
                        }
                    }
                },
                desc_seo: {
                    validators: {
                        stringLength: {
                            max: 500,
                            message: 'Mô tả không được quá dài'
                        }
                    }
                }
            }
        });    
    </script>
@stop
