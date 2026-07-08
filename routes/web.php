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

        Route::get('/rules', [RuleController::class, 'index'])->name('rules');
        Route::post('/rules', [RuleController::class, 'store'])->name('rules.store');

        // Coaches (single definition — duplicate '/admin/coaches' removed, it was
        // doubling the prefix into /admin/admin/coaches and reusing the same route name)
        Route::get('/coaches', [ManagementController::class, 'viewCoaches'])->name('coaches');

        Route::post('/allow/{id}', [AuthController::class, 'allowUser'])->name('allow');
        Route::post('/ban/{id}', [AuthController::class, 'banUser'])->name('ban');

        Route::get('/management', [ManagementController::class, 'index'])->name('management');
        Route::post('/management/college', [ManagementController::class, 'storeCollege'])->name('store_college');
        Route::post('/management/team', [ManagementController::class, 'storeTeam'])->name('store_team');
        Route::post('/management/generate-fixtures', [ManagementController::class, 'generateFixtures'])->name('generate_fixtures');

        // Live Match Management Routes
        Route::post('/management/fixtures/{id}/start', [ManagementController::class, 'startMatch'])->name('match.start');
        Route::post('/management/fixtures/{id}/goal', [ManagementController::class, 'addGoal'])->name('match.goal');
        Route::post('/management/fixtures/{id}/end', [ManagementController::class, 'endMatch'])->name('match.end');
        Route::post('/management/fixtures/{id}/assign-referee', [ManagementController::class, 'assignReferee'])->name('assign_referee');

        Route::get('/fixtures', [ManagementController::class, 'viewFixtures'])->name('view_fixtures');
        Route::get('/live-control/{id}', [ManagementController::class, 'showLivePanel'])->name('live_match_panel');

        // Duplicate of match.goal above (same controller/action, different name/path) — kept
        // since it may be used by existing front-end calls, but consider consolidating to one.
        Route::post('/fixtures/{id}/add-goal', [ManagementController::class, 'addGoal'])->name('add_goal');
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

        // Fixed: was '/coach/player/{id}/update' which, inside the 'coach' prefix group,
        // doubled the prefix into /coach/coach/player/{id}/update. Now correctly /coach/player/{id}/update
        Route::post('/player/{id}/update', [CoachController::class, 'updatePlayerTactics'])->name('player.update');
    });

    // --- Player Specific Portal Cluster ---
    Route::prefix('player')->name('player.')->group(function () {
        Route::get('/dashboard', [PlayerController::class, 'showPlayerDashboard'])->name('player_dashboard');
        Route::get('/player_form', [PlayerController::class, 'showPlayerForm'])->name('form');
        Route::get('/player_profile', [PlayerController::class, 'showPlayerProfile'])->name('profile');
        Route::post('/info', [PlayerController::class, 'updateInfo'])->name('info.save');

        // Fixed: was '/api/colleges/{college}/teams', identical to the global route below
        // but unnamed and unreachable in practice due to route caching order. Given a
        // distinct name here so it doesn't collide silently with the global one.
        Route::get('/api/colleges/{college}/teams', [PlayerController::class, 'getTeamsByCollege'])->name('api.colleges.teams');
        Route::get('/api/positions', [PlayerController::class, 'getPositionsBySport'])->name('api.positions');

        // Read-only scheduling timeline stream for active players
        Route::get('/fixtures', [PlayerController::class, 'viewFixtures'])->name('fixtures');
        Route::get('/rules', [PublicRuleController::class, 'index'])->name('rules.index');
        Route::get('/standings', [GeneralController::class, 'showStandings'])->name('standings');
    });

    // --- Referee Specific Portal Cluster ---
    Route::prefix('referee')->name('referee.')->group(function () {
        Route::get('/dashboard', [RefereeController::class, 'dashboard'])->name('dashboard');

        // Updates
        Route::put('/fixtures/{id}/update', [RefereeController::class, 'updateScore'])->name('update_score');
        Route::post('/fixtures/{id}/update', [RefereeController::class, 'updateFixture'])->name('fixtures.update');

        // Fixed: was '/referee/fixtures/{id}/start', which, inside the 'referee' prefix group,
        // doubled the prefix into /referee/referee/fixtures/{id}/start. Now correctly
        // /referee/fixtures/{id}/start
        Route::match(['get', 'post'], '/fixtures/{id}/start', [RefereeController::class, 'startMatch'])->name('fixtures.start');
    });

    // --- Fan / Spectator Specific Portal Cluster ---
    Route::prefix('fan')->name('fan.')->group(function () {
        // Read-only fan dashboard tracking live matches, stats and points tables
        Route::get('/dashboard', [AuthController::class, 'showFanDashboard'])->name('dashboard');
    });

    // API Fetch Endpoint for Dependent Dropdowns (global version, distinct from player-scoped one above)
    Route::get('/api/colleges/{college}/teams', [PlayerController::class, 'getTeamsByCollege']);

    // --- Global Session Actions ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// --- Public (guest + auth accessible) routes ---
// Fixed: 'rules.index' was defined three times total in the original file (twice back-to-back
// at the bottom, plus once inside the 'player' group). Only one top-level definition is kept
// here; the player-group one above is intentionally kept separate/scoped.
Route::get('/rules', [PublicRuleController::class, 'index'])->name('rules.index');
Route::get('/fixtures', [PublicFixtureController::class, 'index'])->name('fixtures.public');
Route::get('/standings', [GeneralController::class, 'showStandings'])->name('standings.public');