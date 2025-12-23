<?php

namespace App\Http\Controllers;

use App\Helpers\FacebookHelper;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FacebookController extends Controller
{
    /**
     * Parse Facebook URL and extract UID
     * Gọi API traodoisub.com để lấy UID từ Facebook link
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

        if (!FacebookHelper::isValidFacebookUrl($url)) {
            return response()->json([
                'success' => false,
                'message' => 'URL không phải là link Facebook hợp lệ',
                'data' => [
                    'uid' => null,
                    'numeric_uid' => null,
                    'original_url' => $url,
                ],
            ], 400);
        }

        // Gọi API traodoisub.com để lấy UID
        try {
            $client = new Client([
                'timeout' => 20,
                'verify' => false,
            ]);

            $response = $client->post('https://id.traodoisub.com/api.php', [
                'form_params' => [
                    'link' => $url
                ],
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'application/json',
                ]
            ]);

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            // API traodoisub trả về: {"success": 200, "id": "1388977139294476", "post_id": "1388977139294476", ...}
            if (isset($data['success']) && $data['success'] == 200) {
                // Ưu tiên lấy post_id, nếu không có thì lấy id
                $numericUid = isset($data['post_id']) && !empty($data['post_id']) 
                    ? (string) $data['post_id'] 
                    : (isset($data['id']) ? (string) $data['id'] : null);
                
                if ($numericUid && ctype_digit($numericUid)) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Parse link Facebook thành công',
                        'data' => [
                            'uid' => $numericUid,
                            'numeric_uid' => $numericUid,
                            'username' => null,
                            'type' => 'unknown',
                            'original_url' => $url,
                            'extracted_uid' => $numericUid,
                            'traodoisub_data' => [
                                'link' => $data['link'] ?? null,
                                'share_type' => $data['share_type'] ?? null,
                                'name' => $data['name'] ?? null,
                            ],
                        ],
                    ]);
                }
            }

            // Nếu traodoisub không trả về success 200 hoặc không có ID
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy UID từ API traodoisub',
                'data' => [
                    'uid' => null,
                    'numeric_uid' => null,
                    'original_url' => $url,
                    'traodoisub_response' => $data,
                ],
            ], 400);

        } catch (RequestException $e) {
            // Lỗi khi gọi API traodoisub
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi gọi API traodoisub: ' . $e->getMessage(),
                'data' => [
                    'uid' => null,
                    'numeric_uid' => null,
                    'original_url' => $url,
                ],
            ], 500);
        } catch (\Throwable $e) {
            // Lỗi khác
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
                'data' => [
                    'uid' => null,
                    'numeric_uid' => null,
                    'original_url' => $url,
                ],
            ], 500);
        }
    }
}

