<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\RefereeController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\PublicRuleController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PublicFixtureController;

// --- Public Routes (Guests only) ---
Route::get('/', function () { return view('welcome'); });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// --- Protected Routes (Logged-in users) ---
Route::middleware('auth')->group(function () {

    // --- Admin Portal ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showAdminDashboard'])->name('dashboard');
        Route::get('/players', [AuthController::class, 'show'])->name('players');
        Route::get('/rules', [RuleController::class, 'index'])->name('rules');
        Route::post('/rules', [RuleController::class, 'store'])->name('rules.store');
        Route::get('/coaches', [ManagementController::class, 'viewCoaches'])->name('coaches');
        Route::post('/allow/{id}', [AuthController::class, 'allowUser'])->name('allow');
        Route::post('/ban/{id}', [AuthController::class, 'banUser'])->name('ban');
        Route::get('/management', [ManagementController::class, 'index'])->name('management');
        Route::post('/management/college', [ManagementController::class, 'storeCollege'])->name('store_college');
        Route::post('/management/team', [ManagementController::class, 'storeTeam'])->name('store_team');
        Route::post('/management/generate-fixtures', [ManagementController::class, 'generateFixtures'])->name('generate_fixtures');
        Route::post('/management/fixtures/{id}/start', [ManagementController::class, 'startMatch'])->name('match.start');
        Route::post('/management/fixtures/{id}/goal', [ManagementController::class, 'addGoal'])->name('match.goal');
        Route::post('/management/fixtures/{id}/end', [ManagementController::class, 'endMatch'])->name('match.end');
        Route::post('/management/fixtures/{id}/assign-referee', [ManagementController::class, 'assignReferee'])->name('assign_referee');
        Route::get('/fixtures', [ManagementController::class, 'viewFixtures'])->name('view_fixtures');
        Route::get('/live-control/{id}', [ManagementController::class, 'showLivePanel'])->name('live_match_panel');
        Route::post('/fixtures/{id}/add-goal', [ManagementController::class, 'addGoal'])->name('add_goal');
    });

    // --- Coach Portal ---
    Route::prefix('coach')->name('coach.')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showCoachDashboard'])->name('dashboard');
        Route::get('/setup-form', [CoachController::class, 'showCoachForm'])->name('form');
        Route::post('/setup-save', [CoachController::class, 'storeInfo'])->name('info.save');
        Route::get('/players', [CoachController::class, 'viewPlayers'])->name('players');
        Route::get('/fixtures', [CoachController::class, 'viewFixtures'])->name('fixtures');
        Route::get('/profile', [CoachController::class, 'viewProfile'])->name('profile');
        Route::get('/profile/edit', [CoachController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile/update', [CoachController::class, 'updateProfile'])->name('profile.update');
        Route::post('/player/{id}/update', [CoachController::class, 'updatePlayerTactics'])->name('player.update');
    });

    // --- Player Portal (NOTICE: /standings is REMOVED from here) ---
    Route::prefix('player')->name('player.')->group(function () {
        Route::get('/dashboard', [PlayerController::class, 'showPlayerDashboard'])->name('player_dashboard');
        Route::get('/player_form', [PlayerController::class, 'showPlayerForm'])->name('form');
        Route::get('/player_profile', [PlayerController::class, 'showPlayerProfile'])->name('profile');
        Route::post('/info', [PlayerController::class, 'updateInfo'])->name('info.save');
        Route::get('/api/colleges/{college}/teams', [PlayerController::class, 'getTeamsByCollege'])->name('api.colleges.teams');
        Route::get('/api/positions', [PlayerController::class, 'getPositionsBySport'])->name('api.positions');
        Route::get('/fixtures', [PlayerController::class, 'viewFixtures'])->name('fixtures');
        Route::get('/rules', [PublicRuleController::class, 'index'])->name('rules.index');
        // REMOVED: Route::get('/standings', ...) was causing the auth clash.
    });

    // --- Referee Portal ---
    Route::prefix('referee')->name('referee.')->group(function () {
        Route::get('/dashboard', [RefereeController::class, 'dashboard'])->name('dashboard');
        Route::put('/fixtures/{id}/update', [RefereeController::class, 'updateScore'])->name('update_score');
        Route::post('/fixtures/{id}/update', [RefereeController::class, 'updateFixture'])->name('fixtures.update');
        Route::match(['get', 'post'], '/fixtures/{id}/start', [RefereeController::class, 'startMatch'])->name('fixtures.start');
    });

    // --- Fan Portal ---
    Route::prefix('fan')->name('fan.')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showFanDashboard'])->name('dashboard');
    });

    Route::get('/api/colleges/{college}/teams', [PlayerController::class, 'getTeamsByCollege']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// --- Public Routes (Accessible to everyone without login) ---
Route::get('/rules', [PublicRuleController::class, 'index'])->name('rules.index');
Route::get('/fixtures', [PublicFixtureController::class, 'index'])->name('fixtures.public');
Route::get('/standings', [GeneralController::class, 'showStandings'])->name('standings.public');