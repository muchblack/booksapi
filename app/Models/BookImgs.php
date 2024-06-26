<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImgs extends Model
{
    use HasFactory;
    protected $table = 'book_imgs';
    protected $fillable = [
        'name',
        'path'
    ];
}
