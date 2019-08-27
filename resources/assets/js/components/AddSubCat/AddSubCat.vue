<template>
    <section class="container style">
     
       <b-field label="  Name">
            <b-input v-model="name"></b-input>
        </b-field>
        <b-field label=" Outcome Category">
            <b-input v-model="out_cat_id"></b-input>
        </b-field>
           <b-field label="  Due Date">
            <b-input v-model="due_date"></b-input>
        </b-field>
           <b-field label=" Notes ">
            <b-input v-model="notes"></b-input>
        </b-field>
        
        
         <button class="button is-primary" @click="addSubCategory">submit</button>
   </section>
</template>
<script>
import {addSubCategory} from './../../calls'
export default {
    data() {
            return {
                name:null,
                due_date:null,
                notes:null,
                out_cat_id:null,
                token: window.auth_user.csrf
            }},
 methods: {
  
    addSubCategory(){
        var data ={
            '_token':this.token,
            'name':this.name,
            'due_date':this.due_date,
            'out_cat_id':this.out_cat_id
        };
        addSubCategory(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/sub_categories')
        })
        .catch(error => {
                this.errorDialog()
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
            message: 'Campiagn Type '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>

<style>
    .style
    {
        background-color: white;
        padding: 20px;
    } 
</style>
