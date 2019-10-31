
<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Application
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
                                    <b-field label="First Name">
                                        <b-input v-model="application.first_name" :disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                                <div class="column is-6">
                                    <b-field label="Last Name">
                                        <b-input v-model="application.last_name" :disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns is-12">
                                <div class="column is-6">
                                    <b-field label="Phone">
                                       <b-input v-model="application.phone" :disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                                <div class="column is-6">
                                        <b-field class="file" label="Cv">
                                            <b-upload v-model="application.cv">
                                                <a class="button is-primary">
                                                    <b-icon icon="upload"></b-icon>
                                                    <span>Click to upload</span>
                                                </a>
                                            </b-upload>
                                            <span class="file-name" v-if="cv">
                                                {{ application.cv }}
                                            </span>
                                        </b-field>
                                </div>
                            </div>

                            <div class="columns is-12">
                                <div class="column is-6">
                                    <b-field label="LinkedIn">
                                         <b-input v-model="application.linkedin" :disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                                <div class="column is-6">
                                    <b-field label="Website">
                                        <b-input v-model="application.website" :disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns is-12">
                                <div class="column is-6">
                                    <b-field label="Location On Map">
                                         <b-input v-model="application.location" :disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                                <div class="column is-6">
                                    <b-field label="Status">
                                        <b-select v-model="application.acceptness" expanded>
                                            <option value="under_review">Under Review </option>
                                            <option value="shortlisted">Shortlisted </option>
                                            <option value="accepted">Accepted </option>
                                            <option value="rejected">Rejected </option>
                                            <option value="proposed">proposed </option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns is-12 text-center" style="margin:auto">
                                <b-button :disabled="disabled" @click="updateApp" type="is-success" icon-right="pen"> Edit </b-button>
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
import {showApplication , updateThisApplication} from './../../calls'
export default {
    data() {
            return {
                application: [],
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
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getData(){
                this.isLoading = true
                    showApplication(this.id).then(response=>{
                        console.log(response)
                        this.application = response.data
                        this.isLoading = false
                    })
                .catch(error => {
                    console.log(error)
                })
            },   
            updateApp(){
                const bodyFormData = new FormData();
                for (let key in this.application) {
                    const value = this.application[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('_method','put')
                updateThisApplication(bodyFormData,this.id).then(response=>{
                    console.log(response)
                  $(location).attr('href', '/admin/vue/application')
                }).catch(error=>{
                    console.log(error)
                })
            }
            
        }
}
</script>