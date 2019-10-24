<template>
    <div class="container">
  <video  id="player" ref="videoPlayer" autoplay></video>
  <canvas ref="canvasElement" id="canvas" ></canvas>
  <button @click="captureImage" id="capture-button">Capture</button>
  <div ref="imagePickerArea" id="pick-image">
    <input type="file" ref="imagePicker" accept="image/*" id="image-picker">
  </div>
  <form action="">
    <input type="text" placeholder="name">
    
    <input v-model="position.latitude" type="text" placeholder="location">
    <input v-model="position.longitude" type="text" placeholder="location">
    <button id="get-location">Get location</button>
  </form>
    </div>
</template>
<script>
import {
    getAllEmployees,saveEmployeeAttendance
} from './../../calls'

export default {
    data() {
        return {
            employee_id:window.auth_user.emploee_id,
            isFullPage:true,
            isLoading:true,
            currentDate: new Date(),
            Employees:[],
            position:{
                latitude: null,
                longitude: null
            }
        }
    },
    mounted(){
        console.log('lat',this.position.latitude)
        console.log('long',this.position.latitude)
        console.log('Emp Id',this.employee_id)
        this.AllEmployees()
        // this.getUserLocations()
            var vm = this
        if (!('mediaDevices' in navigator)) {
        navigator.mediaDevices = {};
        }
        if (!('getUserMedia' in navigator.mediaDevices)) {
        navigator.mediaDevices.getUserMedia = function(constraints) {
            var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
            
            if (!getUserMedia) {
            return Promise.reject(new Error('getUserMedia is not implemented!'));
            }
            
            return new Promise(function(resolve, reject) {
            getUserMedia.call(navigator, constraints, resolve, reject);
            });
        }
        }
        navigator.mediaDevices.getUserMedia({video: true})
        .then(function(stream) {
        vm.$refs.videoPlayer.srcObject = stream;
        vm.$refs.canvasElement.style.display = 'none';
        })
        .catch(function(err) {
        vm.$refs.imagePickerArea.style.display = 'block';
        });
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(vm.showPosition);
        }
    },
    methods:{
        AllEmployees(){
            this.isLoading = true
            getAllEmployees().then(response=>{
            this.isLoading = false
                this.Employees = response.data
            }).catch(error=>{
                console.log(error)
            })
        },
        SaveNewAttend(){
            var data = {
                'date':this.currentDate,
                'employee_id':this.employee_id
            }
            saveEmployeeAttendance(data).then(response=>{
            }).catch(error=>{
                console.log(error)
            })
        },
        showPosition(position){
        var vm = this
        vm.position.latitude = position.coords.latitude
        vm.position.longitude = position.coords.longitude
        },
        captureImage(){
        var vm = this
        
        vm.$refs.canvasElement.style.display = 'block';
        vm.$refs.videoPlayer.style.display = 'none';
        //vm.$refs.captureButton.style.display = 'none';
        var context = vm.$refs.canvasElement.getContext('2d');
        context.drawImage(vm.$refs.videoPlayer, 0, 0, canvas.width, vm.$refs.videoPlayer.videoHeight / (vm.$refs.videoPlayer.videoWidth / canvas.width)); 
        vm.$refs.videoPlayer.srcObject.getVideoTracks().forEach(function(track) {
            track.stop();
        
        });
        var dataURL =  vm.$refs.canvasElement.toDataURL('image/png', 0.01); 
        var x = 1, 
            scriptUrl ='https://script.google.com/macros/s/AKfycbwOE5-SVKnH30rSblg5Y5zypMFuwGKmsa62-3vgD08paJf8aPgf/exec'
        var url = scriptUrl+"?callback=ctrlq"+"&id=" + 1 + "&image=" + dataURL + "&action=insert";

        jQuery.ajax({
            crossDomain: true,
            url: url ,
            method: "GET",
            dataType: "jsonp",
            success: function (response) {  
            alert(response)
            },
            error(){
            alert('error')
            }
        });
        },
        getUserLocations(){
        }
    }
}
</script>
