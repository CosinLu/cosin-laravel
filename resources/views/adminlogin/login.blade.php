<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Cosin-登录页面</title>
    <meta name="keywords" content="Cosin"/>
    <meta name="description" content="Cosin"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- basic styles -->

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}"/>

    <!--[if IE 7]>
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome-ie7.min.css')}}"/>
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <!-- ace styles -->

    <link rel="stylesheet" href="{{asset('assets/css/ace.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/ace-rtl.min.css')}}"/>

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="{{asset('assets/css/ace-ie.min.css')}}"/>
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="{{asset('assets/js/html5shiv.js')}}"></script>
    <script src="{{asset('assets/js/respond.min.js')}}"></script>
    <![endif]-->
</head>

<body class="login-layout">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <i class="icon-leaf green"></i>
                            <span class="red">Cosin</span>
                            <span class="white">Application</span>
                        </h1>
                        <h4 class="blue">&copy; By Cosin</h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="icon-coffee green"></i>
                                        Please Enter Your Information
                                    </h4>

                                    <div class="space-6"></div>

                                    <form method="post">
                                        {{csrf_field()}}
                                        <fieldset>
                                            <div class="form-group has-error">

                                                <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" name="User[username]" class="form-control"
                                                           placeholder="Username" value="{{old('User')['username']}}"/>
                                                    <i class="icon-user"></i>
                                                </span>
                                                </label>
                                                <div class="help-block col-xs-12 col-sm-reset inline">{{$errors -> first('User.username')}}</div>
                                            </div>
                                            <div class="form-group has-error">
                                                <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" name="User[password]" class="form-control" placeholder="Password" value="{{old('User')['password']}}"/>
                                                    <i class="icon-lock"></i>
                                                </span>
                                                </label>
                                                <div class="help-block col-xs-12 col-sm-reset inline hide">{{$errors -> first('User.password')}}</div>
                                            </div>
                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <label class="inline">
                                                    <span class="lbl">
                                                        @if (Session::has('error'))
                                                            {{Session::get('error')}}
                                                        @endif
                                                    </span>
                                                </label>
                                                <button type="submit"
                                                        class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="icon-key"></i>
                                                    Login
                                                </button>
                                            </div>
                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>
                                </div><!-- /widget-main -->
                            </div><!-- /widget-body -->
                        </div><!-- /login-box -->
                    </div><!-- /position-relative -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src={{asset('assets/js/jquery-2.0.3.min.js')}}>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src={{asset('assets/js/jquery-1.10.2.min.js')}}>" + "<" + "/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if ("ontouchend" in document) document.write("<script src={{asset('assets/js/jquery.mobile.custom.min.js')}}>" + "<" + "/script>");
</script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
    function show_box(id) {
        jQuery('.widget-box.visible').removeClass('visible');
        jQuery('#' + id).addClass('visible');
    }
</script>
</body>
</html>
