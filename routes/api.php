<?php
use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Only admins can access these routes
Route::group(['middleware' => ['role:Admin']], function () {
    Route::delete('blogs/{id}', [BlogController::class, 'destroy']); // Admin can delete
});

// Authors and Admins can add and edit posts
Route::group(['middleware' => ['role:Author|Admin']], function () {
    Route::post('blogs', [BlogController::class, 'store']); // Create new blog post
    Route::put('blogs/{id}', [BlogController::class, 'update']); // Edit blog post
});

//view posts
Route::get('blogs', [BlogController::class, 'index']);
