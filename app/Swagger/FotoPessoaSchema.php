<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="FotoPessoa",
 *     type="object",
 *     title="FotoPessoa",
 *     required={"id", "pes_id", "url", "url_temporaria"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="pes_id", type="integer", example=12),
 *     @OA\Property(property="url", type="string", format="uri", example="https://minio.local/fotos_pessoas/12/foto1.jpg"),
 *     @OA\Property(property="url_temporaria", type="string", format="uri", example="http://localhost:9000/fotos_pessoas/12/foto1.jpg?X-Amz-Expires=600&X-Amz-Signature=abc123..."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-10T14:48:00.000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-10T14:50:00.000Z")
 * )
 */
class FotoPessoaSchema {}