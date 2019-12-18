<?php

namespace Tests\Feature;

use Tests\TestCase;

class MyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/api/test');

        $response->assertStatus(200);
    }
}
