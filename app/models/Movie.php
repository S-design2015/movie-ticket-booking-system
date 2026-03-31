<?php

class Movie {
    private $conn;
    private $table = "movies";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllMovies() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
