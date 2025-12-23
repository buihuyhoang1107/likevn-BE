<?php

namespace App\Helpers;

/**
 * FacebookHelper
 *
 * Mục tiêu: đơn giản – chỉ làm 2 việc
 * - Kiểm tra link có phải Facebook hay không
 * - Gọi đúng 1 lần Facebook Graph API để đổi URL → numeric ID
 */
class FacebookHelper
{
    /**
     * Chuẩn hoá URL: trim, thêm protocol nếu thiếu.
     */
    private static function normalizeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return $url;
        }

        if (!preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://' . $url;
        }

        return $url;
    }

    /**
     * Kiểm tra host có phải domain Facebook hợp lệ không.
     */
    private static function isFacebookHost(string $host): bool
    {
        $host = strtolower($host);

        return in_array($host, [
            'facebook.com',
            'www.facebook.com',
            'm.facebook.com',
            'fb.com',
            'www.fb.com',
        ], true);
    }

    /**
     * Kiểm tra URL có phải link Facebook hợp lệ (chỉ check domain).
     */
    public static function isValidFacebookUrl(string $url): bool
    {
        $url = self::normalizeUrl($url);
        if ($url === '') {
            return false;
        }

        $parsed = parse_url($url);
        if (!$parsed || !isset($parsed['host'])) {
            return false;
        }

        return self::isFacebookHost($parsed['host']);
    }

    /**
     * Lấy App Access Token: {APP_ID}|{APP_SECRET}
     * - App token hầu như không hết hạn (trừ khi đổi secret)
     * - Nếu thiếu APP_ID/SECRET thì fallback sang FACEBOOK_ACCESS_TOKEN (nếu có)
     */
    private static function getAccessToken(): ?string
    {
        $appId = env('FACEBOOK_APP_ID');
        $appSecret = env('FACEBOOK_APP_SECRET');

        if ($appId && $appSecret) {
            return $appId . '|' . $appSecret;
        }

        $userToken = env('FACEBOOK_ACCESS_TOKEN');
        return $userToken ?: null;
    }

    /**
     * Gọi Facebook Graph API để đổi URL → numeric ID.
     *
     * - Dùng duy nhất endpoint: GET https://graph.facebook.com/v18.0/?id={url}&access_token={token}
     * - Trả về numeric ID (post_id) hoặc null nếu không lấy được
     */
    public static function getNumericIdFromUrl(string $url): ?string
    {
        $url = self::normalizeUrl($url);
        if ($url === '' || !self::isValidFacebookUrl($url)) {
            return null;
        }

        $accessToken = self::getAccessToken();
        if (!$accessToken) {
            return null;
        }

        $graphUrl = 'https://graph.facebook.com/v18.0/?id='
            . urlencode($url)
            . '&access_token=' . $accessToken;

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $graphUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || !$response) {
                return null;
            }

            $data = json_decode($response, true);
            if (!is_array($data) || !isset($data['id'])) {
                return null;
            }

            $id = (string) $data['id'];

            // Nhiều trường hợp id dạng pageid_postid → lấy phần sau dấu "_"
            if (strpos($id, '_') !== false) {
                $parts = explode('_', $id);
                $id = end($parts);
            }

            return ctype_digit($id) ? $id : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * API cũ đang dùng trong code: trả về numeric UID nếu có, null nếu không.
     * Giờ chỉ là wrapper của getNumericIdFromUrl().
     */
    public static function extractNumericUid(string $url): ?string
    {
        return self::getNumericIdFromUrl($url);
    }

    /**
     * Giữ lại cho tương thích: trả về UID (numeric) nếu có, nếu không thì trả URL gốc.
     * Dùng khi bạn muốn "có gì dùng nấy".
     */
    public static function extractUid(string $url): string
    {
        $numericId = self::getNumericIdFromUrl($url);
        if ($numericId !== null) {
            return $numericId;
        }

        return self::normalizeUrl($url);
    }
}
