<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GameHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get recent game history
        $gameHistory = GameHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate level progress data
        $levelProgress = $this->calculateLevelProgress($user->points);

        // Calculate success rate data
        $successRateData = $this->calculateSuccessRate($user->id);

        // Calculate points history
        $pointsHistory = $this->calculatePointsHistory($user->id);

        return view('profile.index', compact(
            'user',
            'gameHistory',
            'levelProgress',
            'successRateData',
            'pointsHistory'
        ));
    }

    private function calculateLevelProgress($points)
    {
        return [
            [
                'name' => 'Motorik I',
                'y' => $points >= 300 ? 25 : ($points / 300 * 25),
                'color' => '#4299E1', // blue-500
                'sliced' => true,
                'selected' => true
            ],
            [
                'name' => 'Motorik II',
                'y' => $points >= 600 ? 25 : (max(0, $points - 300) / 300 * 25),
                'color' => '#48BB78' // green-500
            ],
            [
                'name' => 'Motorik III',
                'y' => $points >= 900 ? 25 : (max(0, $points - 600) / 300 * 25),
                'color' => '#ECC94B' // yellow-500
            ],
            [
                'name' => 'Motorik IV',
                'y' => $points >= 1200 ? 25 : (max(0, $points - 900) / 300 * 25),
                'color' => '#ED8936' // orange-500
            ]
        ];
    }

    private function calculateSuccessRate($userId)
    {
        $games = ['motorik-1', 'motorik-2', 'motorik-3', 'motorik-4'];
        $categories = [];
        $data = [];

        foreach ($games as $game) {
            $history = GameHistory::where('user_id', $userId)
                ->where('level', $game)
                ->get();

            $categories[] = ucfirst(str_replace('-', ' ', $game));
            
            if ($history->count() > 0) {
                $totalSuccess = $history->sum('correct_answers');
                $totalQuestions = $history->sum('total_questions');
                $successRate = ($totalSuccess / $totalQuestions) * 100;
                $data[] = round($successRate, 1);
            } else {
                $data[] = 0; // Default value for games not played yet
            }
        }

        return [
            'categories' => $categories,
            'data' => $data
        ];
    }

    private function calculatePointsHistory($userId)
    {
        $history = GameHistory::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($history->isEmpty()) {
            // Return default data if no history exists
            return [
                'dates' => [Carbon::now()->format('d M')],
                'points' => [0]
            ];
        }

        $dates = [];
        $points = [];
        $runningTotal = 0;

        foreach ($history as $game) {
            $runningTotal = $game->points_after;
            $dates[] = $game->created_at->format('d M');
            $points[] = $runningTotal;
        }

        return [
            'dates' => $dates,
            'points' => $points
        ];
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'mother_name' => $request->mother_name,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}