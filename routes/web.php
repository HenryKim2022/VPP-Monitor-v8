<?php
use App\Http\Controllers\Auth\LoginPageController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\UserPanels\Manage\ClientController;

use App\Http\Controllers\UserPanels\Manage\ClientUserLoginController;
use App\Http\Controllers\UserPanels\Manage\EmployeeController;
use App\Http\Controllers\UserPanels\Manage\EmpUserLoginController;
use App\Http\Controllers\UserPanels\Manage\EngTeamController;
use App\Http\Controllers\UserPanels\Manage\MonitoringController;
use App\Http\Controllers\UserPanels\Manage\MyProfileController;
use App\Http\Controllers\UserPanels\Manage\OfficeRoleController;
use App\Http\Controllers\UserPanels\Manage\ProjectsController;
use App\Http\Controllers\UserPanels\Manage\TaskController;
use App\Http\Controllers\UserPanels\Manage\WorksheetController;
use App\Http\Controllers\UserPanels\Navigate\SystemSettingsController;
use App\Http\Middleware\CheckRememberToken;
use Illuminate\Support\Facades\Route;

/////////////////////////////////////////////////// <<<  END: USE CONTROLLER  >>> ///////////////////////////////////////////////


/////////////////////////////////////////////// <<<  START: ROUTES (NO USERGROUP) >>> ///////////////////////////////////////////
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
//////////////////////////////////////////////// <<<  END: ROTES (NO USERGROUP) >>> /////////////////////////////////////////////

/////////////////////////////////////////////// <<<  START: ROUTES (NO USERGROUP) >>> ///////////////////////////////////////////
// // Route::get('/', [LoginPageController::class, 'index'])->name('login.page');
// Route::get('/', [LoginPageController::class, 'index'])->middleware(['auth.notloggedin'])->name('login.page');
// //////////////////////////////////////////////// <<<  END: ROTES (NO USERGROUP) >>> /////////////////////////////////////////////


// /////////////////////////////////////////////////// <<<  START: ROUTES (WITH USERGROUP) >>> //////////////////////////////////////
// Route::prefix('')->name('login.')->middleware(['auth.notloggedin'])->group(function () {
//     // Route::get('/login', 'App\Http\Controllers\Auth\LoginPageController@showLogin')->name('page');
//     Route::get('/login', 'App\Http\Controllers\Auth\LoginPageController@showLogin')->name('show');
//     Route::post('/login', 'App\Http\Controllers\Auth\LoginPageController@doLogin')->name('do');
// });


Route::prefix('')->name('login.')->middleware(['auth.notloggedin'])->group(function () {
    Route::get('/login', 'App\Http\Controllers\Auth\LoginPageController@showLogin')->name('show');
    Route::post('/login', 'App\Http\Controllers\Auth\LoginPageController@doLogin')->name('do');
});

// Protect the root route with the auth.notloggedin middleware
Route::get('/', [LoginPageController::class, 'index'])->middleware(['auth.notloggedin'])->name('login.page');




Route::prefix('')->name('reset.')->middleware(['auth.notloggedin'])->group(function () {
    Route::get('/forgot-password', 'App\Http\Controllers\Auth\PasswordResetController@index')->name('page');
    // Route::post('/forgot-password/send-token', 'App\Http\Controllers\Auth\PasswordResetController@doSend')->name('send');
    // Route::get('/forgot-password/send-token/type', 'App\Http\Controllers\Auth\PasswordResetController@doSend')->name('send');
    Route::match(['get', 'post'], '/forgot-password/send-token', 'App\Http\Controllers\Auth\PasswordResetController@doSend')->name('send');
    // Route::post('/forgot-password/reset-form/{token}', 'App\Http\Controllers\Auth\PasswordResetController@showReset')->name('form');
    // Route::get('/forgot-password/reset-form/{token}', 'App\Http\Controllers\Auth\PasswordResetController@showReset')->name('form');
    Route::match(['get', 'post'], '/forgot-password/reset-form/{token}', 'App\Http\Controllers\Auth\PasswordResetController@showReset')->name('form');
    Route::post('/forgot-password/do-reset', 'App\Http\Controllers\Auth\PasswordResetController@doReset')->name('do');
});

Route::prefix('')->name('register.')->middleware(['auth.notloggedin','check.registration.settings'])->group(function () {
    Route::get('/register-emp', 'App\Http\Controllers\Auth\RegisterEmployeePageController@showRegister')->name('emp.page');
    Route::post('/register-emp', 'App\Http\Controllers\Auth\RegisterEmployeePageController@doRegister')->name('emp.do');

    Route::get('/register-client', 'App\Http\Controllers\Auth\RegisterClientPageController@showRegister')->name('client.page');
    Route::post('/register-client', 'App\Http\Controllers\Auth\RegisterClientPageController@doRegister')->name('client.do');
});



Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/user-panels', 'App\Http\Controllers\UserPanels\Navigate\UserPanelController@index')->name('userpanels');   //<--- ORI: Dashboard
});

Route::prefix('')->name('userPanels.')->middleware(['auth', CheckRememberToken::class])->group(function () {
    // Route::get('/dashboard', 'App\Http\Controllers\UserPanels\Navigate\UserPanelController@index')->name('dashboard');   //<--- ORI: Dashboard
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
    Route::get('/logout', 'App\Http\Controllers\Auth\LoginPageController@doLogoutUPanel')->name('logout.redirect');
});



Route::middleware(['auth'])->group(function () {    // Note: Separated group coz somewhat wont work if using direct controller path (only /my-profile).
    Route::get('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
});
Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    // Route::get('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
    // Route::post('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
    Route::post('/my-profile/edit-acc-avatar', [MyProfileController::class, 'profile_edit_avatar'])->name('userPanels.avatar.edit');
    Route::post('/my-profile/edit-biodata', [MyProfileController::class, 'profile_edit_biodata'])->name('userPanels.biodata.edit');
    Route::post('/my-profile/edit-accdata', [MyProfileController::class, 'profile_edit_accdata'])->name('userPanels.accdata.edit');
    // Route::get('/my-profile/edit-accdata', [MyProfileController::class, 'profile_edit_accdata'])->name('userPanels.accdata.edit');
    Route::get('/my-profile/load-biodata', [MyProfileController::class, 'profile_load_biodata'])->name('userPanels.biodata.load');
    Route::get('/my-profile/load-accdata', [MyProfileController::class, 'profile_load_accdata'])->name('userPanels.accdata.load');
});





Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/m-emp', [EmployeeController::class, 'index'])->name('m.emp');
    Route::post('/m-emp/add', [EmployeeController::class, 'add_emp'])->name('m.emp.add');
    Route::post('/m-emp/edit', [EmployeeController::class, 'edit_emp'])->name('m.emp.edit');
    Route::post('/m-emp/delete', [EmployeeController::class, 'delete_emp'])->name('m.emp.del');
    Route::post('/m-emp/reset', [EmployeeController::class, 'reset_emp'])->name('m.emp.reset');
    Route::post('/m-emp/load', [EmployeeController::class, 'get_emp'])->name('m.emp.getemp');
    // Route::get('/m-emp/load', [EmployeeController::class, 'get_emp'])->name('m.emp.getemp');
});


Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/m-emp/roles', [OfficeRoleController::class, 'index'])->name('m.emp.roles');
    Route::post('/m-emp/roles/add', [OfficeRoleController::class, 'add_role'])->name('m.emp.roles.add');
    Route::post('/m-emp/roles/edit', [OfficeRoleController::class, 'edit_role'])->name('m.emp.roles.edit');
    Route::post('/m-emp/roles/delete', [OfficeRoleController::class, 'delete_role'])->name('m.emp.roles.del');
    Route::post('/m-emp/roles/reset', [OfficeRoleController::class, 'reset_role'])->name('m.emp.roles.reset');
    Route::post('/m-emp/roles/role/load', [OfficeRoleController::class, 'get_role'])->name('m.emp.roles.getrole');
    // Route::get('/m-emp/roles/role/load', [OfficeRoleController::class, 'get_role'])->name('m.emp.roles.getrole');
});


Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/m-emp/teams', [EngTeamController::class, 'index'])->name('m.emp.teams');
    Route::post('/m-emp/teams/add', [EngTeamController::class, 'add_team'])->name('m.emp.teams.add');
    Route::post('/m-emp/teams/edit', [EngTeamController::class, 'edit_team'])->name('m.emp.teams.edit');
    Route::post('/m-emp/teams/delete', [EngTeamController::class, 'delete_team'])->name('m.emp.teams.del');
    Route::post('/m-emp/teams/reset', [EngTeamController::class, 'reset_team'])->name('m.emp.teams.reset');
    Route::post('/m-emp/teams/team/load', [EngTeamController::class, 'get_team'])->name('m.emp.teams.getteam');
    // Route::get('/m-emp/teams/team/load', [EngTeamController::class, 'get_team'])->name('m.emp.teams.getteam');

    Route::get('/m-emp/teams/team/load-select-opt', [EngTeamController::class, 'load_select_opt'])->name('m.emp.teams.loadopt');
    Route::post('/m-emp/teams/team/unassign', [EngTeamController::class, 'un_assign_4rom_team'])->name('m.emp.teams.unassign');
    Route::post('/m-emp/teams/team/assign', [EngTeamController::class, 'assign_into_team'])->name('m.emp.teams.assign');

});



Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/m-emp/teams/team/populate-team-table/loademplists', [EngTeamController::class, 'load_employee_lists_byajax'])->name('m.emp.teams.load.emplists');
    Route::get('/m-emp/teams/team/populate-team-table/loadteamlists', [EngTeamController::class, 'load_teams_lists_byajax'])->name('m.emp.teams.load.teamlists');
    Route::get('/m-emp/teams/team/populate-team-table/detect-db-team-assigment-changes/{modelType}', [EngTeamController::class, 'detect_db_team_assigment_ch_byajax'])->name('m.emp.teams.detect.chg');
    // Route::get('/m-emp/teams/team/populate-team-table', [EngTeamController::class, 'populate_tb_team_byajax'])->name('m.emp.teams.pop.tb');
    // Route::get('/m-emp/teams/team/populate-team-table/loademplists/opt', [EngTeamController::class, 'load_employee_lists_opt_byajax'])->name('m.emp.teams.load.emplistsopt');
});

Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/m-emp/teams/team/detect-db-changes', [EngTeamController::class, 'detectDBChangesByAjax'])->name('m.emp.teams.detchg');
    Route::get('/m-emp/teams/team/populate-team-table', [EngTeamController::class, 'getTeamsByAjax'])->name('m.emp.teams.poptb');
});



Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    // Route::get('', [ProjectsController::class, 'index'])->name('m.projects');
    Route::post('/projects/add', [ProjectsController::class, 'add_project'])->name('m.projects.add');
    Route::post('/projects/edit', [ProjectsController::class, 'edit_project'])->name('m.projects.edit');
    Route::post('/projects/delete', [ProjectsController::class, 'delete_project'])->name('m.projects.del');
    Route::post('/projects/reset', [ProjectsController::class, 'reset_project'])->name('m.projects.reset');
    // Route::post('/projects/load', [ProjectsController::class, 'get_project'])->name('m.projects.getprj');
    // Route::get('/projects/load', [ProjectsController::class, 'get_project'])->name('m.projects.getprj');
    Route::match(['get', 'post'], '/projects/load', [ProjectsController::class, 'get_project'])->name('m.projects.getprj');
    // Route::post('/projects/load4add', [ProjectsController::class, 'get_project_4add'])->name('m.projects.getprj4add');
    // Route::get('/projects/load4add', [ProjectsController::class, 'get_project_4add'])->name('m.projects.getprj4add');
    Route::match(['get', 'post'], '/projects/load4add', [ProjectsController::class, 'get_project_4add'])->name('m.projects.getprj4add');
    Route::get('/projects/loadmondws', [ProjectsController::class, 'get_prjmondws'])->name('m.projects.getprjmondws');
    Route::get('/projects/navigate', [WorksheetController::class, 'index'])->name('m.ws');
    Route::post('/projects/sh-to-client', [ProjectsController::class, 'up_show_toclient'])->name('m.projects.modprj.sh2cl');
});


Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    // Route::post('/projects/m-monitoring-worksheet/mondws', [MonitoringController::class, 'index'])->name('m.mon.dws');
    Route::post('/projects/m-monitoring-worksheet/mondws/uor', [MonitoringController::class, 'update_order'])->name('m.mon.dws.uor');
    Route::post('/projects/m-monitoring-worksheet/mon/add', [MonitoringController::class, 'add_mon'])->name('m.mon.add');
    Route::post('/projects/m-monitoring-worksheet/mon/delete', [MonitoringController::class, 'delete_mon'])->name('m.mon.del');
    Route::post('/projects/m-monitoring-worksheet/mon/reset', [MonitoringController::class, 'reset_mon'])->name('m.mon.reset');
    Route::post('/projects/m-monitoring-worksheet/mon/edit', [MonitoringController::class, 'edit_mon'])->name('m.mon.edit');
    Route::post('/projects/m-monitoring-worksheet/mon/load', [MonitoringController::class, 'get_mon'])->name('m.mon.getmon');

    // Route::post('/projects/m-monitoring-worksheet/mon/print-dom-pdf', [MonitoringController::class, 'print_mon'])->name('m.mon.printdommon');
    Route::match(['get', 'post'], '/projects/m-monitoring-worksheet/mon/print-dom-pdf', [MonitoringController::class, 'print_mon'])->name('m.mon.printdommon');
    Route::post('/projects/m-monitoring-worksheet/mon/save-dom-pdf', [MonitoringController::class, 'save_mon'])->name('m.mon.savedommon');
});

Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    // Route::get('/m-monitoring-worksheet/prj/getlockunlock', [ProjectsController::class, 'get_prj_4lockunlock'])->name('m.ws.getprj4lockunlock');
    Route::post('/projects/m-monitoring-worksheet/prj/getlockunlock', [ProjectsController::class, 'get_prj_4lockunlock'])->name('m.ws.getprj4lockunlock');
    Route::post('/projects/m-monitoring-worksheet/prj/lock', [ProjectsController::class, 'lock_prj'])->name('m.prj.status.lock');
    Route::post('/projects/m-monitoring-worksheet/prj/unlock', [ProjectsController::class, 'unlock_prj'])->name('m.prj.status.unlock');
    Route::post('/projects/m-monitoring-worksheet/ws/add', [WorksheetController::class, 'add_ws'])->name('m.ws.add');
    Route::post('/projects/m-monitoring-worksheet/ws/delete', [WorksheetController::class, 'delete_ws'])->name('m.ws.del');
    Route::post('/projects/m-monitoring-worksheet/ws/reset', [WorksheetController::class, 'reset_ws'])->name('m.ws.reset');
    Route::post('/projects/m-monitoring-worksheet/ws/edit', [WorksheetController::class, 'edit_ws'])->name('m.ws.edit');
    Route::post('/projects/m-monitoring-worksheet/ws/mark-edit', [WorksheetController::class, 'edit_mark_ws'])->name('m.ws.remark.edit');
    Route::post('/projects/m-monitoring-worksheet/ws/load', [WorksheetController::class, 'get_ws'])->name('m.ws.getws');
    // Route::get('/m-monitoring-worksheet/ws/load', [WorksheetController::class, 'get_ws'])->name('m.ws.getws');
    Route::post('/projects/m-monitoring-worksheet/ws/getlockunlock', [WorksheetController::class, 'get_ws_4lockunlock'])->name('m.ws.getws4lockunlock');
    Route::post('/projects/m-monitoring-worksheet/ws/lock', [WorksheetController::class, 'lock_ws'])->name('m.ws.status.lock');
    Route::post('/projects/m-monitoring-worksheet/ws/unlock', [WorksheetController::class, 'unlock_ws'])->name('m.ws.status.unlock');
    Route::post('/projects/m-monitoring-worksheet/ws/sulock', [WorksheetController::class, 'su_lock_ws'])->name('m.ws.status.su.lock');
    Route::post('/projects/m-monitoring-worksheet/ws/sunlock', [WorksheetController::class, 'su_unlock_ws'])->name('m.ws.status.su.unlock');
});

Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::post('/projects/m-monitoring-worksheet/ws/task/add', [TaskController::class, 'add_task'])->name('m.task.add');
    Route::post('/projects/m-monitoring-worksheet/ws/task/delete', [TaskController::class, 'delete_task'])->name('m.task.del');
    Route::post('/projects/m-monitoring-worksheet/ws/task/reset', [TaskController::class, 'reset_task'])->name('m.task.reset');
    Route::post('/projects/m-monitoring-worksheet/ws/task/edit', [TaskController::class, 'edit_task'])->name('m.task.edit');
    // Route::post('/projects/m-monitoring-worksheet/ws/task/load', [TaskController::class, 'get_task'])->name('m.task.gettask');
    // Route::get('/projects/m-monitoring-worksheet/ws/task/load', [TaskController::class, 'get_task'])->name('m.task.gettask');
    // // Route::get('/m-monitoring-worksheet/ws/task/load', [TaskController::class, 'get_task'])->name('m.task.gettask');
    Route::match(['get', 'post'], '/projects/m-monitoring-worksheet/ws/task/load', [TaskController::class, 'get_task'])->name('m.task.gettask');
    // Route::post('/projects/m-monitoring-worksheet/ws/task/print-dom-pdf', [TaskController::class, 'print_task'])->name('m.task.printdomtask');
    Route::match(['get', 'post'], '/projects/m-monitoring-worksheet/ws/task/print-dom-pdf', [TaskController::class, 'print_task'])->name('m.task.printdomtask');
    Route::post('/projects/m-monitoring-worksheet/ws/task/save-dom-pdf', [TaskController::class, 'save_task'])->name('m.task.savedomtask');

});



Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/m-cli', [ClientController::class, 'index'])->name('m.cli');
    Route::post('/m-cli/add', [ClientController::class, 'add_client'])->name('m.cli.add');
    Route::post('/m-cli/edit', [ClientController::class, 'edit_client'])->name('m.cli.edit');
    Route::post('/m-cli/delete', [ClientController::class, 'delete_client'])->name('m.cli.del');
    Route::post('/m-cli/reset', [ClientController::class, 'reset_client'])->name('m.cli.reset');
    Route::post('/m-cli/load', [ClientController::class, 'get_client'])->name('m.cli.getcli');
    // Route::get('/m-cli/load', [ClientController::class, 'get_client'])->name('m.cli.getcli');
});



Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/m-emp/user-accounts', [EmpUserLoginController::class, 'index'])->name('m.user.emp');
    Route::post('/m-emp/user-accounts/add', [EmpUserLoginController::class, 'add_user'])->name('m.user.emp.add');
    Route::post('/m-emp/user-accounts/edit', [EmpUserLoginController::class, 'edit_user'])->name('m.user.emp.edit');
    Route::post('/m-emp/user-accounts/delete', [EmpUserLoginController::class, 'delete_user'])->name('m.user.emp.del');
    Route::post('/m-emp/user-accounts/reset', [EmpUserLoginController::class, 'reset_user'])->name('m.user.emp.reset');
    Route::post('/m-emp/user-accounts/load', [EmpUserLoginController::class, 'get_user'])->name('m.user.emp.getuser');

});

Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/m-cli/user-accounts', [ClientUserLoginController::class, 'index'])->name('m.user.cli');
    Route::post('/m-cli/user-accounts/add', [ClientUserLoginController::class, 'add_user'])->name('m.user.cli.add');
    Route::post('/m-cli/user-accounts/edit', [ClientUserLoginController::class, 'edit_user'])->name('m.user.cli.edit');
    Route::post('/m-cli/user-accounts/delete', [ClientUserLoginController::class, 'delete_user'])->name('m.user.cli.del');
    Route::post('/m-cli/user-accounts/reset', [ClientUserLoginController::class, 'reset_user'])->name('m.user.cli.reset');
    Route::post('/m-cli/user-accounts/load', [ClientUserLoginController::class, 'get_user'])->name('m.user.cli.getuser');
    // Route::get('/m-cli/user-accounts/load', [ClientUserLoginController::class, 'get_user'])->name('m.user.cli.getuser');

});


Route::middleware(['auth', CheckRememberToken::class])->group(function () {
    Route::get('/system/settings', [SystemSettingsController::class, 'index'])->name('m.sys');
    Route::post('/system/settings/sh-reg', [SystemSettingsController::class, 'sh_reg_val_sett'])->name('m.sys.sh.chg.valreg');
    // Route::post('/system/settings/sh-reg-emp', [SystemSettingsController::class, 'sh_reg_emp'])->name('m.sys.sh.regemp');
});



//////////////////////////////////////////////// <<<  END: ROUTES (WITH USERGROUP) >>> ///////////////////////////////////////////

