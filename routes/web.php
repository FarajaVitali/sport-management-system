<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\Admin\ManagementController;

// --- Public Routes (Guests only) ---
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// --- Protected Routes (Logged-in users) ---
Route::middleware('auth')->group(function () {
    
    // --- Admin / Organizer Portal Cluster ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showAdminDashboard'])->name('dashboard');
        Route::get('/players', [AuthController::class, 'show'])->name('players');

        // Access Controls Layout Toggles
        Route::post('/allow/{id}', [AuthController::class, 'allowUser'])->name('allow'); 
        Route::post('/ban/{id}', [AuthController::class, 'banUser'])->name('ban');     

        // Structural Parameter Rules
        Route::get('/management', [ManagementController::class, 'index'])->name('management');
        Route::post('/management/college', [ManagementController::class, 'storeCollege'])->name('store_college');
        Route::post('/management/team', [ManagementController::class, 'storeTeam'])->name('store_team');
        
        // AUTOMATED SCHEDULING: Generates team competition matrices via round-robin method
        Route::post('/management/generate-fixtures', [ManagementController::class, 'generateFixtures'])->name('generate_fixtures');
    });

    // --- Coach Dashboard ---
    Route::get('/coach/dashboard', [AuthController::class, 'showCoachDashboard'])->name('coach.dashboard');

    // --- Player Specific Portal Cluster ---
    Route::prefix('player')->name('player.')->group(function () {
        Route::get('/dashboard', [PlayerController::class, 'showPlayerDashboard'])->name('player_dashboard');
        Route::get('/player_form', [PlayerController::class, 'showPlayerForm'])->name('form');
        Route::get('/player_profile', [PlayerController::class, 'showPlayerProfile'])->name('profile');
        Route::post('/info', [PlayerController::class, 'updateInfo'])->name('info.save');
        
        // NEW: Read-only scheduling timeline stream for active players
        Route::get('/fixtures', [PlayerController::class, 'viewFixtures'])->name('fixtures');
    });
    
    // API Fetch Endpoint for Dependent Dropdowns
    Route::get('/api/colleges/{college}/teams', [PlayerController::class, 'getTeamsByCollege']);

    // --- Global Session Actions ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});