<template>
<div class="container">
    <section>
        <div>
            <b-button v-on:click="AddRoleModel = true" type="is-info">Add New</b-button>
        </div>
        <b-table
            :data="RoleDetails"
            :paginated="isPaginated"
            :per-page="perPage"
            :current-page.sync="currentPage"
            :pagination-simple="isPaginationSimple"
            :default-sort-direction="defaultSortDirection"
            default-sort="user.first_name"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page">

            <template slot-scope="props">
                <b-table-column field="RoleDetails.first_name" label="#" width="40" sortable>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="RoleDetails.en_title" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column label="Actions">
                    <b-button type="is-success"
                        size="is_small"
                        @click="openEditmodal(props.row.id)"
                        icon-left="pen">
                        Update
                    </b-button>
                    <b-button type="is-danger"
                        size="is_small"
                        @click="DeleteelmentById(props.row.id)"
                        icon-left="delete">
                        Delete
                    </b-button>
                </b-table-column>
            </template>
        </b-table>
        <b-modal :active.sync="ActiveModal" has-modal-card :can-cancel="false">
        </b-modal>
    </section>

    <b-modal :active.sync="Editmodal">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">edit Role</p>
            </header>
            <section class="modal-card-body">
                <div class="columns is-multiline is-mobile">
                    <div class="column is-12">
                        <label for="Name"></label>
                        <b-input v-model="singleRole.name"></b-input>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot" style="justify-content: flex-end;">
                <button class="button is-primary" @click="UpdateRoleDetails(singleRole.id)">Edit <span class="fa fa-pen"></span></button>
                <button class="button is-default" @click="Editmodal = false">Close</button>
            </footer>
        </div>
    </b-modal>


    <b-modal :active.sync="AddRoleModel">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">edit Role</p>
            </header>
            <section class="modal-card-body">
                <div class="columns is-multiline is-mobile">
                    <div class="column is-12">
                        <label for="Name"></label>
                        <b-input v-model="singleRole.name"></b-input>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot" style="justify-content: flex-end;">
                <button class="button is-primary" @click="StoreRoleDetails"> Save <span class="fa fa-send"></span></button>
                <button class="button is-default" @click="AddRoleModel = false">Close</button>
            </footer>
        </div>
    </b-modal>
    <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
</div>
</template>

<style>
    .Iconsimage{
        height: 5rem;
        width: 5rem;
    }
</style>


<script>
// from import api's data from calls
import{
    GetAllRoleDetails,
    DeleteRoleDetails,
    EditRoleDetails,
    updateSigleRole,
    saveNewRoleDetails
    // saveIcon,
} from './../../calls'
    export default {
        data() {
            return {
                dropFiles1:[],
                RoleDetails:[],
                isPaginated: true,
                isPaginationSimple: false,
                showDetailIcon: true,
                currentPage:null,
                defaultSortDirection: 'desc',
                IconsCurrentNumber: null,
                perPage:null,
                page:1,
                ActiveModal:false,
                isLoading:true,
                isFullPage:true,
                Editmodal:false,
                AddRoleModel:false,
                singleRole:[],
            }
        },
        created() {
            // this.$router.replace({hash: '#/1'});
         },
        mounted(){
            this.getAlldata();
        },
        methods: {
            getAlldata(){
                GetAllRoleDetails(this.page).then(response=>{
                    this.RoleDetails = response.data.data
                    this.perPage = response.data.per_page
                    // console.log('per page',this.perPage)
                    this.isLoading = false
                    // console.log('Events data',response)
                    this.IconsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    this.iconsTotalNumber = response.data.total
                    this.total = response.data.total
                let currentTotal = response.data.total
                if (response.data.total / this.perPage > 1000) {
                    currentTotal = this.perPage * 1000
                }
                this.total = currentTotal
                }).catch(error => {
                    console.log(error)
                })
            },
            openEditmodal(RoleDID){
                this.isLoading = true
                this.Editmodal = true
                EditRoleDetails(RoleDID).then(response=>{
                    this.isLoading = false
                    this.singleRole = response.data
                }).catch(error=>{
                    console.log(error)
                })
            },
            toggle(row) {
                this.$refs.table.toggleDetails(row)
            },
            UpdateRoleDetails(RoleID){
                this.isLoading = true
                const data = {
                    'name':this.singleRole.name
                }
                updateSigleRole(RoleID,data).then(response=>{
                    this.Editmodal = false
                    this.getAlldata()
                }).catch(error=>{
                    console.log(error)
                })
            },
            StoreRoleDetails(){
                this.isLoading = true
                const data = {
                    'name':this.singleRole.name
                }
                saveNewRoleDetails(data).then(response=>{
                    this.AddRoleModel = false
                    this.singleRole = []
                    this.getAlldata()
                }).console.log(response=>{
                    console.log(error)
                })
            },
            DeleteelmentById(id) {
                // console.log(id);
                this.$dialog.confirm({
                    title: 'Deleting',
                    message: 'Are you sure you want to <b>delete</b> this element?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteRoleDetails(id)
                })
            },
            deleteRoleDetails(id){
                DeleteRoleDetails(id).then(response=>{
                    // console.log('deleted')
                    this.isLoading = true
                    this.getAlldata()
                })
            },
        }
    }
</script>