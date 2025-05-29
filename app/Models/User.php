<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password', // Ẩn password khi trả về JSON
        'remember_token',
    ];
    public const  MIN_PASSWORD = 6;
    public const ROLE_ADMIN = 0;
    public const ROLE_LECTURE = 1;
    public const ROLE_STUDENT = 2;

    public static function passwordRules()
    {
        return [
            'password' => 'required|min:' . self::MIN_PASSWORD,
        ];
    }

    // Hàm tiện ích để lấy tên role
    public static function getRoleOptions()
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_LECTURE => 'Lecture',
            self::ROLE_STUDENT => 'Student',
        ];
    }

    public function getRoleName()
    {
        return self::getRoleOptions()[$this->role] ?? 'Unknown';
    }
}
