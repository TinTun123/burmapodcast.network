<?php

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/audio/{file}', function ($file) {
//     $filePath = public_path('audio/' . $file);
//     $mimeType = mime_content_type($filePath);
//     $contentLength = filesize($filePath);
//     return response()->file($filePath, [
//         'Content-Type' => $mimeType,
//         'Content-Length' => $contentLength,
//         'Accept-Ranges' => 'bytes'
//     ]);
// });

Route::get('/{any}', function () {
    return file_get_contents(public_path('index.html'));
})->where('any', '.*');