<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            onesignal Api Key
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <i style="float:right;  color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-edit" @click="toggleInputsActive"></i>
                </section>
                <!-- begin data -->
                    <div class="card-content">
                            <div class="columns padding">
                                <div class="column is-12">
                                    <b-field label="ONESIGNAL APP ID">
                                        <b-input :disabled="disabled" placeholder="ONESIGNAL APP ID" v-model="onesignal.api_key" ></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns padding">
                                <div class="column is-12">
                                    <b-field label="REST API KEY">
                                        <b-input :disabled="disabled" placeholder="REST API KEY" v-model="onesignal.rest_key" ></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <br>
                            <div class="columns padding">
                                <div class="column is-12 text-center">
                                    <b-button type="is-info"
                                        :disabled="disabled"
                                        @click="editonsignalKey"
                                        icon-left="send">
                                        Edit now
                                    </b-button>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
        <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>

<script>
    import {
        getonesignal,
        saveNewKey
    } from "./../../calls";

export default {
    data() {
        return {
            isLoading:true,
            disabled:true,
            Key:'',
            onesignal:[]
        }
    },
    created(){
        this.getdata()
    },
    methods: {
        toggleInputsActive(){
            this.disabled = !this.disabled
        },
        getdata(){
            getonesignal().then(response=>{
                console.log('onesingnale data',response)
                this.onesignal = response.data
                this.isLoading = false
            }).catch(error=>{
                console.log(error)
            })
        },
        editonsignalKey(){
            const bodyFormData = new FormData();
            for (let key in this.onesignal) {
                const value = this.onesignal[key];
                bodyFormData.set(key, value);
            }
            saveNewKey(bodyFormData).then(response=>{
                this.alertsuccess('Success Update Api key for onesiganl')
                this.getdata()
            }).catch(error=>{
                this.alerterror('error Api key for onesiganl')
                console.log(error)
            })
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
