<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AddBookNewCollectionTest extends TestCase
{
    /**
     * * testSuccessNewCollectionCondition()
     * 
     * This method tests for a successful condition on 
     * creating a new collection and adding a book to it.
     * 
     * @return void
     */
    public function testSuccessNewCollectionCondition()
    {
        $this->actingAs(User::find(1));

        $response = $this->postJson('/v1/collection/book/add/new', [
            'name' => 'A Test Collection',
            'title' => 'A Test Title Book',
            'description' => 'A Tested Description testing the description',
            'link' => 'https://github.com/yordadev',
            'authors' => [
                'author' => 'me'
            ]
        ]);

        $response->assertSessionHas('success', 'Successfully created a new collection.');
    }


    /**
     * * testFailureMissingCollectionNameCondition()
     * 
     * This method tests for a failure condition on
     * adding a book to a new collection. 
     * 
     * Missing collection name.
     * 
     * @return void
     */
    public function testFailureMissingCollectionNameCondition()
    {
        $this->actingAs(User::find(1));

        $response = $this->postJson('/v1/collection/book/add/new', [
            'title' => 'A Test Title Book',
            'description' => 'A Tested Description testing the description',
            'link' => 'https://github.com/yordadev',
            'authors' => [
                'author' => 'me'
            ]
        ]);

        $response->assertSessionMissing('success');
    }
}
