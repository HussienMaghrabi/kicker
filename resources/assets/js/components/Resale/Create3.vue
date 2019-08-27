<template>
  <div>
    <Header />
    <form-wizard @on-complete="onComplete"
    validate-on-back
    ref="wizard" 
    :start-index.sync="activeTabIndex"
    shape="circle" color="#20a0ff" error-color="#ff4949">
        <tab-content title="Description & Privacy" icon="" :before-change="() => validate('firstStep')"> <!-- unit information - Location - Images - Payment -->
            <first-step ref="firstStep" @on-validate="onStepValidate"></first-step>
            <el-button @click="forceClearError">Try to clear the error</el-button>
        </tab-content>
    </form-wizard>

    
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



import FirstStep from "./steps/FirstStep.vue";

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
      finalModel: {},
      activeTabIndex: 0
    }
  },
    components: {
        Header: Header,
        Footer: Footer,
        vueDropzone: vue2Dropzone,
        FirstStep: FirstStep,
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
        onComplete() {
          alert("Yay. Done!");
        },
        forceClearError() {
          this.$refs.wizard.tabs[this.activeTabIndex].validationError = null;
        },
        validate(ref) {
          return this.$refs[ref].validate();
        },
        onStepValidate(validated, model) {
          if (validated) {
            this.finalModel = { ...this.finalModel, ...model };
          }
        },

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
                    console.log('testing')
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
                console.log('4')
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

<style type="text/css">
    @import 'https://unpkg.com/element-ui@2.4.9/lib/theme-chalk/index.css';
    @import 'https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css';
</style>
