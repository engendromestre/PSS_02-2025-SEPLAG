<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FotoPessoaResource extends JsonResource
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
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->fp_id,
            'pessoa' => $this->pes_id,
            'fp_data' => $this->fp_data,
            'url_temporaria' => $this->gerarUrlTemporaria(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    protected function gerarUrlTemporaria(): string
    {
        return $this->resource->gerarUrlTemporaria($this->expiracaoMinutos);
    }
}
