<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ProductsDao.php';

class ProductsService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductsDao());
    }

    public function getByName($keyword) {
        return $this->dao->getByName($keyword);
    }

    public function getByCategoryId($categoryId) {
        return $this->dao->getByCategoryId($categoryId);
    }

    public function isInStock($id, $qty = 1) {
        return $this->dao->isInStock($id, $qty);
    }

    public function updateStock($id, $newQty) {
        return $this->dao->updateStock($id, $newQty);
    }
}
