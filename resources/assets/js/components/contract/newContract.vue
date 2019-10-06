<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <h3 style="font-size:21px;margin-bottom:32px">New Contract</h3>
           <div class="columns is-12">
            <div class="column is-10"></div>
           <div class="column is-1">
               <b-button class="save" type="is-info" @click="addNewContract"><i class="fas fa-save"></i>&nbsp; Save</b-button>
           </div>
           <div  class="column is-1">
               <b-button class="cancel" type="is-danger" style="margin-right:2%"><i class="fas fa-ban"></i>&nbsp; Cancel</b-button>
           </div>
        </div>
        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000;margin-left:3%" class="newcontract">Contract Data</h4>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
          <div class="column is-1"></div>
            <div class="column is-5">
                <b-field>
                   <label  class="column is-4">*Proposed Company</label>
                   <div class="select" style="width:100%">
                        <select style="width:100%" v-model="company_id">
                            <option v-if="propCompany" v-for="proposedCompany in proposedCompanies" :key="proposedCompany.id" :value="proposedCompany.id">{{ proposedCompany.name }}</option>
                        </select>
                   </div>
                </b-field>

                <b-field>
                    <label class="column is-4">Lead</label>
                    <div class="select" style="width:100%">
                        <select style="width:100%" v-on:change="getLeadContacts($event.target.value)">
                            <option v-for="lead in leads" :key="lead.id" :value="lead.id">{{ lead.name }}</option>                           
                        </select>
                    </div>
                </b-field>

                <b-field>
                    <label class="column is-4">Contact</label>
                    <b-select expanded style="margin-right:1%" v-model="contact_id">
                       <option v-for="leadContact in leadContacts" :value="leadContact.id">
                            {{ leadContact.first_name + ' ' + leadContact.last_name }}
                        </option>
                    </b-select>
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addContractField"></span> 
                </b-field>

                <b-field v-if="indexContract > 0" v-for="(contract, indexContract) in contracts" :key="indexContract">
                    <label class="column is-4">Contact</label>
                    <b-select expanded style="margin-right:1%" v-model="newConract">
                        <option v-for="leadContact in leadContacts" :value="leadContact.id">
                            {{ leadContact.first_name + ' ' + leadContact.last_name }}
                        </option>
                    </b-select>
                          <span><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeContractField(indexContract,contract)"></span> 
                </b-field>

                <b-field>
                    <label class="column is-4">Proposal</label>
                    <div class="select" style="width:100%">
                        <select style="width:100%" v-model="proposal_id">
                            <option value="727" selected>727</option>
                            <option value="800">800</option>
                        </select>
                    </div>
                </b-field>

                <b-field>
                    <label  class="column is-4">Contract Date</label>
                    <b-datepicker
                        placeholder="Click to select..."
                        :date-formatter="dateFormatterFrom"
                        v-model="date"
                        icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>
        </div>

        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000;margin-left:3%">Contract Sections</h4>
        </div>
        
          <b-modal :active.sync="isComponentModalActive" has-modal-card>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add Contract Section</p>
                    </header>
                    <section class="modal-card-body">
                        <b-field label="English Description">
                            <b-input type="textarea" v-model="en_description"></b-input>
                        </b-field>
                        <b-field label="Arabic Description">
                            <b-input type="textarea" v-model="ar_description"></b-input>
                        </b-field>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button" type="button" @click="isComponentModalActive = false"><i class="fas fa-ban"></i>&nbsp; Close</button>
                        <b-button type="is-success" @click="addContractSection"><i class="fas fa-save"></i>&nbsp; Save</b-button>
                    </footer>
                </div>
            </b-modal>

        <div class="columns is-12" style="margin-top:4%">
            <div class="column is-6" style="margin-right:2%">
                <h3 style="text-align:center">Available Sections</h3>
                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <p style="display:initial">Create New Section</p>
                    <i class="fas fa-plus" style="float:right;cursor:pointer" @click="openModal()"></i> 
                </div>
                <draggable  @start="drag=true" @end="drag=false"  group="contract"  ghost-class="ghost"> 
                </draggable>

            </div>

            <div class="column is-6">
                <h3 style="text-align:center">Contract Sections</h3>
                <draggable  @start="drag=true" @end="drag=false"  group="contract"  ghost-class="ghost"> 
                    
                </draggable>           

            </div>
        </div>

        <div class="columns is-12" style="float:right">
            <div class="column is-10"></div>
           <div class="column is-1">
               <b-button class="save2" type="is-info"><i class="fas fa-save"></i>&nbsp; Save</b-button>
           </div>
           <div  class="column is-1">
               <b-button class="cancel2" type="is-danger" style="margin-right:2%"><i class="fas fa-ban"></i>&nbsp; Cancel</b-button>
           </div>
        </div>

    </div>
</template>

<style>
@media screen and (max-width: 767px)
{
   .newcontract
   {
       margin-top: 50px;
   }
   .field.has-addons 
   {
       display:unset;
   }
   .save
   {
       float: right;
   }
   .cancel{
       margin-left: 45%;
       margin-top: -1%;
   }
   .save2
   {
       float: right;
       margin-bottom: 20px;
   }
   .cancel2
   {
       margin-left: 46%;
       margin-top: -1%;
   }


}
.ghost {
  opacity: 0.2;
  background-color: #7ad0f8;
}
</style>

<script>
import Vue from 'vue'
import draggable from 'vuedraggable'
import {addContract,addContractSection,getProposedCompanies,getNewLeads,getleadContact} from './../../calls'

export default {
      data() {
        return {
             contracts:[{
                newContract:''
            }],
             token: window.auth_user.csrf,
             contact_id:null,
             company_id:null,
             proposal_id:null,
             section_id:null,
             date:null,
             isComponentModalActive:false,
             en_description:null,
             ar_description:null,
             proposedCompanies:[],
             user_id: window.auth_user.id,
             leads:[],
             leadContacts:[],
        }
      },
    components: {
        draggable
    },
    mounted(){
        this.getALlProposedCompany()
        this.getALlLeads()
    },
  methods: {
        addContractField(){
                this.contracts.push({
                newConract: '',
            });
        },
        removeContractField(indexContract,contract){
            var idx = this.contracts.indexOf(contract);
            console.log(idx, indexContract);
            if (idx > -1) {
                this.contracts.splice(idx, 1);
            }
        },
        getALlProposedCompany(){
            getProposedCompanies().then(response=>{
                // console.log("all proposed",response)
                this.proposedCompanies = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        getALlLeads(){
            getNewLeads().then(response=>{
                console.log("all Leads",response)
                this.leads = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        addNewContract(){
            var data ={
            '_token':this.token,
            'contact_id':this.contact_id,
            'company_id':this.company_id,
            'proposal_id':this.proposal_id,
            // 'section_id':this.section_id,
            'date':this.date,
            };
            console.log('new add',data)
            addContract(data).then(response=>{
                this.success("Added")
                // $(location).attr('href', '/admin/vue/allContract')
            })
            .catch(error => {
                    console.log(error)
            })
        },
        success(action) {
            this.$toast.open({
                message: 'Contract '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        dateFormatterFrom(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.due_date = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        openModal(){
            this.isComponentModalActive = true
        },
        addContractSection(){
            var data ={
            // '_token':this.token,
            'en_description':this.en_description,
            'ar_description':this.ar_description,
            'title':this.title,
            'user_id':this.user_id,
            'proposed_company_id':this.company_id
            };
            console.log('new add',data)
            addContractSection(data).then(response=>{
                alert('Contract Section Added Successfully')
                // $(location).attr('href', '/admin/vue/allContract')
            })
            .catch(error => {
                    console.log(error)
            })
        },
        getLeadContacts(value){
            this.isLoading = true
            var lead_id = value
            console.log('lead is',lead_id);
            getleadContact(lead_id).then(response=>{
                // console.log("job titles",response)
                this.leadContacts = response.data
                // console.log('deeep job title',this.jobTitles)
        })
        .catch(error => {
            console.log(error)
        })
        this.title = true
    },
  }
}
</script>