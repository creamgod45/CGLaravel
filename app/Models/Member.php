<?php

namespace App\Models;

use App\Lib\Permission\cases\AdministratorPermission;
use App\Lib\Utils\Utils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    protected $table = 'members'; // 指定模型对应的表
    protected $primaryKey = 'id'; // 主键，Laravel 默认也是 id，此行可省略
    public $incrementing = true; // 因为 id 是自增的
    protected $keyType = 'int'; // 主键类型

    protected $fillable = [
        'username', 'email', 'password', 'phone', 'enable', 'administrator', 'remember_token'
    ]; // 允许批量赋值的字段

    protected $hidden = [
        'password', 'remember_token' // 在模型数组或 JSON 显示时隐藏这些字段
    ];

    protected $casts = [
        'enable' => 'boolean',
        'administrator' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($member) {
            $member->UUID = Utils::uid();
        });
    }
}
