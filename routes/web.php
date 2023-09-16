<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/storage/audio/{epiId}/{file}', function ($file) {
    $filePath = public_path('audio/' . $file);

    if (!file_exists($filePath)) {
        Log::info('web php', [
            'Audio file not found',
            'file' => $file,
        ]);

        return Response::make('Audio file not found', 404);
    }

    $mimeType = mime_content_type($filePath);

    $contentLength = filesize($filePath);

    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Content-Length' => $contentLength,
        'Accept-Ranges' => 'bytes'
    ])->setStatusCode(200);
});

Route::get('/check-audio-existence/{epiId}/{file}', function ($epiId, $file) {
    $filePath = 'audio/' . $file;
    $exists = Storage::disk('public')->exists($filePath);

    return response()->json(['exists' => $exists]);
});

Route::get('/{any}', function () {
    return file_get_contents(public_path('index.html'));
})->where('any', '.*');