<?php

/**
 * @OA\Tag(
 * name="Products",
 * description="CRUD operations for managing tracksuit products"
 * )
 */

// ====================================================================================
// RUTA: GET /products
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/products",
 * tags={"Products"},
 * summary="Get all products",
 * description="Retrieves a list of all products in the store.",
 * @OA\Response(
 * response=200,
 * description="List of products successfully retrieved",
 * @OA\JsonContent(type="array",
 * @OA\Items(
 * @OA\Property(property="id", type="integer", example=10),
 * @OA\Property(property="name", type="string", example="Elite Black Jogger"),
 * @OA\Property(property="price", type="number", format="float", example=89.99),
 * @OA\Property(property="category_id", type="integer", example=2)
 * )
 * )
 * )
 * )
 */

// ====================================================================================
// RUTA: GET /products/@id
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/products/{id}",
 * tags={"Products"},
 * summary="Get product by ID",
 * description="Retrieves a single product by its ID.",
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the product to retrieve",
 * @OA\Schema(type="integer", example=10)
 * ),
 * @OA\Response(
 * response=200,
 * description="Product details successfully retrieved"
 * ),
 * @OA\Response(response=404, description="Product not found")
 * )
 */

// ====================================================================================
// RUTA: GET /products/search/@keyword
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/products/search/{keyword}",
 * tags={"Products"},
 * summary="Search products by name",
 * description="Searches for products whose name contains the specified keyword.",
 * @OA\Parameter(
 * name="keyword",
 * in="path",
 * required=true,
 * description="Keyword to search for in product names",
 * @OA\Schema(type="string", example="Jogger")
 * ),
 * @OA\Response(
 * response=200,
 * description="List of matching products"
 * )
 * )
 */

// ====================================================================================
// RUTA: GET /products/category/@id
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/products/category/{id}",
 * tags={"Products"},
 * summary="Get products by category ID",
 * description="Retrieves all products belonging to a specific category.",
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the category",
 * @OA\Schema(type="integer", example=1)
 * ),
 * @OA\Response(
 * response=200,
 * description="List of products in the category"
 * )
 * )
 */

// ====================================================================================
// RUTA: POST /products
// ====================================================================================

/**
 * @OA\Post(
 * path="/api/products",
 * tags={"Products"},
 * summary="Create a new product",
 * description="Creates and stores a new product entry.",
 * security={{"ApiKey": {}}},
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"name", "price", "category_id"},
 * @OA\Property(property="name", type="string", example="New Exclusive Hoodie"),
 * @OA\Property(property="price", type="number", format="float", example=120.00),
 * @OA\Property(property="category_id", type="integer", example=2),
 * @OA\Property(property="description", type="string", example="High quality cotton blend.")
 * )
 * ),
 * @OA\Response(
 * response=201,
 * description="Product successfully created"
 * ),
 * @OA\Response(response=401, description="Unauthorized")
 * )
 */

// ====================================================================================
// RUTA: PUT /products/@id
// ====================================================================================

/**
 * @OA\Put(
 * path="/api/products/{id}",
 * tags={"Products"},
 * summary="Update an existing product",
 * description="Updates the details of a specific product.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the product to update",
 * @OA\Schema(type="integer", example=10)
 * ),
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * @OA\Property(property="price", type="number", format="float", example=95.00),
 * @OA\Property(property="description", type="string", example="Updated description.")
 * )
 * ),
 * @OA\Response(
 * response=200,
 * description="Product successfully updated"
 * ),
 * @OA\Response(response=404, description="Product not found")
 * )
 */

// ====================================================================================
// RUTA: DELETE /products/@id
// ====================================================================================

/**
 * @OA\Delete(
 * path="/api/products/{id}",
 * tags={"Products"},
 * summary="Delete a product",
 * description="Deletes a product permanently by its ID.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the product to delete",
 * @OA\Schema(type="integer", example=10)
 * ),
 * @OA\Response(
 * response=204,
 * description="Product successfully deleted"
 * ),
 * @OA\Response(response=404, description="Product not found")
 * )
 */

// ====================================================================================
// FLIGHT PHP RUTE
// ====================================================================================

require_once __DIR__ . '/../services/ProductsService.php';

Flight::register('productsService', 'ProductsService');

Flight::route('GET /products', function(){
    Flight::json(Flight::productsService()->getAll());
});

Flight::route('GET /products/@id', function($id){
    Flight::json(Flight::productsService()->getById($id));
});

Flight::route('GET /products/search/@keyword', function($keyword){
    Flight::json(Flight::productsService()->getByName($keyword));
});

Flight::route('GET /products/category/@id', function($id){
    Flight::json(Flight::productsService()->getByCategoryId($id));
});

Flight::route('POST /products', function(){
    Flight::json(
        Flight::productsService()->create(Flight::request()->data->getData())
    );
});

Flight::route('PUT /products/@id', function($id){
    Flight::json(
        Flight::productsService()->update($id, Flight::request()->data->getData())
    );
});

Flight::route('DELETE /products/@id', function($id){
    Flight::json(Flight::productsService()->delete($id));
});