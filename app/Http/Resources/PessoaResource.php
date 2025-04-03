<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\ServidorEfetivoResource;
use App\Http\Resources\ServidorTemporarioResource;


class PessoaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->pes_id,
            'nome' => $this->pes_nome,
            'data_nascimento' => $this->pes_data_nascimento,
            'idade' => $this->calcularIdade(),
            'sexo' => $this->pes_sexo,
            'mae' => $this->pes_mae,
            'pai' => $this->pes_pai,
            'servidores_efetivos' => ServidorEfetivoResource::collection($this->whenLoaded('servidorEfetivo')),
            'servidores_temporarios' => ServidorTemporarioResource::collection($this->whenLoaded('servidorTemporario')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Calculate the age based on the birth date.
     *
     * @return int|null
     */
    protected function calcularIdade()
    {
        if ($this->pes_data_nascimento) {
            return Carbon::parse($this->pes_data_nascimento)->age;
        }
        return null;
    }

    /**
     * Customize the resource collection response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function collection($resource)
    {
        return parent::collection($resource)->additional([
            'meta' => [
                'total' => $resource->total(),
                'per_page' => $resource->perPage(),
                'current_page' => $resource->currentPage(),
                'last_page' => $resource->lastPage(),
            ],
        ]);
    }
}
