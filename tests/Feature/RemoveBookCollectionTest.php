<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CollectionPivot;
use App\Models\User;

class RemoveBookCollectionTest extends TestCase
{
    /**
     * * testSuccessfulRemoveBookCondition()
     * 
     * This method prepares 2 more books into the existing test collection.
     * 
     * @return void
     */
    public function testSuccessfulRemoveBookCondition()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $bookPivotTest = CollectionPivot::where([
            'collection_id' => 'collection_5fac21047eb21',
        ])->latest()->first();

        $response = $this->postJson('/v1/collection/book/remove', [
            'collection_id' => 'collection_5fac21047eb21',
            'book_id'       => $bookPivotTest->book_id,
        ]);

        $response->assertSessionHas('success', 'Successfully removed the book from the collection.');
    }


    /**
     * * testSuccessfulRemoveBookCondition()
     * 
     * This method prepares 2 more books into the existing test collection.
     * 
     * @return void
     */
    public function testFailureWrongIDSCondition()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->postJson('/v1/collection/book/remove', [
            'collection_id' => 'collection_5fac21047eb21',
            'book_id'       => 'wrong_id',
        ]);

        $response->assertSessionMissing('success');
    }
}
