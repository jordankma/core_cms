@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-news::language.titles.news_cat.edit') }} @stop
{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
    <!--main content-->
    <section class="content paddingleft_right15">
            <div class="the-box no-border">
                <div class="row">
                        <form action="{{route('dhcd.news.tag.update')}}" method="post" id="form-add-tag">
                            <input type="hidden" name="news_tag_id" value="{{$news_tag->news_tag_id}}">
                            <div class="col-md-5" style="">
                                <div class="form-group ui-draggable-handle" style="position: static;">
                                    <label for="input-text-1">{{trans('dhcd-news::language.label.name')}}</label>
                                    <input type="text" name="name" value="{{$news_tag->name}}" class="form-control" id="input-text-1" placeholder="{{trans('dhcd-news::language.form.tags_placeholder')}}">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success">{{trans('dhcd-news::language.buttons.update')}}</button>
                                <a href="{{route('dhcd.news.tag.manager')}}" class="btn btn-danger">{{trans('dhcd-news::language.buttons.discard')}}</a>
                            </div>
                        </form>
                </div>
            </div>
    </section>
    <!--main content ends-->            
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/dhcd/news/js/news_cat/add.js') }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script type="text/javascript">
        $('#form-add-tag').bootstrapValidator({
            feedbackIcons: {
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Bạn chưa nhập chuyên đề'
                        },
                        stringLength: {
                            max: 250,
                            message: 'Tên không được quá dài'
                        }
                    }
                }
            }
        });
        $('#cat-child').change(function(){
            if(this.checked){   
                $(this).val("1");
                $('#list-cat').fadeIn();
            }
            else{
                $(this).val("0");
                $('#list-cat').fadeOut();
            }
        });
    </script>
@stop
