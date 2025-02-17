<?php

use App\Http\Controllers\DealController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SuperAdmin\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\TeamController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\CurrencyController;
use App\Http\Controllers\SuperAdmin\PermissionController;
use App\Http\Controllers\VisibilityGroupController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // for logout
    Route::post('/logout',[LoginController::class,'logout']);

    /*-------------------------------- permissions route ------------------------------------ */

    // for permissions
    Route::get('permissions', [PermissionController::class, 'index']);
    Route::post('permissions/store', [PermissionController::class, 'store']);
    Route::get('permissions/edit/{id}', [PermissionController::class, 'edit']);
    Route::post('permissions/update/{id}', [PermissionController::class, 'update']);
    Route::get('permissions/delete/{id}', [PermissionController::class, 'deletePermission']);
    // ends here

    /*-------------------------------- permissions route end ------------------------------------ */

    
    /*-------------------------------- roles route ------------------------------------ */
    // for roles
    Route::get('roles', [RoleController::class, 'index']);
    Route::post('roles/store', [RoleController::class, 'store']);
    Route::get('roles/edit/{id}', [RoleController::class, 'edit']);
    Route::post('roles/update/{id}', [RoleController::class, 'update']);
    Route::get('roles/delete/{id}', [RoleController::class, 'destroy']);
    /*-------------------------------- roles route end ------------------------------------ */


    /*-------------------------------- user route ------------------------------------ */
    // for user management
    Route::get('users', [UserController::class, 'index']);
    Route::get('/users/details/{id}', [UserController::class, 'show']);
    Route::post('/users/store', [UserController::class, 'store']);
    Route::get('/users/edit/{id}', [UserController::class, 'edit']);
    Route::post('/users/update/{id}', [UserController::class, 'update']);
    Route::get('/users/delete/{id}', [UserController::class, 'destroy']);
    Route::get('/users/{id}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assignRoles');
    Route::put('/users/{id}/update-roles', [UserController::class, 'updateRoles'])->name('users.updateRoles');

    /*-------------------------------- users route end ------------------------------------ */

    
    /*-------------------------------- team route ------------------------------------ */
    // for team management
    Route::get('teams', [TeamController::class, 'index']);
    Route::post('/teams/store', [TeamController::class, 'store']);
    Route::get('teams/{id}/show-members', [TeamController::class, 'show']);
    Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('teams.members');
    Route::put('/teams/{id}/update', [TeamController::class, 'update']);
    Route::post('/teams/{teamId}/add-members', [TeamController::class, 'addMembersToTeam']);
    Route::post('/teams/toggle-status/{id}', [TeamController::class, 'toggleStatus']);
    Route::delete('/teams/{id}/delete',[TeamController::class,'destroy']);

    /*-------------------------------- team route end ------------------------------------ */

   
   
    /*-------------------------------- currency route ------------------------------------ */
    // for currency management
    Route::get('currencies', [CurrencyController::class, 'index']);
    Route::post('currencies/store', [CurrencyController::class, 'store']);
    Route::get('currencies/{id}/edit', [CurrencyController::class, 'edit']);
    Route::put('currencies/{id}/update', [CurrencyController::class, 'update']);
    Route::get('currencies/{id}/show', [CurrencyController::class, 'show']);
    Route::get('currencies/{id}/delete', [CurrencyController::class, 'destroy']);

    /*-------------------------------- currency route end ------------------------------------ */

    
    /*-------------------------------- plans route ------------------------------------ */
    // for plan management
    Route::get('plans', [PlanController::class, 'index']);
    Route::post('plans/store', [PlanController::class, 'store']);
    Route::get('plans/{id}/edit', [PlanController::class, 'edit']);
    Route::put('plans/{id}/update', [PlanController::class, 'update']);
    Route::get('plans/{id}/show', [PlanController::class, 'show']);
    Route::get('plans/{id}/delete', [PlanController::class, 'destroy']);
    /*-------------------------------- plans route end ------------------------------------ */


   
    /*-------------------------------- visibility groups route ------------------------------------ */
    // for managing visibility_groups
    Route::get('visibility_groups', [VisibilityGroupController::class, 'index']);
    Route::post('visibility_groups/store', [VisibilityGroupController::class, 'store']);
    Route::get('visibility_groups/{id}/edit', [VisibilityGroupController::class, 'edit']);
    Route::put('visibility_groups/{id}/update', [VisibilityGroupController::class, 'update']);
    Route::get('visibility_groups/{id}/show', [VisibilityGroupController::class, 'show']);
    Route::get('visibility_groups/{id}/delete', [VisibilityGroupController::class, 'destroy']);
    Route::post('assign-user/{id}', [VisibilityGroupController::class, 'addUser'])->name('assign-user');

    // removing user
    Route::delete('/visibility-groups/{groupid}/users/{userid}', [VisibilityGroupController::class, 'removeUser'])
    ->name('visibility_groups.remove_user');

    /*-------------------------------- visibility groups route end ------------------------------------ */

    
    /*-------------------------------- leads route ------------------------------------ */
    Route::get('leads', [LeadController::class, 'index']);
    Route::post('leads/store', [LeadController::class, 'store']);
    Route::get('leads/{id}/edit', [LeadController::class, 'edit']);
    Route::put('leads/{id}/update', [LeadController::class, 'update']);
    Route::get('leads/{id}/delete', [LeadController::class, 'destroy']);

    // Route::get('/leads/{leadid}/assign-group', [LeadController::class, 'assignGroupForm'])->name('leads.assignGroupForm');
    // Route::post('/leads/{leadid}/assign-group', [LeadController::class, 'assignGroup'])->name('leads.assignGroup');

    /*-------------------------------- leads route end ------------------------------------ */

    
    /*-------------------------------- deals route ------------------------------------ */
    Route::get('deals', [DealController::class, 'index']);
    Route::post('deals/store', [DealController::class, 'store']);
    Route::get('deals/{id}/edit', [DealController::class, 'edit']);
    Route::put('deals/{id}/update', [DealController::class, 'update']);
    Route::get('deals/{id}/delete', [DealController::class, 'destroy']);

    // Route::get('/deals/{dealid}/assign-group', [DealController::class, 'assignGroupForm'])->name('deal.assignGroupForm');
    // Route::post('/deals/{dealid}/assign-group', [DealController::class, 'assignGroup'])->name('deal.assignGroup');

    /*-------------------------------- deals route end ------------------------------------ */
});
