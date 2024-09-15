<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return Team::all();
    }

    public function show($id)
    {
        return Team::findOrFail($id);
    }

    public function store(Request $request)
    {
        return Team::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $team->update($request->all());
        return $team;
    }

    public function destroy($id)
    {
        return Team::destroy($id);
    }
};


class TeamController extends Controller
{
    private $apiToken = 'b373e81675174781839c2a00b33385b0';

    // Fetch and store teams for a given league
    public function fetchTeams($leagueId)
    {
        $league = League::findOrFail($leagueId);

        $response = Http::withToken($this->apiToken)
            ->get("https://api.football-data.org/v4/competitions/{$league->code}/teams");

        $teams = $response->json();

        foreach ($teams['teams'] as $teamData) {
            Team::updateOrCreate(
                ['name' => $teamData['name']],
                [
                    'short_name' => $teamData['shortName'],
                    'league_id' => $league->id,
                    'venue' => $teamData['venue'] ?? 'Unknown'
                ]
            );
        }

        return response()->json(['message' => 'Teams data updated successfully']);
    }
};
