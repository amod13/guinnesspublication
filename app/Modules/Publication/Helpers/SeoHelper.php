<?php

namespace App\Modules\Publication\Helpers;

use Illuminate\Support\Str;

class SeoHelper
{
    public static function generateMetaTitle(string $title): string
    {
        return Str::limit($title, 60);
    }

    public static function generateMetaDescription(string $title, ?string $excerpt = null): string
    {
        if ($excerpt) {
            return Str::limit(strip_tags($excerpt), 160);
        }

        return Str::limit("Learn about {$title} and how NGOs like Aasaman Nepal promote protection, education, and wellbeing.", 160);
    }

    public static function generateMetaKeywords(string $title, ?array $tags = null): string
    {
        $keywords = [];

        // Add title-based keywords
        $titleWords = explode(' ', strtolower($title));
        $keywords = array_merge($keywords, array_slice($titleWords, 0, 3));

        // Add tags if available
        if ($tags) {
            $keywords = array_merge($keywords, $tags);
        }

        // Add default keywords
        $defaultKeywords = ['Nepal', 'NGO', 'Aasaman Nepal', 'child protection', 'education'];
        $keywords = array_merge($keywords, $defaultKeywords);

        return implode(', ', array_unique($keywords));
    }
}
