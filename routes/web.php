<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

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

Route::get("/", [MainController::class, "index"])->name("index");

Route::get("/annual-reports", [MainController::class, "annual_reports"])->name("annual_reports");

Route::get("/reports", [MainController::class, "reports"])->name("reports");

Route::get("/gallerys", [MainController::class, "gallerys"])->name("gallerys");

Route::get("/gallery/{id}-{slug}", [MainController::class, "gallery"])->name("gallery");

Route::get("/about", [MainController::class, "about"])->name("about");
