<?php

namespace App\Http\Controllers;

use App\Helpers\FacebookHelper;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    /**
     * Parse Facebook URL and extract UID
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function parseUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
        ]);

        $url = $request->input('url');
        $parsed = FacebookHelper::parseFacebookUrl($url);

        if ($parsed['type'] === 'invalid') {
            return response()->json([
                'success' => false,
                'message' => 'URL không phải là link Facebook hợp lệ',
                'data' => $parsed,
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Parse link Facebook thành công',
            'data' => [
                'uid' => $parsed['uid'],
                'username' => $parsed['username'],
                'type' => $parsed['type'],
                'original_url' => $parsed['original_url'],
                'extracted_uid' => FacebookHelper::extractUid($url),
            ],
        ]);
    }
}

