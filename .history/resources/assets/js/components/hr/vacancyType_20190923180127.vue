<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            vacancy Types
                        </p>
                    </div>
                </div>
                <div class="level-right" style="padding:.5vw">
                    <b-button type="is-info" @click="AddModel = true">Add New</b-button>
                  <!-- <router-link :to="'/admin/vue/AddVatype'">
                  </router-link> -->
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-table
                                :data="VacansiesType"
                                :paginated="isPaginated"
                                :per-page="perPage"
                                :current-page.sync="currentPage"
                                :pagination-simple="isPaginationSimple"
                                :pagination-position="paginationPosition"
                                :default-sort-direction="defaultSortDirection"
                                default-sort="user.first_name"
                                aria-next-label="Next page"
                                aria-previous-label="Previous page"
                                aria-page-label="Page"
                                aria-current-label="Current page">

                                <template slot-scope="props">
                                
                                    <b-table-column class="width" field="id" label="Name" sortable>
                                        {{ props.row.name }}
                                    </b-table-column>

                                    <b-table-column label="Update">
                                        <b-button type="is-warning" @click="openEditForm(props.row.id)"> Edit <span class="fa fa-pen"></span> </b-button>
                                    </b-table-column>

                                    <b-table-column label="Delete" >
                                    <b-button type="is-danger" @click="DeleteFromIndex(props.row.id)">Delete</b-button>
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
            <b-modal :active.sync="AddModel" has-modal-card :can-cancel="false">
                    <div class="modal-card" style="width: auto">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Add New </p>
                        </header>
                        <section class="modal-card-body text-center">
                            <div class="col-is-12">
                                <b-field label="New Type">
                                    <b-input v-model="NewType"></b-input>
                                </b-field>
                            </div>
                        </section>
                        <footer class="modal-card-foot">
                            <button class="button" type="button" @click="AddModel = false">Close</button>
                            <button class="button is-primary" @click="StoreNewType">Submit</button>
                        </footer>
                    </div>
            </b-modal>
            <b-modal :active.sync="editmodal" has-modal-card :can-cancel="false">
                    <div class="modal-card" style="width: auto">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Edit Type</p>
                        </header>
                        <section class="modal-card-body text-center">
                            <div class="col-is-12">
                                <b-field label="Edit Type">
                                    <b-input v-model="NewType"></b-input>
                                    <b-input v-model="TypeID" hidden></b-input>
                                </b-field>
                            </div>
                        </section>
                        <footer class="modal-card-foot">
                            <button class="button" type="button" @click="editmodal = false">Close</button>
                            <button class="button is-primary" @click="editType">Submit</button>
                        </footer>
                    </div>
            </b-modal>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>
        </div>
    </div>
</template>
<script>
import {
    getVacancyType,StoreNewVacType,DeleteVacType,getVacTypeData
} from './../../calls'

export default {
    data() {
        return {
            isEmpty:true,
            isFullPage:true,
            isLoading:true,
            page:1,
            VacansiesType:[],
            perPage:null,
            currentPage: 1,
            isPaginated:true,
            AddModel:false,
            NewType:null,
            editmodal:false,
            TypeID:null
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
            getVacancyType(this.page).then(response=>{
                this.VacansiesType = response.data.data
                this.perPage = response.data.per_page
                this.isLoading = false
            }).catch(error=>{
                console.log(error)
            })
        },
        onPageChange(page) {
            this.page = page
        },
        DeleteFromIndex(id){
            this.$dialog.confirm({
                title: 'Deleting',
                message: 'Are you sure you want to <b>delete</b> this element?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.TypeDeletecon(id)
            })
        },
        TypeDeletecon(id){
            this.isLoading = true
            DeleteVacType(id).then(response=>{
                this.isLoading = false
                this.alertdanger('Type Is Deleted')
                this.getData()
            }).catch(error=>{
                console.log(error)
            })
        },
        StoreNewType(){
            this.isLoading = true
            var data = {
                'name':this.NewType
            }
            StoreNewVacType(data).then(response=>{
                this.isLoading = false
                this.NewType = ''
                this.AddModel = false
                this.getData()
                this.alertsuccess('New Type Added')
            }).catch(error=>{
                console.log(error)
            })
        },
        openEditForm(id){
            getVacTypeData(id).then(response=>{
                // console.log(response)
                this.editmodal = true
                this.NewType = response.data.name
                this.TypeID = response.data.id
            }).catch(error=>{
                console.log(error)
            })
        },
        editType(){

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

