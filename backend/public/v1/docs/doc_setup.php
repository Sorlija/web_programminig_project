<?php

/**
 * @OA\Info(
 * title="Tracksuit Couture API",
 * description="REST API for managing products, orders, and users of the Tracksuit Couture Online Shop.",
 * version="1.0.0",
 * @OA\Contact(
 * email="support@tracksuitcouture.com",
 * name="Tracksuit Couture Support"
 * ),
 * @OA\License(
 * name="Apache 2.0",
 * url="http://www.apache.org/licenses/LICENSE-2.0.html"
 * )
 * ),
 *
 * @OA\Server(
 * url="https://api.tracksuitcouture.dev/v1",
 * description="Development/Staging Server"
 * ),
 * @OA\Server(
 * url="https://api.tracksuitcouture.com/v1",
 * description="Production (Live) Server"
 * ),
 *
 * @OA\SecurityScheme(
 * securityScheme="ApiKey",
 * type="apiKey",
 * in="header",
 * name="Authentication"
 * )
 */