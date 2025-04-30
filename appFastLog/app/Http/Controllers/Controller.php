<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="FastLog API",
 *         description="API para gerenciamento de entregas via API REST",
 *         @OA\Contact(
 *             email="admin@fastlog.com"
 *         )
 *     ),
 *     @OA\Server(
 *         description="API FastLog",
 *         url=L5_SWAGGER_CONST_HOST
 *     )
 * )
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */
class Controller extends BaseController
{
    //
}
