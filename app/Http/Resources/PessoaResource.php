<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\FotoPessoaResource;
use App\Http\Resources\ServidorEfetivoResource;
use App\Http\Resources\ServidorTemporarioResource;


class PessoaResource extends JsonResource
{
    protected int $expiracaoMinutos = 10;

    public function setExpiracao(int $minutos): self
    {
        $this->expiracaoMinutos = $minutos;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'pes_id' => $this->pes_id,
            'pes_nome' => $this->pes_nome,
            'pes_data_nascimento' => $this->pes_data_nascimento
                ? Carbon::parse($this->pes_data_nascimento)->format('d/m/Y')
                : null,
            'idade' => $this->calcularIdade(),
            'pes_sexo' => $this->pes_sexo,
            'pes_mae' => $this->pes_mae,
            'pes_pai' => $this->pes_pai,
            'fotos' => FotoPessoaResource::collection(
                $this->whenLoaded('fotos', function () {
                    return $this->fotos->map(function ($foto) {
                        return (new FotoPessoaResource($foto))->setExpiracao($this->expiracaoMinutos);
                    });
                })
            ),
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
        $collection = parent::collection($resource);

        if (method_exists($resource, 'total')) {
            $collection->additional([
                'meta' => [
                    'total' => $resource->total(),
                    'per_page' => $resource->perPage(),
                    'current_page' => $resource->currentPage(),
                    'last_page' => $resource->lastPage(),
                ],
            ]);
        }

        return $collection;
    }
}
