<?php

use App\Http\Controllers\Admin\CvFileController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProjectController as SiteProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/proyek/{project}', [SiteProjectController::class, 'show'])->name('projects.show');
Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');

// Dipertahankan agar alur verifikasi email bawaan Breeze tetap memiliki tujuan.
Route::redirect('/dashboard', '/admin')
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::redirect('/', '/admin/projects')->name('index');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('skills', SkillController::class)->except('show');
        Route::resource('projects', ProjectController::class)->except('show');
        Route::resource('experiences', ExperienceController::class)->except('show');

        Route::get('cv-files', [CvFileController::class, 'index'])->name('cv-files.index');
        Route::post('cv-files', [CvFileController::class, 'store'])->name('cv-files.store');
        Route::patch('cv-files/{cvFile}/activate', [CvFileController::class, 'activate'])->name('cv-files.activate');
        Route::delete('cv-files/{cvFile}', [CvFileController::class, 'destroy'])->name('cv-files.destroy');

        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}/read', [MessageController::class, 'toggleRead'])->name('messages.toggle-read');
        Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });

require __DIR__.'/auth.php';
