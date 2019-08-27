<template>
  <div>

                                  
                                    <div class="column is-2">
                                        <label class="label">Location</label>
                                        <div class="field has-addons">
                                            
                                            <div class="control is-expanded"> 
                                                <div class="select is-fullwidth">
                                                    <select v-model="filter.location">
                                                        <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                                                 </select>
                                                </div>
                                          </div>
                                          
                                        </div>
                                        
                                    </div>
                                    <br>
                                    <div class="column is-2">
                                        <label class="label">projects</label>
                                        <div class="field has-addons">
                                          
<!--                                             <div v-for="project in test">{{ project.en_name }}</div>
 -->                                            <div class="control is-expanded"> 
                                                <div class="select is-fullwidth">
                                                    <select v-model="filter.test">
                                                        <option v-for="project in test"> 
                                                         {{project.ar_name}}
                                                        </option>
                                                 </select>
                                                </div>
                                          </div>
                                           
                                        </div>
                                        
                                    </div>
                                    <br> 
                                    <div class="column is-2">
                                        <label class="label">unit_type</label>
                                        <div class="field has-addons">
<!--                                             <div v-for="project in test">{{ project.en_name }}</div>
 -->                                            <div class="control is-expanded"> 
                                                <div class="select is-fullwidth">
                                                    <select v-model="filter.unit_type">
                                                        <option v-for="unit_typee in unit_type"> 
                                                         {{unit_typee.ar_name}}
                                                        </option>
                                                 </select>
                                                </div>
                                          </div>
                                         <div class="control">
                                                <a class="button is-success" @click="filterLeads">Get</a>
                                            </div>
                                        </div>
                              </div>
<table class='table'>
  <thead class='thead-dark' v-if='items.length>0'>
    <th> id</th>
    <th> availability</th>
    <th> price</th>
    <th> location</th>
    <th> bathrooms</th>
    <th> area</th>
  </thead>
  <tbody>
    <tr v-for="item in items">
      <td v-model='id'>{{ item.id }}</td>
      <td v-mpdel='availability'>{{ item.availability }}</td>
      <td v-model='price'>{{ item.price }}</td>
      <td v-model='location'>{{ item.location }}</td>
      <td v-model='rooms'>{{ item.rooms }}</td>
      <td v-model='bathrooms'>{{ item.bathrooms }}</td>
      <td v-model='area'>{{ item.area }}</td>
    </tr>
 </tbody>
</table>
                                
</div>
</template>


        


<script>
import { myVar} from './Unit.vue'
import Unit from './Unit';
import {getPublicData,newResaleFilter,displayTable} from './../../calls'
    export default {
      data() {
            return {
                newCallData: {date: new Date()},
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                getLeadsByAgent: [],
                leadSources: [],
                come:true,
                // leads: [],
                items:[],
                item:{
                  id:0,
                  availability:'',
                  price:0,
                  location:0,
                  rooms:0,
                  bathrooms:0,
                  area:0
                },
                isEmpty: false,
                isLoading: true,
                hasMobileCards: true,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                roow:{},
                total: 0,
                page: 1,
                perPage: 10,
 
                isLoading: true,
                isFullPage: true,
                searchInput: '',
                selectedLeads: [],
                
                ShowHint: false,
                hintId: '',
                callStatus: [],
                projects: [],
                meetingStatus:[],
                filter: {},
                startFilter: false,
               
                switchLeadModel: false,
                bulkActionModel: false,
                switchLeadData: {},
                leadsIds: [],
                commercialAgents: [],
                residentialAgents: [],
                permArray: [],
                reloadData: false,
                //
                unit_type:[],
                locations: [],
                test:{},
                //projects:[],
                //project:{
                 // en_name:'',
                  //id:'',
                //},
                
                
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
              
        
      }},    created() {
        
              //this.getSources()
              //this.newResaleFilter()
              this.getPublic()
        },

         methods: {

          filterLeads(scrollSwitch = false){
                //this.isLoading = true
                //this.fitlerFlag = true
                var data ={
                    //'leadSources':this.filter.sourceId,
                    'location':this.filter.location,
                    //'meetingStatus':this.filter.meeting_status_id,
                    //'callStatus':this.filter.call_status_id,
                    //'dateTo':this.parsedDateTo,
                    //'dateFrom':this.parsedDateFrom,
                    '_token':this.token,
                    'agent_id':this.userId,
                };
                newResaleFilter(this.page,data).then(response=>{
                    Unit.data.ddisplay=displayTable(false);
                    console.log('test_mass');
                    console.log(Unit.data.ddisplay);
                    this.items = response.data.data
                    if(this.items.length>0){
                       // Unit.display=false;
                    }
                    
                    console.log(this.leads)
                    this.leadsCurrentNumber = this.roow.length
                    this.leadsTotalNumber = response.data.total
                    
                    if(this.roow.length == 0){
                        this.isEmpty = true
                    }
                    let currentTotal = response.data.total
                        if (response.data.total / this.perPage > 1000) {
                            currentTotal = this.perPage * 1000
                        }
                    this.total = currentTotal
                    this.isLoading = false
                    
                })
                .catch(error => {
                    console.log(error)
                })
            },

            getPublic(){
              console.log('55');
                getPublicData().then(response=>{
                    //console.log(typeof(response.data))

                    
                    
                    //this.unit_type = response.data

                    console.log(this.projects)
                    // for (var i =0 ; i <this.test.length; i++) {
                    //   console.log(this.test[i]['en_name'])
                    // }
                    this.locations = response.data.locations
                    console.log(this.locations = response.data.locations)
                    this.unit_type = response.data.unit_type
                    this.test = response.data.projects
                    //this.unit_type = response.data.unit_type
                })
                .catch(error => {
                    console.log(error)
                })
            },
           
            // filterLeads(scrollSwitch = false){
            //     this.isLoading = true
            //     this.fitlerFlag = true
            //     var data ={
            //         'leadSources':this.filter.sourceId,
            //         'location':this.filter.location,
            //         'meetingStatus':this.filter.meeting_status_id,
            //         'callStatus':this.filter.call_status_id,
            //         'dateTo':this.parsedDateTo,
            //         'dateFrom':this.parsedDateFrom,
            //         '_token':this.token,
            //         'agent_id':this.userId,
            //     };
                
                    
                
     },filters:{
        jsontest($value){
          return JSON.stringify($value);
        }
        }
     }
      // }
    
</script>

