<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
    <script>
    //paste this code under the head tag or in a separate js file.
      // Wait for window load
      $(window).load(function() {
        // Animate loader off screen
        document.getElementById("loadd").style.display = "none";
        
      });
    </script>
    <!-- Head -->
    @include('admin.new_admin_layout.head')
    <!-- Document title -->
    <title> @if(!empty($title)) {{ trans('admin.website_title') . ' | ' . $title }} @else {{ trans('admin.website_title') }} @endif </title>
    
</head>
<style>
   #loading{
  margin-left: 35%;
  margin-top: 10%;
}
.overlaySec{
  background-color: #fff;
  height: 100%;
  width: 100%;
  z-index: 99999;
  position: fixed;
  top: 0;
} 

.lds-ring {
  margin-left: 40%;
  margin-top: 20%;
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 210px;
  height: 210px;
  margin: 6px;
  border: 20px solid red;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #cc0000 transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>
<body class="has-navbar-fixed-top">

        <section class="overlaySec" id="loadd" :is-full-page="true">
                {{-- <img src="/images/loading.gif" placeholder="loooooading" id="loading"/> --}}   
                  <div class="lds-ring" id="loadd"><div></div><div></div><div></div><div></div></div>
        </section>

       <div id="app3"></div>


      <script src="{{ asset('js/dashboard.js') }}"></script>
       
</body>
</html>
