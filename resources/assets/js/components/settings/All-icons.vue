<template>
<div class="container">
    <section>
        <div>
            <button class="level-right button field is-info" @click="ActiveModal = true">
                <span>Add New</span>
            </button>
        </div>
        <b-table
            :data="IconsData"
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
                <b-table-column field="IconsData.id" label="ID" width="40" sortable numeric>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="IconsData.icon" label="Icon" sortable>
                     <img class="Iconsimage" :src="'/uploads/'+props.row.icon " />
                </b-table-column>

                <b-table-column field="user.last_name" label="Delete" sortable>
                    <b-button type="is-danger"
                        @click="DeleteelmentById(props.row.id)"
                        icon-left="delete">
                        Delete
                    </b-button>
                </b-table-column>
            </template>
        </b-table>
        <b-modal :active.sync="ActiveModal" has-modal-card :can-cancel="false">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add icon </p>
                    </header>
                    <section class="modal-card-body text-center">
                        <div class="col-is-12">
                            <b-field>
                                <b-upload v-model="dropFiles1" multiple drag-drop accept="image">
                                    <section class="section">
                                    <div class="content has-text-centered">
                                        <p>
                                        <b-icon icon="upload" size="is-large"></b-icon>
                                        </p>
                                        <p>Drop your files here or click to upload</p>
                                    </div>
                                    </section>
                                </b-upload>
                            </b-field>
                            <div class="tags">
                                <span v-for="(file, index) in dropFiles1" :key="index" class="tag is-primary">
                                    {{file.name}}
                                    <button
                                    class="delete is-small"
                                    type="button"
                                    @click="deleteDropFile(index)"
                                    ></button>
                                </span>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button" type="button" @click="$parent.close()">Close</button>
                        <button class="button is-primary" @click="StoreNewIcon">Submit</button>
                    </footer>
                </div>
        </b-modal>
    </section>
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
    geticondata,
    deleteiconresponse,
    saveIcon,
} from './../../calls'
    export default {
        data() {
            return {
                dropFiles1:[],
                IconsData:[],
                isPaginated: true,
                isPaginationSimple: false,
                showDetailIcon: true,
                defaultSortDirection: 'desc',
                IconsCurrentNumber: null,
                perPage:20,
                ActiveModal:false,
                isLoading:true,
            }
        },
        created() {
            // this.$router.replace({hash: '#/1'});
         },
        mounted(){
            this.iconData();
        },
        methods: {
            iconData(){
                geticondata().then(response=>{
                    this.IconsData = response.data.data
                    this.isLoading = false
                    console.log('Icons data',response)
                    this.IconsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    this.iconsTotalNumber = response.data.total
                    this.total = response.data.total
                if(this.agents.length == 0){
                    this.isEmpty = true
                }
                let currentTotal = response.data.total
                if (response.data.total / this.perPage > 1000) {
                    currentTotal = this.perPage * 1000
                }
                this.total = currentTotal
                }).catch(error => {
                    console.log(error)
                })
            },
            StoreNewIcon()
            {
                // console.log(this.dropFiles1[0])
                const bodyFormData = new FormData();
                for (let key in this.dropFiles1) {
                    const value = this.dropFiles1[key];
                    // bodyFormData.append("data" + "[" + key + "]", JSON.stringify(this.agenda[key]));        
                    bodyFormData.append("icons" + "[" + key + "]", JSON.stringify(this.dropFiles1[key]));
                }
                // bodyFormData.append("icon", this.dropFiles1[0]);
                saveIcon(bodyFormData).then(response=>{
                    this.ActiveModal = false
                    this.isLoading = true
                     this.iconData();
                }).catch(error=>{
                    console.log(error)
                })
            },
            toggle(row) {
                this.$refs.table.toggleDetails(row)
            },
            DeleteelmentById(id) {
                console.log(id);
                this.$dialog.confirm({
                    title: 'Deleting',
                    message: 'Are you sure you want to <b>delete</b> this element?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.IconsDeletecon(id)
                })
            },
            IconsDeletecon(id){
                deleteiconresponse(id).then(response=>{
                    console.log('deleted')
                    this.isLoading = true
                    iconData()
                })
            },
        }
    }
</script>