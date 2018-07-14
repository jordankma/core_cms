@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-newsfrontend::language.titles.list') }}@stop

{{-- page styles --}}
@section('header_styles')
@stop
<!--end of page css-->
<style type="text/css">
    #content-news .img-display-news{
        max-height: 125px;
        width: 100%;
    }
    #content-news .time{
        margin-top: 5px;
        font-size: 12px;
        color: gray;
    }
    #content-news .title{
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
    }
</style>

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>TIN TỨC</h1>
        {{-- <ol class="breadcrumb">
            <li>
                <a href="{{ route('frontend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol> --}}
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border" id="content-news">
                <ul class="list-group list-group-flush">
                    @if(!empty($list_news))
                    @foreach($list_news as $news)
                    @php
                        $date = date_create($news['created_at']);
                        $date_created = date_format($date,"d/m/Y");
                        $cate_name = '';
                        $cate = json_decode($news['news_cat'],true);
                        if(isset($cate[0]['name'])){
                            $cate_name = $cate[0]['name'];    
                        }
                    @endphp
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 ">
                                <a href="{{route('news.frontend.detail',['news_id'=>$news->news_id])}}">
                                    <img src="{{$news->image != null ? $url_storage.$news->image : 'http://dhcd1.vnedutech.vn/photos/Logo-Dai-hoi-Cong-Doan.png'}}" class="img-display-news img-reponsive">
                                </a>
                            </div>
                            <div class="col-md-10">
                                <p class="time">{{ $cate_name.' - '.$date_created }}</p>
                                <a href="{{route('news.frontend.detail',['news_id'=>$news->news_id])}}" class="title">{{$news->title}}</a>
                                <p class="desc">
                                    {{$news->desc}}
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @endif
                    <div class="row" id="hidden">
                        <div class="col-md-12">
                            <div class="center">
                                {{$list_news->links()}}
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
