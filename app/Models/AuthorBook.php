<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'book_id'
    ];

    public function book()
    {
        return $this->hasOne(Book::class, 'book_id', 'book_id');
    }

    public function author()
    {
        return $this->hasOne(Author::class, 'author_id', 'author_id');
    }
}
