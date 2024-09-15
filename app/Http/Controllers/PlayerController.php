<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        return Player::all();
    }

    public function show($id)
    {
        return Player::findOrFail($id);
    }

    public function store(Request $request)
    {
        return Player::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $player = Player::findOrFail($id);
        $player->update($request->all());
        return $player;
    }

    public function destroy($id)
    {
        return Player::destroy($id);
    }
}



class PlayerController extends Controller
{
    private $apiToken = 'b373e81675174781839c2a00b33385b0';

    // Fetch and store players for a given team
    public function fetchPlayers($teamId)
    {
        $team = Team::findOrFail($teamId);

        $response = Http::withToken($this->apiToken)
            ->get("https://api.football-data.org/v4/teams/{$team->id}");

        $players = $response->json();

        foreach ($players['squad'] as $playerData) {
            Player::updateOrCreate(
                ['name' => $playerData['name']],
                [
                    'position' => $playerData['position'] ?? 'Unknown',
                    'team_id' => $team->id,
                    'shirt_number' => $playerData['shirtNumber'] ?? null
                ]
            );
        }

        return response()->json(['message' => 'Players data updated successfully']);
    }
};