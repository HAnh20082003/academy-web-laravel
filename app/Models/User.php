<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{ // Cho phép mass assign các trường này:
    protected $fillable = [
        'username',
        'email',
        'password',
    ];
}
