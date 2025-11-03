<?php
require_once 'BaseDao.php';

class CartItemsDao extends BaseDao {
    public function __construct() {
        parent::__construct('cart_items');
    }

    // Get all items in a user's cart (with product details)
    public function getCartByUserId($userId) {
        $sql = "SELECT ci.*, p.name AS product_name, p.price, p.image_url 
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.id
                WHERE ci.user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Add item to cart (if exists, increase quantity)
    public function addItem($userId, $productId, $quantity = 1) {
        // Check if already exists
        $sql = "SELECT * FROM cart_items WHERE user_id = :userId AND product_id = :productId";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Update quantity
            $newQuantity = $existing['quantity'] + $quantity;
            $updateSql = "UPDATE cart_items SET quantity = :quantity WHERE id = :id";
            $updateStmt = $this->connection->prepare($updateSql);
            return $updateStmt->execute(['quantity' => $newQuantity, 'id' => $existing['id']]);
        } else {
            // Insert new
            $insertSql = "INSERT INTO cart_items (user_id, product_id, quantity) 
                          VALUES (:userId, :productId, :quantity)";
            $insertStmt = $this->connection->prepare($insertSql);
            return $insertStmt->execute(['userId' => $userId, 'productId' => $productId, 'quantity' => $quantity]);
        }
    }

    //  Update quantity of specific item
    public function updateQuantity($userId, $productId, $quantity) {
        $sql = "UPDATE cart_items 
                SET quantity = :quantity 
                WHERE user_id = :userId AND product_id = :productId";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            'quantity' => $quantity,
            'userId' => $userId,
            'productId' => $productId
        ]);
    }

    //  Remove a specific item from cart
    public function removeItem($userId, $productId) {
        $sql = "DELETE FROM cart_items 
                WHERE user_id = :userId AND product_id = :productId";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            'userId' => $userId,
            'productId' => $productId
        ]);
    }

    // 🧹 Clear all items from user's cart
    public function clearCart($userId) {
        $sql = "DELETE FROM cart_items WHERE user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute(['userId' => $userId]);
    }

    //  Calculate total cost of cart (sum of price * quantity)
    public function getTotal($userId) {
        $sql = "SELECT SUM(p.price * ci.quantity) AS total
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.id
                WHERE ci.user_id = :userId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
?>
