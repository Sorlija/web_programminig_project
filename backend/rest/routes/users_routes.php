<?php

/**
 * @OA\Tag(
 * name="Users",
 * description="CRUD and retrieval operations for user accounts"
 * )
 */

// ====================================================================================
// RUTA: GET /users
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/users",
 * tags={"Users"},
 * summary="Get all users",
 * description="Retrieves a list of all user accounts (Admin access only).",
 * security={{"ApiKey": {}}},
 * @OA\Response(
 * response=200,
 * description="List of users successfully retrieved",
 * @OA\JsonContent(type="array",
 * @OA\Items(
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="email", type="string", example="ajla.s@mail.com"),
 * @OA\Property(property="name", type="string", example="Ajla Sorlija"),
 * @OA\Property(property="role", type="string", example="customer")
 * )
 * )
 * ),
 * @OA\Response(response=401, description="Unauthorized or insufficient privileges")
 * )
 */

// ====================================================================================
// RUTA: GET /users/@id
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/users/{id}",
 * tags={"Users"},
 * summary="Get user by ID",
 * description="Retrieves a single user account by their ID.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the user to retrieve",
 * @OA\Schema(type="integer", example=1)
 * ),
 * @OA\Response(
 * response=200,
 * description="User details successfully retrieved"
 * ),
 * @OA\Response(response=404, description="User not found")
 * )
 */

// ====================================================================================
// RUTA: GET /users/email/@email
// ====================================================================================

/**
 * @OA\Get(
 * path="/api/users/email/{email}",
 * tags={"Users"},
 * summary="Get user by email address",
 * description="Retrieves a single user account by their email address.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="email",
 * in="path",
 * required=true,
 * description="Email address of the user to retrieve",
 * @OA\Schema(type="string", format="email", example="ajla.s@mail.com")
 * ),
 * @OA\Response(
 * response=200,
 * description="User details successfully retrieved"
 * ),
 * @OA\Response(response=404, description="User not found")
 * )
 */

// ====================================================================================
// RUTA: POST /users (Registration)
// ====================================================================================

/**
 * @OA\Post(
 * path="/api/users",
 * tags={"Users"},
 * summary="Register a new user",
 * description="Registers a new user account (defaults role to 'customer').",
 * @OA\RequestBody(
 * required=true,
 * description="User registration data",
 * @OA\JsonContent(
 * required={"name", "email", "password"},
 * @OA\Property(property="name", type="string", example="Novi Korisnik"),
 * @OA\Property(property="email", type="string", format="email", example="new.user@example.com"),
 * @OA\Property(property="password", type="string", format="password", example="SecurePass123"),
 * @OA\Property(property="role", type="string", example="customer", enum={"customer", "admin"})
 * )
 * ),
 * @OA\Response(
 * response=201,
 * description="User successfully registered"
 * ),
 * @OA\Response(response=400, description="Email already in use or invalid input")
 * )
 */

// ====================================================================================
// RUTA: PUT /users/@id
// ====================================================================================

/**
 * @OA\Put(
 * path="/api/users/{id}",
 * tags={"Users"},
 * summary="Update user account",
 * description="Updates details for a specific user account.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the user to update",
 * @OA\Schema(type="integer", example=1)
 * ),
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * @OA\Property(property="name", type="string", example="Ajla N."),
 * @OA\Property(property="email", type="string", format="email", example="ajla.novi@mail.com"),
 * @OA\Property(property="role", type="string", example="customer", enum={"customer", "admin"})
 * )
 * ),
 * @OA\Response(
 * response=200,
 * description="User successfully updated"
 * ),
 * @OA\Response(response=404, description="User not found")
 * )
 */

// ====================================================================================
// RUTA: DELETE /users/@id
// ====================================================================================

/**
 * @OA\Delete(
 * path="/api/users/{id}",
 * tags={"Users"},
 * summary="Delete user account",
 * description="Deletes a user account permanently by ID.",
 * security={{"ApiKey": {}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID of the user to delete",
 * @OA\Schema(type="integer", example=1)
 * ),
 * @OA\Response(
 * response=204,
 * description="User successfully deleted"
 * ),
 * @OA\Response(response=404, description="User not found")
 * )
 */

// ====================================================================================
// FLIGHT PHP RUTE
// ====================================================================================

require_once __DIR__ . '/../services/UsersService.php';

Flight::register('usersService', 'UsersService');

Flight::route('GET /users', function(){
    Flight::json(Flight::usersService()->getAll());
});

Flight::route('GET /users/@id', function($id){
    Flight::json(Flight::usersService()->getById($id));
});

Flight::route('GET /users/email/@email', function($email){
    Flight::json(Flight::usersService()->getByEmail($email));
});

Flight::route('POST /users', function(){
    $d = Flight::request()->data->getData();
    Flight::json(
        Flight::usersService()->createUser($d['name'], $d['email'], $d['password'], $d['role'] ?? 'customer')
    );
});

Flight::route('PUT /users/@id', function($id){
    Flight::json(Flight::usersService()->updateUser($id, Flight::request()->data->getData()));
});

Flight::route('DELETE /users/@id', function($id){
    Flight::json(Flight::usersService()->deleteUser($id));
});