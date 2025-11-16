<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/OrdersDao.php';

class OrdersService extends BaseService {
    public function __construct() {
        parent::__construct(new OrdersDao());
    }

    public function getByUserId($userId) {
        return $this->dao->getByUserId($userId);
    }

    public function getByStatus($status) {
        return $this->dao->getByStatus($status);
    }

    public function getTotalByUser($userId) {
        return $this->dao->getTotalByUser($userId);
    }

    public function updateStatus($orderId, $newStatus) {
        return $this->dao->updateStatus($orderId, $newStatus);
    }
}
