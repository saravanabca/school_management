<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    // public function login_auth(Request $request)
    // {
        
    
    //     if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $user = Auth::user(); 
    
    //         return response()->json([
    //             'loginsuccess' => true,
    //             'message' => 'Welcome',
    //         ], 200);
    //         return redirect()->route('dashboard'); 
    //     } else {
    //         return response()->json([
    //             'loginsuccess' => false,
    //             'message' => 'Invalid email or password. Please try again.',
    //         ], 401);
    //     }
    // }


    public function login_auth(Request $request)
    {
        $credentials = $request->only('email', 'password'); // Get email and password from the request
    
        // Attempt to log in with the different guards
        $guards = ['web', 'teacher', 'student'];
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials)) {
                $user = Auth::guard($guard)->user();
                return response()->json([
                    'loginsuccess' => true,
                    'message' => 'Welcome ' . ucfirst($guard), // Welcome message based on role
                    'role' => $guard,
                ], 200);
            }
        }
    
        // Invalid login response
        return response()->json([
            'loginsuccess' => false,
            'message' => 'Invalid email or password. Please try again.',
        ], 401);
    }
    

    

    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    
}