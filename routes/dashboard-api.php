<?php

Route::group(['prefix'=>'api/dashboard', 'middleware' => ['lang']], function() {
  Route::get('/agent/dashboard-section-statistics', 'DashboardController@dashboard_section_statistics_for_agent');
  // Route::get('/agent/events', 'DashboardController@agent_events');
  Route::get('/projects', 'DashboardController@get_projects');
  Route::post('/agent/achievements', 'DashboardController@get_achievements_stats');
  Route::post('/agent/teamAchievements', 'DashboardController@get_TeamAchievements_Stats');
});

?>
