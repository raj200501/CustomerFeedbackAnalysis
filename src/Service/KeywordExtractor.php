<?php

namespace App\Service;

use App\Support\Text;

class KeywordExtractor
{
    private StopWords $stopWords;

    public function __construct(StopWords $stopWords)
    {
        $this->stopWords = $stopWords;
    }

    public function extract(string $text, int $limit = 5): array
    {
        $words = Text::words($text);
        if ($words === []) {
            return [];
        }

        $counts = [];
        foreach ($words as $word) {
            if ($this->stopWords->contains($word)) {
                continue;
            }

            $counts[$word] = ($counts[$word] ?? 0) + 1;
        }

        arsort($counts);
        $keywords = array_slice(array_keys($counts), 0, $limit);

        return $keywords;
    }
}
