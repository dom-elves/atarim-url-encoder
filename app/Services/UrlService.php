<?php 

namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Url;

class UrlService
{
    public function encode(string $original_url): string
    {
        $code = Str::random(6);
        $base = 'https://short.url/';

        $url = $base . $code;
        
        return $url;
    }

    public function decode(string $encoded_url): string
    {
        $url = Url::where('encoded_url', $encoded_url)->first();
        return $url->url;
    }
}
