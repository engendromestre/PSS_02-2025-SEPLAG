<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ServidorEfetivo",
 *     title="Servidor Efetivo",
 *     type="object",
 *     @OA\Property(property="pes_id", type="integer", example=1),
 *     @OA\Property(property="se_matricula", type="string", example="20241234")
 * )
 */
class ServidorEfetivoSchema {}