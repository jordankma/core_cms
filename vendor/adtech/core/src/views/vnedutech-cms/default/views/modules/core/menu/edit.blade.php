@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('adtech-core::titles.menu.update') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <!--end of page css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                                         data-color="#000"></i>
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
                {!! Form::model($menu, ['url' => route('adtech.core.menu.update'), 'method' => 'put', 'class' => 'bf', 'files'=> true]) !!}
                <div class="row">
                    <div class="col-sm-8">

                        <label>Parent</label>
                        <div class="form-group {{ $errors->first('parent', 'has-error') }}">
                            <select class="form-control select2" title="Select parent..." name="parent"
                                    id="parent">
                                <option value="0">Root menu</option>
                                @foreach($menus as $menuItem)
                                    <option value="{{ $menuItem->menu_id }}" {{ ($menuItem->menu_id == $menu->parent) ? ' selected="selected"' : '' }}>{{ str_repeat('---', $menuItem->level) . $menuItem->name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('parent', ':message') }}</span>
                        </div>

                        <label>Route Name</label>
                        <div class="form-group {{ $errors->first('route_name', 'has-error') }}">
                            <select class="form-control select2" title="Select route name..." name="route_name"
                                    id="parent">
                                <option value="#" {{ $menu->route_name == '#' ? ' selected="selected"' : '' }}>No Link</option>
                                @foreach($listRouteName as $routeName)
                                    <option value="{{ $routeName }}" {{ ($routeName == $menu->route_name) ? ' selected="selected"' : '' }}>{{ $routeName }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('route_name', ':message') }}</span>
                        </div>

                        <label>Group Name</label>
                        <div class="form-group input-group {{ $errors->first('group', 'has-error') }}">
                            {!! Form::text('group', null, array('class' => 'form-control', 'id' => 'group_name_txt', 'disabled' => true, 'placeholder'=> trans('adtech-core::common.menu.group_name_here'))) !!}
                            <select class="form-control" title="Select group name..." name="group" id="group_name_select" disabled="true" style="display: none">
                                @if (count($menusGroups) == 0)
                                    <option value="Hệ thống">Hệ thống</option>
                                @endif

                                @foreach($menusGroups as $groupName)
                                    <option value="{{ $groupName->group }}" {{ ($groupName->group == $menu->group) ? 'selected' : '' }}>{{ $groupName->group }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="changeGroupType()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </span>
                        </div>

                        <label>Menu Name</label>
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus', 'placeholder'=>trans('adtech-core::common.menu.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>

                        <label>Sort</label>
                        <div class="form-group {{ $errors->first('sort', 'has-error') }}">
                            {!! Form::number('sort', null, array('min' => 0, 'max' => 99,'class' => 'form-control', 'placeholder'=> trans('adtech-core::common.menu.sort_here'))) !!}
                            <span class="help-block">{{ $errors->first('sort', ':message') }}</span>
                        </div>

                        <label>Icon</label>
                        <div class="form-group {{ $errors->first('icon', 'has-error') }}">
                            {!! Form::text('icon', null, array('class' => 'form-control', 'placeholder'=>trans('adtech-core::common.menu.icon_here'))) !!}
                            <span class="help-block">{{ $errors->first('icon', ':message') }}</span>
                        </div>

                        <div class="form-group">
                            {!! Form::hidden('menu_id') !!}
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <label for="blog_category" class="">Actions</label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('adtech.core.menu.create') !!}"
                               class="btn btn-danger">{{ trans('adtech-core::buttons.discard') }}</a>
                        </div>
                    </div>
                    <!-- /.col-sm-4 --> </div>
                <!-- /.row -->
                {!! Form::close() !!}
            </div>
            @if ( $errors->any() )
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/pages/add_menu.js') }}" type="text/javascript"></script>
    <script>
        $(function () {
            $(".select2").select2({
                theme:"bootstrap"
            });
            $("[name='permission_locked'], [name='status']").bootstrapSwitch();
        });

        var checkGroup = 0;
        function changeGroupType() {
            if (checkGroup % 2 == 0) {
                $("#group_name_txt").css('display', 'block');
                $('#group_name_txt').prop('disabled', false);
                $('#group_name_select').prop('disabled', true);
                $("#group_name_select").css('display', 'none');
            } else {
                $("#group_name_txt").css('display', 'none');
                $('#group_name_txt').prop('disabled', true);
                $('#group_name_select').prop('disabled', false);
                $("#group_name_select").css('display', 'block');
            }
            checkGroup++;
        }
    </script>
@stop
