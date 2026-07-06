<?php
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

// This will be accessible at: /api/positions?sport=Football
Route::get('/positions', [PositionController::class, 'getBySport']);