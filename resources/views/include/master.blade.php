<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content />
    <meta name="author" content />
    <meta name="robots" content />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Energy Book Dashboard" />
    <meta property="og:title" content="Energy Book Dashboard" />
    <meta property="og:description" content="Energy Book Dashboard" />
    <meta property="og:image" content="." />
    <meta name="format-detection" content="telephone=no">
    <!-- PAGE TITLE HERE -->
    <title>Energy Book Dashboard </title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <style>
        .ai-icon:hover i {
            color: #fff !important;
        }

        .ai-icon:focus i {
            color: #fff !important;
        }

        .ai-icon i {
            color: #969ba0 !important;
        }
    </style>
    @include('include.head')
    @yield('style')
</head>
<body>
    <div id="main-wrapper">
        <div id="preloader">
            <div class="gooey">
                <span class="dot"></span>
                <div class="dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        @include('include.header')

        @include('include.sidebar')
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        @include('include.footer')
    </div>
</body>
@yield('script')
@include('include.foot')
</html>
