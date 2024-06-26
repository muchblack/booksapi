<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Users extends Model
{
    use HasFactory;
    use HasUuids;
    use HasApiTokens;

    protected $table = "users";
    protected $fillable = [
        'userName',
        'email',
        'password'
    ];
}
