<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Project
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="column first">
                        <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-3">
                                <b-field label="Is Featured">
                                    <b-switch v-model="project.featured"
                                    true-value=1
                                    false-value=0>
                                    </b-switch>
                                </b-field>
                            </div>
                            <div class="column is-3">
                                <b-field label="Show on Website">
                                    <b-switch v-model="project.show_website"
                                    true-value=1
                                    false-value=0>
                                    </b-switch>
                                </b-field>
                            </div>
                            <div class="column is-3">
                                <b-field label="Vacation">
                                    <b-switch v-model="project.vacation"
                                    true-value=1
                                    false-value=0>
                                    </b-switch>
                                </b-field>
                            </div>
                            <div class="column is-3">
                                <b-field label="Mobile">
                                    <b-switch v-model="project.mobile"
                                    true-value=1
                                    false-value=0>
                                    </b-switch>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="English Name">
                                    <b-input type="text" v-model="project.en_name" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Name">
                                    <b-input type="text" v-model="project.ar_name" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="English Description">
                                    <b-input v-model="project.en_description" maxlength="200" type="textarea"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Description">
                                    <b-input v-model="project.ar_description" maxlength="200" type="textarea"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Developer">
                                    <b-select v-model="project.selectedDeveloper">
                                        <option v-for="developer in allDevelopers" :key="developer.id" :value="developer.id">{{developer.name}}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Type">
                                    <b-select v-model="project.type">
                                        <option value="commercial">Commercial</option>
                                        <option value="personal">Residential</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Facility">
                                    <multiselect :close-on-select="false" v-model="project.facilities"  tag-placeholder="Add this as new facility" placeholder="Select Facilities" label="name" track-by="id" value="id" :options="facilities" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Tags">
                                    <multiselect :close-on-select="false" v-model="project.tags"  tag-placeholder="Add this as new tag" placeholder="Select Tags" label="name" track-by="id" value="id" :options="tags" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Area From">
                                    <b-input type="number" v-model="project.area" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Area From">
                                    <b-input type="number" v-model="project.area_to" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Video">
                                    <b-input type="text" v-model="project.video" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Facebook">
                                    <b-input type="text" v-model="project.facebook" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Meta Keywords">
                                    <b-input type="text" v-model="project.meta_keywords" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Meta Description">
                                    <b-input type="text" v-model="project.meta_description" />
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Down Payment">
                                    <b-input type="number" v-model="project.down_payment" />
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Installment Year">
                                    <b-input type="number" v-model="project.installment_year" />
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Delivery Date">
                                    <b-datepicker
                                        placeholder="Click to select Date..."
                                        :date-formatter="dateFormatter"
                                        v-model="project.dv">
                                    </b-datepicker>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Price / Meter">
                                    <b-input type="number" v-model="project.meter_price" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Location On Map">
                                    <b-select v-model="project.location_id">
                                        <option v-for="location in locations" :key="location.id" :value="location.id">{{location.title}}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Developer PDF">
                                <div class="field" style="display: flex">
                                <b-upload v-model="project.developer_pdf" @input="handleFile($event,1)">
                                    <a class="button is-primary">
                                        <b-icon icon="upload"></b-icon>
                                        <span>Click to upload</span>
                                    </a>
                                </b-upload>
                                <span class="file-name" v-if="project.developer_pdf">
                                    {{ files.developer_pdf }}
                                </span>
                                </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Broker PDF">
                                <div class="field" style="display: flex">
                                <b-upload v-model="project.broker_pdf" @input="handleFile($event,2)">
                                    <a class="button is-primary">
                                        <b-icon icon="upload"></b-icon>
                                        <span>Click to upload</span>
                                    </a>
                                </b-upload>
                                <span class="file-name" v-if="project.broker_pdf">
                                    {{ files.broker_pdf }}
                                </span>
                                </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Logo">
                                <div class="field" style="display: flex">
                                <b-upload v-model="project.logo" @input="handleFile($event,3)">
                                    <a class="button is-primary">
                                        <b-icon icon="upload"></b-icon>
                                        <span>Click to upload</span>
                                    </a>
                                </b-upload>
                                <span class="file-name" v-if="project.logo">
                                    {{ files.logo }}
                                </span>
                                </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Cover">
                                <div class="field" style="display: flex">
                                <b-upload v-model="project.cover" @input="handleFile($event,4)">
                                    <a class="button is-primary">
                                        <b-icon icon="upload"></b-icon>
                                        <span>Click to upload</span>
                                    </a>
                                </b-upload>
                                <span class="file-name" v-if="project.cover">
                                    {{ files.cover }}
                                </span>
                                </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Website Cover (Best Image resolution is 900 * 536)">
                                <div class="field" style="display: flex">
                                <b-upload v-model="project.website_cover" @input="handleFile($event,5)">
                                    <a class="button is-primary">
                                        <b-icon icon="upload"></b-icon>
                                        <span>Click to upload</span>
                                    </a>
                                </b-upload>
                                <span class="file-name" v-if="project.website_cover">
                                    {{ files.website_cover }}
                                </span>
                                </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Website Slider Banner (Best resolution: 1900 * 1000)">
                                <div class="field" style="display: flex">
                                <b-upload v-model="project.website_slider" @input="handleFile($event,6)">
                                    <a class="button is-primary">
                                        <b-icon icon="upload"></b-icon>
                                        <span>Click to upload</span>
                                    </a>
                                </b-upload>
                                <span class="file-name" v-if="project.website_slider">
                                    {{ files.website_slider }}
                                </span>
                                </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Gallery Image (Best resolution is 900 * 536)">
                                <div class="field" style="display: flex">
                                <b-upload v-model="project.gallery" @input="handleFile($event,7)">
                                    <a class="button is-primary">
                                        <b-icon icon="upload"></b-icon>
                                        <span>Click to upload</span>
                                    </a>
                                </b-upload>
                                <span class="file-name" v-if="project.gallery">
                                    {{ files.gallery }}
                                </span>
                                </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Add Main Slider">
                                    <b-switch v-model="project.on_slider"
                                    true-value=1
                                    false-value=0>
                                    </b-switch>
                                </b-field>
                            </div>
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
                                <gmap-map :center="center" :zoom="zoom" style="width:100%;  height: 400px;">
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
                            <div class="column is-12">
                                <button type="button" class="button is-primary is-meduim mr-10 import-excel" @click="updateProject">Update</button>
                            </div> 
                        </div>
                    </div> 
                </section>
            </div>
        </div>
    </div>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {getEditedProject,updateProject,getAllDevelopers,getFacilities,getAllTags} from './../../calls'
import Multiselect from 'vue-multiselect'
import { Carousel, Slide } from "vue-carousel";
export default {
    data() {
            return {
                project: {},
                selectedDeveloper: {},
                allDevelopers: [],
                facilities: [],
                tags: [],
                locations: [],
                files: {},
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                delivery_date: '',
                center: { lat: 30.0595581, lng: 32.0595581 },
                zoom: 12,
                markers: [{ position: { lat: 30.0595581, lng: 32.0595581 } }],
            }
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            this.getAllTags();
            this.getFacilities();
            this.getAllDevelopers();            
            this.getData()

            $('select').css('width','100%')
            $('select').parent().css('width','100%')
        },
        components: {
            Carousel,
            Slide,
            Multiselect
        },
        methods: {
            handleFile(event,id) {
                const file = event
                console.log(file)
                console.log(id)
                if(id == 1 || id == 2){
                    if (!/\.(pdf)$/i.test(file.name)) {
                        alert('Your choice is not a pdf file')
                    }else{
                        if(id == 1){
                            this.files.developer_pdf = this.project.developer_pdf.name
                        }else if(id == 2){
                            this.files.broker_pdf = this.project.broker_pdf.name
                        }
                    }
                }else if(id == 3 || id == 4 || id == 5 || id == 6 || id == 7){
                    if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                        alert('Your choice is not an image')
                    }else{
                        if(id == 3){
                            this.files.logo = this.project.logo.name
                        }
                        else if(id == 4){
                            this.files.cover = this.project.cover.name
                        }
                        else if(id == 5){
                            this.files.website_cover = this.project.website_cover.name
                        }
                        else if(id == 6){
                            console.log("testtttt")
                            this.files.website_slider = this.project.website_slider.name
                        }
                        else if(id == 7){
                            this.files.gallery = this.project.gallery.name
                        } 
                    }
                }
            },
            getAllTags() {
                getAllTags()
                .then(response => {
                    this.tags = response.data
                })
                .catch(error => {
                    console.log(error);
                });
            },
            getAllDevelopers() {
                getAllDevelopers()
                .then(response => {
                    this.allDevelopers = response.data
                })
                .catch(error => {
                    console.log(error);
                });
            },
            getFacilities(){
                getFacilities()
                .then(response => {
                    this.facilities = response.data
                })
                .catch(error => {
                    console.log(error);
                });
            },
            deleteDropFile(index) {
                this.dropFiles.splice(index, 1)
            },
            handleMainImage(event) {
                const file = event
                console.log(file)
                if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedLogo = reader.result
                })
            },
            getData(){
                this.isLoading = true
                getEditedProject(this.id).then(response=>{
                    console.log(response)
                    this.project = response.data.project
                    this.project.selectedDeveloper = response.data.project.developer_id
                    this.files.developer_pdf = this.project.developer_pdf
                    this.files.broker_pdf = this.project.broker_pdf
                    this.files.cover = this.project.cover          
                    this.files.logo = this.project.logo
                    this.files.website_cover = this.project.website_cover
                    this.files.website_slider = this.project.website_slider
                    this.locations = response.data.location
                    // this.project.facilities = response.data.facilities
                    this.isLoading = false
                })
                .catch(error => {
                    console.log(error)
                })
            },
            dateFormatter(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.delivery_date = year
                return date
            },
            updateProject(){
                const bodyFormData = new FormData();
                bodyFormData.append("_token",this.token);
                for (let key in this.project) {
                    const value = this.project[key];
                    console.log(key,value)
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('location',this.project.location_id);
                bodyFormData.append('developer',this.project.selectedDeveloper);
                bodyFormData.append('developer',this.project.selectedDeveloper);
                bodyFormData.append('project_slider',this.project.website_slider);
                bodyFormData.delete('website_slider');
                bodyFormData.delete('location_id');
                bodyFormData.delete('developer_id');
                bodyFormData.append('lng',this.markers[0].position.lng)
                bodyFormData.append('lat',this.markers[0].position.lat)
                bodyFormData.append("_method", "put");
                const tags = this.project.tags
                if(tags != null){
                    for (var i = 0; i < tags.length; i++) {
                        console.log(tags[i])
                        bodyFormData.append('tags[]', JSON.stringify(tags[i]['id']));
                    }
                }
                const facilities = this.project.facilities
                if(facilities != null){
                    for (var i = 0; i < facilities.length; i++) {
                        console.log(facilities[i])
                        bodyFormData.append('facility[]', JSON.stringify(facilities[i]['id']));
                    }
                }
                // for (let key in this.files) {
                //     const value = this.files[key];
                //     console.log(key,value)
                //     bodyFormData.set(key, value);
                // }
                updateProject(bodyFormData,this.id).then(response=>{
                    console.log(response)
                    this.success("Updated")
                })
                .catch(error => {
                    this.errorDialog()
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
            errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please Fill required inputs',
                    type: 'is-danger',
                })
            },
            success(action) {
                this.$toast.open({
                    message: 'Project '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
        }
}
</script>

<style scoped>
    .column{
        margin-bottom:10px;
    }
    #texteditor h2{
        font-size: 1.5em;
        font-weight: bold;
    }
    #texteditor h3{
        font-size: 1.17em;
        font-weight: bold;
    }
    #texteditor h4{
        font-size: 16px;
        font-weight: bold;
    }
    #texteditor > div > div.ck.ck-editor__main > div ul{
        list-style:initial;
        display: block;
        list-style-type: disc;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;   
    }
    
    #texteditor > div > div.ck.ck-editor__main > div ol{
        display: block;
        list-style-type: decimal;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;
    }
    #contact_wrapper{
        display:flex;
        flex-wrap:wrap;
    }
    #contact{
        margin-top:10px;
        margin-bottom:10px;
    }
    /* span .select,select{
        width:100%
    } */

</style>
