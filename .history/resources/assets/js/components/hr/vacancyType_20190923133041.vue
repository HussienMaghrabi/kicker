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
                  <router-link :to="'/admin/vue/AddVtype'">
                      <b-button type="is-info">Add New</b-button>
                  </router-link>
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
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
            getVacancyType(this.page).then(response=>{
                this.VacansiesType = response.data
                this.perPage = response.data.per_page
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

