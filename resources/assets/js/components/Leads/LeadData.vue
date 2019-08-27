<template>
    <div>
        <div class="level mb-5">
            <div class="level">
                <div class="level-item">
                </div>
            </div>            
        </div>
        <div class="container is-fluid">
            <div class="card">
                <header class="card-header level ">
                    <div class="level">
                        <div class="level-item">
                            <p class="card-header-title">
                                Lead Data
                            </p>
                        </div>
                    </div>
                    <div class="level">
                        <div class="level-item filters">
                            <router-link to="/admin/vue/lead_data_xls" class="button is-success filter-btn" style="margin-right: 50px;">Import Lead Data</router-link>
                        </div>
                        <div class="level-item filters">
                            <a class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="bulkDeleteDialog('0')">Bulk Delete</a>
                        </div>
                    </div>
                </header>
                <div class="card-content">
                    <div class="columns is-mobile mb-5 ml-0" style="margin-top:10px">
                        <!-- <div class="column is-3">
                            <div class="field">
                                <b-field label="Sender Date">
                                    <b-datepicker
                                    placeholder="Click to select..."
                                    :date-formatter="dateFormatterSenderDate"
                                    position="is-bottom-left" v-model="filter.sent_date">
                                </b-datepicker>
                            </b-field>
                            </div>
                        </div> -->
                    </div>
                    <div class="columns is-mobile mb-5 ml-0" style="margin-top:5px">
                        <!-- <div class="column is-2">
                            <div class="control" style="margin-top: 10%;">
                                <a class="button is-success" @click="filterCils">Filter</a>
                            </div>
                        </div> -->
                    </div>
                    <b-table
                            :data="leadsData"
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

                            :checked-rows.sync="selectedLeadsData"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="created_at"
                            >

                            <template slot-scope="props">
                                <b-table-column field="id" label="ID" sortable>
                                    {{props.row.id}}
                                </b-table-column>

                                <b-table-column field="lead_name" label="Lead Name" sortable>
                                    {{props.row.lead_first_name}} {{props.row.lead_last_name}}
                                </b-table-column>

                                <b-table-column field="phone" label="Phone" sortable>
                                    {{props.row.phone}}
                                </b-table-column>

                                <b-table-column field="tag" label="Tag" sortable>
                                    {{props.row.tag}}
                                </b-table-column>

                                <b-table-column field="comment" label="Comment" sortable>
                                    {{props.row.comment}}
                                </b-table-column>

                                <b-table-column field="agent" label="Agent" sortable>
                                    {{props.row.agent}}
                                </b-table-column>

                                <b-table-column field="c_agent" label="Commercial Agent" sortable>
                                    {{props.row.c_agent}}
                                </b-table-column>

                                <b-table-column field="created_at" label="Created At" sortable>
                                    {{props.row.created_at}}
                                </b-table-column>
               
                                <!-- <b-table-column field="options" label="Options" centered>
                                    <div class="select">
                                        <select @change="cilActions($event,props.row.id)">
                                            <option disabled selected value="options">Options</option>
                                            <option value="show">Show</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                    </div>
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
                
                </div>
            </div>
        </div>
        <div class="cils-number">{{leadsDataCurrentNumber + ' / ' + leadsDataTotalNumber}}</div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>

    </div>
</template>

<script>
    import {getLeadsData,deleteCil,sendCils,updateCilsStatus,getCilFilterData,filterCils,getCilReplies,deleteLeadsData} from './../../calls'
    export default {
        data() {
            return {
                isLoading: false,
                isFullPage: true,
                selectedCils: [],
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,
                cils: [],
                isEmpty: false,
                leadsDataCurrentNumber: 0,
                leadsDataTotalNumber: 0,
                ShowHint: false,
                hintId: '',
                reloadData: false,
                flag: 0,
                url: window.location.href,
                developers: [],
                projects: [],
                filter: {},
                showReplies: false,
                replies: [],
                leadsData: [],
                selectedLeadsData: []
            }
        },
        created() {
            this.$router.replace({hash: '#/1'});
         },
        mounted() {
            this.getData()
        },
        components: {
        },
        methods: {
            getData(loading = true){
                this.isLoading = loading
                getLeadsData(this.page).then(response=>{
                        console.log(response)
                        this.perPage = response.data.per_page
                        this.leadsData = response.data.data
                        this.leadsDataCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                        this.leadsDataTotalNumber = response.data.total
                        this.total = response.data.total
                        if(this.leadsData.length == 0){
                            this.isEmpty = true
                        }
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
            // filterCils(loading = true){
            //     this.isLoading = loading
            //     var developers = []
            //     var projects = []
            //     if(this.filter.developers){
            //         var developers = this.filter.developers.map((developer) => {
            //             return developer.id;
            //         });
            //     }
            //     if(this.filter.projects){
            //         var projects = this.filter.projects.map((project) => {
            //             return project.id;
            //         });
            //     }
                
            //     var data ={
            //         'developers': developers,
            //         'projects': projects,
            //         'status': this.filter.status,
            //         'sent_date': this.filter.sent_date,
            //         'expire_on': this.filter.expire_on,
            //         'created_at': this.filter.created_at,
            //         '_token':this.token,
            //     };
            //     filterCils(data).then(response=>{
            //             console.log(response)
            //             this.perPage = response.data.per_page
            //             this.cils = response.data.data
            //             this.cilsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
            //             this.cilsTotalNumber = response.data.total
            //             this.total = response.data.total
            //             if(this.cils.length == 0){
            //                 this.isEmpty = true
            //             }
            //             let currentTotal = response.data.total
            //             if (response.data.total / this.perPage > 1000) {
            //                 currentTotal = this.perPage * 1000
            //             }
            //             this.total = currentTotal                    
            //             this.isLoading = false
            //         })
            //     .catch(error => {
            //         console.log(error)
            //     })
            // },
            // getCilFilter(){
            //     getCilFilterData().then(response=>{
            //         console.log(response);
            //         this.developers = response.data.developers
            //         this.projects = response.data.projects
            //     })
            //     .catch(error => {
            //         console.log(error)
            //     })
            // },
            onPageChange(page) {
                this.page = page
                var url = window.location.href.split("/");
                url[url.length-1] = ''+page
                window.location.href = url.join('/');
                this.getData()
            },
            bulkDeleteDialog(leadData=0) {
                if(this.selectedLeadsData.length != 0){
                    this.confirmDeleteBulk()
                }else if(leadData != 0){
                    this.selectedLeadsData.push(leadData)
                    this.confirmDeleteBulk()

                }else{
                    this.errorDialog()
                }
            },
            confirmDeleteBulk() {
                this.$dialog.confirm({
                    title: 'Deleting Leads Data',
                    message: 'Are you sure you want to <b>delete</b> Bulk Leads Data ?',
                    confirmText: 'Delete Leads Data',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteBulkLeadsData()
                })
            },
            deleteBulkLeadsData(){
                const leadsDataIds = this.selectedLeadsData.map((leadData) => {
                    return leadData.id;
                });
                var data ={
                    'leadsDataIds': leadsDataIds,
                    '_token':this.token,
                };
                deleteLeadsData(data).then(response=>{
                    console.log(response)
                    this.getData()
                    this.success('Deleted')
                })
                .catch(error => {
                    console.log(error)
                })
                this.selectedLeadsData = []
                this.summaryIds = []
            },
            errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select Leads Data that you want first',
                    type: 'is-danger',
                })
            },
            success(action) {
                this.$toast.open({
                    message: 'Lead Data '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
        }
    }
</script>

<style type="text/css" scoped="">
.cils-number
{
    position: absolute;
    left: 200px;
    bottom: 17.5vh;

}

@media screen and (max-width: 767px) {
    .cils-number{
        right: 10% !important;
        left: 285px !important;
    }
}
</style>