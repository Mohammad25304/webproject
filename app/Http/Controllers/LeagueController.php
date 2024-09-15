<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index()
    {
        return League::all();
    }

    public function show($id)
    {
        return League::findOrFail($id);
    }

    public function store(Request $request)
    {
        return League::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $league = League::findOrFail($id);
        $league->update($request->all());
        return $league;
    }

    public function destroy($id)
    {
        return League::destroy($id);
    }
};


class LeagueController extends Controller
{
    private $apiToken = 'b373e81675174781839c2a00b33385b0';

    // Fetch and store leagues from API
    public function fetchLeagues()
    {
        $response = Http::withToken($this->apiToken)
            ->get('https://api.football-data.org/v4/competitions');

        $leagues = $response->json();

        foreach ($leagues['competitions'] as $competition) {
            League::updateOrCreate(
                ['code' => $competition['code']],
                [
                    'name' => $competition['name'],
                    'country' => $competition['area']['name']
                ]
            );
        }

        return response()->json(['message' => 'Leagues data updated successfully']);
    }
};


