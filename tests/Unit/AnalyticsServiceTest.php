<?php

namespace Tests\Unit;

use Tests\Framework\TestCase;
use App\Service\AnalyticsService;
use App\Service\KeywordExtractor;
use App\Service\SentimentLexicon;
use App\Service\StopWords;

class AnalyticsServiceTest extends TestCase
{
    public function testAnalyzeReturnsKeywordsAndSentiment(): void
    {
        $service = new AnalyticsService(new SentimentLexicon(), new KeywordExtractor(new StopWords()));
        $result = $service->analyze('The service was fast, friendly, and helpful but the price felt high.');

        $this->assertTrue(isset($result['keywords']), 'Keywords should be present.');
        $this->assertTrue(isset($result['sentimentScore']), 'Sentiment score should be present.');
        $this->assertNotEmpty($result['keywords'], 'Keywords should not be empty.');
    }

    public function testSentimentScoreReflectsNegativeLanguage(): void
    {
        $service = new AnalyticsService(new SentimentLexicon(), new KeywordExtractor(new StopWords()));
        $result = $service->analyze('The experience was awful, slow, and disappointing.');

        $this->assertTrue($result['sentimentScore'] < 0, 'Sentiment should be negative.');
    }
}
