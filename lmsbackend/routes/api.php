<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassSectionController;
use App\Http\Controllers\SectionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//Public Routes
//Define routes for Login
Route::post('/login', [AuthController::class, 'login']);


//Private Routes
Route::group(['middleware' => ['auth:sanctum']], function () {



    // Define routes for the Logout,Register
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);


    // Define routes for the UserController
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::get('/users/search/{username}', [UserController::class, 'search']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Define routes for the AttendanceController
    Route::get('/attendances', [AttendanceController::class, 'index']);
    Route::get('/attendances/{id}', [AttendanceController::class, 'show']);
    Route::post('/attendances', [AttendanceController::class, 'store']);
    Route::put('/attendances/{id}', [AttendanceController::class, 'update']);
    Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy']);

    // Define routes for the ClassesController
    Route::get('/classes', [ClassesController::class, 'index']);
    Route::get('/classes/{id}', [ClassesController::class, 'show']);
    Route::get('/classes/search/{class_name}', [ClassesController::class, 'search']);
    Route::post('/classes', [ClassesController::class, 'store']);
    Route::put('/classes/{id}', [ClassesController::class, 'update']);
    Route::delete('/classes/{id}', [ClassesController::class, 'destroy']);

    // Define routes for the SectionController
    Route::get('/sections', [SectionsController::class, 'index']);
    Route::get('/sections/{id}', [SectionsController::class, 'show']);
    Route::get('/sections/search/{section_name}', [SectionsController::class, 'search']);
    Route::post('/sections', [SectionsController::class, 'store']);
    Route::put('/sections/{id}', [SectionsController::class, 'update']);
    Route::delete('/sections/{id}', [SectionsController::class, 'destroy']);

    // Define routes for the ClassSectionController
    Route::get('/classsections', [ClassSectionController::class, 'index']);
    Route::get('/classsections/{id}', [ClassSectionController::class, 'show']);
    Route::post('/classsections', [ClassSectionController::class, 'store']);
    Route::put('/classsections/{id}', [ClassSectionController::class, 'update']);
    Route::delete('/classsections/{id}', [ClassSectionController::class, 'destroy']);




});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});