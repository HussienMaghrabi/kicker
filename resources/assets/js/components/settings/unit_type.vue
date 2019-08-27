<template>
    <section>
        <div class="container">
        <b-field grouped group-multiline>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Unit types
                    </div>
                </div>
                <div class="card-body">
                    <button size="is-medium" @click="AddnewModal = true" class="button field is-info">
                        <b-icon icon="file"></b-icon>
                        <span>Add new</span>
                    </button>
                </div>
            </div>
        </b-field>
            <b-field grouped group-multiline>
            </b-field>
            <b-table
                :data="UnitTypes"
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
                    <b-table-column field="UnitTypes.id" label="ID" width="40" sortable numeric>
                        {{ props.row.id }}
                    </b-table-column>

                    <b-table-column field="UnitTypes.en_name" label="English name" sortable>
                        {{ props.row.en_name }}
                    </b-table-column>

                    <b-table-column field="UnitTypes.ar_name" label="Arabic Name" sortable>
                        {{ props.row.ar_name }}
                    </b-table-column>

                    <b-table-column field="show" label="Show">
                        <b-button type="is-info">Show</b-button>
                    </b-table-column>

                    <b-table-column field="edit" label="Edit">
                        <b-button type="is-success" @click="OpenEditModal(props.row.id)" >Edit</b-button>
                    </b-table-column>

                    <b-table-column field="edit" label="Delete">
                        <b-button @click="UnitdeleteElementById(props.row.id)" type="is-danger">Delete</b-button>
                    </b-table-column>

                </template>
            </b-table>
        </div>
        <!-- loding  -->
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
        <!-- end loding -->
        <!-- begin add new -->
            <b-modal :active.sync="AddnewModal" has-modal-card :can-cancel="false">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add new Unit Type</p>
                    </header>
                    <section class="modal-card-body text-center">
                        <div class="col-is-12">
                                <b-field label="English name">
                                    <b-input v-model="unitEnName" placeholder="Unit English name"></b-input>
                                </b-field>
                                <b-field label="Arabic name">
                                    <b-input v-model="unitArName"  placeholder="Unit Arabic name"></b-input>
                                </b-field>
                                <b-field
                                label="type">
                                <b-select v-model="selectTypr" placeholder="Select a type">
                                    <option value="commercial" >Commercial</option>
                                    <option value="personal" >Residential</option>
                                </b-select>
                            </b-field>
                                <b-field label="Message">
                                    <b-input v-model="unitNote" maxlength="200" type="textarea"></b-input>
                                </b-field>
                                <b-field label="On show">
                                    <div class="field">
                                        <b-switch v-model="onShow">
                                            {{ onShow }}
                                        </b-switch>
                                    </div>
                                </b-field>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button" type="button" @click="AddnewModal = false">Close</button>
                        <button class="button is-primary" @click="saveNewUnit">save</button>
                    </footer>
                </div>
            </b-modal>
        <!-- end add new -->
        <!-- edit modal -->
                <b-modal :active.sync="EditModal" has-modal-card :can-cancel="false">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Edit Unit Type</p>
                    </header>
                    <section class="modal-card-body text-center">
                        <div class="col-is-12">
                                <b-input v-model="UnitByid.id" type="hidden"></b-input>
                                <b-field label="English name">
                                    <b-input v-model="UnitByid.enName" placeholder="Unit English name"></b-input>
                                </b-field>
                                <b-field label="Arabic name">
                                    <b-input v-model="UnitByid.arName"  placeholder="Unit Arabic name"></b-input>
                                </b-field>
                                <b-field
                                label="type">
                                <b-select v-model="UnitByid.selectTypr" placeholder="Select a type">
                                    <option :selected="UnitByid.selectTypr == 'commercial'" value="commercial" >Commercial</option>
                                    <option :selected="UnitByid.selectTypr == 'personal'" value="personal" >Residential</option>
                                </b-select>
                            </b-field>
                                <b-field label="On show">
                                    <div class="field">
                                        <b-switch v-model="UnitByid.onShow">
                                            {{ UnitByid.onShow }}
                                        </b-switch>
                                    </div>
                                </b-field>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button" type="button" @click="EditModal = false">Close</button>
                        <button class="button is-primary" @click="saveEditUnit">save</button>
                    </footer>
                </div>
        </b-modal>
        <!-- end edit model -->
    </section>
</template>
<style>
    .card{
        width:100%;
    }
    .card-body{
        padding:2rem
    }
</style>


<script>
import{
    getunittype,
    NewAddUnit,
    getunitbyid,
    updateUnit,
    deleteUnit,
} from './../../calls'
    export default {
        data() {
            return {
                EditModal:false,
                AddnewModal:false,
                UnitTypes:[],
                UnitByid:{
                    unit_id:null,
                    enName:null,
                    arName:null,
                    onShow:false,
                    selectTypr:null,
                },
                isPaginated: true,
                isPaginationSimple: false,
                paginationPosition: 'bottom',
                defaultSortDirection: null,
                currentPage: null,
                perPage: null,
                total:null,
                isLoading:true,
                unitEnName:null,
                unitArName:null,
                selectTypr:null,
                unitNote:null,
                onShow:0,
            }
        },
        created(){
            this.$router.replace({hash: '#/1'});
        },
        mounted(){
            this.getAllUnit()
        },
        methods:{
            getAllUnit(){
                getunittype().then(response=>{
                    this.UnitTypes = response.data.data
                    this.isLoading = false
                    console.log('all unit type is',response)
                    this.perPage = response.data.per_page
                    this.currentPage = response.data.current_page
                    // console.log('per page',this.perPage)
                let currentTotal = response.data.total
                if (response.data.total / this.perPage > 1000) {
                    currentTotal = this.perPage * 1000
                }
                this.total = currentTotal
                }).catch(error => {
                    console.log(error)
                })
            },
            OpenEditModal(id){
                getunitbyid(id).then(response=>{
                    this.UnitByid.id = response.data.id
                    this.UnitByid.enName = response.data.en_name
                    this.UnitByid.arName = response.data.ar_name
                    this.UnitByid.onShow = response.data.on_show
                    this.UnitByid.selectTypr = response.data.usage
                    console.log('en name',this.UnitByid.enName)
                    console.log('data of id only',response)
                    this.EditModal = true
                }).catch(error => {
                    console.log(error)
                })
            },
            saveNewUnit(){
            const bodyFormData = new FormData();
            bodyFormData.append('en_name',this.unitEnName)
            bodyFormData.append('ar_name',this.unitArName)
            bodyFormData.append('usage',this.selectTypr)
            bodyFormData.append('note',this.unitNote)
            bodyFormData.append('onShow',this.onShow)
                NewAddUnit(bodyFormData).then(response=>{
                    this.AddnewModal = false
                    this.isLoading = true
                    this.alertsuccess('add unit type')
                    this.getAllUnit()
                })
            },
            saveEditUnit(){
                const bodyFormData = new FormData();
                for (let key in this.UnitByid) {
                    const value = this.UnitByid[key];
                }
                bodyFormData.append('id',this.UnitByid.id)
                bodyFormData.append('en_name',this.UnitByid.enName)
                bodyFormData.append('ar_name',this.UnitByid.arName)
                bodyFormData.append('type',this.UnitByid.selectTypr)
                bodyFormData.append('on_Show',this.UnitByid.onShow)
                updateUnit(bodyFormData).then(response=>{
                this.EditModal = false
                this.isLoading = true
                this.getAllUnit()
                this.alertsuccess('Update unit type')
                }).catch(error => {
                    console.log(error)
                })
            },
            UnitdeleteElementById(id){
                this.$dialog.confirm({
                    title: 'Deleting',
                    message: 'Are you sure you want to <b>delete</b> this Unit?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteElementById(id)
                })
            },
            deleteElementById(id){
                deleteUnit(id).then(response=>{
                    this.isLoading = true
                    this.getAllUnit()
                }).catch(error => {
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
            }
        }
    }
</script>