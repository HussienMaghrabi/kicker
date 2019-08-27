<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Head -->
    @include('admin.new_admin_layout.head')
        <!-- Document title --> 
        <title> @if(!empty($title)) {{ trans('admin.website_title') . ' | ' . $title }} @else {{ trans('admin.website_title') }} @endif - Units </title>
</head>

<body class="has-navbar-fixed-top">

    <div id="app3"></div>

    <!-- Scripts -->
    <script src="{{ asset('js/resale.js') }}"></script>
</body>
</html>
