<!DOCTYPE html>
<html>
<head>
    {{--<meta charset="utf-8">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot_password | Welcome to Josh Frontend</title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/bootstrap.min.css') }}">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <link rel="shortcut icon" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/favicon.png') }}" type="image/x-icon">
    <!--end of global css-->
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/frontend/forgot.css') }}">
    <!--end of page level css-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="box animation flipInX">
            <img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/josh-new.png') }}" alt="logo" class="img-responsive mar">
            <h3 class="text-primary">Forgot Password</h3>
            <p>Enter your email to reset your password</p>
            <div id="notific">
            @include('includes.notifications')
            </div>
            <form action="{{ route('adtech.core.auth.forgot') }}" class="omb_loginForm" autocomplete="off" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label class="sr-only"></label>
                    <input type="email" class="form-control email" name="email" placeholder="Email"
                           value="{!! old('email') !!}">
                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                </div>
                <div class="form-group">
                    <input class="form-control btn btn-primary btn-block" type="submit" value="Reset Your Password">
                </div>
            </form>

            Back to login page?<a href="{{ route('adtech.core.auth.login') }}"> Click here</a>
        </div>
    </div>
</div>
<!--global js starts-->
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/jquery.min.js') }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/frontend/forgotpwd_custom.js') }}"></script>
<!--global js end-->
</body>
</html>
