<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Url;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    // encoding tests
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

    // decoding tests
    public function test_user_can_decode_a_url(): void
    {
        // repeat encoding for a db record
        $url = 'https://www.reallyreallyreallyreallyreallyreallylong.com';

        $this->post('/encode', [
            'encoded-url' => $url,
        ]);

        $this->assertDatabaseHas('urls', [
            'url' => $url,
        ]);

        $data = Url::where('url', $url)->first();


        // now decode it
        $response = $this->post('/decode', [
            'decoded-url' => $data->encoded_url,
        ]);

        // assert response contains correct data
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => $data->url
        ]);
    }

    public function test_user_can_not_decode_a_url_that_has_not_been_encoded(): void
    {
        // set a url that doesn't exist in the db
        $not_a_url = 'https://short.url/notwiththeconvention';

        // check it's not in the db
        $this->assertDatabaseMissing('urls', [
            'url' => $not_a_url,
        ]);

        $response = $this->post('/decode', [
            'decoded-url' => $not_a_url,
        ]);

        // assert response code & message 
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'decoded-url' => [
                        'The URL field must be a valid encoded URL.'
                    ]
                ]
        ]);
    }

    public function test_user_can_not_decode_an_empty_string(): void
    {
        // set a non-url
        $empty_string = '';

        // post it
        $response = $this->post('/decode', [
            'decoded-url' => $empty_string,
        ]);

        // check it's not in the db
        $this->assertDatabaseMissing('urls', [
            'url' => $empty_string,
        ]);

        // assert response code & message 
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'decoded-url' => [
                        'The URL field is required.'
                    ]
                ]
        ]); 
    }

    public function test_user_can_not_decode_a_non_url(): void
    {
        // set a non-url
        $not_a_url = 'justabigrandomstring12345';

        // post it
        $response = $this->post('/decode', [
            'decoded-url' => $not_a_url,
        ]);

        // check it's not in the db
        $this->assertDatabaseMissing('urls', [
            'url' => $not_a_url,
        ]);

        // assert response code & message 
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'decoded-url' => [
                        'The URL field must be a valid URL.'
                    ]
                ]
        ]);          
    }
}