@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-events::language.titles.events.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <style>
        fieldset.scheduler-border {
        border-radius: 25px;
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
             }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width:auto;
            padding:0 10px;
            border-bottom:none;
        }
        .fa-trash{
            padding-left: 20px;
        }
        .label{
            padding-left: 10px;
            color: black;
            font-size: 14px;
        }
      </style>
@stop
<!--end of page css-->


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title = trans('dhcd-events::language.titles.events.create') }}</h1>
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
                <!-- errors -->
                {!! Form::open(array('url' => route('dhcd.events.events.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'eventsForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                
                    <div class="row">

                        <div class="col-xs-3 col-sm-3 col-md-3">
                            {{$title = trans('dhcd-events::language.titles.events.name')}} :
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-6">
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('dhcd-events::language.placeholder.events.name_here'))) !!}
                                    <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            {{$title = trans('dhcd-events::language.titles.events.date')}} :
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-6">
                            <div class="form-group {{ $errors->first('date', 'has-error') }}">
                                {{-- {!! Form::date('date',\Carbon\Carbon::now(),array('class'=> 'form-control')) !!} --}}
                                <input type="text" id="datepicker" name="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            {{$title = trans('dhcd-events::language.titles.events.content')}} :
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-6">
                            <div class="form-group {{ $errors->first('content', 'has-error') }}">
                                {!! Form::textarea('content', null, array('class' => 'form-control', 'placeholder'=> trans('dhcd-events::language.placeholder.events.content'))) !!}
                                    <span class="help-block">{{ $errors->first('content', ':message') }}</span>
                            </div >
                            </div >
                        </div>
                         <div class="row">
                    <fieldset class="scheduler-border">
                    
                        <legend class="scheduler-border">
                            <div  class="col-md-12">
                                <span class="scheduler-border">
                                    {{$title = trans('dhcd-events::language.titles.events.event_detail')}} :
                                <button type="button" class="btn btn-success" onclick="myFunction()">{{ trans('dhcd-events::language.buttons.create') }}</button>
                                </span>
                            </div>
                        </legend>
                            <div class=" col-md-9 pull-right">
                                <div class="form-group">
                                    <table id="myTable" >
                                        <tr id="beforeID"></tr>
                                    </table>
                                </div >
                            </div>
                  
                    </fieldset>
                </div>
                     <br/>
                    <div class="row">
                     <div class="col-md-6">
                        <center>
                            <button type="submit" class="btn btn-success" >{{ trans('dhcd-events::language.buttons.save') }}</button>
                        </center>
                     </div>
                    </div>
            </div>
               
               

                {!! Form::close() !!}
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
    <!--end of page js-->
    <script>
        function myFunction() {
            var table = document.getElementById("myTable");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            cell1.innerHTML = "<label class='label'>Từ :      <label>";
            cell2.innerHTML = "<input type='time'  class='form-control' name='start_time[]'>";
            cell3.innerHTML = "<label class='label'>Đến :     <label>";
            cell4.innerHTML = "<input type='time'  class='form-control' name='end_time[]'>";
            cell5.innerHTML = "<label class='label'>Nội Dung :     <label>";
            cell6.innerHTML = "<textarea type='text'  class='form-control' name='event_content[]'>";
            cell7.innerHTML = "<i style='font-size:20px' type='button' value='Delete' onclick='deleteRow(this)' class='fa fa-trash'></i>";
            $('#beforeID').before(row);
        }
        function deleteRow(r) {
            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("myTable").deleteRow(i);
        }
        </script>
    <script>
        $(function () {
            $("[name='permission_locked'], [name='status']").bootstrapSwitch();
            $("[name='permission_locked'], [name='visible']").bootstrapSwitch();
        })
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>
      $( function() {
        $( "#datepicker" ).datepicker();
      } );
      </script>
            
@stop
