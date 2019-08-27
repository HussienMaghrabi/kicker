<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Head -->
    @include('admin.new_admin_layout.head')
    <!-- Document title -->
    <title> Show Deals </title>
</head>

<body class="has-navbar-fixed-top">

    <div id="app3">
    	<DealsShow></DealsShow>
    </div>

    <script>
            window.auth_user = {!! json_encode([
                'id'     => auth()->user()->id,
                'name'     => auth()->user()->name,
                'role'     => json_decode( @\App\Role::find(auth()->user()->role_id)->roles )->switch_leads,
                'numOfCil'     => @\App\Cil::where('status', 'not_sent')->count(),
                'token'     => auth()->user()->agentToken->token,
                'locale'     => app()->getLocale(),
                'numOfNotifications'     => @\App\AdminNotification::where('assigned_to',auth()->user()->id)->where('status',0)->count(),
                'profileUrl'     => url(adminPath().'/employees/'. \App\Employee::where('id', Auth()->user()->employee_id)->first()->id),
                'agentType'     => @App\AgentType::find(auth()->user()->agent_type_id)->name,
                'image'     => auth()->user()->image,
                'defaultImage'     => url('../../dist/img/lead.png'),
                'type'     => auth()->user()->type,
                'userHr'     => auth()->user()->hr,
                'csrf'   => csrf_token()
            ]) !!};
            window.deal = {!! json_encode($deal) !!};
    </script>
    <script src="{{ asset('js/showDeals.js') }}"></script>
</body>
</html>
