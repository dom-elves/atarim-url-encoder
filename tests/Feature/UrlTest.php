<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Url;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_encode_a_url(): void
    {
        // set a long url
        $url = 'https://www.reallyreallyreallyreallyreallyreallylong.com';

        // post it
        $response = $this->post('/encode', [
            'encoded-url' => $url,
        ]);

        // check it's in the db
        $this->assertDatabaseHas('urls', [
            'url' => $url,
        ]);

        // find it
        $data = Url::where('url', $url)->first();

        // assert response contains correct data
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $data->id,
                    'url' => $data->url,
                    'encoded_url' => $data->encoded_url,
                ]
        ]);
    }

    public function test_user_can_not_encode_a_non_url(): void
    {
        // set a non-url
        $not_a_url = 'justabigrandomstring12345';

        // post it
        $response = $this->post('/encode', [
            'encoded-url' => $not_a_url,
        ]);

        // check it's not in the db
        $this->assertDatabaseMissing('urls', [
            'url' => $not_a_url,
        ]);

        // assert response code & message 
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'encoded-url' => [
                        'The URL field must be a valid URL.'
                    ]
                ]
        ]);          
    }

    public function test_user_can_not_encode_an_empty_string(): void
    {
        // set a non-url
        $empty_string = '';

        // post it
        $response = $this->post('/encode', [
            'encoded-url' => $empty_string,
        ]);

        // check it's not in the db
        $this->assertDatabaseMissing('urls', [
            'url' => $empty_string,
        ]);

        // assert response code & message 
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'encoded-url' => [
                        'The URL field is required.'
                    ]
                ]
        ]); 
    }
}