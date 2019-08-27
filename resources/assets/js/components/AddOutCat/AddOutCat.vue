<template>
    <section class="container style">
     
       <b-field label=" Name">
            <b-input v-model="name"></b-input>
        </b-field>
        <b-field label=" Notes">
            <b-input v-model="notes"></b-input>
        </b-field>
        
         <button class="button is-primary" @click="addCategory">submit</button>
   </section>
</template>
<script>
import {addCategory} from './../../calls'
export default {
    data() {
            return {
                name:null,
                notes:null,
                token: window.auth_user.csrf
            }},
 methods: {
  
    addCategory(){
        var data ={
            '_token':this.token,
            'name':this.name,
            'notes':this.notes
        };
        addCategory(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/outcome_category')
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
            message: 'Outcome Category '+action+' Successfully',
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
