<?php
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/services/BaseService.php';

require_once __DIR__ . '/services/ProductsService.php';
Flight::register('productsService', 'ProductsService');

require_once __DIR__ . '/services/CategoriesService.php';
Flight::register('categoriesService', 'CategoriesService');

require_once __DIR__ . '/services/UsersService.php';
Flight::register('usersService', 'UsersService');

require_once __DIR__ . '/services/CartService.php';
Flight::register('cartService', 'CartService');

require_once __DIR__ . '/services/OrdersService.php';
Flight::register('ordersService', 'OrdersService');

require_once __DIR__ . '/services/OrderItemsService.php';
Flight::register('orderItemsService', 'OrderItemsService');

require_once __DIR__ . '/routes/products_routes.php';
require_once __DIR__ . '/routes/categories_routes.php';
require_once __DIR__ . '/routes/users_routes.php';
require_once __DIR__ . '/routes/cart_routes.php';
require_once __DIR__ . '/routes/orders_routes.php';
require_once __DIR__ . '/routes/orderitems_routes.php';

Flight::route('/', function() {
    echo json_encode([
        'message' => 'Sweatsuit Shop API',
        'version' => '1.0',
        'endpoints' => [
            '/products' => 'Products',
            '/categories' => 'Categories',
            '/users' => 'Users',
            '/orders' => 'Orders',
            '/orderitems' => 'Order items',
            '/cart' => 'Shopping cart'
        ]
    ]);
});

Flight::start();
