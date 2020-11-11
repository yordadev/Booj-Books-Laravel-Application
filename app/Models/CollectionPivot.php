<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollectionPivot extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'collection_id',
        'book_id',
        'position'    
    ];

    public function book(){
        return $this->hasOne(Book::class, 'book_id', 'book_id');
    }

    public function collection(){
        return $this->belongsTo(Collection::class, 'collection_id', 'collection_id');
    }
}
