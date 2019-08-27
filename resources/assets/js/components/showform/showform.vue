<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Form
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
                                <b><label>English Title: </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :value="form.en_title" v-model="form.en_title" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Arabic Title: </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :value="form.ar_title" v-model="form.ar_title" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Project : </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  v-if="form.project != null" v-model="form.project.en_name" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Lead Source : </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :value="form.lead_source.name" v-model="form.lead_source.name" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                            <div v-if="disabled=disabled" class="column is-12">
                                <b><label>Type : </label></b>
                                <div class="column is-6">
                                    <b-input v-if="disabled=disabled" type="text"  v-model="form.type" :disabled="disabled" />
                                </div>
                            </div>
                            <hr> 

                            <div class="column is-6">
                            <b-field v-if="disabled==false" label=" Type"  >
                                <b-select  v-model="form.type" placeholder=" Type " expanded>
                                    <option value="project">Project</option>
                                    <option value="event">Event</option>
                                    <option value="campaign">Campaign</option>

                                </b-select>
                           </b-field>
                            </div>
                            <hr>

                           
                            <div class="column is-12">
                                <b><label>URL : </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :value="formUrl" v-model="formUrl" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <b><label>Choose Fields : </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :value="form.field" v-model="form.field" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                            <div class="column is-6">
                                <b><label style="display:block">Image: </label></b>
                                <div class="column is-6">
                                    <img :src="'/uploads/'+form.background" style="width:150px;height:150px"/>
                                </div>
                            </div>
                            <hr>
                            <div class="column is-6" style="display: flex;justify-content: center;align-items: center;">
                                <b-field class="file" v-if="disabled==false">
                                    <b-upload v-model="file"
                                    @input="handleFile">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                    <span class="file-name" v-if="file">
                                        {{ file.name }}
                                    </span>
                                </b-field>
                            </div>

                            <div v-if="file=null">
                                 

                            </div>
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateForm">Edit</button>

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
import {showform,updateForm} from './../../calls'
export default {
    data() {
            return {
                form: {},
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
                    showform(this.id).then(response=>{
                        console.log("qqqqqqqqqqqqqq",response)
                        this.form = response.data
                        this.formUrl = this.form.en_title+'-'+this.form.id
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
                    message: 'Form '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
           updateForm(){
            const bodyFormData = new FormData();
            for(let key in this.form){
                const value = this.form[key];
                bodyFormData.set(key,value);
            }
            bodyFormData.append('_method','put')
            updateForm(bodyFormData,this.id).then(response=>{
              console.log("Form update",response)
              $(location).attr('href', '/admin/vue/forms')
            }).catch(error=>{
                console.log(error)
            })
        },
            
        }
}
</script>