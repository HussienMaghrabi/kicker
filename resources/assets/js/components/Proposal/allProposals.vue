<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <div class="level mb-5">
            <div class="level">
                <div class="level-item">

                </div>
            </div>

            <div class="field">
            <div class="control has-icons-left">
                <div class="select">
                <select>
                    <option value="all OPen Leads" selected>All Open Leads</option>
                    <option value="Closed Leads">Closed Leads</option>
                </select>
                </div>
            </div>
            </div>

            <div class="field">
            <div class="control has-icons-left">
                <div class="select">
                <select>
                    <option value="Contacted" selected>Contacted</option>
                    <option value="Not Contacted">Not Contacted</option>
                </select>
                </div>
            </div>
            </div>

            <div class="level">
                <div class="level-item filters">
                    <div class="field  mr-10">
                        <div class="control">
                            <input class="input is-meduim mt-10" type="text" placeholder="Search" style="width:70%;margin-bottom: 23px;">
                            <b-button type="is-info" style="margin-top:8px"><i class="fas fa-plus"></i>&nbsp;
                                <router-link  :to="'/admin/vue/newProposal'" style="color:#fff">
                                  New
                                </router-link>
                             </b-button>
                        </div>
                    </div>
                    
                </div>
            </div>

            </div>
                    <b-table
                    :data="proposal"
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
                    default-sort="created_at"
                    >

                    <template slot-scope="props">
                        <b-table-column  label="Proposed Company" sortable>
                             <router-link :to="'/admin/vue/showProposal/'+props.row.id" style="color:#000"> 
                                      {{props.row.MCompany_name}}
                             </router-link>
                        </b-table-column>

                        <b-table-column label="Company" sortable>
                            <router-link :to="'/admin/vue/showProposal/'+props.row.id" style="color:#000"> 
                                      {{props.row.company_name}}
                            </router-link>
                           
                        </b-table-column>

                        <b-table-column label="Valid Until" sortable>
                            <router-link :to="'/admin/vue/showProposal/'+props.row.id" style="color:#000"> 
                               {{props.row.valid_until}}
                            </router-link>
                        </b-table-column>

                        <b-table-column  label="Sub Total" sortable>
                             <router-link :to="'/admin/vue/showProposal/'+props.row.id" style="color:#000"> 
                               {{props.row.sub_total}}
                            </router-link>
                        </b-table-column>

                        <b-table-column  label="Discount" sortable>
                             <router-link :to="'/admin/vue/showProposal/'+props.row.id" style="color:#000"> 
                               {{props.row.Discount}}
                            </router-link>
                        </b-table-column>

                        <b-table-column  label="Total" sortable>
                              <router-link :to="'/admin/vue/showProposal/'+props.row.id" style="color:#000"> 
                               {{props.row.Total}}
                            </router-link>
                        </b-table-column>
                   

                        <b-table-column  label="" sortable>
                            <i class="fas fa-envelope"></i>
                        </b-table-column>

                        <b-table-column label="Delete" sortable>
                           <i class="fas fa-trash-alt" style="cursor:pointer"></i>
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
            
            <div class="buttons">
                <b-button type="is-success"><i class="fas fa-envelope"></i>  Send Email</b-button>
                <b-button type="is-danger"><i class="fas fa-trash-alt"></i> Delete</b-button>
                <b-button type="is-info"><i class="fas fa-print"></i>  Print</b-button>
            </div>

            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>


    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
changeLeadFav
<script>
    import {getAllProposals} from './../../calls'
    import Multiselect from 'vue-multiselect'
    export default {
        data() {
            return {
                proposal:[],
                currentTotal:0,
                perPage:null,
                isFullPage:false,
                isLoading:true,
                page:1,
                total:0,
            }
        },
        mounted() {
            this.getData()
        },
        components: {
            Multiselect
        },
        created() {
            this.$router.replace({hash: '#/1'});
            this.page = parseInt(this.$route.hash.split('/')[1])
         },
         methods: {
        getData(){
            this.isLoading = true
            getAllProposals(this.page).then(response=>{
                console.log(response);
                this.proposal = response.data.data
                console.log('fdgdsf',this.proposal)
                this.perPage = response.data.per_page
                // if(this.proposal.length == 0){
                //     this.isEmpty = true
                // }
                let currentTotal = response.data.total
                console.log("the total is".currentTotal);
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
        },
     }
}
</script>

<style type="text/css" scoped="">
.leads-number
{
    position: absolute;
    bottom: 122px;

}
@media screen and (max-width: 767px) {
.leads-number{
    margin-bottom: 17%;
}
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
        bottom: 10px !important;
        left: unset !important;
    }

    .filter-content{
        margin-top: 2%;
    }
}
</style>
