<?php

namespace App\Service;

use App\Support\Text;

class AnalyticsService
{
    private SentimentLexicon $lexicon;
    private KeywordExtractor $keywordExtractor;

    public function __construct(SentimentLexicon $lexicon, KeywordExtractor $keywordExtractor)
    {
        $this->lexicon = $lexicon;
        $this->keywordExtractor = $keywordExtractor;
    }

    public function analyze(string $feedbackText): array
    {
        $words = Text::words($feedbackText);
        $score = 0;
        $scoredWords = 0;

        foreach ($words as $word) {
            $delta = $this->lexicon->score($word);
            if ($delta !== 0) {
                $score += $delta;
                $scoredWords++;
            }
        }

        $sentimentScore = $scoredWords === 0 ? 0.0 : $score / $scoredWords;
        $keywords = $this->keywordExtractor->extract($feedbackText, 5);

        return [
            'sentimentScore' => $sentimentScore,
            'keywords' => $keywords,
        ];
    }
}
