@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-news::language.titles.news.edit') }} @stop
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
            background-color: lightblue !important;
        }
        #cate .btn-group{
            width: 100% !important;
        }
        .bootstrap-tagsinput{
            width: 100% !important;
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
                <form role="form" action="{{route('dhcd.news.news.update',$news->news_id)}}" method="post" enctype="multipart/form-data" id="form-edit-news">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            @if(count($errors))
                                @foreach($errors -> all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.title')}}</label>
                                <input type="text" required name="title" value="{{$news->title}}" class="form-control" placeholder="{{trans('dhcd-news::language.form.title_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.desc')}}</label><br>
                                <textarea rows="5" cols="101" name="desc"  class="form-control" placeholder="{{trans('dhcd-news::language.form.desc_placeholder')}}">{{$news->desc}}</textarea>
                            </div>
                            <div class="form-group" >
                                <label>{{trans('dhcd-news::language.form.text.content')}}</label><br>
                                <div class='box-body pad form-group'>
                                    {{-- <input type="textarea" name="content" rows="5"  class="textarea form-control" style="width: 100%; height: 200px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"> --}}
                                    <textarea name="content" id="ckeditor"  placeholder="{{trans('dhcd-news::language.form.content_placeholder')}}">{{$news->content}}</textarea>
                                    <script>
                                       
                                    </script>
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
                                        @if(in_array($news_cat->news_cat_id, $list_id_cat))
                                            <option value="{{$news_cat->news_cat_id}}"  selected >{{str_repeat('+', $news_cat->level) .$news_cat->name}}</option>
                                        @else
                                            <option value="{{$news_cat->news_cat_id}}">{{str_repeat('+', $news_cat->level) .$news_cat->name}}</option>    
                                        @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group area-tag">
                                <label>{{trans('Thêm tag')}}</label><br>
                                <div class="input-group">
                                    <input type="text" name="news_tag_add" value="" class="form-control" placeholder="{{trans('dhcd-news::language.form.tags_placeholder')}}" id="text-tag">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" id="add-tag">Thêm</button> <br>
                                    </span>
                                 </div>
                                <p style="color: red"> Các tag cách nhau bằng dấu phẩy</p>
                                <label>{{trans('Chọn tag')}}</label>
                                <select id="tag" class="form-control" name="news_tag[]" required multiple="multiple">
                                    @if(!empty($list_news_tag))
                                    @foreach($list_news_tag as $nt)
                                        <option value="{{$nt->news_tag_id}}" @if(in_array($nt->news_tag_id, $list_id_tag)) selected="" @endif>{{$nt->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <label>{{trans('dhcd-news::language.form.text.image')}}</label>
                            <div class="input-group">
                               <span class="input-group-btn">
                                 <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                   <i class="fa fa-picture-o"></i> Choose 
                                 </a>
                               </span>
                               <input id="thumbnail" class="form-control" type="text" value="{{$news->image}}" name="filepath">
                             </div>
                             <img id="holder" src="{{$news->image}}" style="margin-top:15px;max-height:100px;">
                            <div class="form-group">
                                <input type="radio" id="hot" @if($news->is_hot==1) checked @endif name="is_hot" value="1">
                                <label for="normal">{{trans('dhcd-news::language.form.text.news_hot')}}    </label> <br>
                                <input type="radio" @if($news->is_hot==2) checked @endif id="normal" name="is_hot" value="0">
                                <label>    {{trans('dhcd-news::language.form.text.news_normal')}}</label>
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.priority')}}</label>
                                <input class="form-control" type="number" name="priority" value="{{$news->priority}}" placeholder="{{trans('dhcd-news::language.form.priority_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.key_seo')}}</label> <br>
                                <input type="text" name="key_word_seo[]" value="{{$list_key_word_seo_string}}" class="form-control" data-role="tagsinput" placeholder="{{trans('dhcd-news::language.form.seo_key_word_placeholder')}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans('dhcd-news::language.form.text.desc_seo')}}</label>
                                <textarea rows="5" cols="101" name="desc_seo" class="form-control" placeholder="{{trans('dhcd-news::language.form.desc_seo_placeholder')}}">{{$news->desc_seo}}</textarea>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">{{trans('dhcd-news::language.buttons.create')}}</button>
                            <a href="" class="btn btn-danger">{{trans('dhcd-news::language.buttons.discard')}}</a>
                        </div>
                        <!-- /.col-sm-8 -->
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
        $('#form-edit-news').bootstrapValidator({
            feedbackIcons: {
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'Bạn chưa nhập tiêu đề'
                        },
                        stringLength: {
                            max: 250,
                            message: 'Tiêu đề không được quá dài'
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
        $('body').on('click','#add-tag',function(e){
            e.preventDefault();
            var list_tag = $('#text-tag').val();
            var i;
            if(list_tag!=''){
                $.ajax({
                    url: "{{route('dhcd.news.tag.ajax.add')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').prop('content')
                    },
                    type: 'POST',
                    cache: false,
                    data: {
                        'list_tag': list_tag
                    },
                    success: function (response) {
                        var text = '';
                        var data = JSON.parse(response);
                        for( i in data){
                            // text += '<li><a tabindex="0"><label class="checkbox" title="'+data[i].name+'"><input type="checkbox" value="'+data[i].news_tag_id+'"> '+data[i].name+'</label></a></li>'
                            text += '<option value="'+data[i].news_tag_id+'" selected="">'+data[i].name+'</option>';
                        }
                        $('#tag').prepend(text);
                        $('#tag').multiselect('rebuild');
                    }
                }, 'json');
            }
            // $('.area-tag .multiselect-container').append('<li><a tabindex="0"><label class="checkbox" title="Hà nội"><input type="checkbox" value="3"> Hà nội</label></a></li>');
        });  
    </script>
@stop
