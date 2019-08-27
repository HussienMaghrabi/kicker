<template>
    <section > 
        <div class="parent"> 
        <!-- tap meeeeeeeeeeeeeee -->
            <h3 style="display:inline" class="title"> All requests</h3> 
        <b-tabs class="tabbs" v-model="activeTab">
            <b-tab-item label="Main Information">
                        <div >
        <div class="card">
            <div class="card-content">
                <section class="container tasks">
                <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>                
                <div class="column first">
                    <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-12">
                                <b><label>ID: </label></b> 
                                <div class="column is-6">
                                    <b-input type="text" :value="MainInformation.id" :disabled="disabled" v-model="MainInformation.id" />
                                </div>
                            </div>
                            <hr>
                             <div v-if="disabled=disabled" class="column is-12">
                                <b><label>Lead: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.leadName"/>
                                </div>
                            </div>
                            <hr>

                             <div v-if="disabled==false" class="column is-12">
                                <b><label>Lead: </label></b>
                                <div class="column is-6">
                                <b-select v-model= "MainInformation.leadName" expanded>
                                    <option v-for="lead in leads " :value="lead.id">{{lead.first_name+' '+lead.last_name}}</option>
                                </b-select>    
                                </div>
                            </div>
                            <hr>
                            

                            <div class="column is-12">
                                <b><label>Price From: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.price_to"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Price To: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.price_from"/>
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <b><label>Area From: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.area_from"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Area To: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.area_to"/>
                                </div>
                            </div>
                            <hr>

                            <div class="column is-12" > 
                            <b-field v-if="disabled==false" label=" Request Type"  >
                                <b-select class="column is-6" v-model="MainInformation.request_type" placeholder=" Select Request Type " expanded>
                                    <option value="rental">Rental</option>
                                    <option value="resale">Resale</option>
                                    <option value="new_home">New Home</option>
                                    <option value="land">Land </option>


                                </b-select>
                           </b-field>

                            </div>
                            <div v-if="disabled=disabled" class="column is-12">
                                <b><label>Request Type: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.request_type"/>
                                </div>
                            </div>
                            <hr>

                            <div class="column is-12" > 
                            <b-field v-if="disabled==false" label="  Type"  >
                                <b-select class="column is-6" v-model="MainInformation.type"  placeholder=" Select Type " expanded>

                                    <option value="buyer">Buyer</option>
                                    <option value="seller">Seller</option>
                                  
                                </b-select>
                             </b-field>

                            </div>
                            <div v-if="disabled=disabled" class="column is-12">
                                <b><label>Type: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.type"/>
                                </div>
                            </div>
                            <hr>

                            <div class="column is-12"> 
                         <b-field v-if="disabled==false" label=" Unit Type"  >
                                <b-select  class="column is-6" v-model="MainInformation.unit_type" placeholder=" Select Unit Type " expanded>

                                    <option value="residential">Residential</option>
                                    <option value="rommercial">Commercial</option>
                                    <option value="land">Land </option>

                                </b-select>
                           </b-field>

                            </div>
                            <div v-if="disabled=disabled" class="column is-12">
                                <b><label>Unit Type: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.unit_type"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Rooms From: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.rooms_from"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Rooms To: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.rooms_to"/>
                                </div>
                            </div>
                            <hr>
                           <div class="column is-12">
                                <b><label>Bathrooms From: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.bathrooms_from"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Bathrooms To: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.bathrooms_to"/>
                                </div>
                            </div>
                            <hr>
                              <div class="column is-12">
                                <b><label>Location On Map: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.location"/>
                                </div>
                            </div>
                            <hr>
                               <div class="column is-12">
                                <b><label>Delivery Date: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.date"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Down Payment: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.down_payment"/>
                                </div>
                            </div>
                            <hr>
                            <div v-if="disabled=disabled" class="column is-12">
                                <b><label>Project: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.project"/>
                                </div>
                            </div>
                            <hr>

                             <div v-if="disabled==false" class="column is-12">
                                <b><label>Project: </label></b>
                                <div class="column is-6">
                                <b-select v-model="project" expanded>
                                    <option v-for="project in projects " :value="project.id">{{project.name}}</option>
                                </b-select>    
                                </div>
                            </div>
                            <hr>

                             <div class="column is-12">
                                <b><label>Notes: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="MainInformation.notes"/>
                                </div>
                            </div>
                            <hr>
                        
                     
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateRequest">Edit</button>

                        </div>
                </div> 
                </section>
            </div>
        </div>
    </div>

            </b-tab-item>
                 <!-- end tap mainInformation -->
                 <!-- tap suggitions -->

            <b-tab-item label="Suggestions">
                <section class="Suggestions">
      
            <b-field class="search" label="Search">
                   <b-input @input="filterSuggestions" v-model="search_query" type="text"></b-input>
            </b-field> 
        <div style="clear:both"> </div>
  
        <b-table
            :data="suggestions" 
            :paginated="isPaginated"
            :per-page="perPage"
            :current-page.sync="currentPage"
            :pagination-simple="isPaginationSimple"
            :pagination-position="paginationPosition"
            :default-sort-direction="defaultSortDirection"
            default-sort="user.id"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page">

            <template slot-scope="props">
               

                <b-table-column class="padding"  label="Title" sortable>
                    {{ props.row.title }}
                </b-table-column>
                
                 <b-table-column class="padding"  label="Location On Map" sortable>
                    {{ props.row.location }}
                </b-table-column> 
                
                 <b-table-column class="padding"  label="Price" sortable>
                    {{ props.row.price }}
                </b-table-column>

                 <b-table-column class="padding"  label="Rooms" sortable>
                    {{ props.row.rooms }}
                </b-table-column>

                 <b-table-column class="padding"  label="Bathrooms" sortable>
                    {{ props.row.bathrooms }}
                </b-table-column>

                 <b-table-column class="padding"  label="Area" sortable>
                    {{ props.row.area }}
                </b-table-column>

                <b-table-column class="padding"  label="Delivery Date" sortable>
                    {{ props.row.date }}
                </b-table-column>

                 <b-table-column class="padding" field="" label="Show" sortable >
                    <button class="button is-primary is-medium">   
                        <router-link style="color:white" :to="'/admin/vue/showProject/'+props.row.id" > Show</router-link>  
                     </button>
                </b-table-column>

            </template>
            <template slot="empty" v-if="!isLoading && isEmpty">
                        <section class="section">
                            <div class="content has-text-grey has-text-centered">
                                <p>
                                    <b-icon
                                    icon="emoticon-sad"
                                    size="is-large">
                                </b-icon>
                            </p>
                            <p>Nothing here.</p>
                        </div>
                    </section>
                    <hr>
                </template>
        </b-table>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </section>
         
            </b-tab-item>
           
        </b-tabs>
        </div>
    </section>
</template>
<script>
import {ShowMeRequest,updateMeeting,getRequestSuggestions,filterSuggestions,updateRequest,getAllProjects,getAllLeads} from './../../calls'

export default {
    data() {
            return {
                activeTab:0,
                disabled:true,
                MainInformation:{},
                suggestions:{},
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                perPage: 100,
                isLoading: true,
                isFullPage: true,
                selectedagent_type: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                paginationPosition: 'bottom',
                currentPage: 1,
                search_query:'',
                requests:{},
                projects:[],
                leads:[],

                id:null
               
            }
        },
        mounted() {
            this.getData()
            this.getsuggestions()
            this.getAllProjects()
            this.getAllLeads()
        },
        components: {
        
        },
        created() {
            this.id = this.$route.params.id
         },
          methods: {

            getData(){
                this.isLoading = true
                ShowMeRequest(this.id).then(response=>{
                console.log('sssssssssss',response)
                this.MainInformation = response.data
                console.log("somayaaa",this.MainInformation)
                // this.agent = response.data.agent
                // this.lead_id = response.data.lead
                console.log('ttttttttt',this.MainInformation)
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },

         getsuggestions(){
                this.isLoading = true
                getRequestSuggestions().then(response=>{
                console.log('wwwwwwwwww',response)
                this.suggestions = response.data
                console.log("wwwwwwww",this.suggestions)
                console.log('ttttttttt',this.suggestions)
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
        getAllProjects()
        {
            this.isLoading = true
                getAllProjects().then(response=>{
                this.projects = response.data
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
                 
        },
             getAllLeads()
        {
            this.isLoading = true
                getAllLeads().then(response=>{
                this.leads = response.data
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
                 
        },

         filterSuggestions(){
        var data ={
            'searchInput':this.search_query,
            '_token':this.token,
        };
        filterSuggestions(data).then(response=>{
            this.suggestions = response.data
        })
    .catch(error => {
        console.log(error)
        })
    },
    toggleInputsActive(){
             this.disabled = !this.disabled
        },

      updateRequest(){
            const bodyFormData = new FormData();
            for(let key in this.MainInformation){
                const value = this.MainInformation[key];
                bodyFormData.set(key,value);
            }
            bodyFormData.append('_method','put')
            updateRequest(bodyFormData,this.id).then(response=>{
                // console.log("iddddddd",this.id)
              console.log("Request update",response)
            //   $(location).attr('href', '/admin/vue/AllRequests')
            }).catch(error=>{
                console.log(error)
            })
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
                    message: 'Request '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
}
}
</script>

<style>
.title
{
    font-size: 24px;
    font-weight: bold;
    margin: 20px;
    margin-left: 30px;
}
.table
{
    margin-left: 30px;
    margin-right: 50px;
}

.padding
{
width:496.01px;
}

.search
{
    width: 10%;
    float: right;
    margin-right: 50px;
    margin-bottom: 0px;

}
.tabs li 
{
        margin-left: 50px;
}
.is-active
{
     font-weight: bold;
}
.tabs li.is-active a{
    color: black;
}
.parent
{
    background-color:white;
    margin-right: 20px;
    margin-left: 20px;
}
</style>
