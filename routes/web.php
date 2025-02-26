<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return view('admin.dashboard'); // Vista del admin
        }
        return view('dashboard'); // Vista del usuario normal
    })->name('dashboard');
});

require __DIR__.'/auth.php';
