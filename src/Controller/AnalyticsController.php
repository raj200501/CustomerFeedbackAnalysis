<?php

class AnalyticsController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAnalytics()
    {
        $stmt = $this->conn->query("SELECT * FROM analytics");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
