<template>
    <div class="container">
        <section>
            <div class="card">
                <header class="card-header level ">
                    <div class="level">
                        <div class="level-item">
                            <p class="card-header-title">
                                Custom Role page
                            </p>
                        </div>
                    </div>
                </header>
                <div class="card-content">
                    <div class="columns is-multiline is-mobile">
                        <div class="column">
                            <b-field label="RoleName">
                                <b-input placeholder="Disabled" v-model="RoleName.name" disabled></b-input>
                            </b-field>
                        </div>
                    </div>
                    <br>
                    <div class="columns is-multiline is-mobile">
                        <div v-for="detail in AllDetails" :key="detail.id" class="column is-4">
                            <div class="field">
                                <b-switch :v-model="Selector[index].detail.id"  :true-value="detail.id" false-value="0">{{ detail.name }}</b-switch>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import {
    GetRoleAndDetails,
    GetApiAllRole,
    GetApiAllRoleDetails,
} from './../../calls'
export default {
    data(){
        return{
            roleId:null,
            RoleName:[],
            AllDetails:[],
            Checkablle:[],
            Selector:[],
        }
    },
    created(){
        console.log('sadasd');
            this.roleId = this.$route.params.id
    },
    mounted(){
        // this.getData()
        this.getRoles()
        this.getRolesDetails()
    },
    methods:{
        getData(){
            GetRoleAndDetails(this.roleId).then(response=>{
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
        },
        getRoles(){
            GetApiAllRole(this.roleId).then(response=>{
                this.RoleName = response.data
            }).catch(error=>{
                console.log(error)
            })
        },
        getRolesDetails(){
            GetApiAllRoleDetails().then(response=>{
                this.AllDetails = response.data
                this.Selector = response.data
            }).catch(error=>{
                console.log(error)
            })
        }
    },
}
</script>
