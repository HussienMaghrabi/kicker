<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->namespace('Api')->group(function () {
    Route::resource('lead', 'LeadsController');
    Route::get('leadsById/{id}', 'LeadsController@leads_by_id');
    Route::resource('item', 'ItemController');
    Route::resource('company', 'ProposedCompanyController');
    Route::resource('invoice', 'InvoicesController');
    Route::get('allProposalById/{id}', 'ProposalController@all_proposal_by_id');
    Route::get('itemById/{id}', 'ItemController@itemCompany');
    Route::get('editProposal/{id}', 'ProposalController@show');
    Route::get('contactBYId/{id}', 'contactsController@contact_by_id');
    Route::get('currencyById/{id}', 'CurrenciesController@currency_by_id');
    Route::post('searchFormLead', 'LeadsController@Search');
    Route::post('searchFormItem', 'ItemController@Search');
});