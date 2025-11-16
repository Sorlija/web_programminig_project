<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UsersDao.php';

class UsersService extends BaseService {
    public function __construct() {
        parent::__construct(new UsersDao());
    }

    public function getByEmail($email) {
        return $this->dao->getByEmail($email);
    }

    public function existsByEmail($email) {
        return $this->dao->existsByEmail($email);
    }

    public function createUser($name, $email, $password, $role='customer') {
        return $this->dao->createUser($name, $email, $password, $role);
    }
    
    public function updateUser($id, $data) {
        return $this->dao->updateUser($id, $data);
    }

    public function deleteUser($id) {
        return $this->dao->deleteUser($id);
    }

    public function getAllCustomers() {
        return $this->dao->getAllCustomers();
    }
}
