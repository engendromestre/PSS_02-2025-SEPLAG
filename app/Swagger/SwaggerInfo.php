<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Documentação da API",
 *     description="API desenvolvida com Laravel Sanctum e documentada via Swagger"
 * )
 *
 * @OA\Server(
 *     url="/",
 *     description="Ambiente local"
 * )
 */
class SwaggerInfo {}
