<template>
    <div class="side-pop">
        <nav class="level is-mobile">
            <div class="level-left">
                <a class="level-item" aria-label="like" @click="sideClose">
                    <span class="icon is-small">
                        <i class="fa fa-close hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
            <div class="level-right">
                <a class="level-item" aria-label="like">
                    <span class="icon is-small">
                        <i class="fa fa-cloud hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
                <a class="level-item" aria-label="like">
                    <span class="icon is-small">
                        <i class="fa fa-trash-o hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
        </nav>
        <i style="color: #724a03; font-size: 1.5rem; cursor: pointer" id="editData" class="fas fa-edit" @click="editData"></i>
        <div class="column is-12">
            <div id="cil">
                <b-field v-for="(value,key) in cil" :key="key" :label="$t('header.'+key)">
                    <b-input :value="value" v-model="cil[key]" :disabled="disabled"></b-input>
                </b-field>
                <div id="footer_buttons">
                    <button class="button is-link mr-10" @click="updateCilData" :disabled="disabled">Save</button>
                    <form :action="url" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" :value="csrf">                                
                        <input type="hidden" name="cil_id" :value="hintId">
                        <button type="submit" class="button is-success is-meduim mr-10" :disabled="disabled">Download</button>
                    </form>
                </div>
            </div>
        </div>

        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>

</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>



import {getPublicData,getCilData,updateCilData,downloadCilExcel} from './../../calls'

import Multiselect from 'vue-multiselect'

export default {
    components: { Multiselect ,
    },
    data(){
        return {
            activeTab2: 0,
            activeTabsHistory:0,
            leadID: null,
            activeTab: 0,
            activeTabActions: 0,
            leadData: {},
            isLoading: false,
            isFullPage:false,
            callStatus: [],
            projects: [],
            locations: [],
            developers: [],
            devProjects: [],
            meetingStatus:[],
            token: window.auth_user.csrf,
            userId: window.auth_user.id,
            showDueCard: false,
            formatAmPm: true,
            options: [],
            disabled: true,
            defaultSortDirection: 'desc',
            cil:{},
            csrf: window.auth_user.csrf,
            url: window.location.origin + '/admin/downloadCilExcel'
        }
    },
    props: {
        sideView: {
            type: Boolean,
        },
        hintId: null,
        flag: null,
        tab: ''
    },
    watch: {
        'hintId': function(newId, oldId) {
            console.log(this.hintId)
            this.getData()
        },
        'flag': function() {
            this.getData();
        }
    },
    computed: {
        format() {
            return this.formatAmPm ? '12' : '24'
        }
    },
    methods: {
        getData(){
            this.isLoading = true
            getCilData(this.hintId).then(response=>{
                this.cil = response.data
                delete this.cil.lead_company
                this.isLoading = false
            })
            .catch(error => {
                console.log(error)
            })
        },
        getPublic(){
            getPublicData().then(response=>{
                //console.log(response)
                this.callStatus = response.data.callStatus
                this.projects = response.data.projects
                //console.log('this.projectssssssss');
                //console.log(this.projects);
                this.meetingStatus = response.data.meetingStatus
                this.locations = response.data.locations
                this.developers = response.data.developers
            })
            .catch(error => {
                console.log(error)
            })
        },

        dateFormatter(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.parsedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        dateFormatter2(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.to_do_due_date = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        timeFormater(dt){
            var time = dt.toLocaleTimeString();
            this.time = time
            return time
        },
        sideClose() {
            this.sideView = false;
            this.$emit('closeSide', this.sideView);
        },
        success(action) {
            this.$toast.open({
                message: action+' Added Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        error(action) {
            this.$toast.open({
                message: action+' Adding Error, Check missing data',
                type: 'is-danger',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        editData(){
            this.disabled = !this.disabled
        },
        updateCilData(){
            this.isLoading = true
            var data = {
                "_token": this.token,
                "cil": this.cil,
                "cil_id": this.hintId
            };
            updateCilData(data).then(response=>{
                console.log(response)
                if(response.status == 200){
                    this.getData()
                    this.success('Cil Info')
                }else {
                    this.error('Cil Info')
                    this.isLoading = false
                }
            })
            .catch(error => {
                console.log(error)
            })
        },
        downloadCilExcel(){
            // this.isLoading = true
            // var data = {
            //     "_token": this.token,
            //     "cil_id": this.hintId
            // };
            // downloadCilExcel(data).then(response=>{
            //     // if(response.status == 200){
            //     //     // this.success('Cil Info')
            //     // }else {
            //     //     // this.error('Cil Info')
            //     //     this.isLoading = false
            //     // }
            // })
            // .catch(error => {
            //     console.log(error)
            // })
        },
        
        
    }
}


</script>
<style>
.multiselect__tag,
.multiselect__option--highlight{
    background: #b07d12 !important;
}

.multiselect__tag-icon:hover{
    background: #b07d12 !important;
}
#footer_buttons{
    display:flex;
    justify-content: center;
    align-items: center;
}

</style>
