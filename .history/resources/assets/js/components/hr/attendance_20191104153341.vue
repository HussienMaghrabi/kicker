<template>
<section class="apps container">           
      
    <sidebarmenu></sidebarmenu>

    <div>
        <b>Upload Attendance File</b>
            <div class="level">
                <div class="level-item">
                    <b-datepicker
                        placeholder="Click to select..."
                        icon="calendar-today"
                        :date-formatter="dateFormatterFrom">
                    </b-datepicker>
                    
                    <b-datepicker
                        placeholder="Click to select..."
                        icon="calendar-today"
                        :date-formatter="dateFormatterTo">
                    </b-datepicker>

                </div>
                <div class="level-item">
                    <router-link to="/admin/vue/uploadLeads" class="button is-success is-meduim mr-10 import-excel">
                        Export From Excel
                    </router-link>
                </div>
            </div>
    </div>
    <hr>

    <b-field>
        <b-upload v-model="dropFiles"
            multiple
            @input="handleFile"
            drag-drop>
            <section class="section">
                <div class="content has-text-centered">
                    <p>
                        <b-icon
                            icon="upload"
                            size="is-large">
                        </b-icon>
                    </p>
                    <p>Upload File To Server</p>
                </div>
            </section>
        </b-upload>
    </b-field>

    <b-field class="file">
        <div class="tags">
            <span v-for="(file, index) in dropFiles"
                :key="index"
                class="tag is-primary" >
                {{file.name}}
                <button class="delete is-small"
                    type="button"
                    @click="deleteDropFile(index)">
                </button>
            </span>
        </div>
    </b-field>

    <b-button type="is-primary" @click="SubmitSheet">
            <b-icon icon="Send"></b-icon>
            <span>Upload</span>
    </b-button>
    <div id="app" class="column is-5" style="margin-top:10%;">
         <progress-bar size="large" bar-color="#dc720f" val="0" text="0%"></progress-bar>
    </div>
    
      </section>
</template>

<style>
.navMenu a[data-v-7f183654]{
    background-color: #fff !important;
    color: #888;
}
.navMenu[data-v-7f183654]{
    background-color: #fff;
    margin-top: 3rem;
}
.table{
    width:100% ;
    margin-bottom:2%;
}
  .btnAdd{
    background-color: #00a65a;
    color: #fff;
    border: none;
    width: 50px;
    height: 30px;
    float: right;
    margin-bottom: 5PX;
  }
  .search{
      float: right;
  }
  .add{
   float: right;
  }
  .inputSearch{
    height: 30px;
    margin-bottom: 10PX;
  }
  .apps{
      background-color: #fff;
      padding: 1% !important;
  }
 
  </style>

<script src="https://unpkg.com/@jeremyhamm/vue-slider"></script>
<script>

import Vue from 'vue'
import sidebarmenu from './sidebarmenu'
import ProgressBar from 'vue-simple-progress'

import {StoreAttendanceByEx} from './../../calls'
export default {
    data() {
            return {
                file:null,
                dropFiles: [],
            }
        },
        components: {
            'sidebarmenu': sidebarmenu,
             file: null
        },
         methods:{
             SubmitSheet(){
                 const bodyFormData = new FormData
                 bodyFormData.append('Employee_Sheet',this.dropFiles[0])
                StoreAttendanceByEx(bodyFormData).then(response=>{
                    console.log(response)
                }).catch(error=>{
                    console.log(error)
                })
             },
            deleteDropFile(index) {
                this.dropFiles.splice(index, 1)
            },
            handleFile(event) {
                const file = event
                console.log(file)
                if (!/\.(xls|xlsx|csv)$/i.test(file[0].name)) {
                    alert('Your choice is not an excel sheet')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedFile = reader.result
                })
            },
            dateFormatterFrom(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            dateFormatterTo(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
        },
}
</script>
