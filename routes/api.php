<?php

use App\Http\Controllers\API\ActivityController;
use App\Http\Controllers\API\AnnualReportController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CourrierController;
use App\Http\Controllers\API\CourrierResponseController;
use App\Http\Controllers\API\EntityController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\FormularController;
use App\Http\Controllers\API\FormularParticipantController;
use App\Http\Controllers\API\FormularQuizController;
use App\Http\Controllers\API\FormularResponseController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\GalleryFileController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\OrganeController;
use App\Http\Controllers\API\ParticipantController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ProjectPartnerController;
use App\Http\Controllers\API\SubActivityController;
use App\Http\Controllers\API\SurveyController;
use App\Http\Controllers\API\SurveyItemController;
use App\Http\Controllers\API\SurveyVoteController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->controller(AuthController::class)->group(function () {

    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('logout', 'logout');
    Route::post('forgot-password', 'forgot_password');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');

    Route::post('update-password', [AuthController::class, "update_password"]);

});


Route::get('unauthentized', [AuthController::class, "unauthentized"])->name("unauthentized");

Route::get("/seed", [AuthController::class, "seed"]);


/**************** PROJECT ***************** */

Route::middleware("authapi:api")->group(function() {

    Route::apiResource("messages", MessageController::class);

    Route::get("/notifications", [MessageController::class, "notifications"]);

    Route::middleware("authentity:cdn")->group(function() {

        Route::apiResource("categories", CategoryController::class);

        Route::apiResource("organes", OrganeController::class);

        Route::apiResource("users", UserController::class);

        Route::apiResource("entities", EntityController::class);


        Route::apiResource("projects", ProjectController::class);

        Route::apiResource("project-patners", ProjectPartnerController::class);

        Route::apiResource("activities", ActivityController::class);

        Route::post("/activities/{id}/status", [ActivityController::class, "status"]);

        Route::apiResource("/sub-activities", SubActivityController::class);

        Route::post("/sub-activities/{id}/status", [SubActivityController::class, "status"]);


        Route::apiResource("events", EventController::class);

        Route::get("events/{id}/send-reminder", [EventController::class, "send_reminder"]);

        Route::apiResource("participants", ParticipantController::class);

        Route::apiResource("surveys", SurveyController::class);

        Route::get("surveys/{id}/publish", [SurveyController::class, "publish"]);

        Route::apiResource("survey-items", SurveyItemController::class);

        Route::apiResource("formulars", FormularController::class);

        Route::apiResource("formular-participants", FormularParticipantController::class);

        Route::get("formulars/{id}/publish", [FormularController::class, "publish"]);

        Route::apiResource("formular-quizzes", FormularQuizController::class);

        Route::apiResource("courriers", CourrierController::class);

        Route::apiResource("courrier-responses", CourrierResponseController::class);

        Route::apiResource("gallerys", GalleryController::class);

        Route::apiResource("gallery-files", GalleryFileController::class);

        Route::apiResource("annual-reports", AnnualReportController::class);

    });


    Route::middleware("authentity:sector_patner")->group(function() {

        Route::get("general/surveys", [SurveyController::class, "sector_index"]);

        Route::get("general/surveys/{id}", [SurveyController::class, "sector_show"]);

        Route::get("surveys/{id}/public", [SurveyController::class, "public_survey"]);

        Route::apiResource("survey-votes", SurveyVoteController::class);

        // Route::apiResource("general/survey-votes", SurveyVoteController::class);


        Route::get("general/formulars", [FormularController::class, "sector_index"]);

        Route::get("general/formulars/{id}", [FormularController::class, "sector_show"]);

        Route::apiResource("general/formular-responses", FormularResponseController::class);



        Route::get("general/courriers", [CourrierController::class, "general_index"]);

        Route::get("general/courriers/{id}", [CourrierController::class, "general_show"]);



    });






    Route::middleware("authentity:sector")->group(function() {

        Route::get("sector/projects", [ProjectController::class, "sector_index"]);

        Route::get("sector/projects/{id}", [ProjectController::class, "sector_show"]);

        Route::get("sector/projects/{id}/publish", [ProjectController::class, "sector_publish"]);

        Route::get("sector/activities", [ActivityController::class, "sector_index"]);

        Route::get("sector/activities/{id}", [ActivityController::class, "sector_show"]);

        Route::apiResource("sector/activities", ActivityController::class)->except(["show"]);

        Route::post("sector/activities/{id}/report", [ActivityController::class, "sector_report"]);

        Route::get("sector/activities/{id}/publish", [ActivityController::class, "sector_publish"]);

        Route::get("sector/activities/{id}/report-publish", [ActivityController::class, "sector_report_publish"]);

        Route::apiResource("sector/sub-activities", SubActivityController::class);

        Route::post("sector/sub-activities/{id}/report", [SubActivityController::class, "sector_report"]);


        Route::get("sector/gallerys", [GalleryController::class, "sector_index"]);

        Route::get("sector/gallerys/{id}", [GalleryController::class, "sector_show"]);

        Route::apiResource("gallerys", GalleryController::class)->only(["store"]);

        Route::apiResource("gallery-files", GalleryFileController::class);




        Route::get("sector/annual-reports", [AnnualReportController::class, "sector_index"]);

        Route::apiResource("annual-reports", AnnualReportController::class)->only(['store']);

    });






    Route::middleware("authentity:patner")->group(function() {

        Route::get("patner/projects", [ProjectController::class, "patner_index"]);

        Route::get("patner/projects/{id}", [ProjectController::class, "patner_show"]);

        Route::apiResource("patner/activities", ActivityController::class);

        Route::apiResource("patner/sub-activities", SubActivityController::class);
    });




});
