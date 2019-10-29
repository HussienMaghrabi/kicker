<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// Route::get('/test', 'LeadController@test');

// dd(session()->get('lang'));
route::get('Submitpage','HomeController@submitview');
route::post('sendsubrequest','MassageController@sendsubrequest');
Route::get("/lang/{lang}","HomeController@switch");
Route::get('/temp-Home', 'HomeController@tempHome');

Route::get('privacypolicy','HomeController@home');
Route::get('dd_leads',function(){
    foreach(App\Lead::get() as $lead){
        if(strtotime($lead->created_at) < 1525478399){
            $lead->delete();
        }
    }
});
include 'website.php';
// echo adminPath() ;
Route::get(adminPath() .'/yourCalendarEvents','EventController@calendarEvents');
Route::get(adminPath() .'/yourCalendarEventsNotf', 'EventController@calendarEventsNotf');

Route::post(adminPath() . '/login_post', 'HomeController@login_post');
Route::get(adminPath() . '/login', [ 'as' => 'login', 'uses' => 'HomeController@login']);
// Route::get('admin/yourCalendarEvents', 'EventController@calendarEvents');
// Route::get('/login', 'HomeController@login');

include 'dashboard-api.php';
Route::get('socket',function (){
    return view('socket');
});

Route::group(['prefix' => '{l}/'.adminPath(), 'middleware' => ['lang', 'admin']], function () {
    Route::get('getPublicData','LeadController@getPublicData');
    Route::get('/', 'HomeController@getMasterView');
    Route::get('logout', 'HomeController@logout');
});

Route::get('/admin', 'HomeController@getMasterView');


Route::group(['prefix' => adminPath().'/vue', 'middleware' => ['admin']], function () {
    Route::get('/{any}', 'HomeController@getMasterView')->where('any', '.*');
});

Route::group(['prefix' => adminPath(), 'middleware' => ['lang', 'admin']], function () {
    
    Route::post('testagax','AjaxController@testAgax');
    Route::get('getAllProjects','ProjectController@getAllProjects');
    Route::get('getAllevents','EventController@getAllevents');
    Route::get('getAllcampaigns','CampaignController@getAllcampaigns');

    //filter apps
    Route::post('filterApplications', 'ApplicationController@filterApplications');
    Route::post('filterIncomeFinances', 'HomeController@filterIncomeFinances');
    Route::post('filterOutcomeFinances', 'HomeController@filterOutcomeFinances');
    
    
    
    Route::get('getRequestSuggestions','RequestController@getRequestSuggestions');
    Route::post('getUnitTypeSelection','UnitTypeController@getUnitTypeSelection');

    Route::get('getRotationalLeads','LeadController@getRotationalLeads');
    Route::post('filterProjects','ProjectController@filterProjects');
    Route::get('getAllLocations','LocationController@getAllLocations');
    Route::get('getAllTags','TagController@getAllTags');
    // //filter apps
    // Route::post('filterApplications', 'ApplicationController@filterApplications');


    Route::post('getPhaseFacilities','PhaseController@getPhaseFacilities');
    Route::get('getPhases','PhaseController@getPhases');

    Route::get('getFacilities','FacilityController@getFacilities');
    Route::get('getProjectPhotos/{id}','ProjectController@getProjectPhotos');
    Route::post('searchEmployees','EmployeeController@searchEmployees');        

    
    Route::post('searchVacancies','VacancyController@searchVacancies');        
    Route::post('searchApps','ApplicationController@searchApps');        

    Route::post('searchJobTitles','JobTitleController@searchJobTitles');        
    Route::post('searchSalary','SalariesController@searchSalary');        
    
    Route::post('searchJobCategory','JobCategoryController@searchJobCategory');        

    Route::post('searchCallStatus','CallStatusController@searchCallStatus');        
    Route::post('searchMeetingStatus','MeetingStatusController@searchMeetingStatus');        
    
    Route::post('searchTargets','TargetController@searchTargets');        
    Route::get('getTargetInputs','TargetController@getTargetInputs');
    Route::get('getMeRequestInputs','RequestController@getMeRequestInputs');

    Route::get('getFormsInputs','FormController@getFormsInputs');
    Route::get('getCampaignInputs','CampaignController@getCampaignInputs');

    Route::get('getJobTitleInputs','JobTitleController@getJobTitleInputs');
    Route::get('getAllJobTitles','EmployeeController@getAllJobTitles');
    Route::get('getJobTitlesDep/{id}','ApplicationController@getJobTitlesDep');
    Route::get('getleadContact/{id}','ProposedCompanyController@getleadContact');
    Route::get('getVacancyJob/{id}','ApplicationController@getVacancyJob');
    
    Route::get('getAllRolesNew','RoleController@getAllRoles');
    
    Route::get('getTaskInputs','TaskController@getTaskInputs');
    Route::get('getMeetingsInputs','MeetingController@getMeetingsInputs');
    
    
    Route::post('searchTitles','TitleController@searchTitles');  
    Route::get('getVacancyInputs','VacancyController@getVacancyInputs');        

    
    
    Route::resource('projectRequests', 'ProjectRequestController');
    Route::post('searchProjectRequest','ProjectRequestController@searchProjectRequest');        

    Route::post('searchTasks','TaskController@searchTasks');        

    Route::post('searchLeadSources','LeadSourceController@searchLeadSources');        

    Route::post('updateDeveloper/{developer}','DeveloperController@updateDeveloper');        

    Route::get('getRoles','AgentController@getRoles');
    Route::get('getAgentTypes','AgentController@getAgentTypes');

    Route::post('updateAgent/{agent}','AgentController@updateAgent');        
    Route::post('filterAgents','AgentController@filterAgents');        

    Route::get('getAgentLeads','AjaxController@getAgentLeads');
    Route::get('getDays','DaysController@index');
    Route::post('updateDays','DaysController@update');

    Route::post('deleteLeadsData','LeadDataController@deleteLeadsData');        
    Route::get('getLeadsData','LeadDataController@index');
    Route::get('lead_data', 'LeadDataController@get_lead_data');    
    Route::get('cilReplies/{id}','CilController@getCilReplies');

    Route::post('filterCils','CilController@filterCils');    
    Route::post('filterSpecificDepartment','ApplicationController@filterSpecificDepartment');    
    Route::get('getCilFilterData','CilController@getCilFilterData');
    Route::post('leads_data_store','LeadDataController@leads_data_store'); 
    Route::get('GetAllRoleDetails','RoleDetailsController@index');
    Route::get('EditRoleDetails/{id}','RoleDetailsController@edit');
    Route::post('updateSigleRole/{id}','RoleDetailsController@update');
    Route::post('saveNewRoleDetails','RoleDetailsController@store');
    Route::get('DeleteRoleDetails/{id}','RoleDetailsController@destroy');
    Route::get('GetApiAllRoleDetails','RoleDetailsController@GetAllrolesDetailsApi');    
    Route::post('lead_data_xls','LeadDataController@lead_data_xls');

    Route::get('lead_data_xls', 'LeadDataController@leads_data_upload'); 
    
    Route::post('editRental','RentalUnitController@editRental');
    Route::post('editResale','ResaleUnitController@editResale');

    Route::post('resaleXls','ResaleUnitController@resaleXls');
    Route::get('uploadResale', 'ResaleUnitController@getUploadResalePage');    
    Route::post('upload_resale_excel', 'ResaleUnitController@uploadResaleExcel');

    Route::get('updateCilsStatus','CilController@updateCilsStatus');
    Route::get('getAgentLeads','AjaxController@getAgentLeads');
    
    Route::get('getCilEmails','CilController@getCilEmails');
    // getCilAcceptedKeywords
    
    Route::post('saveCilSettings', 'CilController@saveCilSettings');
    Route::post('deleteSelectedLeads', 'LeadController@deleteSelectedLeads');
    Route::post('getUserEmails','AgentController@getUserEmails');
    Route::get('getCilSettings','CilController@getCilSettings');
    Route::post('searchForLeadPhone', 'LeadController@searchForLeadPhone');
    Route::get('getDeveloperInfo','ApiAgentController@getDeveloperInfo');
    Route::get('getDeveloperInfoWithPaginate','ApiAgentController@getDeveloperInfoWithPaginate');
    Route::get('getProjectsInfoWithPaginate','ProjectController@getProjectsInfoWithPaginate');

    Route::post('cils/export_xsl', 'CilController@export_xsl');
    Route::get('getCilData/{id}', 'CilController@getCilData');
    Route::post('updateCilData', 'CilController@updateCilData');
    Route::post('downloadCilExcel', 'CilController@export_xsl');    
    

    Route::get('updateWebsiteResaleShow/{id}', 'ResaleUnitController@updateWebsiteResaleShow');
    Route::post('searchForDuplicate','LeadController@searchForDuplicate');
    Route::get('replaceLeadWithDuplicated', 'LeadController@replaceLeadWithDuplicated');
    Route::get('replace_duplicate_lead/{id}', 'LeadController@replaceLeadWithDuplicated');
    Route::post('replace_duplicate_leads', 'LeadController@replaceDuplicateLeads');
    route::post('/sendInrest','LeadController@sendintrest');


    Route::post('editLeadsCalls','LeadController@editLeadsCalls');
    Route::get('GetAllStatusOfCalls', 'CallStatusController@returnForApi');
    Route::post('GetLeadMassege','LeadController@gitleadmassege');
    Route::post('GetleadHistory','LeadController@gitleadHistory');
    Route::post('GetLeadContracts','LeadController@getleadcontracts');
    Route::post('FromrequestPage','LeadController@FromrequestPage');
    Route::post('AddEmployeeRequest','EmployeeRequestController@store');
    Route::get('empRequestVacation/{id}','EmployeeRequestController@getAllForEmployee');
    Route::post('GetLeadContacts','LeadController@getleadcontacts');
    Route::post('Contactlead','LeadController@addleadcontact');
    Route::post('GetleadInterest','LeadController@getleadinterest');
    Route::post('GetFavoriteLead','LeadController@GetFavoriteLead');
    Route::post('GetleadSwitchHistory','LeadController@GetleadSwitchHistory');
    Route::post('Getcilslead','LeadController@Getcilslead');
    Route::post('GetleadInfo','LeadController@GetleadInfo');
    
    
    Route::get('getonesignal','onesignalController@index');
    Route::post('StoreAttendanceByEx','employee_attendance_controller@StoreByEx');
    Route::get('getProposedCompanies','ProposedCompanyController@getProposedCompanies');
    Route::get('getNewLeads','ProposedCompanyController@getNewLeads');
    
    Route::post('getonesignal','onesignalController@store');
    
    
    
    Route::resource('companyLeads', 'LeadsController');
    Route::post('addNewLead','LeadsController@addNewLead');
    Route::post('edit_comapany_data','LeadsController@edit_comapany_data');
    Route::post('edit_address','LeadsController@edit_address');
    
    Route::resource('archive', 'ArchiveController');
    Route::resource('contractSections', 'ContractSectionsController');
    Route::resource('contracts', 'ContractController');
    Route::get('allarchive', 'ArchiveController@allArchive');
    Route::post('archive_data','ArchiveController@archive_data');
    
    Route::get('reformLeadPhones','LeadController@reformLeadPhones');

    Route::post('image_post','ProjectController@image_post');
    Route::get('subscribe',function()
    {
         return view('subscripe');
    });
    Route::post('facebook_post','SettingController@facebook');
    Route::get('deletepush/{id}','ReceivedprojectController@deletepush');

    Route::get('sort_projects','ProjectController@sort_project');
    Route::post('save_sorted','ProjectController@save_sorted');

    Route::get('sort_resale','ResaleUnitController@sort_resale');
    Route::post('save_resale_stored','ResaleUnitController@save_sorted');

    Route::get('sort_rental','RentalUnitController@sort_rental');
    Route::post('save_rental_stored','RentalUnitController@save_sorted');

    // Route::post('save_sorted_mob','ProjectController@save_sorted_mob');
    Route::get('get_password',function(){
        return bcrypt('agent0123');
    });

    //if (checkRole('export_excel') or @auth()->user()->type == 'admin') {
        Route::view('xlsrequest', 'admin.requests.xlsrequest');
    //} else {
    //    Route::get('xlsrequest', function () {
    //        session()->flash('error', __('admin.you_dont_have_permission'));
    //        return back();
    //    });
    //}
    
    Route::view('notifications','admin.notifications');
    Route::get('notificationStatus/{id}','AgentController3@notificationsChangeStatus');
    Route::get('ChangeAllNotification/','AgentController3@ChangeAllNotification');
    Route::get('clearNumCil/','AgentController3@clearNumCil');
    Route::post('guide','HomeController@guide');
    Route::post('xls','HomeController@xls');
    Route::post('xls1','HomeController@xls1');
    Route::post('send_event', 'HomeController@send_event');
    Route::post('send_note/{id}', 'HomeController@send_note');
    Route::get('events_request', 'HomeController@events');
    Route::get('show_event/{id}', 'HomeController@show_event');
    Route::get('get_member/{id}', 'HomeController@get_member');
    Route::resource('lead_sources', 'LeadSourceController');
    Route::resource('leads', 'LeadController');
    Route::get('getVacancyType', 'VacancyTypeController@index');
    Route::post('AddVacancyType', 'VacancyTypeController@store');
    Route::get('editVacancyType/{id}', 'VacancyTypeController@edit');
    Route::post('updateVacancy/{id}', 'VacancyTypeController@update');
    Route::get('deleteVacancyType/{id}', 'VacancyTypeController@distroy');
    Route::get('getVacanceType', 'VacancyTypeController@getAll');
    Route::get('getRequestType', 'RequestTypeController@AllTypes');
    Route::get('getAPIRequestTypes', 'RequestTypeController@AllTypesAPI');
    Route::post('AddRequestType', 'RequestTypeController@store');
    Route::get('editrequesttype/{id}', 'RequestTypeController@edit');
    Route::post('updaterequesttype/{id}', 'RequestTypeController@update');
    Route::get('DeleteRequestType/{id}', 'RequestTypeController@destroy');
    Route::get('getRequestStatus', 'RequestStatusController@AllStatus');
    Route::get('EmployeeContacts/{id}', 'EmployeeController@getAllContacts');
    Route::post('AddRequestStatus', 'RequestStatusController@store');
    Route::get('editRequestStatus/{id}', 'RequestStatusController@edit');
    Route::post('updaterequeststatus/{id}', 'RequestStatusController@update');
    Route::post('DeleterequestStatusType/{id}', 'RequestStatusController@destroy');
    Route::get('getAllStatusOfRequest', 'RequestStatusController@AllForApi');
    Route::get('popup', 'popupController@index');
    Route::post('popup/{id}', 'popupController@update');
    Route::post('GetLeadMassege','LeadController@gitleadmassege');
    Route::post('GetleadHistory','LeadController@gitleadHistory');
    Route::post('GetLeadContracts','LeadController@getleadcontracts');
    Route::post('GetLeadContacts','LeadController@getleadcontacts');
    Route::post('Contactlead','LeadController@addleadcontact');
    Route::post('GetleadInterest','LeadController@getleadinterest');
    Route::post('GetFavoriteLead','LeadController@GetFavoriteLead');
    Route::post('GetleadSwitchHistory','LeadController@GetleadSwitchHistory');
    Route::post('Getcilslead','LeadController@Getcilslead');
    Route::post('GetleadInfo','LeadController@GetleadInfo');
    // Delete Leads after Applying certain filters on it.
    Route::get('filterLeadsToDelete','LeadController@filterLeadsToDelete');
    Route::post('deleteFilteredLeads','LeadController@deleteFilteredLeads');

    Route::post('upload_excel', 'LeadController@upload_excel');
    Route::get('project_featured/{id}', 'ProjectController@project_featured');
    Route::get('delete-lead/{id}', 'LeadController@destroy');

    Route::get('delete-duplicate-lead/{id}', 'LeadController@deleteDuplicateLead');
    Route::post('delete-duplicate-leads', 'LeadController@deleteDuplicateLeads');
    
    Route::post('delete-lead-summaries', 'LeadController@deleteLeadsummaries');

    Route::get('delete-resale/{id}', 'ResaleUnitController@destroy');
    Route::get('delete-rental/{id}', 'RentalUnitController@destroy');
    Route::get('restore-lead/{id}', 'LeadController@restore');

    Route::get('delete-archive-lead/{id}', 'ArchiveController@destroy');
    
    // Route::get('duplicated_leads','LeadController@duplicated_leads');
    Route::get('lead_summaries','LeadController@lead_summaries');
    

    // Delete Leads that have no actions or have unanswered call or uninterested
    Route::get('deleteNoActionLeads','LeadController@deleteNoActionLeads');
    Route::get('project_un_featured/{id}', 'ProjectController@project_un_featured');
    Route::resource('agent_types', 'AgentTypeController');
    //Route::post('login_post','HomeController@login_post');
    //Route::get('login', 'HomeController@login');
    Route::resource('agent', 'AgentController');
    Route::resource('rental_units', 'RentalUnitController');
    Route::resource('calls', 'CallController');
    Route::resource('meetings', 'MeetingController');
    Route::get('getcontactLead/{id}', 'MeetingController@getcontactLead');
    // changes to new Dashboard
    Route::get('teamCalendar','ToDoController@GetTeamTodos');
    Route::get('pendingTodayTodos','ToDoController@getPendingTodayTodos');
    Route::get('getAgentNames','HomeController@getAgentNames');
    Route::get('getLeadName','HomeController@getLeadName');
    Route::get('confirm_to_do/{id}', 'ToDoController@confirm_to_do');
    Route::get('getLeadsByAgentId','HomeController@getLeadsByAgentId');
    Route::get('followUp',function (){
        return view('admin.followUp');
    });
    Route::get('teamFollowUp',function (){
        return view('admin.HeaderTeamFollowUp');
    });
    // End of changes to new Dashboard
//    Route::get('settings', 'SettingController@settings');
    Route::post('settings', 'SettingController@update_settings');
    Route::resource('unit_types', 'UnitTypeController');
    Route::post('UpdateVue_unit_types', 'UnitTypeController@newUpdate');
    Route::get('delete_unit_types/{id}', 'UnitTypeController@newdestroy');
    Route::resource('requests', 'RequestController');
    Route::resource('requests_broadcast', 'RequestBroadcastController');

    Route::resource('groups', 'GroupController');
    Route::resource('incomes', 'IncomeController');
    Route::resource('outcomes', 'OutcomeController');
    Route::post('editgroups', 'GroupController@newupdate');
    Route::post('get_group', 'GroupController@get_group');
    Route::get('uploadLeads', 'LeadController@upload_file');
    Route::post('upload_leads_excel', 'LeadController@upload_leads_excel');
    
    // Route::get('leads/upload', 'LeadController@upload_file');
    // Route::post('leads/upload/excel', 'LeadController@upload_excel');
    Route::resource('tasks', 'TaskController');
    Route::get('confirm_task/{id}', 'TaskController@confirm_task');
    Route::get('confirm_collection/{id}', 'CollectionController@confirmCollection');
    Route::get('confirm_dues/{id}', 'DuesController@confirmDues');
    

    Route::resource('todos', 'ToDoController');
    Route::get('confirm_to_do/{id}', 'ToDoController@confirm_to_do');
    Route::get('todos/find/{id}','ToDoController@find');

    Route::get('deleteTodo/{id}','ToDoController@deleteTodo');

    // Route::get('leads/uploads/excel', 'LeadController@upload_file');
    // Route::post('leads/upload/excel', 'LeadController@upload_excel');

    Route::resource('targets', 'TargetController');
    Route::resource('cils', 'CilController');
    Route::post('cils/data','CilController@data');
    Route::get('cils/{id}/show','CilController@show');
    Route::post('sendCils','CilController@sendCils');
    Route::get('cils/{id}/showVie', 'CilController@show_vie');

    Route::get('cils_mail_settings', 'CilController@mailSettings');
    Route::get('getCils','CilController@getCils');

    Route::resource('industries', 'IndustryController');
    Route::resource('location', 'LocationController');
    Route::resource('schools', 'SchoolController');
    Route::resource('companies', 'CompanyController');
    Route::resource('professions', 'ProfessionController');
    Route::resource('titles', 'TitleController');

    // Ajax
    Route::post('edit_dashboard','AjaxController@edit_dashboard');
    Route::get('getOrder','DashboardController@getOrder');

    // get cities and contries
    Route::get('getCountries','CountryController@getAllCountries');
    Route::get('getcities','CityController@getAllCities');

    Route::post('count_notify','AjaxController@count_notify');
    Route::post('send_notify','AjaxController@send_notify');
    Route::post('get_cities', 'AjaxController@get_cities');
    Route::post('get_contacts', 'AjaxController@get_contacts');
    Route::post('get_calls', 'AjaxController@get_calls');
    Route::post('get_calls_contacts', 'AjaxController@get_calls_contacts');
    Route::post('get_meetings', 'AjaxController@get_meetings');
    Route::post('get_phones', 'AjaxController@get_phones');
    Route::post('get_requests', 'AjaxController@get_requests');
    Route::post('get_unit_types', 'AjaxController@get_unit_types');
    Route::post('get_property', 'AjaxController@get_property');
    Route::post('save_main_slider', 'AjaxController@save_main_slider');
    Route::get('delete_currency/{id}', 'CurrencyController@delete_currency');
    Route::put('edit_currency/{id}', 'CurrencyController@edit_currency');
    Route::post('get_proposal', 'AjaxController@get_proposal');
    Route::post('get_proposal_html', 'AjaxController@get_proposal_html');
    Route::post('get_units', 'AjaxController@get_units');
    Route::post('get_dashboard_callstatus', 'AjaxController@get_callsstatus');
    Route::post('get_activity', 'AjaxController@get_activity');
    Route::post('delete_note', 'AjaxController@deleteNote');
    // End Ajax

    Route::get('language/{lang}', 'HomeController@lang');
    Route::resource('facilities', 'FacilityController');
    Route::resource('projects', 'ProjectController');
    Route::get('BannerOfprojects', 'ProjectController@getProjectsHasBanners');
    Route::get('removeBannerByID/{id}', 'ProjectController@removeBannerByID');
    Route::get('getprojectsfeature', 'ProjectController@getprojectsfeature');
    Route::get('removefeatureByID/{id}', 'ProjectController@removefeatureByID');

    Route::get('getresalefeature', 'ResaleUnitController@getresalefeature');
    Route::get('removefeatureResaleByID/{id}', 'ResaleUnitController@removefeatureResaleByID');

    Route::resource('contacts', 'ContactController');
    Route::get('add/phase/{id}', 'PhaseController@create');
    Route::get('phases/{id}', 'PhaseController@show');
    Route::get('phases/edit/{id}', 'PhaseController@edit');
    Route::post('phases', 'PhaseController@store');
    Route::delete('phases/{id}', 'PhaseController@destroy');
    Route::put('phases/{id}', 'PhaseController@update');
    Route::post('phases/property', 'PhaseController@store_property');
    Route::resource('resale_units', 'ResaleUnitController');
    Route::get('finances', 'HomeController@all_finances');
    Route::get('all_Collections', 'HomeController@all_Collections');
    Route::get('all_Collected', 'HomeController@all_Collected');
    Route::get('all_Dues', 'HomeController@all_Dues');
    Route::get('all_Dues_Paid', 'HomeController@all_Dues_Paid');
    
    Route::get('setting', 'HomeController@all_finances');
    Route::post('location/destroy1', 'LocationController@destroy1');
    Route::get('inventory', 'HomeController@inventory');
    Route::get('calendar', 'Controller@calender');
    Route::resource('bank', 'BankController');
    Route::post('add_currency', 'CurrencyController@create');
    Route::get('delete_bank/{id}', 'BankController@destroy');
    Route::post('add_bank', 'BankController@store');

    //finances

    Route::post('add_income', 'IncomeController@create');
    Route::post('add_outcome', 'OutcomeController@create');
    Route::get('getCurrency', 'IncomeController@getCurrency');
    Route::get('getBanks', 'IncomeController@getBanks');
    Route::get('getOutCats', 'OutcomeController@getOutCats');
    
    Route::get('collect_income/{id}', 'IncomeController@collect');
    Route::post('edit_bank/{id}', 'BankController@edit');
    Route::post('add_safe', 'SafeController@create');
    Route::put('edit_safe/{id}', 'SafeController@edit');
    Route::get('delete_safe/{id}', 'SafeController@destroy');
    Route::get('confirm_proposal/{id}', 'ProposalController@confirm_proposal');
    Route::get('delete-prop/{id}', 'ProposalController@destroy');
    Route::get('show_proposal/{id}', 'ProposalController@show');
    Route::get('edit_proposal/{id}', 'ProposalController@edit');
    Route::get('get_proposal_closed_deal/{id}', 'ProposalController@getProposalClosedDeal');
    Route::get('get_proposals_confirmed', 'ProposalController@getProposalsConfirmed');
    Route::resource('proposals', 'ProposalController');
    Route::get('getProposalWithPaginate','ProposalController@getProposalWithPaginate');
    Route::post('proposals_update', 'ProposalController@update');
    Route::resource('deals', 'ClosedDealController');
    Route::get('delete-deal/{id}', 'ClosedDealController@destroy');
    Route::get('getAllDealsWithPaginate','ClosedDealController@getAllDealsWithPaginate');
    Route::get('show_deal/{id}', 'ClosedDealController@show');
    Route::resource('tags', 'TagController');

    //chris collections
    Route::resource('collection', 'CollectionController');
    Route::put('collection/{id}', 'CollectionController@update');
  

    //Dues
    Route::resource('dues', 'DuesController');
    Route::put('dues/{id}', 'DuesController@update');

    //loading
    Route::get('loading','LoadingController@load');

    Route::get('hintTags','TagController@getHintTags');
    Route::post('storeMultipleTags', 'TagController@storeMultipleTags');
    
    Route::resource('icons', 'IconController');
    Route::get('iconsdelete/{id}','IconController@newdelete');
    Route::get('get_project', 'SendprojectController@get_notification');
    Route::post('send_cil', 'LeadController@send_cil');
    Route::post('switch_leads', 'LeadController@switch_leads');
    Route::post('autoSwitch', 'LeadController@autoSwitch');
    Route::resource('campaign_types', 'CampaignTypeController');
    Route::resource('campaigns', 'CampaignController');
    Route::get('settings', 'SettingController@index');
    Route::get('hub_phones', 'SettingController@return_phones');
    Route::get('hub_icons', 'SettingController@return_icons');
    Route::resource('competitors', 'CompetitorController');
    Route::get('developers_facebook', 'DeveloperController@developers_facebook');
    Route::get('competitors_facebook', 'DeveloperController@competitors_facebook');
    Route::get('projects_facebook', 'DeveloperController@projects_facebook');

    Route::resource('developers', 'DeveloperController');
    Route::post('delete-dev/{id}', 'DeveloperController@destroy');
    Route::post('searchTag','TagController@searchTag');  
    Route::post('searchCampaignType','CampaignTypeController@searchCampaignType');  
    Route::post('searchCategory','OutCatController@searchCategory'); 
    Route::post('searchAgentType','AgentTypeController@searchAgentType');    
    Route::post('searchAgentType','AgentTypeController@searchAgentType');        
    Route::post('searchForm','FormController@searchForm');   
    Route::post('searchSubCat','OutSubCatController@searchSubCat');        
    Route::post('searchFacilities','FacilityController@searchFacilities'); 
    Route::post('searchMeeting','MeetingController@searchMeeting');  
    Route::post('searchRequest','RequestController@searchRequest');  
    Route::post('searchTeam','RequestController@searchTeam');  
    Route::post('searchBroadcast','RequestController@searchBroadcast');  
    Route::post('searchEvent','EventController@searchEvent');  
    Route::post('searchCampaign','CampaignController@searchCampaign'); 


    Route::resource('properties', 'PropertyController');
    Route::resource('facilities', 'FacilityController');
    Route::resource('projects', 'ProjectController');
    Route::resource('contacts', 'ContactController');
    Route::get('finances', 'HomeController@all_finances');
    Route::post('location/destroy1', 'LocationController@destroy1');
    Route::get('inventory', 'HomeController@inventory');
    Route::get('calendar', 'Controller@calender');
    Route::resource('bank', 'BankController');
    Route::post('add_currency', 'CurrencyController@create');
    Route::get('delete_bank/{id}', 'BankController@destroy');
    Route::post('add_bank', 'BankController@store');
    Route::post('add_income', 'IncomeController@create');
    Route::post('add_outcome', 'OutcomeController@create');
    Route::get('collect_income/{id}', 'IncomeController@collect');
    Route::post('edit_bank/{id}', 'BankController@edit');
    Route::post('add_safe', 'SafeController@create');
    Route::put('edit_safe/{id}', 'SafeController@edit');
    Route::get('delete_safe/{id}', 'SafeController@destroy');
    Route::get('confirm_proposal/{id}', 'ProposalController@confirm_proposal');
    Route::resource('proposals', 'ProposalController');
    Route::POST('addNewProposals', 'ProposalController@store');
    Route::resource('deals', 'ClosedDealController');
    Route::resource('tags', 'TagController');
    Route::resource('icons', 'IconController');
    Route::post('send_cil', 'LeadController@send_cil');
    Route::get('main_slider', 'WebsiteController@arrange_main_slider');
    Route::post('switch_leads', 'LeadController@switch_leads');
    Route::resource('campaign_types', 'CampaignTypeController');
    Route::resource('campaigns', 'CampaignController');
    Route::post('add_to_main_slider', 'AjaxController@save_main_slider');
    Route::get('reorder_units', 'ResaleUnitController@reorder');
    Route::post('reorder_units', 'ResaleUnitController@reorder_post');
    Route::post('reorder_projects', 'ResaleUnitController@reorder_projects');
    Route::get('settings_menu', 'HomeController@settings_menu');
    Route::get('sub_payed/{id}', 'ClosedDealController@sub_payed');
    Route::get('main_payed/{id}', 'ClosedDealController@main_payed');
    Route::get('accept/{id}', 'ReceivedprojectController@accept');
    Route::resource('events', 'EventController');
    Route::post('updateEvents', 'EventController@newupdate');

    Route::post('delete_event_image', 'EventController@delete_event_image');

    Route::resource('lands', 'LandController');
    Route::post('delete_land_image', 'LandController@delete_land_image');

    //ajax request
    Route::post('bulkActions', 'AjaxController@bulkAction');
    Route::post('add_call', 'AjaxController@add_call');
    Route::post('add_meetings', 'AjaxController@add_meetings');
    Route::post('add_Request', 'AjaxController@add_Request');

  // change_password
  Route::get('change_password', 'ChangePassController@index');
  Route::post('change_password', 'ChangePassController@store');
  Route::post('change_pass/{id}', 'ChangePassController@store_pass');

    Route::get('sitemap', 'HomeController@sitemap');
    Route::get('seo', 'adminSeoController@index');
    Route::post('updateSeo', 'adminSeoController@update');

    // get ar words
    Route::get('ar_Keywords', 'arabicMetawordsController@index');
    Route::get('en_Keywords', 'EnglishMetawordsController@index');
    
    // Route::get('getAllKeyWords', 'adminMetakeywordsController@index');

    Route::post('get_leads_by_agent', 'AjaxController@getLeadsByAgent');
    Route::post('getBtns', 'AjaxController@getBtns');
    Route::post('fav_lead', 'AjaxController@fav_lead');
    Route::post('hot_lead', 'AjaxController@hot_lead');
    Route::post('add_note_ajax', 'LeadNoteController@store');
    Route::post('add_note', 'LeadNoteController@store');
    // Route::post('get_lands', 'AjaxController@get_lands');
    Route::get('get_lands', 'AjaxController@get_lands');
    Route::post('lead_notifications', 'LeadNotificationController@store');
    Route::post('export_xls','CampaignController@export_xls');
    Route::post('delete_resale_image', 'ResaleUnitController@delete_resale_image');
    Route::post('delete_rental_image', 'RentalUnitController@delete_rental_image');
    Route::resource('roles', 'RoleController');
    Route::get('getAllRoles','RoleController@index');
    Route::get('EditSingleRole/{id}','RoleController@edit');
    Route::post('updateSingleRole/{id}','RoleController@update');
    Route::get('deleteSingleRole/{id}','RoleController@destroy');
    Route::post('storeSingleRole','RoleController@store');
    Route::get('GetRoleAndDetails/{id}','RoleController@DataForCustomePage');
    Route::get('GetApiAllRole/{id}','RoleController@GetAllrolesApi');
    Route::resource('logs', 'LogController');
    Route::post('get_suggestions', 'AjaxController@get_suggestions');
    Route::post('get_suggestions_new', 'AjaxController@get_suggestions_new');
    Route::post('add_suggestion', 'AjaxController@add_suggestion');
    Route::get('suggestions/{id}', 'AjaxController@getLeadSuggestions');

    Route::post('add_doc', 'LeadDocumentController@store');
    Route::post('get_projects', 'AjaxController@get_projects');
    Route::post('update_lead', 'LeadController@update_lead');
    Route::post('seo', 'HomeController@seo');
    Route::get('send_mail','HomeController@send_mail');
    Route::post('mail_post','HomeController@mail_post');
    Route::get('inbox','HomeController@inbox');
    Route::post('get_mail/{id}','HomeController@get_mail');
    Route::post('send_unit','HomeController@send_unit');
    Route::post('push_player','HomeController@push_player');
    Route::post('changeAssistantStatus','HomeController@changeAssistantStatus');
    Route::get('getUserHowLogin','HomeController@getUserHowLogin');
    Route::get('chat', function() {
        return view('admin.chat');
    });
    // require public_path('../vendor/autoload.php');

    Route::get('get_msg', function() {
        $options = array(
            'cluster' => 'eu',
            'encrypted' => true
        );
        $pusher = new Pusher\Pusher(
            '77ab43aa6bf2cb6aab94',
            '8f91214bcb3d73ec23ea',
            '445473',
            $options
        );

        $data['message'] = 'hello world';
        $pusher->trigger('chat', 'ChatEvent', $data);
    });

    Route::post('get_developer_projects','ProjectController@get_developer_projects');

    Route::get('reports',function (){
        return view('admin.reports',['title' => __('admin.reports')]);
    });
    Route::get('dailyreports','AgentController@getDailyReports');
    Route::get('dailyreportsbycall','AgentController@getDailyReportsByCall');
    Route::get('getAllAgents','AgentController@getAllAgents');
    // Route::get('dailyreports',function (){
    //     $agents = \App\User::select('name', 'id')->get();
    //     return view('admin.dailyreports')->with('agents', $agents);
    // });
    // Route::get('dailyreportsbycall',function (){
    //     $agents = \App\User::select('name', 'id')->get();
    //     $lead_sources = \App\LeadSource::all();
    //
    //     return view('admin.dailyreportsbycall')->
    //     with('agents', $agents)->
    //     with('lead_sources', $lead_sources);
    // });
    Route::post('get_report_form', 'AjaxController@get_report_form');
    Route::post('getdailyreports', 'AjaxController@getDailyReports');
    Route::post('getdailyreportsbycall', 'AjaxController@getDailyReportsByCall');
    Route::post('get_lead_report', 'AjaxController@get_lead_report');
    Route::post('get_leads_data', 'AjaxController@get_leads_data');
    Route::post('get_lead', 'AjaxController@get_lead_data');
    Route::post('update_lead_ajax', 'AjaxController@updateLead');

    Route::post('search_cloud', 'AjaxController@search_cloud');
    Route::post('get_target', 'AjaxController@get_target');
    Route::post('get_developer_report', 'AjaxController@get_developer_report');
    Route::post('get_project_deals', 'AjaxController@get_project_deals');
    Route::post('get_phases', 'AjaxController@get_phases');
    Route::post('get_phase_units', 'AjaxController@get_phase_units');

    
    Route::post('get_sales_forecast_report', 'AjaxController@get_sales_forecast_report');
    Route::post('cil_change_status/{id}', 'CilController@cil_change_status');
    Route::get('leads_ajax', 'LeadController@leads_ajax');
    Route::get('leads_ind_ajax', 'LeadController@leads_ind_ajax');
    Route::get('leads_fav_ajax', 'LeadController@leads_fav_ajax');
    Route::get('leads_hot_ajax', 'LeadController@leads_hot_ajax');
    Route::get('team_leads_ajax', 'LeadController@team_leads_ajax');
    Route::post('updatelead','LeadController@updatelead');
    Route::post('updateEmployees','EmployeeController@updateEmployees');
    Route::post('StoreNewEmpRequest','EmployeeRequestController@Store');
    Route::post('UpdateGroosSalary','grossSalaryController@Store');
    Route::get('GrossEmployeeSalary','grossSalaryController@GrossReport');
    Route::get('GetEmpDetails/{id}','grossSalaryController@customeEmployee');
    Route::get('getAlldeduction','deductionController@getAlldeduction');
    Route::post('employeeDeductionUpdate','deductionController@Store');
    Route::post('storeEmployeeContact','EmployeeController@addErContact');
   

    // New Vue Dashboard
    Route::get('leads2','LeadController@getLeadsNew');
    Route::get('getLeadsNew','LeadController@getLeadsNew');
    Route::get('getMyLeads','LeadController@getMyLeads');
    Route::get('getArchive','LeadController@getArchive');
    Route::get('getIndividualLeads','LeadController@getIndividualLeads');
    Route::get('getTeamLeadsNew','LeadController@getTeamLeadsNew');
    Route::get('getHotLeads','LeadController@getHotLeads');
    Route::get('getTodayLeads','LeadController@getTodayLeads');
    Route::get('getSeen','LeadController@getSeen');
    Route::get('getNotSeen','LeadController@getNotSeen');
    Route::get('getColdCalls','LeadController@getColdCalls');
    Route::get('getTodayColdCalls','LeadController@getTodayColdCalls');
    Route::get('getFavoriteLeads','LeadController@getFavoriteLeads');
    Route::get('getLeadData/{id}','LeadController@getLeadData');

    Route::get('getDuplicatedLeads','LeadController@getDuplicatedLeads');
    Route::get('getLeadSummaries','LeadController@getLeadSummaries');

    Route::get('convertLeadCC/{id}','LeadController@convertLeadCC');
    Route::post('newLeadsFilter', 'LeadController@newLeadsFilter');
    //newResaleFilter
    Route::post('newResaleFilter', 'ResaleUnitController@newResaleFilter');
    Route::post('newRentalFilter', 'RentalUnitController@newRentalFilter');
    // Route::post('exportReportLeads','LeadController@exportReportLeads');
    // Route::get('exportReportLeads/{typeReportLeads?}','LeadController@exportReportLeads');
    Route::get('getAgents','LeadController@getAgents');
    // Route::get('getAgents','LeadController@getAgents');
    Route::get('getDevelopers','DeveloperController@getDevelopers');
    Route::get('checkUserGroupAndRoles','LeadController@checkUserGroupAndRoles');
    Route::post('getUnitsTypesnew','LeadController@getUnitsTypesnew');
    Route::post('searchForLead','LeadController@searchForLead');
    Route::post('addToDo','LeadController@addToDo');
    Route::get('getDevProjects/{id}','LeadController@getDevProjects');
    Route::post('addCILRequest','LeadController@addCILRequest');
    Route::get('getAllLeads','LeadController@getAllLeads');
    Route::get('getAllLeads','TaskController@getAllLeads');

    
    Route::get('leads/autocomplete/list','LeadController@getAllLeadsAutocompleteList');
    Route::get('getLeadSources','LeadSourceController@getLeadSources');
    Route::post('leadShortAdding','LeadController@leadShortAdding');
    Route::post('editLeadsCalls','LeadController@editLeadsCalls');

    Route::get('createUnit', 'ResaleUnitController@createUnit');
    Route::post('storeUnitResale', 'ResaleUnitController@storeUnitResale');

    Route::get('getOwnedUnits/{id}', 'AjaxController@getOwnedUnits');
    Route::post('getUnitLeads', 'LeadController@getUnitLeads');
    

    Route::post('get_countries_cities', 'AjaxController@get_countries_cities');
    Route::post('get_cities_districts', 'AjaxController@get_cities_districts');

    Route::resource('forms', 'FormController');

    Route::post('get_form_projects', 'AjaxController@get_form_projects');
    Route::post('get_form_phases', 'AjaxController@get_form_phases');
    Route::resource('contracts', 'ContractController');

    Route::post('filter_team_leads', 'LeadController@filter_team_leads');
    Route::post('notification-status', 'HomeController@notificationStatus');
    Route::post('rate_employee', 'AjaxController@rate_employee');
    Route::post('unread', 'HomeController@unread');

    Route::resource('call_statuses', 'CallStatusController');
    Route::get('GetAllStatusOfCalls', 'CallStatusController@returnForApi');
    Route::resource('meeting_statuses', 'MeetingStatusController');

    Route::resource('out_cats', 'OutCatController');
    Route::resource('out_sub_cats', 'OutSubCatController');
    Route::post('get_sub_cats', 'HomeController@get_sub_cats');
    Route::post('filter_leads', 'LeadController@filter_leads');

    Route::get('interested-request/{unit}/{req}', 'RequestController@interestedRequest');

    Route::get('delete-contracts/{id}', 'ContractController@delete');
    Route::post('get_req_projects', 'RequestController@getProjects');

    Route::post('search-team', 'LeadController@searchTeam');
    Route::resource('leads','LeadController');

    // Route::get('update-projects', function() {
    //     $projects = \App\Project::get();
    //     foreach($projects as $pro) {
    //         $pro->developer_pdf = json_encode([]);
    //         $pro->broker_pdf = json_encode([]);
    //         $pro->save();
    //     }
    //     return 'true';
    // });

    Route::get('test-lead', function() {
        $lead = \App\Lead::where('phone', '01001590310')->get();
        return $lead;
    });

    Route::post('get_group_agents', 'LeadController@getGroupAgents');
     /////////////////////// HR Module //////////////////////
    // Route::post('notification-status', 'HomeController@notificationStatus');
    Route::post('unread', 'HomeController@unread');
    // Route::post('Addapplications', 'ApplicationController@store');
    // Route::resource('applications', 'ApplicationController');
    Route::resources([
        'job_categories'=>'JobCategoryController',
        'job_titles'=>'JobTitleController',
        'vacancies'=>'VacancyController',
        'applications'=>'ApplicationController',
        'employees'=>'EmployeeController',
        'vacations'=>'VacationController',
        'custodies'=>'CustodiesController',
        'kpi'=>'KpiController',
        'rates'=>'RatesController',
        'salaries'=>'SalariesController',
        'salaries-details'=>'SalariesDetailsController',
        'hr-settings'=>'HrSettingsController',
        'attendance'=>'AttendanceController',
        'payroll'=>'PayrollController',
    ]);
    Route::get('Allemployees','EmployeeController@getAllData');
    Route::get('getShortListed', 'ApplicationController@getShortListed');
    Route::get('getUnderReview', 'ApplicationController@getUnderReview');

    Route::post('/employees/employee_slip','EmployeeController@employee_slip');
    Route::post('/salaries/slips','SalariesController@salary_slip');
    Route::get('applications/vacancy/{id}','VacancyController@get_vacancy_applications');
    Route::get('employees/create/{id?}','EmployeeController@create');
    Route::get('applications/create/{id?}','ApplicationController@create');
    Route::post('get_titles','JobTitleController@get_titles');
    Route::post('get_applications','ApplicationController@get_applications');
    Route::post('applications/proposed','JobProposalController@store');
    Route::put('applications/proposed/{id}','JobProposalController@update');
    Route::get('change-category', 'ApplicationController@changeSelector');
    Route::get('change-title', 'ApplicationController@changeTitle');
    Route::post('update_employee', 'EmployeeController@updateEmployee');
    Route::post('image_collector', 'EmployeeController@imageCollector');
    Route::post('update-salary-notes', 'EmployeeController@salaryNotes');
    Route::post('add-er-contact', 'EmployeeController@addErContact');
    Route::post('add-custodies', 'EmployeeController@addCustody');
    Route::post('update-custody', 'CustodiesController@deliverCustody');
    Route::post('request-vacation', 'VacationController@requestVacation');
    Route::post('approve_vacation', 'VacationController@approveVacation');
    Route::get('GetAllVacatonType', 'VacationTypesController@index');
    Route::post('addNewNational', 'NationalVicationController@store');
    Route::get('GetVacationOfNational', 'NationalVicationController@index');
    Route::get('getVacationType', 'VacationTypesController@indexpage');
    Route::post('StoreNewNationalVacType', 'VacationTypesController@store');
    Route::get('DeleteNationalVacType/{id}', 'VacationTypesController@destroy');
    Route::post('updateVacation/{id}', 'VacationTypesController@update');
    Route::get('getSinglevacationType/{id}', 'VacationTypesController@edit');
    Route::get('GetAttendanceReport', 'employee_attendance_controller@reportAllAttendance');
    Route::get('GetAllNationalVacation', 'NationalVicationController@vacationRebort');
    Route::get('getSingleNVacation/{id}', 'NationalVicationController@edit');
    Route::post('updateNVacany', 'NationalVicationController@update');
    Route::delete('DeleteNationalVacation/{id}', 'NationalVicationController@destroy');
    Route::post('disapprove_vacation', 'VacationController@disApproveVacation');
    Route::post('update-settings', 'HrSettingsController@updateSetting');
    Route::get('cal-salary', 'HrSettingsController@calculateSalary');
    Route::view('rules-procedure', 'admin.employee.rules_of_procedure');
    Route::post('insert-attendance', 'HrSettingsController@insertAttendance');
    Route::view('xattendance', 'admin.employee.xlsrequest');
    Route::post('time-interval-attendance', 'AjaxController@dateInterval');
    Route::post('searchSuggestions','RequestController@searchSuggestions');
//    Route::post('attendance', 'SalariesController@salaryCalculations');

    Route::resource('Getleads','LeadController');

    Route::get('emp-dashboard','EmployerDashboard@statics');
 
    Route::get('emp-settings', function () {
        return view('admin.employee.setting');
    });

    Route::post('allow-rate', 'EmployeeController@allowRate');
    Route::post('update-rate','EmployeeController@updateRate');
    //Edit By Pc6 
    Route::get('getAllProposedCompany','ProposedCompanyController@getProposedCompany');
    Route::get('getAllProposal','ProposalController@getProposal');
    Route::get('getAllCompanies','CompanyController@getCompany');
    Route::get('getAllCurrency', 'CurrencyController@getAllCurrency');
    Route::get('getAllItem/{id}', 'ItemController@getAllItem');
    Route::get('getAllNationality', 'NationalityController@getAllNationality');
    Route::get('getAllCities', 'CityController@getAllCities');
    Route::get('getAllCountries', 'CountryController@getAllCountries');
    Route::post('addNewProposedCompany', 'ProposedCompanyController@store');
    Route::post('addNewInvoice', 'invoicesController@store');
    Route::post('UpdateProposedCompany/{id}', 'ProposedCompanyController@update');
    Route::get('getAllContactPerson/{id}','ContactController@getAllContactPerson');
    Route::get('getAllProposalCompanies','ProposedCompanyController@index');

    Route::get('getProposalCompanyById/{id}','ProposedCompanyController@show');
    Route::get('allCompanies/{id}','ProposedCompanyController@destroy');
    Route::get('delete-Company/{id}', 'ProposedCompanyController@multiDelete');
    Route::post('searchForCompany','ProposedCompanyController@searchForCompany');





});

Route::post('fblead1',function (){
    return ['status'=>'ok'];
});
    Route::get('sci',function (){
        return view('sci');
    });
Route::group(['prefix' => 'ajax'], function () {
    Route::get('property', function () {
        return view('admin.projects.content.create.property');
    });
});

Route::get('fb_api', function () {
    $fb = \App\Developer::select('facebook')->get();
    return $fb;
});

Route::get('fb_api2', function () {
    $fb = \App\Developer::pluck('facebook');
    return $fb;
});

Route::get('image_test',function (){
    return view('admin.image_test');
});
Route::get('img_post','HomeController@img');

Route::get('privacy-policy', function(){
    return view('privacy-policy');
});

Route::get('form/{slug}', 'HomeController@form');
Route::post('form-lead', 'LeadController@formLead');

Route::get('contracts/{url}', 'HomeController@contract');
Route::post('confirm-contract', 'HomeController@confirmContract');
Route::post('contract-form', 'HomeController@contractForm');

Route::get('socket', function(){
    exec('node socket/index', $output);
    return $output;
});


// Route::get('sheno','HomeController@test5');


//
// use Facebook\Facebook;
// use Facebook\Exceptions\FacebookResponseException;
//use FacebookAds\Api;
//use FacebookAds\Object\AdSet;
//use FacebookAds\Object\Fields\AdSetFields;
//use FacebookAds\Object\AdAccount;
//
//Route::get('fb', function () {
//    Api::init(
//        '371011733023863',
//        'b5bf2312f741998d6b4c8a612285c9dc',
//        '371011733023863|1lgHZaIL9a_K3u6zNtvVzaaZX9U'
//    );
//    $account_id = 'act_123123';
//    $campaign_id = '123456';
//
//    $account = new AdAccount($account_id);
//    $account->read();
//});

// Route::get('testfb',function(){
//     return view('test1');
// });

// Route::post('webhook.php',function(){
//     $challenge = $_REQUEST['hub_challenge'];
//     $verify_token = $_REQUEST['hub_verify_token'];

//     if ($verify_token === 'abc123') {
//       echo $challenge;
//     }
// });

