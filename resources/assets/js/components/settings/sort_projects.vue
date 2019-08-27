<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            project sort
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <!-- <i style="float:right;  color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-edit" @click="toggleInputsActive"></i> -->
                </section>
                    <div class="columns">
                        <div class="column is-6">
                            <div>
                                <h3 class="text-center"> Web projects </h3>
                            </div>
                            <hr>
                            <draggable v-model="Webprojects" group="people" @start="drag=true" @end="drag=false">
                            <div id="test" v-for="(element , index) in Webprojects" :key="element.id"><span class="fa fa-sort"></span>{{ index }}  : {{element.en_name}}</div>
                            </draggable>
                        </div>
                        <div class="column is-6">
                            <div>
                                <h3 class="text-center"> mobile projects </h3>
                            </div>
                            <hr>
                            <draggable v-model="mobileprojects" group="people" @start="drag=true" @end="drag=false">
                                <div id="test" v-for="(element , index) in mobileprojects" :key="element.id"><span class="fa fa-sort"></span>{{ index }}  : {{element.en_name}}</div>
                            </draggable>
                        </div>
                    </div>
                    <hr>
                    <div class="columns">
                        <div class="column is-6">
                            <b-button type="is-success"
                                @click="saveSortproject"
                                icon-left="send">
                                Save sort
                            </b-button>
                        </div>
                    </div>
            </div>
        </div>
            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style>
    #test{
        padding: 0.5rem;
        border: 1px solid black;
        background: whitesmoke;
    }
</style>

<script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js"></script>
<!-- CDNJS :: Sortable (https://cdnjs.com/) -->
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
<!-- CDNJS :: Vue.Draggable (https://cdnjs.com/) -->
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>
<script>
import {
    getprojectssort,
    Newsortweb,
} from './../../calls'
import draggable from 'vuedraggable'
export default {
        data() {
            return {
                Webprojects:[],
                mobileprojects:[],
                isLoading:false,
            }
        },
        created(){
            this.getsortedProjects()
        },
        components:{
            draggable
        },
        computed:{
            Webprojects: {
                get() {
                    return this.$store.id
                },
                set(value) {
                    this.$store.commit('updateList', value)
                }
            },
            mobileprojects: {
                get() {
                    return this.$store.id
                },
                set(value) {
                    this.$store.commit('updateList', value)
                }
            }
        },
        mounted(){
            // $('body > div > div > div > div > div > div').css({'margin:1rem;display':'inline-block'})
        },
        methods:{
            getsortedProjects(){
                this.isLoading = true
                getprojectssort().then(response=>{
                    // console.log('all projects',response)
                    this.Webprojects = response.data.web_projects
                    this.mobileprojects = response.data.mobile_projects
                    console.log('web projects',this.Webprojects)
                    // console.log('mobile projects',this.mobileprojects)
                    this.isLoading = false
                }).catch(error=>{
                    console.log(error)
                })
            },
            saveSortproject(){
                const bodyFormData = new FormData();
                for (let key in this.Webprojects) {
                    bodyFormData.append('new_data[]',JSON.stringify(this.Webprojects[key]));
                    // bodyFormData.set(key, value);
                }
                for (let key1 in this.mobileprojects) {
                    bodyFormData.append('new_mobile_data[]',JSON.stringify(this.mobileprojects[key1]));
                    // bodyFormData.set(key, value);
                }
                Newsortweb(bodyFormData).then(response=>{
                    this.isLoading = true
                    this.alertsuccess('You are soart a web projects')
                    this.getsortedProjects()
                }).catch(error=>{
                    this.alerterror('some error')
                    console.log(error)
                })
                console.log('new sort by id',this.Webprojects)
            },
            alertsuccess(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-success'
                })
            },
            alerterror(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-danger'
                })
            }
        }
}
</script>

