<template>
    <div>
        <section>
            <b-tabs v-model="activeTabActions" position="is-centered" class="block">
                <b-tab-item label="Resale">                
                    <b-table
                    :data="leads"
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
                        <b-table-column field="id" label="ID" sortable>
                            {{props.row.id}}
                        </b-table-column>

                        <b-table-column field="status" label="R. Status" sortable>
                            <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-if="props.row.personal_status > 0"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
                        </b-table-column>

                        <b-table-column field="seen" label="Seen" sortable>
                            <i class="fa fa-circle" aria-hidden="true" style="color: orange;" v-if="props.row.seen == 1"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-else-if="props.row.seen == 2"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: #ccffcc;" v-else-if="props.row.seen == 3"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
                        </b-table-column>

                        <b-table-column field="leadProbability" label="Probability" sortable>
                            {{props.row.leadProbability}}
                        </b-table-column>

                        <b-table-column field="first_name" label="Name" sortable>
                            {{props.row.first_name+' '+props.row.last_name}}
                        </b-table-column>

                        <b-table-column field="tag" label="Tag" sortable>
                            {{props.row.tag}}
                        </b-table-column>
                        
                        <b-table-column field="phone" label="Hint" centered>
                            <i class="fa fa-eye" aria-hidden="true" @click="openHint(props.row.id, props.row.hot, props.row.favorite)"></i>
                        </b-table-column>

                        <b-table-column field="phone" label="Phone" sortable>
                            {{props.row.phone}}
                        </b-table-column>

                        <b-table-column field="sourceName" label="Source" sortable>
                            {{props.row.sourceName}}
                        </b-table-column>

                        <b-table-column field="requestLocation" label="Req Location" sortable>
                            {{props.row.requestLocation}}
                        </b-table-column>

                        <b-table-column field="projectName" label="Req Project" sortable>
                            {{props.row.projectName}}
                        </b-table-column>

                        <b-table-column field="created_at" label="Created At" sortable>
                            {{props.row.created_at}}
                        </b-table-column>

                        <b-table-column field="type" label="Type" sortable >
                            <span v-if="props.row.type">{{props.row.type}}</span>
                            <span v-else>N/A</span>
                        </b-table-column>

                        <b-table-column field="favorite" label="Favorite" centered sortable>
                            <i class="fa fa-star" aria-hidden="true" style="color: #caa42d" v-if="Number(props.row.favorite)" @click="changeLeadStatus('fav',props.row.id)"></i>
                            <i class="fa fa-star" aria-hidden="true"  v-else @click="changeLeadStatus('fav',props.row.id)"></i>
                        </b-table-column>

                        <b-table-column field="hot" label="Hot" centered sortable>
                            <i class="fa fa-fire" aria-hidden="true"  style="color: #caa42d" v-if="Number(props.row.hot)" @click="changeLeadStatus('hot',props.row.id)"></i>
                            <i class="fa fa-fire" aria-hidden="true" v-else @click="changeLeadStatus('hot',props.row.id)"></i>
                        </b-table-column>

                        <b-table-column field="phone" label="Options" centered>
                            <div class="select">
                                <select @change="leadActions($event,props.row.id)">
                                    <option selected value="options">Options</option>
                                    <option value="show">Show</option>
                                    <option value="edit">Edit</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                        </b-table-column>

                        <!-- <b-table-column field="id" label="Switch" centered v-if="permArray.switch_leads == 1 || userType == 'admin'  || role == '1'">
                            <a class="button is-success is-small" @click="switchLeadDialog(props.row)">Switch</a>
                        </b-table-column> -->

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
                </b-tab-item>
                <b-tab-item label="Rental">                
                    <b-table
                    :data="leads"
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
                        <b-table-column field="id" label="ID" sortable>
                            {{props.row.id}}
                        </b-table-column>

                        <b-table-column field="status" label="R. Status" sortable>
                            <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-if="props.row.personal_status > 0"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
                        </b-table-column>

                        <b-table-column field="seen" label="Seen" sortable>
                            <i class="fa fa-circle" aria-hidden="true" style="color: orange;" v-if="props.row.seen == 1"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-else-if="props.row.seen == 2"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: #ccffcc;" v-else-if="props.row.seen == 3"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
                        </b-table-column>

                        <b-table-column field="leadProbability" label="Probability" sortable>
                            {{props.row.leadProbability}}
                        </b-table-column>

                        <b-table-column field="first_name" label="Name" sortable>
                            {{props.row.first_name+' '+props.row.last_name}}
                        </b-table-column>

                        <b-table-column field="tag" label="Tag" sortable>
                            {{props.row.tag}}
                        </b-table-column>
                        
                        <b-table-column field="phone" label="Hint" centered>
                            <i class="fa fa-eye" aria-hidden="true" @click="openHint(props.row.id, props.row.hot, props.row.favorite)"></i>
                        </b-table-column>

                        <b-table-column field="phone" label="Phone" sortable>
                            {{props.row.phone}}
                        </b-table-column>

                        <b-table-column field="sourceName" label="Source" sortable>
                            {{props.row.sourceName}}
                        </b-table-column>

                        <b-table-column field="requestLocation" label="Req Location" sortable>
                            {{props.row.requestLocation}}
                        </b-table-column>

                        <b-table-column field="projectName" label="Req Project" sortable>
                            {{props.row.projectName}}
                        </b-table-column>

                        <b-table-column field="created_at" label="Created At" sortable>
                            {{props.row.created_at}}
                        </b-table-column>

                        <b-table-column field="type" label="Type" sortable >
                            <span v-if="props.row.type">{{props.row.type}}</span>
                            <span v-else>N/A</span>
                        </b-table-column>

                        <b-table-column field="favorite" label="Favorite" centered sortable>
                            <i class="fa fa-star" aria-hidden="true" style="color: #caa42d" v-if="Number(props.row.favorite)" @click="changeLeadStatus('fav',props.row.id)"></i>
                            <i class="fa fa-star" aria-hidden="true"  v-else @click="changeLeadStatus('fav',props.row.id)"></i>
                        </b-table-column>

                        <b-table-column field="hot" label="Hot" centered sortable>
                            <i class="fa fa-fire" aria-hidden="true"  style="color: #caa42d" v-if="Number(props.row.hot)" @click="changeLeadStatus('hot',props.row.id)"></i>
                            <i class="fa fa-fire" aria-hidden="true" v-else @click="changeLeadStatus('hot',props.row.id)"></i>
                        </b-table-column>

                        <b-table-column field="phone" label="Options" centered>
                            <div class="select">
                                <select @change="leadActions($event,props.row.id)">
                                    <option selected value="options">Options</option>
                                    <option value="show">Show</option>
                                    <option value="edit">Edit</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                        </b-table-column>

                        <!-- <b-table-column field="id" label="Switch" centered v-if="permArray.switch_leads == 1 || userType == 'admin'  || role == '1'">
                            <a class="button is-success is-small" @click="switchLeadDialog(props.row)">Switch</a>
                        </b-table-column> -->

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
                </b-tab-item>
                <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div>
            </b-tabs>
            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
        </section>
        <Hint :class="{openSide: ShowHint}" @closeSide="ShowHint = $event" :hintId='hintId' :fav="fav" :hot="hot" :flag="flag" :sideView='ShowHint' @changeHint="refreshPage"></Hint>
    </div>    
</template>
        
<script>
import {getUnitLeads,changeLeadFav,changeLeadHot} from './../../calls'
import Hint from './Hint'

export default {
    data() {
        return{
            resales: [],
            rentals: [],
            leadsCurrentNumber: 0,
            leadsTotalNumber: 0,
            isLoading: true,
            isFullPage: true,
            isPaginated: true,
            isPaginationSimple: false,
            defaultSortDirection: 'desc',
            total: 0,
            page: parseInt(this.$route.hash.split('/')[1]),
            perPage: 100,
            tab: 'Resale',
            leads: [],
            isEmpty: false,
            selectedLeads: [],
            ShowHint: false,
            hintId: '',
            token: window.auth_user.csrf,
            userId: window.auth_user.id,
            userType: window.auth_user.type,
            flag: 0,
            activeTabActions: 0,
            fav: '',
            hot:'',
        }
    },
    mounted() {
        this.getData()
    },
    created() {
        this.$router.replace({hash: '#/1'});
    },
    watch: {
        'activeTabActions': function() {
            this.getData();
        }
    },
    components: {
        Hint,
    },
    methods: {
        refreshPage() {
            this.getData();   
        },
        onPageChange(page) {
            this.page = page
            this.$router.replace({ name: "OwnedUnits", params: {page: page} })
            this.getData()
        },
        getData(loading = true){
            this.isLoading = loading
            var data ={
                'page':this.page,
                'tab':this.activeTabActions,
            };
            getUnitLeads(data).then(response=>{
                this.perPage = response.data.per_page
                this.leads = response.data.data
                console.log("TEST",response.data)
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    this.leadsTotalNumber = response.data.total
                    this.total = response.data.total
                    // this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    // this.leadsTotalNumber = response.data.total
                    // this.total = response.data.total

                    // if(this.leads.length == 0){
                    //     this.isEmpty = true
                    // }
                    // let currentTotal = response.data.total
                    // if (response.data.total / this.perPage > 1000) {
                    //     currentTotal = this.perPage * 1000
                    // }

                    // this.total = currentTotal
                this.isLoading = false
                    //console.log(response.data)

                })
            .catch(error => {
                console.log(error)
            })
        },
        changeLeadStatus(type,id){
            if(type == 'fav'){
                changeLeadFav({id:id}).then(response=>{
                    console.log(response)
                    this.getData()
                })
                .catch(error => {
                    console.log(error)
                })
            }else if (type == 'hot'){
                changeLeadHot({id:id}).then(response=>{
                    console.log(response)
                    this.getData()
                })
                .catch(error => {
                    console.log(error)
                })
            }
        },
        openHint(id, hot, fav){
            this.ShowHint = true
            this.hintId = id
            this.hot = hot
            this.fav = fav
            this.reloadData = true

            if(id == this.hintId)
            this.flag = Math.random();

            setInterval(function () {
                if(this.reloadData) {
                        // this.getData(false)
                        this.reloadData = false
                    }
                }.bind(this), 5000);
            },
            getRowClass(row) {
                if (!row.seen) return 'rowDanger'
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
    }
} 

</script>
        
<style type="text/css" scoped="">
.leads-number
{
    position: absolute;
    left: 200px;
    bottom: 45px;

}
</style>
        