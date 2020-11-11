<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CollectionPivot;

class MoveBookPositionTest extends TestCase
{
    /**
     * * testPrepareMovePositionTest()
     * 
     * This method prepares 2 more books into the existing test collection.
     * 
     * @return void
     */
    public function testPrepareMovePositionTest()
    {
        $this->actingAs(User::find(1));

        $this->postJson('/v1/collection/book/add/existing', [
            'collection_id' => 'collection_5fac21047eb21',
            'title' => 'A Test Title Book 2',
            'description' => 'A Tested Description testing the description 2',
            'link' => 'https://github.com/yordadev',
            'authors' => [
                'author' => 'me'
            ]
        ]);

        $response = $this->postJson('/v1/collection/book/add/existing', [
            'collection_id' => 'collection_5fac21047eb21',
            'title' => 'A Test Title Book last erm hello world.',
            'description' => 'A Tested Description testing the description another',
            'link' => 'https://github.com/yordadev',
            'authors' => [
                'author' => 'me'
            ]
        ]);

        $response->assertSessionHas('success', 'Successfully added the book to an existing collection.');
    }


    /**
     * * testMovePosition()
     * 
     * This method tests for a successful condition on
     * moving a book around in the collection.
     * 
     * @return void
     */
    public function testMovePosition()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $bookPivotTest = CollectionPivot::where([
            'collection_id' => 'collection_5fac21047eb21',
        ])->latest()->first();

        $response = $this->postJson('/v1/collection/book/move', [
            'collection_id' => 'collection_5fac21047eb21',
            'book_id'       => $bookPivotTest->book_id,
            'position'      => "1",
        ]);

        $response->assertSessionHas('success', 'Successfully moved the book position.');
    }


    /**
     * * testFailureMovePositionWrongID()
     * 
     * This method tests for failure on moving a book around the collection.
     * 
     * It is missing position.
     * 
     * @return void
     */
    public function testFailureMovePositionWrongID()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->postJson('/v1/collection/book/move', [
            'collection_id' => 'collection_5fac21047eb21',
            'book_id'       => 'wrong_id',
        ]);

        $response->assertSessionMissing('success');
    }
}
