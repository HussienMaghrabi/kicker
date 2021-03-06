<?php
use Illuminate\Http\Request;


Route::get('test',function (){
    return 'sheno';
});

Route::post('login','Agentapi@login');
Route::post('signup','Agentapi@signUp');
// token e9d436a60ec7fbcac50c882bc6ee3795
// id 1
// Route::group(['middleware' => 'agentapi'], function () {
    

    Route::post('image','AgentController3@add_image');
    Route::post('push_player', 'Agentapi@push_player');
    Route::post('events', 'Agentapi@events');
    Route::post('add_contact','Agentapi@add_contact');
    Route::post('profile', 'Agentapi@profile');
    Route::post('lead_action','Agentapi@lead_action');
    Route::post('todo_info', 'ApiAgentController@todo_info');
    Route::post('add_todo', 'ApiAgentController@add_todo');
    Route::post('add_todo_ios', 'ApiAgentController@add_todo_ios');
    Route::post('get_leads', 'ApiAgentController@get_leads');
    Route::post('get_leads_by_agent', 'ApiAgentController@get_agent_leads');
    Route::post('get_leads_sync', 'ApiAgentController@get_leads_sync');
    Route::post('get_leads_full', 'ApiAgentController@get_leads_full');
    Route::post('get_team_leads', 'ApiAgentController@get_team_leads');
    Route::post('get_teams', 'ApiAgentController@get_teams');
    Route::post('dash_get_status', 'ApiAgentController@dash_get_status');
    Route::post('dash_get_sources', 'ApiAgentController@dash_get_sources');
    Route::post('get_team_children', 'ApiAgentController@get_team_children');
    Route::post('search_leads', 'ApiAgentController@search_leads');
    Route::post('get_projects', 'ApiAgentController@get_projects');
    Route::post('get_resales', 'ApiAgentController@get_resales');
    Route::post('get_rentals', 'ApiAgentController@get_rentals');
    Route::get('getHrSettingData', 'hrSettingsController@index');
    Route::post('updateHrSettings', 'hrSettingsController@store');
    Route::get('GetEmployeeRequests', 'EmployeeRequestController@index');
    Route::get('ChangeRequestStatus/{id}', 'EmployeeRequestController@ChangeRequestStatus');
    Route::post('saveemployeeattendance', 'employee_attendance_controller@saveemployeeattendance');
    Route::post('UpdateRequestEmployee', 'EmployeeRequestController@update');
    Route::get('DeleteEmployeeRequest/{id}', 'EmployeeRequestController@destroyReq');
    Route::post('single_project', 'ApiAgentController@single_project');
    Route::post('single_resale', 'ApiAgentController@single_resale');
    Route::post('single_rental', 'ApiAgentController@single_rental');
    Route::post('lead_request', 'ApiAgentController@lead_request');
    Route::post('lead_contact', 'ApiAgentController@lead_contact');
    Route::post('lead_message', 'ApiAgentController@lead_message');
    Route::post('lead_document', 'ApiAgentController@lead_document');
    Route::post('lead_note', 'ApiAgentController@lead_note');
    Route::post('getinfo', 'ApiAgentController@getinfo');
    Route::post('add_call', 'ApiAgentController@add_call');
    Route::post('cil_info', 'AgentController3@cil_info');
    Route::post('send_cil', 'AgentController3@send_cil');
    Route::post('getFiltersBtn', 'ApiAgentController@getFiltersBtn');
    Route::post('lead_edit_info', 'AgentController3@lead_edit_info');
    Route::post('edit_lead', 'AgentController3@edit_lead');
    Route::post('add_meeting', 'AgentController3@add_meeting');
    Route::post('get_contact', 'AgentController3@get_contact');
    Route::post('get_request_info', 'AgentController3@getinfo');
    Route::post('add_request', 'AgentController3@request');
    Route::post('add_request_broadcast', 'AgentController3@requestBroadcast');
    Route::post('get_suggestion', 'ApiAgentController@get_suggestion');
    Route::post('lead_resale', 'AgentController3@lead_resale');
    Route::post('lead_rental', 'AgentController3@lead_rental');
    ///////////////////////HR///////////////////////////////
    Route::post('favorite_project', 'AgentController3@favorite_project');
    Route::post('favorite_resale', 'AgentController3@favorite_resale');
    Route::post('favorite_rental', 'AgentController3@favorite_rental');
    Route::post('interested_project', 'AgentController3@interested_project');
    Route::post('interested_resale', 'AgentController3@interested_resale');
    Route::post('interested_rental', 'AgentController3@interested_rental');
    Route::post('refresh_token', 'Agentapi@refresh');
    Route::post('notification', 'AgentController3@notification');
    Route::post('seen', 'AgentController3@seen');
    Route::post('lead_sources', 'AgentController3@lead_sources');
    Route::post('add_lead', 'AgentController3@add_lead');
    Route::post('mission_complete', 'Agentapi@mission_complete');
    Route::post('logout','Agentapi@logout');
    Route::post('add_note', 'Agentapi@add_notifcation');
    Route::post('unit_info', 'Agentapi@unit_info');
    Route::post('upload_test', 'Agentapi@asd');
    Route::post('create_unit', 'AgentController3@create_unit');
    Route::post('get_cils', 'Agentapi@getCils');
    Route::post('get_statuses', 'Agentapi@getStatuses');
    Route::post('filter_leads', 'Agentapi@filterLeads');
    Route::post('get_agent_leads', 'ApiAgentController@getAgentLeads');
    Route::post('filter_data', 'Agentapi@getFilterData');
    Route::post('get_unit_filter_data', 'Agentapi@getUnitFilterData');
    Route::post('fliter_porjects', 'Agentapi@filterProjects');
    Route::post('fliter_units', 'Agentapi@fliterUnits');
    Route::post('add_interested', 'ApiAgentController@add_interested');
    Route::post('list_broadcastrequests', 'Agentapi@list_broadcastrequests');
    Route::post('single_broadcastrequests', 'Agentapi@single_broadcastrequests');
    Route::post('add_lead_note', 'Agentapi@addLeadNote');
    Route::post('add_interested_request', 'Agentapi@addInterestedRequest');
    Route::post('get_cities', 'Agentapi@getCities');
    Route::post('list_requests', 'Agentapi@list_requests');
    Route::post('get_districts', 'Agentapi@getDistricts');
    Route::post('add_unit1', 'Agentapi@addUnit1');
    Route::post('add_unit2', 'Agentapi@addUnit2');
    Route::post('add_unit3', 'Agentapi@addUnit3');
    Route::post('add_unit4', 'Agentapi@addUnit4');
    Route::post('last_seen', 'Agentapi@last_seen');
    Route::post('delete_lead', 'Agentapi@delete_lead');
    //Route::post('get_caller', 'Agentapi@getCaller');
    Route::post('add_doc', 'Agentapi@add_doc');
    Route::post('add_voice', 'Agentapi@addVoice');
    Route::post('get_lead', 'Agentapi@get_lead');
    Route::post('download_lead','Agentapi@downloadLead');
    Route::post('new_teamlead','ApiAgentController@get_teamLeads');
    Route::post('check-emp','Agentapi@checkEmployees');
    Route::post('vac-req','Agentapi@vacationRequests');
    Route::post('approve-attendance','Agentapi@approveAttend');
    Route::post('approve-vacation','Agentapi@approveVacation');
    Route::post('request-vacation','Agentapi@requestVacation');
    Route::post('new-profile','Agentapi@newProfile');
    Route::post('salary-details','Agentapi@salaryDetail');
    Route::post('rate-progress','Agentapi@rateProgress');
    Route::post('init-rate','Agentapi@initRate');
    Route::post('assign-rate','Agentapi@assignRate');
    Route::post('vacation-request','Agentapi@vacation');
    Route::post('get_vacation','Agentapi@getVacation');
    Route::post('resale_of_me','Agentapi@ResaleOfMe');
    Route::post('resale_of_others','Agentapi@ResaleOfOthers');
    Route::post('rental_of_me','Agentapi@RentalOfMe');
    Route::post('rental_of_others','Agentapi@RentalOfOthers');
    Route::post('fav_lead', 'Agentapi@fav_lead');
    Route::post('hot_lead', 'Agentapi@hot_lead');
    Route::post('deleteLeadAction/{type}/{id}', 'Agentapi@deleteLeadAction');
    Route::post('showLeadAction/{type}/{id}', 'Agentapi@showLeadAction');
    Route::put('updateLeadAction/{type}/{id}', 'Agentapi@updateLeadAction');

    // Route::post('storeUnitResale', 'storeUnitResale@storeUnitResale');
    Route::post('storeUnitResaleSteps/{step?}/{id?}', 'ResaleUnitController@storeUnitResaleSteps');

// });

Route::post('get_caller', 'Agentapi@getCaller');

Route::post('signup','Agentapi@signUp');
