<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\PassportController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



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
/**
 * test for permission
 */
Route::get('/test',function(){
    $role = Role::create(['name' => 'writer']);
    $permission = Permission::create(['name' => 'edit articles']);
});

/**
 *  Note for middleware
 *  - I have EnsureTrialIsvalid middleare and register is to kernel php as global middleware.
 *  - you can use it middleware('trial')
 */



Route::fallback(function(){
        return response()->json([
        'message' => 'Page Not Found. If error persists, contact bayramyilmaz061@gmail.com'], 404);
});

Route::middleware(['auth:api','trial'])->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
       // return new UserResource(User::find($request->user()->id));
    });

    Route::get('/todos',[TodosController::class,'index']);
    Route::post('/todos',[TodosController::class,'store']);
    Route::patch('/todos/{todo}',[TodosController::class,'update']);
    Route::patch('/todosCheckAll',[TodosController::class,'updateAll']);
    Route::delete('/todos/{todo}',[TodosController::class,'destroy']);
    Route::delete('/todosDeleteCompleted',[TodosController::class,'destroyCompleted']);

    Route::middleware('auth:api')->post('/logout', [AuthController::class,'logout']);
});

    // this route for to add extra item to Passport response.
    Route::post('/auth', [PassportController::class,'auth']);
    // Login and Register
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']);
