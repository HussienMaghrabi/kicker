<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Head -->
    @include('admin.new_admin_layout.head')
        <!-- Document title --> 
        <title> @if(!empty($title)) {{ trans('admin.website_title') . ' | ' . $title }} @else {{ trans('admin.website_title') }} @endif - Leads </title>
</head>

<body class="has-navbar-fixed-top">

    <div id="app5"></div>

	    <!-- Scripts -->
	    <script src="{{ asset('js/setting.js') }}"></script>
    
</body>
</html>
