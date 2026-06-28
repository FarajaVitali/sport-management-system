<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\GeneralController;

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
        
        // FIXED: Stripped duplicate names & paths. Points to your ManagementController handler!
        Route::get('/coaches', [ManagementController::class, 'viewCoaches'])->name('coaches');

        // Access Controls Layout Toggles
        Route::post('/allow/{id}', [AuthController::class, 'allowUser'])->name('allow'); 
        Route::post('/ban/{id}', [AuthController::class, 'banUser'])->name('ban');     

        // Structural Parameter Rules
        Route::get('/management', [ManagementController::class, 'index'])->name('management');
        Route::post('/management/college', [ManagementController::class, 'storeCollege'])->name('store_college');
        Route::post('/management/team', [ManagementController::class, 'storeTeam'])->name('store_team');
        
        // AUTOMATED SCHEDULING: Generates team competition matrices via round-robin method
        Route::post('/management/generate-fixtures', [ManagementController::class, 'generateFixtures'])->name('generate_fixtures');
        // Live Match Management Routes
        Route::post('/management/fixtures/{id}/start', [ManagementController::class, 'startMatch'])->name('match.start');
        Route::post('/management/fixtures/{id}/goal', [ManagementController::class, 'addGoal'])->name('match.goal');
        Route::post('/management/fixtures/{id}/end', [ManagementController::class, 'endMatch'])->name('match.end');
        Route::get('/fixtures', [ManagementController::class, 'viewFixtures'])->name('fixtures');
        Route::get('/live-control/{id}', [ManagementController::class, 'showLivePanel'])->name('live_match_panel');
        Route::post('/fixtures/{id}/add-goal', [ManagementController::class, 'addGoal'])->name('add_goal');
        //Route::get('/rules', [Admin\RuleController::class, 'index'])->name('rules');
        //Route::post('/rules', [Admin\RuleController::class, 'store'])->name('rules.store');
        Route::get('/rules', [GeneralController::class, 'showRules'])->name('rules.view');
       });

    // --- Coach Specific Portal Cluster ---
    Route::prefix('coach')->name('coach.')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showCoachDashboard'])->name('dashboard');
        
        // ONBOARDING: Profile Setup Form Layouts for pre-registered attributes
        Route::get('/setup-form', [CoachController::class, 'showCoachForm'])->name('form');
        Route::post('/setup-save', [CoachController::class, 'storeInfo'])->name('info.save');

        // Core Dashboard Navigations
        Route::get('/players', [CoachController::class, 'viewPlayers'])->name('players');
        Route::get('/fixtures', [CoachController::class, 'viewFixtures'])->name('fixtures');
        Route::get('/profile', [CoachController::class, 'viewProfile'])->name('profile');
        Route::get('/profile/edit', [CoachController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile/update', [CoachController::class, 'updateProfile'])->name('profile.update');
    });

    // --- Player Specific Portal Cluster ---
    Route::prefix('player')->name('player.')->group(function () {
        Route::get('/dashboard', [PlayerController::class, 'showPlayerDashboard'])->name('player_dashboard');
        Route::get('/player_form', [PlayerController::class, 'showPlayerForm'])->name('form');
        Route::get('/player_profile', [PlayerController::class, 'showPlayerProfile'])->name('profile');
        Route::post('/info', [PlayerController::class, 'updateInfo'])->name('info.save');
        
        // Read-only scheduling timeline stream for active players
        Route::get('/fixtures', [PlayerController::class, 'viewFixtures'])->name('fixtures');
        Route::get('/rules-view', [App\Http\Controllers\GeneralController::class, 'showRules'])->name('rules.view');
        
        });
    
    // API Fetch Endpoint for Dependent Dropdowns
    Route::get('/api/colleges/{college}/teams', [PlayerController::class, 'getTeamsByCollege']);

    // --- Global Session Actions ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});