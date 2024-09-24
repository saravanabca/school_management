<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TeacherController extends Controller
{
    public function teacher()
    {
        return view('teacher');
    }
    public function teacher_add(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
            ]);
        
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'teacher',
            ]);

            return response()->json([
                'status' => 'teacher_add_success',
                'status_value' => true,
                'message' => 'teacher Created Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_value' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}