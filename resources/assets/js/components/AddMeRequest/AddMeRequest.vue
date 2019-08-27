<template>
<div > 
    <section class="container style">
     
      <b-field label=" Lead">
            <b-select v-model="lead_name" expanded>
                <option v-for="lead in leads" :value="lead.id">{{ lead.first_name +' '+lead.last_name}}</option>
            </b-select>    
      </b-field>
      <b-field label="Location On Map">
           <b-select v-model="location" expanded>
                <option v-for="location in locations" :value="location.id">{{location.name}}</option>
            </b-select>    
      </b-field>
       <b-field label="Buyer Or seller">
            <b-select v-model="buyer_seller"  expanded>
                <option>Buyer</option>
                <option>Seller</option>

            </b-select> 
      </b-field>
       <b-field label="Unit Type">
            <b-select v-model="unit_type" expanded>
                <option value="commercial">Commercial</option>
                <option value="personal">Residential</option>

            </b-select> 
      </b-field>
      <b-field label="Unit Types">
            <b-select v-model="unit_type_id" expanded>
                <option v-for="unit_type_id in allTypes" :value="unit_type_id.id">{{unit_type_id.name}}</option>
            </b-select> 
      </b-field>
       <b-field label="Request Type">
          <b-select v-model="request_type" expanded>
                <option >Resale</option>
                <option >Rental</option>
                <option >New Home</option>
                <option >Land</option>

            </b-select> 
      </b-field>
      <b-field label="Price From">
            <b-input v-model="price_from" type="number" ></b-input>
      </b-field>
       <b-field label="Price To">
            <b-input v-model="price_to" type="number" ></b-input>
      </b-field>
      <b-field label="area From">
            <b-input v-model="area_from" type="number"></b-input>
      </b-field>
      <b-field label="Area To">
            <b-input v-model="area_to" type="number"></b-input>
      </b-field>
      <b-field label="Developer">
          <b-select v-model="developers" expanded>
                <option v-for="developers in allDevelopers" :value="developers.id">{{developers.name}}</option>

            </b-select> 
      </b-field>
       <b-field  label="Delivery Date">
        <b-datepicker
            v-model="date"
            icon="calendar-today">
        </b-datepicker>
     </b-field>
     <b-field label="Down Payment">
            <b-input v-model="payment" type="number"></b-input>
      </b-field>
    
      <b-field label="Notes"
            :label-position="labelPosition">
            <b-input v-model="notes" maxlength="200" type="textarea"></b-input>
     </b-field>
        
        
         <button class="button is-primary" @click="AddMeRequest" >submit</button>
   </section>

</div>
</template>


<script>
import {AddMeRequest,getMeRequestInputs,getAllLocations,getAllDevelopers,getUnitTypeSelection,getMeetingsInputs} from './../../calls'
export default {
    data() {
            return {
                AllMeRequest:{},
                event:false,
                lead_name:null,
                location:null,
                type:null,
                buyer_seller:null,
                unit_type_id:null,
                unit_type:null,
                request_type:null,
                price_from:null,
                price_to:null,
                area_from:null,
                locations:[],
                allDevelopers:[],
                allTypes:[],
                area_to:null,
                developers:null,
                date:null,
                payment:null,
                notes:null,          
                token: window.auth_user.csrf,
                leads:[]
            }},
    mounted() {
        this.getlocations()
        this.getdevelopers()
        // this.getUnitTypeSelection()
        this.getLeadData()
        this.getData()
    },
    watch:{
        'unit_type': function()
        {
                this.getUnitTypes()

        }
 
    },
 methods: {

          getlocations(){
              getAllLocations().then(response=>{
                console.log(response)
                this.locations = response.data
            })
            .catch(error => {
                console.log(error)
            })
          },
            getdevelopers(){
              getAllDevelopers().then(response=>{
                console.log("locations",response)
                this.allDevelopers = response.data
            })
            .catch(error => {
                console.log(error)
            })
          },
          getUnitTypes(){
              var data ={
                '_token':this.token,
                'unit_type':this.unit_type,     
            
            };
              getUnitTypeSelection(data).then(response=>{
                // console.log("locations",response)
                this.allTypes = response.data
            })
            .catch(error => {
                console.log(error)
            })
          },
         Toggle(event)
         {
              this.event=!this.event ;
         },

  getData(){
            this.isLoading = true
            getMeRequestInputs().then(response=>{
                console.log(response)
                this.AllMeRequest = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
  getLeadData(){
        this.isLoading = true
        getMeetingsInputs().then(response=>{
            this.leads = response.data.leads
        })
        .catch(error => {
            console.log(error)
        })
        this.isLoading = false
    },
    AddMeRequest(){
        var data ={
            '_token':this.token,
            'lead':this.lead_name,
            'location':this.location, 
            'buyer_seller':this.buyer_seller,
            'unit_type_id':this.unit_type_id,
            'unit_type':this.unit_type,
            'request_type':this.request_type,
            'price_from':this.price_from,
            'price_to':this.price_to,
            'area_from':this.area_from,
            'area_to':this.area_to,
            'date':this.date,
            'down_payment':this.payment,
            'developers':this.developers,
            // 'type':this.type,
            'notes':this.notes,          
           
        };
        AddMeRequest(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/AllRequests')
        })
        .catch(error => {
                this.errorDialog()
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
 },
}
</script>
<style>
.style
{
    background-color: white;
    padding: 20px;
}
</style>

