<?php
class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($name, $age, $theme, $prize, $difficulty) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (name, age, theme, prize, difficulty) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$name, $restaurant, $theme, $prize, $difficulty]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM orders");
        return $stmt->fetchAll();
    }
}