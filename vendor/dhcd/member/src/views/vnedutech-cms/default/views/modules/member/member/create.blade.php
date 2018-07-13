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
                <form role="form" action="{{route("dhcd.member.member.add")}}" method="post" enctype="multipart/form-data" id="form-add-member">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.name') }} <span style="color: red">(*)</span></label>
                            <input type="text" name="name" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.name')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.u_name') }} <span style="color: red">(*)</span></label>
                            <input type="text" name="u_name" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.u_name')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.password') }} <span style="color: red">(*)</span></label>
                            <input type="password" name="password" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.password')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.conf_password') }} <span style="color: red">(*)</span></label>
                            <input type="password" name="conf_password" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.conf_password')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.email') }} <span style="color: red">(*)</span></label>
                            <input type="text" name="email" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.email')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.phone') }} <span style="color: red">(*)</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.phone')}}">
                        </div>
                        <label>{{trans('dhcd-member::language.form.title.position') }}</label>
                        <div class="form-group input-group">
                            <input type="text" name="position" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.position_text')}}" id="position_text" style="display: none" disabled>
                            <select class="form-control select2" id="position_select" name="position" placeholder="{{trans('dhcd-member::language.placeholder.member.position_select')}}">
                                @if(!empty($list_position))
                                    @foreach($list_position as $position)
                                        <option value="{{$position->position}}">{{$position->position}}</option>     
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
                                        <option value="{{$trinh_do_ly_luan->trinh_do_ly_luan}}">{{$trinh_do_ly_luan->trinh_do_ly_luan}}</option>     
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
                                        <option value="{{$trinh_do_chuyen_mon->trinh_do_chuyen_mon}}">{{$trinh_do_chuyen_mon->trinh_do_chuyen_mon}}</option>     
                                    @endforeach
                                @endif                 
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="change-type-trinh-do-chuyen-mon">
                                    <i class="fa fa-random"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.address') }}</label>
                            <textarea class="form-control" name="address" placeholder="{{trans('dhcd-member::language.placeholder.member.address')}}"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.don_vi') }}</label>
                            <textarea class="form-control" name="don_vi" placeholder="{{trans('dhcd-member::language.placeholder.member.don_vi')}}"></textarea>
                        </div>
                        <label>{{trans('dhcd-member::language.form.title.gender') }}</label>
                        <div class="form-group">
                            <label class="radio-inline" for="female">
                            <input type="radio" id="female" name="gender" value="female" checked="checked">
                            Female</label>
                            <label class="radio-inline" for="male"> 
                            <input type="radio" id="male" name="gender" value="male" >
                            Male</label>
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.dan_toc') }}</label>
                            <input type="text" name="dan_toc" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.dan_toc')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.ton_giao') }}</label>
                            <input type="text" name="ton_giao" class="form-control" placeholder="{{trans('dhcd-member::language.placeholder.member.ton_giao')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.ngay_vao_dang') }}</label>
                            <input type="text" name="ngay_vao_dang" class="form-control" id="ngay_vao_dang" placeholder="{{trans('dhcd-member::language.placeholder.member.ngay_vao_dang')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.birthday') }}</label>
                            <input type="text" name="birthday" class="form-control" id="birthday" placeholder="{{trans('dhcd-member::language.placeholder.member.birthday')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('dhcd-member::language.form.title.avatar') }}</label>
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" value="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" name="avatar">
                            <img src="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" id="holder" style="margin-top:15px;max-height:100px;">
                        </div>
                        <div class="form-group">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('dhcd-member::language.buttons.create') }}</button>
                                <a href="{!! route('dhcd.member.member.manage') !!}"
                                   class="btn btn-danger">{{ trans('dhcd-member::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
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
            $('#provine_city').select2({
                theme:"bootstrap",
                placeholder:"select a provine city"
            });
            $('#provine_city').change(function(event) {
                var provine_city_code= $(this).val();
                $.get("{{ route('dhcd.administration.country-district.member') }}" + "?provine_city_code=" + provine_city_code, function(data) { 
                    $("#country_district").html(data);
                }); 
            });
            $('#country_district').select2({
                theme:"bootstrap",
                placeholder:"select a country district"
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
                                max: 100,
                                message: 'Tên phải từ 3 đến 100 kí tự'
                            }
                        }
                    },
                    u_name: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            regexp: {
                                regexp: '^[a-zA-Z0-9_]+$',
                                message: 'Username chỉ gồm số hoặc chữ'
                            },
                            stringLength: {
                                min: 3,
                                max: 100,
                                message: 'Tên đăng nhập phải từ 3 đến 100 kí tự'
                            },
                            remote: {
                                // headers: {
                                //     'X-CSRF-TOKEN': $('input[name=_token]').val()//$('meta[name="csrf-token"]').attr('content')
                                // },
                                data: {
                                    '_token': $('meta[name=csrf-token]').prop('content')
                                },
                                type: 'post',
                                message: 'Tên đăng nhập đã tồn tại',
                                url: '{{route('dhcd.member.member.check-username-exist')}}',
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            regexp: {
                                regexp: "(09|01[2|6|8|9])+([0-9]{8})",
                                message: 'Số điện thoại không đúng định dạng'
                            },
                            remote: {
                                // headers: {
                                //     'X-CSRF-TOKEN': $('input[name=_token]').val()//$('meta[name="csrf-token"]').attr('content')
                                // },
                                data: {
                                    '_token': $('meta[name=csrf-token]').prop('content')
                                },
                                type: 'post',
                                message: 'Số điện thoại đã tồn tại',
                                url: '{{route('dhcd.member.member.check-phone-exist')}}',
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            emailAddress: {
                                message: 'Email không đúng định dạng'
                            },
                            remote: {
                                // headers: {
                                //     'X-CSRF-TOKEN': $('input[name=_token]').val()//$('meta[name="csrf-token"]').attr('content')
                                // },
                                data: {
                                    '_token': $('meta[name=csrf-token]').prop('content')
                                },
                                type: 'post',
                                message: 'Email đã tồn tại',
                                url: '{{route('dhcd.member.member.check-email-exist')}}',
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            regexp: {
                                regexp: "^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[#$^+=!*()@%&]).{8,}$",
                                message: 'Mật khẩu phải chứa 8 ký tự : chứa ít nhất 1 số, 1 chữ viết hoa, 1 chữ viết thường, 1 ký tự đặc biệt'
                            }
                        }
                    },
                    conf_password: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            identical: {
                                field: 'password',
                                message: 'Mật khẩu không khớp nhau'
                            }
                        }
                    }
                }
            });   
        })
    </script>
@stop
