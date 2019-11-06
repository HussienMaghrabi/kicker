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
    Route::resource('item', 'ItemController');
    Route::resource('company', 'ProposedCompanyController');
    Route::get('allProposalById/{id}', 'ProposalController@all_proposal_by_id');
    Route::get('itemById/{id}', 'ItemsControler@itemCompany');
    Route::resource('editProposal/{id}', 'ProposalController');
});