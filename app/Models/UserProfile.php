<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = 'users_profiles';

    protected $fillable = [
       // 'user_id',
        'first_name',
        'last_name',
        'birthdate',
        'gender',
        'country',
        'phone',
        'bio',
    ];
}
