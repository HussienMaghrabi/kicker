<template>

<div class="parent">
     <section class="table">
         <section class ="add">
        <button class="button is-primary is-medium" >
            <router-link style="color:white" to="/admin/vue/AddAgentType">   Add  </router-link>
           
        </button>

     
    </section>
      <div style="clear:both"> </div>
      
       <h1 style="display:inline" class="title"> All agent types</h1>
         <b-field class="search" label="Search">
            <b-input @input="filterAgentType" v-model="search_query" type="text" class="inputSearch"></b-input>
        </b-field> 
        <div style="clear:both"> </div>
      

        <b-table
            :data="allAgent_type"
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
              
                <b-table-column class="width" field="user.user_id" label="ID" sortable>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column class="width" field="user.name" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>
              
                 <b-table-column class="width" field="user.description" label="description" sortable>
                    {{ props.row.description }}
                </b-table-column>

                <b-table-column  field="" label="show" sortable >
                        <button class="button is-primary is-medium"  >
                        <router-link style="color:white" :to="'/admin/vue/ShowAgentType/'+props.row.id"> Show</router-link>  
                                          
                         </button>
                     
                </b-table-column>

              

                <b-table-column class=" btn_delete" field="user.user_id" label="delete" sortable>
                   <button @click="confirmDeleteBulk(props.row.id)" class=" button is-medium">
                            Delete  
                    </button>
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
        <!-- <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div> -->
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </section>
</div>     
    
</template>
<script>
 
     

    import {deleteAgentType,allAgent_type,filterAgentType} from './../../calls'
export default {
    data() {
            return {
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                allAgent_type: [],
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,
                isLoading: true,
                isFullPage: true,
                selectedagent_type: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               search_query:'',
               
                
            
                
            }
        },
        mounted() {
            this.getData()
        },
        components: {
              
        },
        created() {
            this.$router.replace({hash: '#/1'});
         },
         methods: {
         getData(){
            this.isLoading = true
                allAgent_type(this.page).then(response=>{
                console.log("TEST",response)
                this.perPage = response.data.per_page
                this.allAgent_type = response.data.data
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.leadsTotalNumber = response.data.total
                this.total = response.data.total
                
                if(this.allAgent_type.length == 0){
                    this.isEmpty = true
                }
                let currentTotal = response.data.total
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
         deleteAgentType(id){
            console.log('this id',id)
                deleteAgentType(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
                this.getData()
        },
     
        confirmDeleteBulk(id) {
            this.$dialog.confirm({
                title: 'Deleting Agent Type',
                message: 'Are you sure you want to <b>delete</b>  Agent Type ?',
                confirmText: 'Delete Agent Type',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteAgentType(id)
            })
        },
        errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the Agent Type  you want to delete first',
                    type: 'is-danger',
                })
            },
        success(action) {
            this.$toast.open({
                message: 'Agent Type '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
          filterAgentType(){
        var data ={
            'id':this.id,
            'name':this.name,
            'description':this.description,
            'searchInput':this.search_query,
            '_token':this.token,
        };
        filterAgentType(data).then(response=>{
            this.allAgent_type = response.data
        })
    .catch(error => {
        console.log(error)
        })
    },

         },
}
</script>
<style>
.title
{
    font-size: 24px;
    font-weight: bold;
    margin: 20px;
    margin-left: 30px;
}
.table
{
    margin-left: 30px;
    margin-right: 50px;
}

.add
{
    float: right;
   margin-right: 50px;
   margin-top: 20px;

}
.width
{
    width: 400px;
}

.btn_delete .button
{
  background-color: #d43f3a;
     color: white;
     
}
.search
{
    width: 10%;
    float: right;
    margin-right: 50px;
    margin-bottom: 0px;

}
.parent
{
    background-color:white;
    margin-right: 20px;
    margin-left: 20px;
}
</style>