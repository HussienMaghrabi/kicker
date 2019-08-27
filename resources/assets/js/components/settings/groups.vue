<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Groups
                        </p>
                    </div>
                </div>
                <div class="level-right">
                  <router-link :to="'/admin/vue/AddGroups'">
                      <b-button type="is-info">Add New</b-button>
                  </router-link>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-menu>
                                <b-menu-list label="Menu">
                                    <b-menu-item v-for="p in perants" :key="p.id" icon="settings" expanded>
                                        <template slot="label" slot-scope="props">
                                          {{ p.name }}
                                            <b-icon class="is-pulled-right" :icon="props.expanded ? 'menu-down' : 'menu-up'"></b-icon>
                                        </template>
                                            <b-menu-item v-for="c in children" v-if="c.parent_id == p.id" :key="c.id" icon="account" :label="c.name" @click="groupDetails(c.id)"></b-menu-item>
                                    </b-menu-item>
                                </b-menu-list>
                            </b-menu>
                        </div>
                    </div>
                </section>
                <!-- begin data -->
                <!-- end data -->
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
    margin-bottom: 3rem
}
</style>
<script>
import {
    getGroups
} from './../../calls'
export default {
    data() {
            return {
                perants:[],
                children:[],
                isFullPage:false,
                isLoading:false,
            }
        },
        components:{
        },
        created() {
        },
        mounted(){
          this.getperantgroups()
        },
        methods: {
          getperantgroups(){
            getGroups().then(response=>{
              console.log('responseeeeeeeee',response)
              this.perants = response.data.perants
              this.children = response.data.children
              console.log('Perants',this.perants)
              console.log('children',this.children)
            })
            .catch(error => {
                console.log(error)
            })
          },
          groupDetails(id){
              window.location.href = "group_details/"+id
          }
        }
}
</script>