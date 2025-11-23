<?php

namespace App\Core\Helpers;

use Illuminate\Support\Str;

class ContentFormatter
{
    /**
     * Limit words in a given content
     *
     * @param string $content
     * @param int $limit
     * @param string $end
     * @return string
     */
    public static function limitWords(string $content, int $limit = 10, string $end = '...'): string
    {
        return Str::words(strip_tags($content), $limit, $end);
    }

    /**
     * Trim text to a certain number of characters
     *
     * @param string $content
     * @param int $length
     * @param string $end
     * @return string
     */
    public static function trimText(string $content, int $length = 100, string $end = '...'): string
    {
        $text = strip_tags($content);
        if (Str::length($text) <= $length) {
            return $text;
        }
        return Str::substr($text, 0, $length) . $end;
    }

    /**
     * Strip all HTML tags from content
     *
     * @param string $content
     * @return string
     */
    public static function stripHtml(string $content): string
    {
        return strip_tags($content);
    }
}

// Usage examples
// ContentFormatter::limitWords($text, 10);
// ContentFormatter::trimText($text, 100);
// ContentFormatter::stripHtml($text);
