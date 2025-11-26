<?php

namespace App\Modules\Publication\Helpers;

use Illuminate\Support\Str;

class SeoHelper
{
    public static function generateMetaTitle(string $title): string
    {
        // Clean and optimize title for SEO
        $cleanTitle = strip_tags($title);
        $cleanTitle = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $cleanTitle);

        return Str::limit(trim($cleanTitle), 60);
    }

    public static function generateMetaDescription(string $title, ?string $content = null): string
    {
        if ($content) {
            // Extract meaningful content
            $cleanContent = strip_tags($content);
            $cleanContent = preg_replace('/\s+/', ' ', $cleanContent);
            return Str::limit(trim($cleanContent), 160);
        }

        // Generate description from title
        $description = "Discover {$title}. Get detailed information and insights about {$title}.";
        return Str::limit($description, 160);
    }

    public static function generateMetaKeywords(string $title, $tags = null): string
    {
        $keywords = [];

        // Extract keywords from title
        $titleWords = self::extractKeywords($title);
        $keywords = array_merge($keywords, $titleWords);

        // Add tags if available
        if ($tags) {
            if (is_string($tags)) {
                $tagArray = explode(',', $tags);
                $keywords = array_merge($keywords, array_map('trim', $tagArray));
            } elseif (is_array($tags)) {
                $keywords = array_merge($keywords, $tags);
            }
        }

        // Add contextual keywords based on title
        $contextualKeywords = self::getContextualKeywords($title);
        $keywords = array_merge($keywords, $contextualKeywords);

        // Clean and deduplicate
        $keywords = array_filter(array_unique($keywords), function ($keyword) {
            return strlen(trim($keyword)) > 2;
        });

        return implode(', ', array_slice($keywords, 0, 10));
    }

    private static function extractKeywords(string $text): array
    {
        // Remove common stop words
        $stopWords = ['the', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'a', 'an', 'is', 'are', 'was', 'were'];

        $words = explode(' ', strtolower(strip_tags($text)));
        $keywords = [];

        foreach ($words as $word) {
            $word = preg_replace('/[^a-zA-Z0-9]/', '', $word);
            if (strlen($word) > 3 && !in_array($word, $stopWords)) {
                $keywords[] = $word;
            }
        }

        return array_slice($keywords, 0, 5);
    }

    private static function getContextualKeywords(string $title): array
    {
        $title = strtolower($title);
        $contextual = [];

        // Publication related keywords
        if (str_contains($title, 'book') || str_contains($title, 'publication')) {
            $contextual = array_merge($contextual, ['books', 'publication', 'reading', 'literature']);
        }

        if (str_contains($title, 'news') || str_contains($title, 'blog')) {
            $contextual = array_merge($contextual, ['news', 'articles', 'blog', 'information']);
        }

        if (str_contains($title, 'gallery') || str_contains($title, 'photo')) {
            $contextual = array_merge($contextual, ['gallery', 'photos', 'images', 'visual']);
        }

        // Add default organizational keywords
        $contextual = array_merge($contextual, ['Nepal', 'publication', 'content']);

        return array_slice($contextual, 0, 5);
    }
}
