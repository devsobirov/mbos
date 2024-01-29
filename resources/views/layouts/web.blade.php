<!DOCTYPE html>
<html class="no-js" lang="{{app()->getLocale()}}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">

    <title>@yield('meta_title', $settings->meta_title)</title>
    <meta name="description" content="@yield('meta_description', $settings->meta_description)">
    <meta name="keywords" content="@yield('meta_keywords', $settings->meta_keywords)">
    <link rel="shortcut icon" href="{{asset($settings->favicon ?? 'favicon.ico')}}">

    <script src="{{asset('assets/classes/js/jquery.js')}}"></script>
    <script src="{{asset('assets/classes/js/jqueryui.js')}}" defer></script>

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/theme-plugins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <style>
        .header ul.single-widget li {
            position: relative;
            margin-right: 5px;
        }
        .header ul.single-widget li a {
            /*color: #fff;*/
            text-transform: uppercase;
            font-size: 14px;
            padding: 12px 15px;
            position: relative;
            font-weight: 500;
            display: block;
        }
        @media (min-width: 768px) {
            ul.single-widget > li > a {
                padding-top: 15px;
                padding-bottom: 15px;
            }

            ul.single-widget > li > a {
                padding-top: 10px;
                padding-bottom: 10px;
                line-height: 20px;
            }

            ul.single-widget > li > a {
                position: relative;
                display: block;
                padding: 10px 15px;
            }
        }

        .header ul.single-widget .drop-down {
            position: absolute;
            left: 0;
            z-index: 8;
            width: 200px;
            top: 100%;
            opacity: 0;
            background: #fff;
            visibility: hidden;
            border-top: 3px solid;
            opacity: 0;
            -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            transition: all 0.4s ease;
            z-index: 999;
            -webkit-box-shadow: 0 7px 9px rgba(0,0,0,0.40);
            -moz-box-shadow: 0 7px 9px rgba(0,0,0,0.40);
            box-shadow: 0 7px 9px rgba(0,0,0,0.40);
            padding: 5px 0;
            border-color: #ED1C24;
        }

        .header ul.single-widget .drop-down li a {
            color: #353535;
            text-align: left;
            border-radius: 0;
            background: transparent;
            text-transform: none;
            padding: 10px 15px;
            font-weight: 400;
        }

        .header ul.single-widget li a {
            /*color: #fff;*/
            text-transform: uppercase;
            font-size: 14px;
            padding: 12px 15px;
            position: relative;
            font-weight: 500;
            display: block;
        }

        .header ul.single-widget li:hover .drop-down {opacity: 1;visibility: visible;}
        .header ul.single-widget li:hover .drop-down .sub-menu{opacity:1;left:100%;visibility:visible}

        .header ul.single-widget li a i {
            display: inline-block;
            vertical-align: sub;
            width: 8px;
            height: 8px;
            position: static;
            margin-left: 12px;
            -webkit-transform: translateX(-100%);
            -moz-transform: translateX(-100%);
            transform: translateX(-100%);
            -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        .slicknav_menu .slicknav_icon-bar {
            box-shadow: 0 2px 0 rgba(0,0,0,.75);
        }
    </style>

    {!! $settings->google_metrics !!}
    {!! $settings->yandex_metrics !!}
</head>

<body id="bg">

<div id="layout">

    <header id="header" class="header">
        <div class="container">
            @include('layouts.includes.top-header')
        </div>
        <div class="header-inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        @include('layouts.includes.navigation')
                    </div>
                </div>
            </div>
        </div>
    </header>


    @yield('content')


    @include('layouts.includes.call-to-action')
    @include('layouts.includes.footer')
    <!--noindex-->

    <!--/noindex-->
    <script src="{{asset('assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/js.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/theme-plugins.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/main.js')}}" type="text/javascript"></script>

    <script>
        if (("{{session('callback')}}")) {
            $('#callbackModal').modal('show');
        }
    </script>
</div>
</body>
</html>
