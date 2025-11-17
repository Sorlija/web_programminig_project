<?php

/**
 * @OA\Tag(
 * name="Cart",
 * description="Operations related to the shopping cart for a specific user"
 * )
 */

// ====================================================================================
// RUTA: GET /cart/@userId
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/cart/{userId}",
 * tags={"Cart"},
 * summary="Get the content of the shopping cart",
 * description="Retrieves all items in the current user's shopping cart.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="userId",
 * in="path",
 * required=true,
 * description="ID of the user whose cart is being retrieved",
 * @OA\Schema(type="integer", example=1)
 * ),
 * @OA\Response(
 * response=200,
 * description="Cart content successfully retrieved",
 * @OA\JsonContent(type="array",
 * @OA\Items(
 * @OA\Property(property="product_id", type="integer", example=10),
 * @OA\Property(property="name", type="string", example="Elite Hoodie"),
 * @OA\Property(property="quantity", type="integer", example=2),
 * @OA\Property(property="price", type="number", format="float", example=55.00)
 * )
 * )
 * ),
 * @OA\Response(response=401, description="Unauthorized")
 * )
 */

// ====================================================================================
// RUTA: POST /cart/add
// ====================================================================================

/**
 * @OA\Post(
 * path="/api/cart/add",
 * tags={"Cart"},
 * summary="Add item to shopping cart",
 * description="Adds a specified product and quantity to the user's active shopping cart.",
 * security={{"ApiKey": {}}},
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"userId", "productId", "quantity"},
 * @OA\Property(property="userId", type="integer", example=1),
 * @OA\Property(property="productId", type="integer", example=10),
 * @OA\Property(property="quantity", type="integer", example=1)
 * )
 * ),
 * @OA\Response(response=200, description="Item successfully added to cart"),
 * @OA\Response(response=404, description="Product or User not found")
 * )
 */

// ====================================================================================
// RUTA: PUT /cart/update
// ====================================================================================

/**
 * @OA\Put(
 * path="/api/cart/update",
 * tags={"Cart"},
 * summary="Update item quantity in cart",
 * description="Updates the quantity of a specific product for a specific user in the shopping cart.",
 * security={{"ApiKey": {}}},
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"userId", "productId", "quantity"},
 * @OA\Property(property="userId", type="integer", example=1),
 * @OA\Property(property="productId", type="integer", example=10),
 * @OA\Property(property="quantity", type="integer", example=5)
 * )
 * ),
 * @OA\Response(response=200, description="Quantity successfully updated"),
 * @OA\Response(response=404, description="Item not in cart")
 * )
 */

// ====================================================================================
// RUTA: DELETE /cart/remove
// ====================================================================================

/**
 * @OA\Delete(
 * path="/api/cart/remove",
 * tags={"Cart"},
 * summary="Remove item from cart",
 * description="Removes a specific product from the shopping cart for a specific user.",
 * security={{"ApiKey": {}}},
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"userId", "productId"},
 * @OA\Property(property="userId", type="integer", example=1),
 * @OA\Property(property="productId", type="integer", example=10)
 * )
 * ),
 * @OA\Response(response=204, description="Item successfully removed"),
 * @OA\Response(response=404, description="Item not in cart")
 * )
 */

// ====================================================================================
// RUTA: DELETE /cart/clear/@userId
// ====================================================================================

/**
 * @OA\Delete(
 * path="/api/cart/clear/{userId}",
 * tags={"Cart"},
 * summary="Clear the entire shopping cart",
 * description="Removes all items from the shopping cart for a specific user.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="userId",
 * in="path",
 * required=true,
 * description="ID of the user whose cart should be cleared",
 * @OA\Schema(type="integer", example=1)
 * ),
 * @OA\Response(response=204, description="Cart successfully cleared"),
 * @OA\Response(response=404, description="User not found")
 * )
 */

// ====================================================================================
// RUTA: GET /cart/total/@userId
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/cart/total/{userId}",
 * tags={"Cart"},
 * summary="Get cart total amount",
 * description="Retrieves the total price of all items in the user's cart.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="userId",
 * in="path",
 * required=true,
 * description="ID of the user whose cart total is requested",
 * @OA\Schema(type="integer", example=1)
 * ),
 * @OA\Response(
 * response=200,
 * description="Total amount retrieved",
 * @OA\JsonContent(
 * @OA\Property(property="total", type="number", format="float", example=110.00)
 * )
 * ),
 * @OA\Response(response=401, description="Unauthorized")
 * )
 */

// =s===================================================================================
// FLIGHT PHP RUTE
// ====================================================================================

require_once __DIR__ . '/../services/CartService.php';

Flight::register('cartService', 'CartService');

Flight::route('GET /cart/@userId', function($userId){
    Flight::json(Flight::cartService()->getCartByUserId($userId));
});

Flight::route('POST /cart/add', function(){
    $d = Flight::request()->data->getData();
    Flight::json(Flight::cartService()->addItem($d['userId'], $d['productId'], $d['quantity']));
});

Flight::route('PUT /cart/update', function(){
    $d = Flight::request()->data->getData();
    Flight::json(Flight::cartService()->updateQuantity($d['userId'], $d['productId'], $d['quantity']));
});

Flight::route('DELETE /cart/remove', function(){
    $d = Flight::request()->data->getData();
    Flight::json(Flight::cartService()->removeItem($d['userId'], $d['productId']));
});

Flight::route('DELETE /cart/clear/@userId', function($userId){
    Flight::json(Flight::cartService()->clearCart($userId));
});

Flight::route('GET /cart/total/@userId', function($userId){
    Flight::json(['total' => Flight::cartService()->getTotal($userId)]);
});