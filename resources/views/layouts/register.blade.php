<!DOCTYPE html>

<html>

  <head>

    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    <meta charset="utf-8" />

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />

    <link rel="apple-touch-icon" href="{{ asset('pages/ico/60.png') }}">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('pages/ico/76.png') }}">

    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('pages/ico/120.png') }}">

    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('pages/ico/152.png') }}">

    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="apple-touch-fullscreen" content="yes">

    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="" name="description" />

    <meta content="" name="author" />

    <link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/boostrapv3/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" rel="stylesheet" type="text/css" media="screen" />

    <link href="{{ asset('assets/plugins/bootstrap-select2/select2.css') }}" rel="stylesheet" type="text/css" media="screen" />

    <link href="{{ asset('assets/plugins/switchery/css/switchery.min.css') }}" rel="stylesheet" type="text/css" media="screen" />

    <link href="{{ asset('pages/css/pages-icons.css') }}" rel="stylesheet" type="text/css">

    <link class="main-stylesheet" href="{{ asset('pages/css/pages.css') }}" rel="stylesheet" type="text/css" />

    <!--[if lte IE 9]>

        <link href="{{ asset('pages/css/ie9.css') }}" rel="stylesheet" type="text/css" />

    <![endif]-->

    <script type="text/javascript">

    window.onload = function()

    {

      // fix for windows 8

      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)

        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="{{ asset("pages/css/windows.chrome.fix.css") }}" />'

    }

    </script>

  </head>

  <body class="fixed-header ">

    <div class="register-container full-height sm-p-t-30">

      <div class="container-sm-height full-height">

        @yield('content')

      </div>

    </div>

    <!-- BEGIN VENDOR JS -->

    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/jquery/jquery-1.11.1.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/modernizr.custom.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/boostrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/jquery/jquery-easy.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/jquery-unveil/jquery.unveil.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/jquery-bez/jquery.bez.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/jquery-ios-list/jquery.ioslist.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/jquery-actual/jquery.actual.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap-select2/select2.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/classie/classie.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/switchery/js/switchery.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>

    <!-- END VENDOR JS -->

    <script src="{{ asset('pages/js/pages.min.js') }}"></script>

    <script>

    $(function()

    {

      $('#form-register').validate();

      $('#form-password').validate();

    })

    </script>

  </body>

</html>