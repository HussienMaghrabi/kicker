<template>
    <div>
        <div class="level mb-5">
                                    <div class="level">
                                        <div class="level-item">

                                        </div>
                                    </div>

                                    <div class="field">
                                    <div class="control has-icons-left">
                                        <div class="select">
                                        <select>
                                            <option value="all OPen Leads" selected>All Open Leads</option>
                                            <option value="Closed Leads">Closed Leads</option>
                                        </select>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="field">
                                    <div class="control has-icons-left">
                                        <div class="select  contacts">
                                        <select>
                                            <option value="Contacted" selected>Contacted</option>
                                            <option value="Not Contacted">Not Contacted</option>
                                        </select>
                                        </div>
                                    </div>
                                    </div>


                                    <div class="level">
                                        <div class="level-item filters">
                                          <div class="field  mr-10">
                                                <div class="control">
                                                    <input class="input is-meduim mt-10" type="text" placeholder="Search" v-model="searchInput" @input="search" style="margin-top:-19px !important">
                                                </div>
                                            </div>
                                          </div>
                                    </div>

                                </div>
                                <div class="" v-if="startFilter">
                                   <div class="columns mb-5 ml-0 filter-content">
                                    <div class="column is-2">
                                        <div class="field">
                                            <label class="label">Call Status</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="filter.call_status_id">
                                                        <option v-for="status in callStatus" :key="status.id" :value="status.id">{{status.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-2">
                                        <div class="field">
                                            <b-field label="From">
                                                <b-datepicker
                                                placeholder="Click to select..."
                                                :date-formatter="dateFormatterFrom"
                                                position="is-bottom-left" v-model="filter.from">
                                            </b-datepicker>
                                        </b-field>
                                        </div>
                                    </div>
                                    <div class="column is-2">
                                        <div class="field">
                                            <b-field label="To">
                                                <b-datepicker
                                                placeholder="Click to select..."
                                                :date-formatter="dateFormatterTo"
                                                position="is-bottom-left" v-model="filter.to">
                                            </b-datepicker>
                                        </b-field>
                                        </div>
                                    </div>

                            <div class="column is-2">
                                <div class="field">
                                    <label class="label">Meeting Status</label>
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select v-model="filter.meeting_status_id">
                                                <option v-for="status in meetingStatus" :key="status.id" :value="status.id">{{status.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-2">
                                <label class="label">Lead source</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="filter.sourceId">
                                            <option v-for="source in leadSources" :key="source.id" :value="source.id">{{source.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-2">
                                <label class="label">Location</label>
                                <div class="field has-addons">

                                    <div class="control is-expanded">
                                        <div class="select is-fullwidth">
                                            <select v-model="filter.location">
                                                <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns is-mobile mb-5 ml-0">
                            <div class="column is-4">
                                <label class="label">Tags</label>
                                <div class="control">
                                    <div class=" is-fullwidth">
                                        <multiselect :close-on-select="false" v-model="selectedTags"  tag-placeholder="Add this as new tag" placeholder="Select Tags" label="en_name" track-by="id" value="id" :options="tags" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                                    </div>
                                </div>
                                <div class="control">
                                    <a class="button is-success" @click="filterLeads">Get</a>
                                </div>
                            </div>
                            <div class="column is-4">
                                <label class="label">Phone ISO</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="phoneIso">
                                            <option value="national">National</option>
                                            <option value="international">International</option>
                                            <option value="both">Both</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-3">
                                <label class="label">probability</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="probability">
                                            <option value="Follow Up">Follow Up</option>
                                            <option value="On going">On going</option>
                                            <option value="Expected Closing">Expected Closing</option>
                                            <option value="Closed">Closed</option>
                                            <option value="Rotation">Rotation</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <b-table
                    :data="all_leads"
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
                        <b-table-column label="Lead" sortable>
                             <router-link :to="'/admin/vue/showLead/'+props.row.id" style="color:#4AAED5">
                                      {{ props.row.name }}
                             </router-link>
                        </b-table-column>

                        <b-table-column label="Lead Type" sortable>
                            <router-link :to="'/admin/vue/showLead/'+props.row.id" style="color:#4AAED5">
                                      {{ props.row.lead_type }}
                            </router-link>
                        </b-table-column>

                        <b-table-column label="Phone" sortable>
                            {{props.row.phone}}
                        </b-table-column>

                         <b-table-column label="Mobile" sortable>
                            {{props.row.mobile}}
                        </b-table-column>

                        <b-table-column label="Email" sortable>
                            {{props.row.email}}
                        </b-table-column>

                        <b-table-column label="Status" sortable>
                            <router-link :to="'/admin/vue/showLead/'+props.row.id" style="color:#4AAED5">
                                    {{props.row.lead_status}}
                             </router-link>
                        </b-table-column>

                        <b-table-column label="" sortable>
                            <i class="fas fa-envelope"></i>
                        </b-table-column>

                         <b-table-column label="Delete" sortable>
                            <i class="fas fa-trash-alt" @click="DeleteFromIndex(props.row.id)"></i>
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

           



            <!-- <div class="leads-number btns-leads">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div> -->




            <div class="buttons">
                    <b-button type="is-success"><i class="fas fa-envelope"></i>  Send Email</b-button>
                    <b-button type="is-info"><i class="fas fa-print"></i>  Print</b-button>
            </div>

            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>



        <!-- Hint Component -->

        <!-- <Hint :class="{openSide: ShowHint}" @closeSide="ShowHint = $event" :hintId='hintId' :fav="fav" :hot="hot" :flag="flag" :sideView='ShowHint' @changeHint="refreshPage"></Hint> -->
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
changeLeadFav
<script>
    import {deleteThislead} from './../../calls'

    import {getNewAllLeads} from './../../calls'
    import Hint from './Hint'
    import Multiselect from 'vue-multiselect'
    import axios from 'axios'
    export default {
       
        data() {
            return {
                all_leads:[],
                authType: '',
                call_status_id: null,
                dateFormatter: null,
                newCallData: {date: new Date()},
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                getLeadsByAgent: [],
                leadSources: [],
                isEmpty: false,
                isLoading: true,
                hasMobileCards: true,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: 1,
                perPage: 100,
                search:'',
                isLoading: true,
                isFullPage: true,
                searchInput: '',
                selectedLeads: [],

                ShowHint: false,
                hintId: '',
                fav: '',
                hot:'',
                callStatus: [],
                projects: [],
                locations: [],
                meetingStatus:[],
                filter: {},
                startFilter: false,
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
                role: window.auth_user.role,
                switchLeadModel: false,
                bulkActionModel: false,
                switchLeadData: {},
                leadsIds: [],
                commercialAgents: [],
                residentialAgents: [],
                permArray: [],
                reloadData: false,
                autoSwitchModel: false,
                autoSwitchData: {},
                deleteLeadsModal: false,
                flag: 0,
                tag_id: null,
                tags: [],
                selectedTags: [],
                tagIds : [],
                phoneIso: '',
                probability: '',
                project_id:null,
               
            }
        },
        mounted() {
            this.authType = window.auth_user.type
           
            axios.get('http://127.0.0.1:8000/api/lead').then((res)=>{
            this.all_leads=(res.data.data)
             console.log("--------------------------------")

            this.all_leads=(res.data.data)
            console.log(this.all_leads)
            })
             this.getData()
        },
        components: {
            Hint,
            Multiselect
        },
        created() {
            this.$router.replace({hash: '#/1'});
            this.page = parseInt(this.$route.hash.split('/')[1])
         },
         methods: {
        getData(loading = true){
            this.isLoading = loading
            getNewAllLeads(this.page).then(response=>{
                console.log('responseeee',response)
                this.perPage = response.data.per_page
                this.leads = response.data
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
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

                this.all_leads = response.data.data;
                //this.getPublic()
                    //console.log(response.data)

                })
            .catch(error => {
                console.log(error)
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
        onPageChange(page) {
            this.page = page
            this.$router.replace({ name: "MyLeads", params: {page: page} })
            if(this.fitlerFlag){
                this.filterLeads()
            }else {
                this.getData()
            }
        },
        success(action) {
            this.$toast.open({
                message: 'Lead '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        errorDialog() {
            this.$dialog.alert({
                title: 'Error',
                message: 'Please select the leads you want to switch frist',
                type: 'is-danger',
            })
        },
          errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the leads you want to switch frist',
                    type: 'is-danger',
                })
            },

             deleteItem(id){
                deleteThislead (id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                   
                })
                    .catch(error => {
                        this.errorDialog()
                        console.log(error)
                    })
            },

      DeleteFromIndex(id) {
                this.$dialog.confirm({
                    title: 'Deleting ',
                    message: 'Are you sure you want to <b>delete</b> Company?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteItem(id)
                })
            },
       
    }
}
</script>

<style type="text/css" scoped="">
.leads-number
{
    position: absolute;
    bottom: 80px;

}
@media screen and (max-width: 767px) {
.contacts{
    margin-bottom: 6%;
}
.btns-leads{
   margin-bottom: 35%;
}
}
@media screen and (max-width: 767px) {
    .filters {
        display: block;
    }

    .filter-btn {
        margin-right: 2% !important;
        margin-bottom: 2% !important;
    }

    .leads-number{
        right: 10% !important;
        bottom: 10px !important;
        left: unset !important;
    }

    .filter-content{
        margin-top: 2%;
    }
}
</style>
