<?php
require_once 'BaseDao.php';

class OrderItemsDao extends BaseDao {

    public function __construct() {
        parent::__construct('order_items'); // table name
    }

    /**
     * Add a product to an order
     */
    public function addItem($orderId, $productId, $quantity, $price) {
        $sql = "INSERT INTO " . $this->table . " (order_id, product_id, quantity, price) 
                VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            'order_id' => $orderId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }

    /**
     * Get all items for a specific order
     */
    public function getByOrderId($orderId) {
        $sql = "SELECT oi.*, p.name AS product_name, p.price AS product_price, p.image_url
                FROM " . $this->table . " oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = :order_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Delete all items for a specific order
     */
    public function deleteByOrderId($orderId) {
        $sql = "DELETE FROM " . $this->table . " WHERE order_id = :order_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        return $stmt->execute();
    }

    /**
     * Optional: update quantity for a product in an order
     */
    public function updateQuantityByOrderAndProduct($orderId, $productId, $quantity) {
        $sql = "UPDATE " . $this->table . " 
                SET quantity = :quantity 
                WHERE order_id = :order_id AND product_id = :product_id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            'quantity' => $quantity,
            'order_id' => $orderId,
            'product_id' => $productId
        ]);
    }
}
?>
