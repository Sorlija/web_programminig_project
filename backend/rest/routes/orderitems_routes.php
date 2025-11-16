<?php

/**
 * @OA\Tag(
 * name="Order Items",
 * description="Management of individual items within an order"
 * )
 */

// ====================================================================================
// RUTA: GET /orderitems/order/@orderId
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/orderitems/order/{orderId}",
 * tags={"Order Items"},
 * summary="Get items for a specific order",
 * description="Retrieves all products, quantities, and prices associated with a given order ID.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="orderId",
 * in="path",
 * required=true,
 * description="ID of the order whose items are being retrieved",
 * @OA\Schema(type="integer", example=15)
 * ),
 * @OA\Response(
 * response=200,
 * description="List of order items successfully retrieved",
 * @OA\JsonContent(type="array",
 * @OA\Items(
 * @OA\Property(property="product_id", type="integer", example=10),
 * @OA\Property(property="quantity", type="integer", example=1),
 * @OA\Property(property="price_at_purchase", type="number", format="float", example=55.00)
 * )
 * )
 * ),
 * @OA\Response(response=404, description="Order not found")
 * )
 */

// ====================================================================================
// RUTA: POST /orderitems
// ====================================================================================

/**
 * @OA\Post(
 * path="/api/orderitems",
 * tags={"Order Items"},
 * summary="Add a single item to an order",
 * description="Adds a product item to an existing order (typically used internally during checkout).",
 * security={{"ApiKey": {}}},
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"orderId", "productId", "quantity", "price"},
 * @OA\Property(property="orderId", type="integer", example=15),
 * @OA\Property(property="productId", type="integer", example=10),
 * @OA\Property(property="quantity", type="integer", example=2),
 * @OA\Property(property="price", type="number", format="float", example=55.00)
 * )
 * ),
 * @OA\Response(
 * response=201,
 * description="Item successfully added to order"
 * ),
 * @OA\Response(response=400, description="Invalid input")
 * )
 */

// ====================================================================================
// RUTA: DELETE /orderitems/order/@orderId
// ====================================================================================

/**
 * @OA\Delete(
 * path="/api/orderitems/order/{orderId}",
 * tags={"Order Items"},
 * summary="Delete all items for an order",
 * description="Removes all associated order items for a given order ID (e.g., if the order is cancelled).",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="orderId",
 * in="path",
 * required=true,
 * description="ID of the order whose items should be deleted",
 * @OA\Schema(type="integer", example=15)
 * ),
 * @OA\Response(
 * response=204,
 * description="Order items successfully deleted"
 * ),
 * @OA\Response(response=404, description="Order not found")
 * )
 */

// ====================================================================================
// FLIGHT PHP RUTE
// ====================================================================================

require_once __DIR__ . '/../services/OrderItemsService.php';

Flight::register('orderItemsService', 'OrderItemsService');

Flight::route('GET /orderitems/order/@orderId', function($orderId){
    Flight::json(Flight::orderItemsService()->getByOrderId($orderId));
});

Flight::route('POST /orderitems', function(){
    $d = Flight::request()->data->getData();
    Flight::json(
        Flight::orderItemsService()->addItem(
            $d['orderId'], $d['productId'], $d['quantity'], $d['price']
        )
    );
});

Flight::route('DELETE /orderitems/order/@orderId', function($orderId){
    Flight::json(Flight::orderItemsService()->deleteByOrderId($orderId));
});