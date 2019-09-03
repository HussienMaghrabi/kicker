<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <div class="columns is-12  is-mobile">
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

        <div class="columns is-12  is-mobile">
            <div class="column is-12">
                <h6 style="color:#bbb;">Invoice To</h6><hr>
            </div>
        </div>

        <div class="columns is-12  is-mobile">
            <div class="column is-12" style="display:-webkit-inline-box;padding-left:10%">
                <h6 style="color:red;margin-right:1%" class="column is-2">*Company Name</h6>
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

        <div class="columns is-12  is-mobile">
            <div class="column is-12" style="display:-webkit-inline-box;padding-left:10%">
                <h6 style="color:red;margin-right:1%" class="column is-2">*Contact Person</h6>
                <div class="field column is-5">
                    <div class="select" style="width:100%">
                        <select expanded style="width:100%">
                            <option>Circle ERP</option>
                            <option selected>Mohamed Alfy</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns is-12  is-mobile">
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

        <div class="columns is-12  is-mobile">
            <div class="column is-12">
                <h6 style="color:#bbb;">Proposal Quotations</h6><hr>
            </div>
        </div>

     <div class="columns is-12  is-mobile">
      
      <div class="column is-12">
         <b-table
                    :data="taskData"
                    bordered
                    checkable
                    narrowed
                    hoverable

                    paginated
                    backend-pagination

                    :current-page="page"
                    :total="total"
                    :per-page="perPage"
                    @page-change="onPageChange"

                    :checked-rows.sync="selectedLeads"
                    :default-sort-direction="defaultSortDirection"
                    default-sort="created_at"
                    >

                    <template slot-scope="props">
                        <b-table-column  label="Item" sortable>
                             {{ props.row.agent_id }}
                        </b-table-column>

                        <b-table-column label="Quantity" sortable>
                             {{ props.row.due_date }}
                        </b-table-column>

                        <b-table-column label="Unit Price" sortable>
                             {{ props.row.task_type}}
                        </b-table-column>

                        <b-table-column  label="Subtotal" sortable>
                            {{ props.row.task_type}}
                        </b-table-column>

                        <b-table-column  label="Discount" sortable>
                            {{ props.row.task_type}}
                        </b-table-column>

                        <b-table-column  label="Line Total" sortable>
                           {{ props.row.task_type}}
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
                            <th style="width:20%">Status</th>
                            <th style="width:15%">Postpone history</th>
                        </tr>
                    </thead><br>
                    <tr  v-for="(invoice, k) in invoices" :key="k">
                        <td> 
                            <b-field>
                                   <b-datepicker icon="calendar-today"></b-datepicker>
                            </b-field>
                        </td>
                        <td><div class="cell-with-input"><b-input type="number" @input="ChangeInvoice" min="0" v-model="invoice.itemQuantity"/></div></td>
                        <td><div class="cell-with-input"><b-input type="number" min="0" @input="ChangePrice" v-model="invoice.itemPrice"/></div></td>
                        <td>
                            Waiting - <a>Collect</a> -<a>Postpone</a> 
                        </td>
                        <td><b-button type="is-success">View History</b-button></td>
                        <hr>
                    </tr>
                </table>

                <b-button type="is-danger">CLose Invoice</b-button><hr>
                
        </div>
    </div> 

    <div class="columns is-12 is-mobile" style="margin-top:3%;margin-left:77%">
        <b-button type="is-info" style="margin-right:2%"><i class="fas fa-save"></i>&nbsp Save</b-button>
        <b-button type="is-danger" style="margin-right:2%"><i class="fas fa-ban"></i>&nbsp Cancel</b-button>
        <b-button type="is-success"><i class="fas fa-print"></i>&nbsp Print</b-button>
    </div>

    </div>
</template>

<script>
import {getTaskData} from './../../calls'
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
            taskData:[]
        }
     },
     watch:{

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
        getData(){
            this.isLoading = true
            getTaskData(this.page).then(response=>{
                // console.log(response)
            this.taskData = response.data.data
            this.perPage = response.data.per_page
            this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
            this.leadsTotalNumber = response.data.total
            this.total = response.data.total
            let currentTotal = response.data.total
                if (response.data.total / this.perPage > 1000) {
                    currentTotal = this.perPage * 1000
                }

            this.total = currentTotal
            this.isLoading = false
            })
        .catch(error => {
            console.log(error)
        })},
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