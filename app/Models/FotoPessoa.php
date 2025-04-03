<?php

namespace App\Models;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Model;

class FotoPessoa extends Model
{
    /**
     * Get the pessoa that owns the foto pessoa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property int $pes_id The ID of the pessoa in the Pessoa table.
     *
     * @see \App\Models\Pessoa
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id');
    }
}
