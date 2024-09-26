<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Authenticatable
{
    protected $guard = 'student';

    // protected $table = 'students';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship to Teacher
     * A student belongs to a teacher.
     *
     * @return BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relationship to Marks
     * A student can have many marks.
     *
     * @return HasMany
     */
    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    /**
     * Relationship to Homeworks
     * A student can have many homeworks.
     *
     * @return HasMany
     */
    public function homeworks(): HasMany
    {
        return $this->hasMany(Homework::class);
    }
}