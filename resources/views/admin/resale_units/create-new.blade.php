@extends('admin.new_admin_layout.resale')




@section('content')
    <div id='app3'>
        <Create></Create>
    </div>
@endsection


<script>
        window.auth_user = {!! json_encode([
            'name'     => auth()->user()->name,
            'id'     => auth()->user()->id,
            'type'     => auth()->user()->type,
            'userHr'     => auth()->user()->hr,
            'csrf'   => csrf_token(),
            'locale'     => app()->getLocale(),
            'token'     => auth()->user()->agentToken->token,
        ]) !!};
</script>
