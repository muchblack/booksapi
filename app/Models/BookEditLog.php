<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookEditLog extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'book_edit_logs';
    protected $fillable = [
        'userID',
        'editAction',
    ];
}
