<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::get('chat/with/{user}', 'App\Http\Controllers\ChatController@chat_with');
Route::get('/chat/{chat}', '\App\Http\Controllers\ChatController@show')->name('chat.show');
Route::post('message/sent', '\App\Http\Controllers\MessageController@sent');
Route::get('auth/user', function() {
 
	if(auth()->check()) 
		return response()->json([
			'authUser' => auth()->user()
		]);
 
	return null;
 
});
Route::get('/chat/{chat}/get_users', '\App\Http\Controllers\ChatController@get_users')->name('chat.get_users');
Route::get('/chat/{chat}/get_messages/', '\App\Http\Controllers\ChatController@get_messages')->name('chat.get_messages');