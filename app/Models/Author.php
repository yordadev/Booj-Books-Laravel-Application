<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'name'
    ];

    public static function generateAuthorID()
    {
        $id = 'author_' . uniqid();

        if (Author::where('author_id', $id)->first()) {
            return Author::generateAuthorID();
        }

        return $id;
    }
}
