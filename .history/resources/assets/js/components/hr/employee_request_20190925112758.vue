<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Request Types
                        </p>
                    </div>
                </div>
                <div class="level-right" style="padding:.5vw">
                    <b-button type="is-info" @click="AddModel = true">Add New</b-button>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-table
                                :data="EmpRequest"
                                :paginated="isPaginated"
                                :per-page="perPage"
                                :current-page.sync="page"
                                aria-next-label="Next page"
                                aria-previous-label="Previous page"
                                aria-page-label="Page"
                                aria-current-label="Current page">

                                <template slot-scope="props">
                                
                                    <b-table-column class="width" field="ID" label="ID" sortable>
                                        {{props.row.id}}
                                    </b-table-column>

                                    <b-table-column class="width" field="first_name" label="Name" sortable>
                                        {{props.row.first_name +' '+ props.row.last_name}}
                                    </b-table-column>

                                    <b-table-column class="width"  label="Request Type">
                                        {{props.row.type_name}}
                                    </b-table-column>

                                    <b-table-column class="width"  label="Request Status">
                                        {{props.row.status_name}}
                                    </b-table-column>

                                    <b-table-column class="width" field="from" label="From" sortable>
                                        {{props.row.from}}
                                    </b-table-column>

                                    <b-table-column class="width" field="too" label="Too" sortable>
                                        {{props.row.too}}
                                    </b-table-column>


                                    <b-table-column class="width" label="Note">
                                        {{props.row.note}}
                                    </b-table-column>

                                    <b-table-column label="Actions">
                                    <b-button  size="is-small" @click="editstatus(props.row.id)"><span style="color:green" class="fa fa-edit"></span></b-button>
                                    <b-button  size="is-small" @click="DeleteFromIndex(props.row.id)"><span style="color:red" class="fa fa-trash"></span></b-button>
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
                </section>
            </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>
        </div>
        <b-modal :active.sync="editModal" has-modal-card :can-cancel="false">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Change Status</p>
                    </header>
                    <section class="modal-card-body text-center">
                        <div class="col-is-12">
                                <b-select v-model="Emp_requestData.status_id" placeholder="Select status for change">
                                    <option v-for="option in AllStatus" :value="option.id" :key="option.id">
                                        {{ option.name }}
                                    </option>
                                </b-select>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button" type="button" @click="editModal = false">Close</button>
                        <button class="button is-primary" @click="EditEmpRequestStatus">Submit</button>
                    </footer>
                </div>
        </b-modal>
        <!--  -->
            <b-modal :active.sync="AddModel">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add New Request</p>
                    </header>
                    <section class="modal-card-body">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-6">
                                <label class="label">Lead source</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select>
                                            <!-- <option v-for="source in leadSources" :key="source.id" :value="source.id">{{source.name}}</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </b-modal>
    </div>
</template>
<script>
import {
    GetEmployeeRequests,ChangeRequestStatus,getAllStatusOfRequest,DeleteEmployeeRequest,UpdateRequestEmployee
} from './../../calls'

export default {
    data() {
        return {
            isFullPage:true,
            isLoading:true,
            EmpRequest:[],
            isPaginated:true,
            perPage:20,
            editModal:false,
            Emp_requestData:[],
            AllStatus:[],
            ReqID:null,
            AddModel:false,
            Employees:[],
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
            GetEmployeeRequests().then(response=>{
                this.isLoading = false
                this.EmpRequest = response.data
                console.log('Employee Request',this.EmpRequest)
            }).catch(error=>{
                console.log(error)
            })
        },
        getAllRequestStatus(){
            getAllStatusOfRequest().then(response=>{
                this.AllStatus = response.data
            }).catch(error=>{
                console.log(error)
            })
        },
        editstatus(RequestId){
            this.ReqID = RequestId
            this.editModal =true
            this.isLoading = true
            ChangeRequestStatus(RequestId).then(response=>{
            this.isLoading = false
                this.getAllRequestStatus()
                this.Emp_requestData = response.data[0]
                // console.log('employee_request',this.Emp_requestData)
            }).catch(error=>{
                console.log(error)
            })
        },
        EditEmpRequestStatus(){
                this.isLoading = true
                const bodyFormData = new FormData();
                for (let key in this.Emp_requestData) {
                    const value = this.Emp_requestData[key];
                    bodyFormData.set(key, value);
                }
            UpdateRequestEmployee(bodyFormData).then(response=>{
                this.isLoading = false
                this.editModal = false
                this.getData()
                this.alertsuccess('successfully Changed')
            }).catch(error=>{
                console.log(error)
            })
        },
        DeleteFromIndex(ReqID){
            this.$dialog.confirm({
                title: 'Deleting',
                message: 'Are you sure you want to <b>delete</b> this Request?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.TypeDeletecon(ReqID)
            })
        },
        TypeDeletecon(ReqID){
            this.isLoading = true
            DeleteEmployeeRequest(ReqID).then(response=>{
                this.isLoading = false
                this.alertdanger('Request Is Deleted')
                this.getData()
            }).catch(error=>{
                console.log(error)
            })
        },
        getAllEmployees(){
            AllEmployees().then(response=>{
                this.Employees = response.data
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
        alertdanger(massege){
            this.$toast.open({
                message: massege,
                position: 'is-bottom',
                type: 'is-danger'
            })
        },
    }
}
</script>

