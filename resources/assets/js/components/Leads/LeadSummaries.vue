<template>
    <div class="container is-fluid">
            <div class="card">
                <header class="card-header level ">
                    <div class="level">
                        <div class="level-item">
                            <p class="card-header-title">
                                Lead Summaries
                            </p>
                        </div>
                    </div>
                    <div class="level">
                        <div class="level-item filters">
                            <a class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="bulkDeleteDialog('0')">Bulk Delete</a>
                        </div>
                    </div>
                </header>
                <div class="card-content">
                            <b-table
                            :data="lead_summaries"
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

                            :checked-rows.sync="selectedSummaries"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="created_at"
                            >

                            <template slot-scope="props">
                                <b-table-column field="id" label="ID" sortable>
                                    {{props.row.id}}
                                </b-table-column>

                                <b-table-column field="inserted_by" label="Inserted By" sortable>
                                    {{props.row.inserted_by}}
                                </b-table-column>

                                <b-table-column field="national_leads_count" label="National Leads" sortable>
                                    {{props.row.national_leads_count}}
                                </b-table-column>
            
                                <b-table-column field="international_leads_count" label="International Leads" sortable>
                                    {{props.row.international_leads_count}}
                                </b-table-column>

                                <b-table-column field="duplicated_leads_count" label="Duplicated Leads" sortable>
                                    {{props.row.duplicated_leads_count}}
                                </b-table-column>

                                <b-table-column field="updated_leads_count" label="Updated Leads" sortable>
                                    {{props.row.updated_leads_count}}
                                </b-table-column>

                                <b-table-column field="wrong_numbers_count" label="Maybe Wrong Numbers" sortable>
                                    {{props.row.wrong_numbers_count}}
                                </b-table-column>

                                <b-table-column field="assigned_agents_count" label="Assigned Agents" sortable>
                                    {{props.row.assigned_agents_count}}
                                </b-table-column>
                                
                                <b-table-column field="unassigned_agents_count" label="UnAssigned Agents" sortable>
                                    {{props.row.unassigned_agents_count}}
                                </b-table-column>

                                <b-table-column field="created_at" label="Created At" sortable>
                                    {{props.row.created_at}}
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
                
            <div class="summaries-number">{{summariesCurrentNumber + ' / ' + summariesTotalNumber}}</div>

                <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
            </div>
    </div>
</template>

<script>
import {getLeadSummaries,deleteLeadsummaries} from './../../calls'

export default {

    data() {
            return {
                isLoading: false,
                isFullPage: true,
                selectedSummaries: [],
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,
                lead_summaries: [],
                isEmpty: false,
                summariesCurrentNumber: 0,
                summariesTotalNumber: 0,
                summaryIds: []
            }
        },
    mounted() {
         this.$router.replace({
            hash: '#/1'
        });
        this.getData()
    },
    components: {
    },
    methods: {
        getData(loading = true){
            this.isLoading = loading
            getLeadSummaries(this.page).then(response=>{
                console.log(response)
                    this.perPage = response.data.per_page
                    this.lead_summaries = response.data.data
                    this.summariesCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    this.summariesTotalNumber = response.data.total
                    this.total = response.data.total
                    if(this.lead_summaries.length == 0){
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
        onPageChange(page) {
            this.page = page
            var url = window.location.href.split("/");
            url[url.length-1] = ''+page
            window.location.href = url.join('/');
            this.getData()
        },
        bulkDeleteDialog(summary=0) {
            if(this.selectedSummaries.length != 0){
                this.confirmDeleteBulk()
            }else if(summary != 0){
                this.selectedSummaries.push(summary)
                this.confirmDeleteBulk()

            }else{
                this.errorDialog()
            }
        },
        errorDialog() {
            this.$dialog.alert({
                title: 'Error',
                message: 'Please select the summaries you want to switch frist',
                type: 'is-danger',
            })
        },
        success(action) {
            this.$toast.open({
                message: 'Summary '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        confirmDeleteBulk() {
            this.$dialog.confirm({
                title: 'Deleting Summaries',
                message: 'Are you sure you want to <b>delete</b> Bulk Summaries ?',
                confirmText: 'Delete Summaries',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteBulkSummary()
            })
        },
        deleteBulkSummary(){
            this.selectedSummaries.forEach(element => {
                this.summaryIds.push(element.id)
            });
            this.deleteselectedSummaries()
            this.selectedSummaries = []
            this.summaryIds = []
        },
        deleteselectedSummaries(){
            deleteLeadsummaries(this.summaryIds).then(response=>{
                console.log(response)
                this.getData()
                this.success('Deleted')
            })
            .catch(error => {
                console.log(error)
            })
        },
    }
}
</script>

<style type="text/css" scoped="">
.summaries-number
{
    position: absolute;
    left: 200px;
    bottom: 21.5vh;

}

@media screen and (max-width: 767px) {
    .filters {
        display: block;
    }

    .filter-btn {
        margin-right: 2% !important;
        margin-bottom: 2% !important;
    }

    .summaries-number{
        right: 10% !important;
        left: 285px !important;
    }

    .filter-content{
        margin-top: 2%;
    }
}
</style>