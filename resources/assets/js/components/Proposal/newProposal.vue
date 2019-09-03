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
                        <b-select placeholder="Select Company" expanded>
                            <option>Circle ERP</option>
                            <option>PropertzCRM</option>
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
            <div class="column is-12" style="display:-webkit-inline-box;padding-left:10%">
                <h6 style="color:red;margin-right:1%" class="column is-2">*Company Name</h6>
                <div class="field column is-8">
                    <div class="select" style="width:42%">
                        <b-select expanded>
                            <option>Circle ERP</option>
                            <option>PropertzCRM</option>
                        </b-select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns is-12">
            <div class="column is-12" style="display:-webkit-inline-box;padding-left:10%">
                <h6 style="color:red;margin-right:1%" class="column is-2">*Contact Person</h6>
                <div class="field column is-8">
                    <div class="select" style="width:42%">
                        <b-select expanded>
                            <option>Circle ERP</option>
                            <option>PropertzCRM</option>
                        </b-select>
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
                <b-field class="column is-8">
                    <div class="select" style="width:50%">
                        <b-select expanded>
                            <option>EGP</option>
                        </b-select>
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
                <b-button type="is-info"  @click="AddInvoicefield" style="margin-top:10px;margin-bottom:2%"><i class="fas fa-plus-square"></i>&nbsp Add item</b-button>

                <div class="columns is-12" v-if="k == 0" v-for="(invoice, k) in invoices" :key="k">
                    <div class="column is-12">
                        <h6 style="font-weight:700">PAYMENT:</h6>
                        <div class="column is-5">
                            <b-input type="textarea"></b-input>
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
               <b-button type="is-info" style="margin-right:2%"><i class="fas fa-save"></i>&nbsp Save</b-button>
               <b-button type="is-danger">Cancel</b-button>
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

    },
    components: {
        
    },
    methods: {
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

</style>