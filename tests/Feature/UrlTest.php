<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Url;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_url_can_be_encoded(): void
    {
        // set a long url
        $url = 'https://www.reallyreallyreallyreallyreallyreallylong.com';

        // post it
        $response = $this->post('/encode', [
            'encoded-url' => $url,
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
}