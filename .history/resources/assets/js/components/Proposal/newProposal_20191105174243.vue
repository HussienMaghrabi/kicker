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
                        <b-select v-model="companyId" placeholder="Select Companies" expanded>
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
                    <b-select v-model="proposed.leadcontactid" placeholder="Select Contact Person"  expanded>
                        <option v-for="contact in LeadContact" :key="contact.id" :value="contact.id">{{ contact.first_name+' '+ contact.last_name }}</option>
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
            <b-field label="Add Proposal introduction">
                <b-switch v-model="proposed.introduction"
                    true-value="1"
                    false-value="0">
                    {{ proposed.introduction }}
                </b-switch>
            </b-field>
            <b-field label="Closing">
                <b-switch v-model="proposed.closing"
                    true-value="1"
                    false-value="0">
                    {{ proposed.closing }}
                </b-switch>
            </b-field>
                <!-- <b-checkbox v-model="">Add Proposal introduction</b-checkbox><br> -->
                <!-- <b-checkbox>Add Proposal Closing</b-checkbox><br> -->
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">This Proposal valid until</h6>
                <b-field class="column is-4">
                    <b-datepicker v-model="proposed.valid_until" icon="calendar-today"></b-datepicker>
                </b-field>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Proposal Currency</h6>
                <b-field>
                    <!-- <label  class="column is-8">Currency</label> -->
                    <b-select v-model="proposed.currency_id" placeholder="Select Currency" expanded>
                        <option v-for="currency in CompanyCurrency" :key="currency.id" :value="currency.id">{{ currency.currName }}</option>
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

        <!-- new items section -->
        <div class="columns is-12">
            <div class="column is-12">
                <table class="responsive-table">
                    <thead>
                    <tr style="background-color:#F6F6F6;height:50px">
                        <th style="width:32%;padding-left:2%">Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th style="width:10%">Subtotal</th>
                        <th scope="col">Discount</th>
                        <th></th>
                        <th style="width:10%">Line Total</th>
                        <th></th>
                    </tr>
                    </thead><br>
                    <tr  v-for="(invoice,index) in invoices" :key="index">
                        <td>
                            <b-field>
                                <b-select v-model="invoices[index].itemId" placeholder="Select item"  expanded >
                                <option  v-for="item in items" :key="item.id" :value="item.id">{{ item.name }}</option>
                                </b-select>
                                <!-- <i class="fas fa-edit" @click="isComponentItemActive = true" style="font-size:23px;cursor:pointer;margin-left:1%"></i> -->
                            </b-field>
                        </td>
                        <td>
                            <div class="cell-with-input"><b-input type="number" min="0" v-model="invoices[index].itemQuantity"/></div>
                        </td>
                        <td>
                            <div class="cell-with-input"><b-input type="number" min="0"  v-model="invoices[index].itemPrice"/></div>
                        </td>
                        <td>
                            <!-- <div class="cell-with-input"><strong>{{ invoices[index].itemQuantity * invoices[index].itemPrice }}</strong></div> -->
                            <strong>{{ invoices[index].subTotal = invoices[index].itemQuantity * invoices[index].itemPrice }}</strong>
                        </td>
                        <td>
                            <!-- <b-input type="number" placeholder="Value" min="0"  readonly v-model="invoices[index].discountValue" :value="invoices[index].itemPrice - invoices[index].discount / 100"/> -->
                            {{invoices[index].discountValue = invoices[index].discount / invoices[index].subTotal * 100 }} %
                        </td>
                        <td>
                            <b-input type="number" placeholder="Value of discount" min="0" @input="ChangeDiscount"  v-model="invoices[index].discount"/>
                        </td>
                        <td class="text-right"> 
                            {{ invoices[index].total =  invoices[index].subTotal - invoices[index].discount}}
                        </td>
                        <td>
                            <i @click="deleteRow(idex, invoice)" class="fas fa-trash-alt" style="cursor:pointer"></i>
                        </td>
                        <hr>
                        <!-- total -->
                    </tr>
                </table>
                <b-button type="is-info"  @click="AddInvoicefield" style="margin-top:10px;margin-bottom:2%"><i class="fas fa-plus-square"></i>&nbsp; Add item</b-button>

            <!-- div total -->
                <div class="columns is-12">
                    <div class="column is-12">
                        <h6 style="font-weight:700">PAYMENT:</h6>
                        <div class="column is-5">
                            <b-input type="textarea" v-model="payment"></b-input>
                        </div>

                        <div class="column is-7">
                            <h6>Subtotal {{ invoices.total }}</h6><br>
                        </div>

                        <div class="columns is-12">
                            <div class="column is-1">
                                <h6>Discount</h6>
                            </div>
                            <div class="column is-2">
                                <b-input type="number" placeholder="Value" min="0"/>
                            </div>
                            <div class="column is-2">
                                <b-input type="text"/>
                            </div>
                            <div class="column is-1">
                                <h6 style="color:red">Total {{ invoices.total }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end div total -->

            </div>
        </div>
        <!-- end items section -->
        <!-- begin Policy modal -->

        <b-modal :active.sync="isComponentModalActive" has-modal-card>
            <div class="modal-card" style="width: 400px">
                <header class="modal-card-head">
                    <p class="modal-card-title">Kickers</p>
                </header>
                <section class="modal-card-body">
                    <b-field>
                        <b-input v-model="policy" type="textarea"></b-input>
                    </b-field>
                    <span @click="GetPolicy" style="color:rgb(100, 136, 213);cursor:pointer">Restore Default policy</span>
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
            <b-button @click="StoreNewprop" type="is-info" style="margin-right:2%"> <i class="fas fa-save"></i> Save </b-button>
            <b-button @click="ClearAll" type="is-danger">Cancel</b-button>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>

<script>

import { 
    getAllCompanies,
    getAllProposalCompanies,
    getAllContactPerson,
    getAllCurrencyCo,
    Getproposed,
    addNewProposal,
    getAllItem,
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
            companyId:'',
            PropsedCompanyId:null,
            proposed:[],
            CompanyCurrency:[],
            isFullPage: true,
            isLoading:true,
            policy:'',
            invoices: [],
            items:[],
            choseItem:[],
            isComponentItemActive:false,
        }
    },
    watch:{
        'contactlead': function(newId, oldId){
            // console.log('lead_id',newId)
            this.getLeadContact(newId)
        },
        'companyId': function(newId, oldId){
            // console.log('lead_id',newId)
            this.AllCurrencyForCompany(newId)
            this.getItems(newId)
            this.PropsedCompanyId = newId
        },
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
        getItems(companyId){
            getAllItem(companyId).then(response=>{
                // console.log(response)
                this.items = response.data.data
            }).catch(error=>{
                console.log(error)
            })
        },
        getAllCompanies(){
            getAllProposalCompanies().then(response=>{
                console.log('All response',response.data.data.company)
                this.AllCompanies = response.data.data
                console.log('Log companies',this.AllCompanies)
            })
        },
        AllCurrencyForCompany(companyId){
            this.proposed.companyId = companyId
            getAllCurrencyCo(companyId).then(response=>{
                this.CompanyCurrency = response.data.data
            }).catch(error=>{
                console.log(error)
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
            getAllContactPerson(newId).then(response=>{
                this.LeadContact = response.data.data
            }).catch(error=>{
                console.log(error)
            })
        },
        GetPolicy(){
            this.isLoading = true
            Getproposed(this.PropsedCompanyId).then(response=>{
            this.isLoading = false
                this.policy = response.data.data
            }).catch(error=>{
                console.log(error)
            })
        },
        ClearAll(){
            // console.log('All proposed =',this.proposed)
            this.isLoading = true
            this.proposed = []
            this.policy = ''
            this.contactlead = ''
            this.companyId = ''
            this.isLoading = false
        },
        StoreNewprop(){
            const bodyFormData = new FormData();
            for (let key in this.proposed) {
                const value = this.proposed[key];
                bodyFormData.set(key, value);
            }
            bodyFormData.append('items',JSON.stringify(this.invoices))
            bodyFormData.append('policy',this.policy)
            addNewProposal(bodyFormData).then(response=>{
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
        },
        AddInvoicefield(){
            this.invoices.push({
                itemQuantity: '',
                itemPrice: '',
                discountValue: '',
                total: '',
                discount: ''
            });
        },
        deleteRow(index, invoice) {
            var idx = this.invoices.indexOf(invoice);
            //   console.log(idx, index);
            if (idx > -1) {
                this.invoices.splice(idx, 1);
            }
        },
        EditItem(itemId){
            console.log('Item id',itemId)
        },
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