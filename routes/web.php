<?php

use App\Http\Controllers\testController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/game-1',function (){
   return view('NumberGuessingGame');
});
Route::get('/game-2',function (){
   return view('checkers');
});
Route::get('/game-3',function (){
    return view('flappy-bird');
});
Route::get('/game-4',function (){
    return view('XO');
});
Route::get('/game-5',function (){
    return view('MemoryCard');
});
