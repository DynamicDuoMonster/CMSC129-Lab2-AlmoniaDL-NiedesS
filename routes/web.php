<?php
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.login');
})->name('home');

Route::get('/login', function () {
    return view('layouts.login');
})->name('login');
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/dashboard', function () {
    return view('layouts.index');
})->name('dashboard');

// Routes for the quick reset demo
Route::get('forgot-password', function() {
    return view('layouts.quick-reset');
})->name('password.request');

Route::post('forgot-password', [App\Http\Controllers\LoginController::class, 'quickReset'])->name('password.update');

Route::get('/new-page', function () {
    return view('new-page');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/shoes', [ShoeController::class, 'index'])->name('shoes.index');
    Route::get('/shoes/create', [ShoeController::class, 'create'])->name('shoes.create');
    Route::post('/shoes', [ShoeController::class, 'store'])->name('shoes.store');

    // ⚠️ Static routes MUST come before {shoe} wildcard routes
    Route::get('/shoes/trash', [ShoeController::class, 'trash'])->name('shoes.trash');

    Route::get('/shoes/{shoe}/edit', [ShoeController::class, 'edit'])->name('shoes.edit');
    Route::put('/shoes/{shoe}', [ShoeController::class, 'update'])->name('shoes.update');
    Route::patch('/shoes/{shoe}/soft-delete', [ShoeController::class, 'softDelete'])->name('shoes.softDelete');
    Route::patch('/shoes/{shoe}/restore', [ShoeController::class, 'restore'])->name('shoes.restore');
    Route::delete('/shoes/{shoe}', [ShoeController::class, 'destroy'])->name('shoes.destroy');
});
