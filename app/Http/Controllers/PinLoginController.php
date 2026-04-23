<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PinLoginController extends Controller
{
    public function showLoginForm(){
        if (Auth::check()) {
            return redirect()->route('admin.Restaurante'); 
        }
        return view('auth.pin-login');
    }

    public function login(Request $request) {
        $request->validate([
            'pin' => 'required|digits:4',
        ]);
    
        $users = User::where('estado', true)->get();
    
        foreach ($users as $user) {
            if (Hash::check($request->pin, $user->pin)) {
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            }
        }
    
        return response()->json([
            'success' => false,
            'message' => 'El PIN ingresado es incorrecto o no corresponde a ningún usuario.'
        ], 422);
    }
    
}

