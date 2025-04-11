<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Pessoa",
 *     title="Pessoa",
 *     type="object",
 *     @OA\Property(property="pes_id", type="integer", example=1),
 *     @OA\Property(property="pes_nome", type="string", example="Ana Maria"),
 *     @OA\Property(property="pes_data_nascimento", type="string", format="date", example="1986-02-08"),
 *     @OA\Property(property="idade", type="integer", example=39),
 *     @OA\Property(property="pes_sexo", type="string", example="Feminino"),
 *     @OA\Property(property="pes_mae", type="string", example="Mãe da Ana Maria"),
 *     @OA\Property(property="pes_pai", type="string", example="Pai da Ana Maria"),
 *     
 *     @OA\Property(
 *         property="fotos",
 *         type="array",
 *         @OA\Items(type="object")
 *     ),
 *     
 *     @OA\Property(
 *         property="servidores_efetivos",
 *         type="array",
 *         @OA\Items(type="object")
 *     ),
 *     
 *     @OA\Property(
 *         property="servidores_temporarios",
 *         type="array",
 *         @OA\Items(type="object")
 *     )
 * )
 */
class PessoaSchema {}