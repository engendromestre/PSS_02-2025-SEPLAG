<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="FotoPessoa",
 *     title="Foto da Pessoa",
 *     type="object",
 *     @OA\Property(property="fp_id", type="integer", example=1),
 *     @OA\Property(property="pes_id", type="integer", example=1),
 *     @OA\Property(property="fp_data", type="string", format="date", example="2024-01-15"),
 *     @OA\Property(property="fp_bucket", type="string", example="bucket-exemplo"),
 *     @OA\Property(property="fp_hash", type="string", example="hash_exemplo_123456")
 * )
 */
class FotoPessoaSchema {}