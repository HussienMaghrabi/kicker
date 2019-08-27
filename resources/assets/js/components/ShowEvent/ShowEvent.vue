<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Event
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>                
                <div class="column first">
                    <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-12">
                                <b><label>ID: </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :disabled="disabled" v-model="events.id"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Name: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="name"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Status : </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="status"/>
                                </div>
                            </div>
                            <hr>
                            
                            </div>
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateForm">Edit</button>

                        </div>
                </section>
            </div>
        </div>
    </div>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
}
</style>
<script>
import {ShowEvent} from './../../calls'
export default {
    data() {
            return {
                event: null,
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                events:{}
            }
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            this.getData()
        },
        components: {
            
        },
        methods: {
       
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getData(){
                this.isLoading = true
                    ShowEvent(this.id).then(response=>{
                        console.log(response)
                        this.events = response.data.events
                        this.isLoading = false
                    })
                .catch(error => {
                    console.log(error)
                })
            },
            
            errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please Fill required inputs',
                    type: 'is-danger',
                })
            },
            success(action) {
                this.$toast.open({
                    message: 'Event '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
            updateForm(){

            }
            
        }
}
</script>