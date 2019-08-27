<template>
  <div>
      <Header />
    <vue-good-wizard 
      :steps="steps"
      :onNext="nextClicked" 
      :onBack="backClicked">
      <div slot="page1">

        <div class="columns is-multiline is-mobile">    
            <div class="column is-12">
                <div class="field">
                    <label class="label">Add Unit Type</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.uniteAddType" required="" class="is-danger" >
                                <option value="resale">Resale Unit</option>
                                <option value="rentel">Rentel Unit</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>              
            <div class="column is-3">
                <div class="field">
                    <label class="label">Privacy</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.privacy">
                                <option value="only_me">Only Me</option>
                                <option value="team_only">Team Only</option>
                                <option value="public">Public</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <b-field label="Lead" 
                    message="This field is required"
                    v-bind:type="{ 'is-danger': true  }" > 
                    <b-autocomplete
                        v-model="name"
                        ref="autocomplete"
                        :data="filteredDataArray"
                        placeholder="Lead"
                        :open-on-focus="openOnFocus"
                        @select="option => selected = option">
                        <template slot="header">
                            <a @click="showAddLead = true">
                                <span> Add new... </span>
                            </a> 
                        </template>
                        <template slot="empty">No results for {{name}}</template>
                    </b-autocomplete>
                </b-field>
                <!--<div class="field">
                    <label class="label">Lead</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.lead_id">
                                <option v-for="lead in leads" :key="lead.id" :value="lead.id">{{lead.first_name+' '+lead.last_name}}</option>
                            </select>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label">Agent</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.agent_id">
                                <option v-for="agent in allAgents" :key="agent.id" :value="agent.id">{{agent.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <b-field label="Phone">
                        <b-input v-model="newUnitData.phone"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">English Description</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="" v-model="newUnitData.en_description"></textarea>
                    </div>
                </div>
            </div>
            <div class="column is-6">
                <div class="field">
                    <label class="label">Arabic Description</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="" v-model="newUnitData.ar_description"></textarea>
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">English Notes</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="" v-model="newUnitData.en_notes"></textarea>
                    </div>
                </div>
            </div>
            <div class="column is-6">
                <div class="field">
                    <label class="label">Arabic Notes</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="" v-model="newUnitData.ar_notes"></textarea>
                    </div>
                </div>
            </div>
                                                 
        </div>
      </div>
      <div slot="page2">
        <div class="columns is-multiline is-mobile">                  
            <div class="column is-3">
                <div class="field">
                    <label class="label">Type</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.type" @change="unitsTypes">
                                <option value="commercial">Commercial</option>
                                <option value="personal">Residential</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label">Unit Type</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.unit_type_id">
                                <option :value="type.id" v-for="type in unitTypes" :key="type.id">{{type.en_name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label">Project</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.project_id">
                                <option :value="project.id" v-for="project in projects" :key="project.id">{{project.en_name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
             <div class="column is-3">
                <div class="field">
                    <label class="label">View</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.view">
                                <option v-for="view in views" :key="view.id" :value="view.id">{{view.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="column is-3">
                <div class="field">
                    <b-field label="Area">
                        <b-input v-model="newUnitData.area"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-3">
                <div class="field">
                    <b-field label="Rooms">
                        <b-input v-model="newUnitData.rooms"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-3">
                <div class="field">
                    <b-field label="Bathrooms">
                        <b-input v-model="newUnitData.bathrooms"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-3">
                <div class="field">
                    <b-field label="Floors">
                        <b-input v-model="newUnitData.floors"></b-input>
                    </b-field>
                </div>
            </div>

             <div class="column is-4">
                <div class="field">
                    <b-field label="Bua">
                        <b-input placeholder="Click to select..." position="is-bottom-left" v-model="newUnitData.bua"></b-input>
                        <!-- <b-datepicker
                            placeholder="Click to select..."
                            :date-formatter="dateFormatter2"
                            position="is-bottom-left" v-model="newUnitData.bua">
                        </b-datepicker> -->
                    </b-field>
                </div>
            </div>

            <div class="column is-3">
                <div class="field">
                    <b-field label="Land Area">
                        <b-input v-model="newUnitData.landArea"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <label class="label">Delivery Date</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.delivery_date">
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2025">2025</option>
                                                    <option value="2026">2026</option>
                                                    <option value="2027">2027</option>
                                                    <option value="2028">2028</option>
                                                    <option value="2029">2029</option>
                                                    <option value="2030">2030</option>
                                                    <option value="2031">2031</option>
                                                    <option value="2032">2032</option>
                                                    <option value="2033">2033</option>
                                                    <option value="2034">2034</option>
                                                    <option value="2035">2035</option>
                                                    <option value="2036">2036</option>
                                                    <option value="2037">2037</option>
                                                    <option value="2038">2038</option>
                                                    <option value="2039">2039</option>
                                                    <option value="2040">2040</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <label class="label">Finishing</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.finishing">
                                <option value="finished">Finished</option>
                                <option value="semi_finished">Semi Finished</option>
                                <option value="not_finished">Not Finished</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
                                                 
        </div>
      </div>
      <div slot="page3">
        <div class="columns is-multiline is-mobile">                  
    
            
            <div class="column is-4">
                <div class="field">
                    <label class="label">Country</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.country">
                                <option value="64">Egypt</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <label class="label">City</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.city">
                                <option  v-for="city in cities" :key="city.id" :value="city.id" v-if="city.country_id == newUnitData.country">{{city.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
             <div class="column is-4">
                <div class="field">
                    <label class="label">District</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.district">
                                <option v-for="district in districts" :key="district.id" :value="district.id" v-if="district.city_id == newUnitData.city">{{district.en_name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <label class="label">Location</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.location" @change="locationChange">
                                <option v-for="location in locations" :key="location.id" :value="location" >{{location.en_name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <b-field label="English Address">
                        <b-input v-model="newUnitData.en_address"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <b-field label="Arabic Address">
                        <b-input v-model="newUnitData.ar_address"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-12">
                <!-- <googlemaps-map
                :center.sync="center"
                :zoom.sync="zoom"
                @click="onMapClick" style="width: 100%; height: 500px">
                <googlemaps-map
                        :key="index"
                        v-for="(m, index) in markers"
                        :position="m.position"
                        :clickable="true"
                        :draggable="true"
                        @click="center=m.position"
                      />
                <gmap-marker
                        v-bind:key="index"
                        v-for="(m, index) in markers"
                        v-bind:position="m.position"
                        v-bind:clickable="true"
                        @click="center=m.position"
                      >
                </gmap-marker>
  
                </googlemaps-map> -->
            </div>
                                                 
        </div>
      </div>
      <div slot="page4">
        <div class="columns is-multiline is-mobile" style="padding-top: 30px;">                  
    
            <div class="column is-6 text-center">
                <label class="label">Upload main image</label>
                <b-field>
                    <b-upload v-model="dropFiles1"
                        @input="handleImage"
                        drag-drop
                        accept="image/*"
                        name="files">
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
                    <span v-for="(file, index) in dropFiles1"
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
            <div class="column is-6 text-center">
                <h5 class="label">Upload other images</h5>
                <b-field>
                    <b-upload v-model="dropFiles2"
                        @input="handleImage1"
                        multiple
                        drag-drop
                        accept="image/*"
                        name="files">
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
                    <span v-for="(file, index) in dropFiles2"
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
    <div slot="page5" v-if="newUnitData.uniteAddType == 'resale'">
        <div class="columns is-multiline is-mobile">                  
            
            <div class="column is-4">
                <div class="field">
                    <b-field label="Original Price">
                        <b-input v-model="newUnitData.originalPrice"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <b-field label="Paid">
                        <b-input v-model="newUnitData.paid"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <b-field label="Rest">
                        <b-input v-model="newUnitData.rest"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <b-field label="Total">
                        <b-input v-model="newUnitData.total"></b-input>
                    </b-field>
                </div>
            </div>

             <div class="column is-4">
                <div class="field">
                    <b-field label="Price">
                        <b-input v-model="newUnitData.price"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <label class="label">Payment Method</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.payment_method">
                                <option value="cash">Cash</option>
                                <option value="installment">Installment</option>
                                <option value="cash_or_installment">Cash Or Installment</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

             <div class="column is-4">
                <div class="field">
                    <b-field label="Due Now">
                        <b-input placeholder="Click to select..." position="is-bottom-left" v-model="newUnitData.due_now"></b-input>
                        <!-- <b-datepicker
                            placeholder="Click to select..."
                            :date-formatter="dateFormatter2"
                            position="is-bottom-left" v-model="newUnitData.due_now">
                        </b-datepicker> -->
                    </b-field>
                </div>
            </div>
             <div class="column is-12">
                <div class="control">
                    <button class="button is-link mr-10" @click="saveUnit">Submit</button>
                </div>
            </div>

                                                 
        </div>
    </div>
    <div slot="page5" v-if="newUnitData.uniteAddType == 'rentel'">
        <div class="columns is-multiline is-mobile">                  
            
            <div class="column is-4">
                <div class="field">
                    <label class="label">Period Type</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select v-model="newUnitData.periodType">
                                <option value="long">long</option>
                                <option value="short">short</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <b-field label="Value Ensure">
                        <b-input v-model="newUnitData.valueEnsure"></b-input>
                    </b-field>
                </div>
            </div>

            <div class="column is-4">
                <div class="field">
                    <b-field label="value of Rouf">
                        <b-input v-model="newUnitData.valueOfRent"></b-input>
                    </b-field>
                </div>
            </div>

            
             <div class="column is-12">
                <div class="control">
                    <button class="button is-link mr-10" @click="saveUnit">Submit</button>
                </div>
            </div>

                                                 
        </div>
    </div>
    </vue-good-wizard>
    <Footer />
            <b-modal :active.sync="showAddLead">
                <div class="modal-card" style="width: auto">
                   
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add Lead</p>
                    </header>
                    <section class="modal-card-body">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-6">
                                <b-field label="First Name">
                                    <b-input v-model="newLeadData.leadFirstName"></b-input>
                                </b-field>                  
                            </div>
                            <div class="column is-6">
                                <b-field label="Last Name">
                                    <b-input v-model="newLeadData.leadLastName"></b-input>
                                </b-field>                  
                            </div>        
                            <div class="column is-6">
                                <b-field label="phone">
                                    <b-input v-model="newLeadData.phone"></b-input>
                                </b-field>                  
                            </div>   
                            <div class="column is-6">
                                <label class="label">Lead source</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.sourceId">
                                            <option v-for="source in leadSources" :key="source.id" :value="source.id">{{source.name}}</option>
                                        </select>
                                    </div>
                                </div>                
                            </div>  
                            <div class="column is-6">
                                <b-field label="Reference">
                                    <b-input v-model="newLeadData.reference"></b-input>
                                </b-field>                  
                            </div> 
                            <div class="column is-6">
                                <label class="label">Residencial Agent</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.r_agent">
                                            <option v-for="agent in residentialAgents" :key="agent.id" :value="agent.id">{{agent.name}}</option>
                                        </select>
                                    </div>
                                </div>                
                            </div>  
                            <div class="column is-6">
                                <label class="label">Commercial Agent</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.c_agent">
                                            <option v-for="agent in commercialAgents" :key="agent.id" :value="agent.id" >{{agent.name}}</option><!-- v-if="window.auth_user.type == 'admin'" -->
                                        </select>
                                    </div>
                                </div>                
                            </div>  
                        </div>
                    </section>
                    <footer class="modal-card-foot" style="justify-content: flex-end;">
                        <button class="button is-primary" @click="addLead">Add Lead</button>
                    </footer>
                </div>
            </b-modal>
  </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.css';

import Header from '../Layout/Header'
import Footer from '../Layout/Footer'
import {getUnitTypes,getPublicData,storeUnitResale,getAllLeads,getAgents,getLeadSources,leadShortAdding, getDistruct} from './../../calls' 



export default {
  name: 'demo',
  data(){
    return {
      steps: [
        {
          label: 'Description & Privacy',
          slot: 'page1',
        },
        {
          label: 'Unit Information',
          slot: 'page2',
        },
        {
          label: 'Location',
          slot: 'page3',
        },
         {
          label: 'Images',
          slot: 'page4',
        },
        {
          label: 'Payments',
          slot: 'page5',
          options: {
            nextDisabled: true, // control whether next is disabled or not
          },
        }
      ],
      dropzoneOptions: {
            url: 'https://httpbin.org/post',
            thumbnailWidth: 100,
            maxFilesize: 3.0,
            headers: { "My-Awesome-Header": "header value" },
            dictDefaultMessage: "<i class='fa fa-cloud-upload mr-1'></i> Upload Other Images",
            addRemoveLinks: true,
        },
      center: {lat:30.0595581,lng:31.2233591},
      zoom: 13,
      markers: {position: {lat:30.0595581,lng:31.2233591}},
      newUnitData: {},
      privacyArray: ['Only Me','Team Only','Public'],
      views: [
                {id: "main_street", name: "Main Street"},
                {id: "bystreet", name: "By Street"},
                {id: "garden", name: "Garden"},
                {id: "corner", name: "Corner"},
                {id: "sea_or_river", name: "Sea Or River"}
            ],
      leads: [],
      locations: [],
      districts: [],
      cities: [],
      projects: [],
      unitTypes: [],
      allAgents: [],
      leadSources: [],
      openOnFocus: true,
      name: '',
      uniteAddType: 'resale',
      showAddLead: false,
      newLeadData: {},
      commercialAgents: [],
      residentialAgents: [],
      dropFiles1: [],
      dropFiles2: [],
      mainPhoto: '',
      other_images: [],
    }
  },
    components: {
        Header: Header,
        Footer: Footer,
        vueDropzone: vue2Dropzone,
    },
    created() {
        
        this.getPublic()
        this.getCompanyAgents()
        this.getLeads()
        this.getSources()
    },
    mounted(){
        console.log(this.$refs)
    },
    computed: {
        filteredDataArray() {
            return this.leads.filter((option) => {
                return option
                .toString()
                .toLowerCase()
                .indexOf(this.name.toLowerCase()) >= 0
            })
        }
    },
    methods: {
        locationChange(){
            console.log(this.newUnitData.location);
            console.log('qqqqqqqq  ');
            // this.newUnitData.location.lat = this.newUnitData.location.lat
            this.zoom = parseInt(this.newUnitData.location.zoom);
            this.center.lng = parseInt(this.newUnitData.location.lng);
            this.center.lat = parseInt(this.newUnitData.location.lat);
            // this.markers = [{position:{lng: parseInt(this.newUnitData.location.lng), lat: parseInt(this.newUnitData.location.lat)}};
            // this.newUnitData.location = this.newUnitData.location.en_name;
        },
        deleteDropFile(index) {
            this.dropFiles.splice(index, 1)
        },
        saveUnit(){
            
            this.newUnitData.lat = this.center.lat;
            this.newUnitData.lng = this.center.lng;
            this.newUnitData.zoom = this.zoom;

            this.newUnitData.locationId = this.newUnitData.location.id;
            if(this.uniteAddType === 'resale'){
                // this.newUnitData.landArea = this.landArea
                // this.newUnitData.bua = this.bua
                this.newUnitData.image = this.mainPhoto;
                // this.newUnitData.other_images = this.other_images;
                this.newUnitData.other_images = this.other_images;
                console.log(this.newUnitData);
                storeUnitResale(this.newUnitData).then(response=>{
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
            }else if(this.uniteAddType === 'rentel'){
                // this.newUnitData.bua = this.bua
                // this.newUnitData.due_now = this.due_now
                storeUnitResale(this.newUnitData).then(response=>{
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
            }
            
        },
        addLead(){
            leadShortAdding(this.newLeadData).then(response=>{
                console.log(response)
                console.log('3')
                this.showAddLead = false
            })
                .catch(error => {
                console.log(error)
            })
            
            
        },
        unitsTypes(event){
            var usage = event.target.value
            getUnitTypes({usage: usage, _token: this.token}).then(response=>{
                console.log(response)
                this.unitTypes = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        getSources(){
            getLeadSources().then(response=>{
                this.leadSources = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },

        getPublic(){
            getPublicData().then(response=>{
                this.locations = response.data.locations
                this.projects = response.data.projects
                console.log(response.data.districts.en_name)
                this.districts = response.data.districts
                this.cities = response.data.cities
            })
            .catch(error => {
                console.log(error)
            })
        },
        getCompanyAgents(){
            getAgents().then(response=>{
                this.commercialAgents = response.data.commercialAgents
                this.residentialAgents = response.data.residentialAgents
                this.commercialAgents.forEach(element => {
                    this.allAgents.push(element)
                });
                this.residentialAgents.forEach(element => {
                    this.allAgents.push(element)
                });
            })
            .catch(error => {
                console.log(error)
            })
        },
        getLeads(){
            getAllLeads().then(response=>{
                console.log(response)
                this.leads = response.data 
            })
            .catch(error => {
                console.log(error)
            })
        },
        onMapClick(){

        },
        handleImage (event) {
            const files = event
            if (!/\.(gif|jpg|jpeg|png|webp)$/i.test(files[0].name)) {
                alert('Your choice is not a picture')
                return prevent()
            }
            var reader = new FileReader
            reader.addEventListener('load', () => {
                this.mainPhoto = reader.result
                console.log(reader.result);
            })
            reader.readAsDataURL(files[0])

            console.log(reader.result);
        },
        handleImage1 (event) {
            const files = event
            files.forEach(img => {
                if (!/\.(gif|jpg|jpeg|png|webp)$/i.test(img.name)) {
                    alert('Your choice is not a picture')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.other_images.push(reader.result)
                    console.log(reader.result);
                })
                reader.readAsDataURL(img)
            });
           
        },
        dateFormatter2(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.bua = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        nextClicked(currentPage) {
            console.log('next clicked', currentPage)
            console.log('next clicked', this.newUnitData.uniteAddType)
            switch(currentPage) {
                case 1:
                    if (this.newUnitData.uniteAddType == undefined) {

                    }
                    break;
                case 2:
                    
                    break;
                default:
                    
            }

            return true; //return false if you want to prevent moving to next page
        },
        backClicked(currentPage) {
            console.log('back clicked', currentPage);
            return true; //return false if you want to prevent moving to previous page
        }
    },
};
</script>
