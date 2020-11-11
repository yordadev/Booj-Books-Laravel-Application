<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class SearchBookTest extends TestCase
{
    /**
     * * testSuccessfulRemoveBookCondition()
     * 
     * This method tests the search query on the home controller.
     * 
     * @return void
     */
    public function testSuccessfulSearchCondition()
    {
        $this->actingAs(User::find(1));

        $response = $this->get('/v1/home?query=science');

        $response->assertSeeText("science");
    }
}
