<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Tag
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
                                <b><label>English Name: </label></b> 
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="tags.en_name"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Arabic Name: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="tags.ar_name"/>
                                </div>
                            </div>
                            <hr>
                        
                     
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateTags">Edit</button>

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
import {showTag,updateTags} from './../../calls'
export default {
    data() {
            return {
                tags:{},
                form: null,
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

            getData(){
            this.isLoading = true
                showTag(this.id).then(response=>{
                    console.log(response)
                this.tags = response.data
                console.log(this.tags)
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
            toggleInputsActive(){
                this.disabled = !this.disabled
        },
           
               updateTags(){
            const bodyFormData = new FormData();
            for(let key in this.tags){
                const value = this.tags[key];
                bodyFormData.set(key,value);
            }
            bodyFormData.append('_method','put')
            updateTags(bodyFormData,this.id).then(response=>{
              console.log("Tag update",response)
              $(location).attr('href', '/admin/vue/tags')
            }).catch(error=>{
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
                    message: 'Tag '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
    
            
        }
}
</script>