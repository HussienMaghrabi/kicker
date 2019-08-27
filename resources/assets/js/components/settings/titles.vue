<template>
<section class="container competitors">
    <b>All Job Titles</b><hr>
    <div class="add">
        <button name="add" class="btnAdd">
             <router-link :to="'/admin/vue/addTilte'" style="color:#fff;"> 
                    Add
            </router-link>    
        </button><br>
        <div class="search">
            <label>Search: </label>
            <b-input @input="filterTitles" v-model="search_query" type="text" class="inputSearch"></b-input>  
        </div>
    </div>

        <b-table
            :data="titleData"
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

            :checked-rows.sync="selectedLogs"
            :default-sort-direction="defaultSortDirection"
            default-sort="created_at"
            >


            <template slot-scope="props">
              
                <b-table-column class="width" field="id" label="ID" sortable>
                    {{ props.row.id }}
                </b-table-column>
              
                <b-table-column class="width" field="Name" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>

    
                <b-table-column label="Show">
                  <b-button type="is-info">                                     
                         <router-link :to="'/admin/vue/titleShow/'+props.row.id" style="color:#fff;">
                            Show
                        </router-link>
                   </b-button>
                </b-table-column>


                <b-table-column label="Update">
                    <b-button type="is-warning" @click="openModal(props.row.id)">
                            Update
                    </b-button>

                     <!-- Model Update -->

                      <b-modal :active.sync="isComponentModalActive" has-modal-card>
                          <div class="modal-card" style="width: auto">
                                <header class="modal-card-head">
                                    <p class="modal-card-title">Edit Job Title</p>
                                </header>
                                <section class="modal-card-body">
                                    <b-field label="Name">
                                        <b-input
                                            v-model="title.name"
                                            type="text">
                                        </b-input>
                                    </b-field>

                                    <b-field label="Description">
                                        <b-input type="textarea" v-model="title.description"></b-input>
                                    </b-field>
                                    
                                </section>
                                <footer class="modal-card-foot">
                                    <button class="button" type="button" @click="isComponentModalActive = false">Close</button>
                                    <b-button type="is-success" @click="UpdateTitle(title.id)">Update</b-button>
                                </footer>
                            </div>
                      </b-modal>

                     <!-- End Model -->
                </b-table-column>

                <b-table-column label="Delete" >
                   <b-button type="is-danger"  @click="DeleteFromIndex(props.row.id)">Delete</b-button>
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

        <div class="leads-number">{{logsCurrentNumber + ' / ' + logsTotalNumber}}</div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>




        <h5>Showing 1 to 1 of 1 entries</h5>
    </section>
</template>

<style>
  .btnAdd{
    background-color: #00a65a;
    color: #fff;
    border: none;
    width: 50px;
    height: 30px;
    float: right;
    margin-bottom: 5PX;
  }
  .search{
      float: right;
  }
  .add{
   float: right;
  }
  .inputSearch{
    height: 30px;
    margin-bottom: 10PX;
  }
  .competitors{
      background-color: #fff;
      padding: 1% !important;
  }
  body{
      background-color: #ECF0F3;
  }
  .label
  {
      float: left;
  }

</style>

<script>
import {getTitleData,deleteThisTitle,filterTitles,titleShow,UpdateThisTitle} from './../../calls'

    export default {
        components: {
  
    },
    data() {
        return {
                title: {},
                ID:null,
                name:null,
                search_query: '',
                titleData:[],
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                actionLogs: [],
                selectedLogs: [],
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,
                isLoading: true,
                isFullPage: true,
                page:1,
                selectedagent_type: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               isComponentModalActive: false,
            }},
    mounted() {
        this.getData()
    },
    created() {
        this.$router.replace({hash: '#/1'});
        },
    methods: {
        getRowData(id){
        this.isLoading = true
            titleShow(id).then(response=>{
                console.log(response)
            this.title = response.data
            this.isLoading = false
            })
        .catch(error => {
            console.log(error)
        })
        },
        getData(){
            this.isLoading = true
            getTitleData(this.page).then(response=>{
                console.log(response)
            this.titleData = response.data.data
            this.perPage = response.data.per_page
            this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
            this.leadsTotalNumber = response.data.total
            this.total = response.data.total
            let currentTotal = response.data.total
              if(this.titleData.length == 0){
                    this.isEmpty = true
                }

                if (response.data.total / this.perPage > 1000) {
                    currentTotal = this.perPage * 1000
                }

            this.total = currentTotal
            this.isLoading = false
            })
        .catch(error => {
            console.log(error)
        })
            this.isLoading = false
    },
    onPageChange(page) {
            // this.page = page
            // this.$router.replace({ name: "logs", params: {page: page} })
            // this.getData()
        },
    
    deleteTitle(id){
            deleteThisTitle(id).then(response=>{
                this.success('Deleted')
                this.isLoading = true
                this.getData()
            })
            .catch(error => {
                this.errorDialog()
                console.log(error)
            })
    },
    filterTitles(){
        var data ={
            'id':this.ID,
            'name':this.name,
            'searchInput':this.search_query,
            '_token':this.token,
        };
        filterTitles(data).then(response=>{
            this.titleData = response.data
        })
    .catch(error => {
        console.log(error)
        })
    },
    toggle(row) {
        this.$refs.table.toggleDetails(row)
    },
    // delete model 
    DeleteFromIndex(id) {
        this.$dialog.confirm({
            title: 'Deleting ',
            message: 'Are you sure you want to <b>delete</b> DELETE?',
            confirmText: 'Delete',
            type: 'is-danger',
            hasIcon: true,
            onConfirm: () => this.deleteTitle(id)
        })
    },
        errorDialog() {
            this.$dialog.alert({
                title: 'Error',
                message: 'Please select the Task you want to delete first',
                type: 'is-danger',
            })
    },
    success(action) {
        this.$toast.open({
            message: 'Task '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
    openModal(id){
            this.getRowData(id)
            this.isComponentModalActive = true;
    },
    UpdateTitle(id){
        const bodyFormData = new FormData();
        for (let key in this.title) {
            const value = this.title[key];
            bodyFormData.set(key, value);
    }
        bodyFormData.append('_method','put')
        UpdateThisTitle(bodyFormData,id).then(response=>{
            console.log("Update title",response)
            $(location).attr('href', '/admin/vue/titles')
            this.isComponentModalActive = false
        }).catch(error=>{
            console.log(error);
        }); 
    }

      
    },
}
</script>