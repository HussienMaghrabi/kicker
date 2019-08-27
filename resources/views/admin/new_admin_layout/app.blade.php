<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Head -->
    @include('admin.new_admin_layout.head')
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
          OneSignal.init({
              appId: "{{config('onesignal.app_id')}}",
          });
            OneSignal.getUserId(function(userId) {
                  if(userId){
                var id = userId;
                var _token = '{{ csrf_token() }}';
                 $(".logoutUrl").attr('href',"{{ url(adminPath().'/logout?player_id=') }}"+userId);
                $.ajax({
                    url: "{{ url(adminPath().'/push_player')}}",
                    type: 'post',
                    dataType: 'html',
                    data: {id: id, _token: _token},
                    success: function (data) {
                       console.log("OneSignal User ID:", userId);
                    }
                });
              }
          	});
		});
		</script>
        <!-- Document title -->
        <title> @if(!empty($title)) {{ trans('admin.website_title') . ' | ' . $title }} @else {{ trans('admin.website_title') }} @endif - Leads </title>
</head>

<body class="has-navbar-fixed-top">

    <div id="app3"></div>

    <!-- Scripts -->
    @include('admin.new_admin_layout.scripts')

</body>
</html>
