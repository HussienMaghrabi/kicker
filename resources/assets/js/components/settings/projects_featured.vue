<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Projects feature
                        </p>
                    </div>
                </div>
            </header>
                <section class="container tasks">
                    <!-- <i style="float:right;  color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-edit" @click="toggleInputsActive"></i> -->
                </section>
                <!-- begin data -->
            <div class="card-content">
                <div v-for="feature in featured" :key="feature.id" class="columns">
                    <div class="column is-1">
                        <p>{{ feature.id }}</p>
                    </div>
                    <div class="column is-8 text-center">
                        <strong>{{ feature.en_name }}</strong>
                    </div>
                    <div class="column is-3">
                        <b-button @click="remove(feature.id)" type="is-danger">Remove</b-button>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<script>
import {
    getprojectsfeature,
    removefeatureByID
} from './../../calls'
export default {
    data() {
            return {
                featured:[],
                disabled:true,
                isLoading:true,
                isFullPage:false,
            }
        },
    mounted(){
        this.getdata()
    },
    methods: {
        toggleInputsActive(){
            this.disabled = !this.disabled
        },
        getdata(){
            this.isLoading = true
            getprojectsfeature().then(response=>{
                console.log(response)
                this.featured = response.data
                this.isLoading = false
            }).catch(error=>{
                console.log(response)
            })
        },
        remove(id){
            this.$dialog.confirm({
                title: 'Deleting',
                message: 'Are you sure you want to <b>Remove</b> this feature from website ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.Removefeature(id)
            })
        },
        Removefeature(id){
            this.isLoading = true
            removefeatureByID(id).then(response=>{
                this.isLoading = false
                this.getdata()
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>
