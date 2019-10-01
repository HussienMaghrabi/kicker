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
                    <b-button type="is-info" @click="AddModel == true">Add New</b-button>
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
                                        <b-button type="is-warning">
                                            <router-link :to="'/admin/vue/editJobCategory/'+props.row.id" style="color:#000;">
                                                Update
                                            </router-link>
                                        </b-button>
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
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>
        </div>
    </div>
</template>
<script>
import {
    getVacancyType
} from './../../calls'

export default {
    data() {
        return {
            isFullPage:true,
            isLoading:true,
            page:1,
            VacansiesType:[],
            perPage:null,
            currentPage: 1,
            isPaginated:true,
            AddModel:false,
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
        DeleteFromIndex(){
            
        }
    }
}
</script>

