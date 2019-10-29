<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            All National Vacation
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
                                :data="allNVacation"
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
                                    <b-table-column field="allNVacation.id" label="ID" width="40" sortable numeric>
                                        {{ props.row.id }}
                                    </b-table-column>
                                    <b-table-column field="allNVacation.ar_name" label="Arabic name" width="40" sortable>
                                        {{ props.row.ar_name }}
                                    </b-table-column>
                                    <b-table-column field="allNVacation.en_name" label="English name" width="40" sortable>
                                        {{ props.row.en_name }}
                                    </b-table-column>
                                    <b-table-column field="allNVacation.from" label="From" width="40" sortable>
                                        {{ props.row.from }}
                                    </b-table-column>
                                    <b-table-column field="allNVacation.to" label="To" width="40" sortable>
                                        {{ props.row.to }}
                                    </b-table-column>
                                    <b-table-column field="allNVacation.days" label="Days" width="40" sortable>
                                        {{ props.row.days }}
                                    </b-table-column>
                                    <b-table-column field="allNVacation.name" label="Name" width="40" sortable>
                                        {{ props.row.name }}
                                    </b-table-column>
                                    <b-table-column field="allNVacation.name" label="" width="40">
                                        <span @click="UpdateInModel(props.row.id)"><i class="fa fa-edit" style="color:green"></i></span>
                                        <span @click="DeleteNational(props.row.id)"><i class="fa fa-trash" style="color:red"></i></span>                                    </b-table-column>
                                </template>
                            </b-table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
            <b-modal :active.sync="EditModel">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Edit National Vacation</p>
                    </header>
                    <section class="modal-card-body">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-6">
                                <b-field label="English Name">
                                    <b-input v-model="updateVcation.en_name"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Name">
                                    <b-input v-model="updateVcation.ar_name"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Days">
                                    <b-input v-model="updateVcation.days"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Type">
                                    <b-select v-model="updateVcation.natoial_vacation_type_id" expanded>
                                        <option v-for="type in vacationTypes" :value="type.id" :key="type.id">{{ type.name }}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Start date">
                                    <b-input type="date" :value="updateVcation.from" v-model="updateVcation.from"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="End date">
                                    <b-input type="date" :value="updateVcation.to" :v-model="updateVcation.to"></b-input>
                                </b-field>
                            </div>
                        </div>
                        <footer class="modal-card-foot" style="justify-content: flex-end;">
                            <button class="button is-success" @click="updateNVacation">update</button>
                            <button class="button is-default" @click="EditModel = false">Close</button>
                        </footer>
                    </section>
                </div>
            </b-modal>
            <b-modal :active.sync="AddModel">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add National Vacation</p>
                    </header>
                    <section class="modal-card-body">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-6">
                                <b-field label="English Name">
                                    <b-input v-model="NewVacation.en_name"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Name">
                                    <b-input v-model="NewVacation.ar_name"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Days">
                                    <b-input v-model="NewVacation.days"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Type">
                                    <b-select v-model="NewVacation.natoial_vacation_type_id" expanded>
                                        <option v-for="type in vacationTypes" :value="type.id" :key="type.id">{{ type.name }}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Start date">
                                    <b-input type="date" :value="NewVacation.from" v-model="NewVacation.from"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="End date">
                                    <b-input type="date" :value="NewVacation.to" :v-model="NewVacation.to"></b-input>
                                </b-field>
                            </div>
                        </div>
                        <footer class="modal-card-foot" style="justify-content: flex-end;">
                            <button class="button is-success" @click="AddNewVacation">Save</button>
                            <button class="button is-default" @click="AddModel = false">Close</button>
                        </footer>
                    </section>
                </div>
            </b-modal>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>
    </div>
</template>

<script>
import {
    GetAllNationalVacation,
    GetAllVacatonType,
    updateNVacany,
    getSingleNVacation,
    DeleteNationalVacation,
    addNewNational,
} from './../../calls'
export default {
    mounted(){
        this.getData()
    },
    data() {
        return {
            isFullPage:true,
            isLoading:true,
            AddModel:false,
            allNVacation:[],
            isPaginated: true,
            isPaginationSimple: false,
            showDetailIcon: true,
            defaultSortDirection: 'desc',
            IconsCurrentNumber: null,
            perPage:20,
            ActiveModal:false,
            isLoading:true,
            EditModel:false,
            vacationTypes:[],
            updateVcation:[],
            NewVacation:[],
        }
    },
    methods:{
        getVacationsType(){
            GetAllVacatonType().then(response=>{
                this.vacationTypes = response.data
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
        },
        getData(){
            GetAllNationalVacation().then(response=>{
                this.allNVacation = response.data
                console.log(this.allNVacation)
                this.isLoading = false
                this.getVacationsType()
            }).catch(error=>{
                console.log(error)
            })
        },
        UpdateInModel(NaVacationID){
            this.EditModel = true
            this.GetSingeVacation(NaVacationID)
        },
        GetSingeVacation(NaVacationID){
            getSingleNVacation(NaVacationID).then(response=>{
                // console.log('Any',response)
                this.updateVcation = response.data[0]
            }).catch(error=>{
                console.log(error)
            })
        },
        AddNewVacation(){
            this.isLoading = true
            const bodyFormData = new FormData();
            for (const key in this.NewVacation) {
                const value = this.NewVacation[key];
                bodyFormData.set(key, value);
            }
            addNewNational(bodyFormData).then(response=>{
                console.log(response)
                this.AddModel = false
                this.getData()
            }).catch(error=>{
                console.log(error)
            })
        },
        updateNVacation(){
            const bodyFormData = new FormData();
            for (const key in this.updateVcation) {
                const value = this.updateVcation[key];
                bodyFormData.set(key, value);
            }
            updateNVacany(bodyFormData).then(response=>{
                this.EditModel = false
                // console.log(response)
                this.getData()
            }).catch(error=>{
                console.log(error)
            })
        },
        DeleteNational(NationalID){
            this.$dialog.confirm({
                title: 'Deleting National Vacation',
                message: 'Are you sure you want to <b>delete</b> Element ?',
                confirmText: 'Deleting National Vacation',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteVacation(NationalID)
            })
        },
        deleteVacation(NationalID){
            DeleteNationalVacation(NationalID).then(response=>{
                this.getData()
            }).catch(error=>{
                console.log(error)
            })
        },
    }
}
</script>
