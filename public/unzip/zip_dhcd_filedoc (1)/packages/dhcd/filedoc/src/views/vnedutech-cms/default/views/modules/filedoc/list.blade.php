@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = !empty($cate) ? $cate->name : 'Danh mục tài liệu' }}@stop

{{-- page level styles --}}
@section('header_styles')
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
@stop

<style>
    .blogShort{ padding: 15px; border-bottom:1px solid #ddd;}
    article{ padding-left: 65px;}
    .title-doc{font-weight: bold; margin-top: 0px;}
</style>

@php

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>{{ $title }}</h1>
    
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">

            <div class="panel-body">
                @if(!empty($documents->toArray()['data']))
                @foreach($documents->toArray()['data'] as $key => $doc)
                    @if(!empty($doc['avatar']))                    
                    <div class='col-md-6'>                                           
                        <div id="myCarousel" class="carousel image-carousel slide">
                            <div class="carousel-inner">
                                <div class="active item">
                                    <img src="{{asset($doc['avatar'])}}" style="width: 100%; height: 250px;"  class="img-responsive" alt="">
                                </div>                           
                            </div>                       
                        </div>
                        <div class="top-news" style="padding: 10px;">
                            <a href="{{route('dhcd.filedoc.DocumentDetail',['alias_cate' => $cate['alias'], 'alias' => $doc['alias']])}}" style="color: black;font-weight: bold;font-size: 16px;">
                                <span>{{$doc['name']}}</span>

                            </a>
                        </div>                            
                    </div>
                    @else                    
                    <div class="col-md-12 blogShort">
                        <a style="float: left;" href="{{route('dhcd.filedoc.DocumentDetail',['alias_cate' => $cate['alias'], 'alias' => $doc['alias']])}}">                        
                        @if($doc['get_type']['type'] == 'text')
                            <i class="fa fa-file-word-o" style="font-size:60px;color:blue;"></i> 
                        @elseif($doc['get_type']['type'] == 'video')
                            <i class="fa fa-file-video-o" style="font-size:60px;color:black;"></i> 
                        @elseif($doc['get_type']['type'] == 'audio')
                            <i class="fa fa-file-sound-o" style="font-size:60px;color:black;"></i> 
                        @endif
                        </a>
                        <article>
                            <h4 class='title-doc' >{{$doc['name']}}</h4>
                            <p style="text-align: justify;">
                                {{\Illuminate\Support\Str::words($doc['descript'],55)}}
                            </p>
                        </article>
                    </div>
                    @endif
                    
                @endforeach
                @endif
                <div class='row col-md-12'>
                    <div class="dataTables_paginate paging_simple_numbers">                                
                        <ul class="pagination">
                            @if(!empty($params))
                            {{$documents->appends(['document_cate_id' => $params['document_cate_id'],'document_type_id' => $params['document_type_id'], 'name' => $params['name'],'limit' => $params['limit']])->links('DHCD-FILEDOC::modules.filedoc.pagination') }}                            
                            @else
                            {{$documents->links('DHCD-FILEDOC::modules.filedoc.pagination') }}                            
                            @endif
                        </ul>
                    </div>
                </div>    
            </div>
        </div>
    </div>    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

@stop
