<template>
  <div>

    <div class="f1">
      <p class="p1">Finances</p>
      <b-button type="is-info" style="float:right;">
              <router-link :to="'/admin/vue/financeSettings'" style="color:#fff;">
                  Settings
              </router-link>
      </b-button>
      <div class="butns">

         <b-tabs v-model="activeTab">
            <b-tab-item label="Incomes" class="notActive" id="income" v-on:click="change_btn('Income')">
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
                    <b-table-column
                      label="ID"
                      sortable
                    >{{ props.row.id }}</b-table-column>

                    <b-table-column
                      label="Name"
                      sortable
                    >{{ props.row.name }}</b-table-column>

                    <b-table-column
                      label="Description"
                      sortable
                    >{{ props.row.description }}</b-table-column>

                    <b-table-column
                      label="Method"
                      sortable
                    >{{ props.row.payment_method }}</b-table-column>

                    <b-table-column
                      label="Total price"
                      sortable
                    >{{ props.row.value }}</b-table-column>

                    <b-table-column label="bank/safe" sortable> </b-table-column>

                    <b-table-column
                      label="Date"
                      sortable
                    >{{ props.row.date }}</b-table-column>

                    <b-table-column
                      label="Source"
                      sortable
                    >{{ props.row.source }}</b-table-column>

                    <b-table-column
                      label="Status"
                      sortable
                    >{{ props.row.status }}</b-table-column>
                  </template>
                </b-table>
            </b-tab-item>

            <b-tab-item label="Music">
                Lorem <br>
                ipsum <br>
                dolor <br>
                sit <br>
                amet.
            </b-tab-item>

            <b-tab-item :visible="showBooks" label="Outcomes">
                What light is light, if Silvia be not seen? <br>
                What joy is joy, if Silvia be not by— <br>
                Unless it be to think that she is by <br>
                And feed upon the shadow of perfection? <br>
                Except I be by Silvia in the night, <br>
                There is no music in the nightingale.
            </b-tab-item>

            <b-tab-item label="Collections">
                Lorem <br>
                ipsum <br>
                dolor <br>
                sit <br>
                amet.
            </b-tab-item>

            <b-tab-item :visible="showBooks" label="Dues">
                What light is light, if Silvia be not seen? <br>
                What joy is joy, if Silvia be not by— <br>
                Unless it be to think that she is by <br>
                And feed upon the shadow of perfection? <br>
                Except I be by Silvia in the night, <br>
                There is no music in the nightingale.
            </b-tab-item>
         </b-tabs>
            
        <!-- <button
          type="button"
          v-bind:class="{ active: buttonState == 'Income' }"
          class="notActive"
          id="income"
          v-on:click="change_btn('Income')"
        >Income</button>

        <button
          type="button"
          class="notActive"
          v-bind:class="{ active: buttonState == 'outcome' }"
          id="outcome"
          v-on:click="change_btn('outcome')"
        >outcome</button>

        <button
          type="button"
          class="notActive"
           v-bind:class="{ active: buttonState == 'collection' }"
          id="collection"
          @click="isImageModalActive = true, change_btn('collection')"
        >collections</button>

        <button
          class="notActive"
          id="dues"
           v-bind:class="{ active: buttonState == 'dues' }"
          @click="isImageModalActive = true, change_btn('dues')"
        >dues</button> -->

        <b-modal :active.sync="isImageModalActive" full-screen>
          <div class="card-content">
            <b-table
              :data="allProposals"
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
                <b-table-column
                  field="lead"
                  label="ID"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="value"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="collected"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="date"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="currency"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="payment method"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>
              </template>
            </b-table>
          </div>
        </b-modal>

        <b-modal :active.sync="isImageModalActive" full-screen>
          <div class="card-content">
            <b-table
              :data="allProposals"
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
                <b-table-column
                  field="lead"
                  label="ID"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="value"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="collected"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="date"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="currency"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>

                <b-table-column
                  field="lead"
                  label="payment method"
                  sortable
                >{{ props.row.first_name }} {{props.row.last_name}}</b-table-column>
              </template>
            </b-table>
          </div>
        </b-modal>
      </div>

      <div id="hide">
        <button
          
          v-if="buttonState == 'Income'"
          type="button"
          class="btn_form p1"
          @click="isComponentModalActive = true"
          
          id="hide"
        >New income</button>

        <button
          
          v-if="buttonState == 'outcome'"
          type="button"
          class="btn_form p2"
          @click="isComponentModalActive = true"

          id="hide"
        >New outcome</button>
      </div>

      <b-modal :active.sync="isComponentModalActive" has-modal-card>
        <modal-form v-bind="formProps"></modal-form>
      </b-modal>
      <div class="card-content" full-screen>
        <!-- <b-table
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
            <b-table-column
              label="ID"
              sortable
            >{{ props.row.id }}</b-table-column>

            <b-table-column
              label="Name"
              sortable
            >{{ props.row.name }}</b-table-column>

            <b-table-column
              label="Description"
              sortable
            >{{ props.row.description }}</b-table-column>

            <b-table-column
              label="Method"
              sortable
            >{{ props.row.payment_method }}</b-table-column>

            <b-table-column
              label="Total price"
              sortable
            >{{ props.row.value }}</b-table-column>

            <b-table-column label="bank/safe" sortable> </b-table-column>

            <b-table-column
              label="Date"
              sortable
            >{{ props.row.date }}</b-table-column>

            <b-table-column
              label="Source"
              sortable
            >{{ props.row.source }}</b-table-column>

            <b-table-column
              label="Status"
              sortable
            >{{ props.row.status }}</b-table-column>
          </template>
        </b-table> -->
      </div>
    </div>

  </div>
</template>

<script>
import {all_finances} from './../../calls'

const ModalForm = {
  props: [
    "name",
    "description",
    "value",
    "currency",
    "payment_method",
    "date",
    "payment_method2",
    "labelPosition",
   
    "title"
  ],
  template: `
            <form action="" class="form_edit">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">

                      <p class="modal-card-title"  @change_prag(new_state1)> {{title}}</p>
                       
                      
                    </header>

                    <section class="modal-card-body">
                        <b-field label="Name" class="in">
                            <b-input
                                type="text"
                                :value="name"
                                placeholder="Your name"
                                required>
                            </b-input>
                        </b-field>

                        <b-field label="description" class="in">
                            <b-input
                                type="text"
                                :value="description"
                                
                                placeholder="Your description"
                                required>
                            </b-input>
                        </b-field>


                        <b-field label="value" class="in">
                            <b-input
                                type="number"
                                :value="value"
                                placeholder="Your value"
                                required>
                            </b-input>
                        </b-field>

                        <b-field label="currency" class="in"
            :label-position="labelPosition">
            <b-select placeholder="Select a currency" expanded>
            required>
                <option value="1"> </option>
                <option value="2"> </option>
            </b-select>
        </b-field>

 <b-field label="payment method" class="in"
            :label-position="labelPosition">
            <b-select placeholder="Select a method" expanded>
                <option value="1">cach </option>
                <option value="2">cheques</option>
                 <option value="3">bank transfer</option>
            </b-select>
        </b-field>

<b-field label="Bank" class="in"
            :label-position="labelPosition">
            <b-select placeholder="Select a bank" expanded>
                <option value="1">cach </option>
                <option value="2">cheques</option>
                 <option value="3">bank transfer</option>
            </b-select>
        </b-field>

        <b-field label="Date" class="in">
        <b-datepicker
            placeholder="Click to select..."
            icon="calendar-today">
        </b-datepicker>
    </b-field>

 <b-field label="payment method" class="in"
            :label-position="labelPosition">
            <b-select placeholder="Select a method" expanded>
                <option value="1">collected </option>
                <option value="2">non collected</option>
              
            </b-select>
        </b-field>
                        

                       
                    </section>
                    <footer class="modal-card-foot">
                        
                        <button class="btn_form">submit</button>
                    </footer>
                </div>
            </form>
        `
};

export default {
  data() {
    return {
      isImageModalActive: false,
      buttonState: "Income",
      pragrapgState: "p1",
      title:"Add income" ,
      isPaginated: true,
      isPaginationSimple: false,
      defaultSortDirection: "asc",
      currentPage: 1,
      perPage: 10,
      allProposals: [
        { id: "", first_name: "", last_name: "" },
        { id: "", first_name: "", last_name: "" }
      ],
      total: 0,
      page: 1,
      isComponentModalActive: false,
      incomes:[],
      outcomes:[],
      formProps:'',
    };
  },
  computed: {},
  mounted() {
    this.getData()
  },
  components: {
    ModalForm
  },
  methods: {
    change_btn(new_state) {
      this.buttonState = new_state;
    },
    change_prag(new_state1) {
      this.pragrapgState = new_state1;
      console.log(new_state1);      
      if("new_state1 == 'p1'")
      {
        this.title="Add income"
      }
      if("new_state1 == 'p2'")
      {
         this.title = "Add outcome"
      }
    },
    onPageChange(p) {

    },
    getData(){
      this.isLoading = true
          all_finances(this.page).then(response=>{
          console.log("financeees",response)
          // this.perPage = response.data.per_page
          this.incomes = response.data.income
          this.outcomes = response.data.outcome
          this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
          this.logsTotalNumber = response.data.total
          this.total = response.data.total
          
          // if(this.allAgent_type.length == 0){
          //     this.isEmpty = true
          // }
          // let currentTotal = response.data.total
          // if (response.data.total / this.perPage > 1000) {
          //     currentTotal = this.perPage * 1000
          // }

          // this.total = currentTotal
          this.isLoading = false
      

          })
      .catch(error => {
          console.log(error)
      })
      },
  }
};
</script>

<style scoped>
.f1 {
  position: relative;

  background: #ffffff;

  margin-bottom: 20px;
  width: 80%;
  box-shadow: 0 0px 20px rgba(0, 0, 0, 0.1);
  margin: auto;
}
.p1 {
  padding: 10px;
}
.notActive{
  background-color: #fff;
  color: #000;
  border-radius: 15px;
  height: 45px;
  margin-left: 10px;
  margin-top: 20px;
  width: 80px;
  border: none;
  outline: none; 
}
.btnn:hover {
  cursor: pointer;
}

.butns {
  border-bottom: 1px solid #ddd;
}
.btn_form {
  color: #fff;
  height: 35px;
  background-color: #205081;
  border-color: rgba(0, 0, 0, 0.2);
  float: right;
  margin: 20px;
}
.form_edit {
  position: relative;
  padding: 15px;
  width: 600px;
}
.in {
  width: 100%;
  height: 34px;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.42857143;
  color: #555;
  border: 1px solid #ccc;
}

.btn-click {
  background-color: #b07d12;
  color: white;
  border-radius: 15px;
  height: 45px;
  margin-left: 10px;
  margin-top: 20px;
  width: 80px;
  border: none;
  outline: none;
  border: gray;
}
</style>
<style>
.btn_form {
  color: #fff;
  height: 35px;
  background-color: #205081;
  border-color: rgba(0, 0, 0, 0.2);
  margin-left: 90%;
  
}
.active {
  background-color: #b07d12 !important;
  color: white !important;
  border-radius: 15px;
  height: 45px;
  margin-left: 10px;
  margin-top: 20px;
  width: 80px;
  outline: none;
}
</style>