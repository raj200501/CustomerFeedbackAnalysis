<?php

class Analytics
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addAnalytics($feedbackId, $keyword, $sentimentScore)
    {
        $stmt = $this->conn->prepare("INSERT INTO analytics (feedback_id, keyword, sentiment_score) VALUES (:feedback_id, :keyword, :sentiment_score)");
        $stmt->execute([
            'feedback_id' => $feedbackId,
            'keyword' => $keyword,
            'sentiment_score' => $sentimentScore,
        ]);
    }

    public function getAnalytics()
    {
        $stmt = $this->conn->query("SELECT * FROM analytics");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
