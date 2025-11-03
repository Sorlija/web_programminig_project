<?php
require_once 'BaseDao.php';

class CategoriesDao extends BaseDao {
    public function __construct() {
        parent::__construct('categories');
    }

    // Search for categories by name
    public function searchName($keyword) {
        $sql = "SELECT * FROM " . $this->table . " WHERE name LIKE :keyword";
        $stmt = $this->connection->prepare($sql);
        $searchTerm = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
}
?>