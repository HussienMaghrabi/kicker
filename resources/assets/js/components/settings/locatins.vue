<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Locations
                        </p>
                    </div>
                </div>
                <div class="level-right">
                  <!-- <router-link :to="'/admin/vue/AddGroups'">
                      <b-button type="is-info">Add New</b-button>
                  </router-link> -->
                </div>
            </header>
            <div class="columns">
                <div class="column is-6">
                    <div class="card-content">
                        <b-menu>
                            <b-menu-list label="Menu">
                                <b-menu-item v-for="p in perants" :key="p.id" icon="map-marker" expanded>
                                    <template slot="label" slot-scope="props">
                                        {{ p.en_name }}
                                        <b-icon class="is-pulled-right" :icon="props.expanded ? 'menu-down' : 'menu-up'"></b-icon>
                                    </template>
                                        <b-menu-item v-for="c in children" v-if="c.parent_id == p.id" :key="c.id" icon="map-marker" :label="c.en_name" @click="previewLocation(c.id)">
                                        <template slot="label" slot-scope="props">
                                            {{ c.en_name }}
                                            <b-icon class="is-pulled-right" :icon="props.expanded ? 'menu-down' : 'menu-up'"></b-icon>
                                        </template>
                                            <b-menu-item v-for="d in children" v-if="d.parent_id == c.id" :key="d.id" icon="map-marker" :label="d.en_name" @click="previewLocation(d.id)">
                                            </b-menu-item>
                                        </b-menu-item>
                                </b-menu-item>
                            </b-menu-list>
                        </b-menu>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Locations
                            </div>
                        </div>
                        <div class="card-body padding">
                            <b-field label="Expanded">
                                <b-select v-model="singleLocation.parent_id" placeholder="Select perant" expanded>
                                    <option v-for="location in Locations" :key="location.id" :value="location.id">{{ location.en_name }}</option>
                                </b-select>
                            </b-field>
                            <b-field label="English Name">
                                <b-input v-model="singleLocation.en_name"></b-input>
                            </b-field>
                            <b-field label="Arabic name">
                                <b-input v-model="singleLocation.ar_name"></b-input>
                            </b-field>
                            <div class="columns text-center">
                                <div class="column is-4">
                                    <i style="color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-plus" @click="Addlocation"></i>
                                </div>
                                <div class="column is-4">
                                    <i style="color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-edit" @click="editlocation"></i>
                                </div>
                                <div class="column is-4">
                                    <i style="color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-trash" @click="locationdelete"></i>
                                </div>
                            </div>
                            <!-- google map -->
                            <div class="column is-12">
                                <div>
                                <h4>Search and add a pin</h4>
                                <label>
                                    <gmap-autocomplete @place_changed="setPlace"></gmap-autocomplete>
                                    <button @click="addMarker">Add</button>
                                </label>
                                <br>
                                </div>
                                <br>
                                <gmap-map :center="center" zoom="7" style="width:100%;  height: 400px;">
                                <gmap-marker
                                    :key="index"
                                    v-for="(m, index) in markers"
                                    :position="m.position"
                                    :draggable="true"
                                    @drag="updateCoordinates"
                                    @click="center=m.position"
                                ></gmap-marker>
                                </gmap-map>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>

<script>
import {
    getlocations,
    getlocationdetils,
    addnewlocation
} from './../../calls'
export default {
    data() {
            return {
                perants:[],
                children:[],
                location:[],
                Locations:[],
                singleLocation:[],
                center: { lat: 30.0595581, lng: 32.0595581 },
                zoom: 9,
                markers: [{ position: { lat: 30.0595581, lng: 32.0595581 } }],
                isFullPage:false,
                isLoading:false,
            }
        },
        components:{
        },
        created() {
        },
        mounted(){
            this.getAllLocations()
        },
        methods: {
            getAllLocations(){
                getlocations().then(response=>{
                    // console.log('location response',response)
                    this.perants = response.data.perants
                    this.children = response.data.children
                    this.Locations = response.data.alllocations
                    this.markers[0].position.lng = 31.83830274853517
                    this.markers[0].position.lat = 26.820553


                    this.center.lng = 31.83830274853517
                    this.center.lat = 26.820553
                    this.zoom = 9
                    this.isLoading = false
                }).catch(error => {
                console.log(error)
            })
            },
            addMarker() {
            console.log('adddd',this.markers[0])
            // console.log(this.currentPlace)
            if (this.currentPlace) {
                const marker = {
                lat: this.currentPlace.geometry.location.lat(),
                lng: this.currentPlace.geometry.location.lng()
                };
                this.markers[0].position =  marker ;
                this.places = this.currentPlace;
                this.center = marker;
                this.currentPlace = null;
                console.log('markers',this.markers[0].position.lat)
            }
            },
            setPlace(place) {
                this.currentPlace = place;
            },
            updateCoordinates(location) {
                const marker = {
                lat: location.latLng.lat(),
                lng: location.latLng.lng(),
                };
                this.markers[0].position =  marker ;
                // this.center = marker;
                console.log('markers',this.markers[0].position.lat)
            },
            previewLocation($id){
                this.isLoading = true
                getlocationdetils($id).then(response=>{
                    console.log('single location',response)
                    this.singleLocation = response.data
                    this.isLoading = false
                    this.markers[0].position.lat = response.data.lat
                    this.markers[0].position.lng = response.data.lng
                    console.log('lng',this.markers[0].position.lng)
                    console.log('lat',this.markers[0].position.lat)
                    this.center.lat = response.data.lat
                    this.center.lng = response.data.lng
                    // console.log('try int',this.lat)
                    this.zoom = 12
                }).catch(error => {
                    console.log(error)
                })
            },
            Addlocation(){
                this.isLoading = true
                const bodyFormData = new FormData();
                for (let key in this.singleLocation) {
                    const value = this.singleLocation[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('store','add')
                bodyFormData.append('lat',this.markers[0].position.lat)
                bodyFormData.append('lng',this.markers[0].position.lng)
                bodyFormData.append('zoom',this.zoom)
                addnewlocation(bodyFormData).then(response=>{
                this.isLoading = false
                this.getAllLocations()
                this.draggable()
                }).catch(error => {
                    console.log(error)
                })
            },
            editlocation(){
                this.isLoading = true
                const bodyFormData = new FormData();
                for (let key in this.singleLocation) {
                    const value = this.singleLocation[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('store','edit')
                bodyFormData.append('lat',this.markers[0].position.lat)
                bodyFormData.append('lng',this.markers[0].position.lng)
                bodyFormData.append('zoom',this.zoom)
                addnewlocation(bodyFormData).then(response=>{
                this.isLoading = false
                this.getAllLocations()
                }).catch(error => {
                    console.log(error)
                })
            },
            locationdelete(){
                this.$dialog.confirm({
                    title: 'Deleting',
                    message: 'Are you sure you want to <b>delete</b> this Location?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deletelocation()
                })
            },
            deletelocation(){
                this.isLoading = true
                const bodyFormData = new FormData();
                for (let key in this.singleLocation) {
                    const value = this.singleLocation[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('store','delete')
                bodyFormData.append('zoom',this.zoom)
                addnewlocation(bodyFormData).then(response=>{
                this.isLoading = false
                this.getAllLocations()
                }).catch(error => {
                    console.log(error)
                })
            }
        }
}
</script>