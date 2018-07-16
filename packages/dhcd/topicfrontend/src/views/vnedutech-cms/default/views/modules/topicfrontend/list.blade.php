@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-topicfrontend::language.titles.list') }}@stop

{{-- page styles --}}
@section('header_styles')
@stop
<!--end of page css-->
<style type="text/css">
    #list-topic .img-display-topics{
        height : 125px;
        width: 125px;
    }
    #list-topic .time{
        margin-top: 5px;
        font-size: 12px;
        color: gray;
    }
    #list-topic .title{
        font-size: 16px;
        font-weight: bold;
    }
    .lock{
        color: red;
        margin-top: 4%;
    }
    .the-box{
        padding: 15px;
        margin-bottom: 30px;
        border: 1px solid #D5DAE0;
        position: relative;
        background: white;

    }
    .content-right{
        margin-left: 20px;
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
                        $lock = 1;
                        if(in_array($topics->topic_id, $list_topic_id)) {
                            $lock = 2;
                        }
                    @endphp
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-1">
                                <a href="{{route('topic.frontend.detail',['topics_id'=>$topics->topics_id])}}" data-lock="{{$lock}}" class="check-lock">
                                    <img src="{{$topics->image}}" class="img-display-topics img-reponsive">
                                </a>
                            </div>
                            <div class="col-md-9 content-right" >
                                <p class="time">{{ $date_created }}</p>
                                <a href="{{route('topic.frontend.detail',['topics_id'=>$topics->topics_id])}}" data-lock="{{$lock}}" class="check-lock title">{{$topics->name}}</a>
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
                    <div class="center" id="hidden">
                        {{$list_topics->links()}}
                    </div>
                </ul>
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('click', '.check-lock', function(event) {
                let lock = $(this).data("lock");
                if(lock==1){
                    event.preventDefault();
                    alert('Bạn không có quyền vào topic này');
                }
            });    
        });
    </script>
@stop
