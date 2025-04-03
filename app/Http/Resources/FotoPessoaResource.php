<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FotoPessoaResource extends JsonResource
{
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
            'fp_bucket' => $this->fp_bucket,
            'fp_hash' => $this->fp_hash,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
