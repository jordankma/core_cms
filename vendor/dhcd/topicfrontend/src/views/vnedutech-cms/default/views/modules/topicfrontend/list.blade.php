@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-art::language.titles.list') }}@stop

{{-- page styles --}}
@section('header_styles')
@stop
<!--end of page css-->
<style type="text/css">
    #list-topic .img-display-topics{
        max-height: 125px;
        width: 100%;
    }
    #list-topic .time{
        margin-top: 5px;
        font-size: 12px;
        color: gray;
    }
    #list-topic .title{
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .lock{
        color: red;
        margin-top: 4%;
    }
</style>

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>THẢO LUẬN</h1>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border" id="list-topic">
                <ul class="list-group list-group-flush">
                    @if(!empty($list_topics))
                    @foreach($list_topics as $topics)
                    @php
                        $date = date_create($topics['created_at']);
                        $date_created = date_format($date,"d/m/Y");
                    @endphp
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 ">
                                <a href="{{route('topic.frontend.detail',['topics_id'=>$topics->topics_id])}}">
                                    <img src="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" class="img-display-topics img-reponsive">
                                </a>
                            </div>
                            <div class="col-md-9">
                                <p class="time">{{ $date_created }}</p>
                                <a href="{{route('topic.frontend.detail',['topics_id'=>$topics->topics_id])}}" class="title">{{$topics->name}}</a>
                                <p class="desc">
                                    {{$topics->desc}}
                                </p>
                            </div>
                            <div class="col-md-1 lock">
                                @if(!in_array($topics->topic_id, $list_topic_id))
                                    <i class="glyphicon glyphicon-lock"></i>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @endif
                    <div class="row" id="hidden">
                        <div class="col-md-12">
                            <div class="center">
                                {{$list_topics->links()}}
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
