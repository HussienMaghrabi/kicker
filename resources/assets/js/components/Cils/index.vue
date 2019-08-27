<template>
    <div>
        <div class="level mb-5">
            <div class="level">
                <div class="level-item">
                </div>
            </div>            
        </div>
        <div class="container is-fluid">
            <div class="card">
                <header class="card-header level ">
                    <div class="level">
                        <div class="level-item">
                            <p class="card-header-title">
                                Cils
                            </p>
                        </div>
                    </div>
                </header>
                <div class="card-content">
                    <a class="button is-info is-meduim mr-10" @click="sendCils">Send Cils</a>                    
                    <a class="button is-info is-meduim mr-10" @click="updateCilsStatus">Update Cil Status</a>

                    <div class="columns is-mobile mb-5 ml-0" style="margin-top:10px">
                        <div class="column is-3">
                            <label class="label">Developers</label>
                            <multiselect :close-on-select="false" v-model="filter.developers" tag-placeholder="Add this as new developer" placeholder="Select Developers" label="en_name" track-by="id" value="id" :options="developers" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                        </div>
                        <div class="column is-3">
                            <label class="label">Projects</label>
                            <multiselect :close-on-select="false" v-model="filter.projects" tag-placeholder="Add this as new project" placeholder="Select Projects" label="en_name" track-by="id" value="id" :options="projects" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                        </div>
                        <div class="column is-3">
                            <div class="field">
                                <label class="label">Status</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="filter.status">
                                            <option value="not_sent">Not Sent</option>
                                            <option value="WDR">Waiting Developer Reply</option>
                                            <option value="clean_lead">Clean Lead</option>
                                            <option value="WOB">With Other Broker</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="field">
                                <label class="label">Filter Date</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="show_date">
                                            <option value="sender_date">Sender Date</option>
                                            <option value="expire_date">Expire Date</option>
                                            <option value="created_at">Created At</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns is-mobile mb-5 ml-0" style="margin-top:5px">
                        <div v-if="show_date == 'sender_date'" class="column is-3">
                            <div class="field">
                                <b-field label="From Sender Date">
                                    <b-datepicker
                                    placeholder="Click to select..."
                                    :date-formatter="dateFormatterFromSenderDate"
                                    position="is-bottom-left" v-model="filter.from_sent_date">
                                </b-datepicker>
                            </b-field>
                            </div>
                        </div>
                        <div v-if="show_date == 'sender_date'" class="column is-3">
                            <div class="field">
                                <b-field label="From Sender Date">
                                    <b-datepicker
                                    placeholder="Click to select..."
                                    :date-formatter="dateFormatterToSenderDate"
                                    position="is-bottom-left" v-model="filter.to_sent_date">
                                </b-datepicker>
                            </b-field>
                            </div>
                        </div>
                        <div v-if="show_date == 'expire_date'" class="column is-3">
                            <div class="field">
                                <b-field label="From Expire Date">
                                    <b-datepicker
                                    placeholder="Click to select..."
                                    :date-formatter="dateFormatterFromExpireDate"
                                    position="is-bottom-left" v-model="filter.from_expire_on">
                                </b-datepicker>
                            </b-field>
                            </div>
                        </div>
                        <div v-if="show_date == 'expire_date'" class="column is-3">
                            <div class="field">
                                <b-field label="To Expire Date">
                                    <b-datepicker
                                    placeholder="Click to select..."
                                    :date-formatter="dateFormatterToExpireDate"
                                    position="is-bottom-left" v-model="filter.to_expire_on">
                                </b-datepicker>
                            </b-field>
                            </div>
                        </div>
                        <div v-if="show_date == 'created_at'" class="column is-3">
                            <div class="field">
                                <b-field label="From Created at">
                                    <b-datepicker
                                    placeholder="Click to select..."
                                    :date-formatter="dateFormatterFromCreatedAt"
                                    position="is-bottom-left" v-model="filter.from_created_at">
                                    </b-datepicker>
                                </b-field>
                            </div>
                        </div>
                        <div v-if="show_date == 'created_at'" class="column is-3">
                            <div class="field">
                                <b-field label="To Created at">
                                    <b-datepicker
                                    placeholder="Click to select..."
                                    :date-formatter="dateFormatterToCreatedAt"
                                    position="is-bottom-left" v-model="filter.to_created_at">
                                    </b-datepicker>
                                </b-field>
                            </div>
                        </div>
                        <div v-if="this.teamMembers.length != 0 && this.userType != 'admin'" class="column is-3">
                            <label class="label">Team Members</label>
                            <multiselect :close-on-select="false" v-model="filter.teamMembers" tag-placeholder="Select this as new member to filter" placeholder="Select Members" label="name" track-by="id" value="id" :options="teamMembers" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                        </div>
                        <div v-if="this.userType == 'admin'" class="column is-3">
                            <label class="label">Groups</label>
                            <multiselect :close-on-select="false" v-model="filter.groups" tag-placeholder="Select this as new group to filter" placeholder="Select Groups" label="name" track-by="id" value="id" :options="groups" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                        </div>
                        <div class="column is-2">
                            <div class="control" style="margin-top: 10%;">
                                <a class="button is-success" @click="filterCils">Filter</a>
                            </div>
                        </div>
                    </div>
                    <b-table
                            :data="cils"
                            bordered
                            checkable
                            narrowed
                            hoverable

                            paginated
                            backend-pagination

                            :current-page="page"
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"

                            :checked-rows.sync="selectedCils"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="created_at"
                            >

                            <template slot-scope="props">
                                <b-table-column field="id" label="ID" sortable>
                                    {{props.row.id}}
                                </b-table-column>

                                <b-table-column field="lead_name" label="Lead Name" sortable>
                                    {{props.row.lead_first_name}} {{props.row.lead_last_name}}
                                </b-table-column>

                                <b-table-column field="requested_by" label="Requested By" sortable>
                                    {{props.row.user}}
                                </b-table-column>

                                <b-table-column field="hint" label="Hint" centered>
                                    <i class="fa fa-eye" aria-hidden="true" @click="openHint(props.row.id)"></i>
                                </b-table-column>
                                
                                <b-table-column field="project" label="Project" sortable>
                                    {{props.row.project}}
                                </b-table-column>

                                <b-table-column field="developer" label="Developer" sortable>
                                    {{props.row.developer}}
                                </b-table-column>

                                <b-table-column field="status" label="Status" sortable>
                                    {{props.row.status}}
                                </b-table-column>

                                <b-table-column field="envelop" label="Replies" centered>
                                    <i class="fa fa-envelope" aria-hidden="true" style="color: green;" v-if="props.row.replies_status == 1" @click="getCilReplies(props.row.id)"></i>
                                    <i class="fa fa-envelope" aria-hidden="true" style="color: red;" v-else-if="props.row.replies_status == 2" @click="getCilReplies(props.row.id)"></i>
                                    <i class="fa fa-envelope" aria-hidden="true" style="color: orange;" v-else-if="props.row.replies_status == 3" @click="getCilReplies(props.row.id)"></i>
                                    <i class="fa fa-envelope" aria-hidden="true" style="color: brown;" v-else-if="props.row.replies_status == 4" @click="getCilReplies(props.row.id)"></i>
                                    <i class="fa fa-envelope" aria-hidden="true" style="color: #363636;" v-else @click="getCilReplies(props.row.id)"></i>
                                </b-table-column>

                                <b-table-column field="created_at" label="Created At" sortable>
                                    {{props.row.created_at}}
                                </b-table-column>
                                
                                <b-table-column field="sent_date" label="Sent Date" sortable>
                                    {{props.row.sent_date}}
                                </b-table-column>

                                <b-table-column field="sender_name" label="Sender Name" sortable>
                                    {{props.row.sender_name}}
                                </b-table-column>

                                <b-table-column field="expire_on" label="Expire On" sortable>
                                    {{props.row.expire_on}}
                                </b-table-column>

                                <b-table-column field="options" label="Options" centered>
                                    <div class="select">
                                        <select @change="cilActions($event,props.row.id)">
                                            <option disabled selected value="options">Options</option>
                                            <option value="show">Show</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                    </div>
                                </b-table-column>
                             
                            </template>

                            <template slot="empty" v-if="!isLoading && isEmpty">
                                    <section class="section">
                                        <div class="content has-text-grey has-text-centered">
                                            <p>
                                                <b-icon
                                                icon="emoticon-sad"
                                                size="is-large">
                                            </b-icon>
                                        </p>
                                        <p>Nothing here.</p>
                                    </div>
                                </section>
                                <hr>
                            </template>
                    </b-table>
                
                </div>
            </div>
        </div>
        <div class="cils-number">{{cilsCurrentNumber + ' / ' + cilsTotalNumber}}</div>
        <b-modal :active.sync="showReplies">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">Cil Replies</p>
                </header>
                <section class="modal-card-body">
                    <div class="column is-12">
                        <b-field label="Replies">
                            <div class="cont" style="display:flex;justify-content:center;align-items:center;flex-direction:column">
                                <b-field v-for="(reply,index) in replies" :key="index+1" :label="index+1+''" style="width:100%">
                                    <b-input 
                                            :value="reply"
                                            maxlength="2000"
                                            readonly=""
                                            type="textarea"
                                            style="width:100%;overflow:auto">
                                    </b-input>
                                </b-field>
                            </div>

                        </b-field>
                    </div>
                </section>
                <footer class="modal-card-foot" style="justify-content: flex-end;">
                </footer>
            </div>
        </b-modal>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
        <CilHint :class="{openSide: ShowHint}" @closeSide="ShowHint = $event" :hintId='hintId' :flag="flag" :sideView='ShowHint'></CilHint>

    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
    import CilHint from './CilHint'
    import Multiselect from 'vue-multiselect'
    import {getCils,deleteCil,sendCils,updateCilsStatus,getCilFilterData,filterCils,getCilReplies} from './../../calls'
    export default {
        data() {
            return {
                isLoading: false,
                isFullPage: true,
                selectedCils: [],
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,
                cils: [],
                isEmpty: false,
                cilsCurrentNumber: 0,
                cilsTotalNumber: 0,
                ShowHint: false,
                hintId: '',
                reloadData: false,
                flag: 0,
                url: window.location.href,
                developers: [],
                projects: [],
                filter: {},
                showReplies: false,
                replies: [],
                teamMembers: [],
                groups: [],
                show_date: ''
            }
        },
        created() {
            this.$router.replace({hash: '#/1'});
        },
        mounted() {
            this.getData()
            this.getCilFilter();
        },
        components: {
            CilHint: CilHint,
            Multiselect
        },
        methods: {
            getData(loading = true){
                this.isLoading = loading
                this.page = parseInt(this.$route.hash.split('/')[1])
                getCils(this.page).then(response=>{
                        console.log(response)
                        this.perPage = response.data.per_page
                        this.cils = response.data.data
                        this.cilsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                        this.cilsTotalNumber = response.data.total
                        this.total = response.data.total
                        if(this.cils.length == 0){
                            this.isEmpty = true
                        }
                        let currentTotal = response.data.total
                        if (response.data.total / this.perPage > 1000) {
                            currentTotal = this.perPage * 1000
                        }
                        this.total = currentTotal                    
                        this.isLoading = false
                    })
                .catch(error => {
                    console.log(error)
                })
            },
            filterCils(loading = true){
                this.isLoading = loading
                var developers = []
                var projects = []
                var teamMembers = []
                var groups = []
                var data ={
                    'status': this.filter.status,
                    'from_sent_date': this.filter.from_sent_date,
                    'to_sent_date': this.filter.to_sent_date,
                    'from_expire_on': this.filter.from_expire_on,
                    'to_expire_on': this.filter.to_expire_on,
                    'from_created_at': this.filter.from_created_at,
                    'to_created_at': this.filter.to_created_at,
                    '_token':this.token,
                };
                if(this.filter.developers){
                    var developers = this.filter.developers.map((developer) => {
                        return developer.id;
                    });
                    data['developers'] = developers
                }
                if(this.filter.projects){
                    var projects = this.filter.projects.map((project) => {
                        return project.id;
                    });
                    data['projects'] = projects
                }
                if(this.filter.teamMembers){
                    var teamMembers = this.filter.teamMembers.map((member) => {
                        return member.id;
                    });
                    data['teamMembers'] = teamMembers
                }
                if(this.filter.groups){
                    var groups = this.filter.groups.map((group) => {
                        return group.id;
                    });
                    data['groups'] = groups                    
                }
                
                filterCils(data).then(response=>{
                        console.log(response)
                        this.perPage = response.data.per_page
                        this.cils = response.data.data
                        this.cilsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                        this.cilsTotalNumber = response.data.total
                        this.total = response.data.total
                        if(this.cils.length == 0){
                            this.isEmpty = true
                        }
                        let currentTotal = response.data.total
                        if (response.data.total / this.perPage > 1000) {
                            currentTotal = this.perPage * 1000
                        }
                        this.total = currentTotal                    
                        this.isLoading = false
                    })
                .catch(error => {
                    console.log(error)
                })
            },
            getCilFilter(){
                getCilFilterData().then(response=>{
                    console.log(response);
                    this.developers = response.data.developers
                    this.projects = response.data.projects
                    this.teamMembers = response.data.teamMembers
                    this.groups = response.data.groups
                })
                .catch(error => {
                    console.log(error)
                })
            },
            onPageChange(page) {
                this.page = page
                var url = window.location.href.split("/");
                url[url.length-1] = ''+page
                window.location.href = url.join('/');
            },
            cilActions(event,id){
                var action = event.target.value;
                if(action == 'show'){
                    window.location = '/admin/cils/'+ id +'/show/'
                }
                else if(action == 'delete') {
                    this.confirmDelete(id)
                }
            },
            confirmDelete(id) {
                this.$dialog.confirm({
                    title: "Deleting Cil",
                    message: "Are you sure you want to <b>delete</b> this Cil?",
                    confirmText: "Delete Cil",
                    type: "is-danger",
                    hasIcon: true,
                    onConfirm: () => this.deleteThisCil(id)
                });
            },
            deleteThisCil(id) {
                this.isLoading = true;
                deleteCil(id)
                .then(response => {
                this.getData();
                this.success("Deleted");
                })
                .catch(error => {
                console.log(error);
                });
            },
            openHint(id){
                this.ShowHint = true
                this.hintId = id
                this.reloadData = true

                if(id == this.hintId)
                this.flag = Math.random();

                setInterval(function () {
                    if(this.reloadData) {
                            // this.getData(false)
                            this.reloadData = false
                        }
                    }.bind(this), 5000);
            },
            sendCils(){
                this.isLoading = true;
                const cilIds = this.selectedCils.map((cil) => {
                    return cil.id;
                });
                console.log(cilIds);
                var data ={
                    'cils':cilIds,
                    '_token':this.token,
                };
                sendCils(data).then(response => {
                    if(response.data == 'permission denied'){
                        this.errorDialog('Permission Denied : You dont have send cils role')
                    }
                    else{
                        this.getData();
                        this.success("Sent Emails With Cils Data successfully!!");
                    }
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                }); 
            },
            updateCilsStatus(){
                this.isLoading = true;
                updateCilsStatus().then(response => {
                    this.getData();
                    this.success("Updated Cils Status successfully!!");
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                }); 
            },
            dateFormatterFromCreatedAt(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.filter.from_created_at = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            dateFormatterToCreatedAt(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.filter.to_created_at = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            dateFormatterFromSenderDate(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.filter.from_sent_date = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            dateFormatterToSenderDate(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.filter.to_sent_date = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            dateFormatterFromExpireDate(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.filter.from_expire_on = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            dateFormatterToExpireDate(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.filter.to_expire_on = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            getCilReplies(id){
                this.isLoading = true;
                getCilReplies(id).then(response => {
                    console.log("TEST: ",response)
                    this.showReplies = !this.showReplies
                    if(Array.isArray(response.data)){
                        this.replies = response.data
                    }else{
                        this.replies = [response.data]
                    }
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                }); 
            },
            errorDialog(message) {
                this.$dialog.alert({
                    title: 'Error',
                    message: message,
                    type: 'is-danger',
                })
            },
            success(message) {
                this.$toast.open({
                    message: message,
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
        }
    }
</script>

<style type="text/css" scoped="">
.cils-number
{
    position: absolute;
    left: 200px;
    bottom: 17.5vh;

}

@media screen and (max-width: 767px) {
    .cils-number{
        right: 10% !important;
        left: 285px !important;
    }
}
</style>