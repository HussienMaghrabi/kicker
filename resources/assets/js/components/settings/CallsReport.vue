<template>
<div> 
    <section class="container reports">
       <h3>Agent Status Report</h3><hr>
       <div>
            <b><label class="typo__label">Agent Name</label></b>
            <multiselect v-model="agentsArray" :options="agents" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="id" :preselect-first="true">
            </multiselect>
      </div>
       <div>
            <b><label class="typo__label">Lead source</label></b>
            <multiselect v-model="sourcesArray" :options="sourecs" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="id" :preselect-first="true">
            </multiselect>
      </div>

        <div class="column second">
           <div class="is-6">
                 <b-field label="From">
                    <b-datepicker
                        v-model="fromDate"
                        :date-formatter="dateFormatterFrom"
                        icon="calendar-today">
                    </b-datepicker>
                  </b-field>
           </div>
      
           <div class="is-6">
                 <b-field label="To">
                    <b-datepicker
                        v-model="toDate"
                        :date-formatter="dateFormatterTo"
                        icon="calendar-today">
                    </b-datepicker>
                  </b-field>
           </div>

       </div>

        <b-button @click="viewRebortCalls" type="is-info btn-get">GET</b-button>
 
    </section>
     <section class="data container">
        <b-table
            :data="data"
            :paginated="isPaginated"
            :per-page="perPage"
            :current-page.sync="currentPage"
            :pagination-simple="isPaginationSimple"
            :pagination-position="paginationPosition"
            :default-sort-direction="defaultSortDirection"
            :sort-icon="sortIcon"
            :sort-icon-size="sortIconSize"
            default-sort="user.name"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page">

            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" sortable numeric>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column  label="Agent" sortable>
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column  label="Lead name" sortable>
                    {{ props.row.first_name }} {{ props.row.last_name }}
                </b-table-column>

                <b-table-column  label="Phone" sortable>
                    {{ props.row.phone }}
                </b-table-column>

                <b-table-column  label="call status" sortable>
                    {{ props.row.call_status_name }}
                </b-table-column>

                <b-table-column  label="lead source" sortable>
                    {{ props.row.lead_source }}
                </b-table-column>

                <b-table-column  label="Description " sortable>
                    {{ props.row.description }}
                </b-table-column>
                  <b-table-column  label="Date " sortable>
                    {{ props.row.created_at }}
                </b-table-column>
            </template>
        </b-table>
    </section>
</div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.reports{
    background: #fff;
    padding-left: 2%;
}
.btn-get{
    margin-bottom: 2%;
    margin-top: 2%;
}
</style>
<script>
import {getAllAgents,sendInfoTorebortByCalls,LeadSources} from './../../calls'
import Multiselect from 'vue-multiselect'
export default {
  components: {
    Multiselect
  },
  data () {
    return {
        isPaginated: true,
        isPaginationSimple: false,
        paginationPosition: 'bottom',
        defaultSortDirection: 'asc',
        sortIcon: 'arrow-up',
        sortIconSize: 'is-small',
        currentPage: 1,
        perPage: 5,
      agents:[],
      agentsArray:[],
      value: [],
      data: [],
      fromDate: '',
      toDate: '',
      rebortInfo: [],
      sourcesArray: [],
      sourecs: [],
      calls: [],
      source_id: '',
    }
  },
  mounted() {
        this.getData()
        this.getAllSorces()
    },
  methods: {
      getAllSorces(){
        LeadSources().then(response=>{
            this.sourecs = response.data.data
            console.log('sources Array',response)
        }).catch(error=>{
            console.log(error)
        })
      },
     getData(){
                this.isLoading = true
                    getAllAgents(this.page).then(response=>{
                    console.log("TEST",response)
                    this.perPage = response.data.per_page
                    this.agents = response.data
                    console.log('agents',response)
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
                })
            },
            viewRebortCalls(){
              this.isLoading = true
                const bodyFormData = new FormData();
                // console.log('ids',this.group_members_ids)
                for (let key in this.rebortInfo) {
                    const value = this.rebortInfo[key];
                    bodyFormData.set(key, value);
                }
                for (var i = 0; i < this.agentsArray.length; i++) {
                    bodyFormData.append('agents[]', this.agentsArray[i].id);
                }
                for (var i = 0; i < this.sourcesArray.length; i++) {
                    bodyFormData.append('sources[]', this.sourcesArray[i].id);
                }
                    bodyFormData.append('fromDate', this.fromDate);
                    bodyFormData.append('toDate', this.toDate);
              sendInfoTorebortByCalls(bodyFormData).then(response=>{
                  this.isLoading = false
                  this.alertsuccess('success get some reports')
                  this.data = response.data
                //   this.calls = response.data.calls
                //   this.source_id = response.data.selected_sources
                  console.log('All_response',response)
              }).catch(error=>{
                console.log(error)
              })
            },
            alertsuccess(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-success'
                })
            },
            alerterror(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-danger'
                })
            },
            dateFormatterFrom(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.fromDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            dateFormatterTo(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.toDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
  },
}
</script>
<style>
/* .data
{
    display: none;
} */
</style>

