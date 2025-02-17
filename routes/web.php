<?php

use App\Http\Controllers\DealController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\TeamController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\CurrencyController;
use App\Http\Controllers\SuperAdmin\PermissionController;
use App\Http\Controllers\VisibilityGroupController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('roles/delete/{id}', [PermissionController::class, 'destroy'])->name('roles.delete');
    Route::resource('roles', RoleController::class);

    Route::get('permissions/delete/{id}', [PermissionController::class, 'deletePermission'])->name('delete');

    Route::resource('permissions', PermissionController::class);


    Route::get('/users/{id}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assignRoles');
    Route::put('/users/{id}/update-roles', [UserController::class, 'updateRoles'])->name('users.updateRoles');
    Route::resource('users', UserController::class);

    Route::get('/teams/{team}/members', [TeamController::class, 'showMembers'])->name('teams.members');
    Route::post('/teams/{team}/add-member', [TeamController::class, 'addMembersToTeam'])->name('teams.addMembers');



    Route::resource('teams', TeamController::class);
    Route::post('/teams/toggle-status/{id}', [TeamController::class, 'toggleStatus'])->name('toggle.team.status');





    Route::resource('currencies', CurrencyController::class);

    Route::resource('plans', PlanController::class);




    Route::resource('visibility_groups', VisibilityGroupController::class);
    Route::post('assign-user/{id}', [VisibilityGroupController::class, 'addUser'])->name('assign-user');

    Route::delete('/visibility-groups/{groupid}/users/{userid}', [VisibilityGroupController::class, 'removeUser'])
    ->name('visibility_groups.remove_user');

    // remove multiple users
    Route::delete('/visibility-groups/{group}/users', [VisibilityGroupController::class, 'removeMultipleUsers'])
    ->name('visibility_groups.remove_multiple_users');





    // Route::get('/leads/{leadid}/assign-group', [LeadController::class, 'assignGroupForm'])->name('leads.assignGroupForm');
    // Route::post('/leads/{leadid}/assign-group', [LeadController::class, 'assignGroup'])->name('leads.assignGroup');
    Route::resource('leads', LeadController::class);

    // Route::get('/deals/{dealid}/assign-group', [DealController::class, 'assignGroupForm'])->name('deal.assignGroupForm');
    // Route::post('/deals/{dealid}/assign-group', [DealController::class, 'assignGroup'])->name('deal.assignGroup');
    Route::resource('deals', DealController::class);
});
