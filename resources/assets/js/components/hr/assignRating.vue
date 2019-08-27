<template>
<section class="container rating">
    
    <sidebarmenu></sidebarmenu>
    
    <b>Admin Rating</b><hr>
  
    <b-field label="Rated Person:">
        <b-select  placeholder="Choose Option" expanded>
            <option
                v-for="option in data"
                :value="option.id"
                :key="option.id">
                {{ option.user.first_name }}
            </option>
        </b-select>
    </b-field> 

     <b-field label="Admin Rate Person:">
      <multiselect v-model="value" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
      </multiselect>
    </b-field> 

         <b-button type="is-info">Rating</b-button>
     

        <!-- <div class="leads-number">{{logsCurrentNumber + ' / ' + logsTotalNumber}}</div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br> -->

      </section>
</template>

<style>
.control
{
    width: 50%;
}
.navMenu a[data-v-7f183654]{
    background-color: #fff !important;
    color: #888;
}
.navMenu[data-v-7f183654]{
    background-color: #fff;
    margin-top: 3rem;
}
.rating{
    background-color: #fff;
    padding: 1% !important;
}
  </style>

<script src="https://unpkg.com/@jeremyhamm/vue-slider"></script>
<script>
import Multiselect from 'vue-multiselect'

import sidebarmenu from './sidebarmenu'
import {action_logs} from './../../calls'
export default {
        mounted() {
            
        },
        components: {
            'sidebarmenu': sidebarmenu,
            Multiselect
        },
         data () {
            return {
                value: [],
                options: [
                    { name: 'Vue.js', language: 'JavaScript' },
                    { name: 'Adonis', language: 'JavaScript' },
                    { name: 'Rails', language: 'Ruby' },
                    { name: 'Sinatra', language: 'Ruby' },
                    { name: 'Laravel', language: 'PHP' },
                    { name: 'Phoenix', language: 'Elixir' }
                ]
            }
        },
        created() {
            this.$router.replace({hash: '#/1'});
         },
         methods:{
       
         },
}
</script>