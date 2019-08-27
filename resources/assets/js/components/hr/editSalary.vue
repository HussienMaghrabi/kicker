<template>
    <section class="container">
    
     <sidebarmenu></sidebarmenu>
     <div class="columns" >
         <div class="column is-12" style="padding-left:2%;">
           <p style="font-size:18px;font-weight:bold;">Edit Salary</p><hr>
         </div>
     </div>

     

    <div>
            <p style="font-size:18px;font-weight:bold;margin-bottom: 2%;margin-left:1%;color:#b07d12;">Gross Salary</p>
    </div>

    <div class="columns is-12">
            <div class="column is-6" style="margin-left:2%;">
                <b-field label="Ordered by:">
                    <b-input type="text" v-model="name"></b-input>
                </b-field>
            </div>

                <div class="column is-6" style="margin-right:6%;">
                <b-field label="Allowances:" style="width:96%;">
                    <b-input type="number" v-model="name"></b-input>
                </b-field>
            </div>
    </div>

    <div class="columns is-12">
        <div class="column is-6" style="margin-left:2%;">
            <b-field label="Date:">
                <b-input type="date" v-model="name"></b-input>
            </b-field>
        </div>

            <div class="column is-6"  style="margin-right:6%;">
            <b-field label="Details:" style="width:96%;">
                    <b-input type="text" v-model="name"></b-input>
            </b-field>
        </div>
    </div>

    <div class="columns is-12">
            <b-button type="is-info">Update Salary</b-button>
    </div>
    
    <!-- Deduction  -->

    <div>
            <p style="font-size:18px;font-weight:bold;margin-bottom: 2%;margin-left:1%;color:#b07d12;">Deduction</p>
    </div>

    <div class="columns is-12">
            <div class="column is-6" style="margin-left:2%;">
                <b-field label="Ordered by:">
                    <b-input type="text" v-model="name"></b-input>
                </b-field>
            </div>

                <div class="column is-6"  style="margin-right:6%;">
                <b-field label="Deductions:" style="width:96%;">
                    <b-input type="number" v-model="name"></b-input>
                </b-field>
            </div>
    </div>

    <div class="columns is-12">
        <div class="column is-6" style="margin-left:2%;">
            <b-field label="Date:">
                <b-input type="date" v-model="name"></b-input>
            </b-field>
        </div>

            <div class="column is-6"  style="margin-right:6%;">
            <b-field label="Details:" style="width:96%;">
                    <b-input type="text" v-model="name"></b-input>
            </b-field>
        </div>
    </div>

    <div class="columns is-12">
            <b-button type="is-info" style="margin-bottom:3%;">Update Salary</b-button>
    </div>


     
    </section>
</template>
<style>
.container{
    background-color: #fff;
}
/* body{
    background-color: #fff;
} */
.button.is-info{
    margin-left: 44%;
    margin-top: 1%;
}
</style>

<script>

import sidebarmenu from './sidebarmenu'
export default {
    data() {
            return {
    }},
        components: {
            'sidebarmenu': sidebarmenu
        },
}
</script>

