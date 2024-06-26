<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'books';
    protected $fillable = [
        'title',
        'author',
        'bookAdder',
        'publicDate',
        'category',
        'price',
        'quantity'
    ];

    public function bookImgs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BookImgs::class, 'book_id');
    }
}
