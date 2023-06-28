<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SentMessageController;


Route::post('/listings/{id}',[SentMessageController::class,'store']);
