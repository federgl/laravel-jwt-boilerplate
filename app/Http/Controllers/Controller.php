<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel JWT Authentication Core Structure",
 *     description="Description for base laravel project with JWT auth included.",
 *     @OA\Contact(
 *         email="federico.reale@globant.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Swagger OpenApi dynamic host server"
 * )
 *
 * @OA\Server(
 *     url="http://laravel.local.com:8080",
 *     description="Laravel base project / Swagger OpenApi Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Use of access+refresh token generated based on username/password & server side encryption key",
 *     name="Token Based",
 *     in="header",
 * )
 *
 * @OA\Tag(
 *     name="Security",
 *     description="Authorization endpoints",
 * )
 *
 *
 * @OA\ExternalDocumentation(
 *     description="Find out more about Swagger",
 *     url="http://swagger.io"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use Helpers;
}
