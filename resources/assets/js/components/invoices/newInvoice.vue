<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <h1 style="margin-bottom:2%">New Invoice</h1>
           <div class="columns is-12  is-mobile" style="margin-left:9%;margin-bottom:2%">
                <div class="column is-10">
                    <b style="margin-bottom:2%">Invoice No. 79</b>
                </div>
           </div>
           <div class="columns is-12  is-mobile" style="padding-left:10%">
            <div class="column is-12" style="display:-webkit-inline-box;margin-bottom:2%">
                <h6 style="color:red;margin-right:5%">*Company</h6>
                <div class="field column is-5">
                    <div class="select" style="width:100%">
                        <select expanded style="width:100%">
                            <option>Circle ERP</option>
                            <option selected>PropertzCRM</option>
                        </select>
                    </div>
                </div>
            </div>

           </div>


            <div class="columns is-12  is-mobile" style="padding-left:10%">        
                <div class="column is-12" style="display:-webkit-inline-box;margin-bottom:2%">
                    <h6 style="color:red;margin-right:6%">Proposal</h6>
                    <div class="field column is-5">
                        <div class="select" style="width:100%">
                            <select expanded style="width:100%">
                                <option>Circle ERP</option>
                                <option selected>Proposal No. 79</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        <div class="columns is-12">
            <div class="column is-12">
                <h6 style="color:#bbb;">Invoice To</h6><hr>
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
                <h6 style="color:#bbb;">Invoice Options</h6><hr>
            </div>
        </div>

          
        <div class="columns is-12  is-mobile">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Invoice date</h6>
                <b-field class="column is-4">
                    <b-datepicker
                        icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>
        </div>

        <div class="columns is-12  is-mobile">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Due date</h6>
                <b-field class="column is-4">
                    <b-datepicker
                        icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>
        </div>

        <div class="columns is-12  is-mobile">
            <div class="column is-12" style="padding-left:10%;display:-webkit-inline-box">
                <h6 class="column is-2" style="margin-right:1%">Invoice Currency</h6>
                <b-field class="column is-4">
                    <div class="select" style="width:100%">
                        <select expanded style="width:100%">
                            <option selected>EGP</option>
                        </select>
                    </div>
                </b-field>
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
                <b-button type="is-info"  @click="AddInvoicefield" style="margin-top:10px"><i class="fas fa-plus-square"></i>&nbsp Add item</b-button>
                
            </div>
        </div>

        <div style="float:right">
            <h3 style="margin-bottom:4%">Subtotal 89,000.00</h3>
            <div class="columns is-12  is-mobile">
                <div class="column is-5" style="display:flex">
                    <label class="column is-4">Discount</label>
                    <b-input type="text">0.00</b-input>
                </div>
                    <div class="column is-5" style="display:flex">
                    <label class="column is-4"> EGP</label>
                    <b-input type="text">0.00</b-input>
                </div>
            </div>
            <h3>Total 89,000.00</h3>
        </div>

         <div class="columns is-12  is-mobile">
        <div class="column is-12">
            <h6 style="color:#bbb;">Collection Dates</h6><hr>
        </div>
    </div>

    <div class="columns is-12  is-mobile">
        <div class="column is-12">
            <table class="responsive-table">
                <thead>
                    <tr style="background-color:#F6F6F6;height:50px">
                        <th style="width:32%;padding-left:2%">Date</th>
                        <th>Percentage</th>
                        <th>Value</th>
                        <th style="width:30%">Status</th>
                        <th></th>
                    </tr>
                </thead><br>
                <tr v-for="(collectionDate, collectionIndex) in collectionDates" :key="collectionIndex">
                    <td> 
                        <b-field>
                            <b-datepicker icon="calendar-today" v-model="collectionDate.date"></b-datepicker>
                        </b-field>
                    </td>
                    <td><div class="cell-with-input"><b-input type="number" @input="ChangeInvoice" min="0" v-model="collectionDate.percentage"/></div></td>
                    <td><div class="cell-with-input"><b-input type="number" min="0" @input="ChangePrice" v-model="collectionDate.value"/></div></td>
                    <td><div class="cell-with-input"><b-input type="number" min="0" @input="ChangePrice" v-model="collectionDate.status"/></div></td>
                    <td><i @click="deleteCollection(collectionIndex, collectionDate)" class="fas fa-trash-alt" style="cursor:pointer"></i></td>
                    <hr>
                </tr>
            </table>

            <b-button type="is-danger" @click="AddCollectionDates"><i class="fas fa-plus" style="color:#FFF"></i>&nbsp Add Date Or CLose Invoice</b-button>
                    
        </div>
    </div> 
 
        <div class="columns is-12" style="margin-top:3%;;margin-left:77%">
            <b-button type="is-info" style="margin-right:2%"><i class="fas fa-save"></i>&nbsp Save</b-button>
            <b-button type="is-danger" style="margin-right:2%"><i class="fas fa-ban"></i>&nbsp Cancel</b-button>
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
            collectionDate:'',
            collectionDates: [{
                date: '',
                percentage: '',
                value: '',
                status: '',
            }],
            isComponentItemActive:false,
            items:[{
                newItem:''
                }],
        }
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
       AddCollectionDates(){
            this.collectionDates.push({
                date: '',
                percentage: '',
                value: '',
                status: '',
            });    
       },
        deleteRow(index, invoice) {
            var idx = this.invoices.indexOf(invoice);
            console.log(idx, index);
            if (idx > -1) {
                this.invoices.splice(idx, 1);
            }
        },
        deleteCollection(collectionIndex,collectionDate){
             var idx = this.collectionDates.indexOf(collectionDate);
            console.log(idx, collectionIndex);
            if (idx > -1) {
                this.collectionDates.splice(idx, 1);
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