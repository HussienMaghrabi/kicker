<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            resale sort
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
                                <h3 class="text-center"> Web resale projects </h3>
                            </div>
                            <hr>
                            <draggable v-model="resaleMobileSort" group="people" @start="drag=true" @end="drag=false">
                            <div id="test" v-for="(element , index) in resaleMobileSort" :key="element.id"><span class="fa fa-sort"></span>{{ index }}  : {{element.en_title}}</div>
                            </draggable>
                        </div>
                        <div class="column is-6">
                            <div>
                                <h3 class="text-center"> mobile resale projects </h3>
                            </div>
                            <hr>
                            <draggable v-model="mobileSortResale" group="people" @start="drag=true" @end="drag=false">
                                <div id="test" v-for="(element , index) in mobileSortResale" :key="element.id"><span class="fa fa-sort"></span>{{ index }}  : {{element.en_title}}</div>
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
    getResaleSorts,
    newSortResale,
} from './../../calls'
import draggable from 'vuedraggable'
export default {
        data() {
            return {
                resaleMobileSort:[],
                mobileSortResale:[],
                isLoading:false,
            }
        },
        created(){
            this.getsortedResale()
        },
        components:{
            draggable
        },
        computed:{
            resaleMobileSort: {
                get() {
                    return this.$store.id
                },
                set(value) {
                    this.$store.commit('updateList', value)
                }
            },
            mobileSortResale: {
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
            getsortedResale(){
                this.isLoading = true
                getResaleSorts().then(response=>{
                    // console.log('all projects',response)
                    this.resaleMobileSort = response.data.web_resale
                    this.mobileSortResale = response.data.mobile_resale
                    // console.log('web projects',this.resaleMobileSort)
                    // console.log('mobile projects',this.mobileSortResale)
                    this.isLoading = false
                }).catch(error=>{
                    console.log(error)
                })
            },
            saveSortproject(){
                const bodyFormData = new FormData();
                for (let key in this.resaleMobileSort) {
                    bodyFormData.append('new_data[]',JSON.stringify(this.resaleMobileSort[key]));
                    // bodyFormData.set(key, value);
                }
                for (let key1 in this.mobileSortResale) {
                    bodyFormData.append('new_mobile_data[]',JSON.stringify(this.mobileSortResale[key1]));
                    // bodyFormData.set(key, value);
                }
                newSortResale(bodyFormData).then(response=>{
                    this.isLoading = true
                    this.alertsuccess('You are soart a web projects')
                    this.getsortedResale()
                }).catch(error=>{
                    this.alerterror('some error')
                    console.log(error)
                })
                console.log('new sort by id',this.resaleMobileSort)
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

