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
                                    <b-button type="is-info">ATTENDANCE Now <span class="fa fa-clock"></span></b-button>
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
    getAllEmployees,
} from './../../calls'

export default {
    data() {
        return {
            employee_id:window.auth_user.emploee_id,
            isFullPage:true,
            isLoading:true,
            Employees:[],
        }
    },
    mounted(){
        console.log('Emp Id',this.employee_id)
        this.AllEmployees()
        // this.getUserLocations()
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            pos = new google.maps.LatLng(position.coords.latitude,
            position.coords.longitude);

            map.setCenter(pos);
        }, function () {
            handleNoGeolocation(true);
        });
    } else {
        // Browser doesn't support Geolocation
        handleNoGeolocation(false);
    }

    function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
            var content = 'Error: The Geolocation service failed.';
        } else {
            var content = 'Error: Your browser doesn\'t support geolocation.';
        }

        var options = {
            map: map,
            position: new google.maps.LatLng(-29.3456, 151.4346),
            content: content
        };
        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
    }

    var marker = new google.maps.Marker({
        position: pos,
        title: 'Position',
        map: map,
        draggable: true,
        visible: true
    });

    updateMarkerPosition(pos);
    geocodePosition(pos);
    google.maps.event.addListener(marker, 'drag', function () {

        updateMarkerPosition(marker.getPosition());
    });
    $('#button').click(function () {
        marker.setVisible(true);
    });
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
        getUserLocations(){
        }
    }
}
</script>
