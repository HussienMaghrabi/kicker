<template>
  <div class="container">
      <b class="p1">Finances</b>
      <b-button  type="is-danger"  style="float:right;;margin:5px;" onclick="window.printHTML('Hello World');">Print</b-button>
      <b-button type="is-info" style="float:right;margin:5px;">
              <router-link :to="'/admin/vue/financeSettings'" style="color:#fff;">
                 <i class="fas fa-cog"></i> Settings
              </router-link>
      </b-button>
      
      <div class="column is-mobile is-12" style="display:inline-flex;margin-bottom:2%;">
            <div class="column is-4">
                <b-field label="From Date">
                    <b-datepicker
                        v-model="fromDate"
                        placeholder="Click to select..."
                        :date-formatter="dateFormatterFrom"
                        icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>

            <div class="column is-4">
                <b-field label="To Date">
                    <b-datepicker
                        v-model="toDate"
                        placeholder="Click to select..."
                        :date-formatter="dateFormatterTo"
                        icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>

            <div class="column is-2">
                <div class="control" style="margin-top: 12%;display:flex">
                    <b-button class="button is-success" style="margin-right:2%" @click="filterIncomeFinances">Filter Incomes</b-button> 
                    <b-button class="button is-success" style="margin-right:2%" @click="filterOutcomeFinances">Filter Outcomes</b-button> 
                </div>
            </div>

            


       </div>

      <b-tabs>

                <!-- begin income -->

            <b-tab-item label="Incomes">
                <b-table
                  :data="incomes"
                  paginated
                  backend-pagination
                  :current-page="page"
                  :total="total"
                  :per-page="perPage"
                  @page-change="onPageChange"
                  :pagination-simple="isPaginationSimple"
                  :default-sort-direction="defaultSortDirection"
                  default-sort="id"
                  aria-next-label="Next page"
                  aria-previous-label="Previous page"
                  aria-page-label="Page"
                  aria-current-label="Current page"
                >
                  <template slot-scope="props" style="color: hotpink">
                    <b-table-column label="ID" sortable >{{ props.row.id }}</b-table-column>

                    <b-table-column label="Name" sortable >{{ props.row.name }}</b-table-column>

                    <b-table-column label="Description" sortable >{{ props.row.description }}</b-table-column>

                    <b-table-column label="Method" sortable>{{ props.row.payment_method }}</b-table-column>

                    <b-table-column label="Total price" sortable>{{ props.row.value }}</b-table-column>

                    <b-table-column label="bank/safe" sortable> {{ props.row.bankName }}</b-table-column>

                    <b-table-column label="Date" sortable>{{ props.row.date }}</b-table-column>

                    <b-table-column label="Source" sortable>{{ props.row.source }}</b-table-column>

                    <b-table-column label="Status" sortable>{{ props.row.status }}</b-table-column>

                    <b-table-column label="Delete" >
                        <b-button type="is-danger" @click="DeleteFromIndex(props.row.id)">Delete</b-button>
                    </b-table-column>
       
                  </template>
<!-- 
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
                   </template> -->

        </b-table>
<!-- 
        <div class="leads-number">{{logsCurrentNumber + ' / ' + logsTotalNumber}}</div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br> -->

          

                <b-button type="is-info" @click="openModal">
                    New Income
                     <b-modal :active.sync="isComponentModalActive" has-modal-card>
                          <div class="modal-card">
                            <header class="modal-card-head">
                               <p class="modal-card-title">Add New Income</p>
                            </header>

                            <section class="modal-card-body">

                                <b-field label="Name">
                                    <b-input
                                        v-model="name"
                                        type="text"
                                        placeholder="Your name">
                                    </b-input>
                                </b-field>

                                <b-field label="Description">
                                    <b-input
                                        v-model="description"
                                        type="text"
                                        placeholder="Your description">
                                    </b-input>
                                </b-field>


                                <b-field label="Value">
                                    <b-input
                                        v-model="value"
                                        type="number"
                                        placeholder="Your value">
                                    </b-input>
                                </b-field>

                                <b-field label="Currency">
                                    <b-select placeholder="Select a currency" expanded v-model="currency">   
                                      <option v-for="currency in currencies" :key="currency.id" :value="currency.id">
                                          {{ currency.en_name }}
                                      </option>
                                   </b-select>
                                </b-field>

                                <b-field label="Payment Method">
                                    <b-select placeholder="Select a method" expanded v-model="payment_method">
                                        <option value="cash">Cash</option>
                                        <option value="cheques">Cheques</option>
                                        <option value="voucher">Voucher</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </b-select>
                                </b-field>

                                <b-field label="Bank">
                                     <b-select placeholder="Select a bank" expanded v-model="bank">   
                                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">
                                            {{ bank.name }}
                                        </option>
                                   </b-select>
                                </b-field>

                                <b-field label="Date">
                                    <b-datepicker
                                        v-model="date"
                                        :date-formatter="dateFormatterTo"
                                        placeholder="Click to select..."
                                        icon="calendar-today">
                                    </b-datepicker>
                                </b-field>

                                <b-field label="Status">
                                    <b-select placeholder="Select a Status" expanded v-model="status">
                                        <option value="collected">collected </option>
                                        <option value="postponed">PostPoned</option>
                                    </b-select>
                                </b-field>
                             
                            </section>
                            <footer class="modal-card-foot">
                              <!-- <button class="button" type="button" @click="$parent.close()">Close</button> -->
                               <b-button class="button" type="button" @click="isComponentModalActive = false">Close</b-button>
                               <b-button type="is-info" @click="addNewIncome">Submit</b-button>
                            </footer>
                </div>
               </b-modal>
            </b-button>
            </b-tab-item>

            <!-- End Income -->

            <!-- Begin Outcome -->

            <b-tab-item label="Outcomes">
               <b-table
                  :data="outcomes"
                  paginated
                  backend-pagination
                  :current-page="page"
                  :total="total"
                  :per-page="perPage"
                  @page-change="onPageChange"
                  :pagination-simple="isPaginationSimple"
                  :default-sort-direction="defaultSortDirection"
                  default-sort="id"
                  aria-next-label="Next page"
                  aria-previous-label="Previous page"
                  aria-page-label="Page"
                  aria-current-label="Current page"
                >
                  <template slot-scope="props" style="color: hotpink">
                     <b-table-column label="ID" sortable >{{ props.row.id }}</b-table-column>

                    <b-table-column label="Name" sortable >{{ props.row.name }}</b-table-column>

                    <b-table-column label="Description" sortable >{{ props.row.description }}</b-table-column>

                    <b-table-column label="Method" sortable>{{ props.row.payment_method }}</b-table-column>

                    <b-table-column label="Total price" sortable>{{ props.row.value }}</b-table-column>

                    <b-table-column label="bank/safe" sortable> {{ props.row.bankName }}</b-table-column>

                    <b-table-column label="Date" sortable>{{ props.row.date }}</b-table-column>

                    <!-- <b-table-column label="Source" sortable>{{ props.row.source }}</b-table-column> -->
                      
                    <b-table-column label="Status" sortable>{{ props.row.status }}</b-table-column>

                    <b-table-column label="Delete" >
                        <b-button type="is-danger" @click="DeleteFromOutcomes(props.row.id)">Delete</b-button>
                    </b-table-column>

                  </template>

                    <!-- <template slot="empty" v-if="!isLoading && isEmpty">
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
                    </template> -->

              
         </b-table>
<!-- 
        <div class="leads-number">{{logsCurrentNumber + ' / ' + logsTotalNumber}}</div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br> -->

        
                    <b-button type="is-info" @click="openModal">
                        New Outcome
                      <b-modal :active.sync="isComponentModalActive" has-modal-card>
                          <div class="modal-card">
                            <header class="modal-card-head">
                               <p class="modal-card-title">Add New Outcome</p>
                            </header>

                            <section class="modal-card-body">

                                 <b-field label="Outcome Category">
                                    <b-select placeholder="Outcome Category" expanded v-model="outCat">
                                        <option v-for="outCat in outCats" :key="outCat.id" :value="outCat.id">
                                          {{ outCat.name }}
                                      </option>
                                    </b-select>
                                </b-field>

                                <b-field label="Name">
                                    <b-input
                                        v-model="name"
                                        type="text"
                                        placeholder="Your name">
                                    </b-input>
                                </b-field>

                                <b-field label="Description">
                                    <b-input
                                        v-model="description"
                                        type="text"
                                        placeholder="Your description">
                                    </b-input>
                                </b-field>


                                <b-field label="Value">
                                    <b-input
                                        v-model="value"
                                        type="number"
                                        placeholder="Your value">
                                    </b-input>
                                </b-field>

                                  <b-field label="Currency">
                                    <b-select placeholder="Select a currency" expanded v-model="currency">   
                                      <option v-for="currency in currencies" :key="currency.id" :value="currency.id">
                                          {{ currency.en_name }}
                                      </option>
                                   </b-select>
                                </b-field>

                                <b-field label="Payment Method">
                                    <b-select placeholder="Select a method" expanded v-model="payment_method">
                                        <option value="cash">Cash</option>
                                        <option value="cheques">Cheques</option>
                                        <option value="voucher">Voucher</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </b-select>
                                </b-field>
                                
                                <b-field label="Bank">
                                     <b-select placeholder="Select a bank" expanded v-model="bank">   
                                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">
                                            {{ bank.name }}
                                        </option>
                                   </b-select>
                                </b-field>

                                <b-field label="Status">
                                    <b-select placeholder="Select a Status" expanded v-model="statusDue">   
                                      <option value="paid">Paid</option>
                                      <option value="not_paid">Not Paid</option>
                                   </b-select>
                                </b-field>

                                <b-field label="Date">
                                    <b-datepicker
                                        v-model="date"
                                        :date-formatter="dateFormatterTo"
                                        placeholder="Click to select..."
                                        icon="calendar-today">
                                    </b-datepicker>
                                </b-field>
                             
                            </section>
                            <footer class="modal-card-foot">
                               <b-button class="button" type="button" @click="isComponentModalActive = false">Close</b-button>
                               <b-button type="is-info" @click="addNewOutcome">Submit</b-button>
                            </footer>
                </div>
               </b-modal>
              </b-button>

            </b-tab-item>

            <!-- End Outcome -->

         <!-- Begin collections -->

            <b-tab-item label="Collections">
                <b-table
                  :data="collections"
                  paginated
                  backend-pagination
                  :current-page="page"
                  :total="total"
                  :per-page="perPage"
                  @page-change="onPageChange"
                  :pagination-simple="isPaginationSimple"
                  :default-sort-direction="defaultSortDirection"
                  default-sort="id"
                  aria-next-label="Next page"
                  aria-previous-label="Previous page"
                  aria-page-label="Page"
                  aria-current-label="Current page"
                >
                  <template slot-scope="props" style="color: hotpink">
                    <b-table-column label="ID" sortable >{{ props.row.id }}</b-table-column>

                    <b-table-column label="Name" sortable >{{ props.row.name }}</b-table-column>

                    <b-table-column label="Description" sortable >{{ props.row.description }}</b-table-column>

                    <b-table-column label="Value" sortable >{{ props.row.value }}</b-table-column>

                    <b-table-column label="Creation Date" sortable >{{ props.row.date }}</b-table-column>

                    <!-- <b-table-column label="Due Date" sortable >{{ props.row.due_date }}</b-table-column>s -->

                    <b-table-column label="Status" sortable>{{ props.row.status }}</b-table-column>

                     <b-table-column label="Collected">
                         <b-button :disabled="props.row.status == 'collected'" type="is-success" @click="confirmThisCollection(props.row.id)">
                             <i class="fas fa-dollar-sign"></i>  Collect
                         </b-button>
                     </b-table-column>

                  </template>
                </b-table>

            </b-tab-item>

            <!-- End Collection -->

            <!-- Begin Dues -->

            <b-tab-item  label="Dues">
                  <b-table
                  :data="dues"
                  paginated
                  backend-pagination
                  :current-page="page"
                  :total="total"
                  :per-page="perPage"
                  @page-change="onPageChange"
                  :pagination-simple="isPaginationSimple"
                  :default-sort-direction="defaultSortDirection"
                  default-sort="id"
                  aria-next-label="Next page"
                  aria-previous-label="Previous page"
                  aria-page-label="Page"
                  aria-current-label="Current page"
                >
                  <template slot-scope="props" style="color: hotpink">
                    <b-table-column label="ID" sortable >{{ props.row.id }}</b-table-column>

                    <b-table-column label="Name" sortable >{{ props.row.name }}</b-table-column>

                    <b-table-column label="Description" sortable >{{ props.row.description }}</b-table-column>

                    <b-table-column label="Value" sortable >{{ props.row.value }}</b-table-column>

                    <b-table-column label="Creation Date" sortable >{{ props.row.date }}</b-table-column>

                    <!-- <b-table-column label="Due Date" sortable >{{ props.row.due_date }}</b-table-column> -->

                    <b-table-column label="Status" sortable>{{ props.row.status }}</b-table-column>
                    
                     <b-table-column label="Paid">
                         <b-button :disabled="props.row.status == 'paid'" type="is-success" @click="confirmThisDues(props.row.id)">
                             <i class="fas fa-dollar-sign"></i>  Paid
                         </b-button>
                     </b-table-column>

                  </template>
                </b-table>

                
            </b-tab-item>

            <!-- End Dues -->

            <!-- Begin Collected -->
            <b-tab-item label="Collected">
                 <b-table
                  :data="collected"
                  paginated
                  backend-pagination
                  :current-page="page"
                  :total="total"
                  :per-page="perPage"
                  @page-change="onPageChange"
                  :pagination-simple="isPaginationSimple"
                  :default-sort-direction="defaultSortDirection"
                  default-sort="id"
                  aria-next-label="Next page"
                  aria-previous-label="Previous page"
                  aria-page-label="Page"
                  aria-current-label="Current page"
                >
                  <template slot-scope="props" style="color: hotpink">
                    <b-table-column label="ID" sortable >{{ props.row.id }}</b-table-column>

                    <b-table-column label="Name" sortable >{{ props.row.name }}</b-table-column>

                    <b-table-column label="Description" sortable >{{ props.row.description }}</b-table-column>

                    <b-table-column label="Value" sortable >{{ props.row.value }}</b-table-column>

                    <b-table-column label="Creation Date" sortable >{{ props.row.date }}</b-table-column>

                    <!-- <b-table-column label="Due Date" sortable >{{ props.row.due_date }}</b-table-column> -->

                    <b-table-column label="Status" sortable>{{ props.row.status }}</b-table-column>
                    
                  </template>
                </b-table>
            </b-tab-item>
            <!-- End Collected -->

             <!-- Begin Paid -->
            <b-tab-item label="Paid">
                 <b-table
                  :data="paid"
                  paginated
                  backend-pagination
                  :current-page="page"
                  :total="total"
                  :per-page="perPage"
                  @page-change="onPageChange"
                  :pagination-simple="isPaginationSimple"
                  :default-sort-direction="defaultSortDirection"
                  default-sort="id"
                  aria-next-label="Next page"
                  aria-previous-label="Previous page"
                  aria-page-label="Page"
                  aria-current-label="Current page"
                >
                  <template slot-scope="props" style="color: hotpink">
                    <b-table-column label="ID" sortable >{{ props.row.id }}</b-table-column>

                    <b-table-column label="Name" sortable >{{ props.row.name }}</b-table-column>

                    <b-table-column label="Description" sortable >{{ props.row.description }}</b-table-column>

                    <b-table-column label="Value" sortable >{{ props.row.value }}</b-table-column>

                    <b-table-column label="Creation Date" sortable >{{ props.row.date }}</b-table-column>

                    <!-- <b-table-column label="Due Date" sortable >{{ props.row.due_date }}</b-table-column> -->

                    <b-table-column label="Status" sortable>{{ props.row.status }}</b-table-column>
                    
                  </template>
                </b-table>
            </b-tab-item>
            <!-- End Paid -->

         </b-tabs>
            
  </div>
</template>
<style>
.p1 {
  padding: 10px;
}
.container{
    background-color: #fff;
}
.label{
    float: left;
}
</style>

<script>

import {all_finances,getCurrency,getBanks,addNewIncome,addNewOutcome,getOutCats,all_Collections,
        all_Dues,confirmCollection,confirmDues,all_Collected,all_Dues_Paid,filterIncomeFinances,
        filterOutcomeFinances,deleteThisIncome,deleteThisOutcome,
        facilities} from './../../calls'

export default {
  data() {
    return {
      isImageModalActive: false,
      buttonState: "Income",
      pragrapgState: "p1",
      title:"Add income" ,
      isPaginated: true,
      isPaginationSimple: false,
      defaultSortDirection: "desc",
      currentPage: 1,
      perPage: 10,
      total: 0,
      page: 1,
      isComponentModalActive: false,
      incomes:[],
      outcomes:[],
      currencies:[],
      banks:[],
      outCats:[],
      name:null,
      description:null,
      value:null,
      Description:null,
      status:null,
      currency:null,
      outCat:null,
      payment_method:null,
      date:null,
      bank:null,
      sub_cat_id:null,
      collections:[],
      dues:[],
      created_at:null,
      due_date:null,
      statuss:null,
      token: window.auth_user.csrf,
      statusDue:null,
      collected:[],
      paid:[],
      bankName:null,
      fromDate:null,
      toDate:null,
      bank_id:null,
      print:null,
      isEmpty: false,
      page: parseInt(this.$route.hash.split('/')[1]),
      paginationPosition: 'bottom',
      isFullPage: true,
      logsCurrentNumber: 0,
      logsTotalNumber: 0,
      isLoading: true,

  }},
  computed: {
  },
  mounted() {
      window.printHTML = function(html) {
        var win = null;
        win = window.open();
        self.focus();
        win.document.open();
        win.document.write('<' + 'html' + '><' + 'head' + '><' + 'style' + '>');
        win.document.write('body, td { font-family: Verdana; font-size: 10pt;}');
        win.document.write('<' + '/' + 'style' + '><' + '/' + 'head' + '><' + 'body' + '>');
        win.document.write(html);
        win.document.write('<' + '/' + 'body' + '><' + '/' + 'html' + '>');
        win.document.close();
        win.print();
        win.close();
    }
    this.getData()
    this.getAllCollections()
    this.getAllDues()
    this.getAllCollected()
    this.getAllDuesPaid()
    this.getAllCurrency()
    this.getAllBanks()
    this.getAllOutCat()
  },
  components: {
   
  },
//   created(){
//       this.printNow()
//   },
  methods: {
    getData(){
      this.isLoading = true
          all_finances(this.page).then(response=>{
          console.log("financeees",response)
        //   this.perPage = response.data.income.per_page
        //   console.log("paaaage",this.perPage)
          this.incomes = response.data.income
          this.outcomes = response.data.outcome
          this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
          this.logsTotalNumber = response.data.total
          this.total = response.data.total
          
          if(this.incomes.length == 0){
              this.isEmpty = true
          }
          if(this.outcomes.length == 0){
              this.isEmpty = true
          }
         
        //   this.total = currentTotal
          this.isLoading = false
      

          })
      .catch(error => {
          console.log(error)
      })
      },
      getAllCollections(){
      this.isLoading = true
          all_Collections(this.page).then(response=>{
        //   console.log("collectionsssss",response)
          this.perPage = response.data.per_page
          this.collections = response.data.collections
          this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
          this.logsTotalNumber = response.data.total
          this.total = response.data.total
          
          if(this.collections.length == 0){
              this.isEmpty = true
          }

          this.isLoading = false
          })
      .catch(error => {
          console.log(error)
      })
      },
    getAllCollected(){
      this.isLoading = true
          all_Collected(this.page).then(response=>{
        //   console.log("Collecteeeed",response)
          this.perPage = response.data.per_page
          this.collected = response.data.collected
          this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
          this.logsTotalNumber = response.data.total
          this.total = response.data.total
          
          if(this.collected.length == 0){
              this.isEmpty = true
          }

          this.isLoading = false
          })
      .catch(error => {
          console.log(error)
      })
      },    
     getAllDues(){
      this.isLoading = true
          all_Dues(this.page).then(response=>{
          console.log("dueees",response)
          this.perPage = response.data.per_page
          this.dues = response.data.dues
        //   if(this.dues.status == "not_paid"){
        //       this.dues.status = "Not Paid"
        //   }
          this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
          this.logsTotalNumber = response.data.total
          this.total = response.data.total
    
          if(this.dues.length == 0){
              this.isEmpty = true
          }
       
          this.isLoading = false
          })
      .catch(error => {
          console.log(error)
      })
      },
    getAllDuesPaid(){
      this.isLoading = true
          all_Dues_Paid(this.page).then(response=>{
          this.perPage = response.data.per_page
          this.paid = response.data.paid
          this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
          this.logsTotalNumber = response.data.total
          this.total = response.data.total
          
          if(this.collections.length == 0){
              this.isEmpty = true
          }

          this.isLoading = false
          })
      .catch(error => {
          console.log(error)
      })
      },    
    getAllCurrency(){
        this.isLoading = true
        getCurrency().then(response=>{
          this.currencies = response.data
        //   console.log("currencies",this.currencies)
        }).catch(error=>{
            console.log(error)
        })
    },
    getAllBanks(){
        this.isLoading = true
        getBanks().then(response=>{
          this.banks = response.data
        //   console.log("Banks",this.banks)
        }).catch(error=>{
            console.log(error)
        })
    },
    getAllOutCat(){
         this.isLoading = true
        getOutCats().then(response=>{
          this.outCats = response.data
        //   console.log("OutCats",this.outCats)
        }).catch(error=>{
            console.log(error)
        })
    },
    onPageChange(p) {

    },
    openModal(){
        this.isComponentModalActive = true
    },
    // closeModal(){
    //     this.isComponentModalActive = false
    // },
    addNewIncome(){
        var data ={
            '_token':this.token,
            'name':this.name,
            'description':this.description,
            'value':this.value,
            'status':this.status,
            'currency':this.currency,
            'payment_method':this.payment_method,
            'date':this.date,
            'bank':this.bank,
        };
        // console.log('new income',data)
        addNewIncome(data).then(response=>{
            this.success("Added")
            this.getData()
            this.isComponentModalActive = false
            $(location).attr('href', '/admin/vue/FinalFinance')
        })
        .catch(error => {
                this.errorDialog()
        })
    },
    addNewOutcome(){
        var data ={
            '_token':this.token,
            'name':this.name,
            'description':this.description,
            'value':this.value,
            'currency':this.currency,
            'payment_method':this.payment_method,
            'date':this.date,
            'sub_cat_id' :this.outCat,
            'status' :this.statusDue,
        };
        // console.log('new outcome',data)
        addNewOutcome(data).then(response=>{
            this.success("Added")
            this.getData()
            this.isComponentModalActive = false
            $(location).attr('href', '/admin/vue/FinalFinance')
        })
        .catch(error => {
                this.errorDialog()
        })
    },
    confirmThisCollection(id){
        confirmCollection(id).then(response=>{
            console.log('colleeeeeeeeeected',response)
            this.isLoading = true
            this.getAllCollections()
            $(location).attr('href', '/admin/vue/FinalFinance')

        }).catch(error=>{
            console.log(error)
        })
    },
    confirmThisDues(id){
        confirmDues(id).then(response=>{
            console.log('paiiiiiiiid',response)
            this.isLoading = true
            this.getAllDues()
            $(location).attr('href', '/admin/vue/FinalFinance')

        }).catch(error=>{
            console.log(error)
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
            message: 'Finance' + action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
    dateFormatterFrom(dt){
        var date = dt.toLocaleDateString();
        const [month, day, year] = date.split('/')
        this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        return date
    },
    dateFormatterTo(dt){
        var date = dt.toLocaleDateString();
        const [month, day, year] = date.split('/')
        this.parsedDateTo = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        return date
    },
    filterIncomeFinances(){
            this.isLoading = true
            var data ={
                '_token':this.token,
                'fromDate': this.fromDate,    
                'toDate': this.toDate,    
            };
            filterIncomeFinances(data).then(response=>{
                    console.log('filteeeer in',response)
                    this.perPage = response.data.per_page
                    this.incomes = response.data
                    // this.cilsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    // this.cilsTotalNumber = response.data.total
                    this.total = response.data.total
                    // if(this.cils.length == 0){
                    //     this.isEmpty = true
                    // }
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
    filterOutcomeFinances(){
            this.isLoading = true
            var data ={
                '_token':this.token,
                'fromDate': this.fromDate,    
                'toDate': this.toDate,    
            };
            filterOutcomeFinances(data).then(response=>{
                    console.log('filteeeer out',response)
                    this.perPage = response.data.per_page
                    this.outcomes = response.data
                    // this.cilsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    // this.cilsTotalNumber = response.data.total
                    this.total = response.data.total
                    // if(this.cils.length == 0){
                    //     this.isEmpty = true
                    // }
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
    DeleteFromIndex(id) {
            this.$dialog.confirm({
                title: 'Deleting ',
                message: 'Are you sure you want to <b>delete</b> This Income?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteIncome(id)
            })
        },
    deleteIncome(id){
            deleteThisIncome(id).then(response=>{
                this.success('Deleted')
                this.isLoading = true
                this.getData()
            })
            .catch(error => {
                this.errorDialog()
                console.log(error)
            })
    },
    DeleteFromOutcomes(id){
            this.$dialog.confirm({
                title: 'Deleting ',
                message: 'Are you sure you want to <b>delete</b> This Outcome?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteOutcome(id)
            })
        },
    deleteOutcome(id){
            deleteThisOutcome(id).then(response=>{
                this.success('Deleted')
                this.isLoading = true
                this.getData()
            })
            .catch(error => {
                this.errorDialog()
                console.log(error)
            })
    },
  }
  

};
</script>


 

      