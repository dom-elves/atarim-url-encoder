<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UrlService;
use App\Http\Requests\EncodeUrlRequest;
use App\Models\Url;

class UrlController extends Controller
{
    protected $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    public function encode(EncodeUrlRequest $request)
    {
        $validated = $request->validated();
        
        $encoded_url = $this->urlService->encode($validated['encoded-url']);

        $data = Url::create([
            'url' => $validated['encoded-url'],
            'encoded_url' => $encoded_url,
        ]);
        
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function decode()
    {
        
    }
}
