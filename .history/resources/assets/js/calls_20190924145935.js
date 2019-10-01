// Import axios
import axios from 'axios';

// Get My Leads
export const getNotifications = (data) => {
    return axios.post('/api/agent/notification', data)
}

// change status for notifcation
export const notification_status = (id) => {
    return axios.get('/admin/notificationStatus/'+id)
}
// change status for notifcation
export const ChangeAllNotification = () => {
    return axios.get('/admin/ChangeAllNotification')
}
// change Cil notifcation
export const clearNumCil = () => {
    return axios.get('/admin/clearNumCil')
}
// get onesignal
export const getonesignal = () => {
    return axios.get('/admin/getonesignal/')
}
// save onsignal
export const saveNewKey = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/getonesignal',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Get My Leads
export const getLeadsByAgent = (data) => {
    return axios.post('/admin/get_leads_by_agent', data)
}

// Get Btns
export const getBtns = (data) => {
    return axios.post('/admin/getBtns', data)
}

// updte vacancy type
export const updateVacancy = (id,data) => {
    return axios.post('/admin/updateVacancy/'+id,data)
}
// add request type
export const AddRequestType = (data) => {
    return axios.post('/admin/AddRequestType',data)
}
// edit request type
export const requestEditData = (id) => {
    return axios.get('/admin/editrequesttype/'+id)
}
// update request type
export const updaterequesttype = (id,data) => {
    return axios.post('/admin/updaterequesttype/'+id,data)
}
// update request type
export const DeleteRequestType = (id) => {
    return axios.get('/admin/DeleteRequestType/'+id)
}
// update request type
export const AddRequestStatus = (data) => {
    return axios.post('/admin/AddRequestStatus/',data)
}

// edit request status
export const editRequestStatus = (id) => {
    return axios.get('/admin/editRequestStatus/'+id)
}

// update request status
export const updaterequeststatus = (id,data) => {
    return axios.post('/admin/updaterequeststatus/'+id,data)
}

// delete request status
export const DeleterequestStatusType = (id) => {
    return axios.post('/admin/DeleterequestStatusType/'+id)
}

export const getprojectsfeature = () => {
    return axios.get('/admin/getprojectsfeature')
}
export const getresalefeature = () => {
    return axios.get('/admin/getresalefeature')
}

// Get My Leads
export const getLeads = (page) => {
    return axios.get('/admin/leads?page='+page)
}
// Get vacancy type
export const getVacancyType = (page) => {
    return axios.get('/admin/getVacancyType?page='+page)
}
// Get vacancy type
export const getVacanceType = () => {
    return axios.get('/admin/getVacanceType')
}

// Get all contracts
export const getAllContracts = (page) => {
    return axios.get('/admin/contracts?page='+page)
}

export const removeBannerByID = (id) => {
    return axios.get('/admin/removeBannerByID/'+id)
}

export const removefeatureByID = (id) => {
    return axios.get('/admin/removefeatureByID/'+id)
}

export const removefeatureResaleByID = (id) => {
    return axios.get('/admin/removefeatureResaleByID/'+id)
}

// Get Archive
export const getArchive = (page) => {
    return axios.get('/admin/getArchive?page='+page)
}

// Get Individual Leads
export const getIndividualLeads = (page) => {
    return axios.get('/admin/getIndividualLeads?page='+page)
}

// Get Team Leads
export const getTeamLeads = (page) => {
    return axios.get('/admin/getTeamLeadsNew?page='+page)
}

// Get Hot Leads
export const getHotLeads = (page) => {
    return axios.get('/admin/getHotLeads?page='+page)
}

// Get today leads Leads
export const getTodayLeads = (page) => {
    return axios.get('/admin/getTodayLeads?page='+page)
}

// Get Hot Leads
export const getSeen = (page) => {
    return axios.get('/admin/getSeen?page='+page)
}

// Get Hot Leads
export const getNotSeen = (page) => {
    return axios.get('/admin/getNotSeen?page='+page)
}

// Get Cold Calls Leads
export const getColdCalls = (page) => {
    return axios.get('/admin/getColdCalls?page='+page)
}

// Get Today Cold Calls Leads
export const getTodayColdCalls = (page) => {
    return axios.get('/admin/getTodayColdCalls?page='+page)
}

// Get Lead massage
export const GetLeadMassege = (data) => {
    return axios.post('/admin/GetLeadMassege',data)
}
// Get Lead History
export const GetleadHistory = (data) => {
    return axios.post('/admin/GetleadHistory',data)
}
// Get lead from request page
export const FromrequestPage = (data) => {
    return axios.post('/admin/FromrequestPage/',data)
}
// Get Lead Contracts
export const GetLeadContracts = (data) => {
    return axios.post('/admin/GetLeadContracts',data)
}
// Get Lead Contacts
export const GetLeadContacts = (data) => {
    return axios.post('/admin/GetLeadContacts',data)
}
// Get Lead Contacts
export const GetleadInterest = (data) => {
    return axios.post('/admin/GetleadInterest',data)
}
// Get Lead intrest for single lead page
export const getSingleleadinterest = (data) => {
    return axios.post('/admin/getSingleleadinterest',data)
}
// Get Lead Contacts
export const GetFavoriteLead = (data) => {
    return axios.post('/admin/GetFavoriteLead',data)
}
// Get Lead Info for edit
export const GetleadInfo = (data) => {
    return axios.post('/admin/GetleadInfo',data)
}
// get all call status
// export const callstatus = () => {
//     return axios.get('/admin/GetAllStatusOfCalls')
// }
// Get Lead history of switch
export const GetleadSwitchHistory = (data) => {
    return axios.post('/admin/GetleadSwitchHistory',data)
}
export const Getcilslead = (data) => {
    return axios.post('/admin/Getcilslead',data)
}

// Add New Contact
export const saveOtherContacts = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/Contactlead',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}
// update call status
export const updatecallstatus = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/call_statuses/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// edit leads
export const updatelead = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/updatelead',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
    // return axios.post('/admin/ccgevents',data)
}

export const getMyLeads = (page) => {
    return axios.get('/admin/getMyLeads?page='+page)
}


// edit employee
export const updateEmployees = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/updateEmployees',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}


// edit lead calls
export const editCalls = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/editLeadsCalls',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
    // return axios.post('/admin/ccgevents',data)
}


// Change Lead Fav Status
export const changeLeadFav = (data) => {
    return axios.post('/admin/fav_lead',data)
}

// Change Lead Hot Status
export const changeLeadHot = (data) => {
    return axios.post('/admin/hot_lead',data)
}

// Change Lead Hot Status
export const getCountries = () => {
    return axios.get('/admin/getCountries')
}
export const getcities = () => {
    return axios.get('/admin/getcities')
}
export const deleteLead = (id) => {
    return axios.get('/admin/delete-lead/'+id)
}
//delete Resale
export const deleteResale = (id) => {
    return axios.get('/admin/delete-resale/'+id)
}
export const deleteRental = (id) => {
    return axios.get('/admin/delete-rental/'+id)
}
// Change Lead Hot Status
export const getLeadData = (id) => {
    return axios.get('/admin/getLeadData/'+id)
}

// Add Call
export const addCall = (data) => {
    return axios.post('/admin/add_call',data)
}

// Add bulkActions
export const bulkActions = (data) => {
    return axios.post('/admin/bulkActions',data)
}

// Add Meetings
export const addMeeting = (data) => {
    return axios.post('/admin/add_meetings',data)
}

// Add Request
export const addRequest = (data) => {
    return axios.post('/admin/add_Request',data)
}

// Add Note
export const addNote = (data) => {
    return axios.post('/admin/add_note_ajax',data)
}

// Get Public Data
export const getPublicData = () => {
    return axios.get('/{l}/admin/getPublicData')
}

// Get Agents
export const getAgents = () => {
    return axios.get('/admin/getAgents')
}

// Filter Leads
export const newLeadsFilter = (page,data) => {
    return axios.post('/admin/newLeadsFilter?page='+page,data)
}
//newResaleFilter
export const newResaleFilter = (page,data) => {
    return axios.post('/admin/newResaleFilter?page='+page,data)
}
export const newRentalFilter = (page,data) => {
    return axios.post('/admin/newRentalFilter?page='+page,data)
}
// Filt er Report Leads
export const exportReportLeads = (page,data) => {
    return axios.post('/admin/exportReportLeads?page='+page,data)
}

// Switch Leads
export const switchLeads = (data) => {
    return axios.post('/admin/switch_leads',data)
}

// get user infromation
export const getUserById = () => {
    return axios.get('/admin/getUserHowLogin')
}

// Switch Leads
export const autoSwitchAPi = (data) => {
    return axios.post('/admin/autoSwitch', data)
}

// Switch Leads
export const checkUserGroupAndRoles = () => {
    return axios.get('/admin/checkUserGroupAndRoles')
}
// Switch activation assistant
export const assistantChangeStatus = (send) => {
    return axios.post('/admin/changeAssistantStatus',send)
}

// Get Unit Types
export const getUnitTypes = (data) => {
    return axios.post('/admin/getUnitsTypesnew',data)
}

// Get Unit Types
export const searchForLead = (data) => {
    return axios.post('/admin/searchForLead',data)
}

// Add New ToDo
export const addToDo = (data) => {
    return axios.post('/admin/addToDo',data)
}

// Add New ToDo
export const getDevProjects = (id) => {
    return axios.get('/admin/getDevProjects/'+id)
}

// Add Cil Request
export const addCILRequest = (data) => {
    return axios.post('/admin/addCILRequest',data)
}

// Add New Resale
export const storeUnitResale = (data) => {
    return axios.post('/admin/storeUnitResale',data)
}
// Get All Leads
export const getAllLeads = () => {
    return axios.get('/admin/getAllLeads')
}

export const getAllLeadsAutocompleteList = (usrInput) => {
    return axios.get('/admin/leads/autocomplete/list?q='+usrInput);
}

// Get All Leads
export const getLeadSources = () => {
    return axios.get('/admin/getLeadSources')
}

// Add Short Lead
export const leadShortAdding = (data) => {
    return axios.post('/admin/leadShortAdding',data)
}

// --------------------------------------------- //

// Get My Leads
export const getResales = (data, page) => {
    return axios.post('/api/agent/get_resales?page='+page, data)
}
export const getRental = (data, page) => {
    return axios.post('/api/agent/get_rentals?page='+page, data)
}
export const displayTable = ($value) => {
    return $value;
}

export const getSuggestedProjects = (data,page) => {
  return axios.post('/admin/get_suggestions',data);
}

export const deleteNoActionLeads = () => {
  return axios.get('/admin/deleteNoActionLeads');
}

export const deleteFilteredLeads = (data) => {
  return axios.post('/admin/deleteFilteredLeads',data);
}

export const fetchDashboardSingleEventsYourCalender = (id) => {
    return axios.get(`/admin/todos/find/${id}`);
}

export const singleTodoTeamCalendar = (id) => {
    return axios.get(`/admin/singleTeamCalendarTodo/${id}`);
}

export const fetchDashboardSectionStatistics = (uid, startDate, endDate) => {
    return axios.get('/api/dashboard/agent/dashboard-section-statistics', {
        params: {
            uid,
            startDate,
            endDate
        }
      })
}

export const fetchDashboardProjectSection = (startDate, endDate) => {
    return axios.get('/api/dashboard/projects', {
        params: {
            startDate,
            endDate
        }
      })
}

// dashborad
export const dashgetstatus = (data) => {
    return axios.post('/api/agent/dash_get_status', data)
}

// dashboard lead source
export const dashgetsource = (data) => {
    return axios.post('/api/agent/dash_get_sources', data)
}

// dashboard dashboard
export const dashdashboard = (data) => {
    return axios.post('/api/agent/get_agent_leads', data) 
}

export const achievementsSectionDashboard = (req) => {
    return axios.post('/api/dashboard/agent/achievements', req);
}

export const teamAchievementsSectionDashboard = (req) => {
    return axios.post('/api/dashboard/agent/teamAchievements', req);
}


export const dashActivity = (req) => {
    return axios.post('/admin/get_activity', req)
}

export const getTeams = (req) => {
    return axios.post('/api/agent/get_teams', req)
}

export const teamCalendar = (req) => {
    return axios.get('/admin/teamCalendar', req)
}

export const getAgentNames = (req) => {
    return axios.get('/admin/getAgentNames', req)
}

export const getLeadName = (req) => {
    return axios.get('/admin/getLeadName', req)
}

// store todos
export const store = (req) => {
    return axios.post('/admin/todos', req)
}

// change status to done
export const confirmTodo = (id) => {
    return axios.get(`/admin/confirm_to_do/${id}`)
}

export const fetchDashboardEvents = () => {
    return axios.get('/admin/yourCalendarEvents')
}

export const yourCalendarEventsNotf = () => {
    return axios.get('/admin/yourCalendarEventsNotf')
}

// get all leads by agent id who is aleardy logged in
export const getLeadsByAgentId = (req) => {
    return axios.get('/admin/getLeadsByAgentId', req)
}

// edit dashboard sections order
export const edit_dashboard = (req) => {
    return axios.post('/admin/edit_dashboard', req)
}

// get dashboard sections order
export const getOrder = () => {
    return axios.get('/admin/getOrder')
}

// get pending Today Todos 
export const pendingTodayTodos = () => {
    return axios.get('/admin/pendingTodayTodos')
}

// get Owned Units including resales , rentals , New homes 
export const getOwnedUnits = (id) => {
    return axios.get(`/admin/getOwnedUnits/${id}`)
}

// get all tags
export const getHintTags = () => {
    return axios.get('/admin/hintTags')
}

// save multiple tags for a certain lead
export const storeMultipleTags = (req) => {
    return axios.post('/admin/storeMultipleTags', req)
}

// add Suggestions to a certain lead
export const addSuggestions = (req) => {
    return axios.post('/admin/add_suggestion', req)
}

// get team achievements dashboard
export const teamAchievements = (req) => {
    return axios.post('/api/dashboard/agent/teamAchievements', req)
}

// delete todo 
export const deleteTodo = (id) => {
    return axios.get('/admin/deleteTodo/'+id)
}


// get suggestions that belong to a specific lead
export const getLeadSuggestions = (id) => {
    return axios.get(`/admin/suggestions/${id}`)
}

// Get suggestions after filtering input hint
export const getSuggestionsNew = (data) => {
    return axios.post('/admin/get_suggestions_new',data);
}

// Get Leads that have units (Resale or Rental)
export const getUnitLeads = (data) => {
    return axios.post('/admin/getUnitLeads',data);
}

// Convert Lead from cold calls to another lead source
export const convertLeadCC = (id) => {
    return axios.get('/admin/convertLeadCC/'+id)
}

// Upload Leads Excel sheet file
export const uploadLeadExcel = (data) => {
    return axios({
        method: 'POST',
        url: '/admin/upload_leads_excel',
        data: data,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Restore Lead from Archive by his/her ID
export const restoreLead = (id) => {
    return axios.get('/admin/restore-lead/'+id)
}

// Delete Lead from Archive by his/her ID
export const deleteArchiveLead = (id) => {
    return axios.get('/admin/delete-archive-lead/'+id)
}

// Filter and archive data by specific inputs
export const archiveData = (data) => {
    return axios.post('/admin/archive_data',data)
}

// Get Duplicated Leads
export const getDuplicatedLeads = (page) => {
    return axios.get('/admin/getDuplicatedLeads?page='+page)
}

// Delete Duplicate Lead
export const deleteDuplicateLead = (id) => {
    return axios.get('/admin/delete-duplicate-lead/'+id)
}

// Delete Selected Duplicate Leads
export const deleteDuplicateLeads = (data) => {
    return axios.post('/admin/delete-duplicate-leads/',data)
}

// Get Lead Summaries
export const getLeadSummaries = (page) => {
    return axios.get('/admin/getLeadSummaries?page='+page)
}

// Delete Selected Duplicate Leads
export const deleteLeadsummaries = (data) => {
    return axios.post('/admin/delete-lead-summaries/',data)
}

// Get Favorite Leads
export const getFavoriteLeads = (page) => {
    return axios.get('/admin/getFavoriteLeads?page='+page)
}

// Delete Duplicate Lead
export const replaceDuplicateLead = (id) => {
    return axios.get('/admin/replace_duplicate_lead/'+id)
}

// Search for duplicates by specific inputs
export const searchForDuplicate = (data) => {
    return axios.post('/admin/searchForDuplicate',data)
}

// Delete Duplicate Lead
export const replaceDuplicateLeads = (data) => {
    return axios.post('/admin/replace_duplicate_leads',data)
}

// Update show on website value for resale unit
export const updateWebsiteResaleShow = (id) => {
    return axios.get('/admin/updateWebsiteResaleShow/'+id)
}

export const getAllDevelopers = () => {
    return axios.get('/admin/getDeveloperInfo');
}
export const getAllDevelopersWithPaginate = (page) => {
    return axios.get('/admin/getDeveloperInfoWithPaginate?page='+page)
}
export const getAllProjectsWithPaginate = (page) => {
    return axios.get('/admin/getProjectsInfoWithPaginate?page='+page)
}
export const searchForDevelopers = (data) => {
    return axios.post('/admin/searchForDeveloper',data)
}

// Get Cils
export const getCils = (page) => {
    return axios.get('/admin/getCils?page='+page)
}

// Delete a cil
export const deleteCil = (id) => {
    return axios.delete('/admin/cils/'+id)
}

// Get cil data from the saved excel
export const getCilData = (id) => {
    return axios.get('/admin/getCilData/'+id)
}

// Update Cil Data
export const updateCilData = (data) => {
    return axios.post('/admin/updateCilData',data)
}

export const getDeveloperById = (id) => {
    return axios.get('/admin/getDeveloperById/'+id)
}
// Update delete proposal
export const deleteProp = (id) => {
    return axios.get('/admin/delete-prop/'+id)
}
//store proposal
export const storeProposal = (data) => {
    return axios.post('/admin/proposals',data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
      })
}

//update proposal
export const updateProposal = (data) => {
    return axios.post('/admin/proposals_update',data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
      })
}

// Update confirm proposal
export const confirmProp = (id) => {
    return axios.get('/admin/confirm_proposal/'+id)
}
//get all lands in proposal
export const getLands = () => {
    return axios.get('/admin/get_lands')
}
// get units in proposal
export const getUnits = (data) =>{
    return axios.post('/admin/get_units',data);
}

//get Agent leads in proposal
export const getAgentLeads = () => {
    return axios.get('/admin/getAgentLeads')
}

//get developer Projects 
export const getDeveloperProjects = (data) => {
    return axios.post('/admin/get_projects',data)
}

//get Projects phases 
export const getProjectsPhases = (data) => {
    return axios.post('/admin/get_phases',data)
}

//get GetPhasesUnit 
export const getPhasesUnit = (data) => {
    return axios.post('/admin/get_phase_units',data)
}
//delete developer 
export const deleteDeveloper = (id) => {
    return axios.post('/admin/delete-dev/'+ id)
}

export const getAllProposalsWithPaginate = (page) => {
    return axios.get('/admin/getProposalWithPaginate?page='+page)
}
// Download Cil Excel sheet with it's saved data
export const downloadCilExcel = (data) => {
    return axios.post('/admin/downloadCilExcel',data)
}

// Search if input phone number is present in leads table
export const searchForLeadPhone = (data) => {
    return axios.post('/admin/searchForLeadPhone',data)
}


//get all closed deals with paginate
export const getAllDealsWithPaginate = (page) => {
    return axios.get('/admin/getAllDealsWithPaginate?page='+page)
}

// show closed deals
export const showDeal = (id) => {
    return axios.get('/admin/show_deal/'+id)
}

// get proposals confirmed with deals
export const getProposalsConfirmed = () => {
    return axios.get('/admin/get_proposals_confirmed')
}

// get proposal in closed deals
export const getProposalClosedDeal = (id) => {
    return axios.get('/admin/get_proposal_closed_deal/'+id)
}
// get all agents
export const getAllAgents = () => {
    return axios.get('/admin/getAllAgents')
}

//store deal
export const storeDeal = (data) => {
    return axios.post('/admin/deals',data)
}

//delete deal
export const DeleteDeal = (id) => {
    return axios.get('/admin/delete-deal/'+ id)
}
// Get Cil Settings Info for the application
export const getCilSettings = () => {
    return axios.get('/admin/getCilSettings')
}

export const getUserEmails = (data) => {
    return axios.post('/admin/getUserEmails',data)
}

// Bulk Delete Selected Leads
export const deleteSelectedLeads = (data) => {
    return axios.post('/admin/deleteSelectedLeads',data)
}

// save Cil Settings with the new changes made.
export const saveCilSettings = (data) => {
    return axios.post('/admin/saveCilSettings', data)
}

// Get Cil Emails for settings
export const getCilEmails = () => {
    return axios.get('/admin/getCilEmails')
}

// Get Cil Accepted Keywords
export const getCilAcceptedKeywords = () => {
    return axios.get('/admin/getCilAcceptedKeywords')
}

// Get Cil Rejected Keywords
export const getCilRejectedKeywords = () => {
    return axios.get('/admin/getCilRejectedKeywords')
}

// Send Emails with Cil Data
export const sendCils = (data) => {
    return axios.post('/admin/sendCils', data)
}

// Upload Resale Units Excel sheet file
export const uploadResaleExcel = (data) => {
    return axios({
        method: 'POST',
        url: '/admin/upload_resale_excel',
        data: data,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}
export const Addform = (data) => {
    return axios({
        method: 'POST',
        url: '/admin/forms',
        data: data,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Edit Resale
export const editResale = (data) => {
    return axios({
        method: 'POST',
        url: '/admin/editResale',
        data: data,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// update Cil Status
export const updateCilsStatus = () => {
    return axios.get('/admin/updateCilsStatus')
}

// Upload Leads Excel sheet file
export const uploadLeadDataExcel = (data) => {
    return axios({
        method: 'POST',
        url: '/admin/leads_data_store',
        data: data,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Get Public Data
export const getCilFilterData = () => {
    return axios.get('/admin/getCilFilterData')
}

// Filter Cils With certain input
export const filterCils = (data) => {
    return axios.post('/admin/filterCils', data)
}

// Get Public Data
export const getCilReplies = (id) => {
    return axios.get('/admin/cilReplies/'+id)
}

// Get Cils
export const getLeadsData = (page) => {
    return axios.get('/admin/getLeadsData?page='+page)
}

// Delete Leads Data
export const deleteLeadsData = (data) => {
    return axios.post('/admin/deleteLeadsData', data)
}

// Show Resale Unit Data
export const showResaleUnit = (id) => {
    return axios.get('/admin/resale_units/'+id)
}

// Show Rental Unit Data
export const showRentalUnit = (id) => {
    return axios.get('/admin/rental_units/'+id)
}

// Get Rental Unit Edit Data
export const getResaleEditData = (id) => {
    return axios.get('/admin/resale_units/'+id+'/edit')
}
// Get Agents
export const allAgents = (page) => {
    return axios.get('/admin/agent?page='+page)
}
// Add new Agent
export const AddNewAgent  = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/agent',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}
// get only report
export const sendInfoTorebort  = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/getdailyreports',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}
// get only report By calls
export const sendInfoTorebortByCalls  = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/getdailyreportsbycall',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}
// Get Agent_types
export const allAgent_type = (page) => {
    return axios.get('/admin/agent_types?page='+page)
}
// Get All Meeting
export const requests = (page) => {
    return axios.get('/admin/requests?page='+page)
}
// Get All Events
// export const Events = (page) => {
//     return axios.get('/admin/events?page='+page)
// }
export const Teamrequests = (page) => {
    return axios.get('/admin/requests?page='+page)
}
export const requestsBroadcast = (page) => {
    return axios.get('/admin/requests?page='+page)
}
export const Meeting = (page) => {
    return axios.get('/admin/meetings?page='+page)
}
export const action_logs = (page) => {
    return axios.get('/admin/logs?page='+page)
}
export const Tags = () => {
    return axios.get('/admin/tags')
}
export const facilities = (page) => {
    return axios.get('/admin/facilities?page='+page)
}
export const meating_status = (page) => {
    return axios.get('/admin/meating_status?page='+page)
}
export const out_cats = (page) => {
    return axios.get('/admin/out_cats?page='+page)
}
export const sub_cat = (page) => {
    return axios.get('/admin/out_sub_cats?page='+page)
}

// export const add_Type = (page) => {
//     return axios.get('/admin/CampaignType?page='+page)
// }



export const forms = (page) => {
    return axios.get('/admin/forms?page=')
}
// export const Addform = (data) => {
//     return axios.post('/admin/forms/',data)
// }
export const AddCampaign = () => {
    return axios.get('/admin/campaigns/')
}
export const showform = (id) => {
    return axios.get('/admin/forms/'+id)
}
export const ShowActionLogs = (id) => {
    return axios.get('/admin/logs/'+id)
}
export const ShowCampaign = (id) => {
    return axios.get('/admin/campaigns/'+id)
}
export const showCampaignType = (id) => {
    return axios.get('/admin/campaign_types/'+id)
}
export const callstatus = () => {
    return axios.get('/admin/call_statuses')
}
export const showcallstatus = (id) => {
    return axios.get('/admin/showcallstatus/'+id)
}
export const ShowEvent = (id) => {
    return axios.get('/admin/events/'+id)
}
export const addcallstatus = () => {
    return axios.get('/admin/addcallstatus/')
}
export const call_status = (id) => {
    return axios.get('/admin/call_statuses/'+id)
}

export const getCampaigns = () => {
    return axios.get('/admin/campaigns/')
}
export const campaign_type = () => {
    return axios.get('/admin/campaign_types/')
}
export const AddTag = () => {
    return axios.get('/admin/tags/')
}
export const showsubcat = (id) => {
    return axios.get('/admin/out_sub_cats/'+id)
}
export const ShowFacility = (id) => {
    return axios.get('/admin/facilities/'+id)
}
export const ShowAgentType = (id) => {
    return axios.get('/admin/agent_types/'+id)
}
// Delete a call status
export const deleteThisCallStatus = (id) => {
    return axios.delete('/admin/call_statuses/'+id)
}
export const deleterequest = (id) => {
    return axios.delete('/admin/requests/'+id)
}
export const deleteTeam = (id) => {
    return axios.delete('/admin/requests/'+id)
}
export const deleteBroadcast = (id) => {
    return axios.delete('/admin/requests/'+id)
}
// Delete an agent type
export const deleteAgentType = (id) => {
    return axios.delete('/admin/agent_types/'+id)
}
// Delete a Meeting
export const deleteMeeting = (id) => {
    return axios.delete('/admin/meetings/'+id)
}
export const deletefacility = (id) => {
    return axios.delete('/admin/facilities/'+id)
}
export const deleteSubCat = (id) => {
    return axios.delete('/admin/out_sub_cats/'+id)
}
// Delete a Tag
export const deleteThisTag = (id) => {
    return axios.delete('/admin/tags/'+id)
}
// Delete a outcome category
export const deleteCategory = (id) => {
    return axios.delete('/admin/out_cats/'+id)
}

export const showTag = (id) => {
    return axios.get('/admin/tags/'+id)
}

// add Tag
export const addTag = (data) => {
    return axios.post('/admin/tags', data)
}

// add Type
export const addType = (data) => {
    return axios.post('/admin/campaign_types', data)
}
// add Category
export const addCategory = (data) => {
    return axios.post('/admin/out_cats', data)
}
// add facilities
export const addFacility = (data) => {
    return axios.post('/admin/facilities', data)
}
// add campaign
export const Storecampaign = (data) => {
    return axios.post('/admin/campaigns', data)
}
// add sub_Category
export const addSubCategory = (data) => {
    return axios.post('/admin/out_sub_cats', data)
}
// add sub_Category
export const addAgentType = (data) => {
    return axios.post('/admin/agent_types', data)
}








// Delete a agent
export const deleteAgent = (id) => {
    return axios.delete('/admin/agent/'+id)
}

// Filter Leads
export const filterAgents = (data) => {
    return axios.post('/admin/filterAgents',data)
}

// Get Agent Data
export const getAgent = (id) => {
    return axios.get('/admin/agent/'+id)
}
// Add new Agent
export const updateAgent  = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/updateAgent/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Get Public Data
export const getAgentTypes = () => {
    return axios.get('/admin/getAgentTypes')
}
export const showOutCat = (id) => {
    return axios.get('/admin/out_cats/'+id)
}


// Get Public Data
export const getRoles = () => {
    return axios.get('/admin/getRoles')
}

export const getCustomeRoles = () => {
    return axios.get('/admin/roles/create')
}

// Add new Agent
export const storeAgent  = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/agent',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Get Developer Data
export const getDeveloper = (id) => {
    return axios.get('/admin/developers/'+id)
}

// Get Rental Unit Edit Data
export const getRentalEditData = (id) => {
    return axios.get('/admin/rental_units/'+id+'/edit')
}

// Edit Rental Unit
export const editRental = (data) => {
    return axios({
        method: 'POST',
        url: '/admin/editRental',
        data: data,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Update Developer
export const updateDeveloper  = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/updateDeveloper/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Delete a cil
export const deleteProject = (id) => {
    return axios.delete('/admin/projects/'+id)
}

// Get Project Info
export const getProject = (id) => {
    return axios.get('/admin/projects/'+id)
}

// Get Project Info
export const getProjectPhotos = (id) => {
    return axios.get('/admin/getProjectPhotos/'+id)
}

// Delete Phase
export const deletePhase = (id) => {
    return axios.delete('/admin/phases/'+id)
}

// Get Project Info
export const getFacilities = () => {
    return axios.get('/admin/getFacilities')
}

// Add new Agent
export const storePhase = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/phases',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    })
}

export const deleteCampaign = (id) => {
    return axios.delete('/admin/campaigns/'+id)
}
export const deleteEvent = (id) => {
    return axios.delete('/admin/events/'+id)
}
export const deleteCampaignType = (id) => {
    return axios.delete('/admin/campaign_types/'+id)
}
export const deleteForm = (id) => {
    return axios.delete('/admin/forms/'+id)
}
export const filterTag = (data) => {
    return axios.post('/admin/searchTag',data)
}
export const filterCampaignType = (data) => {
    return axios.post('/admin/searchCampaignType',data)
}
export const filterCategory = (data) => {
    return axios.post('/admin/searchCategory',data)
}
export const filterAgentType = (data) => {
    return axios.post('/admin/searchAgentType',data)
}
export const filterForm = (data) => {
    return axios.post('/admin/searchForm',data)
}
export const filterSubCat = (data) => {
    return axios.post('/admin/searchSubCat',data)
}
export const filterFacilities = (data) => {
    return axios.post('/admin/searchFacilities',data)
}
export const filterMeeting = (data) => {
    return axios.post('/admin/searchMeeting',data)
}
export const filterRequest = (data) => {
    return axios.post('/admin/searchRequest',data)
}
export const filterTeam = (data) => {
    return axios.post('/admin/searchTeam',data)
}
export const filterBroadcast = (data) => {
    return axios.post('/admin/searchBroadcast',data)
}
export const filterEvent = (data) => {
    return axios.post('/admin/searchEvent',data)
}

// Edit agent type
export const updateAgentType = (data,id) => {
    return axios.post('/admin/agent_types/'+id,data)
}
export const updateTags = (data,id) => {
    return axios.post('/admin/tags/'+id,data)
}
export const updateRequest = (data,id) => {
    return axios.post('/admin/requests/'+id,data)
}
export const updateFacility = (data,id) => {
    return axios.post('/admin/facilities/'+id,data)
}
export const updateCategory = (data,id) => {
    return axios.post('/admin/out_cats/'+id,data)
}
export const updateCampaignType = (data,id) => {
    return axios.post('/admin/campaign_types/'+id,data)
}
export const updateForm = (data,id) => {
    return axios.post('/admin/forms/'+id,data)
}
export const updateSubCategory = (data,id) => {
    return axios.post('/admin/out_sub_cats/'+id,data)
}


updateSubCategory














// edit task
export const UpdateThisTask  = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/tasks/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Show Lead Source Data
export const showLeadSource = (id) => {
    return axios.get('/admin/lead_sources/'+id)
}
// Show Lead Source Data
export const LeadSources = () => {
    return axios.get('/admin/lead_sources')
}

// Delete a Lead Source
export const deleteThisLeadSource = (id) => {
    return axios.delete('/admin/lead_sources/'+id)
}

// add Lead Source
export const addLeadSource = (data) => {
    return axios.post('/admin/lead_sources', data)
}


// begin settings
        export const getdatasetting = () => {
            return axios.get('/admin/settings')
        }
        // return setting phone
        export const getSettingphone = () => {
            return axios.get('/admin/hub_phones')
        }
        // return setting icons
        export const getsettingsocial = () => {
            return axios.get('/admin/hub_icons')
        }
        // setting only geting data page
        export const geticondata = () => {
            return axios.get('/admin/icons')
        }
        export const getGroups = () => {
            return axios.get('/admin/groups')
        }
        // get banners of projects
        export const getprojectsBanner = () => {
            return axios.get('/admin/BannerOfprojects')
        }
        // get group details
        export const GroupDetils = (id) => {
            return axios.get('/admin/groups/'+id)
        }
        // delete groups
        export const deleteGroupById = (id) => {
            return axios.delete('/admin/groups/'+id)
        }
        // location
            // get all location
            export const getlocations = () => {
                return axios.get('/admin/location')
            }
            // location detils
            export const getlocationdetils = (id) => {
                return axios.get('/admin/location/'+id)
            }    
        // end location
        export const getunittype = () => {
            return axios.get('/admin/unit_types')
        }
        // All rouls
        export const getrouls = () => {
            return axios.get('/admin/roles')
        }
        export const getRolesById = (id) => {
            return axios.get('/admin/roles/'+id)
        }

        export const getAllRolesArray = () => {
            return axios.get('/admin/roles/create')
        }
        export const deleteRole = (id) => {
            return axios.delete('/admin/roles/'+id)
        }
        // get unit type by id
        export const getunitbyid = (id) => {
            return axios.get('/admin/unit_types/'+id)
        }
        // delete unit
        export const deleteUnit = (id) => {
            return axios.get('/admin/delete_unit_types/'+id)
        }
        // delete icons
        export const deleteiconresponse = (id) => {
            return axios.get('/admin/iconsdelete/'+id)
        }
        // // events
        export const getAllEvents = () => {
            return axios.get('/admin/events')
        }
        export const singleEventData = (id) => {
            return axios.get('/admin/events/'+id)
        }
        export const deleteEventByid = (id) => {
            return axios.delete('/admin/events/'+id)
        }
        // update setting
        export const updateSingleSettings = (bodyFormData) => {
            return axios({
                method: 'POST',
                url: '/admin/settings',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // update role by id
        export const updateRoleByID = (bodyFormData,id) => {
            return axios({
                method: 'POST',
                url: '/admin/roles/'+id,
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // add new location
        export const addnewlocation = (bodyFormData) => {
            return axios({
                method: 'POST',
                url: '/admin/location',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        export const StoreNewEvent = (bodyFormData) => {
            return axios({
                method: 'POST',
                url: '/admin/events',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // save new group
        export const storegroup = (bodyFormData) => {
            return axios({
                method: 'POST',
                url: '/admin/groups',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // edit group by id
        export const editGrouByid = (bodyFormData,id) => {
            return axios({
                method: 'POST',
                url: '/admin/groups/'+id,
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        export const updateEventByid = (bodyFormData) => {
            return axios({
                method: 'POST',
                url: '/admin/updateEvents',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // new unit type
        export const NewAddUnit = (bodyFormData) => {
            return axios({
                method: 'POST',
                url: '/admin/unit_types',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // end new type
        // settin only post data
        export const saveIcon = (bodyFormData) => {
            return axios({
                method: 'POST',
                url: '/admin/icons',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        //  new add role
        export const NewAddRole = (bodyFormData) => {
            return axios({
                method: 'POST',
                url: '/admin/roles',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        export const updateUnit = (bodyFormData) => {
            return axios({
                method: 'post',
                url: '/admin/UpdateVue_unit_types/',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // sort web
        export const Newsortweb = (bodyFormData) => {
            return axios({
                method: 'post',
                url: '/admin/save_sorted/',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // sort resale
        export const newSortResale = (bodyFormData) => {
            return axios({
                method: 'post',
                url: '/admin/save_resale_stored/',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
        // sort rentale
        export const newrentalsort = (bodyFormData) => {
            return axios({
                method: 'post',
                url: '/admin/save_rental_stored/',
                data: bodyFormData,
                config: { headers: { 'Content-Type': 'multipart/form-data' } }
            });
        }
// end settings 


// Filter Lead Source
export const filterLeadSource = (data) => {
    return axios.post('/admin/searchLeadSources',data)
}

// Delete a Task
export const deleteThisTask = (id) => {
    return axios.delete('/admin/tasks/'+id)
}

// Delete income
export const deleteThisIncome = (id) => {
    return axios.delete('/admin/incomes/'+id)
}

// Delete outcome
export const deleteThisOutcome = (id) => {
    return axios.delete('/admin/outcomes/'+id)
}




// Show task
export const showtask = (id) => {
    return axios.get('/admin/tasks/'+id)
}

// Filter tasks
export const filterTasks = (data) => {
    return axios.post('/admin/searchTasks',data)
}

// add Task
export const addTask = (data) => {
    return axios.post('/admin/tasks', data)
}

// Add new developer
export const addDeveloper  = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/developers',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Show Lead Source Data
export const getTaskData = () => {
    return axios.get('/admin/tasks')
}
// get single task
export const getspecdata = (id) => {
    return axios.get('/admin/tasks/'+id)
}
// Delete a project
export const rejectProject = (id) => {
    return axios.get('/admin/deletepush/'+id)
}

// Show Projects Data
export const getProjects = () => {
    return axios.get('/admin/projectRequests')
}

// get project sorted
export const getprojectssort = () => {
    return axios.get('/admin/sort_projects')
}
// get resale  sorted
export const getResaleSorts = () => {
    return axios.get('/admin/sort_resale')
}
// get rentale sorted
export const getrentalesort = () => {
    return axios.get('/admin/sort_rental')
}


// Filter Project Request
export const filterPusher = (data) => {
    return axios.post('/admin/searchProjectRequest',data)
}

// get task inputs to add
export const getTaskInputs = () => {
    return axios.get('/admin/getTaskInputs')
}

// Show titles 
export const getTitleData = () => {
    return axios.get('/admin/titles')
}


// Show title
export const titleShow = (id) => {
    return axios.get('/admin/titles/'+id)
}

// Delete a title
export const deleteThisTitle = (id) => {
    return axios.delete('/admin/titles/'+id)
}

// Filter Title
export const filterTitles = (data) => {
    return axios.post('/admin/searchTitles',data)
}

// add Title
export const addTitle = (data) => {
    return axios.post('/admin/titles', data)
}

// Filter Call Status
export const filterCallStatus = (data) => {
    return axios.post('/admin/searchCallStatus',data)
}

// add Call Status
export const addCallStatus = (data) => {
    return axios.post('/admin/call_statuses', data)
}

// Show meeting status Data
export const getMeetingStatus = () => {
    return axios.get('/admin/meeting_statuses')
}

// Show Meeting Status
export const showMeetingStatus = (id) => {
    return axios.get('/admin/meeting_statuses/'+id)
}
// Show Meeting 
export const ShowMeeting = (id) => {
    return axios.get('/admin/meetings/'+id)
}

// Delete a Meeting Status
export const deleteThisMeetingStatus = (id) => {
    return axios.delete('/admin/meeting_statuses/'+id)
}

// Filter Call Status
export const filterMeetingStatus = (data) => {
    return axios.post('/admin/searchMeetingStatus',data)
}

// add Meeting Status
export const addMeetingStatus = (data) => {
    return axios.post('/admin/meeting_statuses', data)
}

// Show target Data
export const allTargets = () => {
    return axios.get('/admin/targets')
}


// Show Target
export const showTarget = (id) => {
    return axios.get('/admin/targets/'+id)
}

// Delete a target
export const deleteThisTarget = (id) => {
    return axios.delete('/admin/targets/'+id)
}


// Filter targets
export const filterTarget = (data) => {
    return axios.post('/admin/searchTargets',data)
}

// add Target
export const addTarget = (data) => {
    return axios.post('/admin/targets', data)
}
export const AddMeRequest = (data) => {
    return axios.post('/admin/requests', data)
}

// get target inputs to add
export const getTargetInputs = () => {
    return axios.get('/admin/getTargetInputs')
}
export const getMeRequestInputs = () => {
    return axios.get('/admin/getMeRequestInputs')
}
// get forms to add
export const getFormsInputs = () => {
    return axios.get('/admin/getFormsInputs')
}
// get campaigns to add
export const getCampaignInputs = () => {
    return axios.get('/admin/getCampaignInputs')
}

// Show job Categories Data
export const AllJobCategories = () => {
    return axios.get('/admin/job_categories')
}

// Delete a job Category
export const deleteThisJobCategory = (id) => {
    return axios.delete('/admin/job_categories/'+id)
}

// Filter Job Category
export const filterJobCategory = (data) => {
    return axios.post('/admin/searchJobCategory',data)
}

// add Job Category
export const addJobCategory = (data) => {
    return axios.post('/admin/job_categories', data)
}

// Show job title Data
export const allJobTitles = () => {
    return axios.get('/admin/job_titles')
}

// Filter job title 
export const filterJobTitle = (data) => {
    return axios.post('/admin/searchJobTitles',data)
}

// Delete a job title
export const deleteThisJobTitle = (id) => {
    return axios.delete('/admin/job_titles/'+id)
}

// get job title inputs to add
export const getJobTitleInputs = () => {
    return axios.get('/admin/getJobTitleInputs')
}

// add Job Category
export const addJobTitle = (data) => {
    return axios.post('/admin/job_titles', data)
}

// Show vacancies Data
export const allVacancies = () => {
    return axios.get('/admin/vacancies')
}


// Show vacancy
export const showVacancy = (id) => {
    return axios.get('/admin/vacancies/'+id)
}

// Delete a vacancy
export const deleteThisVacancy = (id) => {
    return axios.delete('/admin/vacancies/'+id)
}

// Filter vacancy 
export const filterVacancy = (data) => {
    return axios.post('/admin/searchVacancies',data)
}

// get Vacancy inputs to add
export const getVacancyInputs = () => {
    return axios.get('/admin/getVacancyInputs')
}

// add vacancy
export const addVacancy = (data) => {
    return axios.post('/admin/vacancies', data)
}

// Show employees Data
export const allEmployees = (page) => {
    return axios.get('/admin/employees?page='+page)
}
// get all employees Data
export const getAllEmployees = () => {
    return axios.get('/admin/Allemployees')
}
export const getDays = () => {
    return axios.get('/admin/getDays')
}

// show an employee
export const showThisEmployee = (id) => {
    return axios.get('/admin/employees/'+id)
}

// Delete a employee
export const deleteThisEmployee = (id) => {
    return axios.delete('/admin/employees/'+id)
}

// Filter employees 
export const updateAllDays = (bodyFormData) => {
    return axios.post('/admin/updateDays',bodyFormData)
}

// Filter employees 
export const filterEmployees = (data) => {
    return axios.post('/admin/searchEmployees',data)
}

// update job category
export const updateJobCategory = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/job_categories/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Get Phase Info
export const getPhase = (id) => {
    return axios.get('/admin/phases/'+id)
}

// Delete Property
export const deleteProperty = (id) => {
    return axios.delete('/admin/properties/'+id)
}

// Get Phase Info
export const getProperty = (id) => {
    return axios.get('/admin/properties/'+id)
}

// Add new Agent
export const updateProperty  = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/properties/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    })
}
// Show job category
export const getJobCategories = (id) => {
    return axios.get('/admin/job_categories/'+id)
}

// Show job title
export const getJobTitles = (id) => {
    return axios.get('/admin/job_titles/'+id)
}

// update job title
export const updateJobTitle = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/job_titles/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// update lead source
export const UpdateThisLeadSource = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/lead_sources/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Store New Property
export const storeProperty = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/properties',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    })
}
// update title
export const UpdateThisTitle = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/titles/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}
// update seo
export const updatefirstseo = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/updateSeo/',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Get Phases
export const getPhases = () => {
    return axios.get('/admin/getPhases')
}

// Get Phase Facilities
export const getPhaseFacilities = (data) => {
    return axios.post('/admin/getPhaseFacilities',data)
}

// Add new Agent
export const updatePhase  = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/phases/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    })
}
// update target
export const UpdateThisTarget = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/targets/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Cofirm tasks
export const confirmThisTask = (id) => {
    return axios.get('/admin/confirm_task/'+id)
}

// Cofirm collections
export const confirmCollection = (id) => {
    return axios.get('/admin/confirm_collection/'+id)
}

// Cofirm dues
export const confirmDues = (id) => {
    return axios.get('/admin/confirm_dues/'+id)
}

// reject Push
export const rejectThisPush = (id) => {
    return axios.get('/admin/deletepush/'+id)
}

// reject Request types
export const getRequestType = (page) => {
    return axios.get('/admin/getRequestType?page='+page)
}

// reject Request status
export const getRequestStatus = () => {
    return axios.get('/admin/getRequestStatus')
}

// add employee
export const addEmployee = (data) => {
    // console.log('data before sending',data)
    return axios({
        method: 'POST',
        url: '/admin/employees/',
        data: data,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// get job title 
export const getAllJobTitles = () => {
    return axios.get('/admin/getAllJobTitles')
}

// get roles
export const getAllRoles = () => {
    return axios.get('/admin/getAllRoles')
}

// Show employee
export const showEmployee = (id) => {
    return axios.get('/admin/employees/'+id)
}

// Show MeRequest
export const ShowMeRequest = (id) => {
    return axios.get('/admin/requests/'+id)
}


// update employee
export const updateThisEmployee = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/employees/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// update Meeting status
export const updateMeetingstatus = (data,id) => {
    return axios.post('/admin/meeting_statuses/'+id,data)
}

// update vacancy
export const editVacancy = (data,id) => {
    return axios.post('/admin/vacancies/'+id,data)
}

// add vacancy type
export const StoreNewVacType = (data) => {
    return axios.post('/admin/AddVacancyType/',data)
}
// delete vacancy type
export const DeleteVacType = (id) => {
    return axios.get('/admin/deleteVacancyType/'+id)
}

// get singe vacancy type
export const getVacTypeData = (id) => {
    return axios.get('/admin/editVacancyType/'+id)
}

// get UnderReview app
export const getUnderReview = () => {
    return axios.get('/admin/getUnderReview')
}

// get ShortListed
export const getShortListed = () => {
    return axios.get('/admin/getShortListed')
}

// Get Project Info
export const getEditedProject = (id) => {
    return axios.get('/admin/projects/'+id+'/edit')
}

// Get All Tags For multi select
export const getAllTags = () => {
    return axios.get('/admin/getAllTags')
}
// refresh site map
export const refresh = () => {
    return axios.get('/admin/sitemap/')
}
// get seo
export const getSeo = () => {
    return axios.get('/admin/seo/')
}
// get keywords
// export const getAllKeyWords = () => {
//     return axios.get('/admin/getAllKeyWords/')
// }

// get arabic words
export const get_ar_words = () => {
    return axios.get('/admin/ar_Keywords/')
}

// get english words
export const get_en_words = () => {
    return axios.get('/admin/en_Keywords/')
}



// change maker from website in route folder
export const ChangeWebMarker = () => {
    return axios.get('/en/change_marker/')
}

export const updateProject = (bodyFormData,id) => {
    return axios({
        method: 'POST',
        url: '/admin/projects/'+id,
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

export const storeProject = (bodyFormData) => {
    return axios({
        method: 'POST',
        url: '/admin/projects',
        data: bodyFormData,
        config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}

// Get All Locations for select
export const getAllLocations = () => {
    return axios.get('/admin/getAllLocations')
}

// update vacancy
export const filterProjects = (data) => {
    return axios.post('/admin/filterProjects',data)
}

// Get Rotational Leads
export const getRotationalLeads = (page) => {
    return axios.get('/admin/getRotationalLeads?page='+page)
}

// Show all applications
export const getAllApplications = () => {
    return axios.get('/admin/applications')
}

// Show application
export const showApplication = (id) => {
    return axios.get('/admin/applications/'+id)
}

// update Application
export const updateThisApplication = (data,id) => {
    return axios.post('/admin/applications/'+id,data)
}

//delete application
export const deleteThisApplication = (id) => {
    return axios.delete('/admin/applications/'+id)
}

// Filter apps
export const filterApps = (data) => {
    return axios.post('/admin/searchApps',data)
}

// // Filter Applications With certain input
// export const filterSpecificDepartment = (data) => {
//     return axios.post('/admin/filterSpecificDepartment', data)
// }
// update Meeting 
export const updateMeeting = (data,id) => {
    return axios.post('/admin/meetings/'+id,data)
}
export const updateCampiagn = (data,id) => {
    return axios.post('/admin/campaigns/'+id,data)
}
export const filterCampaign = (data) => {
    return axios.post('/admin/searchCampaign',data)
}

// Show proposal data
export const showProposal = (id) => {
    return axios.get('/admin/proposals/'+id)
}

// Show all salaries Data
export const getAllSalaries = () => {
    return axios.get('/admin/salaries')
}

// filter salaries
export const filterSalaries = (data) => {
    return axios.post('/admin/searchSalary',data)
}

// Show all finances Data
export const all_finances = () => {
    return axios.get('/admin/finances')
}

// Show all collection Data
export const all_Collections = () => {
    return axios.get('/admin/all_Collections')
}

// Show all collected Data
export const all_Collected = () => {
    return axios.get('/admin/all_Collected')
}


// Show all dues Data
export const all_Dues = () => {
    return axios.get('/admin/all_Dues')
}

// Show all paid Data
export const all_Dues_Paid = () => {
    return axios.get('/admin/all_Dues_Paid')
}



// get all Currencies for finances
export const getCurrency = () => {
    return axios.get('/admin/getCurrency')
}

// get all banks for finances
export const getBanks = () => {
    return axios.get('/admin/getBanks')
}

// add new income
export const addNewIncome = (data) => {
    return axios.post('/admin/add_income', data)
}

// add new outcome
export const addNewOutcome = (data) => {
    return axios.post('/admin/add_outcome', data)
}

// add new outcome
// export const addNewCollection = (data) => {
//     return axios.post('/admin/collection', data)
// }

// get all out categories for finances
export const getOutCats = () => {
    return axios.get('/admin/getOutCats')
}

// filter apps
export const filterApplications = (data) => {
    return axios.post('/admin/filterApplications', data)
}

// filter incomes finances
export const filterIncomeFinances = (data) => {
    return axios.post('/admin/filterIncomeFinances', data)
}

// filter outcome finances
export const filterOutcomeFinances = (data) => {
    return axios.post('/admin/filterOutcomeFinances', data)
}


// get meetings inputs to add
export const getMeetingsInputs = () => {
    return axios.get('/admin/getMeetingsInputs')
}

// Delete a Push
export const deleteThisPush = (id) => {
    return axios.delete('/admin/projectRequests/'+id)
}

// add Meeting
export const AddMeeting = (data) => {
    return axios.post('/admin/meetings', data)
}

// get lead contacts
export const getcontactLead = (id) => {
    return axios.get('/admin/getcontactLead/'+id)
}

// accept pusher
export const acceptPushThisPusher = (id) => {
    return axios.get('/admin/accept/'+id)
}

// get job title based on department
export const getJobTitlesDep = (id) => {
    return axios.get('/admin/getJobTitlesDep/'+id)
}

// get vacancies based on job title
export const getVacancyJob = (id) => {
    return axios.get('/admin/getVacancyJob/'+id)
}

// Add New application
export const addApplication = (bodyFormData) => {
    return axios({
        method: 'post',
        url: '/admin/applications',
        data: bodyFormData,
        // config: { headers: { 'Content-Type': 'multipart/form-data' } }
    });
}
// Show all unit_types
export const getUnitTypeSelection = (data) => {
    return axios.post('/admin/getUnitTypeSelection',data)
}
export const getRequestSuggestions = (data) => {
    return axios.get('/admin/getRequestSuggestions',data)
}
export const filterSuggestions = (data) => {
    return axios.post('/admin/searchSuggestions',data)
}

export const getAllProjects = () => {
    return axios.get('/admin/getAllProjects')
}
export const getAllevents = () => {
    return axios.get('/admin/getAllevents')
}
export const getAllcampaigns = () => {
    return axios.get('/admin/getAllcampaigns')
}
export const getAllProposal = () => {
    return axios.get('/admin/proposals')
}
