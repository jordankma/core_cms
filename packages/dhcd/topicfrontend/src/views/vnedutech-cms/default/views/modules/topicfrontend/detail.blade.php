@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-topicfrontend::language.titles.detail') }}@stop

{{-- page styles --}}
@section('header_styles')
@stop
<!--end of page css-->
<style type="text/css">
</style>

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>CHI TIẾT THẢO LUẬN</h1>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <p style="color: red;font-size: 25px;">Tính năng đang được phát triển</p>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
