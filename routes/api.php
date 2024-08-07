<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ToDoListController;

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

Route::middleware('api')->group(function () {
    Route::post('/todolist', [ToDoListController::class, 'store']);
    Route::get('/todolist', [ToDoListController::class, 'show']);
    Route::put('/todolist/{id}', [ToDoListController::class, 'update']);
    Route::delete('/todolist/{id}', [ToDoListController::class, 'delete']);
});
