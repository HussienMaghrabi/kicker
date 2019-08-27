<template>
	<div style="text-align: center; ">
		<!-- Header -->
		<Header />

		<!-- v-if="this.$route.path != '/archive/1'" -->
		<Index v-if="this.$route.path != '/index/1'" > </Index>
		<Show v-if="this.$route.path != '/show/1'" ></Show>

		<!-- Footer -->
		<Footer />
	</div>
</template>

<script type="text/javascript">
	import {archiveData, getArchive,changeLeadFav, changeLeadHot, deleteLead, newLeadsFilter,getPublicData,switchLeads,getAgents,checkUserGroupAndRoles,searchForLead, getLeadSources, getLeadsByAgent, addCall,bulkActions} from './../../calls'

	import Header from '../Layout/Header'
	import Footer from '../Layout/Footer'
	import Index from './Index'
	import Show from './Show'
	export default {
	    data() {
	        return {

	        }
	    },
	    mounted() {
	        this.getAgentData()
	    },
	    components: {
	    	Header: Header,
            Footer: Footer,
            Index: Index,
            Show: Show,
	    },
	    created() {

	    },
	    methods: {
	    },
	}