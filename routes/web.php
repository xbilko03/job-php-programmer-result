<?php

use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/{toolType}', [ManagerController::class, 'showTools']);
Route::get('/{toolType}/{toolName}', [ManagerController::class, 'showToolFeatures']);
Route::post('/{toolType}/{toolName}/action', [ManagerController::class, 'toolExecute']);
Route::get('/{toolType}/{toolName}/action', function ($toolType, $toolName) { return redirect("/$toolType/$toolName");});

Route::get('/', [ManagerController::class, 'gotoMenu']);
