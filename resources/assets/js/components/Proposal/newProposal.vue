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
                        <b-select v-model="proposedCompanyId" placeholder="Select Event" expanded>
                            <option v-for="propCompany in proposedCompanies"  :key="propCompany.id" :value="propCompany.id">{{propCompany.name}}</option>
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
                    <select v-model="companyId" placeholder="Select Company Name" expanded  v-on:change="getAllContactPersonById($event.target.value)" >
                        <option v-for="company in companies" :value="company.id" :key="company.id" >{{company.name}}</option>
                    </select>
                </b-field>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2"  style="color:red;margin-right:1%" >*Contact Person</h6>
                <b-field>
                    <!-- <label  class="column is-8">Currency</label> -->
                    <b-select v-model="contactPersonId" placeholder="Select Contact Person"  expanded>
                        <option v-for="item in contactPersonArr " :key="item.id" :value="item.id" >{{item.first_name+' '+item.last_name}}</option>
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
                    <b-datepicker v-model="validUntil"
                                  icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Proposal Currency</h6>
                <b-field>
                    <!-- <label  class="column is-8">Currency</label> -->
                    <b-select v-model="currencyId" placeholder="Select Currency"  expanded>
                        <option v-for="currency in currencies " :key="currency.id" :value="currency.id" >{{currency.name}}</option>
                    </b-select>
                </b-field>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Policy</h6>
                <span class="column is-8"  style="color:rgb(100, 136, 213);cursor:pointer" @click="openModal">Edit policy for this proposal</span>
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
                        <b-input type="textarea" v-model="policy"></b-input>
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
                    <tr  v-for="(invoice, k) in invoices" :key="k">
                        <td>
                            <b-field>
                                <b-select v-model="invoice.name" placeholder="Select item"  expanded >
                                <option v-for="item in itemsArray" :value="item.id" :key="item.id" >{{item.name}}</option>
                                </b-select>
                                <i class="fas fa-edit" style="font-size:23px;cursor:pointer;margin-left:1%"
                                   @click="openAddItem" ></i>
                            </b-field>

                            <b-modal :active.sync="isComponentItemActive" has-modal-card>
                                <div class="modal-card" style="width: 400px">
                                    <header class="modal-card-head">
                                        <p class="modal-card-title">Add New Item</p>
                                    </header>
                                    <section class="modal-card-body">
                                        <b-field>
                                            <b-input type="textarea" placeholder="Description"></b-input>
                                        </b-field>

                                        <b-field>
                                            <label>Item Specifications</label>
                                        </b-field>

                                        <div class="columns is-12" v-for="(item, k) in items" :key="k">
                                            <div class="column is-5">
                                                <b-field>
                                                    <b-input placeholder="Item Name" v-model="item.newItem"></b-input>
                                                </b-field>
                                            </div>
                                            <div class="column is-5">
                                                <b-field>
                                                    <b-input placeholder="Item Name" v-model="item.newItem"></b-input>
                                                </b-field>
                                            </div>
                                            <div class="column is-2" v-if="k == 0">
                                                <i  @click="AddItemfield" class="fas fa-plus" style="background-color:lightgray;padding:5px;border-radius:50%;cursor:pointer"></i>
                                            </div>

                                            <div class="column is-2" v-if="k > 0">
                                                <img src="/images/remove.png"  style="cursor:pointer" @click="deleteItem(k, item)">
                                            </div>

                                        </div>
                                    </section>
                                    <footer class="modal-card-foot">
                                        <b-button type="is-info"><i class="fas fa-save"></i>&nbsp; Save</b-button>
                                        <button class="button" type="button" @click="isComponentItemActive = false">Cancel</button>
                                    </footer>
                                </div>
                            </b-modal>


                        </td>
                        <td><div class="cell-with-input"><b-input type="number" @input="ChangeInvoice" min="0" v-model="invoice.itemQuantity"/></div></td>
                        <td><div class="cell-with-input"><b-input type="number" min="0" @input="ChangePrice" v-model="invoice.itemPrice"/></div></td>
                        <td>{{ invoice.total }} </td>
                        <td><b-input type="number" placeholder="Value" min="0"  readonly v-model="invoice.discountValue"/></td>
                        <td><b-input type="number" placeholder="Percent %" min="0" @input="ChangeDiscount"  v-model="invoice.discount"/></td>
                        <td class="text-right"> {{ invoice.total }} </td>
                        <td><i @click="deleteRow(k, invoice)" class="fas fa-trash-alt" style="cursor:pointer"></i></td>
                        <hr>
                    </tr>
                </table>
                <b-button type="is-info"  @click="AddInvoicefield" style="margin-top:10px;margin-bottom:2%"><i class="fas fa-plus-square"></i>&nbsp; Add item</b-button>

                <div class="columns is-12" v-if="k == 0" v-for="(invoice, k) in invoices" :key="k">
                    <div class="column is-12">
                        <h6 style="font-weight:700">PAYMENT:</h6>
                        <div class="column is-5">
                            <b-input type="textarea" v-model="payment"></b-input>
                        </div>

                        <div class="column is-7">
                            <h6>Subtotal {{ invoice.total }}</h6><br>
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
                                <h6 style="color:red">Total {{ invoice.total }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <div class="columns is-12" style="margin-top:3%">
            <b-button type="is-info" style="margin-right:2%" v-on:click="addNewProposal">
                <i class="fas fa-save"></i>
                Save
            </b-button>.
            <b-button type="is-danger">Cancel</b-button>
        </div>

    </div>
</template>

<script>
    import {getAllProposedCompany,getAllCompanies,getAllContactPerson,getAllCurrency,addNewProposal,getAllItem} from './../../calls'
    export default {
        data() {
            return {
                policy:null,
                currencies:[],
                Items:[],
                currencyId:null,
                validUntil:null,
                proposedCompanies:[],
                companies:[],
                contactPersonArr:[],
                proposedCompanyId:null,
                companyId:null,
                contactPersonId:null,
                payment:'',
                token: window.auth_user.csrf,
                isComponentModalActive: false,
                // itemPrice:'',
                // itemQuantity:'',
                // discount:'',
                // total:null,
                // percent:null,
                // discountValue:null,
                invoice:'',
                invoices: [{
                    itemQuantity: '',
                    itemPrice: '',
                    discountValue: '',
                    total: '',
                    discount: '',
                    name: ''
                }],
                isComponentItemActive:false,
                items:[{
                    newItem:''
                }],
                itemsArray:[],
            }
        },
        watch:{

            //  'itemQuantity' :function(val){
            //     console.log('vaaal',val)
            //     this.itemQuantity = val
            //     console.log(this.itemQuantity)
            //     this.total = this.itemQuantity * this.itemPrice
            // },
            // 'itemPrice':function(val){
            //     this.itemPrice = val
            //     this.total = this.itemQuantity * this.itemPrice
            // },
            // 'discount':function(val){
            //     this.discount = val
            //     if(val == 0 ){
            //         this.discountValue = '0.00'
            //         this.discount = '0.00'
            //         this.total = this.itemQuantity * this.itemPrice
            //     }else{
            //         this.discountValue = this.total * this.discount /100
            //         this.total = this.total - this.discountValue

            //     }
            // },

        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            this.getAllCurrency()
            this.getAllProposedCompany(),
            this.getAllCompanies()

        },
        components: {

        },
        methods: {
            getAllCurrency(){
                getAllCurrency().then(Response=>{
                    this.currencies=Response.data.data
                }).catch(error=>{
                    console.log(error);
                })
            },
            getAllItemById(value){
                var id = value;
                getAllItem(id).then(Response=>{
                    this.itemsArray=Response.data.data
                }).catch(error=>{
                    console.log(error);
                })
            },
            getAllContactPersonById(value){

                // console.log("the id is ",value);
                var id = value;
                getAllContactPerson(id).then(Response=>{
                    this.contactPersonArr=Response.data.data
                    // console.log(Response);
                }).catch(error=>{
                    console.log(error);
                })
            },
            getAllProposedCompany(){
                getAllProposedCompany().then(Response=>{
                    this.proposedCompanies=Response.data.data
                }).catch(error => {
                    console.log("there are error ".error)
                })
            },
            getAllCompanies(){
                getAllCompanies().then(Response=>{
                    this.companies=Response.data.data
                }).catch(error=>{
                    console.log(error)
                })
            },
            ChangeInvoice(event){

            },
            ChangePrice(event){
                for(var i=0 ;i < this.invoices.length; i++){
                    this.invoices[i].total = this.invoices[i].itemQuantity * this.invoices[i].itemPrice
                }
            },
            ChangeDiscount(event){
                for(var i=0 ;i < this.invoices.length;i++){
                    if(this.invoices[i].discount == 0 ){
                        this.invoices[i].discountValue = '0.00'
                        this.invoices[i].discount = '0.00'
                        this.invoices[i].total = this.invoices[i].itemQuantity * this.invoices[i].itemPrice
                    }else{
                        this.invoices[i].discountValue = this.invoices[i].total *this.invoices[i].discount /100
                        this.invoices[i].total = this.invoices[i].total - this.invoices[i].discountValue
                    }
                }
            },
            openModal(){
                this.isComponentModalActive = true
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
            openAddItem(){
                this.isComponentItemActive = true
            },
            AddItemfield(){
                this.items.push({
                    newItem: '',
                });
            },
            deleteItem(k, item){
                var idx = this.items.indexOf(item);
                //console.log(idx, k);
                if (idx > 0) {
                    this.items.splice(idx, 1);
                }
            },
            addNewProposal(){
                var data ={
                    'proposed_company_id':this.proposedCompanyId,
                    'companyId':this.companyId,
                    'contactPersonId':this.contactPersonId,
                    'validUntil':this.validUntil,
                    'currencyId':this.currencyId,
                    'payment':this.payment,
                    'invoices':this.invoices,

                };
                console.log('dadadadadadada',data)
                addNewProposal(data).then(response=>{
                    alert('Success')

                })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }
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