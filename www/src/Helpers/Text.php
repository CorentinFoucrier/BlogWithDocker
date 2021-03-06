<?php

namespace App\Helpers;

class Text
{
    // static n'a pas besoin d'être instancié pour y accèder mais <NAMESPACE\App>::<methode name> eg. App\Helpers::excerpt()
    public static function excerpt(string $content, int $limit = 60) :string
    {
        $content = preg_replace("/(<[^<]*>)/i", "", $content);

        if (mb_strlen($content) <= $limit) {
            return $content;
        }

        $lastSpace = mb_strpos($content, ' ', ($limit - 1));

        if ($lastSpace == null) {
            return mb_substr($content, 0, $limit) . '...';
        }

        return mb_substr($content, 0, $lastSpace) . '...';
    }
}
