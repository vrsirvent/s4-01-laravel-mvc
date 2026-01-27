<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JukeboxToken;
use App\Models\UserToken;
use Illuminate\Support\Facades\Auth;

class JukeboxController extends Controller
{
    /**
     * Dashboard view
     */
    public function index()
    {
        $user = Auth::user();
        
        // Have tokens for buy (BD)
        $availableTokens = JukeboxToken::orderBy('song_quantity')->get();
        
        // Have tokens that the user has grouped by type
        $userTokensRaw = UserToken::where('user_id', $user->id)
            ->with('jukeboxToken')
            ->get();
        
        // Array counter token token type
        $tokenCounts = [];
        
        foreach ($availableTokens as $token) {
            $activeTokens = $userTokensRaw->filter(function($userToken) use ($token) {
                if ($userToken->jukebox_token_id == $token->id) {
                    if ($token->song_quantity == 0) {
                        return true;
                    }
                    return $userToken->songs_used < $token->song_quantity;
                }
                return false;
            })->count();
            
            $tokenCounts[$token->name] = $activeTokens;
        }
        
        // User credit (Auth::user()->money) > this option has not worked
        // User credit (read direct database)
        $userMoney = \DB::table('users')->where('id', $user->id)->value('money') ?? 0;
        
        // Current song
        $currentSong = null;
        
        return view('dashboard', compact(
            'availableTokens',
            'tokenCounts',
            'currentSong',
            'userMoney'
        ));
    }
}
