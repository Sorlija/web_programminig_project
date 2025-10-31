<?php
require_once 'BaseDao.php';

class OrdersDao extends BaseDao {
    public function __construct() {
        parent::__construct('orders');
    }

    // Get all orders for a specific user
    public function getByUserId($userId) {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all orders with a specific status
    public function getByStatus($status) {
        $sql = "SELECT * FROM " . $this->table . " WHERE status = :status";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get total amount spent by a specific user
    public function getTotalByUser($userId) {
        $sql = "SELECT SUM(total_amount) AS total_spent FROM " . $this->table . " WHERE user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $result = $stmt->fetch();
        if($result['total_spent'] !== null) {
            return $result['total_spent'];
        }
        return 0;
    }

    // Update the status of an order
    public function updateStatus($orderId, $newStatus) {
        $sql = "UPDATE " . $this->table . " SET status = :status WHERE id = :orderId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':orderId', $orderId);
        return $stmt->execute();
    }
}
?>
