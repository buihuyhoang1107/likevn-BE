<?php

namespace App\Helpers;

class FacebookHelper
{
    /**
     * Parse Facebook link and extract UID
     * 
     * Supports multiple Facebook URL formats:
     * - https://www.facebook.com/username
     * - https://www.facebook.com/profile.php?id=123456789
     * - https://www.facebook.com/username/posts/123456789
     * - https://www.facebook.com/permalink.php?story_fbid=123456789&id=123456789
     * - https://m.facebook.com/username
     * - https://fb.com/username
     * 
     * @param string $url Facebook URL
     * @return array ['uid' => string|null, 'username' => string|null, 'type' => string]
     */
    public static function parseFacebookUrl($url)
    {
        if (empty($url)) {
            return [
                'uid' => null,
                'username' => null,
                'type' => 'invalid',
                'original_url' => $url,
            ];
        }

        // Remove whitespace
        $url = trim($url);
        
        // Add protocol if missing
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }

        // Parse URL
        $parsedUrl = parse_url($url);
        
        if (!$parsedUrl || !isset($parsedUrl['host'])) {
            return [
                'uid' => null,
                'username' => null,
                'type' => 'invalid',
                'original_url' => $url,
            ];
        }

        // Check if it's a Facebook domain
        $host = strtolower($parsedUrl['host']);
        $isFacebookDomain = in_array($host, [
            'facebook.com',
            'www.facebook.com',
            'm.facebook.com',
            'fb.com',
            'www.fb.com',
        ]);

        if (!$isFacebookDomain) {
            return [
                'uid' => null,
                'username' => null,
                'type' => 'invalid',
                'original_url' => $url,
            ];
        }

        $path = $parsedUrl['path'] ?? '';
        $query = $parsedUrl['query'] ?? '';
        parse_str($query, $queryParams);

        // Case 1: profile.php?id=123456789
        if (strpos($path, 'profile.php') !== false && isset($queryParams['id'])) {
            return [
                'uid' => $queryParams['id'],
                'username' => null,
                'type' => 'profile',
                'original_url' => $url,
            ];
        }

        // Case 2: permalink.php?story_fbid=123456789&id=123456789
        if (strpos($path, 'permalink.php') !== false) {
            $uid = $queryParams['id'] ?? $queryParams['story_fbid'] ?? null;
            return [
                'uid' => $uid,
                'username' => null,
                'type' => 'post',
                'original_url' => $url,
            ];
        }

        // Case 3: /username/posts/123456789
        if (preg_match('/^\/([^\/]+)\/posts\/(\d+)/', $path, $matches)) {
            return [
                'uid' => $matches[2], // Post ID
                'username' => $matches[1],
                'type' => 'post',
                'original_url' => $url,
            ];
        }

        // Case 3.1: /reel/123456789 (Facebook Reel)
        if (preg_match('/^\/reel\/(\d+)/', $path, $matches)) {
            return [
                'uid' => $matches[1], // Reel ID
                'username' => null,
                'type' => 'reel',
                'original_url' => $url,
            ];
        }

        // Case 3.2: /username/reel/123456789
        if (preg_match('/^\/([^\/]+)\/reel\/(\d+)/', $path, $matches)) {
            return [
                'uid' => $matches[2], // Reel ID
                'username' => $matches[1],
                'type' => 'reel',
                'original_url' => $url,
            ];
        }

        // Case 4: /username (profile or page)
        if (preg_match('/^\/([^\/\?]+)/', $path, $matches)) {
            $username = $matches[1];
            
            // Skip common paths that are not usernames
            $skipPaths = [
                'groups', 'pages', 'events', 'watch', 'marketplace', 
                'help', 'settings', 'login', 'logout', 'register',
                'about', 'privacy', 'terms', 'developers', 'policies',
                'reel', 'videos', 'photo', 'photos'
            ];
            
            if (in_array(strtolower($username), $skipPaths)) {
                return [
                    'uid' => null,
                    'username' => null,
                    'type' => 'invalid',
                    'original_url' => $url,
                ];
            }

            // If it's numeric, it's likely a UID
            if (is_numeric($username)) {
                return [
                    'uid' => $username,
                    'username' => null,
                    'type' => 'profile',
                    'original_url' => $url,
                ];
            }

            // Otherwise, it's a username
            return [
                'uid' => null,
                'username' => $username,
                'type' => 'profile',
                'original_url' => $url,
            ];
        }

        // Case 5: Check query params for id
        if (isset($queryParams['id'])) {
            return [
                'uid' => $queryParams['id'],
                'username' => null,
                'type' => 'profile',
                'original_url' => $url,
            ];
        }

        // If we can't parse it, return the original URL
        return [
            'uid' => null,
            'username' => null,
            'type' => 'unknown',
            'original_url' => $url,
        ];
    }

    /**
     * Extract UID from Facebook URL
     * Returns UID if found, otherwise returns original URL
     * 
     * @param string $url Facebook URL
     * @return string UID or original URL
     */
    public static function extractUid($url)
    {
        $parsed = self::parseFacebookUrl($url);
        
        // Return UID if found, otherwise return username, otherwise return original URL
        if ($parsed['uid']) {
            return $parsed['uid'];
        }
        
        if ($parsed['username']) {
            return $parsed['username'];
        }
        
        return $parsed['original_url'];
    }

    /**
     * Check if URL is a valid Facebook URL
     * 
     * @param string $url
     * @return bool
     */
    public static function isValidFacebookUrl($url)
    {
        $parsed = self::parseFacebookUrl($url);
        return $parsed['type'] !== 'invalid';
    }
}

