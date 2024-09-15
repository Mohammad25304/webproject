<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MatchController;

// Leagues
Route::get('/leagues', [LeagueController::class, 'index']); // Get all leagues
Route::get('/leagues/{id}', [LeagueController::class, 'show']); // Get a specific league
Route::post('/leagues', [LeagueController::class, 'store']); // Create a new league
Route::put('/leagues/{id}', [LeagueController::class, 'update']); // Update a league
Route::delete('/leagues/{id}', [LeagueController::class, 'destroy']); // Delete a league
Route::get('/leagues/fetch', [LeagueController::class, 'fetchLeagues']); // Fetch and update leagues from API

// Teams
Route::get('/teams', [TeamController::class, 'index']); // Get all teams
Route::get('/teams/{id}', [TeamController::class, 'show']); // Get a specific team
Route::post('/teams', [TeamController::class, 'store']); // Create a new team
Route::put('/teams/{id}', [TeamController::class, 'update']); // Update a team
Route::delete('/teams/{id}', [TeamController::class, 'destroy']); // Delete a team
Route::get('/leagues/{leagueId}/teams/fetch', [TeamController::class, 'fetchTeams']); // Fetch and update teams for a league from API

// Players
Route::get('/players', [PlayerController::class, 'index']); // Get all players
Route::get('/players/{id}', [PlayerController::class, 'show']); // Get a specific player
Route::post('/players', [PlayerController::class, 'store']); // Create a new player
Route::put('/players/{id}', [PlayerController::class, 'update']); // Update a player
Route::delete('/players/{id}', [PlayerController::class, 'destroy']); // Delete a player
Route::get('/teams/{teamId}/players/fetch', [PlayerController::class, 'fetchPlayers']); // Fetch and update players for a team from API

// Matches
Route::get('/matches', [MatchController::class, 'index']); // Get all matches
Route::get('/matches/{id}', [MatchController::class, 'show']); // Get a specific match
Route::post('/matches', [MatchController::class, 'store']); // Create a new match
Route::put('/matches/{id}', [MatchController::class, 'update']); // Update a match
Route::delete('/matches/{id}', [MatchController::class, 'destroy']); // Delete a match
Route::get('/leagues/{leagueId}/matches/fetch', [MatchController::class, 'fetchMatches']); // Fetch and update matches for a league from API

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
