<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CartItemsDao.php';

class CartService extends BaseService {
    public function __construct() {
        parent::__construct(new CartItemsDao());
    }

    public function getCartByUserId($userId) {
        return $this->dao->getCartByUserId($userId);
    }

    public function addItem($userId, $productId, $quantity=1) {
        return $this->dao->addItem($userId, $productId, $quantity);
    }

    public function updateQuantity($userId, $productId, $quantity) {
        return $this->dao->updateQuantity($userId, $productId, $quantity);
    }

    public function removeItem($userId, $productId) {
        return $this->dao->removeItem($userId, $productId);
    }

    public function clearCart($userId) {
        return $this->dao->clearCart($userId);
    }

    public function getTotal($userId) {
        return $this->dao->getTotal($userId);
    }
}
