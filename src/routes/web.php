<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect('/home') : view('auth.login');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login'); 
})->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/home', function () {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $files = File::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            $files = File::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }

        return view('welcome', compact('files'));
    })->name('home');

    Route::post('/files/upload', [FileController::class, 'store'])->name('files.upload');
    Route::get('/files/download/{id}', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');
});