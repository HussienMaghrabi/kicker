<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            EMPLOYEE ATTENDANCE
                        </p>
                    </div>
                </div>
                <div class="level-right" style="padding:.5vw">
                    <!-- <b-button type="is-info" @click="AddNewRequest">Add New</b-button> -->
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-12">
                                <label class="label">Employee</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="employee_id">
                                            <option v-for="employee in Employees" :key="employee.id" :value="employee.id">{{employee.en_first_name+' '+employee.en_middle_name+' '+employee.en_last_name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="column is-12">
                                <div class="text-center">
                                    <b-button @click="SaveNewAttend" type="is-info">ATTENDANCE Now <span class="fa fa-clock"></span></b-button>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column is-12">
                                    <gmap-map :center="center" :zoom="zoom" style="width:100%;  height: 400px;">
                                    <gmap-marker
                                        :key="index"
                                        v-for="(m, index) in markers"
                                        :position="m.position"
                                        :draggable="true"
                                    ></gmap-marker>
                                    </gmap-map>
                                </div>
                            </div>
                        </div>
                </section>
                <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>
            </div>
        </div>
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
            },
            long:null,
            lat:null,
            zoom:14,
            markers: [{ position: { lat: 30.0595581, lng: 32.0595581 } }],
        }
    },
    created(){
        this.checkOnGetLocation()
    },
    mounted(){
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
        checkOnGetLocation(){
            if (this.lat || this.long == null) {
                this.isLoading = true
                this.isFullPage = true
            }
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
        this.long = vm.position.latitude
        this.lat = vm.position.longitude
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
