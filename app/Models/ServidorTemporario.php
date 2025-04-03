<?php

namespace App\Models;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Model;

class ServidorTemporario extends Model
{
    protected $table = 'servidores_temporarios';
    protected $fillable = ['pes_id', 'st_data_admissao', 'st_data_demissao'];


    /**
     * Get the pessoa record associated with the servidor temporario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property int $pes_id The unique identifier of the pessoa record.
     *
     * @see \App\Models\Pessoa
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id');
    }
}
