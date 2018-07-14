@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-index::language.titles.index') }}@stop

{{-- page styles --}}
@section('header_styles')
@stop
<!--end of page css-->
<style type="text/css">
    #index .img-display-news{
        max-height: 125px;
        width: 100%;
    }
    #index .time{
        margin-top: 5px;
        font-size: 12px;
        color: gray;
    }
    #index .title{
        font-size: 22px;
        font-weight: bold;
    }  
    #index .nav-tabs a{
        color: black;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
    }
    #index .nav-tabs .active a{
        background-color: #3498db !important;
        color: #fff;
    }
    #events{
        margin-top: 20px;
    }
    #events .time span{
        font-weight: bold;
        padding-left: 8px;
    } 
</style>
{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>TRANG CHỦ</h1>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border" id="index">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class=" nav-item active">
                            <a href="#news" data-toggle="tab" class="nav-link">Tin tức</a>
                        </li>
                        <li class="nav-item">
                            <a href="#events" data-toggle="tab" class="nav-link">Chương trình</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="slim2">
                        <div class="tab-pane active" id="news">
                            {{-- list news --}}
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
                                                <img src="{{$url_storage.$news->image}}" class="img-display-news img-reponsive">
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
                            {{-- list news --}}
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="events">
                            {{-- list-events --}}
                            <!-- Custom Tabs -->
                            <p>Chọn ngày để xem lịch trình</p>
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    @if(!empty($list_events))
                                    @foreach($list_events as $key => $news)
                                    @php
                                        $date = date_create($news->date);
                                        $date_created = date_format($date,"d-m-Y");
                                    @endphp
                                    <li class=" nav-item @if($key==0) active @endif">
                                        <a href="#day-{{$key}}" data-toggle="tab" class="nav-link">{{$date_created}}</a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                                <div class="tab-content" id="slim2">
                                    @if(!empty($list_events))
                                    @foreach($list_events as $key => $news)
                                    @php
                                        $list_time = json_decode($news->event_detail,true); 
                                    @endphp
                                    <div class="tab-pane @if($key==0) active @endif" id="day-{{$key}}">
                                        <ul class="list-group list-group-flush">
                                            @if(!empty($list_time))
                                            @foreach($list_time as $key2 => $time)
                                            <li class="list-group-item">
                                                <p class="time"><i class="glyphicon glyphicon-time"></i><span>{{$time['start_time']}} - {{$time['end_time']}}</span></p>
                                                <p>{{$time['content']}}</p>
                                            </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->   
                            {{-- list-events --}}
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->   
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <!--end of page js-->
    <script>
    
    </script>
@stop
