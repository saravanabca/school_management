<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Automatically hashes the user's password when set.
     */
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = Hash::make($password);
    // }

    /**
     * Define a method to check if the user has an admin role.
     */
    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }

    /**
     * Define a method to check if the user has a teacher role.
     */
    // public function isTeacher()
    // {
    //     return $this->role === 'teacher';
    // }

    /**
     * Define a method to check if the user has a student role.
     */
    // public function isStudent()
    // {
    //     return $this->role === 'student';
    // }
}