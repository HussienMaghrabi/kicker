<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Head -->
    @include('admin.new_admin_layout.head')
    <!-- Document title --> 
    <title> Units </title>
</head>

<body class="has-navbar-fixed-top">

    <div id="app3">
    	<Archive></Archive>
    </div>

	<!-- Scripts -->
	<script src="{{ asset('js/unit.js') }}"></script>
    
</body>
</html>
