<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth', 'role:super-admin,university-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', App\Livewire\Admin\Users::class)->name('users');
    Route::get('faculties', App\Livewire\Admin\Faculties::class)->name('faculties');
    Route::get('departments', App\Livewire\Admin\Departments::class)->name('departments');
    Route::get('programmes', App\Livewire\Admin\Programmes::class)->name('programmes');
    Route::get('academic-sessions', App\Livewire\Admin\AcademicSessions::class)->name('academic-sessions');
    Route::get('semesters', App\Livewire\Admin\Semesters::class)->name('semesters');
    Route::get('courses', App\Livewire\Admin\Courses::class)->name('courses');
});

require __DIR__.'/auth.php';
