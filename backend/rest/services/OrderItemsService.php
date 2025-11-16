<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/OrderItemsDao.php';

class OrderItemsService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderItemsDao());
    }

    public function addItem($orderId, $productId, $quantity, $price) {
        return $this->dao->addItem($orderId, $productId, $quantity, $price);
    }

    public function getByOrderId($orderId) {
        return $this->dao->getByOrderId($orderId);
    }

    public function deleteByOrderId($orderId) {
        return $this->dao->deleteByOrderId($orderId);
    }
}
