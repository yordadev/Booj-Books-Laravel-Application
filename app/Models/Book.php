<?php

namespace App\Models;

use App\Models\AuthorBook;
use App\Models\CollectionPivot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'title',
        'description',
    ];

    public static function generateBookID()
    {
        $id = 'book_' . uniqid();

        if (Book::where('book_id', $id)->first()) {
            return Book::generateBookID();
        }

        return $id;
    }

    public function collections()
    {
        return $this->hasMany(CollectionPivot::class, 'book_id', 'book_id');
    }

    public function authors()
    {
        return $this->hasMany(AuthorBook::class, 'book_id', 'book_id');
    }
}
