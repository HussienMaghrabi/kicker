<template>
	<div style="text-align: center; ">
		<!-- Header -->
		<Header />

		<h2 style="text-align: center; " >Archive</h2>
		<div class="container">
			<div class="row">
				<div class="col-xs-2">
					<div class="field">
			            <b-checkbox v-model="archivingData.wrongNubmer">Wrong Numbers</b-checkbox>
			        </div>
			    </div>
				<div class="col-xs-2">
			        <div class="field">
			            <b-checkbox v-model="archivingData.probability">Status of Answered & Propabily Lowest</b-checkbox>
			        </div>
			    </div>
				<div class="col-xs-2">
			        <div class="field">
			            <b-checkbox v-model="archivingData.archive_agent">Archiveing Agent data</b-checkbox>
			        </div>
			    </div>
				<div class="col-xs-2">
				    <b-field label="Simple">
			            <b-select placeholder="Select a name" v-model="archivingData.agentId" :disabled="archivingData.archive_agent == false">
			                <option
			                    v-for="option in allAgents"
			                    :value="option.id"
			                    :key="option.id">
			                    {{ option.name }}
			                </option>
			            </b-select>
			        </b-field>
			    </div>
				<div class="col-xs-2">
			        <b-field label="Select a date">
				        <b-datepicker
				        	v-model="archivingData.from"
				            placeholder="Click to select..."
				            icon="calendar-today"
				            :date-formatter="dateFormatterFrom">
				        </b-datepicker>
				    </b-field>
				</div>
				<div class="col-xs-2">
				    <b-field label="Select a date">
				        <b-datepicker
				        	v-model="archivingData.to"
				            placeholder="Click to select..."
				            icon="calendar-today"
				            :date-formatter="dateFormatterTo">
				        </b-datepicker>
				    </b-field>
				</div>
				<div class="col-xs-2">
					<a class="button" @click="archive">Process</a>
				</div>
			</div> <!-- end row -->
		  </div> <!-- end Container -->

		<!-- Footer -->
		<Footer />
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
	</div>
</template>

<script type="text/javascript">
	import {archiveData, getArchive,changeLeadFav, changeLeadHot, deleteLead, newLeadsFilter,getPublicData,switchLeads,getAgents,checkUserGroupAndRoles,searchForLead, getLeadSources, getLeadsByAgent, addCall,bulkActions,filter_archives} from './../../calls'
import Header from '../Layout/Header'
import Footer from '../Layout/Footer'
	export default {
	    data() {
	        return {
	        	archivingData: {
					archive_agent:false,
				},
	        	allAgents: [],
	        	parsedDateFrom: '',
	        	parsedDateTo: '',
                isFullPage: true,
            	isLoading: false,
	            loading: false,

	        }
	    },
	    mounted() {
	        this.getAgentData()
	    },
	    components: {
	    	Header: Header,
            Footer: Footer,
	    },
	    created() {

	    },
	    methods: {
			archive(){
                this.isLoading = true
                var data ={
					'wrong_number': this.archivingData.wrongNubmer,
					'probability': this.archivingData.probability,
					'archive_all': this.archivingData.archive_agent,
                    'dateFrom':this.parsedDateFrom,
					'dateTo':this.parsedDateTo
                };
				if(this.archivingData.archive_agent == true){
					data['agent_id'] = this.archivingData.agentId
				}
                archiveData(data).then(response=>{
					console.log(response)
                    this.isLoading = false
                })
                .catch(error => {
                    console.log(error)
                })
            },
	    	getAgentData(){
	    		getAgents().then(response=> {
	    			this.allAgents.push({id: 0, name: "All"})
	    			response.data.commercialAgents.forEach(element=>{

	    				this.allAgents.push(element)
	    			})
                	response.data.residentialAgents.forEach(element=>{
	    				this.allAgents.push(element)
	    			})
	    		}).catch(error=> {

	    		});
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
                this.parsedDateTo = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            }
	    }
	}

</script>
