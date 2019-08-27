<template>
<div class="container">
    <section>
        <div>
        <router-link :to="'AddEvent/'">
            <b-button type="is-info">Add New</b-button>
        </router-link>
        </div>
        <b-table
            :data="eventdata"
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
                <b-table-column field="eventdata.id" label="ID" width="40" sortable numeric>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="eventdata.en_title" label="title" sortable>
                    {{ props.row.en_title }}
                </b-table-column>

                <b-table-column field="eventdata.date" label="Date" sortable>
                    {{ props.row.date }}
                </b-table-column>

                <b-table-column label="tags">
                    "tags"
                </b-table-column>

                <b-table-column label="show">
                        <router-link :to="'event/'+props.row.id">
                            <b-button type="is-info">Show</b-button>
                        </router-link>
                </b-table-column>


                <b-table-column label="Delete">
                    <b-button type="is-danger"
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
    getAllEvents,
    deleteEventByid,
    // saveIcon,
} from './../../calls'
    export default {
        data() {
            return {
                dropFiles1:[],
                eventdata:[],
                isPaginated: true,
                isPaginationSimple: false,
                showDetailIcon: true,
                currentPage:null,
                defaultSortDirection: 'desc',
                IconsCurrentNumber: null,
                perPage:null,
                ActiveModal:false,
                isLoading:true,
                isFullPage:true,
            }
        },
        created() {
            this.$router.replace({hash: '#/1'});
         },
        mounted(){
            this.getAlldata();
        },
        methods: {
            getAlldata(){
                getAllEvents().then(response=>{
                    this.eventdata = response.data
                    this.perPage = response.data.per_page
                    // console.log('per page',this.perPage)
                    this.isLoading = false
                    console.log('Events data',response)
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
            toggle(row) {
                this.$refs.table.toggleDetails(row)
            },
            DeleteelmentById(id) {
                // console.log(id);
                this.$dialog.confirm({
                    title: 'Deleting',
                    message: 'Are you sure you want to <b>delete</b> this element?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.EventDeletecon(id)
                })
            },
            EventDeletecon(id){
                deleteEventByid(id).then(response=>{
                    console.log('deleted')
                    this.isLoading = true
                    this.getAlldata()
                })
            },
        }
    }
</script>