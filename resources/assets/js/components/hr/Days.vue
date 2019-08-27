<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            DAYS OF THE WEEK
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <i style="float:right;  color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-edit" @click="toggleInputsActive"></i>
                </section>
                <!-- begin data -->
                    <div class="card-content">
                        <div class="columns text-center">
                            <div class="column is-5">
                                <small> Arabic Day </small>
                            </div>
                            <div class="column is-5">
                                <small> English Day </small>
                            </div>
                            <div class="column is-1">
                                <small> Work Day </small>
                            </div>
                        </div>
                        <div class="columns" v-for="Day in Days" :key="Day.id">
                            <div class="column is-5">
                                <b-field label="">
                                    <b-input :disabled="disabled" placeholder="Arabic Day Name" v-model="Day.ar_day" ></b-input>
                                </b-field>
                            </div>
                            <div class="column is-5">
                                <b-field label="">
                                    <b-input :disabled="disabled" placeholder="English Day Name" v-model="Day.en_day" ></b-input>
                                </b-field>
                            </div>
                            <div class="column is-1">
                                <b-field label="">
                                    <div class="field" >
                                        <b-switch v-model="Day.status"
                                            :disabled="disabled"
                                            true-value="1"
                                            false-value="0">
                                            {{ Day.status }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                        </div>
                        <div class="columns padding">
                            <div class="column is-12 text-center">
                                <b-button type="is-info"
                                    @click="updateDays"
                                    :disabled="disabled"
                                    icon-left="send">
                                    Update now
                                </b-button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<script>
import {
    getDays,
    updateAllDays
} from './../../calls'
export default {
    data() {
            return {
                disabled:true,
                isLoading:true,
                isFullPage:false,
                Days:[],
            }
        },
        created(){
            this.getAllWeek()
        },
        methods: {
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getAllWeek(){
                getDays().then(response=>{
                    console.log('Days',response)
                    this.Days = response.data
                    this.isLoading = false
                }).catch(error=>{
                    console.log(error)
                })
            },
            updateDays(){
                this.isLoading = true
                const bodyFormData = new FormData();
                for (let key in this.Days) {
                    const value = this.Days[key];
                    bodyFormData.set(key, value);
                }
                updateAllDays(bodyFormData).then(response=>{
                    this.isLoading =false
                    this.getAllWeek()
                })
            }
        }
}
</script>

