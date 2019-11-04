<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Settings
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <i style="float:right;  color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-edit" @click="toggleInputsActive"></i>
                </section>
                <!-- begin data -->
                <div class="card-content">
                    <div class="columns">
                          <div class="column is-6">
                            <b-field label="Title">
                                <b-input :disabled="disabled" v-model="settings.title"></b-input>
                            </b-field>
                          </div>
                          <div class="column is-6">
                            <b-field label="Admin path">
                                <b-input :disabled="disabled" v-model="settings.admin_path"></b-input>
                            </b-field>
                          </div>
                    </div>
                    <div class="columns">
                        <div class="column is-6">
                            <b-field label="Source">
                                <b-select v-model="settings.theme" :disabled="disabled" placeholder="select color" expanded>
                                    <option v-for="theme in themes" :key="theme" :value="theme">{{ theme }}</option>
                                </b-select>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Email">
                                <b-input :disabled="disabled" v-model="settings.email"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-6">
                            <b-field label="Address In English">
                                <b-input :disabled="disabled" v-model="settings.address" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Address In Arabic">
                                <b-input :disabled="disabled" v-model="settings.ar_address" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-6">
                            <b-field label="About Us In English">
                                <b-input :disabled="disabled" v-model="settings.about_hub" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="About Us In Arabic">
                                <b-input :disabled="disabled" v-model="settings.ar_about_hub" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-6">
                            <b-field label="Get In Touch In English">
                                <b-input :disabled="disabled" v-model="settings.get_in_touch" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Get In Touch In Arabic">
                                <b-input :disabled="disabled" v-model="settings.ar_get_in_touch" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-6">
                            <b-field label="Mission In English">
                                <b-input :disabled="disabled" v-model="settings.mission" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Mission In Arabic">
                                <b-input :disabled="disabled" v-model="settings.ar_mission" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-6">
                            <b-field label="Vision In English">
                                <b-input :disabled="disabled" v-model="settings.vision" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Vision In Arabic">
                                <b-input :disabled="disabled" v-model="settings.ar_vision" maxlength="200" type="textarea"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns">
                          <div class="column is-6">
                            <b-field label="play_store">
                                <b-input :disabled="disabled" v-model="settings.play_store"></b-input>
                            </b-field>
                          </div>
                          <div class="column is-6">
                            <b-field label="apple_store">
                                <b-input :disabled="disabled" v-model="settings.apple_store"></b-input>
                            </b-field>
                          </div>
                    </div>
                    <div class="columns">
                        <div class="column is-12">
                        <b-field label="Mail Provider">
                            <b-select v-model="settings.mail_provider" :disabled="disabled" placeholder="select color" expanded>
                                <option value="gmail">gmail</option>
                                <option value="cpanel">cpanel</option>
                                <option value="zoho" disabled="disabled">zoho</option>
                            </b-select>
                        </b-field>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-3">
                            <b-field label="leads mail">
                                <b-input :disabled="disabled" v-model="settings.leads_mail"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-3">
                            <b-field label="lead mail password">
                                <b-input :disabled="disabled" v-model="settings.lead_mail_password"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-3">
                            <b-field label="cil email">
                                <b-input :disabled="disabled" v-model="settings.cil_email"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-3">
                            <b-field label="cil password">
                                <b-input :disabled="disabled" v-model="settings.cil_password"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-12 text-center">
                            <b-field label="Website Under Maintenance">
                                <b-switch v-model="isSwitchedCustom"
                                    true-value="1"
                                    false-value="0">
                                    {{ isSwitchedCustom }}
                                </b-switch>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns text-center">
                        <div class="column is-6">
                            <b-field label="Logo">
                                <b-upload v-model="dropFilesLogo"
                                    multiple
                                    drag-drop>
                                    <section class="section">
                                        <div class="content has-text-centered">
                                            <p>
                                                <b-icon
                                                    icon="upload"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Drop your files here or click to upload</p>
                                        </div>
                                    </section>
                                </b-upload>
                            </b-field>

                            <div class="tags">
                                <span v-for="(file, index) in dropFilesLogo"
                                    :key="index"
                                    class="tag is-primary" >
                                    {{file.name}}
                                    <button class="delete is-small"
                                        type="button"
                                        @click="deleteDropFile(index)">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="column is-6">
                            <b-field label="watermark">
                                <b-upload v-model="dropFilesWather"
                                    multiple
                                    drag-drop>
                                    <section class="section">
                                        <div class="content has-text-centered">
                                            <p>
                                                <b-icon
                                                    icon="upload"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Drop your files here or click to upload</p>
                                        </div>
                                    </section>
                                </b-upload>
                            </b-field>

                            <div class="tags">
                                <span v-for="(file, index) in dropFilesWather"
                                    :key="index"
                                    class="tag is-primary" >
                                    {{file.name}}
                                    <button class="delete is-small"
                                        type="button"
                                        @click="deleteDropFile(index)">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="card">
                    <header class="card-header cardHeader">
                        <p class="card-header-title">Phone</p>
                        <i
                        class="fas fa-plus-circle"
                        @click="Addphonefield"
                        style="font-size: 1.75rem;
                    right: 2%;
                    position: absolute;
                    top: 15px;
                    color: #6eb165;
                    cursor: pointer;"
                        ></i>
                    </header>
                    <div class="card-content">
                        <b-collapse class="card" v-for="(data, index) in phones" :key="index">
                        <div slot="trigger" class="card-header">
                            <p class="card-header-title">Phone {{ index+1 }}</p>
                            <i
                            class="fas fa-trash"
                            @click="RemovePhone(index)"
                            style="font-size: 22px; cursor: pointer; margin-right: 2%; margin-top: 1%"
                            ></i>
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <div class="columns is-multiline is-mobile">
                                    <div class="column is-12">
                                    <b-field label="Number">
                                        <b-input v-model="phones[index].phone" :disabled="disabled"></b-input>
                                    </b-field>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </b-collapse>
                    </div>
                    </div>
                    <!-- social icons -->
                    <div class="card">
                    <header class="card-header cardHeader">
                        <p class="card-header-title">social icons</p>
                        <i
                        class="fas fa-plus-circle"
                        @click="Addsocialicons"
                        style="font-size: 1.75rem;
                    right: 2%;
                    position: absolute;
                    top: 15px;
                    color: #6eb165;
                    cursor: pointer;"
                        ></i>
                    </header>
                    <div class="card-content">
                        <b-collapse class="card" v-for="(data, index) in socialIcons" :key="index">
                        <div slot="trigger" class="card-header">
                            <p class="card-header-title">Icons {{ index+1 }}</p>
                            <i
                            class="fas fa-trash"
                            @click="RemovesocialIcons(index)"
                            style="font-size: 22px; cursor: pointer; margin-right: 2%; margin-top: 1%"
                            ></i>
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <div class="columns is-multiline is-mobile">
                                    <div class="column is-3">
                                        <b-field label="Mobile icon">
                                            <b-field class="file">
                                                <b-upload v-model="socialIcons[index].fileMobileIcon">
                                                    <a class="button is-success">
                                                        <b-icon icon="upload"></b-icon>
                                                        <span>Click to upload</span>
                                                    </a>
                                                </b-upload>
                                                <span class="file-name" v-if="socialIcons[index].fileMobileIcon">
                                                    {{ file.name }}
                                                </span>
                                            </b-field>
                                        </b-field>
                                    </div>
                                    <div class="column is-3">
                                        <b-field label="Mobile icon">
                                            <b-field class="file">
                                                <b-upload v-model="socialIcons[index].fileWebIcon">
                                                    <a class="button is-success">
                                                        <b-icon icon="upload"></b-icon>
                                                        <span>Click to upload</span>
                                                    </a>
                                                </b-upload>
                                                <span class="file-name" v-if="socialIcons[index].fileWebIcon">
                                                    {{ file.name }}
                                                </span>
                                            </b-field>
                                        </b-field>
                                    </div>
                                    <div class="column is-3">
                                        <b-field label="social url">
                                            <b-input v-model="socialIcons[index].link" :disabled="disabled"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </b-collapse>
                    </div>
                    </div>
                    <div class="columns">
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
                    </div>
                    <hr>
                    <div class="columns">
                        <div class="column is-12">
                            <b-button type="is-success"
                                @click="updateSettings"
                                icon-left="pen">
                                Edit
                            </b-button>
                        </div>
                    </div>
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<script>
import {
    getdatasetting,
    getSettingphone,
    getsettingsocial,
    updateSingleSettings
} from './../../calls'
export default {
    data() {
            return {
                settings:[],
                dropFilesLogo:[],
                dropFilesWather:[],
                phones:[],
                socialIcons:[],
                themes:[],
                isSwitchedCustom:0,
                fileMobileIcon:'',
                fileWebIcon:'',
                center: { lat: 30.0595581, lng: 32.0595581 },
                zoom: 12,
                markers: [{ position: { lat: 30.0595581, lng: 32.0595581 } }],
                disabled:true,
                isLoading:true,
                isFullPage:false,
            }
        },
        components:{
        },
        created() {
            this.settingsdata()
            this.getAllPhone()
            this.getAllSocial()
        },
        mounted(){
        },
        methods: {
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            settingsdata(){
                getdatasetting().then(response=>{
                    this.settings = response.data.settings
                    this.themes = response.data.themes
                    this.markers[0].position.lng = response.data.settings.lng
                    this.markers[0].position.lat = response.data.settings.lat
                    this.center.lat = response.data.settings.lat
                    this.center.lng = response.data.settings.lng
                    // console.log('lat',response.data.settings.lat)
                    // console.log('Setting data',this.settings)
                    // console.log('themes data',this.themes)
                    this.isLoading = false
                }).catch(error=>{
                    console.log(error)
                })
            },
            updateSettings(){
                this.isLoading = true
                const bodyFormData = new FormData();
                for (let key in this.settings) {
                    const value = this.settings[key];
                    bodyFormData.set(key, value);
                }
                // for (let key in this.phones) {
                // const value = this.phones[key];
                // bodyFormData.append("phone[]",this.phones[key].phone);
                // }

                bodyFormData.append('phone',JSON.stringify(phones))

                for (let key in this.socialIcons) {
                const value = this.socialIcons[key];
                bodyFormData.append("social_url" + "[" + key + "]", JSON.stringify(this.socialIcons[key]));
                // bodyFormData.append("file" + "[" + key + "]", this.agenda[key]['file']);
                // bodyFormData.append("WebIcon",this.socialIcons[key]['fileWebIcon']);
                // bodyFormData.append("MobileIcon",this.socialIcons[key]['fileMobileIcon']);
                }
                bodyFormData.append('watermark',this.dropFilesWather[0])
                bodyFormData.append('logo',this.dropFilesLogo[0])
                bodyFormData.append('lng',this.markers[0].position.lng)
                bodyFormData.append('lat',this.markers[0].position.lat)
                updateSingleSettings(bodyFormData).then(response=>{
                    this.isLoading = true
                    this.alertsuccess('Settings Up to date')
                    this.settingsdata()
                }).catch(error=>{
                    this.alerterror('have some error please check the inputs requierment!')
                    this.isLoading = false
                    console.log(error)
                })
            },
            getAllPhone(){
                getSettingphone().then(response=>{
                    this.phones = response.data
                    console.log('phones',response)
                }).catch(error=>{
                    console.log(error)
                })
            },
            getAllSocial(){
                getsettingsocial().then(response=>{
                    this.socialIcons = response.data
                    console.log('icons',response.data)
                }).catch(error=>{
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
            RemovePhone(){
                alert('adsdasd')
            },
            Addphonefield: function() {
            var id =
                Math.max.apply(
                Math,
                this.phones.map(function(o) {
                    return o.id;
                })
                ) + 1;
            this.phones.push({ id, field: null, value: null });
            },
            Addsocialicons: function() {
            var id =
                Math.max.apply(
                Math,
                this.phones.map(function(o) {
                    return o.id;
                })
                ) + 1;
            this.socialIcons.push({ id, field: null, value: null });
            },
            RemovesocialIcons(){
                alert('sadasd')
            },
            alertsuccess(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-success'
                })
            },
            alerterror(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-danger'
                })
            }
        }
}
</script>