<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Unidade",
 *     title="Unidade",
 *     type="object",
 *     @OA\Property(property="unid_id", type="integer", example=1),
 *     @OA\Property(property="unid_nome", type="string", example="Secretaria da Educação"),
 *     @OA\Property(property="unid_sigla", type="string", example="SED"),
 *     @OA\Property(
 *         property="enderecos",
 *         type="array",
 *         @OA\Items(type="object")
 *     ),
 *     @OA\Property(
 *         property="lotacoes",
 *         type="array",
 *         @OA\Items(type="object")
 *     )
 * )
 */
class UnidadeSchema {}