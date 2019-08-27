<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Call Status
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>                
                <div class="column first">
                    <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="columns is-12">
                                <div class="column is-6">
                                    <b-field label="ID">
                                        <b-input v-model="callstatus.id" disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                                <div class="column is-6">
                                    <b-field label="Name">
                                        <b-input v-model="callstatus.name" :disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns is-12">
                                <div class="column is-6">
                                    <b-field label="Has Next Action">
                                        <b-switch v-model="callstatus.has_next_action"
                                            :disabled="disabled"
                                            true-value="1"
                                            false-value="0">
                                        </b-switch>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns is-12 text-center" style="margin:auto">
                                <b-button :disabled="disabled" @click="updateForm" type="is-success" icon-right="pen"> Edit </b-button>
                            </div>
                        </div>
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
import {call_status , updatecallstatus} from './../../calls'
export default {
    data() {
            return {
                callstatus: [],
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                file: null,
                uploadedFile: '',
                
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
            handleFile(event) {
                const file = event
                console.log(file)
                if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedFile = reader.result
                })
            },
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getData(){
                this.isLoading = true
                    call_status(this.id).then(response=>{
                        console.log(response)
                        this.callstatus = response.data
                        console.log('call_status response',this.callstatus)
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
                    message: 'Agent '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },     
            updateForm(){
                const bodyFormData = new FormData();
                for (let key in this.callstatus) {
                    const value = this.callstatus[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('_method','put')
                updatecallstatus(bodyFormData,this.id).then(response=>{
                    console.log(response)
                  $(location).attr('href', '/admin/vue/callstatus')
                }).catch(error=>{
                    console.log(error)
                })
            }
            
        }
}
</script>