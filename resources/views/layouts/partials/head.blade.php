<head>

    <meta charset="utf-8" />
    <title>{{$title ?? ''}} | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="DATABASE IMAJIWA" name="description" />
    <meta content="IMAJIWA" name="author" />
    <meta name="csrf_token" value="{{ csrf_token() }}"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/logo-imajiwa.png') }}">

    @stack('styles')

    <!-- Bootstrap Css -->
    <link href="{{asset('css/bootstrap.min.css' ) }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('css/icons.min.css' ) }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('css/app.min.css' ) }}" id="app-style" rel="stylesheet" type="text/css" />

    @livewireStyles
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link id="theme-css" rel="stylesheet" href="">
    <script>
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf_token"]').getAttribute('value')
        };
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
