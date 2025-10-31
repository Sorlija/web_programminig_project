<?php
require_once 'BaseDao.php';

class ProductsDao extends BaseDao {

    public function __construct() {
        parent::__construct('products'); // table name
    }

    /* Search products by name */
    public function getByName($keyword) {
        $sql = "SELECT * FROM " . $this->table . " WHERE name LIKE :keyword";
        $stmt = $this->connection->prepare($sql);
        $searchTerm = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Check if a product has enough stock */
    public function isInStock($productId, $requiredQuantity = 1) {
        $sql = "SELECT stock_quantity FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $productId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['stock_quantity'] >= $requiredQuantity;
    }

    /*Update the stock quantity for a product */
    public function updateStock($productId, $newQuantity) {
        $sql = "UPDATE " . $this->table . " SET stock_quantity = :quantity WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':quantity', $newQuantity);
        $stmt->bindParam(':id', $productId);
        return $stmt->execute();
    }

    /* Get all products by category ID */
    public function getByCategoryId($categoryId) {
        $sql = "SELECT * FROM " . $this->table . " WHERE category_id = :categoryId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
