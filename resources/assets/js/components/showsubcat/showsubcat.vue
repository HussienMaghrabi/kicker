<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Outcome Sub_category
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
                                <b><label> Name: </label></b> 
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="subcat.name"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Outcome Category : </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="subcat.outcome"/>
                                </div>
                            </div>
                            <hr>
                                  <div class="column is-12">
                                <b><label>Due Date : </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="subcat.due_date"/>
                                </div>
                            </div>
                            <hr>
                                  <div class="column is-12">
                                <b><label> Notes: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="subcat.notes"/>
                                </div>
                            </div>
                            <hr>
                        
                     
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateSubCategory">Edit</button>

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
import {showsubcat,updateSubCategory} from './../../calls'
export default {
    data() {
            return {
                subcat:{},
                form: null,
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                file: null,
                uploadedFile: '',
                out_cat_id:''
                
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
                showsubcat(this.id).then(response=>{
                    console.log(response)
                this.subcat = response.data
                console.log("saaaaaaaaaaaaaaaaa",this.subcat)
                console.log(this.subcat)
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
                    message: 'Outcome Subcategory '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
             updateSubCategory(){
            const bodyFormData = new FormData();
            for(let key in this.subcat){
                const value = this.subcat[key];
                bodyFormData.set(key,value);
            }
            bodyFormData.append('_method','put')
            updateSubCategory(bodyFormData,this.id).then(response=>{
              console.log("Outcome Subcategory update",response)
              $(location).attr('href', '/admin/vue/sub_categories')
            }).catch(error=>{
                console.log(error)
            })
        },
    
            
        }
}
</script>