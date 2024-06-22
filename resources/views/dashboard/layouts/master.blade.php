<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">

<head>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title> @yield('title', env('APP_NAME')) </title>

    <!-- CSS -->
    @include('dashboard.layouts.css')
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2&family=Jost:wght@246&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        .app-sidebar .slide.active .side-menu__item {
            background: #53649021;
        }
        .slide.is-expanded .side-menu__item
        {
            background: #53649021;
        }
        .side-menu__label
        {
            font-weight: bold;
        }
    </style>
    @stack('styles')

</head>

{{--<body class="main-body app sidebar-mini {{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}"  style=" font-family: 'Baloo Bhaijaan 2', cursive;font-style: normal;font-weight: 800;" >--}}
<body class="main-body app sidebar-mini {{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}" style="font-family: Alexandria, sans-serif;font-style: normal;font-weight: 200;">

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('dashboard/img/svgicons/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">
        <div>
            <!-- main-header -->
            @include('dashboard.layouts.header')
            <!-- /main-header -->

            <!-- main-sidebar -->
            @include('dashboard.layouts.sidebar')
            <!-- main-sidebar -->
        </div>

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid"  style="padding-top: 30px" >
                <x-alert />

                <!-- breadcrumb -->
                <div class="container-fluid">
                @yield('content')
                </div>
            </div>
            <!-- /Container -->
        </div>
        <!-- /main-content -->


        <!-- Footer opened -->
        <div class="main-footer">
            <div class="container-fluid pd-t-0 ht-100p">
                <span> Copyright © 2024 <a href="javascript:void(0);" class="text-primary"></a>. Designed with
                    <span class="fa fa-heart text-danger"></span> by <a href="javascript:void(0);"> RaiyanSoft</a> All
                    rights reserved.</span>
                {{--                <span>All rights reserved for Fit Raw application, developed by Ryan Soft Company © 2023</span>--}}


            </div>
        </div>
        <!-- Footer closed -->

    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

    @include('dashboard.layouts.js')

</body>

</html>
