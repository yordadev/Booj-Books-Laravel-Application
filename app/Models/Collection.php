<?php

namespace App\Models;

use App\Models\CollectionPivot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'user_id',
        'name'
    ];

    public static function generateCollectionID()
    {
        $id = 'collection_' . uniqid();

        if (Collection::where('collection_id', $id)->first()) {
            return Collection::generateCollectionID();
        }

        return $id;
    }
    public function pivot()
    {
        return $this->hasMany(CollectionPivot::class, 'collection_id', 'collection_id')->orderBy('position', 'asc');
    }
}
