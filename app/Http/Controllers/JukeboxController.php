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

    /**
     * Procesar la compra de un token
     */
    public function purchaseToken(Request $request)
    {
        $user = Auth::user();
        
        // Validar que se envió el ID del token
        $request->validate([
            'jukebox_token_id' => 'required|exists:jukebox_tokens,id'
        ]);
        
        // Obtener el token que quiere comprar
        $token = JukeboxToken::findOrFail($request->jukebox_token_id);
        
        // Obtener saldo actual del usuario
        $userMoney = \DB::table('users')->where('id', $user->id)->value('money') ?? 0;
        
        // Validar que tenga saldo suficiente
        if ($userMoney < $token->price) {
            return redirect()->route('dashboard')
                ->with('error', 'Insufficient balance. You need €' . number_format($token->price, 2) . ' but you only have €' . number_format($userMoney, 2));
        }
        
        // Validar que haya stock disponible
        if ($token->stock <= 0) {
            return redirect()->route('dashboard')
                ->with('error', 'This token is out of stock.');
        }
        
        // Realizar la compra (transacción)
        \DB::transaction(function () use ($user, $token) {
            // 1. Restar dinero al usuario
            \DB::table('users')
                ->where('id', $user->id)
                ->decrement('money', $token->price);
            
            // 2. Restar stock del token
            $token->decrement('stock');
            
            // 3. Crear registro en user_tokens
            UserToken::create([
                'user_id' => $user->id,
                'jukebox_token_id' => $token->id,
                'songs_used' => 0,
            ]);
        });
        
        return redirect()->route('dashboard')
            ->with('success', 'Token purchased successfully! You bought ' . strtoupper($token->name) . ' for €' . number_format($token->price, 2));
    }

}
