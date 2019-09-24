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
            isLoading:false,
            page:1,
            VacansiesType:[],
            perPage:null,
            currentPage: 1,
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

