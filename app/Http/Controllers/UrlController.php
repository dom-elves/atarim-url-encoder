<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UrlService;
use App\Http\Requests\EncodeUrlRequest;

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
        $data = $this->urlService->encode($validated['url']);
        
        return response()->json($data);
    }

    public function decode()
    {
        
    }
}
