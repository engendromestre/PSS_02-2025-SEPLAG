<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ServidorTemporario",
 *     title="Servidor Temporário",
 *     type="object",
 *     @OA\Property(property="pes_id", type="integer", example=1),
 *     @OA\Property(property="st_data_admissao", type="string", format="date", example="2023-05-01"),
 *     @OA\Property(property="st_data_demissao", type="string", format="date", example="2024-04-01")
 * )
 */
class ServidorTemporarioSchema {}