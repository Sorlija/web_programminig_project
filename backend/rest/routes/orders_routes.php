<?php

/**
 * @OA\Tag(
 * name="Orders",
 * description="Management of customer orders and status updates"
 * )
 */

// ====================================================================================
// RUTA: GET /orders
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/orders",
 * tags={"Orders"},
 * summary="Get all orders",
 * description="Retrieves a list of all orders placed in the system (Admin access only).",
 * security={{"ApiKey": {}}},
 * @OA\Response(
 * response=200,
 * description="List of orders successfully retrieved"
 * ),
 * @OA\Response(response=401, description="Unauthorized or insufficient privileges")
 * )
 */

// ====================================================================================
// RUTA: GET /orders/@id
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/orders/{id}",
 * tags={"Orders"},
 * summary="Get order by ID",
 * description="Retrieves a single order and its details by ID.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the order to retrieve",
 * @OA\Schema(type="integer", example=15)
 * ),
 * @OA\Response(
 * response=200,
 * description="Order details successfully retrieved"
 * ),
 * @OA\Response(response=404, description="Order not found")
 * )
 */

// ====================================================================================
// RUTA: GET /orders/user/@userId
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/orders/user/{userId}",
 * tags={"Orders"},
 * summary="Get all orders by user ID",
 * description="Retrieves a list of all orders placed by a specific user.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="userId",
 * in="path",
 * required=true,
 * description="ID of the user whose orders are requested",
 * @OA\Schema(type="integer", example=1)
 * ),
 * @OA\Response(
 * response=200,
 * description="List of user orders successfully retrieved"
 * ),
 * @OA\Response(response=401, description="Unauthorized")
 * )
 */

// ====================================================================================
// RUTA: POST /orders
// ====================================================================================

/**
 * @OA\Post(
 * path="/api/orders",
 * tags={"Orders"},
 * summary="Create a new order",
 * description="Creates a new order, typically initiated after successful checkout from the cart.",
 * security={{"ApiKey": {}}},
 * @OA\RequestBody(
 * required=true,
 * description="Order details including user and address information",
 * @OA\JsonContent(
 * required={"user_id", "shipping_address"},
 * @OA\Property(property="user_id", type="integer", example=1),
 * @OA\Property(property="shipping_address", type="string", example="Ulica 123, Grad, 71000"),
 * @OA\Property(property="total_amount", type="number", format="float", example=150.99)
 * )
 * ),
 * @OA\Response(
 * response=201,
 * description="Order successfully created"
 * ),
 * @OA\Response(response=400, description="Invalid data or payment failure")
 * )
 */

// ====================================================================================
// RUTA: PUT /orders/status/@orderId
// ====================================================================================

/**
 * @OA\Put(
 * path="/api/orders/status/{orderId}",
 * tags={"Orders"},
 * summary="Update order status",
 * description="Updates the processing status of an order (e.g., to 'Processing', 'Shipped', or 'Delivered').",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="orderId",
 * in="path",
 * required=true,
 * description="ID of the order to update",
 * @OA\Schema(type="integer", example=15)
 * ),
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"status"},
 * @OA\Property(property="status", type="string", example="Shipped", enum={"Pending", "Processing", "Shipped", "Delivered", "Cancelled"})
 * )
 * ),
 * @OA\Response(
 * response=200,
 * description="Order status successfully updated"
 * ),
 * @OA\Response(response=404, description="Order not found")
 * )
 */

// ====================================================================================
// RUTA: DELETE /orders/@id
// ====================================================================================

/**
 * @OA\Delete(
 * path="/api/orders/{id}",
 * tags={"Orders"},
 * summary="Delete an order",
 * description="Deletes an order permanently by its ID (Admin or system only).",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the order to delete",
 * @OA\Schema(type="integer", example=15)
 * ),
 * @OA\Response(
 * response=204,
 * description="Order successfully deleted"
 * ),
 * @OA\Response(response=404, description="Order not found")
 * )
 */

// ====================================================================================
// FLIGHT PHP RUTE
// ====================================================================================

require_once __DIR__ . '/../services/OrdersService.php';

Flight::register('ordersService', 'OrdersService');

Flight::route('GET /orders', function(){
    Flight::json(Flight::ordersService()->getAll());
});

Flight::route('GET /orders/@id', function($id){
    Flight::json(Flight::ordersService()->getById($id));
});

Flight::route('GET /orders/user/@userId', function($userId){
    Flight::json(Flight::ordersService()->getByUserId($userId));
});

Flight::route('POST /orders', function(){
    Flight::json(Flight::ordersService()->create(Flight::request()->data->getData()));
});

Flight::route('PUT /orders/status/@orderId', function($orderId){
    $status = Flight::request()->data->getData()['status'];
    Flight::json(Flight::ordersService()->updateStatus($orderId, $status));
});

Flight::route('DELETE /orders/@id', function($id){
    Flight::json(Flight::ordersService()->delete($id));
});