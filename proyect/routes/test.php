<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\OneSignalAlertController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::view('test', 'testing.vista1');

    Route::get('testMP', [OneSignalAlertController::class, 'alertOneSiganlFirst']);

    Route::get('envio/test', [MailController::class, 'envio'])->name('envio.test');
    Route::get('envio/campana', [TestController::class, 'enviarNotificacion']);
});

?>