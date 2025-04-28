<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Documentação da API",
 *     description="API desenvolvida com Laravel Sanctum e documentada via Swagger",
 *     @OA\Contact(
 *         email="suporte@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Ambiente local"
 * )
 * 
 * @OA\Tag(
 *     name="Autenticação",
 *     description="Endpoints para gerenciamento de autenticação"
 * )
 */
class SwaggerInfo {}