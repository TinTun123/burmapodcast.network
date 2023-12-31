<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\VerificationController;
use App\Models\Episode;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
Route::get('/show', [ShowController::class, 'getShows'])->middleware('cache');
Route::get('/show/{id}', [ShowController::class, 'getEpisode'])->middleware('cache');
Route::get('/forum', [ForumController::class, 'getForum']);
Route::get('/comments/{episodeId}', [ForumController::class, 'getComments'])->where(['episodeId' => '[0-9]+']);
Route::get('/latestEpisode', [ShowController::class, 'getLatest']);
Route::get('/mostlistenEpisode', [ShowController::class, 'getMostListen']);

Route::post('audience', [AuthController::class, 'addAudience']);
Route::post('/answer/{forumId}', [ForumController::class, 'createAnswer'])->where(['forumId' => '[0-9]+']);
Route::post('/reply/{id}', [ForumController::class, 'createReply'])->where(['id' => '[0-9]+']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('comment/{episodeId}', [ForumController::class, 'createComment'])->where(['episodeId' => '[0-9]+']);
Route::post('likeEpisode/{episodeId}/{audience}', [ShowController::class, 'likeEpisode'])->where(['episodeId' => '[0-9]+']);


Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [AuthController::class, 'resend'])->name('verification.resend');

Route::post('forgotPwd', [AuthController::class, 'sendResetPwdEmail']);
Route::post('resetPwd', [AuthController::class, 'reset']);

Route::get('/search', [ShowController::class, 'search']);
Route::get('/listen/{episode}', [ShowController::class, 'listen']);
Route::get('/recordDownload/{episodeId}/{showId}/{audienceId}', [ShowController::class, 'recordDownload']);
Route::get('/recordShare/{episodeId}/{showId}/{audienceId}', [ShowController::class, 'recordShare']);
Route::get('/users', [AuthController::class, 'getUsers']);
Route::get('/searchByHost', [ShowController::class, 'searchByHost']);
Route::get('/getURLS', [ShowController::class, 'getURLS']);
Route::get('/addPlatform', [ShowController::class, 'addPlatform']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/saveURL', [ShowController::class, 'saveURL']);
    Route::put('/show/{id}', [ShowController::class, 'editShow']);
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/show/createShow', [ShowController::class, 'createShow']);    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/updateUser/{user}', [AuthController::class, 'update']);
    Route::delete('deleteUser/{user}', [AuthController::class, 'delete']);
    Route::delete('/reply/{replyId}', [ForumController::class, 'deleteReply'])->where(['replyId' => '[0-9]+']);
    Route::post('/show/createEpisode/{id}', [ShowController::class, 'createEpisode']);
    Route::put('/show/editEpisode/{showId}/{episodeId}', [ShowController::class, 'editEpisode']);
    Route::delete('/show/deleteShow/{showId}', [ShowController::class, 'deleteShow'])->where(['showId' => '[0-9]+']);
    Route::delete('forum/{forumId}', [ForumController::class, 'deleteForum'])->where(['forumId' => '[0-9]+']);
    Route::delete('/show/{epid}', [ShowController::class, 'deleteEpisode']);
    Route::delete('/answer/{answerId}', [ForumController::class, 'deleteAnswer'])->where(['answerId' => '[0-9]+']);
    Route::delete('/comment/{commentId}', [ForumController::class, 'deleteComment'])->where(['commentId' => '[0-9]+']);
    Route::post('/forum', [ForumController::class, 'addForum']);
    Route::put('/forum/{forum}', [ForumController::class, 'editForum']);
    Route::get('/fetchAdminShows', [ShowController::class, 'getAdminShows']);
    Route::get('/fetchAdminEpisodes/{id}', [ShowController::class, 'adminGetEpisodes']);
    Route::get('/fetchLog', [AuthController::class, 'getLog']);

    Route::get('/getStatisticByWeek/{episodeId}/{showId}', [StatisticController::class, 'getDataByWeek']);
    Route::get('/getStatisticByMonth/{episodeId}/{showId}', [StatisticController::class, 'getDataByMonth']);
    Route::get('/getStatisticByYear/{episodeId}/{showId}', [StatisticController::class, 'getDataByYear']);
    Route::get('/getStatisticByGeo/{episodeId}/{showId}', [StatisticController::class, 'getDataByGeo']);
    Route::post('/saveSpotifyUrl', [ShowController::class, 'saveSpotify']);
    Route::post('/editSpotify/{platform}', [ShowController::class, 'editSpotify']);
    Route::delete('deleteSpotify/{platform}', [ShowController::class, 'deleteSpotify']);
    Route::get('/getShowData/{show}', [StatisticController::class, 'getShowData']);
    
});


