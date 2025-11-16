<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoriesDao.php';

class CategoriesService extends BaseService {
    public function __construct() {
        parent::__construct(new CategoriesDao());
    }

    public function searchName($keyword) {
        return $this->dao->searchName($keyword);
    }
}
