<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AddBookExistingCollectionTest extends TestCase
{
    /**
     * * testSuccessExistingCollectionCondition()
     * 
     * This method tests for a successful condition on add a book to
     * existing collection
     * 
     * @return void
     */
    public function testSuccessExistingCollectionCondition()
    {
        $this->actingAs(User::find(1));

        $response = $this->postJson('/v1/collection/book/add/existing', [
            'collection_id' => 'collection_5fac21047eb21',
            'title' => 'A Test Title Book',
            'description' => 'A Tested Description testing the description',
            'link' => 'https://github.com/yordadev',
            'authors' => [
                'author' => 'me'
            ]
        ]);

        $response->assertSessionHas('success', 'Successfully added the book to an existing collection.');
    }

    /**
     * * testFailureMissingCollectionIDCondition()
     * 
     * This method tests for a failure condition on add a book to
     * existing collection. 
     * 
     * missing collection_id.
     * 
     * @return void
     */
    public function testFailureMissingCollectionIDCondition()
    {
        $this->actingAs(User::find(1));

        $response = $this->postJson('/v1/collection/book/add/existing', [
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
