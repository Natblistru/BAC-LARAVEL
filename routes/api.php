<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeLearningProgramController;
use App\Http\Controllers\LearningProgramController;
use App\Http\Controllers\TeacherTopicController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["namespace"=> "App\Http\Controllers"], function() {
    Route::apiResource("chapters", ChapterController::class);
});
Route::group(["namespace"=> "App\Http\Controllers"], function() {
    Route::apiResource("subject_study_levels", SubjectStudyLevelController::class);
});

Route::get('/capitoleDisciplina', [ThemeLearningProgramController::class, "capitoleDisciplina"]);

Route::get('/disciplineani', [LearningProgramController::class, "disciplineAni"]);

Route::get('/teachertheme', [TeacherTopicController::class, "teacherTheme"]);
