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

    // also works as a store method
    public function encode(EncodeUrlRequest $request)
    {
        // validate the request
        $validated = $request->validated();
        
        // encode the original url
        $encoded_url = $this->urlService->encode($validated['encoded-url']);

        // create the record
        $data = Url::create([
            'url' => $validated['encoded-url'],
            'encoded_url' => $encoded_url,
        ]);
        
        // return json response
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function decode()
    {
        
    }
}
