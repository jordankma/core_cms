@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-member::language.titles.member.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
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
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                <!-- errors -->
                <form role="form" action="{{route("dhcd.member.member.update")}}" method="post" enctype="multipart/form-data" id="form-add-member">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="member_id" value="{{ $member->member_id }}"/>
                <div class="row">
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.name') }}</label>
                            <input type="text" name="name" value="{{$member->name}}" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.name')}}">
                        </div>
                        <label>{{trans('dhcd-member::language.form.title.position') }}</label>
                        <div class="form-group input-group">
                            <input type="text" name="position" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.position_text')}}" id="position_text" style="display: none" disabled>
                            <select class="form-control select2" id="position_select" name="position" placeholder="{{trans('dhcd-member::language.placeholder.member.position_select')}}">
                                @if(!empty($list_position))
                                    @foreach($list_position as $position)
                                        <option value="{{$position->position}}" @if($member->position==$position->position) selected="" @endif>{{$position->position}}</option>     
                                    @endforeach
                                @endif                
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="change-type-position">
                                    <i class="fa fa-random"></i>
                                </button>
                            </span>
                        </div>
                        <label>{{trans('dhcd-member::language.form.title.trinh_do_ly_luan') }}</label>
                        <div class="form-group input-group">
                            <input type="text" name="trinh_do_ly_luan" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.trinh_do_ly_luan_text')}}" id="trinh_do_ly_luan_text" style="display: none" disabled>
                            <select class="form-control select2" id="trinh_do_ly_luan_select" name="trinh_do_ly_luan" placeholder="{{trans('dhcd-member::language.placeholder.member.trinh_do_ly_luan_select')}}">
                                @if(!empty($list_trinh_do_ly_luan))
                                    @foreach($list_trinh_do_ly_luan as $trinh_do_ly_luan)
                                        <option value="{{$trinh_do_ly_luan->trinh_do_ly_luan}}" @if($member->trinh_do_ly_luan==$trinh_do_ly_luan->trinh_do_ly_luan) selected="" @endif>{{$trinh_do_ly_luan->trinh_do_ly_luan}}</option>     
                                    @endforeach
                                @endif                 
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="change-type-trinh-do-ly-luan">
                                    <i class="fa fa-random"></i>
                                </button>
                            </span>
                        </div>
                        <label>{{trans('dhcd-member::language.form.title.trinh_do_chuyen_mon') }}</label>
                        <div class="form-group input-group">
                            <input type="text" name="trinh_do_chuyen_mon" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.trinh_do_chuyen_mon_text')}}" id="trinh_do_chuyen_mon_text" style="display: none" disabled>
                            <select class="form-control select2" id="trinh_do_chuyen_mon_select" name="trinh_do_chuyen_mon" placeholder="{{trans('dhcd-member::language.placeholder.member.trinh_do_chuyen_mon_select')}}">
                                @if(!empty($list_trinh_do_chuyen_mon))
                                    @foreach($list_trinh_do_chuyen_mon as $trinh_do_chuyen_mon)
                                        <option value="{{$trinh_do_chuyen_mon->trinh_do_chuyen_mon}}"  @if($member->trinh_do_chuyen_mon==$trinh_do_chuyen_mon->trinh_do_chuyen_mon) selected="" @endif>{{$trinh_do_chuyen_mon->trinh_do_chuyen_mon}}</option>     
                                    @endforeach
                                @endif                 
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="change-type-trinh-do-chuyen-mon">
                                    <i class="fa fa-random"></i>
                                </button>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.address') }}</label>
                            <textarea class="form-control" name="address" placeholder="{{trans('dhcd-member::language.placeholder.member.address')}}">{{$member->address}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.don_vi') }}</label>
                            <textarea class="form-control" name="don_vi" placeholder="{{trans('dhcd-member::language.placeholder.member.don_vi')}}">{{$member->don_vi}}</textarea>
                        </div>
                        <label>{{trans('dhcd-member::language.form.title.gender') }}</label>
                        <div class="form-group">
                            <label class="radio-inline" for="female">
                            <input type="radio" id="female" name="gender" value="female" @if($member->gender=='female') checked="checked" @endif>
                            Female</label>
                            <label class="radio-inline" for="male" > 
                            <input type="radio" id="male" name="gender" value="male" @if($member->gender=='male') checked="checked" @endif>
                            Male</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.dan_toc') }}</label>
                            <input type="text" value="{{$member->dan_toc}}" name="dan_toc" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.dan_toc')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.ton_giao') }}</label>
                            <input type="text" name="ton_giao" value="{{$member->ton_giao}}" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.ton_giao')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.ngay_vao_dang') }}</label>
                            <input type="text" name="ngay_vao_dang" value="{{$member->ngay_vao_dang}}" class="form-control" id="ngay_vao_dang" placeholder="{{trans('dhcd-member::language.placeholder.member.ngay_vao_dang')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.birthday') }}</label>
                            <input type="text" name="birthday" value="{{$member->birthday}}"  class="form-control" id="birthday" placeholder="{{trans('dhcd-member::language.placeholder.member.birthday')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.avatar') }}</label>
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                            <input id="thumbnail" value="{{$member->avatar}}" class="form-control" type="text" name="avatar">
                            <img id="holder" src="{{$member->avatar}}" style="margin-top:15px;max-height:100px;">
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                </div>
                    <div class="form-group" style="text-align: center;">
                        <button type="submit" class="btn btn-success">{{ trans('dhcd-member::language.buttons.update') }}</button>
                        <a href="{!! route('dhcd.member.member.create') !!}"
                           class="btn btn-danger">{{ trans('dhcd-member::language.buttons.discard') }}</a>
                    </div>
                </form>
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
                
            var check_position = 0;
            $('body').on('click','#change-type-position',function(e){
                if (check_position % 2 == 0) {
                    $("#position_text").css('display', 'block');
                    $('#position_text').prop('disabled', false);
                    $('#position_select').prop('disabled', true);
                    $("#position_select").css('display', 'none');
                } else {
                    $("#position_text").css('display', 'none');
                    $('#position_text').prop('disabled', true);
                    $('#position_select').prop('disabled', false);
                    $("#position_select").css('display', 'block');
                }
                check_position++;
            });
            var check_lyluan = 0;
            $('body').on('click','#change-type-trinh-do-ly-luan',function(e){
                if (check_lyluan % 2 == 0) {
                    $("#trinh_do_ly_luan_text").css('display', 'block');
                    $('#trinh_do_ly_luan_text').prop('disabled', false);
                    $('#trinh_do_ly_luan_select').prop('disabled', true);
                    $("#trinh_do_ly_luan_select").css('display', 'none');
                } else {
                    $("#trinh_do_ly_luan_text").css('display', 'none');
                    $('#trinh_do_ly_luan_text').prop('disabled', true);
                    $('#trinh_do_ly_luan_select').prop('disabled', false);
                    $("#trinh_do_ly_luan_select").css('display', 'block');
                }
                check_lyluan++;
            });
            var check_chuyenmon = 0;
            $('body').on('click','#change-type-trinh-do-chuyen-mon',function(e){
                if (check_chuyenmon % 2 == 0) {
                    $("#trinh_do_chuyen_mon_text").css('display', 'block');
                    $('#trinh_do_chuyen_mon_text').prop('disabled', false);
                    $('#trinh_do_chuyen_mon_select').prop('disabled', true);
                    $("#trinh_do_chuyen_mon_select").css('display', 'none');
                } else {
                    $("#trinh_do_chuyen_mon_text").css('display', 'none');
                    $('#trinh_do_chuyen_mon_text').prop('disabled', true);
                    $('#trinh_do_chuyen_mon_select').prop('disabled', false);
                    $("#trinh_do_chuyen_mon_select").css('display', 'block');
                }
                check_chuyenmon++;
            });    

            var domain = "/admin/laravel-filemanager/";
            $('#lfm').filemanager('image', {prefix: domain});
            $('#birthday,#ngay_vao_dang').datetimepicker({
                format: 'YYYY-MM-DD',
            });
            $('#form-add-member').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            stringLength: {
                                min: 3,
                                max: 30,
                                message: 'Tên phải từ 3 đến 30 kí tự'
                            },
                        }
                    },
                }
            });   
        })
    </script>
@stop
