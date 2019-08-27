<template>
    <div class="container is-fluid">
            <div class="card">
                <header class="card-header level ">
                    <div class="level">
                        <div class="level-item">
                            <p class="card-header-title">
                                Duplicated Leads
                            </p>
                        </div>
                    </div>
                    <div class="level">
                        <div class="level-item filters">
                            <div class="field  mr-10">
                                <div class="control">
                                    <input class="input is-meduim mt-10" type="text" placeholder="Search" v-model="searchInput" @input="search">
                                </div>
                            </div>
                            <a class="button is-success is-small filter-btn" style="margin-right: 25px;margin-left: 15px;" @click="bulkInsertDialog('0')">Bulk Insert</a>
                            <a class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="bulkDeleteDialog('0')">Bulk Delete</a>
                        </div>
                    </div>
                </header>
                <div class="card-content">
                            <b-table
                            :data="duplicated_leads"
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

                                <b-table-column field="status" label="Lead Status" sortable>
                                    <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-if="props.row.lead_color == 1"></i>
                                    <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
                                </b-table-column>

                                <b-table-column field="status" label="Archive Status" sortable>
                                    <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-if="props.row.archive_color == 1"></i>
                                    <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
                                </b-table-column>

                                <b-table-column field="first_name" label="Name" sortable>
                                    {{props.row.first_name+' '+props.row.last_name}}
                                </b-table-column>
                                
                                <b-table-column field="phone_iso" label="Phone Iso" sortable>
                                    {{props.row.phone_iso}}
                                </b-table-column>

                                <b-table-column field="phone" label="Phone" sortable>
                                    {{props.row.phone}}
                                </b-table-column>

                                <b-table-column field="old_agent_residential" label="Old Agent Residential" sortable>
                                    {{props.row.old_agent_residential}}
                                </b-table-column>

                                <b-table-column field="old_agent_commercial" label="Old Agent Commercial" sortable>
                                    {{props.row.old_agent_commercial}}
                                </b-table-column>

                                <b-table-column field="new_agent_residential" label="New Agent Residential" sortable>
                                    {{props.row.new_agent_residential}}
                                </b-table-column>

                                <b-table-column field="new_agent_commercial" label="New Agent Commercial" sortable>
                                    {{props.row.new_agent_commercial}}
                                </b-table-column>

                                <b-table-column field="created_at" label="Created At" sortable>
                                    {{props.row.created_at}}
                                </b-table-column>

                                <b-table-column field="insert" label="Insert">
                                    <a class="button is-success is-small" @click="leadActions($event,props.row.id)">Insert</a>
                                </b-table-column>

                                <b-table-column field="delete" label="Delete">
                                    <a class="button is-success is-small" @click="leadActions($event,props.row.id)">Delete</a>
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
                
            <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div>

                <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
            </div>
    </div>
</template>

<script>
import {getDuplicatedLeads,deleteDuplicateLead,deleteDuplicateLeads,replaceDuplicateLead,searchForDuplicate,replaceDuplicateLeads} from './../../calls'

export default {

    data() {
            return {
                isLoading: false,
                isFullPage: true,
                selectedLeads: [],
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,
                duplicated_leads: [],
                isEmpty: false,
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                leadsIds: [],
                searchInput: "",
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
            getDuplicatedLeads(this.page).then(response=>{
                    this.perPage = response.data.per_page
                    this.duplicated_leads = response.data.data
                    this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    this.leadsTotalNumber = response.data.total
                    this.total = response.data.total
                    if(this.duplicated_leads.length == 0){
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
        leadActions(event,id){
            var action = event.target.innerText;
            if(action == 'Insert'){
                this.confirmReplace(id)
            }
            else if(action == 'Delete') {
                this.confirmDelete(id)
            }
        },
        confirmReplace(id) {
            this.$dialog.confirm({
                title: 'Replacing Lead',
                message: 'Are you sure you want to <b>replace</b> Lead?',
                confirmText: 'Replace Lead',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.replaceThisLead(id)
            })
        },
        replaceThisLead(id){
            this.isLoading = true
            replaceDuplicateLead(id).then(response=>{
                console.log(response)
                this.getData()
                this.success('Deleted')
            })
            .catch(error => {
                console.log(error)
            })
        },
        confirmDelete(id) {
            this.$dialog.confirm({
                title: 'Deleting Lead',
                message: 'Are you sure you want to <b>delete</b> Lead?',
                confirmText: 'Delete Lead',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteThisLead(id)
            })
        },
        deleteThisLead(id){
            this.isLoading = true
            deleteDuplicateLead(id).then(response=>{
                console.log(response)
                this.getData()
                this.success('Deleted')
            })
            .catch(error => {
                console.log(error)
            })
        },
        bulkDeleteDialog(lead=0) {
            if(this.selectedLeads.length != 0){
                this.confirmDeleteBulk()
            }else if(lead != 0){
                this.selectedLeads.push(lead)
                this.confirmDeleteBulk()

            }else{
                this.errorDialog()
            }
        },
        bulkInsertDialog(lead=0) {
            if(this.selectedLeads.length != 0){
                this.confirmInsertBulk()
            }else if(lead != 0){
                this.selectedLeads.push(lead)
                this.confirmInsertBulk()
            }else{
                this.errorDialog()
            }
        },
        errorDialog() {
            this.$dialog.alert({
                title: 'Error',
                message: 'Please select the leads you want to switch frist',
                type: 'is-danger',
            })
        },
        success(action) {
            this.$toast.open({
                message: 'Lead '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        confirmDeleteBulk() {
            this.$dialog.confirm({
                title: 'Deleting Leads',
                message: 'Are you sure you want to <b>delete</b> Bulk Leads ?',
                confirmText: 'Delete Leads',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteBulkLead()
            })
        },
        confirmInsertBulk() {
            this.$dialog.confirm({
                title: 'Inserting Leads',
                message: 'Are you sure you want to <b>insert</b> Bulk Leads ?',
                confirmText: 'Insert Leads',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.insertBulkLead()
            })
        },
        deleteBulkLead(){
            this.selectedLeads.forEach(element => {
                this.leadsIds.push(element.id)
            });
            this.deleteSelectedLeads()
            this.selectedLeads = []
            this.leadsIds = []
        },
        insertBulkLead(){
            this.selectedLeads.forEach(element => {
                this.leadsIds.push(element.id)
            });
            this.insertSelectedLeads()
            this.selectedLeads = []
            this.leadsIds = []
        },
        deleteSelectedLeads(){
            deleteDuplicateLeads(this.leadsIds).then(response=>{
                console.log(response)
                this.getData()
                this.success('Deleted')
            })
            .catch(error => {
                console.log(error)
            })
        },
        insertSelectedLeads(){
            replaceDuplicateLeads(this.leadsIds).then(response=>{
                console.log(response)
                this.getData()
                this.success('Deleted')
            })
            .catch(error => {
                console.log(error)
            })
        },
        search() {
            if (this.searchInput) {
                //this.isLoading = true
                var data = {
                    searchInput: this.searchInput,
                    _token: this.token,
                    agent_id: this.userId
                };
                searchForDuplicate(data)
                .then(response => {
                    this.duplicated_leads = response.data;
                    //this.isLoading = false
                })
                .catch(error => {
                    console.log(error);
                });
            }
        },
    }
}
</script>

<style type="text/css" scoped="">
.leads-number
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

    .leads-number{
        right: 10% !important;
        left: 285px !important;
    }

    .filter-content{
        margin-top: 2%;
    }
}
</style>