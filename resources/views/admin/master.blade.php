<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
    <!-- Head -->
    @include('admin.new_admin_layout.head')
    <!-- Document title -->
    <title> Main </title>
</head>

<body class="has-navbar-fixed-top">

    <div id="app3">
        <App></App>
    </div>

    <script>
            window.auth_user = {!! json_encode([
                'id'     => auth()->user()->id,
                'name'     => auth()->user()->name,
                // 'role'     => json_decode( @\App\Role::find(auth()->user()->role_id)->roles )->switch_leads,
                // 'role' => auth()->user()->role->name,
                // 'numOfCil'     => @\App\Cil::where('status', 'not_sent')->count(),
                //'numOfCil'     => @\App\Cil::where('seen', '0')->count(),
                //'token'     => auth()->user()->agentToken->token,
                'locale'     => app()->getLocale(),
                // 'numOfNotifications'     => @\App\AdminNotification::where('assigned_to',auth()->user()->id)->where('status',0)->count(),
                //'profileUrl'     => url(adminPath().'/employees/'. \App\Employee::where('id', Auth()->user()->employee_id)->first()->id),
                'emploee_id'      =>  @\App\Employee::where('user_id',Auth::user()->id)->first()->id,
                //'agentType'     => @App\AgentType::find(auth()->user()->agent_type_id)->name,
                //'image'     => auth()->user()->image,
                'defaultImage'     => url('../../dist/img/lead.png'),
                //'type'     => auth()->user()->type,
                //'userHr'     => auth()->user()->hr,
                'csrf'   => csrf_token()
            ]) !!};
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
