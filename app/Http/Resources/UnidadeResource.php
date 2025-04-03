<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnidadeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'unid_nome' => $this->pes_id,
            'unid_sigla' => $this->pes_nome,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
