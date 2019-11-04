<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <h1 style="margin-bottom:2%">New Proposal</h1>
        <div class="columns is-12" style="padding-left:10%">
            <div class="column is-3">
                <h6>Proposal NO</h6>
            </div>
            <div class="column is-9" style="display:-webkit-inline-box;margin-bottom:2%">
                <h6 style="color:red;margin-right:1%">*Proposed Company</h6>
                <div class="field">
                    <div class="select">
                        <b-select v-model="proposed.companyId" placeholder="Select Companies" expanded>
                            <option v-for="company in AllCompanies" :key="company.id" :value="company.id">{{ company.name }}</option>
                        </b-select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12">
                <h6 style="color:#bbb;">Proposal To</h6><hr>
            </div>
        </div>

        <!-- <div class="columns is-12">
            <div class="column is-12" style="display:-webkit-inline-box;padding-left:10%">
                <h6 style="color:red;margin-right:1%" class="column is-2">*Company Name</h6>
                <div class="field column is-8">
                     <div class="select" style="width:100%">
                        <select v-model="companyId" placeholder="Select Event" expanded v-on:change="getAllContactPersonById($event.target.value)">
                         <option v-for="company in companies" :value="company.id" :key="company.id" >{{company.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div> -->


        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2"  style="color:red;margin-right:1%" >*Company Name</h6>
                <b-field>
                    <!-- <label  class="column is-8">Currency</label> -->
                    <b-select v-model="contactlead" placeholder="Select Companies leads" expanded>
                        <option v-for="lead in AllcompanyLeads" :key="lead.id" :value="lead.id">{{ lead.name }}</option>
                    </b-select>
                </b-field>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2"  style="color:red;margin-right:1%" >*Contact Person</h6>
                <b-field>
                    <!-- <label  class="column is-8">Currency</label> -->
                    <b-select placeholder="Select Contact Person"  expanded>
                        <option value="Contact1">Contact 1</option>
                        <option value="Contact1">Contact 2</option>
                    </b-select>
                </b-field>
            </div>
        </div>


        <div class="columns is-12">
            <div class="column is-12">
                <h6 style="color:#bbb;">Proposal Options</h6><hr>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;">
                <b-checkbox >Add Proposal introduction</b-checkbox><br>
                <b-checkbox>Add Proposal Closing</b-checkbox><br>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">This Proposal valid until</h6>
                <b-field class="column is-4">
                    <b-datepicker icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Proposal Currency</h6>
                <b-field>
                    <!-- <label  class="column is-8">Currency</label> -->
                    <b-select placeholder="Select Currency" expanded>
                        <option value="EG">EG</option>
                        <option value="usd">USD</option>
                    </b-select>
                </b-field>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Policy</h6>
                <span class="column is-8"  style="color:rgb(100, 136, 213);cursor:pointer" @click="isComponentModalActive = true">Edit policy for this proposal</span>
            </div>
        </div>

        <!-- begin Policy modal -->

        <b-modal :active.sync="isComponentModalActive" has-modal-card>
            <div class="modal-card" style="width: 400px">
                <header class="modal-card-head">
                    <p class="modal-card-title">Kickers</p>
                </header>
                <section class="modal-card-body">
                    <b-field>
                        <b-input type="textarea"></b-input>
                    </b-field>
                    <span style="color:rgb(100, 136, 213);cursor:pointer">Restore Default policy</span>
                </section>
                <footer class="modal-card-foot">
                    <b-button type="is-info"><i class="fas fa-save"></i>&nbsp; Save</b-button>
                    <button class="button" type="button" @click="isComponentModalActive = false">Cancel</button>
                </footer>
            </div>
        </b-modal>

        <!--  end Policy modal -->

        <div class="columns is-12">
            <div class="column is-12">
                <h6 style="color:#bbb;">Proposal Quotations</h6><hr>
            </div>
        </div>

        <div class="columns is-12" style="margin-top:3%">
            <b-button type="is-info" style="margin-right:2%">
                <i class="fas fa-save"></i>
                Save
            </b-button>.
            <b-button type="is-danger">Cancel</b-button>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>

<script>

import { 
    getAllCompanies,
    getAllProposalCompanies,
    getContactConpany
} from "./../../calls";
export default {
    data() {
        return {
            AllCompanies:[],
            CompanyCurncies:[],
            AllcompanyLeads:[],
            LeadContact:[],
            isComponentModalActive:false,
            contactlead:'',
            proposed:[],
            isFullPage: true,
            isLoading:true,
        }
    },
    watch:{
        'contactlead': function(newId, oldId){
            // console.log('lead_id',newId)
            this.getLeadContact(newId)
            console.log(this.proposed)
        }
    },
    created(){},
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
            this.isLoading = false
            this.getAllCompanies()
            this.getCompaniesLead()
        },
        getAllCompanies(){
            getAllProposalCompanies().then(response=>{
                this.AllCompanies = response.data.data
            })
        },
        getCompaniesLead(){
            getAllCompanies().then(response=>{
                this.AllcompanyLeads = response.data.data
            }).catch(error=>{
                console.log(error)
            })
        },
        getLeadContact(newId){
            this.proposed.leadId = newId
            getContactConpany(newId).then(response=>{
                this.LeadContact = response.data.data
            }).catch(error=>{
                console.log(error)
            })
        }
    },
}
</script>

<style>
    h6{
        font-size: 15px;
    }
    td{
        padding-right: 0.5%
    }
    th{
        padding-top: 1%
    }
    .main-content {
        min-height: 100vh;
        padding: 1rem;
        display: flex;
        align-items: center;
    }

</style>