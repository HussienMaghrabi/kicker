@extends('website.index')
@section('content')
<style>
    // Body background

body{
  background: url(http://static.pexels.com/wp-content/uploads/2014/07/darkness-dawn-dusk-2073.jpg) no-repeat;
  background-size: 1920px 1000px;
}

// Show Button

.show{
  position: absolute;
  top: 50%;
  left: 50%;
  width: 150px;
  height: 40px;
  margin-top: -20px;
  margin-left: -75px;
  background: #e74c3c;
  color: #fff;
  border-radius: 5px;
  border: 0;
  border-bottom: 2px solid #c0392b;
  cursor: pointer;
  
  &:hover{
    background: #c0392b;
  }
  
  &:active{
    transform: scale(0.9);
  }
}

// Close Button

.close{
  position: absolute;
  top: 0;
  right: 0;
  width: 35px;
  height: 30px;
  background: #000;
  color: #fff;
  cursor: pointer;
  border: 0;
}

// The mask

.mask{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(52, 73, 94, 0.8);
  z-index: 50;
  visibility: hidden;
  
  opacity: 0;
  
  transition: 0.7s;
}

// Modal

.modal{
  position: fixed;
  top: 50%;
  left: 50%;
  width: 400px;
  height: 300px;
  margin-left: -200px;
  margin-top: -150px;
  background: #bdc3c7;
  z-index: 100;
  visibility: hidden;
  
  opacity: 0;
  
  transition: 0.5s ease-out;
  
  transform: translateY(45px);
}

// Class Active

.active{
  visibility: visible;
  opacity: 1;
}

// When active class is added, that affects the modal class

.active + .modal{
  visibility: visible;
  opacity: 1;
  transform: translateY(0);
}
</style>

<button class="show" aria-haspopup="true">Show Modal</button>

<div class="mask" role="dialog"></div>
<div class="modal" role="alert">
  <button class="close" role="button">X</button>
</div>
@endsection
<script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
</script>
<script>
    $(".show").on("click", function(){
    $(".mask").addClass("active");
    });

    // Function for close the Modal

    function closeModal(){
    $(".mask").removeClass("active");
    }

    // Call the closeModal function on the clicks/keyboard

    $(".close, .mask").on("click", function(){
    closeModal();
    });

    $(document).keyup(function(e) {
    if (e.keyCode == 27) {
        closeModal();
    }
    });
</script>