@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = \Illuminate\Support\Str::words($document->name,10) }}@stop

{{-- page level styles --}}
@section('header_styles')
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
@stop

<style>
    .blogShort{ padding: 15px; border-bottom:1px solid #ddd;}
    article{ padding-left: 85px;}
    .title-doc{font-weight: bold; margin-top: 10px;}
    .hide-bullets {
        list-style:none;
        margin-left: -40px;
        margin-top:20px;
        }
</style>

@php
$listFile = !empty($document->file) ? json_decode($document->file,true) : '';
$type = !empty($document->getType) ? $document->getType->type : '';

@endphp
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
                @if(!empty($type))
                    @if($type == 'image')
                    <div class="row">
                        <div id="main_area">
                            <!-- Slider -->
                            <div class="row">
                                <div class="col-md-12" id="slider">
                                    <!-- Top part of the slider -->
                                    <div class="row">
                                        <div class="col-xs-12" id="carousel-bounding-box">
                                            <div class="carousel slide" id="myCarousel">
                                                <!-- Carousel items -->
                                                <div class="carousel-inner">
                                                    @if(!empty($listFile))
                                                    @foreach($listFile as $i => $file)
                                                    <div class="@if($i==0) active @endif item" data-slide-number="{{$i}}">
                                                        <img width="1024" height="300" src="{{$file['name']}}">
                                                    </div>
                                                    @endforeach
                                                    @endif


                                                </div><!-- Carousel nav -->
                                                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                                    <span class="glyphicon glyphicon-chevron-left"></span>                                       
                                                </a>
                                                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                                    <span class="glyphicon glyphicon-chevron-right"></span>                                       
                                                </a>                                
                                            </div>
                                        </div>                                                                       
                                    </div>
                                </div>
                            </div><!--/Slider-->
                            <div class="row">
                                <div class="row hidden-xs" id="slider-thumbs">
                                    <!-- Bottom switcher of slider -->
                                    <ul class="hide-bullets">
                                        @if(!empty($listFile))
                                        @foreach($listFile as $i => $file)

                                        <li class="col-md-2">
                                            <a class="thumbnail" id="carousel-selector-{{$i}}"><img src="{{$file['name']}}"></a>
                                        </li>
                                        @endforeach
                                        @endif

                                    </ul>                 
                                </div>
                            </div>    
                        </div>
                    </div>
                    @elseif($type == 'text')
                    
                    <h3 style="font-weight: bold;">{{$document->name}}</h3>
                    @if(!empty($listFile))
                        
                        <div class='row'>                                  
                            <div class="form-group">
                                @foreach($listFile as $i => $file)
                                <label class="col-md-12 control-label">File đính kèm {{$i+1}} : <a href="{{asset($file['name'])}}" target="_blank">Tải xuống</a> </label>
                                 @endforeach
                            </div> 
                        </div>                                                                        
                       
                    @endif
                    <div class='form-group'>
                        <p class='text-content' style="text-align: justify;">{{$document->descript}}</p>
                     </div>
                    @elseif($type == 'video')
                    
                    <div class='row '>
                        <div class='col-md-12'>
                            <h3 style="font-weight: bold;">{{$document->name}}</h3>
                            <div class='form-group'>
                                <p class='text-content' style="text-align: justify;">{{$document->descript}}</p>
                            </div>
                            
                                
                                @if(!empty($listFile))
                                    @foreach($listFile as $i => $file)
                                    <div class='row text-center'>                                  
                                        <video width="auto" controls>
                                            <source src="{{$file['name']}}" type="video/mp4">
                                        </video>
                                    </div>                                                                        
                                    @endforeach
                                @endif
                           
                        </div>
                    </div>    
                    
                    @elseif($type == 'audio')
                    <div class='row '>
                        <div class='col-md-12'>
                            <h3 style="font-weight: bold;">{{$document->name}}</h3>                                                                                        
                                @if(!empty($listFile))
                                    @foreach($listFile as $i => $file)
                                    <div class='row text-center'>                                  
                                        <audio controls>                                    
                                            <source src="{{asset($file['name'])}}" type="audio/mpeg">                                 
                                        </audio>
                                    </div>
                                    
                                    @endforeach
                                @endif 
                           <div class='form-group'>
                                <p class='text-content' style="text-align: justify;">{{$document->descript}}</p>
                           </div>     
                        </div>
                    </div>
                    @else
                    <h2 >Tệp tin không xác định</h2>
                    @endif
                                                            
                @endif
                
            </div>
        </div>
    </div>    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
<script>
$(document).ready(function($) {
 
        $('#myCarousel').carousel({
                interval: 5000
        });
 
        $('#carousel-text').html($('#slide-content-0').html());
 
        //Handles the carousel thumbnails
       $('[id^=carousel-selector-]').click( function(){
            var id = this.id.substr(this.id.lastIndexOf("-") + 1);
            var id = parseInt(id);
            $('#myCarousel').carousel(id);
        });
 
 
        // When the carousel slides, auto update the text
        $('#myCarousel').on('slid.bs.carousel', function (e) {
                 var id = $('.item.active').data('slide-number');
                $('#carousel-text').html($('#slide-content-'+id).html());
        });
});
</script>
@stop
