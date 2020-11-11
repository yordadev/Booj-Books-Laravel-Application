<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;


class ViewTest extends TestCase
{
    /**
     * * testAccessHome()
     * 
     * This method tests the home route as the test user.
     * 
     * @return void
     */
    public function testAccessHome()
    {
        $response = $this->actingAs(User::find(1))
            ->get('/v1/home');

        $response->assertStatus(200);
    }

    /**
     * * testAccessCollections()
     * 
     * This tests the view collections route
     * is working with the test user auth.
     * 
     * @return void
     */
    public function testAccessCollections()
    {
        $response = $this->actingAs(User::find(1))
            ->get('/v1/collections');

        $response->assertStatus(200);
    }

    /**
     * * testLandingRedirectToHome()
     * 
     * This method is testing a successfull failure condition
     * redirecting anyone to home from /
     * 
     * @return void
     */
    public function testLandingRedirectToHome()
    {
        $response = $this->actingAs(User::find(1))
            ->get('/');

        $response->assertStatus(302);
    }
}
