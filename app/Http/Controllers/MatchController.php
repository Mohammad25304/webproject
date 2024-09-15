<?php

namespace App\Http\Controllers;

use App\Models\Match;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        return Match::all();
    }

    public function show($id)
    {
        return Match::findOrFail($id);
    }

    public function store(Request $request)
    {
        return Match::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $match = Match::findOrFail($id);
        $match->update($request->all());
        return $match;
    }

    public function destroy($id)
    {
        return Match::destroy($id);
    }
};


class MatchController extends Controller
{
    private $apiToken = 'b373e81675174781839c2a00b33385b0';

    // Fetch and store matches for a given league
    public function fetchMatches($leagueId)
    {
        $league = League::findOrFail($leagueId);

        $response = Http::withToken($this->apiToken)
            ->get("https://api.football-data.org/v4/competitions/{$league->code}/matches");

        $matches = $response->json();

        foreach ($matches['matches'] as $matchData) {
            $homeTeam = Team::where('name', $matchData['homeTeam']['name'])->first();
            $awayTeam = Team::where('name', $matchData['awayTeam']['name'])->first();

            Match::updateOrCreate(
                [
                    'home_team_id' => $homeTeam->id,
                    'away_team_id' => $awayTeam->id,
                    'match_date' => $matchData['utcDate']
                ],
                [
                    'home_score' => $matchData['score']['fullTime']['homeTeam'] ?? null,
                    'away_score' => $matchData['score']['fullTime']['awayTeam'] ?? null
                ]
            );
        }

        return response()->json(['message' => 'Matches data updated successfully']);
    }
};