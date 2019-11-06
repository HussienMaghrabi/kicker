<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <div class="columns is-12">
            <div class="column is-10">
                <b style="margin-bottom:2%">Proposal No. 272</b>
            </div>
           <div class="column is-1">
               <b-button type="is-info" class="save">Save</b-button>
           </div>
           <div  class="column is-1">
               <b-button type="is-danger" class="cancel">Cancel</b-button>
           </div>
        </div>
        <div class="columns is-12" style="padding-left:10%">
            <div class="column is-12" style="display:-webkit-inline-box;margin-bottom:2%">
                <h6 style="color:red;margin-right:5%" class="headerInput">*Proposed Company</h6>
                <div class="field column is-5">
                    <div class="select" style="width:100%">
                        <select expanded style="width:100%">
                            <option >{{ prop.company_name }}</option>
                        </select>
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
            <div class="column is-12" style="display:-webkit-inline-box;padding-left:10%">
                <h6 style="color:red;margin-right:1%" class="column is-2">*Company Name</h6>
                <div class="field column is-5">
                    <div class="select" style="width:100%">
                        <select expanded style="width:100%">
                            <option>{{prop.lead_name}}</option>
                       
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="display:-webkit-inline-box;padding-left:10%">
                <h6 style="color:red;margin-right:1%" class="column is-2">*Contact Person</h6>
                <div class="field column is-5">
                    <div class="select" style="width:100%">
                        <select expanded style="width:100%">
                            <option>{{prop.contact_first_name  +  prop.contact_last_name}}</option>
              
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12">
                <h6 style="color:#bbb;">Proposal Options</h6><hr>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;">
                <b-checkbox>Add Proposal introduction</b-checkbox><br>
                <b-checkbox>Add Proposal Closing</b-checkbox><br>
            </div>
        </div>
        
        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">This Proposal valid until</h6>
                <b-field class="column is-4">
                    <b-datepicker
                        icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Proposal Currency</h6>
                <b-field class="column is-4">
                    <div class="select" style="width:100%">
                        <select expanded style="width:100%">
                            <option selected>{{prop.carrancy_name}}</option>
                        </select>
                    </div>
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
                            <b-input type="textarea"></b-input>                                 
                        </b-field>
                        <span style="color:rgb(100, 136, 213);cursor:pointer">Restore Default policy</span>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
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
                                 <b-autocomplete :open-on-focus="true" dir="ltr"></b-autocomplete>
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
                                        <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
                                        <button class="button" type="button" @click="isComponentItemActive = false">Cancel</button>
                                    </footer>
                                </div>
                            </b-modal>

                            
                        </td>
                        <td><div class="cell-with-input"><b-input type="number" @input="ChangeInvoice" min="0" v-model="prop_item.quantity"/></div></td>
                        <td><div class="cell-with-input"><b-input type="number" min="0" @input="ChangePrice" v-model="invoice.itemPrice"/></div></td>
                        <td>{{ invoice.total }} </td>
                        <td><b-input type="number" placeholder="Value" min="0"  readonly v-model="prop_item.discaount"/></td>
                        <td><b-input type="number" placeholder="Percent %" min="0" @input="ChangeDiscount"  v-model="invoice.discount"/></td>
                        <td class="text-right"> {{ prop_item.final_total }} </td>
                        <td><i @click="deleteRow(k, invoice)" class="fas fa-trash-alt" style="cursor:pointer"></i></td>
                        <hr>
                    </tr>
                </table>
                <b-button type="is-info"  @click="AddInvoicefield" style="margin-top:10px"><i class="fas fa-plus-square"></i>&nbsp Add item</b-button>
                
            </div>
        </div>

         <div class="columns is-12">
            <div class="column is-12">
                <h6 style="font-weight:700">PAYMENT:</h6>
                <div class="column is-5">
                    <b-input type="textarea"></b-input>
                </div>

                <div class="column is-7">
                    <h6>Subtotal 49000.00</h6><br>
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

         <div class="columns is-12" style="margin-top:3%">
               <b-button type="is-info" style="margin-right:2%"><i class="fas fa-save"></i>&nbsp Save</b-button>
               <b-button type="is-danger" style="margin-right:2%"><i class="fas fa-ban"></i>&nbsp Cancel</b-button>
               <b-button type="is-success"><i class="fas fa-print"></i>&nbsp Print</b-button>
          </div>

    </div>
</template>

<script>
import {} from './../../calls'
export default {
    data() {
        return {
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
                discount: ''
            }],
            isComponentItemActive:false,
            items:[{
                newItem:''
                }],
            id:null,
            prop:[],
            prop_item:[]
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
        this.getData()
    },
    components: {
        
    },
    methods: {
       getData(loading = true){
                this.isLoading = loading;
               axios.get('/api/editProposal/'+this.id).then(response=>{
                    this.perPage = response.data.per_page;
                    this.prop = response.data.propsal[0],
                    this.prop_item = response.data.items[0]
                    console.log("===================",response.data.items[0])

                    this.leadsTotalNumber = response.data.total
                    this.total = response.data.total
                    if(this.leads.length == 0){
                        this.isEmpty = true
                    }
                    let currentTotal = response.data.total
                    if (response.data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }
                    this.total = currentTotal
                    this.isLoading = false
                    this.getPublic()
            

                })
                    .catch(error => {
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
            console.log(idx, index);
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
            console.log(idx, k);
            if (idx > 0) {
                this.items.splice(idx, 1);
            }
        }
}}

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
@media screen and (max-width: 767px) {
    .save{
        margin-left: 62%;
    }
    .cancel{
        margin-top: -11%;
        margin-left: 81%;
    }
    .headerInput{
        display: contents !important;
    }
}

</style>