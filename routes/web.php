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

Route::get('/concerts/create', [ConcertController::class, 'create'])->name('concerts.create');
Route::get('/concerts/index', [ConcertController::class, 'index'])->name('concerts.index');
Route::post('/concerts', [ConcertController::class, 'store'])->name('concerts.store');

require __DIR__.'/auth.php';
